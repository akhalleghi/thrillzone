{{--<!DOCTYPE html>--}}
{{--<html lang="fa" dir="rtl">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>داشبورد مدیریت | منطقه هیجان</title>--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">--}}
{{--    <style>--}}
{{--        body{background:#0b0f2a;color:#fff}--}}
{{--        .topbar{background:linear-gradient(135deg,#11173e,#16163c);border-bottom:1px solid rgba(0,255,255,.2)}--}}
{{--        .btn-neon{background:linear-gradient(135deg,#00ffff,#ff00ff);border:none;border-radius:10px;color:#fff;font-weight:700}--}}
{{--        .btn-neon:hover{box-shadow:0 0 25px rgba(255,0,255,.5)}--}}
{{--        a{color:#00ffff} a:hover{color:#ff00ff}--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<nav class="topbar p-3 d-flex justify-content-between align-items-center">--}}
{{--    <div>🎮 پنل مدیریت منطقه هیجان</div>--}}
{{--    <form method="POST" action="{{ route('admin.logout') }}">--}}
{{--        @csrf--}}
{{--        <button class="btn btn-neon btn-sm">خروج</button>--}}
{{--    </form>--}}
{{--</nav>--}}

{{--<div class="container py-4">--}}
{{--    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif--}}

{{--    <div class="row g-3">--}}
{{--        <div class="col-md-4">--}}
{{--            <div class="p-4 rounded" style="background:linear-gradient(135deg,rgba(20,25,50,.92),rgba(40,20,70,.88));border:1px solid rgba(0,255,255,.25);">--}}
{{--                <h5>مدیریت پلن‌ها</h5>--}}
{{--                <p class="text-muted">تعریف/ویرایش پلن‌های Thrill (Lite, Silver, Pro, Max)</p>--}}
{{--                <a href="#" class="btn btn-outline-info btn-sm">ورود به بخش</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4">--}}
{{--            <div class="p-4 rounded" style="background:linear-gradient(135deg,rgba(20,25,50,.92),rgba(40,20,70,.88));border:1px solid rgba(0,255,255,.25);">--}}
{{--                <h5>کاربران</h5>--}}
{{--                <p class="text-muted">جستجو، مشاهده، مسدودسازی/فعال‌سازی</p>--}}
{{--                <a href="#" class="btn btn-outline-info btn-sm">ورود به بخش</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4">--}}
{{--            <div class="p-4 rounded" style="background:linear-gradient(135deg,rgba(20,25,50,.92),rgba(40,20,70,.88));border:1px solid rgba(0,255,255,.25);">--}}
{{--                <h5>سفارش‌ها و اشتراک‌ها</h5>--}}
{{--                <p class="text-muted">پیگیری پرداخت‌ها و وضعیت اشتراک‌ها</p>--}}
{{--                <a href="#" class="btn btn-outline-info btn-sm">ورود به بخش</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}

@extends('admin.layouts.app')
@section('title', 'داشبورد مدیریت')

@section('content')
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card-glass text-center">
                <i class="bi bi-people fs-3 text-info"></i>
                <div class="mt-1 muted">کاربران کل</div>
                <div class="fs-3 fw-bold">۲۴۵</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-glass text-center">
                <i class="bi bi-box fs-3 text-info"></i>
                <div class="mt-1 muted">تعداد پلن‌ها</div>
                <div class="fs-3 fw-bold">۴</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-glass text-center">
                <i class="bi bi-activity fs-3 text-info"></i>
                <div class="mt-1 muted">اشتراک‌های فعال</div>
                <div class="fs-3 fw-bold">۱۶۸</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-glass text-center">
                <i class="bi bi-cash-coin fs-3 text-info"></i>
                <div class="mt-1 muted">درآمد ماه جاری</div>
                <div class="fs-3 fw-bold">۴,۲۵۰,۰۰۰</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-lg-8">
            <div class="card-glass">
                <h5 class="section-title mb-2">نمودار درآمد ماهانه</h5>
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card-glass h-100">
                <h5 class="section-title">آخرین درخواست‌های تعویض</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-transparent text-white d-flex justify-content-between"><span>امیر حسینی – Pro</span><span class="badge bg-warning text-dark">در انتظار</span></li>
                    <li class="list-group-item bg-transparent text-white d-flex justify-content-between"><span>نازنین توکلی – Silver</span><span class="badge bg-success">تایید شد</span></li>
                    <li class="list-group-item bg-transparent text-white d-flex justify-content-between"><span>مهدی کاظمی – Lite</span><span class="badge bg-danger">رد شد</span></li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded',()=>{
            const ctx=document.getElementById('revenueChart');
            new Chart(ctx,{
                type:'line',
                data:{
                    labels:['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'],
                    datasets:[{label:'درآمد (میلیون تومان)',data:[12,19,11,15,22,28,25,30,27,34,31,38],tension:.35,fill:true,borderColor:'#00ffff',backgroundColor:'rgba(0,255,255,0.15)'}]
                },
                options:{plugins:{legend:{display:false}},scales:{y:{ticks:{callback:v=>v.toLocaleString('fa-IR')}}}}
            });
        });
    </script>
@endpush

