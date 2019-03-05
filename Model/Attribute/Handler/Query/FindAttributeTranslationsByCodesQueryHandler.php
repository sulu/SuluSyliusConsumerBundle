<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Attribute\Handler\Query;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\ProductAttributeGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Attribute\Query\FindAttributeTranslationsByCodesQuery;

class FindAttributeTranslationsByCodesQueryHandler
{
    /**
     * @var ProductAttributeGatewayInterface
     */
    private $attributeGateway;

    public function __construct(ProductAttributeGatewayInterface $attributeGateway)
    {
        $this->attributeGateway = $attributeGateway;
    }

    public function __invoke(FindAttributeTranslationsByCodesQuery $message): void
    {
        $result = [];
        foreach ($this->attributeGateway->findByCodes($message->getCodes()) as $attributeData) {
            if (!array_key_exists($message->getLocale(), $attributeData['translations'])) {
                continue;
            }

            $result[$attributeData['code']] = $attributeData['translations'][$message->getLocale()]['name'];
        }

        $message->setProductAttributeTranslations($result);
    }
}
