@extends('layouts.app') {{-- افترضنا أنك تملك ملف Layout أساسي --}}

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 font-weight-bold text-dark">لوحة أداء المبيعات العام</h2>
        <span class="badge bg-white text-dark shadow-sm p-2">{{ now()->format('Y-m-d') }}</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-bold">إجمالي المبيعات</p>
                            <h3 class="mb-0">${{ number_format($totalSales, 2) }}</h3>
                        </div>
                        <div class="icon-shape bg-soft-success text-success p-3 rounded">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-bold">عدد الطلبات</p>
                            <h3 class="mb-0">{{ number_format($totalOrders) }}</h3>
                        </div>
                        <div class="icon-shape bg-soft-primary text-primary p-3 rounded">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-bold">نمو المبيعات</p>
                            <h3 class="mb-0 {{ $growthRate >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $growthRate >= 0 ? '+' : '' }}{{ number_format($growthRate, 1) }}%
                            </h3>
                        </div>
                        <div class="icon-shape p-3 rounded">
                            <i class="fas {{ $growthRate >= 0 ? 'fa-arrow-up text-success' : 'fa-arrow-down text-danger' }}"></i>
                        </div>
                    </div>
                    <small class="text-muted small">مقارنة بالشهر الماضي</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-bold">مبالغ تحت التحصيل</p>
                            <h3 class="mb-0 text-warning">${{ number_format($remainingTotal, 2) }}</h3>
                        </div>
                        <div class="icon-shape bg-soft-warning text-warning p-3 rounded">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">تحليل المبيعات اليومي (آخر 7 أيام)</h6>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">توزيع طرق الدفع</h6>
                </div>
                <div class="card-body d-flex align-items-center">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">آخر عمليات البيع</h6>
                    <a href="#" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>العميل</th>
                                <th>المخزن</th>
                                <th>الإجمالي</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSales as $sale)
                            <tr>
                                <td class="fw-bold">#{{ $sale->invoice_number }}</td>
                                <td>{{ $sale->customer->name ?? 'عميل نقدي' }}</td>
                                <td>{{ $sale->warehouse->name ?? 'المخزن الرئيسي' }}</td>
                                <td>${{ number_format($sale->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $sale->status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                        {{ $sale->status }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $sale->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Line Chart: Sales Trends
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesData->pluck('date')) !!},
            datasets: [{
                label: 'المبيعات',
                data: {!! json_encode($salesData->pluck('total')) !!},
                fill: true,
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderColor: '#0d6efd',
                tension: 0.4,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Doughnut Chart: Payment Methods
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Cash', 'Card', 'Bank Transfer'],
            datasets: [{
                data: [55, 30, 15], // استبدل هذه القيم ببيانات حقيقية من الـ Controller
                backgroundColor: ['#0d6efd', '#20c997', '#ffc107'],
                hoverOffset: 4
            }]
        },
        options: {
            cutout: '70%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>

<style>
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.15); }
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.15); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.15); }
    .icon-shape { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .card { border-radius: 12px; }
</style>
@endsection