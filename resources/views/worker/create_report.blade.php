@extends('layouts.app')

@section('title', 'إنشاء تقرير عمل جديد')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-[#0f172a] rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden transition-colors duration-300">
        
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-white flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold tracking-wide">إرسال تقرير عمل</h2>
                <p class="text-blue-100 mt-1 text-sm opacity-90">قم بتوثيق الإنجازات أو الملاحظات اليومية بدقة</p>
            </div>
            <div class="p-4 bg-white/10 rounded-2xl backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
        </div>

        <form action="{{ route('reports.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">عنوان التقرير</label>
                    <div class="relative">
                        <input type="text" name="title" required
                            class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none placeholder-gray-400"
                            placeholder="مثال: تقرير الجرد الدوري، ملاحظات الصيانة...">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">تاريخ التقرير</label>
                    <input type="date" name="report_date" value="{{ date('Y-m-d') }}" required
                        class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">التفاصيل والوصف</label>
                <textarea name="description" rows="8" required
                    class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none placeholder-gray-400 resize-none"
                    placeholder="اكتب تفاصيل العمل، المشاكل التي واجهتك، أو أي اقتراحات..."></textarea>
            </div>

            <div class="p-4 bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/30 rounded-2xl flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs text-amber-700 dark:text-amber-400 leading-relaxed">
                    ملاحظة: سيتم إرسال هذا التقرير مباشرة إلى إدارة النظام، وسيتضمن اسمك وتوقيت الإرسال تلقائياً. تأكد من مراجعة البيانات قبل الاعتماد.
                </p>
            </div>

            <div class="pt-6 flex flex-col md:flex-row justify-end gap-4 border-t border-gray-100 dark:border-gray-800">
                <button type="reset" class="px-6 py-3 rounded-xl text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 font-bold transition order-2 md:order-1">
                    مسح المسودة
                </button>
                <button type="submit" 
                    class="px-10 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-600/20 transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2 order-1 md:order-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    إرسال التقرير الآن
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /**
     * 1. الدالة الجمالية الموحدة للتنبيهات
     * تدعم Dark/Light Mode وتنسيق الأزرار والأنيميشن
     */
    function showCustomAlert(title, text, icon = 'success', html = null) {
        const isDark = document.documentElement.classList.contains('dark');
        
        return Swal.fire({
            title: title,
            text: text,
            html: html,
            icon: icon,
            showConfirmButton: true,
            confirmButtonText: 'حسناً',
            background: isDark ? '#1e293b' : '#ffffff', 
            color: isDark ? '#f8fafc' : '#1e293b',
            iconColor: icon === 'success' ? '#10b981' : (icon === 'error' ? '#ef4444' : '#f59e0b'),
            showClass: { popup: 'animate__animated animate__zoomIn animate__faster' },
            hideClass: { popup: 'animate__animated animate__zoomOut animate__faster' },
            customClass: {
                popup: 'rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-2xl',
                title: 'text-2xl font-bold font-cairo',
                confirmButton: icon === 'error' 
                    ? 'bg-rose-600 hover:bg-rose-700 text-white px-10 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-rose-600/20 mx-2'
                    : 'bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-blue-600/20 mx-2',
                cancelButton: 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 px-10 py-3 rounded-2xl font-bold mx-2'
            },
            buttonsStyling: false 
        });
    }

    /**
     * 2. إعداد القوائم المنسدلة (Sidebar Dropdowns)
     */


    /**
     * 4. معالجة أحداث التنبيهات (Flash Messages & Errors)
     */
    @if(session('success'))
        showCustomAlert('تمت العملية بنجاح!', "{{ session('success') }}", 'success');
    @endif

    @if($errors->any())
        let errorList = '<ul class="text-right text-sm space-y-1">';
        @foreach ($errors->all() as $error)
            errorList += '<li class="text-rose-500 font-semibold">• {{ $error }}</li>';
        @endforeach
        errorList += '</ul>';
        showCustomAlert('خطأ في البيانات!', null, 'error', errorList);
    @endif

    /**
     * 5. تنبيه "مسح النموذج" الاحترافي
     */
    const resetBtn = document.querySelector('button[type="reset"]');
    if(resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const isDark = document.documentElement.classList.contains('dark');
            
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف كل ما كتبته في هذا التقرير ولن تتمكن من التراجع!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، امسح الكل',
                cancelButtonText: 'تراجع',
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#f8fafc' : '#1e293b',
                customClass: {
                    popup: 'rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-2xl',
                    confirmButton: 'bg-rose-600 hover:bg-rose-700 text-white px-8 py-3 rounded-2xl font-bold mx-2',
                    cancelButton: 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 px-8 py-3 rounded-2xl font-bold mx-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').reset();
                    showCustomAlert('تم المسح!', 'تمت إعادة تعيين النموذج بنجاح', 'success');
                }
            });
        });
    }
</script>
@endpush