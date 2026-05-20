@extends('layouts.app')

@section('content')
<div id="vanta-bg" class="fixed top-0 left-0 w-full h-full -z-10"></div>
<div class="max-w-7xl mx-auto space-y-10 animate-fade-in">
    
    <div class="relative overflow-hidden bg-white dark:bg-[#0a1120] p-10 rounded-[3rem] border border-gray-100 dark:border-white/5 shadow-2xl">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-black text-gray-800 dark:text-white tracking-tight">لوحة الإحصائيات العامة</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-2 text-lg">نظرة شاملة على أداء النظام والنمو المالي</p>
            </div>
            <div class="hidden md:block">
                <span class="px-6 py-3 bg-blue-500/10 text-blue-500 rounded-2xl font-bold border border-blue-500/20">
                    <i class="far fa-calendar-alt ml-2"></i> تحديث مباشر
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
        
        <div class="group bg-white/80 dark:bg-[#0a1120]/80 backdrop-blur-md p-8 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-white/5 transition-all duration-300 hover:-translate-y-2">
            <div class="w-12 h-12 bg-green-500/20 rounded-2xl flex items-center justify-center mb-6 text-green-500">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-wider">إجمالي الربح</p>
          <h3 class="text-xl md:text-2xl lg:text-2xl font-black text-gray-800 dark:text-white tracking-tight break-words">${{ number_format($grossProfit, 2) }}</h3>
            <div class="mt-4 h-1.5 w-full bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 w-3/4 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></div>
            </div>
        </div>

        <div class="group bg-white/80 dark:bg-[#0a1120]/80 backdrop-blur-md p-8 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-white/5 transition-all duration-300 hover:-translate-y-2">
            <div class="w-12 h-12 bg-blue-500/20 rounded-2xl flex items-center justify-center mb-6 text-blue-500">
                <i class="fas fa-shopping-cart text-xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-wider">المبيعات</p>
            <h3 class="text-xl md:text-2xl lg:text-2xl font-black text-gray-800 dark:text-white tracking-tight break-words">${{ number_format($totalSales, 2) }}</h3>
            <div class="mt-4 h-1.5 w-full bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500 w-2/3 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
            </div>
        </div>

        <div class="group bg-white/80 dark:bg-[#0a1120]/80 backdrop-blur-md p-8 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-white/5 transition-all duration-300 hover:-translate-y-2">
            <div class="w-12 h-12 bg-purple-500/20 rounded-2xl flex items-center justify-center mb-6 text-purple-500">
                <i class="fas fa-file-invoice-dollar text-xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-wider">الفواتير</p>
            <h3 class="text-xl md:text-2xl lg:text-2xl font-black text-gray-800 dark:text-white tracking-tight break-words">{{ $invoiceCount }}</h3>
            <div class="mt-4 h-1.5 w-full bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-purple-500 w-1/2 shadow-[0_0_10px_rgba(168,85,247,0.5)]"></div>
            </div>
        </div>

        <div class="group bg-white/80 dark:bg-[#0a1120]/80 backdrop-blur-md p-8 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-white/5 transition-all duration-300 hover:-translate-y-2">
            <div class="w-12 h-12 bg-yellow-500/20 rounded-2xl flex items-center justify-center mb-6 text-yellow-500">
                <i class="fas fa-boxes text-xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-wider">المخزون</p>
            <h3 class="text-xl md:text-2xl lg:text-2xl font-black text-gray-800 dark:text-white tracking-tight break-words">{{ $productCount }}</h3>
            <div class="mt-4 h-1.5 w-full bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-yellow-500 w-4/5 shadow-[0_0_10px_rgba(234,179,8,0.5)]"></div>
            </div>
        </div>

        <div class="group bg-white/80 dark:bg-[#0a1120]/80 backdrop-blur-md p-8 rounded-[2.5rem] shadow-xl border border-gray-100 dark:border-white/5 transition-all duration-300 hover:-translate-y-2">
            <div class="w-12 h-12 bg-red-500/20 rounded-2xl flex items-center justify-center mb-6 text-red-500">
                <i class="fas fa-users text-xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-bold uppercase tracking-wider">الفريق</p>
            <h3 class="text-xl md:text-2xl lg:text-2xl font-black text-gray-800 dark:text-white tracking-tight break-words">{{ $employeeCount }}</h3>
            <div class="mt-4 h-1.5 w-full bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                <div class="h-full bg-red-500 w-1/3 shadow-[0_0_10px_rgba(239,68,68,0.5)]"></div>
            </div>
        </div>
    </div>

    <div class="bg-white/80 dark:bg-[#0a1120]/80 backdrop-blur-xl p-10 rounded-[3rem] shadow-2xl border border-gray-100 dark:border-white/5">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <h2 class="text-2xl font-black text-gray-800 dark:text-white">منحنى نمو الأرباح الشهري</h2>
           
        </div>
        <div class="relative w-full h-[450px]">
            <canvas id="profitChart"></canvas>
        </div>
    </div>
</div>


<style>
    /* لجعل الكروت واضحة فوق الخلفية المتحركة */
.group {
    background-color: rgba(255, 255, 255, 0.05) !important; /* شفافية خفيفة جداً */
    backdrop-filter: blur(12px); /* تأثير زجاجي قوي */
    border: 1px solid rgba(255, 255, 255, 0.1);
    opacity: 0; /* سنظهرها باستخدام GSAP */
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.5s ease;
}

/* لضمان أن الخلفية تغطي الشاشة بالكامل */
body, html {
    margin: 0;
    padding: 0;
    background-color: #050a15; /* لون أساسي غامق */
    transition: background-color 0.5s ease, color 0.5s ease;
}
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    body {
    min-height: 100vh;
    margin: 0;
    overflow-x: hidden; /* لمنع ظهور شريط تمرير عرضي أثناء حركة السايد بار */
}
</style>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // متغيرات عامة
    let myChart = null;
   window.vantaEffect = null

    // إنشاء المنحنى
 function initChart() {
    const canvas = document.getElementById('profitChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const isDark = document.documentElement.classList.contains('dark');

    // تحديد الألوان بناءً على الوضع الحالي
    const primaryColor = isDark ? '#10b981' : '#059669'; // أخضر زاهي للداكن وأغمق للفاتح
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

    // بيانات Laravel
    const labels = {!! json_encode($monthlyProfit->pluck('month')) !!};
    const data = {!! json_encode($monthlyProfit->pluck('revenue')) !!};

    // إذا كان المنحنى موجوداً مسبقاً، نحدث ألوانه فقط بدلاً من تدميره
    if (window.myChart) {
        window.myChart.data.datasets[0].borderColor = primaryColor;
        window.myChart.data.datasets[0].backgroundColor = isDark ? 'rgba(16, 185, 129, 0.1)' : 'rgba(5, 150, 105, 0.05)';
        window.myChart.data.datasets[0].pointBackgroundColor = primaryColor;
        
        // تحديث ألوان المحاور والنصوص
        window.myChart.options.scales.y.ticks.color = textColor;
        window.myChart.options.scales.y.grid.color = gridColor;
        window.myChart.options.scales.x.ticks.color = textColor;
        window.myChart.options.plugins.legend.labels.color = textColor;

        window.myChart.update('none'); // تحديث فوري بدون أنيميشن داخلي لمنع الثقل
        return;
    }

    // إنشاء المنحنى للمرة الأولى فقط
    window.myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'الربح الشهري ($)',
                data: data,
                borderColor: primaryColor,
                backgroundColor: isDark ? 'rgba(16, 185, 129, 0.1)' : 'rgba(5, 150, 105, 0.05)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: primaryColor
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: {
                    position: 'top',
                    rtl: true,
                    labels: { color: textColor, font: { family: 'Plus Jakarta Sans' } }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { color: textColor }
                },
                x: { 
                    reverse: true,
                    grid: { display: false },
                    ticks: { color: textColor }
                }
            }
        }
    });
}

    // تحديث خلفية Vanta
    function updateVantaTheme() {

        const isDark = document.documentElement.classList.contains('dark');

        const vantaOptions = {
            el: "body",

            mouseControls: true,
            touchControls: true,
            gyroControls: false,

            minHeight: 200.00,
            minWidth: 200.00,

            scale: 1.00,
            scaleMobile: 1.00,

            points: 15.00,
            maxDistance: 20.00,
            spacing: 16.00,

            color: isDark ? 0x3b82f6 : 0x2563eb,
            backgroundColor: isDark ? 0x050a15 : 0xf8fafc
        };

        // حذف الخلفية القديمة
        if (vantaEffect) {
            vantaEffect.destroy();
        }

        // إنشاء الخلفية الجديدة
        if (window.VANTA) {
            vantaEffect = VANTA.NET(vantaOptions);
        }
    }

    // التشغيل بعد تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function () {

        // تشغيل الخلفية
        updateVantaTheme();

        // تشغيل المنحنى
        initChart();

        // مراقبة تغيير حجم الحاوية
        const chartContainer = document.querySelector('#profitChart').parentElement;

        const resizeObserver = new ResizeObserver(() => {

            if (myChart) {
                myChart.resize();
            }

        });

        resizeObserver.observe(chartContainer);

        // مراقبة تغيير الثيم
        const observer = new MutationObserver(() => {
            updateVantaTheme();
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        // أنيميشن البطاقات
        gsap.to(".group", {
            opacity: 1,
            y: 0,

            stagger: 0.15,
            duration: 1,

            ease: "power4.out"
        });

        // عداد الأرقام
        document.querySelectorAll('h3').forEach(h3 => {

            const originalValue = h3.innerText;

            const numericValue =
                parseFloat(originalValue.replace(/[^\d.]/g, '')) || 0;

            const isCurrency = originalValue.includes('$');

            const counter = {
                val: 0
            };

            gsap.to(counter, {

                val: numericValue,

                duration: 2,
                ease: "power2.out",

                onUpdate: () => {

                    let formatted = counter.val.toLocaleString(undefined, {
                        minimumFractionDigits:
                            originalValue.includes('.') ? 2 : 0,

                        maximumFractionDigits:
                            originalValue.includes('.') ? 2 : 0
                    });

                    h3.innerText =
                        isCurrency ? `$${formatted}` : formatted;
                }
            });
        });

     
        }
    );
</script>
@endpush