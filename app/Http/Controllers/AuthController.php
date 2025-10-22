<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Helpers\SmsHelper;

class AuthController extends Controller
{
    /**
     * نمایش فرم ورود
     */
    public function showLoginForm()
    {
        // فقط اگر در حالت ورود موبایل/OTP نیستیم، سشن‌ها را پاک کن
        if (!session('otp_sent') && !session('need_name')) {
            session()->forget(['otp', 'otp_expires', 'otp_sent', 'last_otp_time', 'phone', 'otp_verified']);
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

        // محدودیت زمانی 60 ثانیه برای ارسال مجدد
        $lastTs = session('last_otp_time');
        if ($lastTs && (int)now()->timestamp - (int)$lastTs < 60) {
            $left = 60 - ((int)now()->timestamp - (int)$lastTs);
            return back()->with('error', "لطفاً {$left} ثانیه دیگر صبر کنید.");
        }

        $otp = random_int(100000, 999999);

        session([
            'phone'        => $phone,
            'otp'          => (string)$otp,
            'otp_expires'  => now()->addMinutes(3),
            'otp_sent'     => true,
            'otp_verified' => false,
            'need_name'    => false,
            'last_otp_time'=> now()->timestamp, // به‌صورت timestamp عددی
        ]);

        // ارسال پیامک
        $response = SmsHelper::sendOtp($phone, $otp);
        Log::info("SMS Response for {$phone}: " . $response);

        if (preg_match('/^\s*([+-]?\d+)/', $response, $m)) {
            $code = (int)$m[1];
            if ($code === 0) {
                return back()->with('success', 'کد تایید با موفقیت ارسال شد');
            }
            session()->forget('otp_sent');
            return back()->with('error', "خطا در ارسال پیامک (کد پاسخ: {$code})");
        }

        // پاسخ غیرمعمول
        return back()->with('success', 'پیامک ارسال شد (پاسخ سرور غیرمعمول بود)');
    }

    /**
     * بررسی OTP
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

        // ✅ کد صحیح است
        $existing = User::where('phone', $phoneSession)->first();

        if ($existing) {
            // کاربر قدیمی → ورود مستقیم
            session()->forget(['otp', 'otp_expires', 'otp_sent', 'last_otp_time', 'otp_verified', 'need_name']);
            Auth::login($existing);
            return redirect()->route('dashboard')->with('success', 'خوش آمدید!');
        }

        // کاربر جدید → مرحله سوم: گرفتن نام
        session([
            'otp_verified' => true,
            'need_name'    => true,
        ]);

        // برگرد به صفحه لاگین تا فرم نام نمایش داده شود
        return redirect()->route('login')->with('success', 'کد تایید شد، لطفاً نام و نام خانوادگی را وارد کنید.');
    }

    /**
     * تکمیل پروفایل برای کاربر جدید پس از تایید OTP
     */
    public function completeProfile(Request $request)
    {
        if (!session('otp_verified') || !session('phone')) {
            return redirect()->route('login')->with('error', 'ابتدا شماره موبایل را تأیید کنید.');
        }

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            // در صورت نیاز:
            // 'email' => ['nullable', 'email', 'max:150', 'unique:users,email'],
        ], [
            'name.required' => 'لطفاً نام و نام خانوادگی را وارد کنید.',
        ]);

        $phone = session('phone');

        $user = User::create([
            'name'     => $request->name,
            'phone'    => $phone,
            'email'    => null,              // اگر ایمیل گرفتی، مقدار بده
            'password' => bcrypt('000000'),  // placeholder برای سازگاری
        ]);

        session()->forget(['otp', 'otp_expires', 'otp_sent', 'last_otp_time', 'otp_verified', 'need_name']);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'ثبت نام با موفقیت انجام شد. خوش آمدید!');
    }

    /**
     * ارسال مجدد OTP با محدودیت 60 ثانیه
     */
    public function resendOtp()
    {
        $phone = session('phone');
        if (!$phone) {
            session()->forget(['otp', 'otp_expires', 'otp_sent', 'last_otp_time', 'otp_verified', 'need_name']);
            return redirect()->route('login');
        }

        $lastTs = session('last_otp_time');
        if ($lastTs && (int)now()->timestamp - (int)$lastTs < 60) {
            $left = 60 - ((int)now()->timestamp - (int)$lastTs);
            return back()->with('error', "لطفاً {$left} ثانیه دیگر صبر کنید.");
        }

        $otp = random_int(100000, 999999);

        session([
            'otp'           => (string)$otp,
            'otp_expires'   => now()->addMinutes(3),
            'otp_sent'      => true,
            'last_otp_time' => now()->timestamp,
        ]);

        $response = SmsHelper::sendOtp($phone, $otp);
        Log::info("SMS Response (resend) for {$phone}: " . $response);

        if (preg_match('/^\s*([+-]?\d+)/', $response, $m)) {
            $code = (int)$m[1];
            if ($code === 0) {
                return back()->with('success', 'کد تایید جدید با موفقیت ارسال شد.');
            }
            return back()->with('error', "خطا در ارسال پیامک (کد پاسخ: {$code})");
        }

        return back()->with('success', 'کد تایید جدید ارسال شد.');
    }

    /**
     * ریست سشن برای دکمه "تغییر شماره"
     */
    public function resetOtp()
    {
        session()->forget(['otp', 'otp_expires', 'otp_sent', 'phone', 'last_otp_time', 'otp_verified', 'need_name']);
        return redirect()->route('login');
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
