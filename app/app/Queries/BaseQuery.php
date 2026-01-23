<?php

declare(strict_types=1);

namespace App\Queries;

use BackedEnum;
use App\Interfaces\QueryInterface;


readonly abstract class BaseQuery implements QueryInterface
{
    /**
     * По умолчанию не кешируем
     */
    public function getCacheTtl(): ?int
    {
        return null;
    }

    /**
     * По умолчанию нет тегов
     */
    public function getCacheTags(): array
    {
        return [];
    }

    /**
     * Генерация ключа кеша на основе класса и параметров
     */
    public function getCacheKey(): string
    {
        $reflection = new \ReflectionClass($this);
        $properties = [];

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $value = $property->getValue($this);
            $properties[$property->getName()] = $this->serializeValue($value);
        }

        return sprintf(
            '%s:%s',
            class_basename($this),
            md5(serialize($properties))
        );
    }

    /**
     * Сериализация значения для ключа кеша
     */
    protected function serializeValue(mixed $value): mixed
    {
        if (is_object($value) && method_exists($value, '__toString')) {
            return (string)$value;
        }

        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        return $value;
    }
}
