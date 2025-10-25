<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // فیلترهای ساده (اختیاری)
        $q       = trim($request->get('q',''));         // جستجو روی شماره تراکنش/کد مرجع/نام کاربر
        $status  = $request->get('status','');          // success/pending/failed/refunded
        $gateway = $request->get('gateway','');         // zarinpal/payir/...
        $dateFrom= $request->get('from','');            // 2025-01-01
        $dateTo  = $request->get('to','');              // 2025-12-31

        $transactions = Transaction::query()
            ->with(['user','plan'])
            ->when($q, function($qr) use ($q) {
                $qr->where('txn_number', 'like', "%{$q}%")
                   ->orWhere('ref_code', 'like', "%{$q}%")
                   ->orWhereHas('user', fn($u)=>$u->where('name','like',"%{$q}%")->orWhere('phone','like',"%{$q}%"));
            })
            ->when(in_array($status, ['success','pending','failed','refunded'], true), fn($qr)=>$qr->where('status',$status))
            ->when($gateway, fn($qr)=>$qr->where('gateway',$gateway))
            ->when($dateFrom, fn($qr)=>$qr->whereDate('paid_at','>=',$dateFrom))
            ->when($dateTo, fn($qr)=>$qr->whereDate('paid_at','<=',$dateTo))
            ->latest('paid_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.finance', compact('transactions','q','status','gateway','dateFrom','dateTo'));
    }
}
