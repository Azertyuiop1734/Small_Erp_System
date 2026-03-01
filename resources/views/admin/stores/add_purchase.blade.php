<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مشتريات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 p-4">

    <div class="max-w-6xl mx-auto p-6 bg-white shadow-lg rounded-lg border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">إضافة فاتورة مشتريات جديدة</h2>

        <form action="{{ route('purchases.store') }}" method="POST" id="purchase-form">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">المورد</label>
                    <select name="supplier_id" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg">
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">المخزن المستلم</label>
                    <select name="warehouse_id" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg">
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الشراء</label>
                    <input type="date" name="purchase_date" class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="relative overflow-x-auto sm:rounded-lg mb-4">
                <table class="w-full text-sm text-right text-gray-500" id="products_table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-4 py-3">الباركود</th>
                            <th class="px-4 py-3">اسم المنتج</th>
                            <th class="px-4 py-3">الكمية</th>
                            <th class="px-4 py-3">سعر الشراء</th>
                            <th class="px-4 py-3 text-center">الإجمالي</th>
                            <th class="px-4 py-3 text-center">إجراء</th>
                        </tr>
                    </thead>
                    <tbody id="items-container">
                        <tr class="border-b bg-white item-row">
                            <td class="px-4 py-3">
                                <input type="text" name="items[0][barcode]" class="barcode-input w-full p-2 bg-blue-50 border border-blue-200 rounded focus:ring-2 focus:ring-blue-500" placeholder="امسح الباركود">
                                <input type="hidden" name="items[0][product_id]" class="product-id">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" class="product-name w-full p-2 bg-gray-100 border-none rounded" readonly placeholder="تلقائي">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="items[0][quantity]" class="qty w-full p-2 border border-gray-300 rounded" required min="1" value="1">
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="items[0][price]" step="0.01" class="price w-full p-2 border border-gray-300 rounded" required>
                            </td>
                            <td class="px-4 py-3 text-center font-bold line-total">0.00</td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" class="remove-row text-red-500 hover:text-red-700 font-bold">حذف</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" id="add-item" class="mb-8 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                + إضافة منتج آخر
            </button>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 bg-gray-50 rounded-xl">
                <div class="space-y-4 text-left order-2 md:order-1">
                    <div class="flex justify-between md:justify-end items-center md:gap-4">
                        <span class="text-gray-600 font-bold">إجمالي الفاتورة:</span>
                        <span class="text-2xl font-black text-blue-600" id="grand-total-display">0.00</span>
                        <input type="hidden" name="total_amount" id="grand-total-input">
                    </div>
                </div>

                <div class="space-y-4 order-1 md:order-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">المبلغ المدفوع</label>
                        <input type="number" name="paid_amount" id="paid_amount" class="w-full p-2.5 bg-white border border-gray-300 rounded-lg" value="0">
                    </div>
                    <div class="flex justify-between items-center text-red-600 font-bold">
                        <span>المبلغ المتبقي:</span>
                        <span id="remaining-amount-display">0.00</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="mt-8 w-full py-4 bg-blue-600 text-white text-xl font-bold rounded-xl hover:bg-blue-700 shadow-lg transition">
                حفظ الفاتورة وتحديث المخزون
            </button>
        </form>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
    let rowCount = 1;

    // --- 1. إضافة صف جديد ---
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const firstRow = document.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, `[${rowCount}]`);
            input.value = input.classList.contains('qty') ? 1 : '';
        });

        newRow.querySelector('.line-total').textContent = '0.00';
        container.appendChild(newRow);
        
        // تركيز الماوس تلقائياً على حقل الباركود في الصف الجديد
        newRow.querySelector('.barcode-input').focus();
        rowCount++;
    });

    // --- 2. البحث التلقائي بالباركود (بدون تحريك الماوس) ---
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('barcode-input')) {
            const barcode = e.target.value.trim();
            const row = e.target.closest('tr');

            // تنفيذ البحث فقط عندما يكون طول الباركود مناسباً (مثلاً 8 أرقام فأكثر)
            // هذا يمنع إرسال طلبات ناقصة أثناء الكتابة اليدوية
            if (barcode.length >= 8) { 
                const fetchUrl = `{{ url('purchases/get-product') }}/${barcode}`;

                fetch(fetchUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.product) {
                            row.querySelector('.product-id').value = data.product.id;
                            row.querySelector('.product-name').value = data.product.name;
                            // ملء السعر إذا كان متاحاً (بناءً على التعديلات الأخيرة في قاعدة البيانات)
                            row.querySelector('.price').value = data.product.last_purchase_price || 0;
                            
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            Toast.fire({ icon: 'success', title: 'تم جلب المنتج' });
                            
                            calculateTotals();
                            // الانتقال تلقائياً لحقل الكمية بعد نجاح مسح الباركود
                            row.querySelector('.qty').focus();
                        }
                    });
            }
        }
    });

    // --- 3. معالجة الحفظ بـ SweetAlert ---
    const purchaseForm = document.getElementById('purchase-form');
    purchaseForm.addEventListener('submit', function(e) {
        e.preventDefault(); // منع الإرسال الفوري

        Swal.fire({
            title: 'هل تريد حفظ الفاتورة؟',
            text: "سيتم تحديث كميات المخزون فوراً",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم، حفظ وتحديث',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                // إظهار نافذة تحميل أثناء المعالجة
                Swal.fire({
                    title: 'جاري الحفظ...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                
                // إرسال النموذج فعلياً
                purchaseForm.submit();
            }
        });
    });

    // --- 4. العمليات الحسابية ---
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('qty') || e.target.classList.contains('price') || e.target.id === 'paid_amount') {
            calculateTotals();
        }
    });

    function calculateTotals() {
        let grandTotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const lineTotal = qty * price;
            row.querySelector('.line-total').textContent = lineTotal.toFixed(2);
            grandTotal += lineTotal;
        });

        document.getElementById('grand-total-display').textContent = grandTotal.toFixed(2);
        document.getElementById('grand-total-input').value = grandTotal.toFixed(2);

        const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
        const remaining = grandTotal - paid;
        document.getElementById('remaining-amount-display').textContent = remaining.toFixed(2);
    }
});
    </script>
</body>
</html>