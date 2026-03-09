<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>قائمة المنتجات والمخزون</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="p-4">

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark fw-bold">📦 قائمة المنتجات والمخازن</h2>
            <a href="{{ route('products.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> إضافة منتج جديد</a>
        </div>

        <div class="card search-card mb-4">
            <div class="card-body">
                <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">البحث (اسم المنتج أو الباركود)</label>
                        <input type="text" id="searchInput" name="search_name" class="form-control" placeholder="مثال: آيفون أو 12345..." value="{{ request('search_name') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">تصفية حسب المخزن</label>
                        <select name="warehouse_id" id="warehouseSelect" class="form-select">
                            <option value="">جميع المخازن</option>
                            @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}" {{ request('warehouse_id') == $wh->id ? 'selected' : '' }}>
                                {{ $wh->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">

                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary"><i class="fas fa-undo"></i></a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card search-card text-center">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>الصورة</th>
                                <th>المنتج</th>
                                <th>الباركود</th>
                                <th>القسم</th>
                                <th>المخزن</th>
                                <th>الكمية الحالية</th>
                                <th>عدد الصناديق</th>
                               
                                <th>سعر البيع</th>
                                
                                <th>حدف </th>
                                <th>تعديل </th>
                            </tr>
                        </thead>
                        <tbody id="productsTableBody">
                            @include('admin.stores.products_table')
                        </tbody>
                    </table>
                    <div class="text-center my-3">
                        <button id="loadMoreBtn"
                            data-page="2"
                            class="btn btn-outline-primary">
                            ➕ مزيد
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("loadMoreBtn").addEventListener("click", function() {

            let button = this;
            let page = button.getAttribute("data-page");

            let searchValue = document.getElementById("searchInput").value;
            let warehouseValue = document.getElementById("warehouseSelect").value;

            fetch("{{ route('products.index') }}?page=" + page +
                    "&search_name=" + searchValue +
                    "&warehouse_id=" + warehouseValue, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                .then(response => response.text())
                .then(html => {

                    if (html.trim() === '') {
                        button.style.display = "none";
                        return;
                    }

                    document.getElementById("productsTableBody").insertAdjacentHTML("beforeend", html);

                    button.setAttribute("data-page", parseInt(page) + 1);
                });
        });
    </script>
    <script>
        // تنبيه النجاح بعد الحذف
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'تمت العملية',
            text: "{{ session('success') }}",
            confirmButtonColor: '#0d6efd'
        });
        @endif

        // تنبيه الخطأ
        @if(session('error_message'))
        Swal.fire({
            icon: 'error',
            title: 'خطأ!',
            text: "{{ session('error_message') }}",
        });
        @endif

        // دالة التأكيد التي كتبتها أنت (تأكد أنها تحت استدعاء مكتبة SweetAlert)
        function confirmDelete(id) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف المنتج نهائياً من كافة المخازن!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذفه!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('admin/products/delete') }}/" + id;
                }
            })
        }
    </script>
    <script>
        function liveSearch() {
            let searchValue = document.getElementById("searchInput").value;
            let warehouseValue = document.getElementById("warehouseSelect").value;

            fetch("{{ route('products.index') }}?search_name=" + searchValue + "&warehouse_id=" + warehouseValue)
                .then(response => response.text())
                .then(data => {
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(data, 'text/html');
                    document.querySelector("tbody").innerHTML =
                        doc.querySelector("tbody").innerHTML;
                });
        }

        document.getElementById("searchInput").addEventListener("keyup", liveSearch);
        document.getElementById("warehouseSelect").addEventListener("change", liveSearch);
    </script>
</body>

</html>