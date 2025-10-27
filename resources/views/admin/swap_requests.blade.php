@extends('admin.layouts.app')

@section('title', 'درخواست‌های تعویض')

@section('content')
@php use Morilog\Jalali\Jalalian; @endphp

<style>
.card-glass{background:var(--panel);border:1px solid var(--border);border-radius:14px;padding:1rem;}
.table-scroll-x{overflow-x:auto}
.badge-soft{background:rgba(255,255,255,.08);border:1px solid var(--border);border-radius:999px;padding:.35rem .6rem;font-weight:600;}
.subs-actions{display:flex;gap:.4rem;flex-wrap:wrap;}
</style>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="section-title m-0">درخواست‌های تعویض</h4>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card-glass">
  <div class="table-scroll-x">
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
            <td><span class="badge bg-info">{{ $req->subscription->subscription_code ?? '-' }}</span></td>
            <td>{{ $req->subscription_id }}</td>
            <td>{{ $req->user->name ?? '—' }}</td>
            <td>{{ $req->user->phone ?? '—' }}</td>
            <td>{{ $req->subscription->plan->name ?? '—' }}</td>
            <td>{{ $req->subscription->duration_months ?? '—' }} ماهه</td>
            <td>
              @if(!empty($req->requested_games))
                {{ implode('، ', $req->requested_games) }}
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
            <td colspan="10" class="text-center text-muted py-4">هیچ درخواستی یافت نشد.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-3">
    {{ $requests->links('pagination::bootstrap-5') }}
  </div>
</div>
@endsection
