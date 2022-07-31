<?php

namespace App\Helpers;

use Carbon\Carbon;

class Otp {
    public static function generate() {
        $otp = '';
        for ($i=0; $i<=5; $i++)
            $otp .= rand(0, 9);
        return [
            'otp' => $otp,
            'expires_at' => Carbon::now()->addHour(),
        ];
    }
}