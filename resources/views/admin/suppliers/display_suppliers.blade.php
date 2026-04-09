@extends('layouts.app')

@section('title', 'قائمة الموردين المسجلين')

@section('content')

<section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center gap-4 transition-colors duration-300">
        <div class="p-4 bg-blue-600/10 rounded-xl text-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $suppliers->count() }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">إجمالي الموردين</p>
        </div>
    </div>
</section>

<div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm mb-8 transition-colors duration-300">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="relative w-full md:w-96">
            <input type="text" id="supplierSearch" placeholder="ابحث عن مورد أو شركة..." 
                class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 pr-10 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none placeholder-gray-400">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        
        <a href="{{ route('suppliers.create') }}" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-blue-600/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            إضافة مورد جديد
        </a>
    </div>
</div>

<div class="bg-white dark:bg-[#0f172a] rounded-2xl border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden transition-colors duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-[#020617] text-gray-500 dark:text-gray-400 text-sm uppercase">
                    <th class="px-6 py-4 font-bold">#</th>
                    <th class="px-6 py-4 font-bold">اسم المورد</th>
                    <th class="px-6 py-4 font-bold">الشركة</th>
                    <th class="px-6 py-4 font-bold">الهاتف</th>
                    <th class="px-6 py-4 font-bold text-center">المستحقات (الدين)</th>
                    <th class="px-6 py-4 font-bold">العنوان</th>
                    <th class="px-6 py-4 font-bold text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800/50">
                @forelse($suppliers as $supplier)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $supplier->id }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $supplier->name }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 text-sm">{{ $supplier->company_name ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 text-sm font-mono tracking-tighter">{{ $supplier->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $supplier->balance > 0 ? 'bg-rose-100 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400' : 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' }}">
                            {{ number_format($supplier->balance, 2) }} د.ج
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm max-w-[200px] truncate">{{ $supplier->address ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-lg transition-colors" title="تعديل">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="delete-form inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-delete p-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="حذف">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">لا يوجد موردين مضافين حالياً.</td>
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
    // إعدادات SweetAlert المتوافقة مع الـ Dark Mode
    const swalConfig = {
        background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#fff',
        color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
    };

    @if(session('success'))
        Swal.fire({
            ...swalConfig,
            icon: 'success',
            title: 'تمت العملية',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    // تأكيد الحذف
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                ...swalConfig,
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف المورد وكافة بياناته نهائياً!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'نعم، احذفه!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush