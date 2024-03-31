<?php

namespace App\Enum;

enum GenderEnum: string
{
    case MALE = "m";
    case FEMALE = "f";
    case OTHERS = "o";

    public static function getLabel(string $value): string
    {
        return match ($value) {
            self::MALE->value => "Male",
            self::FEMALE->value => 'Female',
            self::OTHERS->value => 'Others',
        };
    }
}