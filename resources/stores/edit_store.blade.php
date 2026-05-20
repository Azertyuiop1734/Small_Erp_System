@extends('layouts.app')

@section('title', 'تعديل مستودع')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-black text-slate-800 dark:text-white">تعديل: {{ $store->name }}</h1>
        <a href="{{ route('stores.index') }}" class="text-gray-500 hover:text-blue-500 transition">
            <i class="fas fa-arrow-left ml-2"></i> العودة للقائمة
        </a>
    </div>

    <div class="bg-white dark:bg-slate-900/70 backdrop-blur-xl rounded-[2.5rem] border border-gray-200 dark:border-white/5 shadow-2xl p-8">
        <form action="{{ route('stores.update', $store->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-600 dark:text-gray-400 mr-2">اسم المستودع</label>
                <input type="text" name="name" value="{{ old('name', $store->name) }}" 
                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition"
                       placeholder="مثال: مستودع المنطقة المركزية">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-600 dark:text-gray-400 mr-2">الموقع الجغرافي</label>
                <input type="text" name="location" value="{{ old('location', $store->location) }}" 
                       class="w-full bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-2xl px-6 py-4 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none transition"
                       placeholder="مثال: شارع الاستقلال، وهران">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:scale-[1.02] active:scale-95">
                <i class="fas fa-save ml-2"></i> حفظ التغييرات
            </button>
        </form>
    </div>
</div>
@endsection