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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Address\Message;

use Sulu\Bundle\SyliusConsumerBundle\Model\Address\AddressInterface;

class ModifyAddressMessage
{
    /**
     * @var AddressInterface
     */
    private $address;

    public function __construct(AddressInterface $address)
    {
        $this->address = $address;
    }

    public function getAddress(): AddressInterface
    {
        return $this->address;
    }
}
