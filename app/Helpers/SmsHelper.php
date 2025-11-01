<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use App\Models\SmsLog;
use Illuminate\Support\Facades\Auth;


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

    // public static function sendMessage(string $mobile, string $message): string
    // {
    //     $username = config('services.sms.username');
    //     $password = config('services.sms.password');
    //     $sender   = config('services.sms.sender');
    //     $url      = config('services.sms.url');

    //     if (!$username || !$password || !$sender) {
    //         Log::error('SMS config values missing in .env');
    //         return 'missing_config';
    //     }

    //     $query = http_build_query([
    //         'FROM'     => $sender,
    //         'TO'       => $mobile,
    //         'TEXT'     => $message,
    //         'USERNAME' => $username,
    //         'PASSWORD' => $password,
    //     ]);

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, "{$url}?{$query}");
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);

    //     if ($response === false) {
    //         $err = curl_error($ch);
    //         curl_close($ch);
    //         Log::error("SMS cURL Error: {$err}");
    //         return 'curl_error';
    //     }

    //     curl_close($ch);
    //     Log::info("SMS sent to {$mobile} - Response: {$response}");
    //     return trim($response);
    // }

    public static function sendMessage(string $mobile, string $message, array $context = []): string
    {
        $username = config('services.sms.username');
        $password = config('services.sms.password');
        $sender   = config('services.sms.sender');
        $url      = config('services.sms.url');

        // اطلاعات تکمیلی اختیاری برای لاگ
        $userId         = $context['user_id'] ?? (Auth::id() ?: null);
        $transactionId  = $context['transaction_id'] ?? null;
        $subscriptionId = $context['subscription_id'] ?? null;
        $purpose        = $context['purpose'] ?? null;          // otp, payment_success, payment_failed, custom, ...
        $trackId        = $context['track_id'] ?? null;
        $gateway        = $context['gateway'] ?? 'default';

        if (!$username || !$password || !$sender) {
            \Log::error('SMS config values missing in .env');

            self::storeLog([
                'user_id'          => $userId,
                'transaction_id'   => $transactionId,
                'subscription_id'  => $subscriptionId,
                'mobile'           => $mobile,
                'message'          => $message,
                'purpose'          => $purpose,
                'track_id'         => $trackId,
                'status'           => 'missing_config',
                'gateway'          => $gateway,
                'provider_status'  => null,
                'provider_response'=> null,
                'error_message'    => 'Missing SMS config in .env',
            ]);

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
            \Log::error("SMS cURL Error: {$err}");

            self::storeLog([
                'user_id'          => $userId,
                'transaction_id'   => $transactionId,
                'subscription_id'  => $subscriptionId,
                'mobile'           => $mobile,
                'message'          => $message,
                'purpose'          => $purpose,
                'track_id'         => $trackId,
                'status'           => 'curl_error',
                'gateway'          => $gateway,
                'provider_status'  => null,
                'provider_response'=> null,
                'error_message'    => $err,
            ]);

            return 'curl_error';
        }

        curl_close($ch);

        // اینجا می‌تونی با توجه به پاسخ سرویس، موفق/ناموفق بودن رو دقیق‌تر تشخیص بدی
        // فعلاً فرض می‌کنیم هر پاسخ غیر false یعنی ارسال موفق
        $providerStatus = 'OK';
        $status = 'sent';

        // اگر سرویس شما کُد مشخصی برمی‌گرداند، اینجا parse کن و مقدار واقعی بده
        // مثال:
        // $json = json_decode($response, true);
        // $providerStatus = $json['status'] ?? 'UNKNOWN';
        // $status = ($providerStatus == '0' || $providerStatus == 'OK') ? 'sent' : 'failed';

        \Log::info("SMS sent to {$mobile} - Response: {$response}");

        self::storeLog([
            'user_id'          => $userId,
            'transaction_id'   => $transactionId,
            'subscription_id'  => $subscriptionId,
            'mobile'           => $mobile,
            'message'          => $message,
            'purpose'          => $purpose,
            'track_id'         => $trackId,
            'status'           => $status,
            'gateway'          => $gateway,
            'provider_status'  => $providerStatus,
            'provider_response'=> is_string($response) ? mb_substr($response, 0, 5000) : null, // برای جلوگیری از متن‌های خیلی بلند
            'error_message'    => null,
        ]);

        return trim((string)$response);
    }


    protected static function storeLog(array $data): void
    {
        try {
            SmsLog::create($data);
        } catch (\Throwable $e) {
            // اگر حتی ذخیره لاگ هم خطا داد، نذار فرآیند اصلی بترکه
            \Log::warning('SMS Log save error: '.$e->getMessage());
        }
    }


}
