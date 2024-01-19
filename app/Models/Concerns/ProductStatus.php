<?php

namespace App\Models\Concerns;

enum ProductStatus: int
{
    case PASSIVE = 0;
    case ACTIVE = 1;

    public static function list(): array
    {
        $arr = [];

        foreach (self::cases() as $case) {
            $arr[$case->name] = $case->value;
        }

        return $arr;
    }

    public static function listForIn(): string
    {
        return implode(",", self::list());
    }

    public static function getNameFromValue($key): string
    {
        return \strtolower(array_flip(self::list())[$key] ?? '');
    }
}
