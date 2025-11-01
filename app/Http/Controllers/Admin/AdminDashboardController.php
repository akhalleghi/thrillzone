<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'          => $this->formatNumber(User::count()),
            'plans'          => $this->formatNumber(Plan::count()),
            'activeSubs'     => $this->formatNumber(
                Subscription::where('status', 'active')->count()
            ),
            'currentRevenue' => $this->formatNumber($this->currentMonthRevenue()),
        ];

        $monthlyRevenue = $this->monthlyRevenueData();

        $latestSubscriptions = Subscription::query()
            ->with(['user:id,name,phone', 'plan:id,name'])
            ->orderByDesc('purchased_at')
            ->orderByDesc('created_at')
            ->limit(4)
            ->get()
            ->map(fn(Subscription $subscription) => [
                'plan'        => $subscription->plan?->name ?? 'نامشخص',
                'user'        => $subscription->user?->name ?: ($subscription->user?->phone ?? 'کاربر نامشخص'),
                'status'      => $subscription->status,
                'statusLabel' => $this->statusLabel($subscription->status),
                'statusClass' => $this->statusClass($subscription->status),
                'price'       => $subscription->price ? $this->formatNumber($subscription->price) : '۰',
                'purchasedAt' => $this->formatDate($subscription->purchased_at ?? $subscription->created_at),
            ]);

        return view('admin.dashboard', compact('stats', 'monthlyRevenue', 'latestSubscriptions'));
    }

    protected function currentMonthRevenue(): float
    {
        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        return Transaction::query()
            ->where('status', 'success')
            ->whereBetween(DB::raw('COALESCE(paid_at, created_at)'), [$start, $end])
            ->sum('amount');
    }

    protected function monthlyRevenueData(): array
    {
        $start = Carbon::now()->startOfMonth()->subMonths(11);
        $end   = Carbon::now()->endOfMonth();

        $raw = Transaction::query()
            ->selectRaw("DATE_FORMAT(COALESCE(paid_at, created_at), '%Y-%m') as month_key")
            ->selectRaw('SUM(amount) as total')
            ->where('status', 'success')
            ->whereBetween(DB::raw('COALESCE(paid_at, created_at)'), [$start, $end])
            ->groupBy('month_key')
            ->orderBy('month_key')
            ->pluck('total', 'month_key');

        $months = [];
        $cursor = $start->copy();

        while ($cursor <= $end) {
            $key = $cursor->format('Y-m');
            $months[] = [
                'key'           => $key,
                'label'         => $this->persianMonthName($cursor),
                'value'         => (float) ($raw[$key] ?? 0),
                'value_formatted' => $this->formatNumber($raw[$key] ?? 0),
            ];
            $cursor->addMonth();
        }

        return $months;
    }

    protected function persianMonthName(Carbon $date): string
    {
        $monthNames = [
            1  => 'ژانویه',
            2  => 'فوریه',
            3  => 'مارس',
            4  => 'آوریل',
            5  => 'مه',
            6  => 'ژوئن',
            7  => 'ژوئیه',
            8  => 'اوت',
            9  => 'سپتامبر',
            10 => 'اکتبر',
            11 => 'نوامبر',
            12 => 'دسامبر',
        ];

        return $monthNames[(int) $date->format('n')] ?? $date->format('Y-m');
    }

    protected function formatNumber(float|int|null $value, int $decimals = 0, bool $useGrouping = true): string
    {
        $number = $value ?? 0;

        if (class_exists(NumberFormatter::class)) {
            $formatter = new NumberFormatter('fa_IR', NumberFormatter::DECIMAL);
            $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);
            $formatter->setAttribute(NumberFormatter::GROUPING_USED, $useGrouping ? 1 : 0);

            $formatted = $formatter->format($number);

            return str_replace('٬', '،', $formatted);
        }

        if ($useGrouping) {
            $formatted = number_format((float) $number, $decimals, '.', ',');
        } else {
            $formatted = number_format((float) $number, $decimals, '.', '');
        }

        $search = ['0','1','2','3','4','5','6','7','8','9',','];
        $replace = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','،'];

        return str_replace($search, $replace, $formatted);
    }

    protected function formatDate(?Carbon $date): string
    {
        if (!$date) {
            return 'نامشخص';
        }

        return $this->formatNumber((int) $date->format('Y'), 0, false) . ' / ' .
            $this->formatNumber((int) $date->format('m'), 0, false) . ' / ' .
            $this->formatNumber((int) $date->format('d'), 0, false);
    }

    protected function statusLabel(string $status): string
    {
        return match ($status) {
            'active'   => 'فعال',
            'waiting'  => 'در انتظار',
            'ended'    => 'پایان یافته',
            default    => 'نامشخص',
        };
    }

    protected function statusClass(string $status): string
    {
        return match ($status) {
            'active'  => 'badge bg-success',
            'waiting' => 'badge bg-warning text-dark',
            'ended'   => 'badge bg-secondary',
            default   => 'badge bg-light text-dark',
        };
    }
}
