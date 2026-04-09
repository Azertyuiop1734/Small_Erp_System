@extends('layouts.app')

@section('content')
<div class="min-h-screen p-6 lg:p-8 flex items-start justify-center">
    <div class="w-full max-w-2xl">
        <div class="flex items-center gap-4 mb-8">
            <div class="p-3 bg-blue-600 rounded-2xl shadow-lg shadow-blue-600/20">
                <i class="fas fa-wallet text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white transition-colors">إضافة مصاريف جديدة</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">سجل مصروفات الشركة بدقة لتتبع ميزانيتك</p>
            </div>
        </div>

        <div class="bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl border border-gray-100 dark:border-gray-800 rounded-3xl shadow-2xl overflow-hidden transition-all">
            <form action="{{ route('expenses.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mr-1">عنوان المصروف</label>
                    <div class="relative group">
                        <input type="text" name="title" required
                            class="w-full bg-gray-50 dark:bg-[#030712] border border-gray-200 dark:border-gray-800 text-gray-900 dark:text-white rounded-2xl py-4 px-5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder-gray-400"
                            placeholder="مثال: فاتورة الكهرباء، أدوات مكتبية">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mr-1">المبلغ ($)</label>
                        <div class="relative group">
                            <input type="number" step="0.01" name="amount" required
                                class="w-full bg-gray-50 dark:bg-[#030712] border border-gray-200 dark:border-gray-800 text-gray-900 dark:text-white rounded-2xl py-4 px-5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                                placeholder="0.00">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mr-1">التاريخ</label>
                        <div class="relative group">
                            <input type="date" name="expense_date" value="{{ date('Y-m-d') }}" required
                                class="w-full bg-gray-50 dark:bg-[#030712] border border-gray-200 dark:border-gray-800 text-gray-900 dark:text-white rounded-2xl py-4 px-5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mr-1">الوصف (اختياري)</label>
                    <textarea name="description" rows="4"
                        class="w-full bg-gray-50 dark:bg-[#030712] border border-gray-200 dark:border-gray-800 text-gray-900 dark:text-white rounded-2xl py-4 px-5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all placeholder-gray-400"
                        placeholder="أضف تفاصيل إضافية هنا..."></textarea>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4">
                    <a href="{{ route('expenses.index') }}" 
                        class="w-full sm:w-auto px-8 py-4 text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors text-center">
                        إلغاء
                    </a>
                    <button type="submit" 
                        class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-10 rounded-2xl shadow-xl shadow-blue-600/20 transform active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i>
                        <span>حفظ المصروفات</span>
                    </button>
                </div>
            </form>
        </div>
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
