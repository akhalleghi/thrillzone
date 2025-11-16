
@extends('user.layouts.app')

@section('title', 'اشتراک‌های من')

@php
    use Morilog\Jalali\Jalalian;
    use Illuminate\Support\Carbon;

    $gamePlaceholderSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="160" height="100" viewBox="0 0 160 100"><rect fill="#25315c" width="160" height="100" rx="14"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#8cb8ff" font-size="26" font-family="Vazir, sans-serif">Game</text></svg>';
    $gamePlaceholder = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($gamePlaceholderSvg);
@endphp

@section('extra-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <style>
        .card-glass {
            background: rgba(16,21,52,.88);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.35);
            backdrop-filter: blur(18px);
        }
        .section-title {
            background: linear-gradient(135deg,#00f5ff,#ff4dff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
        .table thead th {
            border-bottom: 1px solid rgba(255,255,255,.12);
            color: #9fe3ff;
            font-size: .9rem;
            white-space: nowrap;
        }
        .table td,
        .table th {
            border-color: rgba(255,255,255,.07);
            vertical-align: middle;
            font-size: .95rem;
        }
        .table-wrapper { position: relative; }
        .table-scroll { overflow-x: auto; }
        .game-pill {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: rgba(13,110,253,.18);
            border-radius: 999px;
            padding: .25rem .65rem;
            margin: .15rem .15rem .15rem 0;
            font-size: .85rem;
            white-space: nowrap;
        }
        .game-pill img {
            width: 28px;
            height: 18px;
            object-fit: cover;
            border-radius: 6px;
        }
        .badge-soft {
            border-radius: 999px;
            padding: .35rem .85rem;
            font-size: .78rem;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,.12);
        }
        .badge-waiting { background: rgba(255,193,7,.18); color: #ffd966; }
        .badge-active { background: rgba(25,135,84,.22); color: #63ffb4; }
        .badge-ended { background: rgba(220,53,69,.18); color: #ff7b9b; }
        .timer {
            font-variant-numeric: tabular-nums;
            direction: ltr;
            display: inline-block;
            min-width: 120px;
        }
        .subs-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            justify-content: center;
        }
        .swap-disabled {
            opacity: .45;
            pointer-events: none;
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }
        .empty-state .icon {
            font-size: 3rem;
            color: #2ddfff;
            margin-bottom: 1rem;
        }
        .sub-card {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .mobile-actions {
            display: flex;
            flex-wrap: wrap;
            gap: .45rem;
            margin-top: .75rem;
        }
        .select2-option-cover {
            width: 40px;
            height: 26px;
            object-fit: cover;
            border-radius: 6px;
        }
        .select2-container--bootstrap-5 .select2-selection {
            background-color: #101a3f;
            border: 1px solid rgba(255,255,255,.18);
            color: #fff;
            min-height: 2.8rem;
            display: flex;
            align-items: center;
        }
        .select2-container--bootstrap-5 .select2-selection__rendered {
            color: #fff;
            padding-right: .75rem;
        }
        .select2-container--bootstrap-5 .select2-dropdown {
            background-color: #0f1738;
            border: 1px solid rgba(255,255,255,.18);
            color: #fff;
            z-index: 1061;
        }
        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background: rgba(13,110,253,.35);
            color: #fff;
        }
        @media (max-width: 992px) {
            .table-wrapper { display: none; }
        }
        .subscription-modal .modal-content {
            background: rgba(15,23,56,.95);
            border: 1px solid rgba(255,255,255,.15);
            box-shadow: 0 20px 60px rgba(0,0,0,.45);
        }
        .subscription-modal .modal-header,
        .subscription-modal .modal-footer {
            border-color: rgba(255,255,255,.12);
            background: rgba(255,255,255,.02);
        }
        .subscription-modal .modal-header {
            align-items: center;
            gap: 1rem;
        }
        .subscription-modal .modal-header .modal-title {
            color: #fff;
        }
        .subscription-modal .modal-header .btn-close {
            margin: 0;
            margin-inline-end: auto;
            filter: invert(1);
            opacity: .8;
        }
        .subscription-modal .modal-header .btn-close:hover {
            opacity: 1;
        }
        .subscription-modal .modal-body {
            background: rgba(16,21,52,.6);
        }
        .subscription-modal .modal-footer {
            backdrop-filter: blur(6px);
        }
        .select2-container--bootstrap-5 .select2-selection__placeholder,
        .select2-container--bootstrap-5 .select2-results__option {
            color: #fff;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4 gap-2">
        <div>
            <h3 class="section-title mb-0">اشتراک‌های من</h3>
            <p class="text-secondary mb-0">وضعیت اشتراک‌ها، انتخاب بازی‌ها و درخواست تعویض را از همین‌جا مدیریت کن.</p>
        </div>
        <div>
            <span class="badge bg-primary bg-opacity-25 text-info px-3 py-2">
                <i class="bi bi-controller"></i>
                اشتراک های فعال: {{ $subscriptions->where('status', 'active')->count() }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            لطفاً خطاهای زیر را برطرف کن:
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
        </div>
    @endif

    @if($subscriptions->isEmpty())
        <div class="card-glass empty-state">
            <div class="icon"><i class="bi bi-emoji-smile"></i></div>
            <h5 class="text-info">در حال حاضر اشتراکی ثبت نکرده‌ای</h5>
            <p class="text-secondary mb-0">برای ساخت اولین اشتراک به فروشگاه پلن‌ها سر بزن تا بازی‌هایت همیشه آماده باشند.</p>
        </div>
    @else
        <div class="card-glass">
            <div class="table-wrapper d-none d-lg-block">
                <div class="table-scroll">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>شماره اشتراک</th>
                            <th>پلن</th>
                            <th>وضعیت</th>
                            <th>تاریخ خرید</th>
                            <th>مهلت انتخاب بازی</th>
                            <th>زمان هماهنگی</th>
                            <th>شروع</th>
                            <th>پایان</th>
                            <th>تا پایان اشتراک</th>
                            <th>بازی‌ها</th>
                            <th>تا تعویض بعدی</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subscriptions as $index => $subscription)
                            @php
                                $baseIndex = ($subscriptions instanceof \Illuminate\Pagination\LengthAwarePaginator || $subscriptions instanceof \Illuminate\Pagination\Paginator)
                                    ? ($subscriptions->firstItem() ?? 1)
                                    : 1;
                                $rowNumber = $baseIndex + $index;
                                $status = $subscription->status;
                                $statusLabel = match ($status) {
                                    'waiting' => 'در انتظار انتخاب بازی',
                                    'active'  => 'فعال',
                                    'ended'   => 'پایان یافته',
                                    default   => 'نامشخص',
                                };
                                $statusClass = match ($status) {
                                    'waiting' => 'badge-soft badge-waiting',
                                    'active'  => 'badge-soft badge-active',
                                    'ended'   => 'badge-soft badge-ended',
                                    default   => 'badge-soft',
                                };
                                $selectionDeadline = $subscription->selection_deadline;
                                $selectionDeadlineIso = $selectionDeadline?->toIso8601String();
                                $games = collect($subscription->active_games ?? [])->filter(fn($item) => filled($item))->values();
                                $hasSelectedGames = $subscription->has_selected_games;
                                $needsSelection = !$hasSelectedGames || !$subscription->games_selected_at || !$subscription->requested_at;
                                $swapReady = $subscription->status === 'active' && $subscription->next_swap_at && now()->greaterThanOrEqualTo($subscription->next_swap_at);
                                $modalId = 'subscriptionModal-' . $subscription->id;
                                $hasPendingSwap = in_array($subscription->id, $pendingSwapRequests, true);
                                $level1Count = max(0, (int) optional($subscription->plan)->level1_selection);
                                $totalSlots = max(0, (int) optional($subscription->plan)->concurrent_games);
                                $otherCount = max(0, $totalSlots - $level1Count);
                                $planName = optional($subscription->plan)->name ?? 'بدون پلن';
                                $purchasedAt = $subscription->purchased_at ? Jalalian::fromCarbon($subscription->purchased_at)->format('Y/m/d H:i') : '---';
                                $requestedAtFormatted = $subscription->requested_at ? Jalalian::fromCarbon($subscription->requested_at)->format('Y/m/d H:i') : null;
                                $activatedAt = $subscription->activated_at ? Jalalian::fromCarbon($subscription->activated_at)->format('Y/m/d H:i') : '---';
                                $endsAtFormatted = $subscription->ends_at ? Jalalian::fromCarbon($subscription->ends_at)->format('Y/m/d H:i') : '---';
                                $endsCountdownIso = $subscription->ends_at?->toIso8601String();
                                $selectionDelayDays = $subscription->selection_delay_days ?? 0;
                                $deadlinePassed = $selectionDeadline && now()->greaterThan($selectionDeadline);
                                $swapIso = $subscription->next_swap_at?->toIso8601String();
                            @endphp
                            <tr>
                                <td>{{ $rowNumber }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $subscription->subscription_code ?? '---' }}</span>
                                        <span class="text-secondary small">{{ $subscription->duration_months }} ماهه</span>
                                    </div>
                                </td>
                                <td>{{ $planName }}</td>
                                <td><span class="{{ $statusClass }}">{{ $statusLabel }}</span></td>
                                <td>{{ $purchasedAt }}</td>
                                <td>
                                    @if($hasSelectedGames)
                                        <div class="text-success fw-semibold">بازی‌ها انتخاب شده‌اند</div>
                                        @if($selectionDelayDays > 0)
                                            <div class="text-warning small">با {{ $selectionDelayDays }} روز تأخیر</div>
                                        @endif
                                        @if($subscription->games_selected_at)
                                            <div class="text-secondary small">{{ Jalalian::fromCarbon($subscription->games_selected_at)->format('Y/m/d H:i') }}</div>
                                        @endif
                                    @elseif($subscription->status === 'waiting')
                                        <span class="timer selection-countdown {{ $deadlinePassed ? 'text-danger' : '' }}" data-deadline="{{ $selectionDeadlineIso }}">
                                            {{ $deadlinePassed ? 'مهلت انتخاب به پایان رسیده' : '...' }}
                                        </span>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>
                                <td>
                                    @if($requestedAtFormatted)
                                        <span class="text-info">{{ $requestedAtFormatted }}</span>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>
                                <td>{{ $activatedAt }}</td>
                                <td>{{ $endsAtFormatted }}</td>
                                <td>
                                    @if($subscription->status === 'active' && $subscription->ends_at)
                                        @if(now()->greaterThanOrEqualTo($subscription->ends_at))
                                            <span class="text-danger fw-semibold">اشتراک به پایان رسیده</span>
                                        @else
                                            <span class="timer end-countdown" data-deadline="{{ $endsCountdownIso }}">...</span>
                                        @endif
                                    @elseif($subscription->status === 'ended')
                                        <span class="text-muted">پایان یافته</span>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>
                                <td>
                                    @if($games->isEmpty())
                                        <span class="text-secondary">بازی انتخاب نشده</span>
                                    @else
                                        <span class="text-info">{{ $games->implode(', ') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($subscription->status === 'active' && $subscription->next_swap_at)
                                        @if($swapReady)
                                            <span class="text-success fw-semibold">شما هم‌اکنون مجاز به تعویض بازی هستید</span>
                                        @else
                                            <span class="timer swap-countdown" data-deadline="{{ $swapIso }}">...</span>
                                        @endif
                                    @elseif($subscription->status === 'active')
                                        <span class="text-muted">---</span>
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="subs-actions">
                                        @if($needsSelection)
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" data-mode="initial">
                                                <i class="bi bi-list-check"></i>
                                                انتخاب بازی‌ها
                                            </button>
                                        @endif
                                        @if($subscription->swap_every_days)
                                            <button class="btn btn-sm btn-outline-info {{ $swapReady && !$hasPendingSwap ? '' : 'swap-disabled' }}" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" data-mode="swap">
                                                <i class="bi bi-arrow-repeat"></i>
                                                درخواست تعویض بازی
                                            </button>
                                        @endif
                                        @if($hasPendingSwap)
                                            <span class="text-warning small">درخواست تعویض در انتظار بررسی</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @push('modals')
                                <div class="modal fade subscription-modal" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content text-light">
                                            <div class="modal-header">
                                                <h5 class="modal-title">انتخاب بازی‌های اشتراک</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="بستن"></button>
                                            </div>
                                            <form method="POST" action="{{ route('user.subscriptions.selection', $subscription) }}">
                                                @csrf
                                                <input type="hidden" name="mode" value="initial">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                            <div>
                                                                <h5 class="mb-0 text-info">{{ $planName }}</h5>
                                                                <p class="text-secondary mb-0 small">ظرفیت بازی همزمان: {{ $totalSlots }}</p>
                                                            </div>
                                                            <div class="text-end">
                                                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                                                    <i class="bi bi-clock-history"></i>
                                                                    مهلت تعویض: {{ $subscription->swap_every_days ? $subscription->swap_every_days . ' روزه' : 'غیرفعال' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        @php
                                                            $allSelectableGames = $level1Games->concat($otherGames)->unique('id');
                                                        @endphp
                                                        @if($level1Count > 0)
                                                            @for($i = 0; $i < $level1Count; $i++)
                                                                @php
                                                                    $selectedName = $games->get($i);
                                                                @endphp
                                                                <div class="col-md-6">
                                                                    <label class="form-label text-info">انتخاب بازی سطح ۱ ({{ $i + 1 }})</label>
                                                                    <select class="form-select game-select" name="games[level1][]" data-placeholder="انتخاب بازی سطح ۱" required>
                                                                        <option value="">-- انتخاب --</option>
                                                                        @foreach($allSelectableGames as $game)
                                                                            <option value="{{ $game->id }}" data-cover="{{ $game->cover ? $game->cover_url : $gamePlaceholder }}" {{ $selectedName === $game->name ? 'selected' : '' }}>{{ $game->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endfor
                                                        @endif
                                                        @if($otherCount > 0)
                                                            @for($i = 0; $i < $otherCount; $i++)
                                                                @php
                                                                    $selectedName = $games->get($level1Count + $i);
                                                                @endphp
                                                                <div class="col-md-6">
                                                                    <label class="form-label text-info">انتخاب سایر بازی‌ها ({{ $i + 1 }})</label>
                                                                    <select class="form-select game-select" name="games[other][]" data-placeholder="انتخاب سایر بازی‌ها" required>
                                                                        <option value="">-- انتخاب --</option>
                                                                        @foreach($otherGames as $game)
                                                                            <option value="{{ $game->id }}" data-cover="{{ $game->cover ? $game->cover_url : $gamePlaceholder }}" {{ $selectedName === $game->name ? 'selected' : '' }}>{{ $game->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endfor
                                                        @endif
                                                    </div>
                                                    <hr class="border-secondary border-opacity-25 my-4">
                                                    <div class="mb-3 booking-section">
                                                        <h6 class="text-info mb-2">انتخاب زمان ارتباط با کارشناس</h6>
                                                        <p class="text-secondary small mb-3">لطفاً یکی از بازه‌های آزاد را انتخاب کن تا کارشناس در همان زمان با تو هماهنگ کند.</p>
                                                        <select class="form-select" name="booking_id" required>
                                                            <option value="">-- انتخاب زمان تماس --</option>
                                                            @foreach($availableBookings as $booking)
                                                                @php
                                                                    $reservedByUser = (int) $booking->user_id === auth()->id();
                                                                @endphp
                                                                @continue($booking->status !== 'available' && !$reservedByUser)
                                                                @php
                                                                    $date = Carbon::parse($booking->date);
                                                                    $label = Jalalian::fromCarbon($date)->format('Y/m/d');
                                                                    $time = $booking->start_time . ' تا ' . $booking->end_time;
                                                                @endphp
                                                                <option value="{{ $booking->id }}">
                                                                    {{ $label }} | {{ $time }} {{ $reservedByUser ? '(رزرو شده توسط شما)' : '' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">انصراف</button>
                                                    <button type="submit" class="btn btn-neon submit-btn">ثبت انتخاب</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endpush
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mobile-cards d-lg-none">
                @foreach($subscriptions as $subscription)
                    @php
                        $status = $subscription->status;
                        $statusLabel = match ($status) {
                            'waiting' => 'در انتظار انتخاب بازی',
                            'active'  => 'فعال',
                            'ended'   => 'پایان یافته',
                            default   => 'نامشخص',
                        };
                        $statusClass = match ($status) {
                            'waiting' => 'badge-soft badge-waiting',
                            'active'  => 'badge-soft badge-active',
                            'ended'   => 'badge-soft badge-ended',
                            default   => 'badge-soft',
                        };
                        $modalId = 'subscriptionModal-' . $subscription->id;
                        $games = collect($subscription->active_games ?? [])->filter(fn($item) => filled($item))->values();
                        $hasSelectedGames = $subscription->has_selected_games;
                        $needsSelection = !$hasSelectedGames || !$subscription->games_selected_at || !$subscription->requested_at;
                        $swapReady = $subscription->status === 'active' && $subscription->next_swap_at && now()->greaterThanOrEqualTo($subscription->next_swap_at);
                        $hasPendingSwap = in_array($subscription->id, $pendingSwapRequests, true);
                        $planName = optional($subscription->plan)->name ?? 'بدون پلن';
                        $selectionDeadline = $subscription->selection_deadline;
                        $selectionDeadlineIso = $selectionDeadline?->toIso8601String();
                        $selectionDelayDays = $subscription->selection_delay_days ?? 0;
                        $deadlinePassed = $selectionDeadline && now()->greaterThan($selectionDeadline);
                        $swapIso = $subscription->next_swap_at?->toIso8601String();
                        $purchasedAt = $subscription->purchased_at ? Jalalian::fromCarbon($subscription->purchased_at)->format('Y/m/d H:i') : '---';
                        $activatedAt = $subscription->activated_at ? Jalalian::fromCarbon($subscription->activated_at)->format('Y/m/d H:i') : '---';
                        $endsAtFormatted = $subscription->ends_at ? Jalalian::fromCarbon($subscription->ends_at)->format('Y/m/d H:i') : '---';
                        $endsCountdownIso = $subscription->ends_at?->toIso8601String();
                    @endphp
                    <div class="sub-card">
                        <div class="header mb-2">
                            <div>
                                <div class="fw-semibold">{{ $subscription->subscription_code ?? '---' }}</div>
                                <div class="text-secondary small">{{ $planName }} | {{ $subscription->duration_months }} ماهه</div>
                            </div>
                            <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>
                        <div class="row g-2 text-secondary small">
                            <div class="col-6"><b>خرید:</b> {{ $purchasedAt }}</div>
                            <div class="col-6">
                                <b>مهلت انتخاب:</b>
                                @if($hasSelectedGames)
                                    <span class="d-block text-success">بازی‌ها انتخاب شده‌اند</span>
                                    @if($selectionDelayDays > 0)
                                        <span class="d-block text-warning small">با {{ $selectionDelayDays }} روز تأخیر</span>
                                    @endif
                                    @if($subscription->games_selected_at)
                                        <span class="d-block text-secondary small">{{ Jalalian::fromCarbon($subscription->games_selected_at)->format('Y/m/d H:i') }}</span>
                                    @endif
                                @elseif($subscription->status === 'waiting')
                                    <span class="timer selection-countdown d-inline-block {{ $deadlinePassed ? 'text-danger' : '' }}" data-deadline="{{ $selectionDeadlineIso }}">{{ $deadlinePassed ? 'مهلت انتخاب به پایان رسیده' : '...' }}</span>
                                @else
                                    ---
                                @endif
                            </div>
                            <div class="col-12">
                                <b>زمان هماهنگی:</b>
                                @if($subscription->requested_at)
                                    {{ Jalalian::fromCarbon($subscription->requested_at)->format('Y/m/d H:i') }}
                                @else
                                    ---
                                @endif
                            </div>
                            <div class="col-6"><b>شروع:</b> {{ $activatedAt }}</div>
                            <div class="col-6"><b>پایان:</b> {{ $endsAtFormatted }}</div>
                            <div class="col-6">
                                <b>تا پایان اشتراک:</b>
                                @if($subscription->status === 'active' && $subscription->ends_at)
                                    @if(now()->greaterThanOrEqualTo($subscription->ends_at))
                                        <span class="text-danger fw-semibold">اشتراک به پایان رسیده</span>
                                    @else
                                        <span class="timer end-countdown d-inline-block" data-deadline="{{ $endsCountdownIso }}">...</span>
                                    @endif
                                @elseif($subscription->status === 'ended')
                                    <span class="text-muted">پایان یافته</span>
                                @else
                                    ---
                                @endif
                            </div>
                        </div>
                        <div class="mt-3">
                            <b class="text-info">بازی‌ها:</b>
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                @if($games->isEmpty())
                                    <span class="text-secondary">بازی انتخاب نشده</span>
                                @else
                                    @foreach($games as $game)
                                        <span class="game-pill">{{ $game }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="mt-3 text-secondary small">
                            <b>تا تعویض بعدی:</b>
                            @if($subscription->status === 'active' && $subscription->next_swap_at)
                                @if($swapReady)
                                    <span class="text-success fw-semibold">شما هم‌اکنون مجاز به تعویض بازی هستید</span>
                                @else
                                    <span class="timer swap-countdown" data-deadline="{{ $swapIso }}">...</span>
                                @endif
                            @elseif($subscription->status === 'active')
                                ---
                            @else
                                ---
                            @endif
                        </div>
                        <div class="mobile-actions">
                            @if($needsSelection)
                                <button class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" data-mode="initial">
                                    <i class="bi bi-list-check"></i>
                                    انتخاب بازی‌ها
                                </button>
                            @endif
                            @if($subscription->swap_every_days)
                                <button class="btn btn-sm btn-outline-info w-100 {{ $swapReady && !$hasPendingSwap ? '' : 'swap-disabled' }}" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" data-mode="swap">
                                    <i class="bi bi-arrow-repeat"></i>
                                    درخواست تعویض بازی
                                </button>
                            @endif
                            @if($hasPendingSwap)
                                <span class="text-warning small w-100 text-center">درخواست تعویض در انتظار بررسی</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($subscriptions instanceof \Illuminate\Pagination\AbstractPaginator && $subscriptions->hasPages())
                <div class="mt-3">
                    {{ $subscriptions->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    @endif
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        (function(){
            const fallbackCover = @json($gamePlaceholder);

            function buildOption(option){
                if (!option.id) { return option.text; }
                const cover = option.element?.dataset?.cover || fallbackCover;
                const wrapper = document.createElement('span');
                wrapper.className = 'd-flex align-items-center gap-2';
                const img = document.createElement('img');
                img.src = cover;
                img.alt = option.text;
                img.className = 'select2-option-cover';
                const text = document.createElement('span');
                text.textContent = option.text;
                wrapper.appendChild(img);
                wrapper.appendChild(text);
                return $(wrapper);
            }

            function buildSelection(option){
                if (!option.id) { return option.text || ''; }
                const cover = option.element?.dataset?.cover || fallbackCover;
                const wrapper = document.createElement('span');
                wrapper.className = 'd-flex align-items-center gap-2';
                const img = document.createElement('img');
                img.src = cover;
                img.alt = option.text;
                img.className = 'select2-option-cover';
                const text = document.createElement('span');
                text.textContent = option.text;
                wrapper.appendChild(img);
                wrapper.appendChild(text);
                return $(wrapper);
            }

            document.querySelectorAll('.game-select').forEach(function(select){
                const placeholder = select.dataset.placeholder || 'انتخاب بازی';
                const modal = select.closest('.modal');
                $(select).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dir: 'rtl',
                    dropdownParent: modal ? $(modal) : $(document.body),
                    placeholder: placeholder,
                    templateResult: buildOption,
                    templateSelection: buildSelection,
                    language: {
                        noResults: function(){ return 'بازی یافت نشد'; }
                    }
                });
            });

            document.querySelectorAll('.subscription-modal').forEach(function(modalEl){
                modalEl.addEventListener('show.bs.modal', function(event){
                    const trigger = event.relatedTarget;
                    const mode = trigger?.getAttribute('data-mode') || 'initial';
                    const titleEl = modalEl.querySelector('.modal-title');
                    const submitBtn = modalEl.querySelector('.submit-btn');
                    const hiddenMode = modalEl.querySelector('input[name="mode"]');
                    const bookingSection = modalEl.querySelector('.booking-section');
                    const bookingSelect = bookingSection ? bookingSection.querySelector('select[name="booking_id"]') : null;

                    if (hiddenMode) hiddenMode.value = mode;

                    if (mode === 'swap') {
                        if (titleEl) titleEl.textContent = 'درخواست تعویض بازی';
                        if (submitBtn) submitBtn.textContent = 'ارسال درخواست تعویض';
                        if (bookingSection) bookingSection.classList.add('d-none');
                        if (bookingSelect) {
                            bookingSelect.removeAttribute('required');
                            bookingSelect.disabled = true;
                            $(bookingSelect).val(null).trigger('change');
                        }
                    } else {
                        if (titleEl) titleEl.textContent = 'انتخاب بازی‌های اشتراک';
                        if (submitBtn) submitBtn.textContent = 'ثبت انتخاب';
                        if (bookingSection) bookingSection.classList.remove('d-none');
                        if (bookingSelect) {
                            bookingSelect.disabled = false;
                            bookingSelect.setAttribute('required','required');
                        }
                    }
                });

                modalEl.addEventListener('hidden.bs.modal', function(){
                    const bookingSection = modalEl.querySelector('.booking-section');
                    const bookingSelect = bookingSection ? bookingSection.querySelector('select[name="booking_id"]') : null;
                    if (bookingSection) bookingSection.classList.remove('d-none');
                    if (bookingSelect) {
                        bookingSelect.disabled = false;
                        bookingSelect.setAttribute('required','required');
                    }
                });
            });

            function formatCountdown(seconds, element){
                if (seconds <= 0) {
                    if (element.classList.contains('swap-countdown')) {
                        return 'شما هم‌اکنون مجاز به تعویض بازی هستید';
                    }
                    if (element.classList.contains('end-countdown')) {
                        return 'اشتراک به پایان رسیده';
                    }
                    return 'مهلت انتخاب به پایان رسیده';
                }
                const days = Math.floor(seconds / 86400);
                seconds %= 86400;
                const hours = Math.floor(seconds / 3600);
                seconds %= 3600;
                const minutes = Math.floor(seconds / 60);
                const secs = seconds % 60;
                const clock = `${String(hours).padStart(2,'0')}:${String(minutes).padStart(2,'0')}:${String(secs).padStart(2,'0')}`;
                return days > 0 ? `${days} روز | ${clock}` : clock;
            }

            function tick(){
                const now = Date.now();
                document.querySelectorAll('.selection-countdown, .swap-countdown, .end-countdown').forEach(function(el){
                    const deadline = el.getAttribute('data-deadline');
                    if (!deadline) {
                        el.textContent = '---';
                        return;
                    }
                    const diff = Math.floor((new Date(deadline).getTime() - now) / 1000);
                    el.textContent = formatCountdown(diff, el);
                    if (diff <= 0) {
                        if (el.classList.contains('swap-countdown')) {
                            el.classList.add('text-success', 'fw-semibold');
                        } else if (el.classList.contains('end-countdown')) {
                            el.classList.add('text-danger', 'fw-semibold');
                        } else {
                            el.classList.add('text-danger');
                        }
                    }
                });
            }

            tick();
            setInterval(tick, 1000);
        })();
    </script>
@endsection


