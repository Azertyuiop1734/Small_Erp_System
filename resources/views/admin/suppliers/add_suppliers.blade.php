@extends('layouts.app')

@section('title', 'إضافة مورد جديد')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-[#0f172a] rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm dark:shadow-xl overflow-hidden transition-colors duration-300">
        
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-[#020617]/50">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                بيانات المورد الجديد
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">يرجى ملء كافة الحقول المطلوبة لإضافة مورد جديد للنظام.</p>
        </div>

        <form action="{{ route('suppliers.store') }}" method="POST" class="p-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">اسم المورد </span></label>
                    <input type="text" name="name" required
                        class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none placeholder-gray-400"
                        placeholder="أدخل الاسم الكامل">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">اسم الشركة</label>
                    <input type="text" name="company_name"
                        class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none placeholder-gray-400"
                        placeholder="شركة التوريد المحدودة">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">رقم الهاتف</label>
                    <input type="text" name="phone"
                        class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none text-left"
                        placeholder="0XXXXXXXXX">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">الرصيد الافتتاحي (دينار)</label>
                    <input type="number" step="0.01" name="balance" value="0"
                        class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none">
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">العنوان بالتفصيل</label>
                    <textarea name="address" rows="3"
                        class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none placeholder-gray-400"
                        placeholder="المدينة، الشارع، المعالم القريبة..."></textarea>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800 flex flex-col md:flex-row gap-4">
                <button type="submit" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all duration-300 shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    حفظ بيانات المورد
                </button>
                
                <a href="{{ url()->previous() }}" 
                    class="flex-1 bg-gray-100 dark:bg-[#020617] hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 font-bold py-3 rounded-xl transition-all duration-300 text-center border border-gray-200 dark:border-gray-700">
                    إلغاء العملية
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // تخصيص تنبيهات SweetAlert لتناسب المظهر الجديد
    const swalConfig = {
        background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#fff',
        color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
    };

    @if(session('success'))
        Swal.fire({
            ...swalConfig,
            title: 'تمت العملية!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#2563eb',
            timer: 3000
        });
    @endif

    @if($errors->any())
        Swal.fire({
            ...swalConfig,
            title: 'خطأ في البيانات!',
            html: '<div class="text-right text-sm">{!! implode("<br>", $errors->all()) !!}</div>',
            icon: 'error',
            confirmButtonColor: '#e11d48'
        });
    @endif
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