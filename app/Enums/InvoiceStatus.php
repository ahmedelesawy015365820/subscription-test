<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case UNPAID = 'unpaid';
    case PAID = 'paid';
    case CANCELED = 'canceled';

    public static function toDictionary(): array {
        $dictionary = [];
        foreach (self::cases() as $index=>$case) {
            $dictionary[$index]['name'] = $case->name;
            $dictionary[$index]['value'] = $case->value;
        }
        return $dictionary;
    }
}
