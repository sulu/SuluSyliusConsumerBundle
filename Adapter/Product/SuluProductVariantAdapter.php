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

use Sulu\Bundle\SyliusConsumerBundle\Adapter\ProductVariantAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ProductVariantPayload;
use Sulu\Product\Domain\Model\ProductInterface;
use Sulu\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException;
use Symfony\Component\String\Slugger\AsciiSlugger;

class SuluProductVariantAdapter implements ProductVariantAdapterInterface
{
    public function __construct(
        private readonly SuluProductWriter $writer,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly string $urlPrefix,
    ) {
    }

    public function synchronize(ProductVariantPayload $payload): void
    {
        $parentUuid = $this->writer->findUuid($payload->getProductCode());
        if (null === $parentUuid) {
            throw new RecoverableMessageHandlingException(\sprintf('Parent product "%s" is not synchronized yet.', $payload->getProductCode()));
        }

        $parent = $this->productRepository->getOneBy(['uuid' => $parentUuid]);
        if (ProductInterface::TYPE_PRODUCT_WITH_VARIANTS !== $parent->getType()) {
            // the single variant of a simple Sylius product is the product itself
            return;
        }

        $url = $this->urlPrefix . (new AsciiSlugger())->slug($payload->getCode())->lower()->toString();
        $contents = [];
        foreach ($payload->getTranslations() as $translation) {
            $contents[$translation->getLocale()] = new ProductContent($translation->getName(), $url);
        }

        $this->writer->upsert($payload->getCode(), ProductInterface::TYPE_VARIANT, $contents, $parentUuid);
    }

    public function remove(string $code): void
    {
        $this->writer->remove($code);
    }
}
