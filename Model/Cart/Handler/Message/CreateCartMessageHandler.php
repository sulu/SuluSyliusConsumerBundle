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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Cart\Handler\Message;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\CartGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Cart\Message\CreateCartMessage;

class CreateCartMessageHandler
{
    /**
     * @var CartGatewayInterface
     */
    private $cartGateway;

    /**
     * @var string
     */
    private $defaultChannel;

    public function __construct(CartGatewayInterface $cartGateway, string $defaultChannel)
    {
        $this->cartGateway = $cartGateway;
        $this->defaultChannel = $defaultChannel;
    }

    public function __invoke(CreateCartMessage $message): array
    {
        $syliusUser = $message->getSyliusUser();
        if (!$syliusUser) {
            // TODO: Anonymous Cart
            throw new \Exception('not implemented');
        }

        $createdCart = $this->cartGateway->create(
            $syliusUser->getEmail(),
            $message->getChannel() ?: $this->defaultChannel,
            $message->getLocale()
        );

        return $createdCart;
    }
}
