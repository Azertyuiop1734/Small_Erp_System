@php
    
$isWarehouseActive = request()->routeIs('stores.*') || request()->routeIs('products.index') || request()->routeIs('products.create');
$isSupplierActive = request()->routeIs('suppliers.*');
$isEmployeeActive = request()->routeIs('reports.*')|| request()->routeIs('attendance.*')||request()->routeIs('users.*');
$isPurchasesActive = request()->routeIs('purchases.*'); 
$isExpensesActive = request()->routeIs('expenses.*');
$isCustomersActive = request()->routeIs('customers.*')||request()->routeIs('customers1');
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
   <a href="{{ route('worker.dashboard') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('worker.dashboard') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    
    <svg class="w-5 h-5 min-w-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
    </svg>

    <span class="sidebar-text font-medium whitespace-nowrap">Worker dashboard</span>
</a>
<a href="{{ route('profile') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('profile') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    
    <svg class="w-5 h-5 min-w-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
    </svg>

    <span class="sidebar-text font-medium whitespace-nowrap">My profile</span>
</a>
 <a href="{{ route('pos.index') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('pos.index') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    
    <svg class="w-5 h-5 min-w-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <rect x="3" y="3" width="18" height="14" rx="2"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 17v4"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 11h5"/>
        <circle cx="17" cy="16" r="1" fill="currentColor"/>
    </svg>

    <span class="sidebar-text font-medium whitespace-nowrap"> Pos system</span>
</a>

<a href="{{ route('reports.create') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('reports.create') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    
    <svg class="w-5 h-5 min-w-[20px]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 19V9a2 2 0 012-2h2a2 2 0 012 2v10"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 19v-4"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15v-8"/>
        <circle cx="17" cy="5" r="2" fill="currentColor"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 7v2"/>
    </svg>

    <span class="sidebar-text font-medium whitespace-nowrap">Create report</span>
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

        <a href="{{ route('customers1') }}" 
   class="flex items-center gap-3 p-3 text-sm transition rounded-xl
   {{ request()->routeIs('customers1') ? 'bg-blue-400 text-black border border-white' : 'text-gray-500 hover:text-blue-400' }}">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
    </svg>
    <span class="sidebar-text font-medium whitespace-nowrap">Customers statistics</span>
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
        
  
    </div>
</div>




         
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