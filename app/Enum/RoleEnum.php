<?php

namespace App\Enum;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'super_admin';
    case ARTIST_MANAGER = 'artist_manager';
    case ARTIST = 'artist';

    public static function getLabel(string $value): string
    {
        return match ($value){
          self::SUPER_ADMIN->value => 'Super Admin',
          self::ARTIST_MANAGER->value => 'Artist Manager',
          self::ARTIST->value => 'Artist'
        };
    }
}