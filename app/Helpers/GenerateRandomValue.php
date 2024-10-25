<?php

namespace App\Helpers;

class GenerateRandomValue
{
    static function generateRandomReservationId(): string
    {
        $prefix = 'RES-';
        $random = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8));
        return $prefix . $random;
    }
}
