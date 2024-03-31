<?php

namespace App\Enum;

enum GenreEnum : string
{
    case RNB = 'rnb';
    case COUNTRY = 'country';
    case CLASSIC = 'classic';
    case ROCK = 'rock';
    case JAZZ = 'jazz';

    public static function getLabel(string $value): string
    {
        return match ($value) {
            self::RNB->value => "Rythm and Blues",
            self::CLASSIC->value => 'Classic',
            self::COUNTRY->value => 'Country',
            self::ROCK->value => 'Rock',
            self::JAZZ->value => 'Jazz',
            default => 'No Match Found',
        };
    }
}