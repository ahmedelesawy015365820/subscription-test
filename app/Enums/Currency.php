<?php

namespace App\Enums;

enum Currency: string
{
    case EGP = 'EGP';
    case USD = 'USD';
    case AED = 'AED';

    public static function toDictionary(): array {
        $dictionary = [];
        foreach (self::cases() as $index=>$case) {
            $dictionary[$index]['name'] = $case->name;
            $dictionary[$index]['value'] = $case->value;
        }
        return $dictionary;
    }

}
