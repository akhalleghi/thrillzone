@extends('admin.layouts.app')
@section('title', 'مدیریت کدهای تخفیف')

@php use Morilog\Jalali\Jalalian; @endphp

@section('content')
<style>
  .card-glass{background:var(--panel);border:1px solid var(--border);border-radius:14px;padding:1rem;}
  .section-title{background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-weight:800;}
  .sub-card{background:rgba(255,255,255,.05);border:1px solid var(--border);border-radius:14px;padding:1rem;}
  [data-theme="light"] .sub-card{background:#fff;}
</style>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h4 class="section-title m-0">مدیریت کدهای تخفیف</h4>
  <button class="neon-btn" data-bs-toggle="modal" data-bs-target="#couponModal" data-mode="create">
    <i class="bi bi-plus-lg"></i> افزودن کد جدید
  </button>
</div>

@if(session('success'))<div class="alert alert-success">{{session('success')}}</div>@endif

<div class="card-glass">
  {{-- نسخه دسکتاپ --}}
  <div class="table-responsive d-none d-md-block">
    <table class="table table-dark align-middle mb-0">
      <thead>
        <tr>
          <th>#</th>
          <th>کد</th>
          <th>نوع</th>
          <th>کاربر</th>
          <th>مبلغ</th>
          <th>نوع تخفیف</th>
          <th>تعداد استفاده</th>
          <th>تاریخ انقضا</th>
          <th>وضعیت</th>
          <th>عملیات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($coupons as $i => $c)
          <tr>
            <td>{{ $coupons->firstItem() + $i }}</td>
            <td class="fw-bold">{{ $c->code }}</td>

            {{-- نوع کوپن --}}
            <td>{{ $c->type === 'public' ? 'عمومی' : 'کاربر خاص' }}</td>

            {{-- کاربر --}}
            <td>{{ $c->user?->name ?? '—' }}</td>

            {{-- مبلغ --}}
            <td>{{ number_format($c->amount) }} {{ $c->discount_type === 'percent' ? '%' : 'تومان' }}</td>

            {{-- نوع تخفیف (درصدی / مبلغ ثابت) --}}
            <td>{{ $c->discount_type_label ?? '—' }}</td>

            {{-- تعداد استفاده --}}
            <td>{{ $c->used_count ?? 0 }} / {{ $c->usage_limit ?? '—' }}</td>

            {{-- تاریخ انقضا --}}
            <td>{{ $c->expires_at ? Jalalian::fromCarbon($c->expires_at)->format('Y/m/d H:i') : '—' }}</td>

            {{-- وضعیت --}}
            <td>
              @php
                $expired = $c->expires_at && $c->expires_at->isPast();
              @endphp
              <span class="badge {{ $expired ? 'bg-warning text-dark' : ($c->is_active ? 'bg-success' : 'bg-secondary') }}">
                {{ $expired ? 'منقضی' : ($c->is_active ? 'فعال' : 'غیرفعال') }}
              </span>
            </td>

            {{-- عملیات --}}
            <td>
              <button class="btn btn-sm btn-outline-info me-1"
                      data-bs-toggle="modal" data-bs-target="#couponModal"
                      data-mode="edit"
                      data-id="{{ $c->id }}"
                      data-code="{{ $c->code }}"
                      data-type="{{ $c->type }}"
                      data-user="{{ $c->user_id }}"
                      data-amount="{{ $c->amount }}"
                      data-disctype="{{ $c->discount_type }}"
                      data-limit="{{ $c->usage_limit }}"
                      data-expire="{{ $c->expires_at ? Jalalian::fromCarbon($c->expires_at)->format('Y/m/d H:i') : '' }}">
                <i class="bi bi-pencil"></i>
              </button>

              <form method="POST" action="{{ route('admin.coupons.destroy', $c) }}" class="d-inline"
                    onsubmit="return confirm('حذف این کد قطعی است؟')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="10" class="text-center text-muted py-4">هیچ کدی یافت نشد.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- نسخه موبایل --}}
  <div class="d-md-none">
    @forelse($coupons as $c)
      <div class="sub-card mb-3">
        <div class="d-flex justify-content-between">
          <span class="fw-bold">{{ $c->code }}</span>
          @php $expired = $c->expires_at && $c->expires_at->isPast(); @endphp
          <span class="badge {{ $expired ? 'bg-warning text-dark' : ($c->is_active ? 'bg-success' : 'bg-secondary') }}">
            {{ $expired ? 'منقضی' : ($c->is_active ? 'فعال' : 'غیرفعال') }}
          </span>
        </div>

        <div class="small mt-2">
          نوع: {{ $c->type==='public'?'عمومی':'کاربر خاص' }}<br>
          مبلغ: {{ number_format($c->amount) }} {{ $c->discount_type==='percent'?'%':'تومان' }}<br>
          نوع تخفیف: {{ $c->discount_type_label ?? '—' }}<br>
          کاربر: {{ $c->user?->name ?? '—' }}<br>
          استفاده: {{ $c->used_count ?? 0 }} از {{ $c->usage_limit ?? '—' }}<br>
          انقضا: {{ $c->expires_at ? Jalalian::fromCarbon($c->expires_at)->format('Y/m/d H:i') : '—' }}
        </div>

        <div class="text-end mt-2">
          <button class="btn btn-sm btn-outline-info"
                  data-bs-toggle="modal" data-bs-target="#couponModal"
                  data-mode="edit"
                  data-id="{{ $c->id }}"
                  data-code="{{ $c->code }}"
                  data-type="{{ $c->type }}"
                  data-user="{{ $c->user_id }}"
                  data-amount="{{ $c->amount }}"
                  data-disctype="{{ $c->discount_type }}"
                  data-limit="{{ $c->usage_limit }}"
                  data-expire="{{ $c->expires_at ? Jalalian::fromCarbon($c->expires_at)->format('Y/m/d H:i') : '' }}">
            <i class="bi bi-pencil"></i> ویرایش
          </button>
        </div>
      </div>
    @empty
      <div class="text-center text-muted py-4">هیچ کدی نیست.</div>
    @endforelse
  </div>

  <div class="mt-3">
    {{ $coupons->links('pagination::bootstrap-5') }}
  </div>
</div>


{{-- مودال --}}
{{-- مودال افزودن / ویرایش کد تخفیف --}}
<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form id="couponForm" method="POST" class="modal-content"
          style="background: linear-gradient(135deg, rgba(18, 24, 54, 0.96), rgba(30, 16, 66, 0.94)); color: var(--text); border: 1px solid var(--border)">
      @csrf
      <input type="hidden" name="_method" value="POST" id="methodField">

      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="couponModalLabel">افزودن کد تخفیف جدید</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">کد تخفیف</label>
            <input type="text" name="code" id="codeFld" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">نوع</label>
            <select name="type" id="typeFld" class="form-select">
              <option value="public">عمومی</option>
              <option value="user_specific">کاربر خاص</option>
            </select>
          </div>

          <div class="col-md-6 user-select-wrap d-none">
            <label class="form-label">انتخاب کاربر</label>
            <select name="user_id" id="userFld" class="form-select">
              <option value="">انتخاب کاربر...</option>
              @foreach(\App\Models\User::all() as $u)
                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->phone }})</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">مقدار</label>
            <input type="number" name="amount" id="amountFld" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">نوع تخفیف</label>
            <select name="discount_type" id="discFld" class="form-select">
              <option value="fixed">مبلغ ثابت</option>
              <option value="percent">درصدی</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">حداکثر استفاده</label>
            <input type="number" name="usage_limit" id="limitFld" class="form-control" required min="1">
          </div>

          <div class="col-md-6">
            <label class="form-label">تاریخ انقضا (اختیاری)</label>
            <input type="text" name="expires_at" id="expireFld" class="form-control" placeholder="مثلاً 1403/09/15 12:00">
          </div>
        </div>
      </div>

      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
        <button type="submit" class="neon-btn">ذخیره</button>
      </div>
    </form>
  </div>
</div>


{{-- Persian Datepicker --}}
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/persian-datepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('vendor/persian-datepicker/persian-datepicker.min.js') }}"></script>
<link href="{{ asset('vendor/persian-datepicker/persian-datepicker.min.css') }}" rel="stylesheet">

<script>
  $(document).ready(function() {
    $('#expireFld').persianDatepicker({
      format: 'YYYY/MM/DD HH:mm',
      timePicker: {
        enabled: true,
        meridiem: {
          enabled: false
        }
      },
      initialValue: false,
      autoClose: true,
      toolbox: {
        calendarSwitch: { enabled: false },
        todayButton: { enabled: true, text: "امروز" },
        submitButton: { enabled: true, text: "تأیید" }
      }
    });
  });
</script>



<script>
  const modal = document.getElementById('couponModal');
  const form = document.getElementById('couponForm');
  const methodFld = document.getElementById('methodField');
  const title = modal.querySelector('.modal-title');
  const typeFld = document.getElementById('typeFld');
  const userWrap = document.querySelector('.user-select-wrap');
  const userFld = document.getElementById('userFld');

  typeFld.addEventListener('change', ()=> userWrap.classList.toggle('d-none', typeFld.value!=='user_specific'));

  modal.addEventListener('show.bs.modal', function(e){
    const btn = e.relatedTarget;
    const mode = btn?.getAttribute('data-mode') || 'create';
    form.reset();

    if(mode==='create'){
      title.textContent = 'افزودن کد تخفیف جدید';
      form.action = "{{ route('admin.coupons.store') }}";
      methodFld.value = 'POST';
    }else{
      title.textContent = 'ویرایش کد تخفیف';
      const id = btn.getAttribute('data-id');
      form.action = "{{ route('admin.coupons.update', '__ID__') }}".replace('__ID__', id);
      methodFld.value = 'PUT';
      document.getElementById('codeFld').value = btn.getAttribute('data-code');
      typeFld.value = btn.getAttribute('data-type');
      userFld.value = btn.getAttribute('data-user');
      document.getElementById('amountFld').value = btn.getAttribute('data-amount');
      document.getElementById('discFld').value = btn.getAttribute('data-disctype');
      document.getElementById('limitFld').value = btn.getAttribute('data-limit');
      document.getElementById('expireFld').value = btn.getAttribute('data-expire');
      userWrap.classList.toggle('d-none', typeFld.value!=='user_specific');
    }
  });
</script>
@endsection
