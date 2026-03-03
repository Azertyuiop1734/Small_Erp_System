<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم الإحصائية</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">إحصائيات النظام العامة</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-green-500">
                <p class="text-gray-500 text-sm">إجمالي الربح</p>
                <h3 class="text-2xl font-bold text-gray-800">${{ number_format($grossProfit, 2) }}</h3>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-blue-500">
                <p class="text-gray-500 text-sm">إجمالي المبيعات</p>
                <h3 class="text-2xl font-bold text-gray-800">${{ number_format($totalSales, 2) }}</h3>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-purple-500">
                <p class="text-gray-500 text-sm">عدد الفواتير</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $invoiceCount }}</h3>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-yellow-500">
                <p class="text-gray-500 text-sm">المنتجات في المخزن</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $productCount }}</h3>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-red-500">
                <p class="text-gray-500 text-sm">عدد الموظفين</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $employeeCount }}</h3>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-md">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">منحنى نمو الأرباح الشهري</h2>
            <div class="h-[400px]">
                <canvas id="profitChart"></canvas>
            </div>
        </div>
    </div>

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