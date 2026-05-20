@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in">
    
    <div class="relative overflow-hidden bg-white dark:bg-[#0a1120] p-8 rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-2xl dark:shadow-blue-900/10 transition-all duration-500">
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-2xl shadow-lg shadow-blue-500/30">
                    <i class="fas fa-layer-group text-2xl text-white"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight">إدارة الأقسام</h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium flex items-center gap-2 mt-1">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        نظام تنظيم المخزون الذكي
                    </p>
                </div>
            </div>
            
            <a href="{{ route('categories.create') }}" 
               class="group relative inline-flex items-center gap-3 bg-gray-900 dark:bg-blue-600 hover:bg-black dark:hover:bg-blue-500 text-white px-8 py-4 rounded-2xl font-bold transition-all duration-300 transform hover:-translate-y-1 shadow-xl">
                <i class="fas fa-plus-circle transition-transform group-hover:rotate-90"></i>
                إضافة قسم جديد
            </a>
        </div>
    </div>

    <div class="bg-white/80 dark:bg-[#0a1120]/80 backdrop-blur-md rounded-[2rem] shadow-2xl border border-gray-100 dark:border-white/5 overflow-hidden transition-all duration-500">
        <table class="w-full text-right">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-white/[0.02] text-gray-400 dark:text-gray-500">
                    <th class="p-6 text-[10px] font-black uppercase tracking-[2px]">المعرف</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-[2px]">اسم القسم</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-[2px]">التفاصيل</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-[2px]">تاريخ الإنشاء</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-[2px] text-center">التحكم</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                @forelse($categories as $cat)
                <tr class="group hover:bg-blue-50/30 dark:hover:bg-blue-500/[0.02] transition-all duration-300">
                    <td class="p-6">
                        <span class="font-mono text-xs font-bold text-gray-400 group-hover:text-blue-500 transition-colors">#{{ str_pad($cat->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    
                    <td class="p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-white/5 flex items-center justify-center text-blue-500 font-bold group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
                                {{ mb_substr($cat->category_name, 0, 1) }}
                            </div>
                            <span class="font-bold text-gray-700 dark:text-gray-200">{{ $cat->category_name }}</span>
                        </div>
                    </td>

                    <td class="p-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed italic truncate max-w-[200px]">
                            {{ $cat->description ?: 'لا يوجد وصف مضاف...' }}
                        </p>
                    </td>

                    <td class="p-6">
                        <span class="text-xs font-medium text-gray-400 flex items-center gap-2">
                            <i class="far fa-clock text-blue-400"></i>
                            {{ $cat->created_at->diffForHumans() }}
                        </span>
                    </td>
                    
                    <td class="p-6 text-center">
                        <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button onclick="confirmDelete({{ $cat->id }})" 
                                    class="h-10 w-10 flex items-center justify-center rounded-xl bg-red-50 dark:bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300 shadow-sm">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-20 text-center">
                        <div class="flex flex-col items-center gap-4 opacity-40">
                            <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center">
                                <i class="fas fa-folder-open text-4xl"></i>
                            </div>
                            <span class="font-bold text-lg">قائمة الأقسام فارغة حالياً</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }

</style>
@endsection
{{-- تأكد أن هذا الجزء في نهاية الملف --}}
@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '<span class="text-2xl font-black text-white">هل أنت متأكد؟</span>',
            html: '<p class="text-gray-400 font-medium">سيتم حذف هذا القسم نهائياً، وقد يؤثر ذلك على المنتجات المرتبطة به!</p>',
            icon: 'warning',
            iconColor: '#f87171', // لون أيقونة التحذير (Red-400)
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Red-500
            cancelButtonColor: '#374151',  // Gray-700
            confirmButtonText: '<i class="fas fa-trash-alt ml-2"></i> نعم، احذف الآن',
            cancelButtonText: 'إلغاء العملية',
            reverseButtons: true, // لجعل زر الإلغاء على اليمين والحذف على اليسار (أفضل لتجربة المستخدم)
            
            // تحسين التصميم البصري للنافذة
            background: '#0a1120', // لون الخلفية الداكن المطابق للـ Layout
            backdrop: `rgba(4, 8, 15, 0.8) blur(8px)`, // جعل خلفية الصفحة ضبابية عند ظهور النافذة
            
            customClass: {
                popup: 'rounded-[2.5rem] border border-white/10 shadow-2xl',
                confirmButton: 'px-8 py-3 rounded-2xl font-bold transition-all hover:scale-105',
                cancelButton: 'px-8 py-3 rounded-2xl font-bold transition-all hover:bg-gray-600'
            },
            
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster' // حركات دخول ناعمة
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // إظهار نافذة تحميل صغيرة قبل الانتقال
                Swal.fire({
                    title: 'جاري الحذف...',
                    timerProgressBar: true,
                    didOpen: () => { Swal.showLoading(); },
                    background: '#0a1120',
                    color: '#fff',
                    showConfirmButton: false,
                    customClass: { popup: 'rounded-3xl' }
                });
                
                window.location.href = "{{ url('admin/categories/delete') }}/" + id;
            }
        })
    }
</script>
@endpush