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

namespace Sulu\Bundle\SyliusConsumerBundle\Model;

use Webmozart\Assert\Assert;

trait PayloadTrait
{
    /**
     * @var array
     */
    protected $payload;

    protected function initializePayload(array $payload = [])
    {
        $this->payload = $payload;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    protected function getValueWithDefault(string $name, $default = null)
    {
        if (!array_key_exists($name, $this->payload)) {
            return $default;
        }

        return $this->payload[$name];
    }

    protected function getBoolValue(string $name): bool
    {
        $value = $this->getValue($name);

        Assert::boolean($value);

        return $value;
    }

    protected function getBoolValueWithDefault(string $name, bool $default = false): bool
    {
        $value = $this->getValueWithDefault($name, $default);

        Assert::boolean($value);

        return $value;
    }

    protected function getStringValue(string $name): string
    {
        $value = $this->getValue($name);

        Assert::string($value);

        return $value;
    }

    protected function getStringValueWithDefault(string $name, string $default = ''): string
    {
        $value = $this->getValueWithDefault($name, $default);
        if (null === $value) {
            return $default;
        }

        Assert::string($value);

        return $value;
    }

    protected function getFloatValue(string $name): float
    {
        $value = $this->getValue($name);

        if (is_int($value)) {
            $value = (float) $value;
        }

        Assert::float($value);

        return $value;
    }

    protected function getFloatValueWithDefault(string $name, float $default = 0.0): float
    {
        $value = $this->getValueWithDefault($name, $default);

        Assert::float($value);

        return $value;
    }

    protected function getIntValue(string $name): int
    {
        $value = $this->getValue($name);

        Assert::integer($value);

        return $value;
    }

    protected function getIntValueWithDefault(string $name, int $default = 0): int
    {
        $value = $this->getValueWithDefault($name, $default);

        Assert::integer($value);

        return $value;
    }

    protected function getArrayValue(string $name): array
    {
        $value = $this->getValue($name);

        Assert::isArray($value);

        return $value;
    }

    protected function getArrayValueWithDefault(string $name, array $default = []): array
    {
        $value = $this->getValueWithDefault($name, $default);

        Assert::isArray($value);

        return $value;
    }

    private function getValue(string $name)
    {
        Assert::keyExists($this->payload, $name);

        return $this->payload[$name];
    }
}
