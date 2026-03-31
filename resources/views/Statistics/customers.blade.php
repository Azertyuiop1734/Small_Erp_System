@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 text-right" dir="rtl">
    <div class="max-w-7xl mx-auto">
        
        <div class="mb-8 border-b pb-4">
            <h2 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
                <span class="p-2 bg-blue-100 rounded-lg text-blue-600">👥</span>
                تحليل سلوك ونشاط العملاء
            </h2>
            <p class="text-gray-500 mt-2 text-sm">متابعة تفاعل العملاء وتوزيعهم الجغرافي بعيداً عن البيانات المالية.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-400 font-bold mb-1">العملاء الجدد</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black text-blue-600">{{ $newCustomersCount }}</span>
                    <span class="text-xs text-gray-500 italic">خلال آخر 30 يوم</span>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-400 font-bold mb-1">أكثر منطقة نشاطاً</p>
                <span class="text-xl font-bold text-gray-800">{{ $customerLocations->first()->address ?? 'غير محدد' }}</span>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-400 font-bold mb-1">عملاء لم يزورونا مؤخراً</p>
                <span class="text-3xl font-black text-orange-500">{{ $idleCustomers->count() }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    📍 التوزيع الجغرافي للعملاء
                </h3>
                <div class="h-[300px]">
                    <canvas id="locationChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">🏆 العملاء الأكثر وفاءً (عدد الطلبات)</h3>
                <div class="space-y-4">
                    @foreach($topActiveCustomers as $c)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold">
                                {{ mb_substr($c->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $c->name }}</p>
                                <p class="text-xs text-gray-500">{{ $c->phone }}</p>
                            </div>
                        </div>
                        <div class="text-left">
                            <span class="text-blue-600 font-black">{{ $c->sales_count }}</span>
                            <span class="text-xs text-gray-400">طلب</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
                <h3 class="text-lg font-bold text-orange-600 mb-4 flex items-center gap-2">
                    😴 عملاء خاملون (لم يجروا عمليات منذ 3 أشهر)
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-right">
                        <thead>
                            <tr class="text-gray-400 text-sm border-b">
                                <th class="py-3 pr-4">اسم العميل</th>
                                <th class="py-3">العنوان</th>
                                <th class="py-3">رقم الهاتف</th>
                                <th class="py-3 text-center">الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($idleCustomers as $c)
                            <tr class="border-b last:border-0 hover:bg-gray-50 transition-colors">
                                <td class="py-4 pr-4 font-bold text-gray-700">{{ $c->name }}</td>
                                <td class="py-4 text-gray-500 text-sm">{{ $c->address }}</td>
                                <td class="py-4 text-gray-500 font-mono">{{ $c->phone }}</td>
                                <td class="py-4 text-center">
                                    <button class="text-blue-500 hover:underline text-sm font-bold">إرسال عرض ترويجي</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-gray-400">لا يوجد عملاء خاملون حالياً.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // رسم بياني للمناطق (Polar Area Chart)
    const ctx = document.getElementById('locationChart').getContext('2d');
    new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: {!! json_encode($customerLocations->pluck('address')) !!},
            datasets: [{
                data: {!! json_encode($customerLocations->pluck('total')) !!},
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(245, 158, 11, 0.7)',
                    'rgba(239, 68, 68, 0.7)',
                    'rgba(139, 92, 246, 0.7)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection