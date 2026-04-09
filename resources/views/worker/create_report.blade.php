@extends('layouts.app')

@section('title', 'إنشاء تقرير عمل جديد')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-[#0f172a] rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden transition-colors duration-300">
        
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-white flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold tracking-wide">إرسال تقرير عمل</h2>
                <p class="text-blue-100 mt-1 text-sm opacity-90">قم بتوثيق الإنجازات أو الملاحظات اليومية بدقة</p>
            </div>
            <div class="p-4 bg-white/10 rounded-2xl backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
        </div>

        <form action="{{ route('reports.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">عنوان التقرير</label>
                    <div class="relative">
                        <input type="text" name="title" required
                            class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none placeholder-gray-400"
                            placeholder="مثال: تقرير الجرد الدوري، ملاحظات الصيانة...">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">تاريخ التقرير</label>
                    <input type="date" name="report_date" value="{{ date('Y-m-d') }}" required
                        class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">التفاصيل والوصف</label>
                <textarea name="description" rows="8" required
                    class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none placeholder-gray-400 resize-none"
                    placeholder="اكتب تفاصيل العمل، المشاكل التي واجهتك، أو أي اقتراحات..."></textarea>
            </div>

            <div class="p-4 bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/30 rounded-2xl flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs text-amber-700 dark:text-amber-400 leading-relaxed">
                    ملاحظة: سيتم إرسال هذا التقرير مباشرة إلى إدارة النظام، وسيتضمن اسمك وتوقيت الإرسال تلقائياً. تأكد من مراجعة البيانات قبل الاعتماد.
                </p>
            </div>

            <div class="pt-6 flex flex-col md:flex-row justify-end gap-4 border-t border-gray-100 dark:border-gray-800">
                <button type="reset" class="px-6 py-3 rounded-xl text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 font-bold transition order-2 md:order-1">
                    مسح المسودة
                </button>
                <button type="submit" 
                    class="px-10 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-600/20 transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2 order-1 md:order-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    إرسال التقرير الآن
                </button>
            </div>
        </form>
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
    // إعدادات التنبيهات المتوافقة مع الـ Dark Mode
    const swalConfig = {
        background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#fff',
        color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
    };

    @if(session('success'))
        Swal.fire({
            ...swalConfig,
            icon: 'success',
            title: 'تم الإرسال!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'حسناً'
        });
    @endif

    // تنبيه عند محاولة المسح
    document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            ...swalConfig,
            title: 'هل أنت متأكد؟',
            text: "سيتم حذف كل ما كتبته في هذا التقرير!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'نعم، امسح',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').reset();
            }
        });
    });
</script>
@endpush