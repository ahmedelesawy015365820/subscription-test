<?php

namespace App\Enums;

enum AccountType: string
{
    case ASSET = 'asset';
    case LIABILITY = 'liability';
    case REVENUE = 'revenue';

    public static function toDictionary(): array {
        $dictionary = [];
        foreach (self::cases() as $index=>$case) {
            $dictionary[$index]['name'] = $case->name;
            $dictionary[$index]['value'] = $case->value;
        }
        return $dictionary;
    }
}
