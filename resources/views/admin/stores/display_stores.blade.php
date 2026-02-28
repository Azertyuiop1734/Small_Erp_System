<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قائمة المخازن</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light p-5">

<div class="container shadow-sm p-4 bg-white rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إدارة المخازن والمستودعات</h2>
        <a href="{{ route('stores.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة مخزن جديد
        </a>
    </div>

    <table class="table table-hover table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>اسم المخزن</th>
                <th>الموقع / العنوان</th>
                <th>تاريخ الإنشاء</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stores as $store)
                <tr>
                    <td>{{ $store->id }}</td>
                    <td class="fw-bold">{{ $store->name }}</td>
                    <td>{{ $store->location ?? 'غير محدد' }}</td>
                    <td>{{ date('Y-m-d', strtotime($store->created_at)) }}</td>
                    <td>
                        <form action="{{ route('stores.destroy', $store->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm btn-delete">
                                <i class="fas fa-trash-alt"></i> حذف
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-muted p-4">لا توجد مخازن مسجلة حالياً.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // تنبيهات النجاح
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'تمت العملية',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    // تأكيد الحذف
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف هذا المخزن نهائياً من النظام!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذفه',
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