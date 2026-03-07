<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قائمة الموردين</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light p-5">

<div class="container shadow-sm p-4 bg-white rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>قائمة الموردين المسجلين</h2>
        <a href="{{ route('suppliers.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> إضافة مورد جديد
        </a>
    </div>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>اسم المورد</th>
                <th>الشركة</th>
                <th>الهاتف</th>
                <th>الدين (كمية المال الواجب تسديدها للمورد) </th>
                <th>العنوان</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->id }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->company_name ?? '-' }}</td>
                    <td>{{ $supplier->phone ?? '-' }}</td>
                    <td class="{{ $supplier->balance > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                        {{ number_format($supplier->balance, 2) }}
                    </td>
                    <td>{{ $supplier->address ?? '-' }}</td>
                   <td class="d-flex justify-content-center gap-2">
    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary">
        <i class="fas fa-edit"></i> تعديل
    </a>

    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger btn-delete">
            <i class="fas fa-trash"></i> حذف
        </button>
    </form>
</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">لا يوجد موردين مضافين حالياً.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // تنبيه النجاح بعد الحذف أو الإضافة
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'تمت العملية', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif

    // تأكيد الحذف باستخدام SweetAlert
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن تتمكن من تراجع عن هذا الحذف!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذفه!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

</body>
</html>