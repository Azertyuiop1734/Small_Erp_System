<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير مبيعات الموظف | {{ $worker->name }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
        }
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        body { font-family: 'Cairo', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
        .dark .glass-card {
            background: rgba(15, 23, 42, 0.8);
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-[#020617] min-h-screen transition-colors duration-300 p-4 md:p-8">

<div class="max-w-7xl mx-auto space-y-8">
    
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 bg-white dark:bg-[#0f172a] p-8 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-5 text-right">
            <div class="w-20 h-20 rounded-3xl overflow-hidden border-4 border-blue-100 dark:border-blue-900 shadow-lg">
                <img src="{{ $worker->image ? asset('storage/' . $worker->image) : 'https://ui-avatars.com/api/?name='.urlencode($worker->name).'&background=2563eb&color=fff' }}" class="w-full h-full object-cover">
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-gray-800 dark:text-white tracking-tight">تقرير أداء المبيعات</h2>
                <p class="text-blue-600 dark:text-blue-400 font-bold flex items-center gap-2 mt-1">
                    <i class="fas fa-user-tie"></i> الموظف: {{ $worker->name }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
                      <div class="flex items-center justify-center p-2">
    <button id="theme-toggle" type="button" 
        class="group relative inline-flex items-center justify-center p-3 overflow-hidden font-medium transition-all duration-500 rounded-2xl bg-white/10 dark:bg-slate-800/50 backdrop-blur-lg border border-gray-200 dark:border-slate-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(59,130,246,0.1)] active:scale-95 group">
        
        <div class="absolute inset-0 w-0 bg-gradient-to-r from-blue-600/10 to-indigo-600/10 transition-all duration-500 ease-out group-hover:w-full"></div>

        <div class="relative flex items-center justify-center w-6 h-6">
            <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6 text-slate-700 transition-all duration-500 transform group-hover:rotate-12 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            
            <svg id="theme-toggle-light-icon" class="hidden w-6 h-6 text-amber-400 transition-all duration-500 transform group-hover:rotate-90 group-hover:scale-110 drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
            </svg>
        </div>
    </button>
</div>
            <a href="{{ route('users.index') }}" class="px-6 py-4 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-2xl font-bold flex items-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                <i class="fas fa-arrow-right"></i> عودة للقائمة
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
        $stats = [
            ['title' => 'إجمالي الفواتير', 'value' => $totalSalesCount, 'icon' => 'fa-file-invoice-dollar', 'color' => 'from-blue-500 to-blue-700', 'shadow' => 'shadow-blue-500/20'],
            ['title' => 'إجمالي الإيرادات', 'value' => number_format($totalRevenue, 2) . ' $', 'icon' => 'fa-hand-holding-dollar', 'color' => 'from-emerald-500 to-teal-700', 'shadow' => 'shadow-emerald-500/20'],
            ['title' => 'صافي الربح', 'value' => number_format($totalProfit, 2) . ' $', 'icon' => 'fa-chart-line', 'color' => 'from-amber-500 to-orange-700', 'shadow' => 'shadow-amber-500/20'],
        ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white dark:bg-[#0f172a] p-8 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-gray-800 group hover:-translate-y-2 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-gray-500 dark:text-gray-400 font-bold text-sm mb-2 uppercase tracking-widest">{{ $s['title'] }}</h4>
                    <p class="text-3xl font-black text-gray-800 dark:text-white tracking-tight">{{ $s['value'] }}</p>
                </div>
                <div class="p-4 bg-gradient-to-br {{ $s['color'] }} rounded-2xl text-white shadow-lg {{ $s['shadow'] }}">
                    <i class="fas {{ $s['icon'] }} text-xl"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white dark:bg-[#0f172a] rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden">
        <div class="p-8 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/20">
            <h3 class="text-xl font-black text-gray-800 dark:text-white flex items-center gap-3">
                <i class="fas fa-list-ul text-blue-600"></i> سجل العمليات الأخيرة
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50 text-gray-400 text-right uppercase text-xs font-black tracking-widest">
                        <th class="px-8 py-5">رقم العملية</th>
                        <th class="px-8 py-5 text-center">التاريخ</th>
                        <th class="px-8 py-5 text-center">العميل</th>
                        <th class="px-8 py-5 text-center">الإجمالي</th>
                        <th class="px-8 py-5 text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($sales as $sale)
                    <tr class="hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 px-4 py-2 rounded-xl font-black text-sm">
                                #{{ $sale->id }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center text-gray-600 dark:text-gray-300 font-bold">
                            {{ $sale->created_at->format('Y/m/d H:i') }}
                        </td>
                        <td class="px-8 py-6 text-center text-gray-700 dark:text-white font-black">
                            {{ $sale->customer_name ?? 'عميل نقدي' }}
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-emerald-600 dark:text-emerald-400 font-black text-lg">
                                {{ number_format($sale->total_amount, 2) }} $
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <button onclick='openModal(@json($sale->items), "{{ $sale->id }}")' 
                                    class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-xl font-bold hover:bg-blue-600 hover:text-white transition-all transform active:scale-95 flex items-center gap-2 mx-auto">
                                <i class="fas fa-eye text-xs"></i> تفاصيل
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="saleModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate__animated animate__fadeIn">
    <div class="bg-white dark:bg-[#0f172a] w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden border border-white/20 transform animate__animated animate__zoomIn">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-white flex justify-between items-center">
            <h3 class="text-2xl font-black flex items-center gap-3">
                <i class="fas fa-shopping-basket"></i> تفاصيل الفاتورة <span id="modalTitleId"></span>
            </h3>
            <button onclick="closeModal()" class="text-white/80 hover:text-white hover:rotate-90 transition-all">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <div class="p-8 max-h-[60vh] overflow-y-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="text-gray-400 text-xs font-black border-b border-gray-100 dark:border-gray-800">
                        <th class="pb-4">المنتج</th>
                        <th class="pb-4 text-center">الكمية</th>
                        <th class="pb-4 text-center">السعر</th>
                        <th class="pb-4 text-center">الإجمالي</th>
                    </tr>
                </thead>
                <tbody id="modalBody" class="divide-y divide-gray-50 dark:divide-gray-800/50">
                    </tbody>
            </table>
        </div>

        <div class="p-8 bg-gray-50 dark:bg-gray-900/40 flex justify-end">
            <button onclick="closeModal()" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-600/20 transition-all">
                إغلاق النافذة
            </button>
        </div>
    </div>
</div>

<script>
    // 1. منطق المودال (Modal Logic)
    const modal = document.getElementById("saleModal");
    const modalBody = document.getElementById("modalBody");
    const modalTitleId = document.getElementById("modalTitleId");

    function openModal(items, id) {
        modalTitleId.innerText = `#${id}`;
        modalBody.innerHTML = "";

        items.forEach(item => {
            modalBody.innerHTML += `
            <tr class="group hover:bg-gray-50/50 dark:hover:bg-gray-800/30">
                <td class="py-5 font-bold text-gray-800 dark:text-white">${item.name}</td>
                <td class="py-5 text-center text-gray-600 dark:text-gray-400">${item.qty}</td>
                <td class="py-5 text-center text-gray-600 dark:text-gray-400">${item.price} $</td>
                <td class="py-5 text-center font-black text-blue-600 dark:text-blue-400">${(item.qty * item.price).toFixed(2)} $</td>
            </tr>`;
        });

        modal.classList.remove("hidden");
        document.body.style.overflow = "hidden"; // منع السكرول عند فتح المودال
    }

    function closeModal() {
        modal.classList.add("hidden");
        document.body.style.overflow = "auto";
    }

    // 2. تبديل الوضع الليلي
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    function updateIcons() {
        if (document.documentElement.classList.contains('dark')) {
            lightIcon.classList.remove('hidden');
            darkIcon.classList.add('hidden');
        } else {
            darkIcon.classList.remove('hidden');
            lightIcon.classList.add('hidden');
        }
    }

    themeToggleBtn.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        updateIcons();
    });

    updateIcons();
</script>

</body>
</html>