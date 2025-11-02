<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsLog;
use Illuminate\Http\Request;

class SmsLogController extends Controller
{
    public function index(Request $request)
    {
        $search   = trim((string) $request->input('q', ''));
        $status   = $request->input('status');
        $gateway  = trim((string) $request->input('gateway', ''));
        $dateFrom = $request->input('from');
        $dateTo   = $request->input('to');

        $logsQuery = SmsLog::query()
            ->with([
                'user:id,name,phone',
                'transaction:id,txn_number',
                'subscription:id,subscription_code',
            ])
            ->latest('created_at')
            ->orderByDesc('id');

        if ($search !== '') {
            $logsQuery->where(function ($query) use ($search) {
                $query->where('mobile', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%")
                    ->orWhere('purpose', 'like', "%{$search}%")
                    ->orWhere('track_id', 'like', "%{$search}%");
            });
        }

        if ($status !== null && $status !== '') {
            $logsQuery->where('status', $status);
        }

        if ($gateway !== '') {
            $logsQuery->where('gateway', 'like', "%{$gateway}%");
        }

        if ($dateFrom) {
            $logsQuery->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $logsQuery->whereDate('created_at', '<=', $dateTo);
        }

        $logs = $logsQuery->paginate(20)->withQueryString();

        return view('admin.sms-logs', [
            'logs'     => $logs,
            'search'   => $search,
            'status'   => $status,
            'gateway'  => $gateway,
            'dateFrom' => $dateFrom,
            'dateTo'   => $dateTo,
        ]);
    }
}
