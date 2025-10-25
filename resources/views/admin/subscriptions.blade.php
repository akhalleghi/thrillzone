@extends('admin.layouts.app')
@section('title','مدیریت اشتراک‌ها')

@php
    use Morilog\Jalali\Jalalian;
@endphp

@section('content')
<style>
  .card-glass{ background: var(--panel); border:1px solid var(--border); border-radius:14px; padding:1rem; }
  .section-title{ background:var(--grad); -webkit-background-clip:text; -webkit-text-fill-color:transparent; font-weight:800; }
  .table thead th{ border-bottom:1px solid var(--border); }
  .table td,.table th{ border-color:var(--border); vertical-align:middle; }
  .badge-round{border-radius:999px}
  .timer{font-variant-numeric: tabular-nums; direction:ltr; display:inline-block; min-width:110px}
  .sub-card{ background: rgba(255,255,255,.05); border:1px solid var(--border); border-radius:14px; padding:1rem; }
  [data-theme="light"] .sub-card { background:#fff; }
  .table-wrapper{position:relative}
  .table-scroll{overflow:auto}
  @media (max-width: 992px){ .table-wrapper{display:none} }
  
</style>
<style>
  .table-scroll-x{overflow-x:auto}
  .subs-actions{display:flex;gap:.4rem;flex-wrap:wrap}
  @media (max-width: 992px){
    .subs-actions .btn{padding:.35rem .55rem;font-size:.85rem}
    .td-nowrap{white-space:nowrap}
  }
  .badge-soft{
    background:rgba(255,255,255,.08);
    border:1px solid var(--border);
    border-radius:999px;
    padding:.35rem .6rem;
    font-weight:600;
  }
</style>


<div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
  <h4 class="section-title m-0">مدیریت اشتراک‌ها</h4>
</div>

{{-- فیلترها --}}
<div class="card-glass mb-3">
  <form method="GET" action="{{ route('admin.subscriptions') }}">
    <div class="row g-2 align-items-end">
      <div class="col-md-3">
        <label class="form-label">جستجوی کاربر (نام/موبایل)</label>
        <input type="text" name="q" class="form-control" value="{{ $q }}" placeholder="مثلاً: امین یا 0912...">
      </div>
      <div class="col-md-2">
        <label class="form-label">وضعیت</label>
        <select name="status" class="form-select">
          <option value="">همه</option>
          <option value="waiting" {{ $status==='waiting'?'selected':'' }}>در انتظار انتخاب بازی</option>
          <option value="active"  {{ $status==='active'?'selected':'' }}>فعال</option>
          <option value="ended"   {{ $status==='ended'?'selected':'' }}>پایان یافته</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">پلن</label>
        <select name="plan_id" class="form-select">
          <option value="">همه</option>
          @foreach($plans as $p)
            <option value="{{ $p->id }}" {{ (string)$planId === (string)$p->id ? 'selected':'' }}>{{ $p->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">از تاریخ</label>
        <input type="date" name="from" class="form-control" value="{{ $from }}">
      </div>
      <div class="col-md-2">
        <label class="form-label">تا تاریخ</label>
        <input type="date" name="to" class="form-control" value="{{ $to }}">
      </div>
      <div class="col-md-2 ms-auto text-end">
        <button class="btn btn-primary w-100"><i class="bi bi-search"></i> فیلتر</button>
      </div>
    </div>
  </form>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div> @endif

<div class="card-glass">
  {{-- نسخه دسکتاپ: جدول --}}
  <div class="table-wrapper d-none d-lg-block">
    <div class="table-scroll">
      <table class="table table-dark align-middle mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>کاربر</th>
            <th>مدت</th>
            <th>پلن</th>
            <th>تاریخ خرید</th>
            <th>زمان درخواستی</th>
            <th>شروع</th>
            <th>پایان</th>
            <th>زمان باقی‌مانده</th>
            <th>بازی‌های فعال</th>
            <th>وضعیت</th>
            <th>زمان تا تعویض</th>
            <th>عملیات</th>
          </tr>
        </thead>
        <tbody>
        @forelse($subscriptions as $i => $s)
          <tr>
            <td>{{ $subscriptions->firstItem() + $i }}</td>
            <td>
              <div class="fw-bold">{{ $s->user->name ?? '—' }}</div>
              <div class="text-muted">{{ $s->user->phone ?? '—' }}</div>
            </td>
            <td>{{ $s->duration_months }} ماهه</td>
            <td>{{ $s->plan->name ?? '—' }}</td>
            <td>{{ $s->purchased_at ? Jalalian::fromCarbon($s->purchased_at)->format('Y/m/d H:i') : '—' }}</td>
            <td>{{ $s->requested_at ? Jalalian::fromCarbon($s->requested_at)->format('Y/m/d H:i') : '—' }}</td>
            <td>{{ $s->activated_at ? Jalalian::fromCarbon($s->activated_at)->format('Y/m/d H:i') : '—' }}</td>
            <td>{{ $s->ends_at ? Jalalian::fromCarbon($s->ends_at)->format('Y/m/d H:i') : '—' }}</td>

            {{-- زمان باقی‌مانده --}}
            <td>
              @if($s->status === 'active' && $s->ends_at)
                <span class="timer countdown"
                      data-end="{{ $s->ends_at->toIso8601String() }}">...</span>
              @elseif($s->status === 'ended')
                <span class="text-muted">خاتمه یافته</span>
              @else
                <span class="text-muted">در انتظار انتخاب بازی</span>
              @endif
            </td>

            {{-- بازی‌های فعال --}}
            <td>{{ $s->active_games_list }}</td>

            {{-- وضعیت --}}
            <td>
              @if($s->status === 'waiting')
                <span class="badge bg-warning text-dark badge-round">در انتظار انتخاب بازی</span>
              @elseif($s->status === 'active')
                <span class="badge bg-success badge-round">فعال</span>
              @else
                <span class="badge bg-secondary badge-round">پایان یافته</span>
              @endif
            </td>

            {{-- زمان تا تعویض --}}
            <td>
              @if($s->status === 'active' && $s->next_swap_at)
                <span class="timer swapdown"
                      data-swap="{{ $s->next_swap_at->toIso8601String() }}">...</span>
              @else
                <span class="text-muted">—</span>
              @endif
            </td>

            {{-- عملیات --}}
            <td class="text-nowrap">
              <!-- <a href="{{ route('admin.subscriptions.show',$s) }}"
                 class="btn btn-sm btn-outline-info me-1">
                <i class="bi bi-receipt"></i> رسید
              </a> -->
              @if($s->status==='waiting')
                <form class="d-inline" method="POST" action="{{ route('admin.subscriptions.activate',$s) }}">
                  @csrf
                  <button class="btn btn-sm btn-outline-success">
                    <i class="bi bi-play"></i> فعال‌سازی
                  </button>
                </form>
              @elseif($s->status==='active')
                <form class="d-inline" method="POST" action="{{ route('admin.subscriptions.finish',$s) }}">
                  @csrf
                  <button class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-stop"></i> خاتمه
                  </button>
                </form>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="13" class="text-center text-muted py-4">موردی یافت نشد.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- نسخه موبایل: کارت --}}
  <div class="d-lg-none">
    @forelse($subscriptions as $i => $s)
      <div class="sub-card mb-3">
        <div class="d-flex align-items-center mb-2">
          <div class="fw-bold">{{ $s->user->name ?? '—' }}</div>
          <span class="ms-auto badge {{ $s->status==='active'?'bg-success':($s->status==='waiting'?'bg-warning text-dark':'bg-secondary') }}">
            {{ $s->status==='waiting' ? 'در انتظار انتخاب بازی' : ($s->status==='active'?'فعال':'پایان یافته') }}
          </span>
        </div>
        <div class="small text-muted mb-2">{{ $s->user->phone ?? '—' }}</div>

        <div class="row g-2 small">
          <div class="col-6"><b>پلن:</b> {{ $s->plan->name ?? '—' }}</div>
          <div class="col-6"><b>مدت:</b> {{ $s->duration_months }} ماهه</div>
          <div class="col-6"><b>خرید:</b> {{ $s->purchased_at ? Jalalian::fromCarbon($s->purchased_at)->format('Y/m/d H:i') : '—' }}</div>
          <div class="col-6"><b>شروع:</b> {{ $s->activated_at ? Jalalian::fromCarbon($s->activated_at)->format('Y/m/d H:i') : '—' }}</div>
          <div class="col-6"><b>پایان:</b> {{ $s->ends_at ? Jalalian::fromCarbon($s->ends_at)->format('Y/m/d H:i') : '—' }}</div>
          <div class="col-12"><b>بازی‌ها:</b> {{ $s->active_games_list }}</div>
          <div class="col-6">
            <b>باقی‌مانده:</b>
            @if($s->status==='active' && $s->ends_at)
              <span class="timer countdown" data-end="{{ $s->ends_at->toIso8601String() }}">...</span>
            @elseif($s->status==='ended')
              <span class="text-muted">خاتمه یافته</span>
            @else
              <span class="text-muted">—</span>
            @endif
          </div>
          <div class="col-6">
            <b>تا تعویض:</b>
            @if($s->status==='active' && $s->next_swap_at)
              <span class="timer swapdown" data-swap="{{ $s->next_swap_at->toIso8601String() }}">...</span>
            @else
              <span class="text-muted">—</span>
            @endif
          </div>
        </div>

        <div class="text-end mt-2">
          <a href="{{ route('admin.subscriptions.show',$s) }}" class="btn btn-sm btn-outline-info me-1">
            <i class="bi bi-receipt"></i> رسید
          </a>
          @if($s->status==='waiting')
            <form class="d-inline" method="POST" action="{{ route('admin.subscriptions.activate',$s) }}">
              @csrf
              <button class="btn btn-sm btn-outline-success"><i class="bi bi-play"></i> فعال</button>
            </form>
          @elseif($s->status==='active')
            <form class="d-inline" method="POST" action="{{ route('admin.subscriptions.finish',$s) }}">
              @csrf
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-stop"></i> پایان</button>
            </form>
          @endif
        </div>
      </div>
    @empty
      <div class="text-center text-muted py-4">موردی یافت نشد.</div>
    @endforelse
  </div>

  <div class="mt-3">
    {{ $subscriptions->links('pagination::bootstrap-5') }}
  </div>
</div>

{{-- تایمرهای معکوس --}}
<script>
(function(){
  function fmt(sec){
    if (sec <= 0) return '00:00:00';
    const d = Math.floor(sec / 86400);
    sec %= 86400;
    const h = Math.floor(sec / 3600);
    sec %= 3600;
    const m = Math.floor(sec / 60);
    const s = Math.floor(sec % 60);
    const hh = String(h).padStart(2,'0');
    const mm = String(m).padStart(2,'0');
    const ss = String(s).padStart(2,'0');
    return (d>0? d+'d ':'') + `${hh}:${mm}:${ss}`;
  }

  function tick(){
    const now = new Date().getTime();

    // پایان اشتراک
    document.querySelectorAll('.countdown').forEach(el=>{
      const end = el.getAttribute('data-end');
      if (!end) { el.textContent = '—'; return; }
      const t = new Date(end).getTime() - now;
      const secs = Math.floor(t/1000);
      el.textContent = secs>0 ? fmt(secs) : 'تمام شد';
    });

    // تعویض بعدی
    document.querySelectorAll('.swapdown').forEach(el=>{
      const sw = el.getAttribute('data-swap');
      if (!sw) { el.textContent = '—'; return; }
      const t = new Date(sw).getTime() - now;
      const secs = Math.floor(t/1000);
      el.textContent = secs>0 ? fmt(secs) : 'امکان تعویض';
    });
  }

  tick();
  setInterval(tick, 1000);
})();
</script>
@endsection
