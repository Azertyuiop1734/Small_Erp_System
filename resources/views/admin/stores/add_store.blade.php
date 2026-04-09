@extends('layouts.app')
@section('page_icon_url', asset('imgs/warehouseimg.png'))
@section('title', 'إضافة مخزن جديد')

@section('content')
 
        
       
          
       
   
    <div class="max-w-2xl mx-auto bg-white dark:bg-[#0f172a] p-8 rounded-2xl border border-gray-300  dark:border-gray-800 shadow-2xl">
        
        <div class="mb-8 border-b border-gray-800/50 pb-6">
            <h2 class="text-2xl font-bold text-black dark:text-white mb-2">إضافة مستودع جديد</h2>
            <p class="text-gray-400 text-base">يرجى ملء البيانات أدناه لإضافة مخزن جديد إلى النظام</p>
        </div>

        <form action="{{ route('stores.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-700 dark:text-gray-200">اسم المخزن</label>
                <input type="text" name="name" 
                    class="w-full bg-gray-200 dark:bg-[#020617] border border-gray-700 rounded-xl px-4 py-3 text-white outline-none focus:ring-2 focus:ring-blue-500 transition" 
                    placeholder="أدخل اسم المخزن..." required>
            </div>

            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-700 dark:text-gray-200">موقع المخزن</label>
                <textarea name="location" rows="4" 
                    class="w-full bg-gray-200 dark:bg-[#020617] border border-gray-700 rounded-xl px-4 py-3 text-white outline-none focus:ring-2 focus:ring-blue-500 transition"
                    placeholder="أدخل العنوان بالتفصيل..."></textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full text-white bg-blue-600 py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20">
                    حفظ البيانات
                </button>
            </div>
        </form>

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
