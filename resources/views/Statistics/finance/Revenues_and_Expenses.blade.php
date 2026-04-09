@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <div class="flex flex-col md:flex-row justify-between items-center glass-panel p-6 rounded-3xl shadow-xl gap-4">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-600/20">
                <i class="fas fa-chart-pie text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-gray-800 dark:text-white transition-colors tracking-tight">Financial Overview</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 font-medium italic">Statistics for the year {{ Carbon\Carbon::now()->year }}</p>
            </div>
        </div>
        
        <button onclick="window.print()" class="bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-200 px-6 py-3 rounded-2xl font-bold border border-gray-100 dark:border-gray-700 shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
            <i class="fas fa-print text-sm"></i>
            <span>Print Report</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="relative overflow-hidden group glass-panel p-6 rounded-[2rem] border-b-4 border-blue-500 shadow-xl transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">Today's Sales</p>
                    <h2 class="text-3xl font-black text-gray-800 dark:text-white">{{ number_format($salesToday, 2) }} <span class="text-xs font-normal opacity-60">DA</span></h2>
                </div>
                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-blue-600">
                    <i class="fas fa-calendar-day text-xl"></i>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-125 transition-transform">
                <i class="fas fa-calendar-day text-8xl text-blue-500"></i>
            </div>
        </div>

        <div class="relative overflow-hidden group glass-panel p-6 rounded-[2rem] border-b-4 border-emerald-500 shadow-xl transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-1">Monthly Revenue</p>
                    <h2 class="text-3xl font-black text-gray-800 dark:text-white">{{ number_format($salesThisMonth, 2) }} <span class="text-xs font-normal opacity-60">DA</span></h2>
                </div>
                <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center text-emerald-600">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-125 transition-transform">
                <i class="fas fa-chart-line text-8xl text-emerald-500"></i>
            </div>
        </div>

        <div class="relative overflow-hidden group glass-panel p-6 rounded-[2rem] border-b-4 border-rose-500 shadow-xl transition-transform hover:scale-[1.02]">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest mb-1">Monthly Expenses</p>
                    <h2 class="text-3xl font-black text-gray-800 dark:text-white">{{ number_format($expensesThisMonth, 2) }} <span class="text-xs font-normal opacity-60">DA</span></h2>
                </div>
                <div class="w-12 h-12 bg-rose-50 dark:bg-rose-900/30 rounded-2xl flex items-center justify-center text-rose-600">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-125 transition-transform">
                <i class="fas fa-wallet text-8xl text-rose-500"></i>
            </div>
        </div>
    </div>

    <div class="glass-panel p-8 rounded-[2.5rem] shadow-2xl border border-white/10">
        <div class="flex items-center gap-3 mb-8">
            <h3 class="text-lg font-black text-gray-800 dark:text-white">Annual Financial Performance</h3>
            <div class="h-px flex-1 bg-gray-100 dark:bg-gray-800"></div>
        </div>
        <div class="relative h-[450px]">
            <canvas id="financialChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('financialChart').getContext('2d');
    
    // إعداد التدرجات اللونية للرسم البياني
    const salesGradient = ctx.createLinearGradient(0, 0, 0, 400);
    salesGradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)');
    salesGradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

    const expensesGradient = ctx.createLinearGradient(0, 0, 0, 400);
    expensesGradient.addColorStop(0, 'rgba(244, 63, 94, 0.5)');
    expensesGradient.addColorStop(1, 'rgba(244, 63, 94, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [
                {
                    label: 'Total Sales (DA)',
                    data: @json($monthlySalesData),
                    borderColor: '#3b82f6',
                    backgroundColor: salesGradient,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 3
                },
                {
                    label: 'Total Expenses (DA)',
                    data: @json($monthlyExpensesData),
                    borderColor: '#f43f5e',
                    backgroundColor: expensesGradient,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#f43f5e',
                    pointBorderWidth: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { family: 'Cairo', weight: 'bold', size: 12 },
                        color: document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { family: 'Cairo', size: 14 },
                    bodyFont: { family: 'Cairo', size: 13 },
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: {
                        color: '#94a3b8',
                        callback: (value) => value.toLocaleString() + ' DA'
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                }
            }
        }
    });
</script>
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

    // 3. تنبيه النجاح (SweetAlert)
    @if(session('success'))
        Swal.fire({
            title: 'تم الحفظ!',
            text: "{{ session('success') }}",
            icon: 'success',
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#2563eb'
        });
    @endif
</script>
@endpush
