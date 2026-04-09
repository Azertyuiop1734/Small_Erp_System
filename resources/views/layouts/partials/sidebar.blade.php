@php
    
$isWarehouseActive = request()->routeIs('stores.*') || request()->routeIs('products.*');
$isSupplierActive = request()->routeIs('suppliers.*');
$isEmployeeActive = request()->routeIs('reports.*')|| request()->routeIs('attendance.*')||request()->routeIs('users.*');
$isPurchasesActive = request()->routeIs('purchases.*'); 
$isExpensesActive = request()->routeIs('expenses.*');
@endphp
<aside id="sidebar" class="fixed right-0 top-0 h-screen w-72 bg-white dark:bg-[#020617] border-l border-gray-100 dark:border-gray-800 transition-all duration-300 z-[60] flex flex-col">
         <div class="p-5 border-b  border-gray-100 dark:border-gray-800 flex items-center gap-3">
     
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
<div class="space-y-1">
    <button id="supplierBtn" 
        class="w-full flex items-center justify-between p-3 transition rounded-xl 
        {{ $isSupplierActive ? 'bg-blue-600/10 text-blue-400 border border-blue-600/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
        
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-sm font-medium">Supplier Management</span>
        </div>

        <svg id="supplierArrow" 
             class="w-4 h-4 transition-transform duration-200 {{ $isSupplierActive ? 'rotate-180' : '' }}" 
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
            <span>Add Supplier</span>
        </a>

        {{-- رابط عرض الموردين --}}
        <a href="{{ route('suppliers.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('suppliers.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <span>Supplier Info</span>
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
            <span class="text-sm font-medium">Warehouse Management</span>
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
            Add Warehouse
        </a>
        <a href="{{ route('products.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('products.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Add Products
        </a>
        <a href="{{ route('products.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('products.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Browse All Products
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
            <span class="text-sm font-medium">Employee Management</span>
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
            <span>Add Employee</span>
        </a>

        {{-- تقارير الموظفين --}}
        <a href="{{ route('reports.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('reports.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Employee Reports</span>
        </a>

        {{-- معلومات الموظفين --}}
        <a href="{{ route('users.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('users.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Employee Info</span>
        </a>

        {{-- جدول الحضور --}}
        <a href="{{ route('attendance.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('attendance.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Attendance Schedule</span>
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
            <span class="text-sm font-medium">Expenses</span>
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
        
        {{-- قائمة المصاريف --}}
        <a href="{{ route('expenses.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('expenses.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Expenses List</span>
        </a>

        {{-- إضافة مصاريف --}}
        <a href="{{ route('expenses.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('expenses.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>New Expenses</span>
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
            <span class="text-sm font-medium">Purchases</span>
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
        
        {{-- قائمة الفواتير --}}
        <a href="{{ route('purchases.index') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('purchases.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Invoice List</span>
        </a>

        {{-- فاتورة جديدة --}}
        <a href="{{ route('purchases.create') }}" 
           class="flex items-center gap-3 p-3 text-sm transition rounded-xl
           {{ request()->routeIs('purchases.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>New Invoice</span>
        </a>
    </div>
</div>
            

           <a href="{{ route('finance.dashboard') }}" 
   class="flex items-center gap-3 p-3 transition rounded-xl
   {{ request()->routeIs('finance.dashboard') ? 'bg-blue-400 text-black border border-white' : 'text-gray-400 hover:text-white hover:bg-gray-800/50 hover:text-blue-400' }}">
    
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    
    <span class="text-sm font-medium">Sales Statistics</span>
</a>
</div>

    </aside>