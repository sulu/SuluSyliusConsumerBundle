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

use Sulu\Bundle\SyliusConsumerBundle\Adapter\ImageMediaAdapter;
use Sulu\Bundle\SyliusConsumerBundle\Adapter\ProductAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ProductPayload;
use Sulu\Bundle\SyliusConsumerBundle\Repository\ImageMediaBridgeRepositoryInterface;
use Sulu\Bundle\SyliusConsumerBundle\Repository\TaxonCategoryBridgeRepositoryInterface;
use Sulu\Product\Domain\Model\ProductInterface;

class SuluProductAdapter implements ProductAdapterInterface
{
    public function __construct(
        private readonly SuluProductWriter $writer,
        private readonly ?ImageMediaAdapter $imageAdapter,
        private readonly ImageMediaBridgeRepositoryInterface $imageBridges,
        private readonly TaxonCategoryBridgeRepositoryInterface $taxonBridges,
        private readonly string $urlPrefix,
    ) {
    }

    public function synchronize(ProductPayload $payload): void
    {
        $contents = [];
        foreach ($payload->getTranslations() as $translation) {
            $contents[$translation->getLocale()] = new ProductContent(
                $translation->getName(),
                $this->urlPrefix . $translation->getSlug(),
                $translation->getShortDescription(),
                $translation->getDescription(),
            );
        }

        $this->writer->upsert(
            $payload->getCode(),
            $payload->isSimple() ? ProductInterface::TYPE_PRODUCT : ProductInterface::TYPE_PRODUCT_WITH_VARIANTS,
            $contents,
            publish: $payload->isEnabled(),
            categoryIds: $this->getCategoryIds($payload),
            mediaIds: $this->getMediaIds($payload),
        );
    }

    public function remove(string $code): void
    {
        $this->writer->remove($code);
    }

    /**
     * @return int[]
     */
    private function getCategoryIds(ProductPayload $payload): array
    {
        $ids = [];
        foreach ($payload->getTaxonIds() as $taxonId) {
            $bridge = $this->taxonBridges->findById($taxonId);
            if (null !== $bridge) {
                $ids[] = $bridge->getCategory()->getId();
            }
        }

        return $ids;
    }

    /**
     * @return int[]
     */
    private function getMediaIds(ProductPayload $payload): array
    {
        $ids = [];
        if (null === $this->imageAdapter) {
            return $ids;
        }

        foreach ($payload->getImages() as $image) {
            $this->imageAdapter->synchronize(new ImagePayload($image['id'], 'en', $image));
            $bridge = $this->imageBridges->findById($image['id']);
            if (null !== $bridge) {
                $ids[] = $bridge->getMedia()->getId();
            }
        }

        return $ids;
    }
}
