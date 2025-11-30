@extends('user.layouts.app')

@section('title', 'درخواست ارتقا اشتراک')

@section('extra-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <style>
        .card-glass {
            background: rgba(8,8,8,.92);
            border: 1px solid rgba(255,0,77,.18);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 30px 90px rgba(0,0,0,.6);
            backdrop-filter: blur(18px);
        }
        .section-title {
            background: linear-gradient(135deg,var(--c-primary),var(--c-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }
        .btn-upgrade {
            background: linear-gradient(135deg,var(--c-primary),var(--c-secondary));
            border: none;
            border-radius: 12px;
            color: #000;
            font-weight: 700;
            padding: .7rem 1.5rem;
            box-shadow: 0 15px 40px rgba(255,0,77,.4);
            transition: .25s ease;
        }
        .btn-upgrade:hover { transform: translateY(-2px); box-shadow: 0 20px 45px rgba(255,0,77,.55); }
        .table thead th {
            border-bottom: 1px solid rgba(255,0,77,.25);
            color: rgba(255,255,255,.85);
            font-size: .9rem;
            white-space: nowrap;
        }
        .table td,
        .table th {
            border-color: rgba(255,255,255,.05);
            vertical-align: middle;
            font-size: .95rem;
        }
        .badge-status {
            border-radius: 999px;
            padding: .35rem .9rem;
            font-size: .78rem;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,.12);
            backdrop-filter: blur(4px);
        }
        .badge-pending { background: rgba(255,193,7,.18); color: #ffbe55; }
        .badge-rejected { background: rgba(255,0,77,.2); color: #ff4d79; }
        .badge-done { background: rgba(0,255,156,.18); color: #4dffca; }
        .selected-pill {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: rgba(255,255,255,.08);
            border-radius: 999px;
            padding: .25rem .8rem;
            margin: .15rem;
            font-size: .85rem;
        }
        .table-wrapper { display: block; }
        .mobile-cards { display: none; }
        .upgrade-card {
            background: rgba(0,0,0,.55);
            border: 1px solid rgba(255,0,77,.18);
            border-radius: 18px;
            padding: 1.1rem;
            margin-bottom: 1rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.55);
        }
        .upgrade-card .card-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: .45rem;
            font-size: .9rem;
        }
        .upgrade-card .card-row span:first-child {
            color: rgba(255,255,255,.6);
        }
        @media (max-width: 992px) {
            .table-wrapper { display: none; }
            .mobile-cards { display: block; }
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }
        .empty-state .icon {
            font-size: 3rem;
            color: var(--c-primary);
            margin-bottom: 1rem;
        }
        .modal-upgrade .modal-content {
            background: linear-gradient(135deg, rgba(5,5,5,.95), rgba(25,0,15,.9));
            border-radius: 20px;
            border: 1px solid rgba(255,0,77,.25);
            box-shadow: 0 35px 90px rgba(0,0,0,.65);
        }
        .modal-upgrade .modal-header,
        .modal-upgrade .modal-footer {
            border-color: rgba(255,0,77,.2);
            background: rgba(255,0,77,.05);
        }
        .modal-upgrade .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4 gap-2">
        <div>
            <h3 class="section-title mb-1">درخواست ارتقا</h3>
            <p class="text-secondary mb-0">یکی از اشتراک‌های فعال خود را انتخاب کنید، پلن جدید و بازی‌های مدنظر را بنویسید و منتظر تایید پشتیبانی بمانید.</p>
        </div>
        <button class="btn-upgrade" data-bs-toggle="modal" data-bs-target="#upgradeModal">
            <i class="bi bi-arrow-up-right-circle me-1"></i>
            ثبت درخواست ارتقا
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card-glass">
        @if($requests->isEmpty())
            <div class="empty-state">
                <div class="icon"><i class="bi bi-rocket"></i></div>
                <h5 class="text-light">هیچ درخواست ارتقایی ثبت نشده است</h5>
                <p class="text-secondary mb-0">با کلیک روی دکمه بالا اولین درخواست خود را ارسال کنید.</p>
            </div>
        @else
            <div class="table-responsive table-wrapper">
                <table class="table table-dark align-middle mb-0">
                    <thead>
                        <tr>
                            <th>شماره درخواست</th>
                            <th>اشتراک انتخاب‌شده</th>
                            <th>پلن درخواستی</th>
                            <th>مدت</th>
                            <th>بازی‌ها</th>
                            <th>توضیحات</th>
                            <th>تاریخ درخواست</th>
                            <th>وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                            <tr>
                                <td class="fw-semibold">{{ $request->request_number }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $request->subscription->subscription_code ?? '---' }}</div>
                                    <small class="text-secondary">{{ $request->subscription->plan->name ?? '---' }}</small>
                                </td>
                                <td>{{ $request->requestedPlan->name ?? '---' }}</td>
                                <td>{{ $request->requested_duration ? $request->requested_duration . ' ماهه' : '---' }}</td>
                                <td>
                                    @forelse(($request->selected_games ?? []) as $game)
                                        <span class="selected-pill">{{ $game }}</span>
                                    @empty
                                        <span class="text-secondary">ثبت نشده</span>
                                    @endforelse
                                </td>
                                <td>{{ $request->description ?? '---' }}</td>
                                <td>{{ $request->created_at ? \Morilog\Jalali\Jalalian::fromCarbon($request->created_at)->format('Y/m/d H:i') : '---' }}</td>
                                <td>
                                    @php
                                        $statusKey = $request->status;
                                        $statusLabel = $statusMap[$statusKey] ?? $statusKey;
                                        $badgeClass = match($statusKey) {
                                            \App\Models\UpgradeRequest::STATUS_DONE => 'badge-done',
                                            \App\Models\UpgradeRequest::STATUS_REJECTED => 'badge-rejected',
                                            default => 'badge-pending',
                                        };
                                    @endphp
                                    <span class="badge-status {{ $badgeClass }}">{{ $statusLabel }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mobile-cards d-lg-none">
                @foreach($requests as $request)
                    @php
                        $statusKey = $request->status;
                        $statusLabel = $statusMap[$statusKey] ?? $statusKey;
                        $badgeClass = match($statusKey) {
                            \App\Models\UpgradeRequest::STATUS_DONE => 'badge-done',
                            \App\Models\UpgradeRequest::STATUS_REJECTED => 'badge-rejected',
                            default => 'badge-pending',
                        };
                    @endphp
                    <div class="upgrade-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="fw-semibold">{{ $request->request_number }}</div>
                                <small class="text-secondary">{{ $request->created_at ? \Morilog\Jalali\Jalalian::fromCarbon($request->created_at)->format('Y/m/d H:i') : '---' }}</small>
                            </div>
                            <span class="badge-status {{ $badgeClass }}">{{ $statusLabel }}</span>
                        </div>
                        <div class="card-row">
                            <span>اشتراک</span>
                            <span class="text-light">{{ $request->subscription->subscription_code ?? '---' }}</span>
                        </div>
                        <div class="card-row">
                            <span>پلن درخواستی</span>
                            <span>{{ $request->requestedPlan->name ?? '---' }}</span>
                        </div>
                        <div class="card-row">
                            <span>مدت</span>
                            <span>{{ $request->requested_duration ? $request->requested_duration . ' ماهه' : '---' }}</span>
                        </div>
                        <div class="card-row">
                            <span>بازی‌ها</span>
                            <span class="text-light">
                                @if($request->selected_games)
                                    {{ implode(', ', $request->selected_games) }}
                                @else
                                    ---
                                @endif
                            </span>
                        </div>
                        <div class="card-row">
                            <span>توضیحات</span>
                            <span>{{ $request->description ?? '---' }}</span>
                        </div>
                        <div class="card-row">
                            <span>تاریخ درخواست</span>
                            <span>{{ $request->created_at ? \Morilog\Jalali\Jalalian::fromCarbon($request->created_at)->format('Y/m/d H:i') : '---' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                {{ $requests->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <div class="modal fade modal-upgrade" id="upgradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content text-light">
                <div class="modal-header">
                    <h5 class="modal-title">ثبت درخواست ارتقا</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('user.upgrade_requests.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">انتخاب اشتراک</label>
                    <select class="form-select" name="subscription_id" id="subscriptionSelect" required>
                        <option value="">یکی از اشتراک‌ها...</option>
                        @foreach($subscriptions as $subscription)
                            @php
                                $label = ($subscription->subscription_code ?? '---') . ' | ' . ($subscription->plan->name ?? 'بدون پلن');
                            @endphp
                            <option value="{{ $subscription->id }}" {{ old('subscription_id') == $subscription->id ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">پلن درخواستی</label>
                    <select class="form-select" name="requested_plan_id" id="requestedPlan" required disabled>
                        <option value="">ابتدا اشتراک را انتخاب کنید</option>
                    </select>
                    <small class="text-secondary d-block mt-1" id="planHelp">فقط پلن‌های بالاتر نمایش داده می‌شوند.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">مدت پلن درخواستی</label>
                    <select class="form-select" name="requested_duration" id="requestedDuration" required disabled>
                        <option value="">ابتدا پلن را انتخاب کنید</option>
                    </select>
                    <small class="text-secondary d-block mt-1" id="durationHelp">پس از انتخاب پلن، مدت‌های مجاز نمایش داده می‌شود.</small>
                </div>
                            <div class="col-12">
                                <label class="form-label">انتخاب بازی‌ها</label>
                                <p class="text-secondary small mb-2">با توجه به پلن انتخابی، تعداد بازی‌های سطح ۱ و سایر بازی‌ها نمایش داده می‌شود.</p>
                                <div id="gameFieldsContainer" class="row g-3">
                                    <div class="col-12 text-secondary placeholder-text">ابتدا پلن درخواستی را انتخاب کنید.</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">توضیحات تکمیلی</label>
                                <textarea class="form-control" rows="3" name="description" placeholder="جزئیات مدنظر خود را بنویسید...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">انصراف</button>
                        <button type="submit" class="btn-upgrade">ارسال درخواست</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        (function(){
            const planMeta = @json($planMetaById);
            const level1Games = @json($level1Games);
            const otherGames = @json($otherGames);
            const allGames = (() => {
                const map = new Map();
                [...level1Games, ...otherGames].forEach(game => {
                    if (!map.has(game.id)) {
                        map.set(game.id, game);
                    }
                });
                return Array.from(map.values());
            })();
            const availablePlansBySubscription = @json($upgradeablePlans);
            const previousGames = {
                level1: @json(old('games.level1', [])),
                other: @json(old('games.other', [])),
            };
            let previousPlanId = '{{ old('requested_plan_id') }}';
            let durationPreset = '{{ old('requested_duration') }}';

            const subscriptionSelect = document.getElementById('subscriptionSelect');
            const planSelect = document.getElementById('requestedPlan');
            const planHelp = document.getElementById('planHelp');
            const durationSelect = document.getElementById('requestedDuration');
            const durationHelp = document.getElementById('durationHelp');
            const gameFieldsContainer = document.getElementById('gameFieldsContainer');
            let usedGameDefaults = false;

            function initSelect2(select) {
                $(select).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dir: 'rtl',
                    dropdownParent: $('#upgradeModal'),
                    placeholder: select.dataset.placeholder || 'انتخاب کنید'
                });
            }

            subscriptionSelect?.addEventListener('change', event => {
                previousPlanId = '';
                durationPreset = '';
                updatePlanSelect(event.target.value);
            });

            planSelect?.addEventListener('change', event => {
                updateDurationOptions(event.target.value);
                renderGameFields(event.target.value);
            });

            updatePlanSelect(subscriptionSelect?.value || '');

            function updatePlanSelect(subscriptionId) {
                planSelect.innerHTML = '';
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = subscriptionId ? 'انتخاب پلن...' : 'ابتدا اشتراک را انتخاب کنید';
                planSelect.appendChild(placeholder);

                if (!subscriptionId) {
                    planSelect.disabled = true;
                    planHelp.textContent = 'ابتدا اشتراک فعال خود را انتخاب کنید.';
                    updateDurationOptions(null);
                    renderGameFields(null);
                    return;
                }

                const plans = availablePlansBySubscription[subscriptionId] || [];
                if (!plans.length) {
                    planSelect.disabled = true;
                    planHelp.textContent = 'پلن بالاتری برای این اشتراک موجود نیست.';
                    updateDurationOptions(null);
                    renderGameFields(null);
                    return;
                }

                plans.forEach(plan => {
                    const option = document.createElement('option');
                    option.value = plan.id;
                    option.textContent = plan.name;
                    planSelect.appendChild(option);
                });

                planSelect.disabled = false;
                planHelp.textContent = 'فقط پلن‌های بالاتر نمایش داده شده‌اند.';

                if (previousPlanId && plans.some(plan => String(plan.id) === String(previousPlanId))) {
                    planSelect.value = previousPlanId;
                    updateDurationOptions(previousPlanId);
                    renderGameFields(previousPlanId);
                    previousPlanId = '';
                } else {
                    planSelect.value = '';
                    updateDurationOptions(null);
                    renderGameFields(null);
                }
            }

            function updateDurationOptions(planId) {
                durationSelect.innerHTML = '';
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = planId ? 'انتخاب مدت...' : 'ابتدا پلن را انتخاب کنید';
                durationSelect.appendChild(placeholder);

                if (!planId) {
                    durationSelect.disabled = true;
                    durationHelp.textContent = 'ابتدا پلن را انتخاب کنید.';
                    return;
                }

                const meta = planMeta[planId] || {};
                const durations = meta.durations || [];

                if (!durations.length) {
                    durationSelect.disabled = true;
                    durationHelp.textContent = 'برای این پلن مدت مجاز ثبت نشده است.';
                    return;
                }

                durations.forEach(duration => {
                    const option = document.createElement('option');
                    option.value = duration;
                    option.textContent = duration + ' ماهه';
                    if (durationPreset && String(duration) === String(durationPreset)) {
                        option.selected = true;
                    }
                    durationSelect.appendChild(option);
                });

                durationSelect.disabled = false;
                durationHelp.textContent = 'مدت دلخواه را انتخاب کنید.';

                if (!durationPreset || !durations.some(duration => String(duration) === String(durationPreset))) {
                    durationSelect.value = '';
                }

                durationPreset = '';
            }

            function renderGameFields(planId) {
                if (!planId) {
                    gameFieldsContainer.innerHTML = '<div class="col-12 text-secondary">ابتدا پلن درخواستی را انتخاب کنید.</div>';
                    return;
                }

                const meta = planMeta[planId] || { level1_selection: 0, concurrent_games: 0 };
                const level1Count = Math.max(0, meta.level1_selection || 0);
                const totalSlots = Math.max(0, meta.concurrent_games || 0);
                const otherCount = Math.max(totalSlots - level1Count, 0);

                let defaults = { level1: [], other: [] };
                if (!usedGameDefaults) {
                    defaults = previousGames;
                    usedGameDefaults = true;
                }

                gameFieldsContainer.innerHTML = '';

                if ((level1Count + otherCount) === 0) {
                    gameFieldsContainer.innerHTML = '<div class="col-12 text-warning">برای پلن انتخابی ظرفیتی برای ثبت بازی در نظر گرفته نشده است.</div>';
                    return;
                }

                const buildSelect = (name, placeholder, list, selectedValue) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'col-md-6';
                    const label = document.createElement('label');
                    label.className = 'form-label text-info';
                    label.textContent = placeholder;
                    const select = document.createElement('select');
                    select.className = 'form-select game-select';
                    select.name = name;
                    select.dataset.placeholder = placeholder;

                    const emptyOption = document.createElement('option');
                    emptyOption.value = '';
                    emptyOption.textContent = '-- انتخاب --';
                    select.appendChild(emptyOption);

                    list.forEach(game => {
                        const option = document.createElement('option');
                        option.value = game.id;
                        option.textContent = game.name;
                        option.dataset.cover = game.cover_url;
                        if (String(game.id) === String(selectedValue)) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });

                    wrapper.appendChild(label);
                    wrapper.appendChild(select);
                    gameFieldsContainer.appendChild(wrapper);
                    initSelect2(select);
                };

                for (let i = 0; i < level1Count; i++) {
                    buildSelect(
                        'games[level1][]',
                        `انتخاب بازی سطح ۱ (${i + 1})`,
                        allGames,
                        defaults.level1?.[i] ?? ''
                    );
                }

                for (let i = 0; i < otherCount; i++) {
                    buildSelect(
                        'games[other][]',
                        `انتخاب سایر بازی‌ها (${i + 1})`,
                        otherGames,
                        defaults.other?.[i] ?? ''
                    );
                }
            }

            if (!planSelect?.value) {
                renderGameFields(null);
            }
        })();
    </script>
@endpush
