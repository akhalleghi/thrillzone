@extends('admin.layouts.app')

@section('title', 'درخواست‌های تعویض')

@section('content')
@php use Morilog\Jalali\Jalalian; @endphp

<style>
  .card-glass{ background: var(--panel); border:1px solid var(--border); border-radius:14px; padding:1rem; }
  .section-title{ background:var(--grad); -webkit-background-clip:text; -webkit-text-fill-color:transparent; font-weight:800; }
  .table thead th{ border-bottom:1px solid var(--border); }
  .table td,.table th{ border-color:var(--border); vertical-align:middle; }
  .badge-round{border-radius:999px}
  .timer{font-variant-numeric: tabular-nums; direction:ltr; display:inline-block; min-width:110px}
  .sub-card{ background: rgba(255,255,255,.05); border:1px solid var(--border); border-radius:14px; padding:1rem; }
  [data-theme="light"] .sub-card { background:#fff; }
</style>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="section-title m-0">درخواست‌های تعویض</h4>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card-glass">

  {{-- جدول دسکتاپ فقط از lg به بالا --}}
  <div class="d-none d-lg-block">
    <table class="table table-dark align-middle mb-0">
      <thead>
        <tr>
          <th>#</th>
          <th>شماره اشتراک</th>
          <th>کد اشتراک</th>
          <th>کاربر</th>
          <th>شماره تماس</th>
          <th>پلن</th>
          <th>مدت پلن</th>
          <th>بازی‌های درخواست‌شده</th>
          <th>تاریخ درخواست</th>
          <th>وضعیت</th>
          <th>عملیات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($requests as $i => $req)
          <tr>
            <td>{{ $requests->firstItem() + $i }}</td>
            <td><span class="badge bg-primary">{{ $req->subscription->subscription_code ?? '—' }}</span></td>
            <td class="text-muted">{{ $req->subscription_id }}</td>
            <td>{{ $req->user->name ?? '—' }}</td>
            <td>{{ $req->user->phone ?? '—' }}</td>
            <td>{{ $req->subscription->plan->name ?? '—' }}</td>
            <td>{{ $req->subscription->duration_months ?? '—' }} ماهه</td>
            <td>
              @if(!empty($req->requested_games))
                {{ is_array($req->requested_games) ? implode('، ', $req->requested_games) : $req->requested_games }}
              @else
                —
              @endif
            </td>
            <td>{{ Jalalian::fromCarbon($req->created_at)->format('Y/m/d H:i') }}</td>
            <td>
              @if($req->status === 'done')
                <span class="badge bg-success">انجام‌شده</span>
              @else
                <span class="badge bg-warning text-dark">در انتظار</span>
              @endif
            </td>
            <td>
              @if($req->status === 'pending')
                <form method="POST"
                      action="{{ route('admin.swap_requests.done', $req) }}"
                      onsubmit="return confirm('آیا از انجام این درخواست مطمئن هستید؟ این عملیات قابل بازگشت نیست.');">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-success">
                    <i class="bi bi-check-circle"></i> انجام شد
                  </button>
                </form>
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="11" class="text-center text-muted py-4">هیچ درخواستی یافت نشد.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- نسخه موبایل: کارت‌ها فقط زیر lg --}}
  <div class="d-lg-none">
    @forelse($requests as $req)
      <div class="sub-card mb-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <div class="fw-bold">{{ $req->subscription->user->name ?? '—' }}</div>
          <span class="badge bg-primary">{{ $req->subscription->subscription_code ?? '—' }}</span>
        </div>

        <div class="small text-muted mb-1">
          <b>پلن:</b> {{ $req->subscription->plan->name ?? '—' }}<br>
          <b>مدت:</b> {{ $req->subscription->duration_months }} ماهه<br>
          <b>بازی‌های درخواستی:</b>
          <span class="text-light">
            {{ is_array($req->requested_games) ? implode('، ', $req->requested_games) : ($req->requested_games ?: '—') }}
          </span>
        </div>

        <div class="small text-muted mb-2">
          <b>تماس:</b> {{ $req->subscription->user->phone ?? '—' }}<br>
          <b>تاریخ درخواست:</b> {{ Jalalian::fromCarbon($req->created_at)->format('Y/m/d H:i') }}
        </div>

        <div class="d-flex align-items-center justify-content-between">
          <div>
            @if($req->status === 'done')
              <span class="badge bg-success">انجام‌شده</span>
            @else
              <span class="badge bg-warning text-dark">در انتظار</span>
            @endif
          </div>
          <div class="text-end">
            @if($req->status === 'pending')
              <form method="POST" action="{{ route('admin.swap_requests.done', $req) }}"
                    onsubmit="return confirm('آیا از انجام این درخواست مطمئن هستید؟')">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-success">
                  <i class="bi bi-check2-circle"></i> انجام شد
                </button>
              </form>
            @endif
          </div>
        </div>
      </div>
    @empty
      <div class="text-center text-muted py-4">درخواستی یافت نشد.</div>
    @endforelse
  </div>

  {{-- صفحه‌بندی (مشترک) --}}
  <div class="mt-3">
    {{ $requests->links('pagination::bootstrap-5') }}
  </div>
</div>
@endsection
