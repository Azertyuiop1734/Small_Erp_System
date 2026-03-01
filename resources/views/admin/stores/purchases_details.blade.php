<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الفاتورة #{{ $purchase->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; }
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .shadow-xl { shadow: none; border: 1px solid #eee; }
        }
    </style>
</head>
<body class="bg-gray-100 py-10">

    <div class="max-w-4xl mx-auto p-4">
        
        <div class="mb-6 no-print">
            <a href="{{ route('purchases.index') }}" class="text-gray-500 hover:text-blue-600 flex items-center font-bold transition">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7l-7-7 7-7"></path></svg>
                العودة لقائمة المشتريات
            </a>
        </div>

        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
            <div class="bg-gray-900 p-8 text-white flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black">تفاصيل الفاتورة</h2>
                    <p class="text-gray-400 mt-1 uppercase tracking-widest text-sm">رقم المرجع: #{{ $purchase->id }}</p>
                </div>
                <div class="text-left">
                    <span class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-4 py-2 rounded-xl font-bold text-sm">
                        حالة الفاتورة: مكتملة
                    </span>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <p class="text-gray-400 text-xs mb-1 font-bold uppercase">المورد</p>
                        <p class="text-gray-800 font-extrabold text-lg">{{ $purchase->supplier_name }}</p>
                    </div>
                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <p class="text-gray-400 text-xs mb-1 font-bold uppercase">المخزن المستلم</p>
                        <p class="text-gray-800 font-extrabold text-lg">{{ $purchase->warehouse_name }}</p>
                    </div>
                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <p class="text-gray-400 text-xs mb-1 font-bold uppercase">تاريخ الشراء</p>
                        <p class="text-gray-800 font-extrabold text-lg">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y/m/d') }}</p>
                    </div>
                </div>

                <div class="mb-10">
                    <h3 class="text-xl font-black text-gray-800 mb-4 border-r-4 border-blue-600 pr-3">الأصناف المشتراة</h3>
                    <div class="overflow-hidden rounded-2xl border border-gray-100">
                        <table class="w-full text-right">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="p-4 font-bold text-gray-600">المنتج</th>
                                    <th class="p-4 font-bold text-gray-600 text-center">الباركود</th>
                                    <th class="p-4 font-bold text-gray-600 text-center">الكمية</th>
                                    <th class="p-4 font-bold text-gray-600 text-center">السعر</th>
                                    <th class="p-4 font-bold text-gray-600 text-left">الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($items as $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 font-bold text-gray-800">{{ $item->product_name }}</td>
                                    <td class="p-4 text-center font-mono text-sm text-gray-500">{{ $item->barcode }}</td>
                                    <td class="p-4 text-center font-bold">{{ $item->quantity }}</td>
                                    <td class="p-4 text-center text-gray-600">{{ number_format($item->price, 2) }}</td>
                                    <td class="p-4 text-left font-black text-blue-600">{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-blue-50/50">
                                    <td colspan="4" class="p-5 text-left font-bold text-gray-700 text-lg">المجموع الكلي للفاتورة:</td>
                                    <td class="p-5 text-left font-black text-2xl text-blue-700">
                                        {{ number_format($purchase->total_amount, 2) }} <small class="text-xs">د.ج</small>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="flex gap-4 no-print">
                    <button onclick="window.print()" class="flex-1 bg-gray-800 hover:bg-black text-white py-4 rounded-2xl font-black transition duration-200 flex items-center justify-center shadow-lg shadow-gray-200">
                        <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        طباعة الفاتورة
                    </button>
                    <button class="px-8 bg-blue-50 text-blue-600 font-bold rounded-2xl hover:bg-blue-100 transition">تحميل PDF</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>