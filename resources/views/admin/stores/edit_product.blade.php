<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل المنتج | {{ $product->name }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 15px; }
        .card-header { border-radius: 15px 15px 0 0 !important; }
        .form-control:focus, .form-select:focus { box-shadow: 0 0 0 0.25 margin-left: rgba(13, 110, 253, 0.1); border-color: #0d6efd; }
    </style>
</head>
<body class="p-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white p-3">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i> تعديل بيانات المنتج: {{ $product->name }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="editProductForm" action="{{ route('products.update', $product->id) }}" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">اسم المنتج</label>
                                    <input type="text" name="name" class="form-control form-control-lg" value="{{ $product->name }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">الباركود (غير قابل للتعديل)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-barcode"></i></span>
                                        <input type="text" class="form-control form-control-lg bg-light" value="{{ $product->barcode }}" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">القسم</label>
                                    <select name="category_id" class="form-select form-select-lg">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">المورد</label>
                                    <select name="supplier_id" class="form-select form-select-lg">
                                        @foreach($suppliers as $sup)
                                            <option value="{{ $sup->id }}" {{ $product->supplier_id == $sup->id ? 'selected' : '' }}>
                                                {{ $sup->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-danger">سعر الشراء</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="purchase_price" class="form-control form-control-lg text-center" value="{{ $product->purchase_price }}">
                                        <span class="input-group-text">د.ج</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-success">سعر البيع</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="selling_price" class="form-control form-control-lg text-center" value="{{ $product->selling_price }}">
                                        <span class="input-group-text">د.ج</span>
                                    </div>
                                </div>
                            </div>

                            <div class="hr mt-4 mb-4" style="border-top: 1px solid #eee;"></div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-4 border">إلغاء</a>
                                <button type="button" onclick="confirmUpdate()" class="btn btn-success btn-lg px-5">
                                    <i class="fas fa-save me-1"></i> حفظ التعديلات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdate() {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم تطبيق التعديلات الجديدة على هذا المنتج",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'نعم، قم بالحفظ',
                cancelButtonText: 'تراجع',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // الآن سيعمل هذا السطر لأننا أضفنا id="editProductForm" للفورم
                    document.getElementById('editProductForm').submit();
                }
            })
        }

        // معالجة أخطاء التحقق من لارافل
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'خطأ في البيانات المدخلة',
                html: '<div class="text-start">{!! implode("<br>", $errors->all()) !!}</div>',
                confirmButtonText: 'مفهوم'
            });
        @endif

        // معالجة رسالة الخطأ من الـ Controller
        @if(session('error_message'))
            Swal.fire({
                icon: 'error',
                title: 'فشل التحديث',
                text: "{{ session('error_message') }}",
            });
        @endif
    </script>
</body>
</html>