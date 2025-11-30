@extends('admin.layouts.app')
@section('title','درخواست‌های ارتقا')

@php use Morilog\Jalali\Jalalian; @endphp

@section('content')
<style>
    .card-glass{background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:1.25rem;box-shadow:0 20px 60px rgba(0,0,0,.35)}
    .section-title{background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-weight:800}
    .table thead th{border-bottom:1px solid var(--border);color:rgba(255,255,255,.85)}
    .table td,.table th{border-color:var(--border);vertical-align:middle}
    .badge-status{border-radius:999px;padding:.35rem .9rem;font-weight:600}
    .badge-pending{background:rgba(255,193,7,.18);color:#ffb347}
    .badge-done{background:rgba(0,255,156,.18);color:#24ffb9}
    .badge-rejected{background:rgba(255,0,77,.2);color:#ff4d79}
    .selected-pill{display:inline-flex;align-items:center;gap:.35rem;background:rgba(255,255,255,.08);border-radius:999px;padding:.2rem .8rem;margin:.15rem;font-size:.85rem}
    .table-wrapper{display:block}
    .mobile-cards{display:none}
    .upgrade-card{background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:16px;padding:1rem;margin-bottom:1rem}
    .upgrade-card .row-line{display:flex;justify-content:space-between;margin-bottom:.35rem;font-size:.9rem}
    .upgrade-card .row-line span:first-child{color:rgba(255,255,255,.6)}
    @media(max-width:992px){.table-wrapper{display:none}.mobile-cards{display:block}}
</style>

<div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
    <h4 class="section-title m-0">درخواست‌های ارتقا</h4>
</div>

<div class="card-glass mb-3">
    <form method="GET" action="{{ route('admin.upgrade_requests.index') }}" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">وضعیت</label>
            <select name="status" class="form-select">
                <option value="">همه</option>
                @foreach($statusMap as $key => $label)
                    <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 ms-auto text-end">
            <button class="btn btn-primary w-100"><i class="bi bi-search"></i> فیلتر</button>
        </div>
    </form>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

<div class="card-glass">
    @if($requests->isEmpty())
        <div class="text-center text-muted py-5">درخواستی ثبت نشده است.</div>
    @else
        <div class="table-wrapper d-none d-lg-block">
            <div class="table-responsive">
                <table class="table table-dark align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>کاربر</th>
                            <th>اشتراک</th>
                            <th>پلن/مدت درخواستی</th>
                            <th>بازی‌ها</th>
                            <th>توضیحات</th>
                            <th>تاریخ درخواست</th>
                            <th>وضعیت</th>
                            <th>اقدامات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $index => $req)
                            <tr>
                                <td>{{ $requests->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $req->user->name ?? '---' }}</div>
                                    <div class="text-muted small">{{ $req->user->phone ?? '---' }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $req->subscription->subscription_code ?? '---' }}</div>
                                    <small class="text-muted">{{ $req->subscription->plan->name ?? '---' }}</small>
                                </td>
                                <td>
                                    <div>{{ $req->requestedPlan->name ?? '---' }}</div>
                                    <small class="text-muted">{{ $req->requested_duration ? $req->requested_duration . ' ماهه' : '---' }}</small>
                                </td>
                                <td>
                                    @forelse(($req->selected_games ?? []) as $game)
                                        <span class="selected-pill">{{ $game }}</span>
                                    @empty
                                        <span class="text-muted">---</span>
                                    @endforelse
                                </td>
                                <td>{{ $req->description ?? '---' }}</td>
                                <td>{{ $req->created_at ? Jalalian::fromCarbon($req->created_at)->format('Y/m/d H:i') : '---' }}</td>
                                <td>
                                    @php $badge = 'badge-status '; @endphp
                                    @if($req->status === \App\Models\UpgradeRequest::STATUS_DONE)
                                        @php $badge .= 'badge-done'; @endphp
                                    @elseif($req->status === \App\Models\UpgradeRequest::STATUS_REJECTED)
                                        @php $badge .= 'badge-rejected'; @endphp
                                    @else
                                        @php $badge .= 'badge-pending'; @endphp
                                    @endif
                                    <span class="{{ $badge }}">{{ $statusMap[$req->status] ?? $req->status }}</span>
                                </td>
                                <td class="text-nowrap">
                                    @if($req->status === \App\Models\UpgradeRequest::STATUS_PENDING)
                                        <form method="POST" action="{{ route('admin.upgrade_requests.approve', $req) }}" class="d-inline" onsubmit="return confirm('آیا از تایید این درخواست مطمئن هستید؟');">
                                            @csrf
                                            <button class="btn btn-sm btn-success"><i class="bi bi-check2"></i> تایید</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.upgrade_requests.reject', $req) }}" class="d-inline" onsubmit="return confirm('آیا از رد این درخواست مطمئن هستید؟');">
                                            @csrf
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-x"></i> رد</button>
                                        </form>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mobile-cards">
            @foreach($requests as $req)
                @php
                    $badgeClass = 'badge-status ' . match($req->status) {
                        \App\Models\UpgradeRequest::STATUS_DONE => 'badge-done',
                        \App\Models\UpgradeRequest::STATUS_REJECTED => 'badge-rejected',
                        default => 'badge-pending',
                    };
                @endphp
                <div class="upgrade-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="fw-semibold">{{ $req->user->name ?? '---' }}</div>
                            <small class="text-muted">{{ $req->created_at ? Jalalian::fromCarbon($req->created_at)->format('Y/m/d H:i') : '---' }}</small>
                        </div>
                        <span class="{{ $badgeClass }}">{{ $statusMap[$req->status] ?? $req->status }}</span>
                    </div>
                    <div class="row-line"><span>اشتراک</span><span>{{ $req->subscription->subscription_code ?? '---' }}</span></div>
                    <div class="row-line"><span>پلن</span><span>{{ $req->requestedPlan->name ?? '---' }}</span></div>
                    <div class="row-line"><span>مدت</span><span>{{ $req->requested_duration ? $req->requested_duration . ' ماهه' : '---' }}</span></div>
                    <div class="row-line"><span>بازی‌ها</span><span>
                        @if($req->selected_games)
                            {{ implode(', ', $req->selected_games) }}
                        @else
                            ---
                        @endif
                    </span></div>
                    <div class="row-line"><span>توضیحات</span><span>{{ $req->description ?? '---' }}</span></div>
                    <div class="text-end mt-2">
                        @if($req->status === \App\Models\UpgradeRequest::STATUS_PENDING)
                            <form method="POST" action="{{ route('admin.upgrade_requests.approve', $req) }}" class="d-inline" onsubmit="return confirm('آیا از تایید این درخواست مطمئن هستید؟');">
                                @csrf
                                <button class="btn btn-sm btn-success mb-1"><i class="bi bi-check2"></i> تایید</button>
                            </form>
                            <form method="POST" action="{{ route('admin.upgrade_requests.reject', $req) }}" class="d-inline" onsubmit="return confirm('آیا از رد این درخواست مطمئن هستید؟');">
                                @csrf
                                <button class="btn btn-sm btn-danger mb-1"><i class="bi bi-x"></i> رد</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3">
            {{ $requests->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
