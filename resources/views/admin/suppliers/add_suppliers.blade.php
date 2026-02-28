<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة مورد جديد</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="bg-light p-5">

<div class="container shadow-sm p-4 bg-white rounded">
    <h2 class="mb-4">إضافة مورد جديد</h2>

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">اسم المورد</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">اسم الشركة</label>
                <input type="text" name="company_name" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">الرصيد الافتتاحي</label>
                <input type="number" step="0.01" name="balance" class="form-control" value="0">
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">العنوان</label>
                <textarea name="address" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">حفظ البيانات</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // التحقق من وجود رسالة نجاح في الجلسة (Session)
    @if(session('success'))
        Swal.fire({
            title: 'تمت العملية!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'حسناً',
            confirmButtonColor: '#0d6efd', // لون الزر متناسق مع Bootstrap
            timer: 3000 // يختفي تلقائياً بعد 3 ثواني
        });
    @endif

    // يمكنك أيضاً إضافة تنبيه في حال وجود أخطاء في المدخلات
    @if($errors->any())
        Swal.fire({
            title: 'خطأ في البيانات!',
            html: '{!! implode("<br>", $errors->all()) !!}',
            icon: 'error',
            confirmButtonText: 'إغلاق',
            confirmButtonColor: '#dc3545'
        });
    @endif
</script>

</body>
</html>