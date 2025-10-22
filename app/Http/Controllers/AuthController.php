<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Helpers\SmsHelper;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * نمایش فرم ورود
     */
    public function showLoginForm()
    {
        // فقط اگر در مرحله OTP نیستیم، سشن‌های قبلی را پاک کن
        if (!session('otp_sent')) {
            session()->forget(['otp', 'otp_expires', 'otp_sent', 'last_otp_time', 'phone']);
        }
        return view('auth.login');
    }

    /**
     * ارسال OTP
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^09\d{9}$/'],
        ]);

        $phone = $request->phone;

        // ریت‌لیمیت: هر 60 ثانیه
        if (session('last_otp_time')) {
            $last = Carbon::parse(session('last_otp_time'));
            $elapsed = now()->diffInSeconds($last);
            if ($elapsed < 60) {
                $left = 60 - $elapsed;
                return back()->with('error', "لطفاً {$left} ثانیه دیگر صبر کنید تا بتوانید مجدداً درخواست دهید.");
            }
        }

        $otp = random_int(100000, 999999);

        session([
            'phone'        => $phone,
            'otp'          => (string)$otp,
            'otp_expires'  => now()->addMinutes(3),
            'otp_sent'     => true,
            'last_otp_time'=> now()->toDateTimeString(), // به صورت متن استاندارد
        ]);

        // ارسال پیامک
        $response = SmsHelper::sendOtp($phone, $otp);
        Log::info("SMS Response for {$phone}: " . $response);

        // پاسخ عددی ابتدای رشته
        if (preg_match('/^\s*([+-]?\d+)/', $response, $m)) {
            $code = (int)$m[1];
            if ($code === 0) {
                return redirect()->route('auth.login')->with('success', 'کد تایید با موفقیت ارسال شد.');
            }
            // خطای سرور پیامکی
            return back()->with('error', "خطا در ارسال پیامک (کد پاسخ: {$code})");
        }

        // پاسخ غیرمعمول
        return redirect()->route('auth.login')->with('success', 'پیامک ارسال شد.');
    }

    /**
     * تأیید OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^09\d{9}$/'],
            'otp'   => ['required', 'digits:6'],
        ]);

        $phoneForm    = $request->phone;
        $phoneSession = session('phone');
        $otpSession   = (string) session('otp');
        $expiresAt    = session('otp_expires');

        if (!$phoneSession || !$otpSession || $phoneForm !== $phoneSession) {
            return back()
                ->withErrors(['otp' => 'جلسه شما منقضی شده یا اطلاعات ناقص است.'])
                ->with('otp_sent', true)
                ->with('phone', $phoneForm);
        }

        if (!$expiresAt || now()->greaterThan($expiresAt)) {
            session()->forget(['otp', 'otp_expires', 'otp_sent']);
            return back()
                ->withErrors(['otp' => 'کد تایید منقضی شده است.'])
                ->with('phone', $phoneForm);
        }

        $otpInput = $this->normalizeDigits($request->otp);

        if ($otpInput !== $otpSession) {
            return back()
                ->withErrors(['otp' => 'کد تایید اشتباه است.'])
                ->with('otp_sent', true)
                ->with('phone', $phoneForm);
        }

        // موفق
        session()->forget(['otp', 'otp_expires', 'otp_sent', 'last_otp_time']);

        $user = User::firstOrCreate(
            ['phone' => $phoneSession],
            [
                'name'     => null,
                'email'    => null,
                'password' => bcrypt('000000'),
            ]
        );

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'خوش آمدید!');
    }

    /**
     * ارسال مجدد OTP
     */
    public function resendOtp()
    {
        $phone = session('phone');

        // اگر شماره ذخیره نیست، برگرد به لاگین
        if (!$phone) {
            session()->forget(['otp', 'otp_expires', 'otp_sent', 'last_otp_time']);
            return redirect()->route('auth.login');
        }

        // جلوگیری از ارسال زودتر از ۶۰ ثانیه
        if (session('last_otp_time')) {
            try {
                $last = \Carbon\Carbon::parse(session('last_otp_time'));
            } catch (\Exception $e) {
                // اگر پارس با خطا مواجه شد، بازنویسی کن
                $last = now()->subMinutes(2);
            }

            // اختلاف دقیق ثانیه‌ها با عدد صحیح
            $elapsed = (int) abs(now()->diffInSeconds($last));

            if ($elapsed < 60) {
                $left = max(0, 60 - $elapsed);
                return back()->with('error', "لطفاً {$left} ثانیه دیگر صبر کنید.");
            }
        }

        // ✅ تولید کد جدید
        $otp = random_int(100000, 999999);

        // ذخیره سشن با زمان به‌صورت timestamp عددی (بهتر از رشته)
        session([
            'otp' => (string) $otp,
            'otp_expires' => now()->addMinutes(3),
            'otp_sent' => true,
            'last_otp_time' => now()->timestamp, // فقط timestamp ذخیره می‌کنیم
        ]);

        // ارسال پیامک
        $response = \App\Helpers\SmsHelper::sendOtp($phone, $otp);
        \Log::info("SMS Response (resend) for {$phone}: " . $response);

        if (preg_match('/^\s*([+-]?\d+)/', $response, $m)) {
            $code = (int) $m[1];
            if ($code === 0) {
                return back()->with('success', 'کد تایید جدید با موفقیت ارسال شد.');
            }
            return back()->with('error', "خطا در ارسال پیامک (کد پاسخ: {$code})");
        }

        return back()->with('success', 'کد تایید جدید ارسال شد.');
    }


    /**
     * ریست مرحله (تغییر شماره)
     */
    public function resetOtp()
    {
        session()->forget(['otp', 'otp_expires', 'otp_sent', 'phone', 'last_otp_time']);
        return redirect()->route('auth.login');
    }

    /**
     * تبدیل ارقام فارسی/عربی به انگلیسی
     */
    private function normalizeDigits(string $value): string
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $arabic  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        $value   = str_replace($persian, $english, $value);
        $value   = str_replace($arabic,  $english, $value);
        return preg_replace('/\D+/', '', $value) ?? '';
    }
}
