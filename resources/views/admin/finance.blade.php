{{-- resources/views/admin/finance.blade.php --}}
@extends('admin.layouts.app')
@section('title','گزارش مالی')

@php
    use Morilog\Jalali\Jalalian;
@endphp

@section('content')
<style>
    .card-glass{background:var(--panel);border:1px solid var(--border);border-radius:14px;padding:1rem}
    .section-title{background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-weight:800}
    .neon-btn{background:var(--grad);border:none;border-radius:12px;color:#0a0e27;font-weight:700;padding:.55rem 1rem;box-shadow:0 0 20px rgba(0,255,255,.25)}
    .table thead th{border-bottom:1px solid var(--border)}
    .table td,.table th{border-color:var(--border);vertical-align:middle}
    .badge-status{border-radius:999px}
    .table-scroll{overflow-x:auto}
    .receipt-row dt{color:var(--muted);min-width:110px}
    @media (max-width: 768px){
        .desktop-table{display:none}
        .mobile-cards{display:block}
    }
    @media (min-width: 769px){
        .desktop-table{display:block}
        .mobile-cards{display:none}
    }
</style>

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <h4 class="section-title m-0">گزارش مالی</h4>
</div>

{{-- فیلترهای ساده (اختیاری) --}}
<div class="card-glass mb-3">
    <form method="GET" action="{{ route('admin.finance') }}">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">جستجو</label>
                <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="شماره تراکنش/کد مرجع/نام/موبایل">
            </div>
            <div class="col-md-2">
                <label class="form-label">وضعیت</label>
                <select name="status" class="form-select">
                    <option value="">همه</option>
                    @foreach(['success'=>'موفق','pending'=>'در انتظار','failed'=>'ناموفق','refunded'=>'برگشت شده'] as $key=>$label)
                        <option value="{{ $key }}" {{ ($status??'')===$key ? 'selected':'' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">درگاه</label>
                <input type="text" name="gateway" class="form-control" value="{{ $gateway ?? '' }}" placeholder="مثلاً zarinpal">
            </div>
            <div class="col-md-2">
                <label class="form-label">از تاریخ</label>
                <input type="date" name="from" class="form-control" value="{{ $dateFrom ?? '' }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">تا تاریخ</label>
                <input type="date" name="to" class="form-control" value="{{ $dateTo ?? '' }}">
            </div>
            <div class="col-md-1 text-end">
                <button class="neon-btn w-100" type="submit"><i class="bi bi-filter"></i> اعمال</button>
            </div>
        </div>
    </form>
</div>

{{-- پیام‌ها --}}
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

<div class="card-glass">

    {{-- جدول دسکتاپ --}}
    <div class="desktop-table">
        <div class="table-scroll">
            <table class="table table-dark align-middle mb-0" style="min-width:980px;">
                <thead>
                <tr>
                    <th>شماره تراکنش</th>
                    <th>فعالیت</th>
                    <th>نام پلن</th>
                    <th>کاربر</th>
                    <th>مبلغ</th>
                    <th>تاریخ و ساعت</th>
                    <th>درگاه</th>
                    <th>وضعیت</th>
                    <th>رسید</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transactions as $tx)
                    <tr>
                        <td class="fw-semibold">{{ $tx->txn_number }}</td>
                        <td>{{ $tx->activity }}</td>
                        <td>{{ $tx->plan?->name ?? '—' }}</td>
                        <td>
                            {{ $tx->user?->name ?? '—' }}
                            <div class="small text-muted">{{ $tx->user?->phone }}</div>
                        </td>
                        <td>{{ number_format($tx->amount) }}</td>
                        <td>
                            @if($tx->paid_at)
                                {{ Jalalian::fromCarbon($tx->paid_at)->format('Y/m/d H:i') }}
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $tx->gateway ?: '—' }}</td>
                        <td>
                            @php
                                $badge = match($tx->status) {
                                    'success'  => 'success',
                                    'pending'  => 'warning text-dark',
                                    'failed'   => 'danger',
                                    'refunded' => 'secondary',
                                    default    => 'secondary'
                                };
                                $label = [
                                    'success'=>'موفق','pending'=>'در انتظار','failed'=>'ناموفق','refunded'=>'برگشت شده'
                                ][$tx->status] ?? $tx->status;
                            @endphp
                            <span class="badge bg-{{ $badge }} badge-status">{{ $label }}</span>
                        </td>
                        <td>
                            <button
                                class="btn btn-sm btn-outline-info"
                                data-bs-toggle="modal" data-bs-target="#receiptModal"
                                data-txn="{{ $tx->txn_number }}"
                                data-activity="{{ $tx->activity }}"
                                data-plan="{{ $tx->plan?->name ?? '—' }}"
                                data-user="{{ ($tx->user?->name ?? '—').' ('.($tx->user?->phone ?? '—').')' }}"
                                data-amount="{{ number_format($tx->amount) }}"
                                data-datetime="{{ $tx->paid_at ? Jalalian::fromCarbon($tx->paid_at)->format('Y/m/d H:i') : '—' }}"
                                data-gateway="{{ $tx->gateway ?: '—' }}"
                                data-status="{{ $label }}"
                                data-ref="{{ $tx->ref_code ?: '—' }}"
                                data-receipt='@json($tx->receipt)'>
                                <i class="bi bi-receipt"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">تراکنشی ثبت نشده است.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $transactions->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- کارت‌های موبایل --}}
    <div class="mobile-cards">
        @forelse($transactions as $tx)
            <div class="card-glass mb-2">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="fw-bold">{{ $tx->txn_number }}</div>
                        <div class="small text-muted">{{ $tx->activity }}</div>
                    </div>
                    <div>
                        @php
                            $badge = match($tx->status) {
                                'success'  => 'success',
                                'pending'  => 'warning text-dark',
                                'failed'   => 'danger',
                                'refunded' => 'secondary',
                                default    => 'secondary'
                            };
                            $label = [
                                'success'=>'موفق','pending'=>'در انتظار','failed'=>'ناموفق','refunded'=>'برگشت شده'
                            ][$tx->status] ?? $tx->status;
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                    </div>
                </div>
                <div class="mt-2 small">
                    <div><b>پلن:</b> {{ $tx->plan?->name ?? '—' }}</div>
                    <div><b>کاربر:</b> {{ $tx->user?->name ?? '—' }} ({{ $tx->user?->phone }})</div>
                    <div><b>مبلغ:</b> {{ number_format($tx->amount) }}</div>
                    <div><b>زمان:</b> {{ $tx->paid_at ? Jalalian::fromCarbon($tx->paid_at)->format('Y/m/d H:i') : '—' }}</div>
                    <div><b>درگاه:</b> {{ $tx->gateway ?: '—' }}</div>
                </div>
                <div class="text-end mt-2">
                    <button
                        class="btn btn-sm btn-outline-info"
                        data-bs-toggle="modal" data-bs-target="#receiptModal"
                        data-txn="{{ $tx->txn_number }}"
                        data-activity="{{ $tx->activity }}"
                        data-plan="{{ $tx->plan?->name ?? '—' }}"
                        data-user="{{ ($tx->user?->name ?? '—').' ('.($tx->user?->phone ?? '—').')' }}"
                        data-amount="{{ number_format($tx->amount) }}"
                        data-datetime="{{ $tx->paid_at ? Jalalian::fromCarbon($tx->paid_at)->format('Y/m/d H:i') : '—' }}"
                        data-gateway="{{ $tx->gateway ?: '—' }}"
                        data-status="{{ $label }}"
                        data-ref="{{ $tx->ref_code ?: '—' }}"
                        data-receipt='@json($tx->receipt)'>
                        <i class="bi bi-receipt"></i> رسید
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">تراکنشی یافت نشد.</div>
        @endforelse

        <div class="mt-3">
            {{ $transactions->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- مودال رسید --}}
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="background:linear-gradient(135deg, rgba(18, 24, 54, .97), rgba(30, 16, 66, .95)); color:var(--text); border:1px solid var(--border)">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="receiptModalLabel">رسید تراکنش</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <dl class="row receipt-row">
                    <dt class="col-sm-3">شماره تراکنش</dt><dd class="col-sm-9" id="rc-txn">—</dd>
                    <dt class="col-sm-3">فعالیت</dt>       <dd class="col-sm-9" id="rc-activity">—</dd>
                    <dt class="col-sm-3">پلن</dt>          <dd class="col-sm-9" id="rc-plan">—</dd>
                    <dt class="col-sm-3">کاربر</dt>        <dd class="col-sm-9" id="rc-user">—</dd>
                    <dt class="col-sm-3">مبلغ</dt>         <dd class="col-sm-9" id="rc-amount">—</dd>
                    <dt class="col-sm-3">تاریخ/ساعت</dt>   <dd class="col-sm-9" id="rc-datetime">—</dd>
                    <dt class="col-sm-3">درگاه</dt>        <dd class="col-sm-9" id="rc-gateway">—</dd>
                    <dt class="col-sm-3">وضعیت</dt>        <dd class="col-sm-9" id="rc-status">—</dd>
                    <dt class="col-sm-3">کد مرجع</dt>      <dd class="col-sm-9" id="rc-ref">—</dd>
                </dl>
                <hr class="my-3" style="border-color:var(--border)">
                <div>
                    <div class="fw-bold mb-2">جزئیات خام رسید (JSON)</div>
                    <pre id="rc-json" class="bg-dark text-white p-2 rounded" style="white-space:pre-wrap;max-height:240px;overflow:auto;">—</pre>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-outline-light" id="rc-print"><i class="bi bi-printer"></i> چاپ</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
            </div>
        </div>
    </div>
</div>




<script>
document.getElementById('receiptModal')?.addEventListener('show.bs.modal', function (ev){
    const btn = ev.relatedTarget;
    // پر کردن فیلدها از data-*
    const set = (id,val)=>document.getElementById(id).textContent = (val ?? '—');

    set('rc-txn',      btn.getAttribute('data-txn'));
    set('rc-activity', btn.getAttribute('data-activity'));
    set('rc-plan',     btn.getAttribute('data-plan'));
    set('rc-user',     btn.getAttribute('data-user'));
    set('rc-amount',   btn.getAttribute('data-amount'));
    set('rc-datetime', btn.getAttribute('data-datetime'));
    set('rc-gateway',  btn.getAttribute('data-gateway'));
    set('rc-status',   btn.getAttribute('data-status'));
    set('rc-ref',      btn.getAttribute('data-ref'));

    const raw = btn.getAttribute('data-receipt');
    try {
        const obj = raw ? JSON.parse(raw) : null;
        document.getElementById('rc-json').textContent = obj ? JSON.stringify(obj, null, 2) : '—';
    } catch(e){
        document.getElementById('rc-json').textContent = raw || '—';
    }
});

// چاپ رسید (یک چاپ ساده‌ی محتوا)
document.getElementById('rc-print')?.addEventListener('click', function(){
    const w = window.open('', '', 'width=900,height=700');
    const html = `
<html dir="rtl" lang="fa">
<head>
<meta charset="utf-8">
<title>چاپ رسید</title>
<style>
body{font-family:'Vazir', sans-serif;}
h3{margin:0 0 12px}
dl{display:grid;grid-template-columns:120px 1fr;gap:8px 16px}
dt{color:#555}
pre{background:#f1f5f9;padding:10px;border-radius:8px}
</style>
</head>
<body>
  <h3>رسید تراکنش</h3>
  <dl>
    <dt>شماره تراکنش</dt><dd>${document.getElementById('rc-txn').textContent}</dd>
    <dt>فعالیت</dt><dd>${document.getElementById('rc-activity').textContent}</dd>
    <dt>پلن</dt><dd>${document.getElementById('rc-plan').textContent}</dd>
    <dt>کاربر</dt><dd>${document.getElementById('rc-user').textContent}</dd>
    <dt>مبلغ</dt><dd>${document.getElementById('rc-amount').textContent}</dd>
    <dt>تاریخ/ساعت</dt><dd>${document.getElementById('rc-datetime').textContent}</dd>
    <dt>درگاه</dt><dd>${document.getElementById('rc-gateway').textContent}</dd>
    <dt>وضعیت</dt><dd>${document.getElementById('rc-status').textContent}</dd>
    <dt>کد مرجع</dt><dd>${document.getElementById('rc-ref').textContent}</dd>
  </dl>
  <h4>جزئیات رسید</h4>
  <pre>${document.getElementById('rc-json').textContent}</pre>
  <script>window.print();<\/script>
</body>
</html>`;
    w.document.write(html);
    w.document.close();
});
</script>
@endsection
