@extends('layouts.app')

@section('title', 'إضافة فاتورة مشتريات جديدة')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white dark:bg-[#0f172a] rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden transition-colors duration-300">
        
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">إنشاء فاتورة شراء</h2>
                <p class="text-blue-100 text-sm opacity-90">قم بتسجيل المنتجات الموردة وتحديث المخزون</p>
            </div>
            <div class="hidden md:block p-3 bg-white/10 rounded-2xl backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>

        <form action="{{ route('purchases.store') }}" method="POST" id="purchase-form" class="p-6 md:p-8 space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mr-1">المورد</label>
                    <select name="supplier_id" class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none appearance-none">
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mr-1">المخزن المستلم</label>
                    <select name="warehouse_id" class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none appearance-none">
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mr-1">تاريخ الفاتورة</label>
                    <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" 
                        class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none">
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-2">
                    <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-width="2"/></svg>
                        قائمة المنتجات
                    </h3>
                    <button type="button" id="add-row" class="text-sm bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg transition-all shadow-md shadow-emerald-500/20 font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2.5"/></svg>
                        إضافة منتج
                    </button>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-800">
                    <table class="w-full text-right" id="items-table">
                        <thead class="bg-gray-50 dark:bg-[#020617] text-gray-500 dark:text-gray-400 text-xs">
                            <tr>
                                <th class="px-4 py-3 min-w-[200px]">المنتج</th>
                                <th class="px-4 py-3">الكراتين</th>
                                <th class="px-4 py-3">وحدات/كرتون</th>
                                <th class="px-4 py-3">الكمية الكلية</th>
                                <th class="px-4 py-3">سعر الوحدة</th>
                                <th class="px-4 py-3 text-left">الإجمالي</th>
                                <th class="px-4 py-3 w-10"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            <tr class="item-row hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-4 py-3">
                                    <select name="items[0][product_id]" class="w-full bg-transparent text-gray-900 dark:text-white outline-none">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-3"><input type="number" name="items[0][boxes]" class="boxes-count w-20 bg-transparent border-b border-dashed border-gray-300 dark:border-gray-600 focus:border-blue-500 outline-none text-center dark:text-white" value="0"></td>
                                <td class="px-4 py-3"><input type="number" name="items[0][units_per_box]" class="units-per-box w-20 bg-transparent border-b border-dashed border-gray-300 dark:border-gray-600 focus:border-blue-500 outline-none text-center dark:text-white" value="0"></td>
                                <td class="px-4 py-3"><input type="number" name="items[0][qty]" class="qty w-20 bg-gray-100 dark:bg-gray-800 rounded px-2 py-1 outline-none text-center dark:text-white font-bold" value="0" readonly></td>
                                <td class="px-4 py-3"><input type="number" step="0.01" name="items[0][price]" class="price w-24 bg-transparent border-b border-dashed border-gray-300 dark:border-gray-600 focus:border-blue-500 outline-none text-center dark:text-white" value="0"></td>
                                <td class="px-4 py-3 text-left font-mono font-bold text-blue-600 dark:text-blue-400 line-total">0.00</td>
                                <td class="px-4 py-3"><button type="button" class="remove-row text-rose-500 opacity-50 hover:opacity-100 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2"/></svg></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-gray-100 dark:border-gray-800">
                <div class="bg-gray-50 dark:bg-[#020617] p-6 rounded-2xl space-y-4">
                    <h4 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="2"/></svg>
                        تفاصيل الدفع
                    </h4>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-500 dark:text-gray-400 mr-1">المبلغ المدفوع</label>
                        <input type="number" step="0.01" name="paid_amount" id="paid_amount" value="0"
                            class="w-full bg-white dark:bg-[#0f172a] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white font-bold focus:ring-2 focus:ring-emerald-500 transition outline-none">
                    </div>
                    <div class="flex justify-between p-3 bg-rose-50 dark:bg-rose-500/10 rounded-xl">
                        <span class="text-rose-600 dark:text-rose-400 font-bold">المتبقي كدين:</span>
                        <span class="font-mono font-bold text-rose-600 dark:text-rose-400" id="remaining-amount">0.00</span>
                    </div>
                </div>

                <div class="flex flex-col justify-center space-y-6">
                    <div class="text-left">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">إجمالي الفاتورة النهائي</span>
                        <div class="text-5xl font-black text-blue-600 dark:text-blue-400 font-mono mt-1">
                            <span id="grand-total-display">0.00</span>
                            <span class="text-sm">د.ج</span>
                        </div>
                        <input type="hidden" name="total_amount" id="grand-total-input" value="0">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold text-lg shadow-xl shadow-blue-600/20 transition-all transform hover:scale-[1.01] flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                        حفظ الفاتورة الآن
                    </button>
                </div>
            </div>
        </form>
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



    let rowIndex = 1;

    // إضافة سطر جديد
    document.getElementById('add-row').addEventListener('click', () => {
        const tbody = document.querySelector('#items-table tbody');
        const newRow = `
            <tr class="item-row hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors">
                <td class="px-4 py-3">
                    <select name="items[${rowIndex}][product_id]" class="w-full bg-transparent text-gray-900 dark:text-white outline-none">
                        @foreach($products as $product) <option value="{{ $product->id }}">{{ $product->name }}</option> @endforeach
                    </select>
                </td>
                <td class="px-4 py-3"><input type="number" name="items[${rowIndex}][boxes]" class="boxes-count w-20 bg-transparent border-b border-dashed border-gray-300 dark:border-gray-600 focus:border-blue-500 outline-none text-center dark:text-white" value="0"></td>
                <td class="px-4 py-3"><input type="number" name="items[${rowIndex}][units_per_box]" class="units-per-box w-20 bg-transparent border-b border-dashed border-gray-300 dark:border-gray-600 focus:border-blue-500 outline-none text-center dark:text-white" value="0"></td>
                <td class="px-4 py-3"><input type="number" name="items[${rowIndex}][qty]" class="qty w-20 bg-gray-100 dark:bg-gray-800 rounded px-2 py-1 outline-none text-center dark:text-white font-bold" value="0" readonly></td>
                <td class="px-4 py-3"><input type="number" step="0.01" name="items[${rowIndex}][price]" class="price w-24 bg-transparent border-b border-dashed border-gray-300 dark:border-gray-600 focus:border-blue-500 outline-none text-center dark:text-white" value="0"></td>
                <td class="px-4 py-3 text-left font-mono font-bold text-blue-600 dark:text-blue-400 line-total">0.00</td>
                <td class="px-4 py-3"><button type="button" class="remove-row text-rose-500 opacity-50 hover:opacity-100 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2"/></svg></button></td>
            </tr>`;
        tbody.insertAdjacentHTML('beforeend', newRow);
        rowIndex++;
    });

    // حذف سطر
    document.addEventListener('click', e => {
        if (e.target.closest('.remove-row')) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('.item-row').remove();
                calculateTotals();
            }
        }
    });

    // الحسابات التلقائية
    document.addEventListener('input', e => {
        const row = e.target.closest('.item-row');
        if (row) {
            const boxes = parseFloat(row.querySelector('.boxes-count').value) || 0;
            const units = parseFloat(row.querySelector('.units-per-box').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            
            const totalQty = boxes * units;
            row.querySelector('.qty').value = totalQty;
            row.querySelector('.line-total').textContent = (totalQty * price).toFixed(2);
            
            calculateTotals();
        }
        if (e.target.id === 'paid_amount') calculateTotals();
    });

    function calculateTotals() {
        let grandTotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            grandTotal += qty * price;
        });

        document.getElementById('grand-total-display').textContent = grandTotal.toFixed(2);
        document.getElementById('grand-total-input').value = grandTotal.toFixed(2);
        
        const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
        document.getElementById('remaining-amount').textContent = (grandTotal - paid).toFixed(2);
    }
</script>
@endpush