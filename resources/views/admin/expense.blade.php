@extends('layouts.app')

@section('title', 'سجل المصاريف والنفقات')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm transition-all">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-600 dark:text-rose-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">إجمالي المصاريف</p>
                <p class="text-2xl font-black text-gray-900 dark:text-white font-mono">{{ number_format($expenses->sum('amount'), 2) }} <small class="text-xs">د.ج</small></p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm transition-all md:col-span-2 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">إدارة المصاريف</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">تتبع كافة المصاريف التشغيلية للمؤسسة</p>
        </div>
        <button onclick="openExpenseModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-blue-600/20 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            إضافة مصاريف
        </button>
    </div>
</div>

<div class="bg-white dark:bg-[#0f172a] rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden transition-colors duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-[#020617] text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-bold">التاريخ</th>
                    <th class="px-6 py-4 font-bold">الوصف / البيان</th>
                    <th class="px-6 py-4 font-bold">الفئة</th>
                    <th class="px-6 py-4 font-bold">بواسطة</th>
                    <th class="px-6 py-4 font-bold text-center">المبلغ</th>
                    <th class="px-6 py-4 font-bold text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800/50">
                @forelse($expenses as $expense)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 font-mono">
                        {{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-900 dark:text-white font-bold">{{ $expense->description }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-lg text-xs font-medium border border-gray-200 dark:border-gray-700">
                            {{ $expense->category ?? 'عام' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-[10px] text-blue-600 dark:text-blue-400 font-bold">
                                {{ substr($expense->user->name ?? 'A', 0, 1) }}
                            </div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $expense->user->name ?? 'غير معروف' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="font-mono font-bold text-rose-600 dark:text-rose-400">
                            {{ number_format($expense->amount, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="delete-form">
                                @csrf @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="p-2 text-gray-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" stroke-width="2"/></svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">لا توجد مصاريف مسجلة</p>
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
 
    async function openExpenseModal() {
        const isDark = document.documentElement.classList.contains('dark');
        
        const { value: formValues } = await Swal.fire({
            title: '<span class="dark:text-white">إضافة مصاريف جديدة</span>',
            background: isDark ? '#0f172a' : '#fff',
            color: isDark ? '#fff' : '#000',
            html: `
                <div class="flex flex-col gap-4 text-right p-2">
                    <div>
                        <label class="text-xs font-bold text-gray-400">الوصف / البيان</label>
                        <input id="swal-desc" class="w-full mt-1 bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-400">المبلغ (د.ج)</label>
                            <input id="swal-amount" type="number" class="w-full mt-1 bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400">التاريخ</label>
                            <input id="swal-date" type="date" value="{{ date('Y-m-d') }}" class="w-full mt-1 bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'حفظ البيانات',
            cancelButtonText: 'إلغاء',
            confirmButtonColor: '#2563eb',
            customClass: { popup: 'rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl' },
            preConfirm: () => {
                return {
                    description: document.getElementById('swal-desc').value,
                    amount: document.getElementById('swal-amount').value,
                    date: document.getElementById('swal-date').value,
                    _token: '{{ csrf_token() }}'
                }
            }
        });

        if (formValues) {
            // إرسال البيانات عبر AJAX أو Submit عادي
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('expenses.store') }}";
            for (const key in formValues) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = formValues[key];
                form.appendChild(input);
            }
            document.body.appendChild(form);
            form.submit();
        }
    }

    function confirmDelete(button) {
        const form = button.closest('.delete-form');
        const isDark = document.documentElement.classList.contains('dark');

        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لن تتمكن من استرجاع هذا السجل!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء',
            background: isDark ? '#0f172a' : '#fff',
            color: isDark ? '#fff' : '#000',
            customClass: { popup: 'rounded-3xl' }
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }
</script>
@endpush