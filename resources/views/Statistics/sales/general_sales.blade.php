@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 px-4 py-6">

    <div class="flex flex-col md:flex-row justify-between items-center glass-panel p-6 rounded-3xl shadow-xl gap-4">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-600/20">
                <i class="fas fa-chart-line text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-gray-800 dark:text-white transition-colors tracking-tight">Sales Performance</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 font-medium italic">General overview of sales and revenue</p>
            </div>
        </div>
        <div class="px-4 py-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 text-sm font-bold text-gray-600 dark:text-gray-300">
            <i class="far fa-calendar-alt mr-2 text-indigo-500"></i> {{ now()->format('Y-m-d') }}
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-panel p-6 rounded-[2rem] shadow-xl border-t-4 border-indigo-500 transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Sales</p>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white">{{ number_format($totalSales, 2) }} <span class="text-xs font-normal opacity-50">DA</span></h3>
                </div>
                <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 rounded-lg">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>

        <div class="glass-panel p-6 rounded-[2rem] shadow-xl border-t-4 border-emerald-500 transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Orders</p>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white">{{ number_format($orderCount) }}</h3>
                </div>
                <div class="p-2 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 rounded-lg">
                    <i class="fas fa-shopping-basket"></i>
                </div>
            </div>
        </div>

        <div class="glass-panel p-6 rounded-[2rem] shadow-xl border-t-4 border-amber-500 transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Avg. Order Value</p>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white">{{ number_format($avgOrderValue, 2) }}</h3>
                </div>
                <div class="p-2 bg-amber-50 dark:bg-amber-900/30 text-amber-600 rounded-lg">
                    <i class="fas fa-percentage"></i>
                </div>
            </div>
        </div>

        <div class="glass-panel p-6 rounded-[2rem] shadow-xl border-t-4 border-rose-500 transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Customers</p>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white">{{ number_format($totalCustomers) }}</h3>
                </div>
                <div class="p-2 bg-rose-50 dark:bg-rose-900/30 text-rose-600 rounded-lg">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass-panel p-8 rounded-[2.5rem] shadow-2xl">
            <h3 class="text-lg font-black text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                <i class="fas fa-chart-area text-indigo-500"></i> Revenue Trend (12 Months)
            </h3>
            <div class="relative h-[300px]">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>

        <div class="glass-panel p-8 rounded-[2.5rem] shadow-2xl">
            <h3 class="text-lg font-black text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                <i class="fas fa-wallet text-emerald-500"></i> Payment Methods
            </h3>
            <div class="relative h-[300px]">
                <canvas id="paymentChart"></canvas>
            </div>
        </div>
    </div>

    <div class="glass-panel rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-800">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center bg-gray-50/30 dark:bg-slate-800/30">
            <h3 class="font-black text-gray-800 dark:text-white">Recent Sales Transactions</h3>
            <button class="text-xs font-bold text-indigo-600 hover:text-indigo-700 underline">View All Report</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 dark:bg-slate-800/50 text-gray-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="p-5">Order ID</th>
                        <th class="p-5">Customer</th>
                        <th class="p-5">Date</th>
                        <th class="p-5 text-right">Total Amount</th>
                        <th class="p-5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($recentSales as $sale)
                    <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-colors">
                        <td class="p-5 font-bold text-indigo-600 text-sm">#{{ $sale->id }}</td>
                        <td class="p-5">
                            <div class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $sale->customer->name ?? 'Guest' }}</div>
                        </td>
                        <td class="p-5 text-xs text-gray-500">{{ $sale->created_at->format('M d, Y') }}</td>
                        <td class="p-5 text-right font-black text-gray-800 dark:text-white">
                            {{ number_format($sale->total_amount, 2) }}
                        </td>
                        <td class="p-5 text-center">
                            @php
                                $statusClass = $sale->status === 'paid' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black border {{ $statusClass }}">
                                {{ strtoupper($sale->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#94a3b8' : '#64748b';

    // 1. Sales Trend Chart
    new Chart(document.getElementById('salesTrendChart'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Revenue',
                data: @json($monthlySalesData),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#6366f1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: textColor } },
                x: { grid: { display: false }, ticks: { color: textColor } }
            }
        }
    });

    // 2. Payment Methods Chart
    new Chart(document.getElementById('paymentChart'), {
        type: 'doughnut',
        data: {
            labels: ['Cash', 'Card', 'Transfer'],
            datasets: [{
                data: [55, 30, 15], // استبدل ببيانات حقيقية من الكنترولر لاحقاً
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { position: 'bottom', labels: { color: textColor, usePointStyle: true, padding: 20 } }
            }
        }
    });
</script>
@endsection
@endsection
@push('scripts')
      
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
   <script>
    
    // 1. وظيفة القوائم المنسدلة (Dropdowns) الموحدة
    function setupDropdown(btnId, menuId, arrowId) {
        const btn = document.getElementById(btnId);
        const menu = document.getElementById(menuId);
        const arrow = document.getElementById(arrowId);
        
        if(btn && menu) {
            btn.addEventListener('click', () => {
                const isOpen = menu.style.maxHeight !== '0px' && menu.style.maxHeight !== '';
                menu.style.maxHeight = isOpen ? '0px' : menu.scrollHeight + 'px';
                if(arrow) arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        }
    }

    // تفعيل كل القوائم
    setupDropdown('supplierBtn', 'supplierMenu', 'supplierArrow');
    setupDropdown('warehouseBtn', 'warehouseMenu', 'warehouseArrow');
    setupDropdown('employeeBtn', 'employeeMenu', 'employeeArrow');
    setupDropdown('purchasesBtn', 'purchasesMenu', 'purchasesArrow');
    setupDropdown('expensesBtn', 'expensesMenu', 'expensesArrow');
    setupDropdown('statisticsBtn', 'statisticsMenu', 'statisticsArrow');
    // 2. وظيفة إغلاق وفتح السايد بار (Sidebar Toggle)
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
toggleBtn.addEventListener('click', () => {
    // إخفاء السايد بار بإزاحته لليمين خارج الشاشة
    sidebar.classList.toggle('translate-x-full');
    
    if (sidebar.classList.contains('translate-x-full')) {
        // توسيع المحتوى والناف بار ليأخذا كامل الشاشة
        mainContent.classList.replace('mr-72', 'mr-0');
    } else {
        // إعادة الهامش لحجز مكان للسايد بار
        mainContent.classList.replace('mr-0', 'mr-72');
    }
});

   
</script>
@endpush