@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="fas fa-file-invoice text-primary me-2"></i> Invoices Analytics ({{ Carbon\Carbon::now()->year }})</h3>
        <span class="text-muted">Data based on the current year</span>
    </div>
    
    {{-- 1. بطاقات المؤشرات الرئيسية (KPI Cards) --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-primary bg-opacity-10 rounded-circle me-3">
                        <i class="fas fa-boxes text-primary fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small">Total Invoices</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalInvoicesCount) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-info bg-opacity-10 rounded-circle me-3">
                        <i class="fas fa-calculator text-info fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small">Avg. Invoice Value</h6>
                        <h4 class="mb-0 fw-bold text-info">{{ number_format($averageInvoiceValue, 2) }} DA</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-dark bg-opacity-10 rounded-circle me-3">
                        <i class="fas fa-crown text-dark fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small">Highest Invoice</h6>
                        <h4 class="mb-0 fw-bold text-dark">{{ number_format($highestInvoiceValue, 2) }} DA</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 p-2">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-success bg-opacity-10 rounded-circle me-3">
                        <i class="fas fa-percent text-success fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small">Collection Rate</h6>
                        <h3 class="mb-0 fw-bold text-success">{{ number_format($collectionRate, 1) }}%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- 2. قسم الرسم البياني المجوف والملخص المالي --}}
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-chart-pie text-primary me-2"></i> Invoice Payment Status</h5>
                    <span class="badge bg-light text-muted rounded-pill fw-normal">By Count</span>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    {{-- عنصر الرسم البياني --}}
                    <div style="height: 300px; width: 300px;">
                        <canvas id="invoiceDoughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-money-bill-wave text-primary me-2"></i> Collection Summary</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="p-3">Type</th>
                                <th class="p-3 text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-3 fw-bold text-success"><i class="fas fa-check-circle me-2"></i> Total Collected</td>
                                <td class="p-3 text-end text-success fw-bold">{{ number_format($totalCollected, 2) }} DA</td>
                            </tr>
                            <tr>
                                <td class="p-3 fw-bold text-danger"><i class="fas fa-exclamation-circle me-2"></i> Total Remaining</td>
                                <td class="p-3 text-end text-danger fw-bold">{{ number_format($totalRemaining, 2) }} DA</td>
                            </tr>
                            <tr class="table-light text-uppercase fw-bold">
                                <td class="p-3">Total Invoice Value</td>
                                <td class="p-3 text-end text-dark">
                                    {{ number_format($totalCollected + $totalRemaining, 2) }} DA
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="p-3 text-center">
                        <p class="text-muted small mb-0">The 'Total Remaining' includes partially paid and unpaid invoices.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- 3. كود الـ JavaScript ومكتبة Chart.js --}}

{{-- استدعاء مكتبة Chart.js عبر CDN (إذا لم تكن قد استدعيتها في الـ Layout) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // الحصول على سياق العنصر canvas
    const doughnutCtx = document.getElementById('invoiceDoughnutChart').getContext('2d');

    // قراءة البيانات المرسلة من الـ Controller
    const chartData = {!! $doughnutChartData !!};

    // رسم المنحنى البياني المجوف (Doughnut)
    const invoiceDoughnutChart = new Chart(doughnutCtx, {
        type: 'doughnut', // نوع الرسم: مجوف دائري
        data: {
            labels: ['Fully Paid', 'Unpaid / Partial'], // التسميات
            datasets: [{
                // البيانات الحقيقية (الأعداد)
                data: [chartData.paid, chartData.unpaid], 
                // الألوان
                backgroundColor: [
                    '#198754', // الأخضر (نجاح - success)
                    '#dc3545', // الأحمر (خطر - danger)
                ],
                // ألوان الحدود (اختياري)
                borderColor: [
                    '#ffffff', // أبيض
                    '#ffffff',
                ],
                borderWidth: 2, // سُمك الحدود
                hoverOffset: 10 // تأثير التكبير عند تمرير الماوس
            }]
        },
        options: {
            responsive: true, // متجاوب
            maintainAspectRatio: false, // يحترم الارتفاع المحدد في الـ div
            cutout: '70%', // حجم الفجوة في المنتصف (كلما زاد الرقم، زاد التجويف)
            plugins: {
                legend: {
                    position: 'bottom', // مكان مفتاح الرسم (أسفل)
                    labels: {
                        usePointStyle: true, // استخدام أشكال النقاط
                        padding: 20,
                        font: { size: 13 }
                    }
                },
                tooltip: {
                    // تخصيص التلميحات
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                // عرض العدد ونسبة مئوية بسيطة
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                label += context.parsed.toLocaleString() + ' invoices (' + percentage + '%)';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection