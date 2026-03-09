<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الأقسام</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="p-4 bg-light">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📁 الأقسام (Categories)</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> إضافة قسم جديد</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0 text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#ID</th>
                        <th>اسم القسم</th>
                        <th>الوصف</th>
                        <th>تاريخ الإضافة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td class="fw-bold">{{ $cat->category_name }}</td>
                        <td class="text-muted">{{ $cat->description ?? 'لا يوجد وصف' }}</td>
                        <td>{{ date('Y-m-d', strtotime($cat->created_at)) }}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $cat->id }})">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-muted">لا توجد أقسام مضافة حالياً</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "حذف القسم قد يؤثر على المنتجات المرتبطة به!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('admin/categories/delete') }}/" + id;
            }
        })
    }

    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'نجاح', text: "{{ session('success') }}" });
    @endif

    @if(session('error_message'))
        Swal.fire({ icon: 'error', title: 'تنبيه', text: "{{ session('error_message') }}" });
    @endif
</script>
</body>
</html>