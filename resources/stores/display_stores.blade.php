@extends('layouts.app')

@section('title', 'قائمة المخازن')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                <i class="fas fa-warehouse text-blue-500"></i>
                إدارة المخازن
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1 font-medium">عرض وإدارة جميع مستودعات النظام</p>
        </div>
        
        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-500/20 transition-all hover:scale-105 flex items-center gap-2">
            <i class="fas fa-plus-circle"></i>
            إضافة مخزن جديد
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white/50 dark:bg-slate-900/50 backdrop-blur-md p-6 rounded-[2rem] border border-gray-200 dark:border-white/5 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 text-xl">
                    <i class="fas fa-boxes"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-bold">إجمالي المخازن</p>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">{{ $stores->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900/70 backdrop-blur-xl rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-black/20 text-gray-600 dark:text-gray-400 text-sm font-bold uppercase tracking-wider">
                        <th class="px-8 py-5">#</th>
                        <th class="px-8 py-5">اسم المخزن</th>
                        <th class="px-8 py-5">الموقع الجغرافي</th>
                        <th class="px-8 py-5 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($stores as $store)
                    <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-500/5 transition-colors group">
                        <td class="px-8 py-5 font-bold text-gray-400 group-hover:text-blue-500">{{ $loop->iteration }}</td>
                        <td class="px-8 py-5">
                            <span class="font-black text-slate-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                {{ $store->name }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-gray-600 dark:text-gray-400 font-medium">
                            <i class="fas fa-map-marker-alt ml-2 opacity-50"></i>{{ $store->location }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('stores.edit', $store->id) }}" class="p-3 bg-amber-500/10 text-amber-600 rounded-2xl hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete({{ $store->id }})" class="p-3 bg-red-500/10 text-red-600 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center opacity-30">
                                <i class="fas fa-box-open text-6xl mb-4"></i>
                                <p class="text-xl font-bold">لا توجد مخازن مسجلة حالياً</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        const isDark = document.documentElement.classList.contains('dark');
        
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "سيتم حذف المخزن نهائياً!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: isDark ? '#334155' : '#94a3b8',
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء',
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#1e293b',
            customClass: {
                popup: 'rounded-[2rem] border border-white/10 shadow-2xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // كود الحذف هنا
                Swal.fire('تم الحذف!', 'تمت إزالة المخزن بنجاح.', 'success');
            }
        });
    }
</script>
@endpush
@endsection