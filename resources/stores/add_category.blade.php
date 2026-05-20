@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 animate-fade-in">
    <div class="mb-8 text-center">
        <div class="inline-flex p-4 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-3xl shadow-lg shadow-blue-500/30 mb-4">
            <i class="fas fa-plus-circle text-3xl text-white"></i>
        </div>
        <h2 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight">إضافة قسم جديد</h2>
        <p class="text-gray-500 dark:text-gray-400 font-medium mt-2">قم بتعبئة البيانات أدناه لإنشاء تصنيف منتجات جديد</p>
    </div>

    <div class="bg-white/80 dark:bg-[#0a1120]/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-white/5 overflow-hidden transition-all duration-500">
        <form action="{{ route('categories.store') }}" method="POST" class="p-10 space-y-8">
            @csrf
            
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 px-2">
                    <i class="fas fa-tag ml-1 text-blue-500"></i> اسم القسم
                </label>
                <input type="text" name="category_name" required
                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 p-5 rounded-2xl text-gray-800 dark:text-white focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all shadow-inner"
                       placeholder="على سبيل المثال: إلكترونيات، ملابس، أدوات منزلية...">
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 px-2">
                    <i class="fas fa-align-right ml-1 text-blue-500"></i> وصف القسم (اختياري)
                </label>
                <textarea name="description" rows="4"
                          class="w-full bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 p-5 rounded-2xl text-gray-800 dark:text-white focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all shadow-inner"
                          placeholder="اكتب وصفاً مختصراً لهذا القسم لسهولة تنظيمه لاحقاً..."></textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-black py-5 rounded-2xl transition-all duration-300 transform hover:-translate-y-1 shadow-xl shadow-blue-500/25 flex items-center justify-center gap-3">
                    <i class="fas fa-check-circle"></i>
                    حفظ القسم الجديد
                </button>
                
                <a href="{{ route('categories.index') }}" 
                   class="px-10 py-5 bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 font-bold rounded-2xl hover:bg-gray-200 dark:hover:bg-white/10 transition-all text-center">
                    إلغاء والعودة
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.7s ease-out forwards; }
</style>
@endsection