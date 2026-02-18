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
  .account-details-modal .modal-content{
    background: linear-gradient(135deg, rgba(18,24,54,0.96), rgba(30,16,66,0.94));
    border:1px solid rgba(255,255,255,0.15);
    color: var(--text-color,#f8f9ff);
    box-shadow: 0 25px 60px rgba(0,0,0,0.5);
    backdrop-filter: blur(10px);
  }
  .account-details-modal .modal-header,
  .account-details-modal .modal-footer{
    background: rgba(255,255,255,0.03);
    border-color: rgba(255,255,255,0.12);
  }
  .account-details-modal .modal-header .btn-close{
    filter: invert(1);
    opacity: .7;
  }
  .account-details-modal textarea{
    background: rgba(255,255,255,0.08);
    border-color: rgba(255,255,255,0.2);
    color: inherit;
  }
  .time-manage-modal .modal-content{
    background: linear-gradient(135deg, rgba(18,24,54,0.96), rgba(30,16,66,0.94));
    border:1px solid rgba(255,255,255,0.15);
    color: var(--text-color,#f8f9ff);
    box-shadow: 0 25px 60px rgba(0,0,0,0.5);
    backdrop-filter: blur(10px);
  }
  .time-manage-modal .modal-header,
  .time-manage-modal .modal-footer{
    background: rgba(255,255,255,0.03);
    border-color: rgba(255,255,255,0.12);
  }
  .time-manage-modal .modal-header .btn-close{
    filter: invert(1);
    opacity: .7;
  }
  .time-manage-summary{
    background: rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.12);
    border-radius:12px;
    padding:.8rem;
  }
  .time-manage-summary .label{
    font-size:.8rem;
    color:rgba(255,255,255,.7);
    margin-bottom:.35rem;
  }
  .time-manage-summary .value{
    font-weight:700;
    font-variant-numeric: tabular-nums;
  }
  .time-manage-preview{
    background: rgba(255,255,255,.04);
    border:1px dashed rgba(255,255,255,.25);
    border-radius:12px;
    padding:.9rem;
  }
  .time-manage-preview .label{
    font-size:.8rem;
    color:rgba(255,255,255,.7);
  }
  .time-manage-preview .value{
    margin-top:.35rem;
    font-weight:800;
    font-variant-numeric: tabular-nums;
  }
  .time-manage-quick{
    display:flex;
    flex-wrap:wrap;
    gap:.4rem;
  }
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
          <option value="waiting_ready" {{ $status==='waiting_ready'?'selected':'' }}>در انتظار فعالسازی توسط ادمین</option>
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
@if($errors->any())
  <div class="alert alert-warning">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="card-glass">
  {{-- نسخه دسکتاپ: جدول --}}
  <div class="table-wrapper d-none d-lg-block">
    <div class="table-scroll">
      <table class="table table-dark align-middle mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>شماره اشتراک</th>
            <th>کاربر</th>
            <th>مدت</th>
            <th>پلن</th>
            <th>تاریخ خرید</th>
            <th>زمان درخواستی</th>
            <th>فرصت انتخاب بازی</th>
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
          @php
            $waitingReady = $s->is_waiting_ready;
            $accountModalId = 'accountModal-' . $s->id;
            $gamesModalId = 'gamesModal-' . $s->id;
            $timeModalId = 'timeModal-' . $s->id;
            $swapTimeModalId = 'swapTimeModal-' . $s->id;
          @endphp
          <tr>
            <td>{{ $subscriptions->firstItem() + $i }}</td>
            <td><span class="badge bg-info">{{ $s->subscription_code }}</span></td>
            <td>
              <div class="fw-bold">{{ $s->user->name ?? '—' }}</div>
              <div class="text-muted">{{ $s->user->phone ?? '—' }}</div>
            </td>
            @php $durLabel = (int)$s->duration_months === 0 ? 'آفلاین - نامحدود' : ($s->duration_months . ' ماهه'); @endphp
            <td>{{ $durLabel }}</td>
            <td>{{ $s->plan->name ?? '—' }}</td>
            <td>{{ $s->purchased_at ? Jalalian::fromCarbon($s->purchased_at)->format('Y/m/d H:i') : '—' }}</td>
            <td>{{ $s->requested_at ? Jalalian::fromCarbon($s->requested_at)->format('Y/m/d H:i') : '—' }}</td>
            <td>
              @if($s->selection_deadline)
                @if($waitingReady)
                  <span class="text-success">بازی‌ها انتخاب شدند</span>
                  @if($s->selection_delay_days > 0)
                    <div class="small text-danger">{{ $s->selection_delay_days }} روز تأخیر</div>
                  @endif
                @elseif($s->status === 'waiting')
                  <span class="timer selection-timer" data-selection="{{ $s->selection_deadline->toIso8601String() }}">...</span>
                  @if($s->selection_delay_days > 0)
                    <div class="small text-danger">{{ $s->selection_delay_days }} روز تأخیر</div>
                  @endif
                @elseif($s->selection_delay_days > 0)
                  <span class="text-danger">مهلت تمام شده ({{ $s->selection_delay_days }} روز تأخیر)</span>
                @else
                  <span class="text-muted">-</span>
                @endif
              @else
                <span class="text-muted">-</span>
              @endif
            </td>
            <td>{{ $s->activated_at ? Jalalian::fromCarbon($s->activated_at)->format('Y/m/d H:i') : '—' }}</td>
            <td>
              <span class="ends-at-text" data-subscription-id="{{ $s->id }}">
                {{ $s->ends_at ? Jalalian::fromCarbon($s->ends_at)->format('Y/m/d H:i') : '—' }}
              </span>
            </td>

            {{-- زمان باقی‌مانده --}}
            <td>
              @if($s->status === 'active' && $s->ends_at)
                <span class="timer countdown"
                      data-subscription-id="{{ $s->id }}"
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
                <span class="badge bg-warning text-dark badge-round">
                  {{ $waitingReady ? 'در انتظار فعالسازی توسط ادمین' : 'در انتظار انتخاب بازی توسط کاربر' }}
                </span>
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
              <div class="dropdown">
                <button
                  class="btn btn-sm btn-outline-secondary dropdown-toggle"
                  type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="bi bi-list"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end text-start">
                  <li>
                    <button type="button"
                            class="dropdown-item d-flex align-items-center gap-2"
                            data-bs-toggle="modal"
                            data-bs-target="#{{ $accountModalId }}">
                      <i class="bi bi-person-lines-fill"></i>
                      <span>اطلاعات حساب کاربری</span>
                    </button>
                  </li>
                  <li>
                    <button type="button"
                            class="dropdown-item d-flex align-items-center gap-2"
                            data-bs-toggle="modal"
                            data-bs-target="#{{ $gamesModalId }}">
                      <i class="bi bi-controller"></i>
                      <span>تغییر بازی‌ها</span>
                    </button>
                  </li>
                  @if(($s->status==='active' && $s->ends_at) || $s->status==='waiting')
                    <li>
                      <button type="button"
                              class="dropdown-item d-flex align-items-center gap-2"
                              data-bs-toggle="modal"
                              data-bs-target="#{{ $timeModalId }}">
                        <i class="bi bi-clock-history"></i>
                        <span>مدیریت زمان</span>
                      </button>
                    </li>
                  @endif
                  @if($s->status==='active' && ($s->next_swap_at || (int) ($s->swap_every_days ?? 0) > 0))
                    <li>
                      <button type="button"
                              class="dropdown-item d-flex align-items-center gap-2"
                              data-bs-toggle="modal"
                              data-bs-target="#{{ $swapTimeModalId }}">
                        <i class="bi bi-arrow-repeat"></i>
                        <span>مدیریت زمان تعویض</span>
                      </button>
                    </li>
                  @endif
                  @if($s->status==='waiting')
                    <li>
                      <form method="POST" action="{{ route('admin.subscriptions.activate',$s) }}">
                        @csrf
                        <button class="dropdown-item d-flex align-items-center gap-2 text-success">
                          <i class="bi bi-play"></i>
                          <span>فعال‌سازی اشتراک</span>
                        </button>
                      </form>
                    </li>
                  @elseif($s->status==='active')
                    <li>
                      <form method="POST" action="{{ route('admin.subscriptions.finish',$s) }}">
                        @csrf
                        <button class="dropdown-item d-flex align-items-center gap-2 text-danger">
                          <i class="bi bi-stop"></i>
                          <span>خاتمه</span>
                        </button>
                      </form>
                    </li>
                  @endif
                </ul>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="14" class="text-center text-muted py-4">موردی یافت نشد.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- نسخه موبایل: کارت --}}
<div class="d-lg-none">
  @forelse($subscriptions as $i => $s)
    @php
      $waitingReady = $s->is_waiting_ready;
      $accountModalId = 'accountModal-' . $s->id;
      $gamesModalId = 'gamesModal-' . $s->id;
      $timeModalId = 'timeModal-' . $s->id;
      $swapTimeModalId = 'swapTimeModal-' . $s->id;
    @endphp
    <div class="sub-card mb-3">
      {{-- هدر کارت --}}
      <div class="d-flex align-items-center mb-2">
        <div class="fw-bold">{{ $s->user->name ?? '—' }}</div>
        <span class="ms-auto badge 
          {{ $s->status==='active'
              ? 'bg-success'
              : ($s->status==='waiting'
                  ? 'bg-warning text-dark'
                  : 'bg-secondary') }}">
          {{ $s->status==='waiting'
              ? ($waitingReady ? 'در انتظار فعالسازی توسط ادمین' : 'در انتظار انتخاب بازی توسط کاربر')
              : ($s->status==='active' ? 'فعال' : 'پایان یافته') }}
        </span>
      </div>

      {{-- شماره تلفن --}}
      <div class="small text-muted mb-1">{{ $s->user->phone ?? '—' }}</div>

      {{-- 🔹 شماره اشتراک (افزوده شده جدید) --}}
      <div class="small mb-2">
        <b>شماره اشتراک:</b>
        <span class="text-primary fw-semibold">{{ $s->subscription_code ?? '—' }}</span>
      </div>

      {{-- جزئیات اشتراک --}}
      <div class="row g-2 small">
        <div class="col-6"><b>پلن:</b> {{ $s->plan->name ?? '—' }}</div>
        @php $durLabel = (int)$s->duration_months === 0 ? 'آفلاین - نامحدود' : ($s->duration_months . ' ماهه'); @endphp
        <div class="col-6"><b>مدت:</b> {{ $durLabel }}</div>
        <div class="col-6"><b>خرید:</b> 
          {{ $s->purchased_at ? Jalalian::fromCarbon($s->purchased_at)->format('Y/m/d H:i') : '—' }}
        </div>
        <div class="col-6"><b>درخواستی:</b> 
          {{ $s->requested_at ? Jalalian::fromCarbon($s->requested_at)->format('Y/m/d H:i') : '—' }}
        </div>
        <div class="col-6">
          <b>فرصت انتخاب:</b>
          @if($s->selection_deadline)
            @if($waitingReady)
              <span class="text-success">بازی‌ها انتخاب شدند</span>
              @if($s->selection_delay_days > 0)
                <div class="small text-danger">{{ $s->selection_delay_days }} روز تأخیر</div>
              @endif
            @elseif($s->status==='waiting')
              <span class="timer selection-timer" data-selection="{{ $s->selection_deadline->toIso8601String() }}">...</span>
              @if($s->selection_delay_days > 0)
                <div class="small text-danger">{{ $s->selection_delay_days }} روز تأخیر</div>
              @endif
            @elseif($s->selection_delay_days > 0)
              <span class="text-danger">مهلت تمام شد ({{ $s->selection_delay_days }} روز تأخیر)</span>
            @else
              <span class="text-muted">-</span>
            @endif
          @else
            <span class="text-muted">-</span>
          @endif
        </div>
        <div class="col-6"><b>شروع:</b> 
          {{ $s->activated_at ? Jalalian::fromCarbon($s->activated_at)->format('Y/m/d H:i') : '—' }}
        </div>
        <div class="col-6"><b>پایان:</b> 
          {{ $s->ends_at ? Jalalian::fromCarbon($s->ends_at)->format('Y/m/d H:i') : '—' }}
        </div>
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

      {{-- دکمه‌ها --}}
      <div class="text-end mt-2">
        <button type="button"
                class="btn btn-sm btn-outline-info me-1 mb-1"
                data-bs-toggle="modal"
                data-bs-target="#{{ $accountModalId }}">
          <i class="bi bi-person-lines-fill"></i> جزئیات اکانت
        </button>
        <button type="button"
                class="btn btn-sm btn-outline-primary me-1 mb-1"
                data-bs-toggle="modal"
                data-bs-target="#{{ $gamesModalId }}">
          <i class="bi bi-controller"></i> تغییر بازی‌ها
        </button>
        @if(($s->status==='active' && $s->ends_at) || $s->status==='waiting')
          <button type="button"
                  class="btn btn-sm btn-outline-secondary me-1 mb-1"
                  data-bs-toggle="modal"
                  data-bs-target="#{{ $timeModalId }}">
            <i class="bi bi-clock-history"></i> مدیریت زمان
          </button>
        @endif
        @if($s->status==='active' && ($s->next_swap_at || (int) ($s->swap_every_days ?? 0) > 0))
          <button type="button"
                  class="btn btn-sm btn-outline-warning me-1 mb-1"
                  data-bs-toggle="modal"
                  data-bs-target="#{{ $swapTimeModalId }}">
            <i class="bi bi-arrow-repeat"></i> مدیریت زمان تعویض
          </button>
        @endif
        {{-- <a href="{{ route('admin.subscriptions.show',$s) }}" class="btn btn-sm btn-outline-info me-1">
          <i class="bi bi-receipt"></i> رسید
        </a> --}}
        @if($s->status==='waiting')
          <form class="d-inline" method="POST" action="{{ route('admin.subscriptions.activate',$s) }}">
            @csrf
            <button class="btn btn-sm btn-outline-success">
              <i class="bi bi-play"></i> فعال
            </button>
          </form>
        @elseif($s->status==='active')
          <form class="d-inline" method="POST" action="{{ route('admin.subscriptions.finish',$s) }}">
            @csrf
            <button class="btn btn-sm btn-outline-danger">
              <i class="bi bi-stop"></i> پایان
            </button>
          </form>
        @endif
      </div>
    </div>
  @empty
    <div class="text-center text-muted py-4">موردی یافت نشد.</div>
  @endforelse
</div>
@foreach($subscriptions as $modalSubscription)
  @php
    $modalId = 'accountModal-' . $modalSubscription->id;
    $oldContextId = old('context_subscription_id');
    $isActiveModal = $oldContextId && (int) $oldContextId === $modalSubscription->id;
    $modalTextareaValue = $isActiveModal ? old('account_details') : $modalSubscription->account_details;
  @endphp
  <div class="modal fade account-details-modal" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">جزئیات اکانت اشتراک</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
        </div>
        <form method="POST" action="{{ route('admin.subscriptions.account_details', $modalSubscription) }}">
          @csrf
          <input type="hidden" name="context_subscription_id" value="{{ $modalSubscription->id }}">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">اطلاعات ورود / توضیحات نصب</label>
              <textarea
                name="account_details"
                class="form-control"
                rows="7"
                placeholder="نام کاربری، پسورد، توضیحات نصب و ... را اینجا ثبت کنید.">{{ $modalTextareaValue ?? '' }}</textarea>
              @if($isActiveModal && $errors->has('account_details'))
                <div class="text-danger small mt-1">{{ $errors->first('account_details') }}</div>
              @endif
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">بستن</button>
            <button type="submit" class="btn btn-primary">ذخیره جزئیات</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endforeach

@foreach($subscriptions as $gamesSubscription)
  @php
    $gamesModalId = 'gamesModal-' . $gamesSubscription->id;
    $selectedGames = collect($gamesSubscription->active_games ?? []);
    $level1Count = max(0, (int) optional($gamesSubscription->plan)->level1_selection);
    $totalSlots  = max(0, (int) optional($gamesSubscription->plan)->concurrent_games);
    $otherCount  = max(0, $totalSlots - $level1Count);
  @endphp
  <div class="modal fade account-details-modal" id="{{ $gamesModalId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">تغییر بازی‌های اشتراک</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
        </div>
        @if(!$gamesSubscription->plan)
          <div class="modal-body">
            <div class="alert alert-warning mb-0">پلن این اشتراک یافت نشد.</div>
          </div>
        @elseif($totalSlots === 0)
          <div class="modal-body">
            <div class="alert alert-warning mb-0">این پلن هیچ اسلات فعالی برای بازی ندارد.</div>
          </div>
        @else
          <form method="POST" action="{{ route('admin.subscriptions.games', $gamesSubscription) }}">
            @csrf
            <div class="modal-body">
              <div class="mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                  <div class="fw-bold">{{ $gamesSubscription->plan->name }}</div>
                  <div class="text-muted small">تعداد اسلات: {{ $totalSlots }} | سطح ۱: {{ $level1Count }} | سایر: {{ $otherCount }}</div>
                </div>
                <div class="text-end">
                  <span class="badge bg-secondary">{{ $gamesSubscription->subscription_code }}</span>
                </div>
              </div>
              <div class="row g-3">
                @for($i = 0; $i < $level1Count; $i++)
                  @php $selectedName = $selectedGames->get($i); @endphp
                  <div class="col-md-6">
                    <label class="form-label">بازی سطح ۱ ({{ $i + 1 }})</label>
                    <select class="form-select" name="games[level1][]" required>
                      <option value="">-- انتخاب بازی سطح ۱ --</option>
                      @foreach($level1And2Games as $game)
                        <option value="{{ $game->id }}" {{ $selectedName === $game->name ? 'selected' : '' }}>{{ $game->name }}</option>
                      @endforeach
                    </select>
                  </div>
                @endfor
                @for($i = 0; $i < $otherCount; $i++)
                  @php $selectedName = $selectedGames->get($level1Count + $i); @endphp
                  <div class="col-md-6">
                    <label class="form-label">بازی دیگر ({{ $i + 1 }})</label>
                    <select class="form-select" name="games[other][]" required>
                      <option value="">-- انتخاب بازی --</option>
                      @foreach($otherGames as $game)
                        <option value="{{ $game->id }}" {{ $selectedName === $game->name ? 'selected' : '' }}>{{ $game->name }}</option>
                      @endforeach
                    </select>
                  </div>
                @endfor
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">انصراف</button>
              <button type="submit" class="btn btn-primary">ذخیره بازی‌ها</button>
            </div>
          </form>
        @endif
      </div>
    </div>
  </div>
@endforeach

@foreach($subscriptions as $timeSubscription)
  @php
    $timeModalId = 'timeModal-' . $timeSubscription->id;
    $timeBaseAt = $timeSubscription->status === 'waiting'
      ? ($timeSubscription->selection_deadline ?? $timeSubscription->purchased_at ?? $timeSubscription->created_at)
      : $timeSubscription->ends_at;
    $timeBaseAtIso = $timeBaseAt?->toIso8601String();
    $timeBaseAtLabel = $timeBaseAt ? Jalalian::fromCarbon($timeBaseAt)->format('Y/m/d H:i') : '—';
    $timeRemainingDays = $timeBaseAt ? max(0, now()->diffInDays($timeBaseAt, false)) : null;
  @endphp
  @if(($timeSubscription->status === 'active' && $timeSubscription->ends_at) || $timeSubscription->status === 'waiting')
    <div class="modal fade time-manage-modal" id="{{ $timeModalId }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">مدیریت زمان اشتراک</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
          </div>
          <form method="POST" action="{{ route('admin.subscriptions.time', $timeSubscription) }}" class="time-manage-form">
            @csrf
            <div class="modal-body">
              <div class="row g-2">
                <div class="col-6">
                  <div class="time-manage-summary">
                    <div class="label">زمان پایان فعلی</div>
                    <div class="value">{{ $timeBaseAtLabel }}</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="time-manage-summary">
                    <div class="label">روز باقی‌مانده</div>
                    <div class="value">{{ $timeRemainingDays !== null ? $timeRemainingDays : '0' }}</div>
                  </div>
                </div>
              </div>
              <div class="mt-3">
                <label class="form-label">تغییر زمان (روز)</label>
                <input type="number" class="form-control time-adjust-days" name="adjust_days" min="-3650" max="3650" step="1" value="0" required data-base-end="{{ $timeBaseAtIso }}">
              </div>
              <div class="time-manage-quick mt-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-add-days="1">+1</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-add-days="7">+7</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-add-days="30">+30</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-add-days="-1">-1</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-add-days="-7">-7</button>
              </div>
              <div class="time-manage-preview mt-3">
                <div class="label">زمان نهایی پیش از ذخیره</div>
                <div class="value time-final-preview">{{ $timeBaseAtLabel }}</div>
              </div>
              <div class="form-check mt-3">
                <input class="form-check-input time-send-sms-toggle" type="checkbox" value="1" name="send_sms" id="sendSms-{{ $timeSubscription->id }}">
                <label class="form-check-label" for="sendSms-{{ $timeSubscription->id }}">
                  ارسال پیامک
                </label>
              </div>
              <div class="mt-2 d-none time-sms-wrapper">
                <label class="form-label">متن پیامک</label>
                <textarea name="sms_message" class="form-control time-sms-message" rows="4" maxlength="1000" placeholder="متن دلخواه پیامک را وارد کنید."></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">انصراف</button>
              <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif
@endforeach

@foreach($subscriptions as $swapSubscription)
  @php
    $swapTimeModalId = 'swapTimeModal-' . $swapSubscription->id;
    $swapBaseAt = $swapSubscription->next_swap_at
      ?? (((int) ($swapSubscription->swap_every_days ?? 0) > 0) ? now()->addDays((int) $swapSubscription->swap_every_days) : null);
    $swapBaseAtIso = $swapBaseAt?->toIso8601String();
    $swapBaseAtLabel = $swapBaseAt ? Jalalian::fromCarbon($swapBaseAt)->format('Y/m/d H:i') : '—';
    $swapRemainingDays = $swapBaseAt ? max(0, now()->diffInDays($swapBaseAt, false)) : null;
  @endphp
  @if($swapSubscription->status === 'active' && ($swapSubscription->next_swap_at || (int) ($swapSubscription->swap_every_days ?? 0) > 0))
    <div class="modal fade time-manage-modal" id="{{ $swapTimeModalId }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">مدیریت زمان تعویض بازی</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
          </div>
          <form method="POST" action="{{ route('admin.subscriptions.swap_time', $swapSubscription) }}" class="time-manage-form">
            @csrf
            <div class="modal-body">
              <div class="row g-2">
                <div class="col-6">
                  <div class="time-manage-summary">
                    <div class="label">زمان تعویض فعلی</div>
                    <div class="value">{{ $swapBaseAtLabel }}</div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="time-manage-summary">
                    <div class="label">روز باقی‌مانده تا تعویض</div>
                    <div class="value">{{ $swapRemainingDays !== null ? $swapRemainingDays : '0' }}</div>
                  </div>
                </div>
              </div>
              <div class="mt-3">
                <label class="form-label">تغییر زمان تعویض (روز)</label>
                <input type="number" class="form-control time-adjust-days" name="adjust_days" min="-3650" max="3650" step="1" value="0" required data-base-end="{{ $swapBaseAtIso }}">
              </div>
              <div class="time-manage-quick mt-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-add-days="1">+1</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-add-days="7">+7</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-add-days="30">+30</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-add-days="-1">-1</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-add-days="-7">-7</button>
              </div>
              <div class="time-manage-preview mt-3">
                <div class="label">زمان نهایی تعویض پیش از ذخیره</div>
                <div class="value time-final-preview">{{ $swapBaseAtLabel }}</div>
              </div>
              <div class="form-check mt-3">
                <input class="form-check-input time-send-sms-toggle" type="checkbox" value="1" name="send_sms" id="swapSendSms-{{ $swapSubscription->id }}">
                <label class="form-check-label" for="swapSendSms-{{ $swapSubscription->id }}">
                  ارسال پیامک
                </label>
              </div>
              <div class="mt-2 d-none time-sms-wrapper">
                <label class="form-label">متن پیامک</label>
                <textarea name="sms_message" class="form-control time-sms-message" rows="4" maxlength="1000" placeholder="متن دلخواه پیامک را وارد کنید."></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">انصراف</button>
              <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif
@endforeach


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

  function formatFinalDate(dateObj){
    try{
      return new Intl.DateTimeFormat('fa-IR-u-ca-persian', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      }).format(dateObj);
    }catch(e){
      return dateObj.toLocaleString('fa-IR');
    }
  }

  function updateTimePreview(form){
    const input = form.querySelector('.time-adjust-days');
    const preview = form.querySelector('.time-final-preview');
    if (!input || !preview) return;
    const baseEnd = input.getAttribute('data-base-end');
    if (!baseEnd) return;
    const days = parseInt(input.value || '0', 10);
    const safeDays = Number.isNaN(days) ? 0 : days;
    const baseMs = new Date(baseEnd).getTime();
    const finalDate = new Date(baseMs + (safeDays * 86400000));
    preview.textContent = formatFinalDate(finalDate);
  }

  document.querySelectorAll('.time-manage-form').forEach(form=>{
    updateTimePreview(form);

    const smsToggle = form.querySelector('.time-send-sms-toggle');
    const smsWrapper = form.querySelector('.time-sms-wrapper');
    const smsMessage = form.querySelector('.time-sms-message');
    if (smsToggle && smsWrapper && smsMessage) {
      const syncSmsVisibility = ()=>{
        const checked = smsToggle.checked;
        smsWrapper.classList.toggle('d-none', !checked);
        smsMessage.required = checked;
      };
      syncSmsVisibility();
      smsToggle.addEventListener('change', syncSmsVisibility);
    }

    form.addEventListener('input', (e)=>{
      if (e.target.classList.contains('time-adjust-days')) {
        updateTimePreview(form);
      }
    });

    form.querySelectorAll('[data-add-days]').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const input = form.querySelector('.time-adjust-days');
        if (!input) return;
        const delta = parseInt(btn.getAttribute('data-add-days') || '0', 10);
        const current = parseInt(input.value || '0', 10);
        input.value = String((Number.isNaN(current) ? 0 : current) + (Number.isNaN(delta) ? 0 : delta));
        updateTimePreview(form);
      });
    });

    form.addEventListener('submit', (e)=>{
      if (!window.confirm('آیا مطمئن هستید؟')) {
        e.preventDefault();
      }
    });
  });

  function tick(){
    const now = new Date().getTime();

    // پایان اشتراک
    document.querySelectorAll('.selection-timer').forEach(el=>{
      const deadline = el.getAttribute('data-selection');
      if (!deadline) { el.textContent = '\u2014'; el.classList.remove('text-danger'); return; }
      const t = new Date(deadline).getTime() - now;
      const secs = Math.floor(t/1000);
      if (secs > 0) {
        el.textContent = fmt(secs);
        el.classList.remove('text-danger');
      } else {
        el.textContent = '\u0645\u0647\u0644\u062a \u062a\u0645\u0627\u0645 \u0634\u062f';
        el.classList.add('text-danger');
      }
    });

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
