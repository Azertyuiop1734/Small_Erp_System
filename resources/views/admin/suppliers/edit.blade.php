<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل بيانات المورد</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="bg-light p-5">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white p-3">
                    <h4 class="mb-0">✏️ تعديل بيانات المورد: {{ $supplier->name }}</h4>
                </div>
                <div class="card-body p-4">
                    <form id="editSupplierForm" action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">اسم المورد</label>
                                <input type="text" name="name" class="form-control" value="{{ $supplier->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">اسم الشركة</label>
                                <input type="text" name="company_name" class="form-control" value="{{ $supplier->company_name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">الهاتف</label>
                                <input type="text" name="phone" class="form-control" value="{{ $supplier->phone }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">الدين الحالي (د.ج)</label>
                                <input type="number" step="0.01" name="balance" class="form-control" value="{{ $supplier->balance }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold">العنوان</label>
                                <textarea name="address" class="form-control" rows="2">{{ $supplier->address }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="button" onclick="confirmUpdate()" class="btn btn-success px-4">حفظ التغييرات</button>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary px-4">إلغاء</a>
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
            title: 'تأكيد الحفظ',
            text: "هل تريد حفظ التعديلات الجديدة لهذا المورد؟",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'نعم، حفظ',
            cancelButtonText: 'تراجع'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('editSupplierForm').submit();
            }
        })
    }
</script>
</body>
</html>