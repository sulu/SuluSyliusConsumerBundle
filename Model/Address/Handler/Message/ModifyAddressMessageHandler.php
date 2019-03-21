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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Address\Handler\Message;

use Sulu\Bundle\SyliusConsumerBundle\Gateway\AddressGatewayInterface;
use Sulu\Bundle\SyliusConsumerBundle\Model\Address\Message\ModifyAddressMessage;

class ModifyAddressMessageHandler
{
    /**
     * @var AddressGatewayInterface
     */
    private $addressGateway;

    public function __construct(AddressGatewayInterface $addressGateway)
    {
        $this->addressGateway = $addressGateway;
    }

    public function __invoke(ModifyAddressMessage $message): void
    {
        $this->addressGateway->update($message->getAddress());
    }
}
