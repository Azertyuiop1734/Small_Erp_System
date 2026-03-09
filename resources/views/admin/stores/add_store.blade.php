<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة مخزن جديد</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="bg-light p-5">

<div class="container shadow-sm p-4 bg-white rounded" style="max-width: 600px;">
    <h2 class="mb-4 text-primary">إضافة مخزن/مستودع جديد</h2>

    <form action="{{ route('stores.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-bold">اسم المخزن</label>
            <input type="text" name="name" class="form-control"  required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">موقع المخزن (العنوان)</label>
            <textarea name="location" class="form-control" rows="3" ></textarea>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">حفظ بيانات المخزن</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            title: 'تم الحفظ!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'ممتاز',
            confirmButtonColor: '#0d6efd'
        });
    @endif
</script>

</body>
</html>