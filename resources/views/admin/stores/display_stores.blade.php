<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قائمة المخازن</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #0f172a; color: #94a3b8; }
        .glass-card { background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.05); }
        .gradient-btn { background: linear-gradient(90deg, #2563eb, #0891b2); }
        .table {
            border-collapse: separate; /* ضروري جداً للسماح بظهور الحواف الدائرية */
            border-spacing: 0;
            background: transparent !important;
            color: #94a3b8 !important;
        }
        .table thead tr th:first-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
        }
        .table thead tr th:last-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
        }
        .gradient-btn th {
            background: transparent !important;
            border: none !important;
            color: white !important;
            padding: 12px;
        }
        .form-input { 
            background-color: #0f172a;
            border: 1px solid #1e293b;
            color: white;
        }
        
        .table tbody td {
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important; /* خط نحيف جداً يفصل الصفوف */
        color: #cbd5e1 !important; /* لون نص أوضح قليلاً للقراءة */
        vertical-align: middle;
        padding: 15px 10px;
       }
       .table-hover tbody tr:hover td {
        background: rgba(255, 255, 255, 0.03) !important; /* إضاءة خفيفة جداً عند التأشير */
        color: #fff !important;
    }
    .table > :not(caption) > * > * {
        background-color: transparent !important;
        box-shadow: none !important;
    }
    .btn-delete {
        border-radius: 8px;
        padding: 5px 12px;
        font-size: 0.85rem;
        background-color: rgba(220, 38, 38, 0.2); /* أحمر شفاف */
        border: 1px solid rgba(220, 38, 38, 0.5);
        color: #fca5a5;
        transition: all 0.3s;
    }
    .btn-delete:hover {
        background-color: #dc2626; /* أحمر كامل عند الحصر */
        color: white;
    }
        
    </style>
</head>
<body class="p-5">

<div class="container shadow-sm p-4 glass-card rounded">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white">
            <i class="fas fa-warehouse ml-2 text-info"></i>
              إدارة المخازن والمستودعات
       </h2>
        <a href="{{ route('stores.create') }}" class="btn gradient-btn">
            <i class="fas fa-plus "></i> إضافة مخزن جديد
        </a>
    </div>

    <table class="table table-hover text-center">
        <thead class="gradient-btn">
            <tr>
                <th><i class="fas fa-list-ol ml-1"></i></th>
                <th><i class="fas fa-warehouse ml-1"></i>اسم المخزن</th>
                <th><i class="fas fa-map-marker-alt ml-1"></i>الموقع / العنوان</th>
                <th><i class="fas fa-calendar-alt ml-1"></i>تاريخ الإنشاء</th>
                <th><i class="fas fa-tools ml-1"></i>الإجراءات</th>
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
                    <td colspan="5" class="py-5 text-white" style="background: transparent;">
                    <i class="fas fa-box-open fa-3x mb-3 d-block opacity-50"></i>
                         لا توجد مخازن مسجلة حالياً.
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</main>

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