@extends('layouts.app')

@section('title', 'سجل حضور وانصراف الموظفين')

@section('content')

<div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm mb-8 transition-colors duration-300">
    <form action="{{ route('attendance.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
        <div class="w-full md:w-64 space-y-2">
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">تصفية حسب التاريخ</label>
            <div class="relative">
                <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" 
                    class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none">
            </div>
        </div>
        
        <div class="flex gap-2 w-full md:w-auto">
            <button type="submit" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                عرض السجل
            </button>
            
            <a href="{{ route('attendance.index') }}" class="flex-1 md:flex-none bg-gray-100 dark:bg-[#020617] hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 px-6 py-3 rounded-xl font-bold transition border border-gray-200 dark:border-gray-700 text-center">
                إعادة تعيين
            </a>
        </div>
    </form>
</div>

<div class="bg-white dark:bg-[#0f172a] rounded-2xl border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden transition-colors duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-[#020617] text-gray-500 dark:text-gray-400 text-sm uppercase">
                    <th class="px-6 py-4 font-bold">التاريخ</th>
                    <th class="px-6 py-4 font-bold">الموظف</th>
                    <th class="px-6 py-4 font-bold">المخزن / الفرع</th>
                    <th class="px-6 py-4 font-bold text-center">وقت الحضور</th>
                    <th class="px-6 py-4 font-bold text-center">وقت الانصراف</th>
                    <th class="px-6 py-4 font-bold text-center">الحالة</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800/50">
                @forelse($attendances as $record)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-gray-600 dark:text-gray-300">
                        {{ $record->date }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold">
                                {{ substr($record->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 dark:text-white">{{ $record->user->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-500">{{ $record->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400 text-sm">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 4V4" />
                            </svg>
                            {{ $record->user->warehouse->name ?? 'غير محدد' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center font-mono text-emerald-600 dark:text-emerald-400 font-bold">
                        {{ $record->check_in ?? '--:--' }}
                    </td>
                    <td class="px-6 py-4 text-center font-mono text-rose-600 dark:text-rose-400 font-bold">
                        {{ $record->check_in ? ($record->check_out ?? 'في العمل') : '--:--' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $statusClasses = [
                                'present' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400',
                                'absent'  => 'bg-rose-100 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400',
                                'late'    => 'bg-amber-100 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400',
                            ];
                            $status = strtolower($record->status);
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClasses[$status] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($record->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-200 dark:text-gray-800 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">لا توجد سجلات حضور لهذا اليوم.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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