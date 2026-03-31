@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 text-right" dir="rtl">
    <div class="max-w-7xl mx-auto">
        
        <div class="mb-8 flex justify-between items-center">
            <h2 class="text-3xl font-extrabold text-gray-900 flex items-center gap-2">
                <span class="text-blue-600">🛒</span> تحليل أداء المنتجات
            </h2>
            <span class="bg-white px-4 py-2 rounded-lg shadow-sm text-sm text-gray-500 border border-gray-100">
                {{ now()->format('Y-m-d') }}
            </span>
        </div>

        @if($lowStockProducts->count() > 0)
        <div class="mb-8 bg-red-50 border-r-4 border-red-500 p-4 rounded-l-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="mr-3">
                    <h3 class="text-sm font-bold text-red-800">تنبيه: منتجات شارفت على النفاد!</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($lowStockProducts->take(3) as $product)
                                <li>
                                    المنتج: <span class="font-bold">{{ $product->name }}</span> - 
                                    المخزون الحالي: <span class="underline font-black">{{ $product->current_stock ?? 0 }}</span> 
                                    (الحد الأدنى: {{ $product->minimum_stock }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">مقارنة حركة المنتجات (كمية)</h3>
                <div class="relative h-[300px]">
                    <canvas id="topSellingChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">تحليل العوائد المالية ($)</h3>
                <div class="relative h-[300px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-red-600">⚠️ المنتجات الراكدة (ضعيفة الحركة)</h3>
                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">تحتاج إجراء تسويقي</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead class="bg-gray-50 text-gray-600 text-sm uppercase">
                        <tr>
                            <th class="px-6 py-4 font-bold border-b">المنتج</th>
                            <th class="px-6 py-4 font-bold border-b text-center">سعر البيع</th>
                            <th class="px-6 py-4 font-bold border-b text-center">إجمالي المباع</th>
                            <th class="px-6 py-4 font-bold border-b text-center">المخزون الكلي</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($stagnantProducts as $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-900 font-medium">{{ $p->name }}</td>
                            <td class="px-6 py-4 text-center text-blue-600 font-semibold font-mono">
                                ${{ number_format($p->selling_price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $p->total_qty ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $p->warehouses->sum('pivot.quantity') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // تهيئة عامة لـ Chart.js ليدعم الخطوط العربية
    Chart.defaults.font.family = 'system-ui, -apple-system, sans-serif';

    // 1. رسم بياني للمنتجات الأكثر مبيعاً (الأفقي)
    const ctxTop = document.getElementById('topSellingChart').getContext('2d');
    new Chart(ctxTop, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topSellingProducts->pluck('name')) !!},
            datasets: [{
                label: 'الكمية المباعة',
                data: {!! json_encode($topSellingProducts->pluck('total_qty')) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1,
                borderRadius: 8,
                barThickness: 25
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { display: false } }
            }
        }
    });

    // 2. رسم بياني للعوائد المالية (Revenue)
    const ctxRev = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRev, {
        type: 'bar',
        data: {
            labels: {!! json_encode($productSalesData->pluck('name')) !!},
            datasets: [{
                label: 'إجمالي العوائد ($)',
                data: {!! json_encode($productSalesData->pluck('total_revenue')) !!},
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                borderColor: 'rgb(16, 185, 129)',
                borderWidth: 1,
                borderRadius: 8,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection