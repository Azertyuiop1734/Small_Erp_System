<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الفاتورة #{{ $sale->invoice_number }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        cairo: ['Cairo', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Cairo', sans-serif; }
        .glass-panel { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        
        /* تحسينات للوضع المظلم */
        .dark body { background-color: #0f172a; }

        @media print {
            body { background: white !important; padding: 0 !important; margin: 0 !important; color: black !important; }
            .no-print { display: none !important; }
            .glass-panel { border: 1px solid #eee !important; box-shadow: none !important; background: white !important; backdrop-filter: none !important; }
            .absolute { display: none !important; }
            table { width: 100% !important; border: 1px solid #eee !important; }
            th { background: #f9fafb !important; color: black !important; }
            .text-transparent { color: black !important; background: none !important; -webkit-background-clip: initial !important; }
        }

        /* أنيميشن الدخول */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-slate-950 transition-colors duration-300">

    <div class="max-w-5xl mx-auto space-y-8 px-4 py-8 no-print animate-fade-in">
        
        <div class="relative overflow-hidden glass-panel p-8 rounded-[2.5rem] shadow-2xl border border-white/20 dark:border-white/5 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl">
            <div class="absolute -top-12 -left-12 w-48 h-48 bg-cyan-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-5">
                    <div class="relative">
                        <div class="absolute inset-0 bg-cyan-600 blur-lg opacity-30 animate-pulse"></div>
                        <div class="relative p-4 bg-gradient-to-br from-cyan-600 to-blue-600 rounded-2xl shadow-xl">
                            <i class="fas fa-file-invoice text-white text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight">تفاصيل الفاتورة</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 font-medium">رقم المرجع: <span class="text-cyan-600 font-bold">#{{ $sale->invoice_number }}</span></p>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button onclick="window.print()" class="group px-8 py-3 bg-gray-800 dark:bg-slate-700 text-white rounded-xl font-bold text-sm shadow-lg hover:bg-gray-900 transition-all flex items-center gap-3">
                        <i class="fas fa-print group-hover:scale-110 transition-transform"></i> طباعة الفاتورة
                    </button>
                    <button onclick="window.history.back()" class="px-8 py-3 bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 rounded-xl font-bold text-sm shadow-sm hover:bg-gray-50 transition-all">
                        العودة
                    </button>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-[2.5rem] shadow-2xl border border-white/20 dark:border-white/5 bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl overflow-hidden">
            <div class="p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12">
                    <div class="space-y-6">
                        <h3 class="text-xs font-black uppercase tracking-widest text-cyan-600 mb-4 px-2 border-r-4 border-cyan-600">معلومات العميل</h3>
                        <div class="flex items-center gap-4 p-5 rounded-3xl bg-gray-50/50 dark:bg-white/5 border border-gray-100 dark:border-white/5 transition-all hover:shadow-md">
                            <div class="w-14 h-14 rounded-2xl bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-600">
                                <i class="fas fa-user-tie text-xl"></i>
                            </div>
                            <div>
                                <p class="text-lg font-bold text-gray-800 dark:text-white">{{ $sale->customer->name }}</p>
                                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{ $sale->customer->phone }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <h3 class="text-xs font-black uppercase tracking-widest text-indigo-600 mb-4 px-2 border-r-4 border-indigo-600">بيانات العملية</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-3xl bg-gray-50/50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                                <span class="block text-[10px] text-gray-400 font-black mb-1 uppercase">تاريخ الإصدار</span>
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-200">{{ $sale->created_at->format('Y-m-d') }}</span>
                            </div>
                            <div class="p-4 rounded-3xl bg-gray-50/50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                                <span class="block text-[10px] text-gray-400 font-black mb-1 uppercase">حالة الدفع</span>
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-emerald-500 bg-emerald-500/10 px-3 py-1 rounded-full uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> مدفوع
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden shadow-inner bg-gray-50/30 dark:bg-black/10">
                    <table class="w-full text-right">
                        <thead>
                            <tr class="bg-gray-100/50 dark:bg-white/5 text-gray-400">
                                <th class="p-6 text-[11px] font-black uppercase tracking-wider">المنتج والوصف</th>
                                <th class="p-6 text-[11px] font-black uppercase tracking-wider text-center">الكمية</th>
                                <th class="p-6 text-[11px] font-black uppercase tracking-wider">سعر الوحدة</th>
                                <th class="p-6 text-[11px] font-black uppercase tracking-wider">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                            @foreach($sale->items as $item)
                            <tr class="hover:bg-white/50 dark:hover:bg-white/5 transition-all">
                                <td class="p-6">
                                    <div class="font-bold text-gray-800 dark:text-white">{{ $item->product->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-medium">كود الصنف: #PRD-{{ $item->product_id }}</div>
                                </td>
                                <td class="p-6 text-center">
                                    <span class="px-4 py-1.5 bg-gray-200/50 dark:bg-slate-800 rounded-xl font-black text-gray-700 dark:text-gray-300 text-xs">
                                        {{ $item->quantity }}
                                    </span>
                                </td>
                                <td class="p-6 font-bold text-gray-600 dark:text-gray-400 text-sm">{{ number_format($item->price, 2) }} DA</td>
                                <td class="p-6 font-black text-gray-800 dark:text-white text-sm">{{ number_format($item->quantity * $item->price, 2) }} DA</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-10 flex justify-end">
                    <div class="w-full md:w-80 space-y-4 p-8 rounded-[2.5rem] bg-gray-100/50 dark:bg-white/5 border border-gray-200 dark:border-white/5 shadow-xl">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-bold">المجموع الفرعي:</span>
                            <span class="text-gray-800 dark:text-gray-200 font-black">{{ number_format($sale->total_amount, 2) }} DA</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-bold">الضريبة (0%):</span>
                            <span class="text-gray-800 dark:text-gray-200 font-black">0.00 DA</span>
                        </div>
                        <div class="pt-5 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <span class="text-gray-800 dark:text-white font-black text-lg">الإجمالي الكلي:</span>
                            <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 to-blue-600">
                                {{ number_format($sale->total_amount, 2) }} DA
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-gray-100/50 dark:bg-slate-800/50 border-t border-gray-200 dark:border-gray-800 text-center">
                <span class="text-[10px] text-gray-400 font-black tracking-[0.2em] uppercase">
                    تم إنشاء هذه الفاتورة بواسطة نظام الـ ERP المتكامل
                </span>
            </div>
        </div>
    </div>

</body>
</html>