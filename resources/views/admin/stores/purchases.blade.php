<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل فواتير المشتريات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="max-w-7xl mx-auto p-4 md:p-8 min-h-screen">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">سجل فواتير المشتريات</h2>
                <p class="text-gray-500 mt-1">عرض وإدارة جميع عمليات الشراء الواردة للمخازن</p>
            </div>
            <a href="{{ route('purchases.create') }}" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition duration-200 shadow-lg shadow-blue-200 flex items-center justify-center">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                فاتورة جديدة
            </a>
        </div>

        <div class="bg-white shadow-2xl shadow-gray-200/50 rounded-3xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-gray-900 text-white">
                            <th class="p-5 font-bold text-sm uppercase tracking-wider">رقم الفاتورة</th>
                            <th class="p-5 font-bold text-sm uppercase tracking-wider">المورد</th>
                            <th class="p-5 font-bold text-sm uppercase tracking-wider text-center">المخزن</th>
                            <th class="p-5 font-bold text-sm uppercase tracking-wider text-center">إجمالي المبلغ</th>
                            <th class="p-5 font-bold text-sm uppercase tracking-wider text-center">التاريخ</th>
                            <th class="p-5 font-bold text-sm uppercase tracking-wider text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($purchases as $purchase)
                        <tr class="hover:bg-blue-50/50 transition duration-150 group">
                            <td class="p-5 text-gray-700 font-bold">
                                <span class="text-blue-500 text-xs mr-1">#</span>{{ $purchase->id }}
                            </td>
                            <td class="p-5">
                                <div class="flex items-center">
                                    <div class="w-9 h-9 bg-gradient-to-tr from-gray-100 to-gray-200 rounded-full ml-3 flex items-center justify-center text-gray-600 border border-gray-300 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $purchase->supplier_name }}</span>
                                </div>
                            </td>
                            <td class="p-5 text-center">
                                <span class="inline-flex items-center px-4 py-1.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    {{ $purchase->warehouse_name }}
                                </span>
                            </td>
                            <td class="p-5 text-center text-nowrap">
                                <span class="text-lg font-black text-emerald-600">
                                    {{ number_format($purchase->total_amount, 2) }} 
                                    <small class="text-[10px] font-bold text-emerald-500 uppercase">د.ج</small>
                                </span>
                            </td>
                            <td class="p-5 text-center text-gray-500 font-medium">
                                {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}
                            </td>
                            <td class="p-5 text-center">
                                <a href="{{ route('purchases.show', $purchase->id) }}" 
                                   class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-blue-600 text-blue-600 rounded-xl text-sm font-black hover:bg-blue-600 hover:text-white transition-all duration-300 group-hover:shadow-md active:scale-95">
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    عرض التفاصيل
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-100 p-6 rounded-full mb-4">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800">لا توجد سجلات</h3>
                                    <p class="text-gray-500">لم يتم إضافة أي فواتير مشتريات حتى الآن.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 text-center text-gray-400 text-sm italic">
            جميع الأوقات المعروضة بناءً على توقيت النظام المحلي.
        </div>
    </div>

</body>
</html>