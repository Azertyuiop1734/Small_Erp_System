<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة منتج جديد</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .image-preview { width: 150px; height: 150px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-top: 10px; border-radius: 10px; }
        .image-preview img { width: 100%; height: auto; display: none; }
    </style>
</head>
<body class="bg-light p-4">

<div class="container bg-white p-4 rounded shadow-sm">
    <h2 class="mb-4">إضافة منتج جديد للمخزون</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">اسم المنتج</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">الباركود (Barcode)</label>
                <input type="text" name="barcode" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">الحد الأدنى للمخزون</label>
                <input type="number" name="minimum_stock" class="form-control" value="5">
            </div>
<div class="col-md-4 mb-3">
    <label class="form-label">الكمية المتوفرة حالياً</label>
    <input type="number" name="initial_quantity" class="form-control" value="0" min="0" required>
</div>
            <div class="col-md-4 mb-3">
                <label class="form-label">القسم (Category)</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- اختر القسم --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">المورد (Supplier)</label>
                <select name="supplier_id" class="form-select" required>
                    <option value="">-- اختر المورد --</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">المخزن الأساسي</label>
                <select name="warehouse_id" class="form-select" required>
                    <option value="">-- اختر المخزن --</option>
                    @foreach($warehouses as $wh)
                        <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">سعر الشراء</label>
                <input type="number" step="0.01" name="purchase_price" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">سعر البيع</label>
                <input type="number" step="0.01" name="selling_price" class="form-control" required>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">صورة المنتج</label>
                <input type="file" name="image" class="form-control" id="imgInput" accept="image/*">
                <div class="image-preview" id="previewContainer">
                    <span class="text-muted" id="previewText">معاينة الصورة</span>
                    <img src="" id="previewImg">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">حفظ المنتج</button>
    </form>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // معاينة الصورة قبل الرفع
    const imgInput = document.getElementById('imgInput');
    const previewImg = document.getElementById('previewImg');
    const previewText = document.getElementById('previewText');

    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            previewImg.src = URL.createObjectURL(file);
            previewImg.style.display = 'block';
            previewText.style.display = 'none';
        }
    }

    // تنبيه النجاح
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'تمت الإضافة!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#0d6efd'
        });
    @endif
    @if(session('error_message'))
    Swal.fire({
        icon: 'error',
        title: 'عذراً.. حدث خطأ في قاعدة البيانات',
        text: "{{ session('error_message') }}",
        confirmButtonColor: '#d33'
    });
@endif
</script>

</body>
</html>