<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل فواتير المشتريات</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="max-w-7xl mx-auto p-4 md:p-8 min-h-screen">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">

            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                    سجل فواتير المشتريات
                </h2>

                <p class="text-gray-500 mt-1">
                    عرض وإدارة جميع عمليات الشراء الواردة للمخازن
                </p>
            </div>

            <a href="{{ route('purchases.create') }}"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition duration-200 shadow-lg shadow-blue-200 flex items-center justify-center">

                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4"></path>
                </svg>

                فاتورة جديدة
            </a>

        </div>

        <div class="bg-white shadow-2xl shadow-gray-200/50 rounded-3xl overflow-hidden border border-gray-100">

            <div class="overflow-x-auto">

                <table class="w-full text-right">

                    <thead>
                        <tr class="bg-gray-900 text-white">

                            <th class="p-5">رقم الفاتورة</th>
                            <th class="p-5">المورد</th>
                            <th class="p-5 text-center">المخزن</th>
                            <th class="p-5 text-center">إجمالي المبلغ</th>
                            <th class="p-5 text-center">التاريخ</th>
                            <th class="p-5 text-center">الإجراءات</th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($purchases as $purchase)

                        <tr class="hover:bg-blue-50 transition">

                            <td class="p-5 font-bold text-gray-700">
                                <span class="text-blue-500 text-xs mr-1">#</span>
                                {{ $purchase->id }}
                            </td>

                            <td class="p-5">

                                <div class="flex items-center">

                                    <div class="w-9 h-9 bg-gray-200 rounded-full ml-3 flex items-center justify-center">

                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>

                                        </svg>

                                    </div>

                                    <span class="font-bold text-gray-800">
                                        {{ $purchase->supplier->name ?? '-' }}
                                    </span>

                                </div>

                            </td>

                            <td class="p-5 text-center">

                                <span class="px-4 py-1.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border">

                                    {{ $purchase->warehouse->name ?? '-' }}

                                </span>

                            </td>

                            <td class="p-5 text-center">

                                <span class="text-lg font-black text-emerald-600">

                                    {{ number_format($purchase->total_amount,2) }}

                                    <small class="text-xs text-emerald-500">دج</small>

                                </span>

                            </td>

                            <td class="p-5 text-center text-gray-500">

                                {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}

                            </td>

                            <td class="p-5 text-center">

                                <a href="{{ route('purchases.show',$purchase->id) }}"

                                    class="px-4 py-2 bg-white border-2 border-blue-600 text-blue-600 rounded-xl text-sm font-bold hover:bg-blue-600 hover:text-white transition">

                                    عرض التفاصيل

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="p-20 text-center text-gray-500">

                                لا توجد فواتير مشتريات حتى الآن

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <div class="mt-6 text-center text-gray-400 text-sm">
            جميع الأوقات المعروضة حسب توقيت النظام
        </div>

    </div>

</body>

</html>