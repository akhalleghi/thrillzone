@extends('admin.layouts.app')
@section('title', 'داشبورد مدیریت')

@section('content')
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card-glass text-center">
                <i class="bi bi-people fs-3 text-info"></i>
                <div class="mt-1 muted">تعداد کاربران کل</div>
                <div class="fs-3 fw-bold">{{ $stats['users'] ?? '۰' }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-glass text-center">
                <i class="bi bi-box fs-3 text-info"></i>
                <div class="mt-1 muted">تعداد پلن‌ها</div>
                <div class="fs-3 fw-bold">{{ $stats['plans'] ?? '۰' }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-glass text-center">
                <i class="bi bi-activity fs-3 text-info"></i>
                <div class="mt-1 muted">اشتراک‌های فعال</div>
                <div class="fs-3 fw-bold">{{ $stats['activeSubs'] ?? '۰' }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-glass text-center">
                <i class="bi bi-cash-coin fs-3 text-info"></i>
                <div class="mt-1 muted">درآمد ماه جاری</div>
                <div class="fs-3 fw-bold">{{ $stats['currentRevenue'] ?? '۰' }} <span class="fs-6">تومان</span></div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-lg-8">
            <div class="card-glass">
                <h5 class="section-title mb-2">نمودار درآمد ماهیانه</h5>
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card-glass h-100">
                <h5 class="section-title">آخرین اشتراک‌های خریداری‌شده</h5>
                <ul class="list-group list-group-flush">
                    @forelse($latestSubscriptions as $subscription)
                        <li class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-start">
                            <div>
                                <span class="d-block fw-semibold">{{ $subscription['plan'] }}</span>
                                <span class="d-block small text-secondary">{{ $subscription['user'] }}</span>
                                <span class="d-block small text-secondary">تاریخ خرید: {{ $subscription['purchasedAt'] }}</span>
                            </div>
                            <div class="text-end">
                                <span class="{{ $subscription['statusClass'] }}">{{ $subscription['statusLabel'] }}</span>
                                <span class="d-block small mt-1 text-info">{{ $subscription['price'] }} تومان</span>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item bg-transparent text-white">داده‌ای برای نمایش وجود ندارد.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('revenueChart');
            const revenueDataset = @json($monthlyRevenue, JSON_UNESCAPED_UNICODE);
            const labels = revenueDataset.map(item => item.label);
            const values = revenueDataset.map(item => item.value);
            const formattedValues = revenueDataset.map(item => item.value_formatted);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'درآمد ماهیانه',
                        data: values,
                        tension: 0.35,
                        fill: true,
                        borderColor: '#00ffff',
                        backgroundColor: 'rgba(0,255,255,0.15)'
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label(context) {
                                    const idx = context.dataIndex;
                                    return `درآمد: ${formattedValues[idx]} تومان`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: v => Number(v).toLocaleString('fa-IR')
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
