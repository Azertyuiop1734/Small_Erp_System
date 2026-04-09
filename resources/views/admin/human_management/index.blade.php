@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 glass-panel p-6 rounded-3xl shadow-xl gap-4">
        <div class="flex items-center gap-4 text-right">
            <div class="p-3 bg-blue-600 rounded-2xl shadow-lg shadow-blue-600/20">
                <i class="fas fa-users-cog text-white text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-gray-800 dark:text-white transition-colors tracking-tight">إدارة الموظفين</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 font-medium italic">Worker Management & Directory</p>
            </div>
        </div>
        
        <a href="{{ route('users.create') }}" 
           class="w-full md:w-auto bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-8 py-3.5 rounded-2xl font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-green-600/20 transform active:scale-95">
            <i class="fas fa-user-plus text-xs"></i> 
            <span>إضافة موظف جديد</span>
        </a>
    </div>

    <div class="glass-panel rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-800 transition-all">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead class="bg-gray-50/50 dark:bg-slate-800/50 text-gray-400 uppercase text-[10px] font-bold tracking-widest">
                    <tr>
                        <th class="p-5 border-b border-gray-100 dark:border-gray-800 text-right uppercase">الموظف</th>
                        <th class="p-5 border-b border-gray-100 dark:border-gray-800 text-right uppercase">المستودع</th>
                        <th class="p-5 border-b border-gray-100 dark:border-gray-800 text-right uppercase">التفاصيل</th>
                        <th class="p-5 border-b border-gray-100 dark:border-gray-800 text-right uppercase">البيانات المالية</th>
                        <th class="p-5 border-b border-gray-100 dark:border-gray-800 text-center uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($workers as $worker)
                    <tr class="hover:bg-blue-50/30 dark:hover:bg-blue-900/10 transition-colors group">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img src="{{ $worker->image ? asset('storage/' . $worker->image) : 'https://ui-avatars.com/api/?name='.urlencode($worker->name).'&background=random' }}" 
                                         class="w-12 h-12 rounded-2xl object-cover border-2 border-white dark:border-gray-700 shadow-md transform group-hover:scale-110 transition-transform">
                                    <div class="absolute -bottom-1 -left-1 w-4 h-4 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full"></div>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800 dark:text-gray-200">{{ $worker->name }}</div>
                                    <div class="text-[10px] text-gray-500 dark:text-gray-500 font-mono tracking-tight">{{ $worker->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="p-5">
                            <span class="inline-flex items-center gap-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 px-3 py-1.5 rounded-xl text-[11px] font-bold border border-blue-100 dark:border-blue-800/50">
                                <i class="fas fa-warehouse text-[10px]"></i> 
                                {{ $worker->warehouse->name ?? 'غير محدد' }}
                            </span>
                        </td>

                        <td class="p-5">
                            <div class="flex flex-wrap gap-1.5 max-w-xs">
                                @php $detailsArray = explode(';', $worker->details); @endphp
                                @foreach($detailsArray as $detail)
                                    @if(trim($detail))
                                    <span class="bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-lg text-[10px] font-bold border border-gray-200 dark:border-gray-700 shadow-sm">
                                        {{ trim($detail) }}
                                    </span>
                                    @endif
                                @endforeach
                            </div>
                        </td>

                        <td class="p-5">
                            <div class="text-sm font-black text-emerald-600 dark:text-emerald-400">${{ number_format($worker->salary, 2) }}</div>
                            <div class="text-[9px] text-gray-400 dark:text-gray-500 uppercase tracking-tighter mt-1 font-bold italic">التعيين: {{ $worker->hire_date }}</div>
                        </td>

                        <td class="p-5">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('users.sales', $worker->id) }}" class="w-9 h-9 flex items-center justify-center text-purple-600 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-xl transition-all" title="المبيعات">
                                    <i class="fas fa-chart-line text-sm"></i>
                                </a>
                                <a href="{{ route('users.edit', $worker->id) }}" class="w-9 h-9 flex items-center justify-center text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all" title="تعديل">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route('users.destroy', $worker->id) }}" method="POST" class="delete-form inline">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="w-9 h-9 flex items-center justify-center text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-all" title="حذف">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(button) {
        const form = button.closest('.delete-form');
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "حذف هذا الموظف نهائي ولا يمكن التراجع عنه!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'نعم، قم بالحذف',
            cancelButtonText: 'إلغاء',
            background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#fff',
            color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
            customClass: {
                popup: 'rounded-[2rem] border-none shadow-2xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endpush
@push('scripts')
      
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
   <script>
    
    // 1. وظيفة القوائم المنسدلة (Dropdowns) الموحدة
    function setupDropdown(btnId, menuId, arrowId) {
        const btn = document.getElementById(btnId);
        const menu = document.getElementById(menuId);
        const arrow = document.getElementById(arrowId);
        
        if(btn && menu) {
            btn.addEventListener('click', () => {
                const isOpen = menu.style.maxHeight !== '0px' && menu.style.maxHeight !== '';
                menu.style.maxHeight = isOpen ? '0px' : menu.scrollHeight + 'px';
                if(arrow) arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        }
    }

    // تفعيل كل القوائم
    setupDropdown('supplierBtn', 'supplierMenu', 'supplierArrow');
    setupDropdown('warehouseBtn', 'warehouseMenu', 'warehouseArrow');
    setupDropdown('employeeBtn', 'employeeMenu', 'employeeArrow');
    setupDropdown('purchasesBtn', 'purchasesMenu', 'purchasesArrow');
    setupDropdown('expensesBtn', 'expensesMenu', 'expensesArrow');
    // 2. وظيفة إغلاق وفتح السايد بار (Sidebar Toggle)
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
toggleBtn.addEventListener('click', () => {
    // إخفاء السايد بار بإزاحته لليمين خارج الشاشة
    sidebar.classList.toggle('translate-x-full');
    
    if (sidebar.classList.contains('translate-x-full')) {
        // توسيع المحتوى والناف بار ليأخذا كامل الشاشة
        mainContent.classList.replace('mr-72', 'mr-0');
    } else {
        // إعادة الهامش لحجز مكان للسايد بار
        mainContent.classList.replace('mr-0', 'mr-72');
    }
});

    // 3. تنبيه النجاح (SweetAlert)
    @if(session('success'))
        Swal.fire({
            title: 'تم الحفظ!',
            text: "{{ session('success') }}",
            icon: 'success',
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#2563eb'
        });
    @endif
</script>
@endpush
