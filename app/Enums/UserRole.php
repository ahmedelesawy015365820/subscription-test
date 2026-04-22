<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public static function toDictionary(): array {
        $dictionary = [];
        foreach (self::cases() as $index=>$case) {
            $dictionary[$index]['name'] = $case->name;
            $dictionary[$index]['value'] = $case->value;
        }
        return $dictionary;
    }
}
