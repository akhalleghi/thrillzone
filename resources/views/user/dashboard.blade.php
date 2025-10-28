@extends('user.layouts.app')

@section('title', 'داشبورد من')

@section('content')
<div class="container">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 rounded-4 shadow text-center text-white" style="background: linear-gradient(135deg, #00ffff, #ff00ff);">
                <h2 class="mb-2 fw-bold" style="text-shadow: 0 0 5px #000;">👾 خوش آمدید به <span style="font-weight:900">منطقه هیجان</span></h2>
                <p class="m-0" style="opacity:0.9">پنل کاربری شما برای کنترل کامل اشتراک‌های بازی</p>
            </div>
        </div>
    </div>

    <!-- Profile Info -->
    <div class="row mb-4">
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 text-white" style="background: rgba(255,255,255,.03); border-radius: 16px;">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-gradient p-3" style="background: linear-gradient(135deg, #00ffff, #ff00ff); width:60px; height:60px; display:flex; justify-content:center; align-items:center;">
                        <i class="bi bi-person fs-3 text-dark"></i>
                    </div>
                    <div>
                        <h5 class="mb-1 fw-bold">{{ auth()->user()->name ?? 'کاربر عزیز' }}</h5>
                        <small class="text-white-50">شماره: {{ auth()->user()->phone ?? 'نامشخص' }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loop Active Subscriptions -->
    @php
        $subscriptions = auth()->user()->subscriptions ?? []; // فرض بر اینه که کاربر چند اشتراک داره
    @endphp

    @forelse ($subscriptions as $index => $sub)
        @php
            $plan = $sub->plan;
            $canSwap = now()->diffInDays($sub->last_swap_at ?? $sub->started_at) >= $plan->swap_interval_days;
        @endphp

        <div class="card border-0 text-white mb-4" style="background: rgba(255,255,255,.03); border-radius: 16px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 fw-bold text-info">🎮 اشتراک {{ $plan->name ?? 'نامشخص' }}</h4>
                    <span class="badge bg-secondary">#{{ $index + 1 }}</span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 col-xl-3">
                        <div class="p-3 rounded-3 border" style="border-color:rgba(0,255,255,0.2)">
                            <div class="text-muted small mb-1">مدت:</div>
                            <div class="fw-bold">{{ $sub->duration_months }} ماه</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="p-3 rounded-3 border" style="border-color:rgba(0,255,255,0.2)">
                            <div class="text-muted small mb-1">بازی مجاز:</div>
                            <div class="fw-bold">{{ $plan->max_games ?? '؟' }} بازی</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="p-3 rounded-3 border" style="border-color:rgba(0,255,255,0.2)">
                            <div class="text-muted small mb-1">پایان:</div>
                            <div class="fw-bold">{{ jdate($sub->ends_at)->format('Y/m/d') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="p-3 rounded-3 border" style="border-color:rgba(0,255,255,0.2)">
                            <div class="text-muted small mb-1">تعویض بعدی:</div>
                            <div class="fw-bold text-{{ $canSwap ? 'success' : 'warning' }}">
                                {{ $canSwap ? 'مجاز به تعویض' : jdate($sub->next_swap_at)->format('Y/m/d') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Selected Games -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-white-50">بازی‌های انتخابی:</span>
                        @if($canSwap)
                            <a href="{{ route('user.swap.form', $sub) }}" class="btn btn-sm btn-outline-light">
                                <i class="bi bi-arrow-repeat"></i> درخواست تعویض
                            </a>
                        @endif
                    </div>
                    <div class="row g-2">
                        @forelse($sub->games as $game)
                            <div class="col-auto">
                                <span class="badge bg-gradient text-dark p-2" style="background:linear-gradient(135deg,#00ffff,#ff00ff)">
                                    🎮 {{ $game->name }}
                                </span>
                            </div>
                        @empty
                            <div class="col-12 text-white-50">هیچ بازی‌ای انتخاب نشده.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-dark">شما هیچ اشتراک فعالی ندارید.</div>
    @endforelse
</div>
@endsection