@php
    
$isWarehouseActive = request()->routeIs('stores.*') || request()->routeIs('products.index') || request()->routeIs('products.create');
$isSupplierActive = request()->routeIs('suppliers.*');
$isEmployeeActive = request()->routeIs('reports.*')|| request()->routeIs('attendance.*')||request()->routeIs('users.*');
$isPurchasesActive = request()->routeIs('purchases.*'); 
$isExpensesActive = request()->routeIs('expenses.*');
$isCustomersActive = request()->routeIs('customers.*');
$isStatisticsActive = request()->routeIs('finance.dashboard') || request()->routeIs('invoice.dashboard')||request()->routeIs('late.payers')||request()->routeIs('products.analysis')||request()->routeIs('customers1')||request()->routeIs('general.sales'); 
@endphp
<aside id="sidebar" class="fixed right-0 top-0 h-screen w-72 bg-gradient-to-b from-white to-[#78c4ef] dark:bg-gradient-to-b dark:from-[#020617] dark:to-[#224189] border-l border-gray-100 dark:border-gray-800 transition-all duration-300 z-[60] flex flex-col">
         <div class="p-5 border-b  border-gray-100 dark:border-gray-800 flex items-center gap-3 logo-container">
     
             <div class="relative p-2 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg shadow-lg shadow-blue-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="flex flex-col text-right">
                <span class="text-sm font-bold tracking-widest uppercase">Pos System</span>
                <span class="text-[10px] text-gray-500 uppercase">Management</span>
            </div>
        </div>
  <div class="flex-1 overflow-y-auto overflow-x-hidden p-4 space-y-4 custom-scrollbar">
   <a href="{{ route('admin.dashboard') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('admin.dashboard') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    
    <svg class="w-5 h-5 min-w-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
    </svg>

    <span class="sidebar-text font-medium whitespace-nowrap">Admin dashboard</span>
</a>
<a href="{{ route('profile') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('profile') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    
    <svg class="w-5 h-5 min-w-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
    </svg>

    <span class="sidebar-text font-medium whitespace-nowrap">My profile</span>
</a>

<div class="space-y-1">
    <button id="CustomersBtn" 
        class="w-full flex items-center justify-between p-3 transition rounded-xl 
        {{ $isCustomersActive ? 'bg-blue-600/10 text-blue-400 border border-blue-600/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
</svg>
            <span class="sidebar-text text-sm font-medium">Customers</span>
        </div>

        <svg id="CustomersArrow" 
             class=" w-4 h-4 transition-transform duration-200 {{ $isCustomersActive ? 'rotate-180' : '' }}" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <div id="CustomersMenu" 
         class="overflow-hidden transition-all duration-300 pr-4 space-y-1"
         style="max-height: {{ $isCustomersActive ? '500px' : '0px' }};">
        
        {{-- رابط إضافة زبون--}}
        <a href="{{ route('customers.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('customers.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7.5v9m-4.5-4.5h9M3 20.25a.75.75 0 01.75-.75h2.25a.75.75 0 01.75.75v.75H3v-.75zM10.5 10.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM3.75 18a4.5 4.5 0 019 0v1.5h-9V18z" />
</svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Add costumer</span>
        </a>

        {{-- رابط عرض الزبائن--}}
        <a href="{{ route('customers.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('customers.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
       <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
</svg>

            <span class="sidebar-text font-medium whitespace-nowrap">Customers Info</span>
        </a>
    </div>
</div>
<div class="space-y-1">
    <button id="supplierBtn" 
        class="w-full flex items-center justify-between p-3 transition rounded-xl 
        {{ $isSupplierActive ? 'bg-blue-600/10 text-blue-400 border border-blue-600/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text text-sm font-medium">Supplier Management</span>
        </div>

        <svg id="supplierArrow" 
             class=" w-4 h-4 transition-transform duration-200 {{ $isSupplierActive ? 'rotate-180' : '' }}" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <div id="supplierMenu" 
         class="overflow-hidden transition-all duration-300 pr-4 space-y-1"
         style="max-height: {{ $isSupplierActive ? '500px' : '0px' }};">
        
        {{-- رابط إضافة مورد --}}
        <a href="{{ route('suppliers.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('suppliers.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Add Supplier</span>
        </a>

        {{-- رابط عرض الموردين --}}
        <a href="{{ route('suppliers.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('suppliers.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Supplier Info</span>
        </a>
    </div>
</div>
<div class="space-y-1">
    <button id="warehouseBtn" 
        class="w-full flex items-center justify-between p-3 transition rounded-xl 
        {{ $isWarehouseActive ? 'bg-blue-600/10 text-blue-400 border border-blue-600/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text text-sm font-medium">Warehouse Management</span>
        </div>
        <svg id="warehouseArrow" 
             class="w-4 h-4 transition-transform duration-200 {{ $isWarehouseActive ? 'rotate-180' : '' }}" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <div id="warehouseMenu" 
         class="overflow-hidden transition-all duration-300 pr-4 space-y-1"
         style="max-height: {{ $isWarehouseActive ? '500px' : '0px' }};">
        
        <a href="{{ route('stores.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('stores.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-9-4.74c0-.899.513-1.716 1.309-2.113l8-4a2 2 0 011.382 0l8 4A2 2 0 0121 7.26v9.48a2 2 0 01-1.309 2.113l-8 4a2 2 0 01-1.382 0l-8-4A2 2 0 013 16.74V7.26z" stroke-width="2"/>
            </svg>
                        <span class="sidebar-text font-medium whitespace-nowrap">Add Warehouse</span>

        </a>

                <a href="{{ route('stores.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('stores.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
          <svg  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
</svg>

                        <span class="sidebar-text font-medium whitespace-nowrap">Warehouse info</span>

        </a>

        <a href="{{ route('products.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('products.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
               <span class="sidebar-text font-medium whitespace-nowrap">Add Products</span>

        </a>
        <a href="{{ route('products.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('products.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
                     <span class="sidebar-text font-medium whitespace-nowrap">   Browse All Products</span>

        </a>
        </div>
</div>



<div class="space-y-1">
    {{-- زر القائمة الرئيسي --}}
    <button id="employeeBtn" 
        class="w-full flex items-center justify-between p-3 transition rounded-xl 
        {{ $isEmployeeActive ? 'bg-blue-600/10 text-blue-400 border border-blue-600/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text text-sm font-medium">Employee Management</span>
        </div>

        <svg id="employeeArrow" 
             class="w-4 h-4 transition-transform duration-200 {{ $isEmployeeActive ? 'rotate-180' : '' }}" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    {{-- القائمة الفرعية --}}
    <div id="employeeMenu" 
         class="overflow-hidden transition-all duration-300 pr-4 space-y-1"
         style="max-height: {{ $isEmployeeActive ? '600px' : '0px' }};">
        
        {{-- إضافة موظف --}}
        <a href="{{ route('users.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('users.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Add Employee</span>
        </a>

        {{-- تقارير الموظفين --}}
        <a href="{{ route('reports.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('reports.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Employee Reports</span>
        </a>

        {{-- معلومات الموظفين --}}
        <a href="{{ route('users.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('users.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Employee Info</span>
        </a>

        {{-- جدول الحضور --}}
        <a href="{{ route('attendance.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('attendance.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Attendance Schedule</span>
        </a>
    </div>
</div>


<div class="space-y-1">
    {{-- زر المصاريف الرئيسي --}}
    <button id="expensesBtn" 
        class="w-full flex items-center justify-between p-3 transition rounded-xl 
        {{ $isExpensesActive ? 'bg-blue-600/10 text-blue-400 border border-blue-600/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        
        <div class="flex items-center gap-3">
            {{-- تغيير الأيقونة لتناسب المصاريف (Banknotes icon) --}}
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text text-sm font-medium">Expenses</span>
        </div>

        <svg id="expensesArrow" 
             class="w-4 h-4 transition-transform duration-200 {{ $isExpensesActive ? 'rotate-180' : '' }}" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    {{-- القائمة الفرعية للمصاريف --}}
    <div id="expensesMenu" 
         class="overflow-hidden transition-all duration-300 pr-4 space-y-1"
         style="max-height: {{ $isExpensesActive ? '500px' : '0px' }};">
              {{-- إضافة مصاريف --}}
        <a href="{{ route('expenses.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('expenses.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">New Expenses</span>
        </a>
        {{-- قائمة المصاريف --}}
        <a href="{{ route('expenses.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('expenses.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Expenses List</span>
        </a>

  
    </div>
</div>

<div class="space-y-1">
    {{-- زر المشتريات الرئيسي --}}
    <button id="purchasesBtn" 
        class="w-full flex items-center justify-between p-3 transition rounded-xl 
        {{ $isPurchasesActive ? 'bg-blue-600/10 text-blue-400 border border-blue-600/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text text-sm font-medium">Invoices</span>
        </div>

        <svg id="purchasesArrow" 
             class="w-4 h-4 transition-transform duration-200 {{ $isPurchasesActive ? 'rotate-180' : '' }}" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    {{-- القائمة الفرعية للمشتريات --}}
    <div id="purchasesMenu" 
         class="overflow-hidden transition-all duration-300 pr-4 space-y-1"
         style="max-height: {{ $isPurchasesActive ? '500px' : '0px' }};">
            {{-- فاتورة جديدة --}}
        <a href="{{ route('purchases.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('purchases.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">New Invoice</span>
        </a>
        {{-- قائمة الفواتير --}}
        <a href="{{ route('purchases.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('purchases.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Invoice List</span>
        </a>

    
    </div>
</div>


<div class="space-y-1">
    {{-- تصحيح المعرف (ID) ليطابق الجافا سكريبت --}}
    <button id="statisticsBtn" 
        class="w-full flex items-center justify-between p-3 transition rounded-xl 
        {{ $isStatisticsActive ? 'bg-blue-600/10 text-blue-400 border border-blue-600/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text text-sm font-medium">Statistics</span>
        </div>

        <svg id="statisticsArrow" 
             class="w-4 h-4 transition-transform duration-200 {{ $isStatisticsActive ? 'rotate-180' : '' }}" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <div id="statisticsMenu" 
         class="overflow-hidden transition-all duration-300 pr-4 space-y-1"
         style="max-height: {{ $isStatisticsActive ? '500px' : '0px' }};">
        
        <a href="{{ route('finance.dashboard') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('finance.dashboard') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Sales Statistics</span>
        </a>

        <a href="{{ route('invoice.dashboard') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('invoice.dashboard') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 17v-2m3 2v-4m3 2v-6m10 10V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sidebar-text font-medium whitespace-nowrap">Invoice Statistics</span>
        </a>

        <a href="{{ route('late.payers') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('late.payers') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span class="sidebar-text font-medium whitespace-nowrap">Late payers</span>
</a>

<a href="{{ route('products.analysis') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('products.analysis') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
    <span class="sidebar-text font-medium whitespace-nowrap">Products analysis</span>
</a>
<a href="{{ route('customers1') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('customers1') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
    </svg>
    <span class="sidebar-text font-medium whitespace-nowrap">Customers statistics</span>
</a>

<a href="{{ route('general.sales') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('general.sales') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
    </svg>
    <span class="sidebar-text font-medium whitespace-nowrap">General sales</span>
</a>

         
    </div>
    <form action="{{ route('logout') }}" method="POST" class="pt-10">
    @csrf
    <button type="submit" class="w-full flex items-center gap-3 p-3 text-sm transition rounded-xl text-red-500 hover:bg-red-50 hover:text-red-600 font-medium">
        <svg class="w-5 h-5 min-w-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 15l3-3m0 0l-3-3m3 3H9"/>
        </svg>
        <span class="sidebar-text font-medium whitespace-nowrap">Log out</span>
    </button>
</form>

</div>
  
</div>

    </aside>