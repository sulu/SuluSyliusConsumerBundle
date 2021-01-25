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

namespace Sulu\Bundle\SyliusConsumerBundle\Common;

use Webmozart\Assert\Assert;

trait PayloadTrait
{
    /**
     * @var mixed[]
     */
    protected $payload;

    /**
     * @param mixed[] $payload
     */
    public function initializePayloadTrait(array $payload = []): void
    {
        $this->payload = $payload;
    }

    /**
     * @return mixed[]
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    public function keyExists(string $key): bool
    {
        return \array_key_exists($key, $this->payload);
    }

    /**
     * @return mixed
     */
    public function getValue(string $key, bool $nullIfNotExists = false)
    {
        if (!$nullIfNotExists) {
            Assert::keyExists($this->payload, $key);
        }

        return $this->payload[$key] ?? null;
    }

    public function getBoolValue(string $key): bool
    {
        $value = $this->getValue($key, false);

        Assert::boolean($value);

        return $value;
    }

    public function getNullableBoolValue(string $key, bool $nullIfNotExists = false): ?bool
    {
        $value = $this->getValue($key, $nullIfNotExists);

        if (null === $value) {
            return null;
        }

        Assert::boolean($value);

        return $value;
    }

    public function getStringValue(string $key): string
    {
        $value = $this->getValue($key, false);

        Assert::string($value);

        return $value;
    }

    public function getNullableStringValue(string $key, bool $nullIfNotExists = false): ?string
    {
        $value = $this->getValue($key, $nullIfNotExists);

        if (null === $value) {
            return null;
        }

        Assert::string($value);

        return $value;
    }

    public function getDateTimeValueValue(string $key): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->getStringValue($key));
    }

    public function getNullableDateTimeValue(string $key, bool $nullIfNotExists = false): ?\DateTimeImmutable
    {
        $value = $this->getNullableStringValue($key, $nullIfNotExists);

        if (!$value) {
            return null;
        }

        return new \DateTimeImmutable($value);
    }

    public function getFloatValue(string $key): float
    {
        $value = $this->getValue($key, false);

        if (\is_int($value)) {
            $value = (float) $value;
        }

        Assert::float($value);

        return $value;
    }

    public function getNullableFloatValue(string $key, bool $nullIfNotExists = false): ?float
    {
        $value = $this->getValue($key, $nullIfNotExists);

        if (null === $value) {
            return null;
        }

        if (\is_int($value)) {
            $value = (float) $value;
        }

        Assert::float($value);

        return $value;
    }

    public function getIntValue(string $key): int
    {
        $value = $this->getValue($key, false);

        Assert::integer($value);

        return $value;
    }

    public function getNullableIntValue(string $key, bool $nullIfNotExists = false): ?int
    {
        $value = $this->getValue($key, $nullIfNotExists);

        if (null === $value) {
            return null;
        }

        Assert::integer($value);

        return $value;
    }

    /**
     * @return mixed[]
     */
    public function getArrayValue(string $key): array
    {
        $value = $this->getValue($key, false);

        Assert::isArray($value);

        return $value;
    }

    /**
     * @return mixed[]|null
     */
    public function getNullableArrayValue(string $key, bool $nullIfNotExists = false): ?array
    {
        $value = $this->getValue($key, $nullIfNotExists);

        if (null === $value) {
            return null;
        }

        Assert::isArray($value);

        return $value;
    }
}
