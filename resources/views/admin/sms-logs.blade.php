@extends('admin.layouts.app')
@section('title','گزارش پیامک‌ها')

@php
    use Morilog\Jalali\Jalalian;

    $statusLabels = [
        'sent'           => 'ارسال شده',
        'queued'         => 'در صف ارسال',
        'pending'        => 'در انتظار ارسال',
        'failed'         => 'ناموفق',
        'curl_error'     => 'خطای ارتباطی',
        'missing_config' => 'تنظیمات ناقص',
    ];

    $statusStyles = [
        'sent'           => 'bg-success text-dark',
        'queued'         => 'bg-warning text-dark',
        'pending'        => 'bg-warning text-dark',
        'failed'         => 'bg-danger',
        'curl_error'     => 'bg-danger',
        'missing_config' => 'bg-secondary',
    ];

    $purposeLabels = [
        'otp'                => 'ارسال کد تایید',
        'payment_success'    => 'پرداخت موفق',
        'payment_failed'     => 'پرداخت ناموفق',
        'subscription_alert' => 'اعلان اشتراک',
        'custom'             => 'پیام سفارشی',
    ];
@endphp

@section('content')
<style>
    .card-glass{background:var(--panel);border:1px solid var(--border);border-radius:14px;padding:1rem;}
    .section-title{background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-weight:800;}
    .table-scroll{overflow-x:auto;}
    .badge-status{border-radius:999px;padding:.25rem .7rem;font-weight:600;font-size:.85rem;}
    .mobile-cards{display:none;}
    .table td div small{white-space:normal;}

    .sms-card{display:flex;flex-direction:column;gap:1rem;background:rgba(255,255,255,.05);border:1px solid var(--border);border-radius:16px;padding:1.1rem;}
    [data-theme="light"] .sms-card{background:#fff;}
    .sms-card-header{display:flex;justify-content:space-between;align-items:flex-start;gap:.75rem;}
    .sms-card-number{font-weight:700;font-size:1.05rem;word-break:break-word;}
    .sms-card-tag{color:var(--muted);font-size:.8rem;margin-top:.25rem;display:block;word-break:break-word;}
    .sms-card-badge{align-self:flex-start;}
    .sms-meta-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
    .sms-meta-item{display:flex;flex-direction:column;gap:.3rem;background:rgba(255,255,255,.04);border:1px solid var(--border);border-radius:10px;padding:.65rem;}
    [data-theme="light"] .sms-meta-item{background:#f8fafc;}
    .meta-label{color:var(--muted);font-size:.8rem;}
    .meta-value{font-weight:600;font-size:.92rem;line-height:1.6;word-break:break-word;overflow-wrap:anywhere;}
    .sms-card-message{background:rgba(0,0,0,.25);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:.75rem;white-space:pre-wrap;line-height:1.8;word-break:break-word;overflow-wrap:anywhere;}
    [data-theme="light"] .sms-card-message{background:#f4f7fb;border-color:#e5e7eb;}
    .sms-related{display:flex;flex-wrap:wrap;gap:.4rem;}
    .sms-related span{background:rgba(255,255,255,.08);border:1px solid var(--border);border-radius:8px;padding:.25rem .55rem;font-size:.82rem;}
    [data-theme="light"] .sms-related span{background:#eef2ff;}
    .divider{border-top:1px solid var(--border);}

    @media(max-width:992px){
        .desktop-table{display:none;}
        .mobile-cards{display:block;}
    }
</style>

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <h4 class="section-title m-0">گزارش پیامک‌های ارسال شده</h4>
</div>

<div class="card-glass mb-3">
    <form method="GET" action="{{ route('admin.sms_logs.index') }}">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">جستجو</label>
                <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="شماره موبایل، متن پیام یا شناسه پیگیری">
            </div>
            <div class="col-md-2">
                <label class="form-label">وضعیت</label>
                <select name="status" class="form-select">
                    <option value="">همه</option>
                    @foreach($statusLabels as $key => $label)
                        <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">درگاه / سرویس</label>
                <input type="text" name="gateway" class="form-control" value="{{ $gateway }}" placeholder="مثلاً: farapayamak">
            </div>
            <div class="col-md-2">
                <label class="form-label">از تاریخ</label>
                <input type="date" name="from" class="form-control" value="{{ $dateFrom }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">تا تاریخ</label>
                <input type="date" name="to" class="form-control" value="{{ $dateTo }}">
            </div>
            <div class="col-md-1 text-end ms-auto">
                <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search"></i> فیلتر</button>
            </div>
        </div>
    </form>
</div>

<div class="card-glass">
    <div class="desktop-table">
        <div class="table-scroll">
            <table class="table table-dark align-middle mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th>شماره</th>
                    <th>کاربر</th>
                    <th>هدف</th>
                    <th>درگاه</th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>
                    <th class="text-center">جزئیات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($logs as $index => $log)
                    @php
                        $createdAt = $log->created_at ? Jalalian::fromCarbon($log->created_at)->format('Y/m/d H:i') : '---';
                        $statusKey = $log->status ?? '';
                        $badgeClass = $statusStyles[$statusKey] ?? 'bg-dark';
                        $statusLabel = $statusLabels[$statusKey] ?? ($statusKey ?: 'نامشخص');
                        $purposeLabel = $log->purpose ? ($purposeLabels[$log->purpose] ?? $log->purpose) : '---';
                    @endphp
                    <tr>
                        <td>{{ $logs->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-semibold">{{ $log->mobile ?? '---' }}</div>
                            @if($log->track_id)
                                <small class="text-muted d-block">شناسه: {{ $log->track_id }}</small>
                            @endif
                        </td>
                        <td>
                            @if($log->user)
                                <div class="fw-semibold">{{ $log->user->name ?? 'بدون نام' }}</div>
                                @if($log->user->phone)
                                    <small class="text-muted d-block">{{ $log->user->phone }}</small>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $purposeLabel }}</td>
                        <td>{{ $log->gateway ?: '-' }}</td>
                        <td><span class="badge badge-status {{ $badgeClass }}">{{ $statusLabel }}</span></td>
                        <td>{{ $createdAt }}</td>
                        <td class="text-center">
                            <button
                                class="btn btn-sm btn-outline-info"
                                data-bs-toggle="modal"
                                data-bs-target="#smsDetailModal"
                                data-mobile="{{ $log->mobile ?? '---' }}"
                                data-track="{{ $log->track_id ?? '' }}"
                                data-user="{{ $log->user?->name ?? '---' }}"
                                data-user-phone="{{ $log->user?->phone ?? '' }}"
                                data-purpose="{{ $purposeLabel }}"
                                data-gateway="{{ $log->gateway ?: '-' }}"
                                data-status="{{ $statusLabel }}"
                                data-status-color="{{ $badgeClass }}"
                                data-provider-status="{{ $log->provider_status ?: '-' }}"
                                data-message="{{ e($log->message ?? '---') }}"
                                data-response="{{ e($log->provider_response ?? '---') }}"
                                data-created="{{ $createdAt }}"
                                data-transaction="{{ $log->transaction?->txn_number ?? '' }}"
                                data-subscription="{{ $log->subscription?->subscription_code ?? '' }}"
                            >
                                مشاهده
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">هیچ پیامکی ثبت نشده است.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mobile-cards">
        @forelse($logs as $log)
            @php
                $createdAt = $log->created_at ? Jalalian::fromCarbon($log->created_at)->format('Y/m/d H:i') : '---';
                $statusKey = $log->status ?? '';
                $badgeClass = $statusStyles[$statusKey] ?? 'bg-dark';
                $statusLabel = $statusLabels[$statusKey] ?? ($statusKey ?: 'نامشخص');
                $purposeLabel = $log->purpose ? ($purposeLabels[$log->purpose] ?? $log->purpose) : '---';
            @endphp
            <div class="sms-card">
                <div class="sms-card-header">
                    <div>
                        <div class="sms-card-number">{{ $log->mobile ?? '---' }}</div>
                        @if($log->track_id)
                            <span class="sms-card-tag">شناسه پیگیری: {{ $log->track_id }}</span>
                        @endif
                    </div>
                    <span class="badge badge-status {{ $badgeClass }} sms-card-badge">{{ $statusLabel }}</span>
                </div>

                <div class="sms-meta-grid">
                    <div class="sms-meta-item">
                        <span class="meta-label">تاریخ ثبت</span>
                        <span class="meta-value">{{ $createdAt }}</span>
                    </div>
                    <div class="sms-meta-item">
                        <span class="meta-label">هدف ارسال</span>
                        <span class="meta-value">{{ $purposeLabel }}</span>
                    </div>
                    <div class="sms-meta-item">
                        <span class="meta-label">کاربر</span>
                        <span class="meta-value">
                            @if($log->user)
                                {{ $log->user->name ?? 'بدون نام' }}
                                @if($log->user->phone)
                                    <small class="d-block text-muted">{{ $log->user->phone }}</small>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </span>
                    </div>
                    <div class="sms-meta-item">
                        <span class="meta-label">درگاه / سرویس</span>
                        <span class="meta-value">{{ $log->gateway ?: '-' }}</span>
                    </div>
                    <div class="sms-meta-item">
                        <span class="meta-label">وضعیت سرویس</span>
                        <span class="meta-value">{{ $log->provider_status ?: '-' }}</span>
                    </div>
                </div>

                <div>
                    <span class="meta-label d-block mb-2">متن پیامک</span>
                    <div class="sms-card-message">{{ $log->message ?: '---' }}</div>
                </div>

                @if($log->transaction || $log->subscription)
                    <div class="divider"></div>
                    <div class="sms-related">
                        @if($log->transaction)
                            <span>تراکنش: {{ $log->transaction->txn_number ?? '-' }}</span>
                        @endif
                        @if($log->subscription)
                            <span>اشتراک: {{ $log->subscription->subscription_code ?? '-' }}</span>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center text-muted py-4">هیچ پیامکی ثبت نشده است.</div>
        @endforelse
    </div>

    <div class="mt-3">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
</div>

<div class="modal fade" id="smsDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background:linear-gradient(135deg, rgba(18,24,54,.97), rgba(30,16,66,.95));color:var(--text);border:1px solid var(--border);">
            <div class="modal-header border-0">
                <h5 class="modal-title">جزئیات پیامک</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="meta-label">شماره موبایل</div>
                        <div class="fw-semibold" id="detail-mobile">---</div>
                    </div>
                    <div class="col-md-6">
                        <div class="meta-label">شناسه پیگیری</div>
                        <div id="detail-track">---</div>
                    </div>
                    <div class="col-md-6">
                        <div class="meta-label">کاربر</div>
                        <div id="detail-user">---</div>
                    </div>
                    <div class="col-md-6">
                        <div class="meta-label">هدف ارسال</div>
                        <div id="detail-purpose">---</div>
                    </div>
                    <div class="col-md-4">
                        <div class="meta-label">وضعیت</div>
                        <div id="detail-status" class="badge badge-status bg-secondary">---</div>
                    </div>
                    <div class="col-md-4">
                        <div class="meta-label">درگاه</div>
                        <div id="detail-gateway">---</div>
                    </div>
                    <div class="col-md-4">
                        <div class="meta-label">وضعیت سرویس</div>
                        <div id="detail-provider-status">---</div>
                    </div>
                    <div class="col-md-6">
                        <div class="meta-label">تاریخ ثبت</div>
                        <div id="detail-created">---</div>
                    </div>
                    <div class="col-md-6">
                        <div class="meta-label">مرتبط با</div>
                        <div id="detail-related">---</div>
                    </div>
                    <div class="col-12">
                        <div class="meta-label">متن پیامک</div>
                        <pre class="sms-card-message bg-dark text-white" id="detail-message">---</pre>
                    </div>
                    <div class="col-12">
                        <div class="meta-label">پاسخ سرویس</div>
                        <pre class="sms-card-message bg-dark text-white" id="detail-response">---</pre>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const detailModal = document.getElementById('smsDetailModal');
    detailModal?.addEventListener('show.bs.modal', event => {
        const btn = event.relatedTarget;
        if (!btn) return;

        const mobile = btn.getAttribute('data-mobile') || '---';
        const track  = btn.getAttribute('data-track') || '---';
        const user   = btn.getAttribute('data-user') || '---';
        const userPhone = btn.getAttribute('data-user-phone');
        const purpose = btn.getAttribute('data-purpose') || '---';
        const status = btn.getAttribute('data-status') || '---';
        const statusColor = btn.getAttribute('data-status-color') || 'bg-secondary';
        const gateway = btn.getAttribute('data-gateway') || '---';
        const providerStatus = btn.getAttribute('data-provider-status') || '---';
        const created = btn.getAttribute('data-created') || '---';
        const message = btn.getAttribute('data-message') || '---';
        const response = btn.getAttribute('data-response') || '---';
        const txn = btn.getAttribute('data-transaction');
        const sub = btn.getAttribute('data-subscription');

        document.getElementById('detail-mobile').textContent = mobile;
        document.getElementById('detail-track').textContent = track || '---';
        document.getElementById('detail-user').textContent = user === '---'
            ? '---'
            : `${user}${userPhone ? ' | ' + userPhone : ''}`;

        const statusEl = document.getElementById('detail-status');
        statusEl.textContent = status;
        statusEl.className = `badge badge-status ${statusColor}`;

        document.getElementById('detail-gateway').textContent = gateway;
        document.getElementById('detail-provider-status').textContent = providerStatus;
        document.getElementById('detail-created').textContent = created;
        document.getElementById('detail-message').textContent = message;
        document.getElementById('detail-response').textContent = response;

        let related = [];
        if (txn) related.push(`تراکنش: ${txn}`);
        if (sub) related.push(`اشتراک: ${sub}`);
        document.getElementById('detail-related').textContent = related.length ? related.join(' | ') : '---';
    });
</script>
@endpush
@endsection
