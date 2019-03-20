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

namespace Sulu\Bundle\SyliusConsumerBundle\Model\Address;

class Address implements AddressInterface
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $postcode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string|null
     */
    private $provinceCode;

    /**
     * @var string|null
     */
    private $phoneNumber;

    public function __construct(
        string $firstName,
        string $lastName,
        string $street,
        string $postcode,
        string $city,
        string $countryCode,
        ?string $provinceCode = null,
        ?string $phoneNumber = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->street = $street;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->countryCode = $countryCode;
        $this->provinceCode = $provinceCode;
        $this->phoneNumber = $phoneNumber;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getProvinceCode(): ?string
    {
        return $this->provinceCode;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function toArray(): array
    {
        $data = [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'street' => $this->street,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'countryCode' => $this->countryCode,
        ];

        if ($this->provinceCode) {
            $data['provinceCode'] = $this->provinceCode;
        }

        if ($this->phoneNumber) {
            $data['phoneNumber'] = $this->phoneNumber;
        }

        return $data;
    }
}
