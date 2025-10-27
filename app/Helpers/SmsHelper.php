<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class SmsHelper
{
    public static function sendOtp(string $mobile, string $otp): string
    {
        $username = config('services.sms.username');
        $password = config('services.sms.password');
        $sender   = config('services.sms.sender');
        $url      = config('services.sms.url');

        if (!$username || !$password || !$sender) {
            Log::error('SMS config values missing in .env');
            return 'missing_config';
        }

        $message = "کد تایید شما در منطقه هیجان: {$otp}";

        $query = http_build_query([
            'FROM'     => $sender,
            'TO'       => $mobile,
            'TEXT'     => $message,
            'USERNAME' => $username,
            'PASSWORD' => $password,
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$url}?{$query}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            $err = curl_error($ch);
            curl_close($ch);
            Log::error("SMS cURL Error: {$err}");
            return 'curl_error';
        }

        curl_close($ch);
        Log::info("SMS sent to {$mobile} - Response: {$response}");
        return trim($response);
    }

    public static function sendMessage(string $mobile, string $message): string
    {
        $username = config('services.sms.username');
        $password = config('services.sms.password');
        $sender   = config('services.sms.sender');
        $url      = config('services.sms.url');

        if (!$username || !$password || !$sender) {
            Log::error('SMS config values missing in .env');
            return 'missing_config';
        }

        $query = http_build_query([
            'FROM'     => $sender,
            'TO'       => $mobile,
            'TEXT'     => $message,
            'USERNAME' => $username,
            'PASSWORD' => $password,
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "{$url}?{$query}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            $err = curl_error($ch);
            curl_close($ch);
            Log::error("SMS cURL Error: {$err}");
            return 'curl_error';
        }

        curl_close($ch);
        Log::info("SMS sent to {$mobile} - Response: {$response}");
        return trim($response);
    }

}
