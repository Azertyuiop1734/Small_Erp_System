@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="fas fa-chart-line text-primary me-2"></i> Financial Overview ({{ Carbon\Carbon::now()->year }})</h3>
        {{-- يمكنك إضافة زر لطباعة التقرير هنا مستقبلاً --}}
    </div>
    
    {{-- 1. بطاقات الأرقام (Cards) - نفس الكود السابق مع تعديل بسيط في التنسيق --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 small opacity-75">Today's Sales</h6>
                            <h2 class="mb-0 fw-bold">{{ number_format($salesToday, 2) }} DA</h2>
                        </div>
                        <i class="fas fa-calendar-day fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 small opacity-75">This Month's Sales</h6>
                            <h2 class="mb-0 fw-bold">{{ number_format($salesMonth, 2) }} DA</h2>
                        </div>
                        <i class="fas fa-calendar-alt fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 small opacity-75">Annual Expenses</h6>
                            <h2 class="mb-0 fw-bold">{{ number_format($totalExpenses, 2) }} DA</h2>
                        </div>
                        <i class="fas fa-file-invoice-dollar fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 small opacity-75">Annual Net Profit</h6>
                            <h1 class="mb-0 fw-bold">{{ number_format($netProfit, 2) }} DA</h1>
                            <p class="mb-0 small opacity-75 mt-1">Formula: Total Annual Sales - Total Annual Expenses</p>
                        </div>
                        <i class="fas fa-hand-holding-usd fa-4x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- 2. قسم المنحنى البياني (Chart Section) - الإضافة الجديدة هنا --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-chart-area text-primary me-2"></i> Financial Performance Trend</h5>
                    <span class="badge bg-light text-muted rounded-pill fw-normal">Monthly Data</span>
                </div>
                <div class="card-body">
                    {{-- هذا هو العنصر الذي سيرسم فيه المنحنى --}}
                    <div style="height: 400px;">
                        <canvas id="financialChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. جدول التفاصيل (اختياري، يمكنك إبقاؤه أو حذفه) --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list text-primary me-2"></i> Summary Table</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="p-3">Category</th>
                        <th class="p-3">Description</th>
                        <th class="p-3 text-end">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-3 fw-bold text-primary"><i class="fas fa-arrow-up me-2"></i> Revenue (Annual)</td>
                        <td class="p-3 text-muted">Total sum of all sales in {{ Carbon\Carbon::now()->year }}</td>
                        <td class="p-3 text-end text-primary fw-bold">+ {{ number_format($salesYear, 2) }} DA</td>
                    </tr>
                    <tr>
                        <td class="p-3 fw-bold text-danger"><i class="fas fa-arrow-down me-2"></i> Expenses (Annual)</td>
                        <td class="p-3 text-muted">Total sum of all expenses in {{ Carbon\Carbon::now()->year }}</td>
                        <td class="p-3 text-end text-danger fw-bold">- {{ number_format($totalExpenses, 2) }} DA</td>
                    </tr>
                    <tr class="table-light text-uppercase fw-bold">
                        <td class="p-3" colspan="2">Net Annual Balance</td>
                        <td class="p-3 text-end {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($netProfit, 2) }} DA
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- 4. كود الـ JavaScript ومكتبة Chart.js --}}

{{-- استدعاء مكتبة Chart.js عبر CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // الحصول على سياق العنصر canvas
    const ctx = document.getElementById('financialChart').getContext('2d');

    // رسم المنحنى البياني
    const financialChart = new Chart(ctx, {
        type: 'line', // نوع الرسم: منحنى خطي
        data: {
            // التسميات (أسماء الشهور) التي أرسلناها من الـ Controller
            labels: {!! $chartLabels !!}, 
            datasets: [
                {
                    label: 'Total Sales',
                    // بيانات المبيعات
                    data: {!! $chartSales !!},
                    borderColor: '#0d6efd', // لون الخط (الأزرق - primary)
                    backgroundColor: 'rgba(13, 110, 253, 0.1)', // لون التعبئة تحت الخط
                    fill: true, // تفعيل التعبئة
                    tension: 0.3, // درجة انحناء الخط (لجعله ناعماً)
                    borderWidth: 3,
                    pointBackgroundColor: '#0d6efd',
                    pointRadius: 4
                },
                {
                    label: 'Total Expenses',
                    // بيانات المصاريف
                    data: {!! $chartExpenses !!},
                    borderColor: '#dc3545', // لون الخط (الأحمر - danger)
                    backgroundColor: 'rgba(220, 53, 69, 0.05)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2,
                    pointBackgroundColor: '#dc3545',
                    pointRadius: 3,
                    borderDash: [5, 5] // جعل الخط متقطعاً للتميز
                },
                {
                    label: 'Net Profit',
                    // بيانات صافي الربح
                    data: {!! $chartProfit !!},
                    borderColor: '#198754', // لون الخط (الأخضر - success)
                    backgroundColor: 'transparent', // لا نريد تعبئة للربح لكي لا يغطي البقية
                    fill: false,
                    tension: 0.1, // خط مستقيم تقريباً للتميز
                    borderWidth: 4,
                    pointBackgroundColor: '#198754',
                    pointRadius: 5,
                    pointStyle: 'rectRounded' // شكل النقاط مربع مقعر للتميز
                }
            ]
        },
        options: {
            responsive: true, // جعل الرسم متجاوباً مع حجم الشاشة
            maintainAspectRatio: false, // لكي يحترم الارتفاع الذي حددناه في الـ div (400px)
            plugins: {
                legend: {
                    position: 'top', // مكان مفتاح الرسم (أعلى)
                    labels: {
                        usePointStyle: true, // استخدام أشكال النقاط في المفتاح
                        padding: 20,
                        font: {
                            size: 13
                        }
                    }
                },
                tooltip: {
                    // تخصيص التلميحات التي تظهر عند تمرير الماوس
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14 },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                // تنسيق الرقم ليظهر كعملة (DA)
                                label += new Intl.NumberFormat('en-US', { minimumFractionDigits: 2 }).format(context.parsed.y) + ' DA';
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true, // بدأ المحور الصادي من الصفر
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)' // لون خطوط الشبكة
                    },
                    ticks: {
                        font: { size: 11 },
                        callback: function(value, index, values) {
                            // إضافة "DA" على المحور الصادي
                            return value.toLocaleString() + ' DA';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false // إخفاء خطوط الشبكة العمودية
                    },
                    ticks: {
                        font: { size: 11 }
                    }
                }
            },
            interaction: {
                intersect: false, // إظهار التلميح لأقرب نقطة حتى لو لم نكن فوقها تماماً
                mode: 'index',
            }
        }
    });
</script>
@endsection