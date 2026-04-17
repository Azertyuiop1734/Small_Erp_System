<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم الإحصائية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #0b1120; color: #94a3b8; }
        .glass-card { background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.05); }
        .gradient-btn { background: linear-gradient(90deg, #2563eb, #0891b2); }
        .form-input { background-color: #0f172a; border: 1px solid #1e293b; color: white; }
    </style>
</head>
<body class="flex min-h-screen font-sans">
 <main class="flex-1 p-8 overflow-y-auto">

    <div class="max-w-7xl mx-auto">
        <div class="flex items-center gap-3 mb-8 ">
            <i class="fas fa-chart-pie text-blue-500 text-3xl"></i>
            <h2 class="text-3xl font-bold text-white">إحصائيات النظام العامة</h2>
        </div>
        

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
            
            <div class="glass-card p-6 rounded-2xl">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xm uppercase text-gray-400 font-bold">إجمالي الربح</p>
                    <i class="fas fa-chart-line text-green-400 text-xl"></i>
               </div>
               <h3 class="text-4xl font-bold text-blue-500">${{ number_format($grossProfit, 2) }}</h3>
            </div>

            <div class="glass-card p-6 rounded-2xl">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xm uppercase text-gray-400 font-bold">إجمالي المبيعات</p>
                    <i class="fas fa-shopping-cart text-blue-400 text-xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-blue-500">${{ number_format($totalSales, 2) }}</h3>
            </div>

            <div class="glass-card p-6 rounded-2xl">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xm uppercase text-gray-400 font-bold">عدد الفواتير</p>
                    <i class="fas fa-file-invoice-dollar text-purple-400 text-xl"></i>
               </div>
               <h3 class="text-4xl font-bold text-blue-500">{{ $invoiceCount }}</h3>
            </div>

            <div class="glass-card p-6 rounded-2xl">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xm uppercase text-gray-400 font-bold">المنتجات في المخزن</p>
                    <i class="fas fa-boxes text-yellow-400 text-xl"></i>
                </div>  
                <h3 class="text-4xl font-bold text-blue-500">{{ $productCount }}</h3>
            </div>

            <div class="glass-card p-6 rounded-2xl">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xm uppercase text-gray-400 font-bold">عدد الموظفين</p>
                    <i class="fas fa-users text-indigo-400 text-xl"></i>
                </div>
                <h3 class="text-4xl font-bold text-blue-500">{{ $employeeCount }}</h3>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-md">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">منحنى نمو الأرباح الشهري</h2>
                </div>
                <button class="text-gray-400 hover:text-blue-500 transition-colors">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
            <div class="h-[400px]">
                <canvas id="profitChart"></canvas>
            </div>
        </div>
    </div>
 </main>

    <script>
        const ctx = document.getElementById('profitChart').getContext('2d');
        
        // تجهيز البيانات من Laravel إلى JavaScript
        const labels = {!! json_encode($monthlyProfit->pluck('month')) !!};
        const data = {!! json_encode($monthlyProfit->pluck('revenue')) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'الربح الشهري ($)',
                    data: data,
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgb(34, 197, 94)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', rtl: true }
                },
                scales: {
                    y: { beginAtZero: true },
                    x: { reverse: true } // لدعم الاتجاه من اليمين لليسار
                }
            }
        });
    </script>
</body>
</html>