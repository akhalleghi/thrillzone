<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SwapRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helpers\SmsHelper;


class SwapRequestController extends Controller
{
    public function index() {
        $requests = SwapRequest::with(['user', 'subscription.plan'])->latest()->paginate(12);
        return view('admin.swap_requests', compact('requests'));
    }

    // public function markDone(SwapRequest $swapRequest) {
    //     $subscription = $swapRequest->subscription;

    //     if ($subscription && $subscription->status === 'active') {
    //         $subscription->next_swap_at = Carbon::now()->addDays($subscription->swap_every_days ?? 30);
    //         $subscription->save();
    //     }

    //     $swapRequest->update(['status' => 'done']);
    //     return back()->with('success', 'درخواست تعویض انجام شد و تایمر ریست گردید.');
    // }

    public function markDone(SwapRequest $swapRequest)
    {
        $subscription = $swapRequest->subscription;

        if ($subscription) {
            // ✅ اگر وضعیت اشتراک فعال است، تایمر تعویض بازی را ریست کنیم
            if ($subscription->status === 'active') {
                $subscription->next_swap_at = now()->addDays($subscription->swap_every_days ?? 30);
            }

            // ✅ جایگزینی بازی‌های درخواستی با بازی‌های فعال فعلی
            if (!empty($swapRequest->requested_games)) {
                $subscription->active_games = $swapRequest->requested_games;
            }

            // ✅ ذخیره تغییرات اشتراک
            $subscription->save();
        }

        // ✅ تغییر وضعیت درخواست به انجام‌شده
        $swapRequest->update(['status' => 'done']);
        
        $user = $subscription->user;
        if ($user && $user->phone) {
        $message = "{$user->name} {$user->family} عزیز\nدرخواست تعویض بازی شما با موفقیت انجام شد ✅\n\nفروشگاه هیجان 🎮";
        SmsHelper::sendMessage($user->phone, $message);
    }

        return back()->with('success', 'درخواست تعویض انجام شد و بازی‌های جدید جایگزین شدند ، پیامک نیز ارسال گردید.');
    }

}

