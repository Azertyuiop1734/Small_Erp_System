@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Point of Sale (Warehouse: {{ Auth::user()->warehouse->name ?? 'Not specified' }})</h5>
                    <div id="clock" class="small"></div>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-primary text-white"><i class="fas fa-barcode"></i></span>
                        <input type="text" id="barcode-input" class="form-control form-control-lg"
                            placeholder="Scan the barcode or enter it manually..." autofocus>
                    </div>

                    <div class="table-responsive" style="max-height: 450px;">
                        <table class="table table-hover align-middle border">
                            <thead class="table-light">
                                <tr>
                                    <th width="70">Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th width="120">Quantity</th>
                                    <th>Total</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody id="pos-items">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-3 border-info">
                <div class="card-body">
                    <label class="form-label fw-bold"><i class="fas fa-user"></i> Select Customer (Optional)</label>
                    <div class="position-relative">
                        <input type="text" id="customer-search" class="form-control" placeholder="Search by customer name...">
                        <div id="customer-results" class="list-group position-absolute w-100 shadow-lg" style="z-index: 1050;"></div>
                    </div>
                    <div id="selected-customer-display" class="mt-2 p-2 border rounded bg-light d-none">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong id="display-name"></strong>
                                <div class="small text-danger">Customer Discount: <span id="display-discount">0</span>%</div>
                            </div>
                            <button class="btn btn-sm btn-outline-danger" onclick="clearCustomer()">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <h4 class="text-center mb-4">Invoice Summary</h4>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Items:</span>
                        <span id="items-count" class="badge bg-secondary">0</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal (Before Discount):</span>
                        <span><span id="subtotal">0.00</span> DA</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-danger">
                        <span>Discount Value:</span>
                        <span>- <span id="discount-val">0.00</span> DA</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-bold">Grand Total:</h5>
                        <h5 class="text-primary fw-bold"><span id="grand-total">0.00</span> DA</h5>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Paid Amount:</label>
                        <input type="number" id="paid-amount" class="form-control form-control-lg border-success text-success fw-bold" step="0.01">
                    </div>

                    <button id="complete-sale" class="btn btn-success btn-lg w-100 py-3 shadow">
                        <i class="fas fa-check-circle"></i> Complete Sale (alt + s)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let cart = [];
    let selectedCustomer = null;

    // --- 1. إدارة الزبائن ---

    // البحث عن زبون
    document.getElementById('customer-search').addEventListener('input', function() {
        let term = this.value.trim();
        if (term.length < 2) {
            document.getElementById('customer-results').innerHTML = '';
            return;
        }

        fetch(`{{ url('/customers/search') }}?term=${term}`)
            .then(res => res.json())
            .then(data => {
                let html = '';
                data.forEach(c => {
                    html += `<button type="button" class="list-group-item list-group-item-action" 
                            onclick="selectCustomer(${c.id}, '${c.name}', ${c.discount})">
                            ${c.name} <span class="badge bg-info float-end">${c.discount}% خصم</span>
                         </button>`;
                });
                document.getElementById('customer-results').innerHTML = html;
            });
    });

    function selectCustomer(id, name, discount) {
        selectedCustomer = {
            id,
            name,
            discount
        };
        document.getElementById('customer-search').value = '';
        document.getElementById('customer-results').innerHTML = '';

        // تحديث الواجهة
        document.getElementById('display-name').textContent = name;
        document.getElementById('display-discount').textContent = discount;
        document.getElementById('selected-customer-display').classList.remove('d-none');
        document.getElementById('customer-search').classList.add('d-none');

        renderCart(); // إعادة الحساب لتطبيق الخصم
    }

    function clearCustomer() {
        selectedCustomer = null;
        document.getElementById('selected-customer-display').classList.add('d-none');
        document.getElementById('customer-search').classList.remove('d-none');
        renderCart();
    }

    // --- 2. إدارة السلة والمنتجات ---

    document.getElementById('barcode-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            let barcode = this.value.trim();
            if (!barcode) return;
            fetchProduct(barcode);
            this.value = '';
        }
    });

    function fetchProduct(barcode) {
        fetch(`{{ url('/product') }}/${barcode}`)
            .then(res => {
                if (!res.ok) throw new Error('The product is not in your warehouse');
                return res.json();
            })
            .then(product => addToCart(product))
            .catch(err => alert(err.message));
    }

    function addToCart(product) {
        let index = cart.findIndex(i => i.id === product.id);
        if (index !== -1) {
            if (cart[index].quantity < product.available_qty) {
                cart[index].quantity++;
            } else {
                alert('The quantity requested exceeds what is available in the warehouse!');
            }
        } else {
            cart.push({
                ...product,
                quantity: 1
            });
        }
        renderCart();
    }

    function renderCart() {
        let tbody = document.getElementById('pos-items');
        tbody.innerHTML = '';
        let subtotal = 0;

        cart.forEach((item, index) => {
            let rowTotal = item.price * item.quantity;
            subtotal += rowTotal;

            let imgUrl = item.image ? item.image : `{{ asset('images/no-image.png') }}`;

            tbody.innerHTML += `
        <tr>
            <td>
                <img src="${imgUrl}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
            </td>
            <td><strong>${item.name}</strong></td>
            <td>
                <input type="number" class="form-control form-control-sm text-center fw-bold" 
                       value="${item.price}" onchange="updatePrice(${index}, this.value)" step="0.01" style="width: 100px;">
            </td>
            <td>
                <input type="number" class="form-control form-control-sm text-center" 
                       value="${item.quantity}" onchange="updateQty(${index}, this.value)" min="1">
            </td>
            <td class="fw-bold text-primary">${rowTotal.toFixed(2)}</td>
            <td>
                <button class="btn btn-link text-danger p-0" onclick="removeItem(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>`;
        });
        // ... باقي الكود الخاص بالحسابات


        // الحسابات مع الخصم
        let discountPercent = selectedCustomer ? selectedCustomer.discount : 0;
        let discountVal = subtotal * (discountPercent / 100);
        let grandTotal = subtotal - discountVal;

        document.getElementById('items-count').textContent = cart.length;
        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('discount-val').textContent = discountVal.toFixed(2);
        document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
        document.getElementById('paid-amount').value = grandTotal.toFixed(2);
    }

    function updateQty(index, val) {
        let qty = parseInt(val) || 1;
        cart[index].quantity = qty;
        renderCart();
    }

    function updatePrice(index, val) {
        let newPrice = parseFloat(val);

        // التأكد من أن السعر المدخل رقم صحيح وليس سالباً
        if (isNaN(newPrice) || newPrice < 0) {
            alert('Please enter a correct price');
            renderCart(); // لإعادة السعر القديم في الواجهة
            return;
        }

        cart[index].price = newPrice;
        renderCart(); // إعادة حساب الإجماليات
    }

    function removeItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    // --- 3. إتمام البيع ---

    document.getElementById('complete-sale').addEventListener('click', function() {
        if (cart.length === 0) return alert('The basket is empty');

        // الحسابات
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.price * item.quantity;
        });

        let discountPercent = selectedCustomer ? selectedCustomer.discount : 0;
        let discountAmount = subtotal * (discountPercent / 100);

        // المبلغ الصافي الذي سيتم تخزينه في total_amount
        let finalTotal = subtotal - discountAmount;
        let paid = parseFloat(document.getElementById('paid-amount').value);

        let data = {
            items: cart,
            customer_id: selectedCustomer ? selectedCustomer.id : null,
            total: finalTotal, // إرسال السعر بعد الخصم ليناسب قاعدة البيانات الحالية
            paid: paid
        };

        fetch('{{ url("/pos/add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            // داخل جزء الـ fetch بعد نجاح الحفظ
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    // فتح نافذة الطباعة في صفحة جديدة
                    let printUrl = `{{ url('/pos/print') }}/${res.sale_id}`; // تأكد أن الـ Controller يرسل sale_id
                    window.open(printUrl, '_blank', 'width=600,height=700');

                    // إعادة تحميل الصفحة الأصلية لتصفير السلة
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    alert('False : ' + res.message);
                }
            })
            .catch(err => alert('Failed to connect to the server'));
    });

    // اختصار F2 لإتمام البيع
    window.addEventListener('keydown', function(e) {
        if (e.altKey && (e.key === 's' || e.key === 'S')) {
        e.preventDefault(); // يمنع أي سلوك افتراضي
        document.getElementById('complete-sale').click(); // تنفيذ الحفظ
    }

    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection