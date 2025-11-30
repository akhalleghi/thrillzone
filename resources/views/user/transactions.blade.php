@extends('user.layouts.app')

@section('title', 'تراکنش‌های من')

@php
    use Morilog\Jalali\Jalalian;

    $statusStyles = [
        'success'  => ['label' => 'موفق',   'class' => 'badge-success-soft'],
        'pending'  => ['label' => 'در انتظار', 'class' => 'badge-pending-soft'],
        'failed'   => ['label' => 'ناموفق', 'class' => 'badge-failed-soft'],
        'refunded' => ['label' => 'برگشت شده', 'class' => 'badge-refunded-soft'],
    ];
@endphp

@section('extra-styles')
    <style>
        .text-info { color: #ff4d79 !important; }
        .btn-outline-info {
            color: #ff4d79;
            border-color: rgba(255,0,77,.5);
        }
        .btn-outline-info:hover {
            background: rgba(255,0,77,.2);
            color: #fff;
            border-color: rgba(255,0,77,.8);
        }
        .card-glass {
            background: rgba(8,8,8,0.92);
            border: 1px solid rgba(255,0,77,0.18);
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
        .table-wrapper { position: relative; }
        .table-scroll { overflow-x: auto; }
        .badge-soft {
            border-radius: 999px;
            padding: .35rem .85rem;
            font-size: .78rem;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,.12);
            backdrop-filter: blur(6px);
        }
        .badge-success-soft { background: rgba(0,255,156,.15); color: #4dffca; }
        .badge-pending-soft { background: rgba(255,167,0,.18); color: #ffb347; }
        .badge-failed-soft { background: rgba(255,0,77,.18); color: #ff4d79; }
        .badge-refunded-soft { background: rgba(255,255,255,.12); color: rgba(255,255,255,.7); }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }
        .empty-state .icon {
            font-size: 3rem;
            color: var(--c-primary);
            margin-bottom: 1rem;
        }
        .mobile-cards { display: none; }
        .transaction-card {
            background: rgba(0,0,0,.55);
            border: 1px solid rgba(255,0,77,.2);
            border-radius: 18px;
            padding: 1.1rem;
            margin-bottom: 1rem;
            box-shadow: 0 20px 70px rgba(0,0,0,.55);
        }
        .transaction-card .card-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: .5rem;
            font-size: .9rem;
        }
        .transaction-card .card-row span:first-child {
            color: rgba(255,255,255,.6);
        }
        .receipt-json {
            background: rgba(0,0,0,.35);
            border-radius: 12px;
            padding: .75rem;
            max-height: 260px;
            overflow: auto;
            font-size: .86rem;
            border: 1px solid rgba(255,0,77,.25);
        }
        .transaction-modal .modal-content {
            background: linear-gradient(135deg, rgba(5,5,5,.95), rgba(25,0,15,.9));
            border: 1px solid rgba(255,0,77,.25);
            box-shadow: 0 35px 90px rgba(0,0,0,.65);
        }
        .transaction-modal .modal-header,
        .transaction-modal .modal-footer {
            border-color: rgba(255,0,77,.2);
            background: rgba(255,0,77,.05);
        }
        .transaction-modal .modal-title {
            color: #fff;
        }
        @media (max-width: 992px) {
            .table-wrapper { display: none; }
            .mobile-cards { display: block; }
        }
    </style>
@endsection

@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4 gap-2">
        <div>
            <h3 class="section-title mb-0">تراکنش‌های من</h3>
            <p class="text-secondary mb-0">تاریخچه پرداخت‌ها و وضعیت تراکنش‌های شما در منطقه هیجان.</p>
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

    @if($transactions->isEmpty())
        <div class="card-glass empty-state">
            <div class="icon"><i class="bi bi-credit-card"></i></div>
            <h5 class="text-light">هنوز تراکنشی ثبت نشده است</h5>
            <p class="text-secondary mb-0">با خرید پلن‌ها و اشتراک‌ها، جزئیات پرداخت‌های شما در اینجا نمایش داده می‌شود.</p>
        </div>
    @else
        <div class="card-glass mb-3">
            <div class="table-wrapper">
                <div class="table-scroll">
                    <table class="table table-dark align-middle mb-0" style="min-width: 1050px;">
                        <thead>
                            <tr>
                                <th>شماره تراکنش</th>
                                <th>پلن / فعالیت</th>
                                <th>مبلغ پرداختی</th>
                                <th>تخفیف</th>
                                <th>کد تخفیف</th>
                                <th>مدت</th>
                                <th>درگاه</th>
                                <th>تاریخ پرداخت</th>
                                <th>وضعیت</th>
                                <th>جزئیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                @php
                                    $status = $transaction->status ?? 'pending';
                                    $statusInfo = $statusStyles[$status] ?? ['label' => $status, 'class' => 'badge-soft'];
                                    $paidAt    = $transaction->paid_at
                                        ? Jalalian::fromDateTime($transaction->paid_at)->format('Y/m/d H:i')
                                        : 'ثبت نشده';
                                    $receiptJson = $transaction->receipt
                                        ? json_encode($transaction->receipt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
                                        : null;
                                @endphp
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $transaction->txn_number ?? '—' }}
                                        <div class="small text-secondary">{{ $transaction->ref_code ?? 'کد مرجع: —' }}</div>
                                    </td>
                                    <td>
                                        {{ $transaction->plan?->name ?? '—' }}
                                        @if($transaction->activity)
                                            <div class="small text-secondary">فعالیت: {{ $transaction->activity }}</div>
                                        @endif
                                    </td>
                                    <td>{{ number_format((int) $transaction->amount) }} <span class="text-secondary small">تومان</span></td>
                                    <td>{{ $transaction->discount ? number_format((int) $transaction->discount) : '—' }}</td>
                                    <td>{{ $transaction->coupon_code ?? '—' }}</td>
                                    <td>{{ $transaction->months ? $transaction->months . ' ماهه' : '—' }}</td>
                                    <td>{{ $transaction->gateway ?? '—' }}</td>
                                    <td>{{ $paidAt }}</td>
                                    <td>
                                        <span class="badge-soft {{ $statusInfo['class'] }}">
                                            {{ $statusInfo['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#userTransactionModal"
                                            data-txn="{{ $transaction->txn_number ?? '—' }}"
                                            data-plan="{{ $transaction->plan?->name ?? '—' }}"
                                            data-activity="{{ $transaction->activity ?? '—' }}"
                                            data-amount="{{ number_format((int) $transaction->amount) }} تومان"
                                            data-discount="{{ $transaction->discount ? number_format((int) $transaction->discount) . ' تومان' : '—' }}"
                                            data-coupon="{{ $transaction->coupon_code ?? '—' }}"
                                            data-months="{{ $transaction->months ? $transaction->months . ' ماهه' : '—' }}"
                                            data-gateway="{{ $transaction->gateway ?? '—' }}"
                                            data-status="{{ $statusInfo['label'] }}"
                                            data-ref="{{ $transaction->ref_code ?? '—' }}"
                                            data-paid="{{ $paidAt }}"
                                            data-receipt="{{ $receiptJson ? e($receiptJson) : '' }}"
                                        >
                                            مشاهده
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mobile-cards">
                @foreach($transactions as $transaction)
                    @php
                        $status = $transaction->status ?? 'pending';
                        $statusInfo = $statusStyles[$status] ?? ['label' => $status, 'class' => 'badge-soft'];
                        $paidAt    = $transaction->paid_at
                            ? Jalalian::fromDateTime($transaction->paid_at)->format('Y/m/d H:i')
                            : 'ثبت نشده';
                        $receiptJson = $transaction->receipt
                            ? json_encode($transaction->receipt, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
                            : null;
                    @endphp
                    <div class="transaction-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="fw-semibold">{{ $transaction->plan?->name ?? '—' }}</div>
                                <div class="small text-secondary">{{ $transaction->gateway ?? '—' }}</div>
                            </div>
                            <span class="badge-soft {{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</span>
                        </div>
                        <div class="card-row">
                            <span>شماره تراکنش</span>
                            <span>{{ $transaction->txn_number ?? '—' }}</span>
                        </div>
                        <div class="card-row">
                            <span>مبلغ</span>
                            <span>{{ number_format((int) $transaction->amount) }} تومان</span>
                        </div>
                        <div class="card-row">
                            <span>تاریخ پرداخت</span>
                            <span>{{ $paidAt }}</span>
                        </div>
                        <div class="card-row">
                            <span>کد تخفیف</span>
                            <span>{{ $transaction->coupon_code ?? '—' }}</span>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-outline-info btn-sm mt-2"
                                data-bs-toggle="modal"
                                data-bs-target="#userTransactionModal"
                                data-txn="{{ $transaction->txn_number ?? '—' }}"
                                data-plan="{{ $transaction->plan?->name ?? '—' }}"
                                data-activity="{{ $transaction->activity ?? '—' }}"
                                data-amount="{{ number_format((int) $transaction->amount) }} تومان"
                                data-discount="{{ $transaction->discount ? number_format((int) $transaction->discount) . ' تومان' : '—' }}"
                                data-coupon="{{ $transaction->coupon_code ?? '—' }}"
                                data-months="{{ $transaction->months ? $transaction->months . ' ماهه' : '—' }}"
                                data-gateway="{{ $transaction->gateway ?? '—' }}"
                                data-status="{{ $statusInfo['label'] }}"
                                data-ref="{{ $transaction->ref_code ?? '—' }}"
                                data-paid="{{ $paidAt }}"
                                data-receipt="{{ $receiptJson ? e($receiptJson) : '' }}"
                            >
                                جزئیات کامل
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $transactions->links() }}
        </div>
    @endif

    <div class="modal fade transaction-modal" id="userTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content text-light">
                <div class="modal-header">
                    <h5 class="modal-title">جزئیات تراکنش</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-secondary small">شماره تراکنش</div>
                            <div class="fw-semibold" id="tx-txn">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-secondary small">کد مرجع</div>
                            <div class="fw-semibold" id="tx-ref">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-secondary small">پلن / فعالیت</div>
                            <div class="fw-semibold" id="tx-plan">—</div>
                            <div class="text-secondary small" id="tx-activity">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-secondary small">درگاه</div>
                            <div class="fw-semibold" id="tx-gateway">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-secondary small">مبلغ پرداختی</div>
                            <div class="fw-semibold" id="tx-amount">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-secondary small">تخفیف اعمال شده</div>
                            <div class="fw-semibold" id="tx-discount">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-secondary small">کد تخفیف</div>
                            <div class="fw-semibold" id="tx-coupon">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-secondary small">مدت اشتراک</div>
                            <div class="fw-semibold" id="tx-months">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-secondary small">وضعیت</div>
                            <div class="fw-semibold" id="tx-status">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-secondary small">تاریخ پرداخت</div>
                            <div class="fw-semibold" id="tx-paid">—</div>
                        </div>
                    </div>
                    <hr class="my-4" style="border-color: rgba(255,255,255,.12);">
                    <div>
                        <div class="fw-semibold mb-2">رسید تراکنش (JSON)</div>
                        <pre class="receipt-json" id="tx-receipt">—</pre>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('userTransactionModal')?.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            if (!trigger) return;

            const setText = (id, value) => {
                const el = document.getElementById(id);
                if (el) {
                    el.textContent = value && value.trim() !== '' ? value : '—';
                }
            };

            setText('tx-txn', trigger.getAttribute('data-txn'));
            setText('tx-plan', trigger.getAttribute('data-plan'));
            setText('tx-activity', trigger.getAttribute('data-activity'));
            setText('tx-amount', trigger.getAttribute('data-amount'));
            setText('tx-discount', trigger.getAttribute('data-discount'));
            setText('tx-coupon', trigger.getAttribute('data-coupon'));
            setText('tx-months', trigger.getAttribute('data-months'));
            setText('tx-gateway', trigger.getAttribute('data-gateway'));
            setText('tx-status', trigger.getAttribute('data-status'));
            setText('tx-ref', trigger.getAttribute('data-ref'));
            setText('tx-paid', trigger.getAttribute('data-paid'));

            let receipt = trigger.getAttribute('data-receipt');
            if (receipt) {
                try {
                    const parsed = JSON.parse(receipt);
                    receipt = JSON.stringify(parsed, null, 2);
                } catch (e) {
                    // keep original string
                }
            }
            setText('tx-receipt', receipt || '—');
        });
    </script>
@endpush
