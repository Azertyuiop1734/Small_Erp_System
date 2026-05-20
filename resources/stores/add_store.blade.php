@extends('layouts.app')
@section('page_icon_url', asset('imgs/warehouseimg.png'))
@section('title', 'إضافة مخزن جديد')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    .warehouse-bg {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        overflow: hidden;
    }
    .warehouse-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(90px);
        opacity: 0.12;
    }
    .orb-1 { width: 500px; height: 500px; background: #1a56db; top: -120px; right: -100px; }
    .orb-2 { width: 380px; height: 380px; background: #0ea5e9; bottom: -80px; left: -80px; }
    .orb-3 { width: 280px; height: 280px; background: #6366f1; top: 45%; left: 45%; transform: translate(-50%, -50%); }
</style>
@endpush

@section('content')

{{-- خلفية الأوريب --}}
<div class="warehouse-bg dark:block hidden">
    <div class="warehouse-orb orb-1"></div>
    <div class="warehouse-orb orb-2"></div>
    <div class="warehouse-orb orb-3"></div>
</div>

<div class="relative z-10 min-h-[85vh] flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-lg">

        {{-- البطاقة --}}
        <div class="bg-white dark:bg-[#070f1f]/80 dark:backdrop-blur-2xl
                    border border-gray-200 dark:border-white/[0.07]
                    rounded-3xl shadow-2xl dark:shadow-[0_32px_80px_rgba(0,0,0,0.6)]
                    overflow-hidden">

            {{-- شريط العلوي الملوّن --}}
            <div class="h-1" style="background: linear-gradient(90deg, #1a56db, #0ea5e9, #6366f1);"></div>

            <div class="p-10">

                {{-- رأس الصفحة --}}
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 flex-shrink-0 rounded-2xl flex items-center justify-center
                                bg-blue-50 dark:bg-blue-900/20
                                border border-blue-200 dark:border-blue-700/40">
                        <svg class="w-6 h-6 text-blue-500" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <polyline points="9,22 9,12 15,12 15,22"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-slate-100 tracking-tight">
                            إضافة مستودع جديد
                        </h2>
                        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">
                            يرجى ملء البيانات أدناه لإضافة مخزن إلى النظام
                        </p>
                    </div>
                </div>

                {{-- فاصل --}}
                <div class="border-t border-gray-100 dark:border-white/[0.06] mb-8"></div>

                {{-- النموذج --}}
                <form action="{{ route('stores.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- اسم المخزن --}}
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400">
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            اسم المخزن
                        </label>
                        <input type="text" name="name"
                            class="w-full bg-gray-50 dark:bg-white/[0.04]
                                   border border-gray-200 dark:border-white/[0.08]
                                   rounded-xl px-4 py-3
                                   text-gray-900 dark:text-slate-200
                                   placeholder:text-gray-300 dark:placeholder:text-slate-700
                                   text-sm
                                   outline-none transition-all duration-200
                                   focus:border-blue-500 dark:focus:border-blue-500/60
                                   focus:bg-blue-50/50 dark:focus:bg-blue-900/[0.08]
                                   focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/10"
                            placeholder="أدخل اسم المخزن..."
                            value="{{ old('name') }}"
                            required>
                        @error('name')
                            <p class="text-xs text-red-500 flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M8 1a7 7 0 100 14A7 7 0 008 1zm.75 4.5a.75.75 0 00-1.5 0v3.5a.75.75 0 001.5 0V5.5zm-.75 6a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- موقع المخزن --}}
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400">
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            موقع المخزن
                            <span class="mr-auto text-xs text-gray-300 dark:text-slate-600 font-normal">(اختياري)</span>
                        </label>
                        <textarea name="location" rows="4"
                            class="w-full bg-gray-50 dark:bg-white/[0.04]
                                   border border-gray-200 dark:border-white/[0.08]
                                   rounded-xl px-4 py-3
                                   text-gray-900 dark:text-slate-200
                                   placeholder:text-gray-300 dark:placeholder:text-slate-700
                                   text-sm resize-none
                                   outline-none transition-all duration-200
                                   focus:border-blue-500 dark:focus:border-blue-500/60
                                   focus:bg-blue-50/50 dark:focus:bg-blue-900/[0.08]
                                   focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/10"
                            placeholder="أدخل العنوان بالتفصيل...">{{ old('location') }}</textarea>
                    </div>

                    {{-- زر الإرسال --}}
                    <div class="pt-2">
                        <button type="submit"
                            class="group relative w-full py-3.5 px-6 rounded-xl font-semibold text-sm text-white overflow-hidden
                                   transition-all duration-200 hover:-translate-y-0.5
                                   bg-blue-600 hover:bg-blue-700
                                   shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40">
                            {{-- وميض الزر --}}
                            <span class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%]
                                         bg-gradient-to-r from-transparent via-white/10 to-transparent
                                         transition-transform duration-500 ease-in-out"></span>
                            <span class="relative flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2.2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14z"/>
                                    <polyline points="17,21 17,13 7,13 7,21"/>
                                    <polyline points="7,3 7,8 15,8"/>
                                </svg>
                                حفظ البيانات
                            </span>
                        </button>
                    </div>

                </form>

                {{-- تذييل البطاقة --}}
                <div class="mt-6 flex items-center justify-center gap-2">
                    <span class="w-1 h-1 rounded-full bg-gray-200 dark:bg-slate-800"></span>
                    <p class="text-xs text-gray-300 dark:text-slate-600">الحقول المميزة بنقطة زرقاء إلزامية</p>
                    <span class="w-1 h-1 rounded-full bg-gray-200 dark:bg-slate-800"></span>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ... (بقية السكريبت بدون تغيير)

    function fireStyledAlert(config) {
        const isDarkMode = document.documentElement.classList.contains('dark');
        return Swal.fire({
            icon: config.icon || 'info',
            title: config.title || '',
            text: config.text || '',
            timer: config.timer || null,
            showConfirmButton: config.showConfirmButton ?? true,
            confirmButtonText: config.confirmButtonText || 'موافق',
            background: isDarkMode ? '#070f1f' : '#ffffff',
            color: isDarkMode ? '#e2e8f0' : '#1e293b',
            confirmButtonColor: '#1d4ed8',
            customClass: {
                popup: 'rounded-[1.5rem] border border-gray-200 dark:border-gray-800 shadow-2xl',
                title: 'text-xl font-semibold',
                confirmButton: 'rounded-xl px-8 py-2.5 text-sm font-semibold'
            },
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            fireStyledAlert({
                icon: 'success',
                title: 'تمت العملية بنجاح',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endpush