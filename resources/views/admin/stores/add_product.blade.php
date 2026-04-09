@extends('layouts.app')

@section('title', 'إضافة منتج جديد')
@section('page_icon_url', asset('imgs/addproductimg.png'))
@section('content')

<div class="max-w-4xl mx-auto bg-white dark:bg-[#0f172a] p-8 rounded-2xl border border-gray-800 shadow-2xl w-full">        
    <div class="mb-8 border-b border-gray-100 dark:border-gray-800 pb-6">
        <h2 class="text-2xl font-bold text-black  dark:text-white mb-2">إضافة منتج جديد للمخزون</h2>
        <p class="text-gray-400 text-base">يرجى إدخال تفاصيل المنتج بدقة لتحديث قاعدة البيانات</p>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-600 dark:text-gray-200">اسم المنتج</label>
                <input type="text" name="name" 
                    class="w-full bg-gray-200 dark:bg-[#020617] border border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition" 
                    placeholder="أدخل اسم المنتج..." required>
            </div>

            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-600 dark:text-gray-200">الباركود (Barcode)</label>
                <input type="text" name="barcode" 
                    class="w-full bg-gray-200 dark:bg-[#020617] border border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition" 
                    placeholder="امسح أو أدخل الباركود..." required>
            </div>

            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-600 dark:text-gray-200">القسم (Category)</label>
                <select name="category_id" 
                    class="w-full bg-gray-200 dark:bg-[#020617] border border-gray-700 rounded-xl px-4 py-3 text-gray-700 dark:text-white  outline-none focus:ring-2 focus:ring-blue-500 transition appearance-none" required>
                    <option value="" class="bg-[#0f172a]">-- اختر القسم --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" class="bg-[#0f172a]">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-600 dark:text-gray-200">المخزن الأساسي</label>
                <select name="warehouse_id" 
                    class="w-full bg-gray-200 dark:bg-[#020617] border border-gray-700 rounded-xl px-4 py-3 text-gray-700 dark:text-gray-300 outline-none focus:ring-2 focus:ring-blue-500 transition appearance-none" required>
                    <option value="" class="bg-[#0f172a] ">-- اختر المخزن --</option>
                    @foreach($warehouses as $wh)
                        <option value="{{ $wh->id }}" class="bg-[#0f172a]">{{ $wh->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-600 dark:text-gray-200">الحد الأدنى للمخزون</label>
                <input type="number" name="minimum_stock" value="5"
                    class="w-full bg-gray-200 dark:bg-[#020617] border border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white  outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-600 dark:text-gray-200">سعر البيع</label>
                <input type="number" step="0.01" name="selling_price" 
                    class="w-full bg-gray-200 dark:bg-[#020617] border border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white  outline-none focus:ring-2 focus:ring-blue-500 transition" 
                    placeholder="0.00" required>
            </div>
        </div>

        <div class="space-y-2">
            <label class="block text-base font-semibold text-gray-600 dark:text-gray-200">صورة المنتج</label>
            <div class="flex items-center gap-6">
                <input type="file" name="image" id="imgInput" accept="image/*" class="hidden">
                <label for="imgInput" class="cursor-pointer bg-gray-300 dark:bg-[#020617] border border-dashed border-gray-600 hover:border-black dark:hover:border-blue-500 transition rounded-xl p-8 flex flex-col items-center justify-center w-40 h-40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-xs text-gray-400">اختر صورة</span>
                </label>
                
                <div id="previewContainer" class="w-40 h-40 rounded-xl border border-gray-800 overflow-hidden hidden">
                    <img src="" id="previewImg" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <input type="hidden" name="initial_quantity" value="0">

        <div class="pt-4">
            <button type="submit" class="w-full bg-blue-600 py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 text-white">
                حفظ المنتج الجديد
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
