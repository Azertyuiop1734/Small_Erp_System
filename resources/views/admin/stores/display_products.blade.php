@extends('layouts.app')

@section('title', 'قائمة المنتجات والمخزون')
@section('page_icon_url', asset('imgs/browseproductsimg.png'))

@section('content')

<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- بطاقة إحصاء واحدة كمثال (طبقها على البقية) --}}
    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center space-x-4 rtl:space-x-reverse transition-colors duration-300">
        <div class="p-4 bg-blue-600/10 rounded-xl text-blue-600 dark:text-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_products'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">إجمالي المنتجات</p>
        </div>
    </div>

    {{-- مستودعات --}}
    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center space-x-4 rtl:space-x-reverse transition-colors duration-300">
        <div class="p-4 bg-emerald-600/10 rounded-xl text-emerald-600 dark:text-emerald-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['warehouses'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">المستودعات</p>
        </div>
    </div>

    {{-- مخزون منخفض --}}
    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center space-x-4 rtl:space-x-reverse transition-colors duration-300">
        <div class="p-4 bg-amber-600/10 rounded-xl text-amber-600 dark:text-amber-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['low_stock'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">مخزون منخفض</p>
        </div>
    </div>

    {{-- نفذت الكمية --}}
    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center space-x-4 rtl:space-x-reverse transition-colors duration-300">
        <div class="p-4 bg-rose-600/10 rounded-xl text-rose-600 dark:text-rose-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['out_of_stock'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">نفذت الكمية</p>
        </div>
    </div>
</section>

<div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm dark:shadow-xl mb-8 transition-colors duration-300">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative">
                <input type="text" id="searchInput" placeholder="ابحث باسم المنتج أو الباركود..." 
                    class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 pr-10 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            
            <select id="warehouseSelect" class="bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none appearance-none">
                <option value="">جميع المخازن</option>
                @foreach($warehouses as $wh)
                    <option value="{{ $wh->id }}" {{ request('warehouse_id') == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
                @endforeach
            </select>
        </div>
        
        <a href="{{ route('products.create') }}" class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            منتج جديد
        </a>
    </div>
</div>

<div class="bg-white dark:bg-[#0f172a] rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm dark:shadow-xl overflow-hidden transition-colors duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-[#020617] text-gray-500 dark:text-gray-400 text-sm uppercase">
                    <th class="px-6 py-4 font-semibold text-center">الصورة</th>
                    <th class="px-6 py-4 font-semibold">المنتج</th>
                    <th class="px-6 py-4 font-semibold text-center">الباركود</th>
                    <th class="px-6 py-4 font-semibold text-center">القسم</th>
                    <th class="px-6 py-4 font-semibold text-center">المخزن</th>
                    <th class="px-6 py-4 font-semibold text-center">الكمية الحالية</th>
                    <th class="px-6 py-4 font-semibold text-center">سعر البيع</th>
                    <th class="px-6 py-4 font-semibold text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody id="productsTableBody" class="divide-y divide-gray-100 dark:divide-gray-800/50">
                @include('admin.stores.products_table')
            </tbody>
        </table>
    </div>
    
    <div class="p-6 border-t border-gray-100 dark:border-gray-800 text-center">
        <button id="loadMoreBtn" data-page="2" class="bg-gray-50 dark:bg-[#020617] hover:bg-gray-100 dark:hover:bg-gray-800 text-blue-600 dark:text-blue-400 px-8 py-2 rounded-lg border border-gray-200 dark:border-gray-700 transition font-medium">
            عرض المزيد من المنتجات
        </button>
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
