<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user')->latest()->paginate(20);
        return view('admin.bookings', compact('bookings'));
    }

public function store(Request $request)
{
    $v = Validator::make($request->all(), [
        'date_jalali'  => ['required','string'],
        'start_hour'   => ['required','regex:/^\d{2}$/'],
        'start_minute' => ['required','regex:/^\d{2}$/'],
        'end_hour'     => ['required','regex:/^\d{2}$/'],
        'end_minute'   => ['required','regex:/^\d{2}$/'],
        'weekday'      => ['nullable','in:saturday,sunday,monday,tuesday,wednesday,thursday,friday'],
        'notes'        => ['nullable','string','max:255'],
    ]);

    if ($v->fails()) {
        return back()->withErrors($v)->withInput();
    }

    try {
        // 🟢 گام 1: اعداد فارسی را به انگلیسی تبدیل کن
        $j = $request->input('date_jalali');
        $j = strtr($j, [
            '۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4',
            '۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9',
            '٠'=>'0','١'=>'1','٢'=>'2','٣'=>'3','٤'=>'4',
            '٥'=>'5','٦'=>'6','٧'=>'7','٨'=>'8','٩'=>'9',
        ]);

        // 🟢 گام 2: تبدیل جلالی به میلادی
        $dateCarbon = Jalalian::fromFormat('Y/m/d', $j)->toCarbon();

        // 🟢 گام 3: ساخت رشته‌های زمان HH:MM
        $start = sprintf('%s:%s', $request->input('start_hour'), $request->input('start_minute'));
        $end   = sprintf('%s:%s', $request->input('end_hour'),   $request->input('end_minute'));

        // 🟢 گام 4: بررسی منطقی ساعت‌ها
        [$sh,$sm] = [intval($request->input('start_hour')), intval($request->input('start_minute'))];
        [$eh,$em] = [intval($request->input('end_hour')),   intval($request->input('end_minute'))];
        if (($eh*60+$em) <= ($sh*60+$sm)) {
            return back()->withErrors(['end_hour' => 'ساعت پایان باید بعد از ساعت شروع باشد.'])->withInput();
        }

        // 🟢 گام 5: ایجاد نوبت
        \App\Models\Booking::create([
            'date'        => $dateCarbon->format('Y-m-d'),
            'start_time'  => $start,
            'end_time'    => $end,
            'day_of_week'     => $request->input('weekday'),
            'is_reserved' => false,
            'reserved_by' => null,
            'notes'       => $request->input('notes'),
        ]);

        return back()->with('success','✅ نوبت با موفقیت ثبت شد.');

    } catch (\Throwable $e) {
        report($e);
        return back()->with('error','خطا در ثبت نوبت: '.$e->getMessage())->withInput();
    }
}

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->with('success','نوبت حذف شد.');
    }
}
