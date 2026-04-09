@extends('layouts.app')

@section('title', 'سجل فواتير المشتريات')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-white dark:bg-[#0f172a] p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm transition-colors duration-300">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            سجل فواتير المشتريات
        </h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">عرض وإدارة جميع عمليات الشراء الواردة للمخازن</p>
    </div>

    <a href="{{ route('purchases.create') }}"
        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition duration-300 flex items-center justify-center gap-2 shadow-lg shadow-blue-600/20">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        إضافة فاتورة شراء
    </a>
</div>

<div class="bg-white dark:bg-[#0f172a] rounded-2xl border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden transition-colors duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-[#020617] text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-bold">رقم الفاتورة</th>
                    <th class="px-6 py-4 font-bold">المورد</th>
                    <th class="px-6 py-4 font-bold">المخزن المستلم</th>
                    <th class="px-6 py-4 font-bold text-center">القيمة الإجمالية</th>
                    <th class="px-6 py-4 font-bold text-center">تاريخ الشراء</th>
                    <th class="px-6 py-4 font-bold text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800/50">
                @forelse($purchases as $purchase)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4">
                        <span class="font-mono font-bold text-blue-600 dark:text-blue-400">
                            #{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 4V4" />
                                </svg>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $purchase->supplier->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400 text-sm">
                        {{ $purchase->warehouse->name ?? 'غير محدد' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 font-mono font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-3 py-1 rounded-lg">
                            {{ number_format($purchase->total_amount, 2) }}
                            <small class="text-[10px]">د.ج</small>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center text-gray-500 dark:text-gray-500 text-sm font-mono">
                        {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center">
                            <a href="{{ route('purchases.show', $purchase->id) }}"
                                class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-transparent border border-blue-600 text-blue-600 dark:text-blue-400 rounded-xl text-xs font-bold hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white transition-all duration-300 shadow-sm hover:shadow-blue-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                تفاصيل الفاتورة
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="p-4 bg-gray-50 dark:bg-gray-800/50 rounded-full mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">لا توجد فواتير مشتريات مسجلة حتى الآن</p>
                            <a href="{{ route('purchases.create') }}" class="mt-4 text-blue-600 dark:text-blue-400 text-sm font-bold hover:underline">ابدأ بإضافة أول فاتورة الآن</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 text-center">
    <p class="text-gray-400 dark:text-gray-500 text-xs flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        جميع الأوقات المعروضة حسب توقيت النظام الرسمي
    </p>
</div>

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
