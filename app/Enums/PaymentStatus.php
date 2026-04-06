<?php


namespace App\Enums;


enum PaymentStatus: string
{
    case SUCCESS = 'success';
    case FAILED = 'failed';

    public static function toDictionary(): array {
        $dictionary = [];
        foreach (self::cases() as $index=>$case) {
            $dictionary[$index]['name'] = $case->name;
            $dictionary[$index]['value'] = $case->value;
        }
        return $dictionary;
    }

}
