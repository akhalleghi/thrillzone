@extends('admin.layouts.app')
@section('title','مدیریت نوبت‌ها')

@section('content')
@php use Morilog\Jalali\Jalalian; @endphp

<style>
.card-glass{background:var(--panel);border:1px solid var(--border);border-radius:14px;padding:1rem;}
.table th,.table td{border-color:var(--border);vertical-align:middle;}
.sub-card{background:rgba(255,255,255,.05);border:1px solid var(--border);border-radius:14px;padding:1rem;}
[data-theme=light] .sub-card{background:#fff;}
</style>
{{-- Persian Datepicker (local) --}}
<link rel="stylesheet" href="{{ asset('vendor/persian-datepicker/persian-datepicker.min.css') }}">


<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="section-title">مدیریت نوبت‌ها</h4>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal">
    <i class="bi bi-plus-lg"></i> افزودن نوبت جدید
  </button>
</div>

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif



<div class="card-glass">

  {{-- دسکتاپ --}}
  <div class="d-none d-lg-block">
    <table class="table table-dark align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>روز هفته</th>
          <th>تاریخ</th>
          <th>ساعت</th>
          <th>وضعیت</th>
          <th>رزروکننده</th>
          <th>عملیات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($bookings as $i => $b)
          <tr>
            <td>{{ $bookings->firstItem() + $i }}</td>
            <td>{{ $b->day_of_week_fa }}</td>
            <td>{{ $b->jalali_date }}</td>
            <td>{{ $b->time_range }}</td>
            <td>
              @if($b->status=='reserved')
                <span class="badge bg-danger">رزرو شده</span>
              @else
                <span class="badge bg-success">آزاد</span>
              @endif
            </td>
            <td>{{ $b->user->name ?? '—' }}</td>
            <td>
              <form method="POST" action="{{ route('admin.bookings.destroy',$b) }}" onsubmit="return confirm('حذف این نوبت؟')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted py-3">هیچ نوبتی تعریف نشده.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- موبایل --}}
  <div class="d-lg-none">
    @forelse($bookings as $b)
      <div class="sub-card mb-3">
        <div class="fw-bold mb-1">{{ $b->day_of_week_fa }} - {{ $b->jalali_date }}</div>
        <div><b>ساعت:</b> {{ $b->time_range }}</div>
        <div><b>وضعیت:</b> 
          @if($b->status=='reserved')
            <span class="badge bg-danger">رزرو شده</span>
          @else
            <span class="badge bg-success">آزاد</span>
          @endif
        </div>
        <div><b>رزروکننده:</b> {{ $b->user->name ?? '—' }}</div>
        <div class="text-end mt-2">
          <form method="POST" action="{{ route('admin.bookings.destroy',$b) }}" onsubmit="return confirm('حذف نوبت؟')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> حذف</button>
          </form>
        </div>
      </div>
    @empty
      <div class="text-center text-muted py-4">هیچ نوبتی وجود ندارد.</div>
    @endforelse
  </div>

  <div class="mt-3">{{ $bookings->links('pagination::bootstrap-5') }}</div>
</div>

<!-- Modal: افزودن نوبت جدید -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form method="POST" action="{{ route('admin.bookings.store') }}" class="modal-content"
          style="background: linear-gradient(135deg, rgba(18, 24, 54, 0.96), rgba(30, 16, 66, 0.94)); color: var(--text); border: 1px solid var(--border)">
      @csrf

      <div class="modal-header border-0">
        <h5 class="modal-title" id="bookingModalLabel">نوبت جدید</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          {{-- تاریخ شمسی --}}
          <div class="col-md-4">
            <label class="form-label">تاریخ (شمسی) <span class="text-danger">*</span></label>
            <input type="text" id="date_jalali" name="date_jalali" class="form-control" placeholder="مثلاً 1404/08/10" autocomplete="off" required>
            <div class="form-text">روی کادر کلیک کنید تا تقویم باز شود.</div>
          </div>

          {{-- شروع: ساعت/دقیقه --}}
          <div class="col-md-4">
            <label class="form-label">ساعت شروع <span class="text-danger">*</span></label>
            <div class="d-flex gap-2">
              <select class="form-select" name="start_hour" id="start_hour" required>
                @for($h=0;$h<24;$h++)
                  <option value="{{ sprintf('%02d',$h) }}">{{ sprintf('%02d',$h) }}</option>
                @endfor
              </select>
              <select class="form-select" name="start_minute" id="start_minute" required>
                @for($m=0;$m<60;$m+=5)
                  <option value="{{ sprintf('%02d',$m) }}">{{ sprintf('%02d',$m) }}</option>
                @endfor
              </select>
            </div>
            <div class="form-text">۲۴ ساعته | گام ۵ دقیقه</div>
          </div>

          {{-- پایان: ساعت/دقیقه --}}
          <div class="col-md-4">
            <label class="form-label">ساعت پایان <span class="text-danger">*</span></label>
            <div class="d-flex gap-2">
              <select class="form-select" name="end_hour" id="end_hour" required>
                @for($h=0;$h<24;$h++)
                  <option value="{{ sprintf('%02d',$h) }}">{{ sprintf('%02d',$h) }}</option>
                @endfor
              </select>
              <select class="form-select" name="end_minute" id="end_minute" required>
                @for($m=0;$m<60;$m+=5)
                  <option value="{{ sprintf('%02d',$m) }}">{{ sprintf('%02d',$m) }}</option>
                @endfor
              </select>
            </div>
            <div class="form-text">پایان باید بعد از شروع باشد.</div>
          </div>

          {{-- روز هفته (اختیاری، برای فیلتر/نمایش) --}}
          <div class="col-md-4">
            <label class="form-label">روز هفته </label>
            <select class="form-select" name="weekday" required>
              <option value="">—</option>
              <option value="saturday">شنبه</option>
              <option value="sunday">یکشنبه</option>
              <option value="monday">دوشنبه</option>
              <option value="tuesday">سه‌شنبه</option>
              <option value="wednesday">چهارشنبه</option>
              <option value="thursday">پنجشنبه</option>
              <option value="friday">جمعه</option>
            </select>
          </div>

          {{-- توضیحات (اختیاری) --}}
          <div class="col-md-8">
            <label class="form-label">توضیحات</label>
            <input type="text" name="notes" class="form-control" placeholder="مثلاً: تماس واتساپ / هماهنگی نصب دیتا">
          </div>

          {{-- میان‌بُرها --}}
          <div class="col-12">
            <div class="d-flex flex-wrap gap-2">
              <button class="btn btn-sm btn-outline-info" type="button" id="btnAdd30">پایان = شروع + 30 دقیقه</button>
              <button class="btn btn-sm btn-outline-info" type="button" id="btnAdd60">پایان = شروع + 60 دقیقه</button>
              <button class="btn btn-sm btn-outline-secondary" type="button" id="btnNow">شروع = اکنون (گرد به 5 دقیقه)</button>
              <button class="btn btn-sm btn-outline-secondary" type="button" id="btnResetTimes">ریست ساعات</button>
            </div>
          </div>

          {{-- هشدار اعتبارسنجی در کلاینت (اختیاری) --}}
          <div class="col-12">
            <div id="timeError" class="alert alert-danger d-none py-2 mb-0">ساعت پایان باید بعد از ساعت شروع باشد.</div>
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

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/persian-datepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('vendor/persian-datepicker/persian-datepicker.min.js') }}"></script>


{{-- اسکریپت راه‌اندازی تقویم و منطق زمان --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // ===== Jalali Datepicker =====
    $('#date_jalali').pDatepicker({
      format: 'YYYY/MM/DD',
      initialValueType: 'gregorian', // فقط نمایش؛ مقدار خروجی جلالی ست
      autoClose: true,
      minDate: null,
      observer: true,
      calendar: {
        persian: { locale: 'fa', leapYearMode: 'algorithmic' },
        gregorian: { locale: 'en' }
      },
      toolbox: { calendarSwitch: { enabled: true } }
    });

    // ===== ابزارک زمان‌ها =====
    const startH = document.getElementById('start_hour');
    const startM = document.getElementById('start_minute');
    const endH   = document.getElementById('end_hour');
    const endM   = document.getElementById('end_minute');
    const errBox = document.getElementById('timeError');

    function toMinutes(h, m){ return parseInt(h,10)*60 + parseInt(m,10); }
    function setFromMinutes(selectH, selectM, minutes){
      let hh = Math.floor((minutes/60)) % 24;
      let mm = minutes % 60;
      selectH.value = String(hh).padStart(2,'0');
      // گرد به 5 دقیقه
      mm = Math.round(mm/5)*5;
      if(mm===60){ mm=0; hh=(hh+1)%24; selectH.value = String(hh).padStart(2,'0'); }
      selectM.value = String(mm).padStart(2,'0');
    }

    function validateTimes(){
      const s = toMinutes(startH.value, startM.value);
      const e = toMinutes(endH.value,   endM.value);
      if(e <= s){ errBox.classList.remove('d-none'); return false; }
      errBox.classList.add('d-none'); return true;
    }

    [startH,startM,endH,endM].forEach(el => el.addEventListener('change', validateTimes));

    // میان‌برها
    document.getElementById('btnAdd30').addEventListener('click', ()=>{
      const s = toMinutes(startH.value, startM.value);
      setFromMinutes(endH, endM, s + 30);
      validateTimes();
    });
    document.getElementById('btnAdd60').addEventListener('click', ()=>{
      const s = toMinutes(startH.value, startM.value);
      setFromMinutes(endH, endM, s + 60);
      validateTimes();
    });
    document.getElementById('btnNow').addEventListener('click', ()=>{
      const now = new Date();
      setFromMinutes(startH, startM, now.getHours()*60 + now.getMinutes());
      // پیش‌فرض پایان +30
      const s = toMinutes(startH.value, startM.value);
      setFromMinutes(endH, endM, s + 30);
      validateTimes();
    });
    document.getElementById('btnResetTimes').addEventListener('click', ()=>{
      startH.value='07'; startM.value='00';
      endH.value='07';   endM.value='30';
      validateTimes();
    });

    // مقدارهای اولیه خوش‌دست
    startH.value='07'; startM.value='00';
    endH.value='07';   endM.value='30';
  });
</script>

@endsection
