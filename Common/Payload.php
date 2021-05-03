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

namespace Sulu\Bundle\SyliusConsumerBundle\Common;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Payload
{
    /**
     * @var mixed[]
     */
    protected $data;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function keyExists(string $key): bool
    {
        return \array_key_exists($key, $this->data);
    }

    /**
     * @return mixed
     */
    public function getValue(string $key, bool $nullIfNotExists = false)
    {
        if (!$nullIfNotExists) {
            Assert::keyExists($this->data, $key);
        }

        return $this->data[$key] ?? null;
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

    public function getUuidValue(string $key): string
    {
        $value = $this->getValue($key, false);

        Assert::string($value);
        static::assertUuid($value);

        return $value;
    }

    public function getNullableUuidValue(string $key, bool $nullIfNotExists = false): ?string
    {
        $value = $this->getValue($key, $nullIfNotExists);

        if (null === $value) {
            return null;
        }

        Assert::string($value);
        static::assertUuid($value);

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

        if (\is_numeric($value)) {
            $value = (int) $value;
        }

        Assert::integer($value);

        return $value;
    }

    public function getNullableIntValue(string $key, bool $nullIfNotExists = false): ?int
    {
        $value = $this->getValue($key, $nullIfNotExists);

        if (null === $value) {
            return null;
        }

        if (\is_numeric($value)) {
            $value = (int) $value;
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

    /**
     * @throws \InvalidArgumentException when the given value is no uuid
     */
    private static function assertUuid(string $value): void
    {
        if (!Uuid::isValid($value)) {
            throw new \InvalidArgumentException(\sprintf('Expected a uuid. Got: %s', $value));
        }
    }
}
