<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Adapter\Product;

use Sulu\Messenger\Infrastructure\Symfony\Messenger\FlushMiddleware\EnableFlushStamp;
use Sulu\Product\Application\Message\ApplyWorkflowTransitionProductMessage;
use Sulu\Product\Application\Message\CreateProductFamilyMessage;
use Sulu\Product\Application\Message\CreateProductMessage;
use Sulu\Product\Application\Message\ModifyProductMessage;
use Sulu\Product\Application\Message\RemoveProductMessage;
use Sulu\Product\Domain\Model\ProductFamilyInterface;
use Sulu\Product\Domain\Model\ProductInterface;
use Sulu\Product\Domain\Repository\ProductFamilyRepositoryInterface;
use Sulu\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Writes Sylius data into sulu/product-bundle through its own messages, so every
 * mapper, route generator and event of the bundle runs as it does for the admin.
 */
class SuluProductWriter
{
    /**
     * @param string[] $locales Sulu languages to synchronize, the first one is the default.
     *                          Sylius locales carry a country, so only the language part is compared.
     */
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ProductFamilyRepositoryInterface $productFamilyRepository,
        private readonly array $locales,
        private readonly string $familyKey,
        private readonly string $template,
    ) {
    }

    /**
     * @param array<string, ProductContent> $contentByLocale Sylius locale => content
     * @param int[] $categoryIds
     * @param int[] $mediaIds
     */
    public function upsert(
        string $code,
        string $type,
        array $contentByLocale,
        ?string $parentUuid = null,
        bool $publish = true,
        array $categoryIds = [],
        array $mediaIds = [],
    ): string {
        $contents = $this->toSuluLocales($contentByLocale);
        if ([] === $contents) {
            throw new \RuntimeException(\sprintf('Product "%s" has no translation for %s.', $code, \implode(', ', $this->locales)));
        }

        $uuid = $this->findUuid($code);

        foreach ($contents as $locale => $content) {
            $data = [
                'locale' => $locale,
                'title' => $content->title,
                'code' => $code,
                'type' => $type,
                'externalIdentifier' => $code,
                'url' => $content->url,
                'shortDescription' => $content->shortDescription,
                'description' => $content->description,
                'excerptCategories' => $categoryIds,
                'excerpt' => ['images' => ['ids' => $mediaIds]],
            ];
            if (null !== $parentUuid) {
                $data['parent'] = $parentUuid;
            }

            if (null === $uuid) {
                $product = $this->dispatch(new CreateProductMessage($data + [
                    'productFamily' => $this->getFamilyUuid(),
                    'template' => $this->template,
                    'attributes' => [],
                ]));
                \assert($product instanceof ProductInterface);
                $uuid = $product->getUuid();
            } else {
                $this->dispatch(new ModifyProductMessage(['uuid' => $uuid], $data));
            }

            if ($publish) {
                $this->dispatch(new ApplyWorkflowTransitionProductMessage(['uuid' => $uuid], $locale, 'publish'));
            }
        }

        return $uuid;
    }

    public function findUuid(string $code): ?string
    {
        return $this->productRepository->findOneBy([
            'code' => $code,
            'locale' => $this->locales[0],
            'stage' => 'draft',
            'load_ghost_content' => true,
        ])?->getUuid();
    }

    public function remove(string $code): void
    {
        $uuid = $this->findUuid($code);
        if (null === $uuid) {
            return;
        }

        $this->dispatch(new RemoveProductMessage(['uuid' => $uuid], $this->locales[0]));
    }

    private function getFamilyUuid(): string
    {
        $family = $this->productFamilyRepository->findOneBy(['key' => $this->familyKey]);
        if (null !== $family) {
            return $family->getUuid();
        }

        $family = $this->dispatch(new CreateProductFamilyMessage([
            'locale' => $this->locales[0],
            'key' => $this->familyKey,
            'name' => 'Sylius',
            'attributes' => [],
        ]));
        \assert($family instanceof ProductFamilyInterface);

        return $family->getUuid();
    }

    /**
     * @param array<string, ProductContent> $contentByLocale
     *
     * @return array<string, ProductContent>
     */
    private function toSuluLocales(array $contentByLocale): array
    {
        $result = [];
        foreach ($contentByLocale as $syliusLocale => $content) {
            $language = \strtolower(\explode('_', $syliusLocale)[0]);
            if (\in_array($language, $this->locales, true) && !isset($result[$language])) {
                $result[$language] = $content;
            }
        }

        return $result;
    }

    private function dispatch(object $message): mixed
    {
        $envelope = $this->messageBus->dispatch(new Envelope($message, [new EnableFlushStamp()]));

        return $envelope->last(HandledStamp::class)?->getResult();
    }
}
