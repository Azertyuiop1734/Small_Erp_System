@extends('layouts.app')
@section('title', 'إضافة منتج جديد')
@section('page_icon_url', asset('imgs/addproductimg.png'))

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    .product-orb {
        position: fixed; border-radius: 50%;
        filter: blur(100px); opacity: 0.1; pointer-events: none; z-index: 0;
    }
    .orb-a { width: 450px; height: 450px; background: #1a56db; top: -100px; right: -80px; }
    .orb-b { width: 350px; height: 350px; background: #38bdf8; bottom: -60px; left: -60px; }
    .orb-c { width: 250px; height: 250px; background: #818cf8; top: 50%; left: 50%; transform: translate(-50%,-50%); }
    .section-divider {
        font-size: .7rem; font-weight: 600; color: #475569;
        letter-spacing: .1em; display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.25rem; margin-top: .25rem;
    }
    .section-divider::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,.06); }
    .upload-zone {
        border: 1.5px dashed; border-color: rgb(51 65 85);
        border-radius: 14px; padding: 2rem;
        display: flex; flex-direction: column; align-items: center; gap: .6rem;
        cursor: pointer; transition: all .2s; background: rgba(255,255,255,.02);
    }
    .upload-zone:hover { border-color: rgb(59 130 246 / .5); background: rgba(59,130,246,.04); }
    .upload-preview { width: 100%; max-height: 200px; object-fit: contain; border-radius: 10px; display: none; }
</style>
@endpush

@section('content')

{{-- أوريب خلفية ديناميكية --}}
<div class="dark:block hidden">
    <div class="product-orb orb-a"></div>
    <div class="product-orb orb-b"></div>
    <div class="product-orb orb-c"></div>
</div>

<div class="relative z-10 flex items-center justify-center px-4 py-10 min-h-[90vh]">
<div class="w-full max-w-2xl">

    {{-- البطاقة الرئيسية --}}
    <div class="bg-white dark:bg-[#070f1f]/85 dark:backdrop-blur-2xl
                border border-gray-200 dark:border-white/[0.07]
                rounded-3xl shadow-2xl dark:shadow-[0_32px_80px_rgba(0,0,0,0.55)]
                overflow-hidden">

        {{-- شريط علوي ملوّن --}}
        <div class="h-[3px]" style="background: linear-gradient(90deg, #1a56db, #38bdf8, #818cf8);"></div>

        <div class="p-8 md:p-10">

            {{-- رأس الصفحة --}}
            <div class="flex items-center gap-4 mb-7">
                <div class="w-14 h-14 flex-shrink-0 rounded-2xl flex items-center justify-center
                            bg-blue-50 dark:bg-blue-900/20
                            border border-blue-200 dark:border-blue-700/40">
                    <svg class="w-6 h-6 text-blue-500" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/>
                        <path d="M16 3H8L6 7h12l-2-4z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-slate-100 tracking-tight">
                        إضافة منتج جديد للمخزون
                    </h2>
                    <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">
                        يرجى إدخال تفاصيل المنتج بدقة لتحديث قاعدة البيانات
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-white/[0.06] mb-7"></div>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="initial_quantity" value="0">

                {{-- قسم: معلومات المنتج --}}
                <div class="section-divider">معلومات المنتج</div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                    {{-- اسم المنتج --}}
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-slate-500 tracking-wide uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                            اسم المنتج
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full bg-gray-50 dark:bg-white/[0.04]
                                   border border-gray-200 dark:border-white/[0.07]
                                   rounded-xl px-4 py-3 text-sm
                                   text-gray-900 dark:text-slate-200
                                   placeholder:text-gray-300 dark:placeholder:text-slate-700
                                   outline-none transition-all
                                   focus:border-blue-500/60 focus:ring-4 focus:ring-blue-500/10
                                   dark:focus:bg-blue-900/[0.07]"
                            placeholder="أدخل اسم المنتج..." required>
                        @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- الباركود --}}
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-slate-500 tracking-wide uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                            الباركود
                        </label>
                        <input type="text" name="barcode" value="{{ old('barcode') }}"
                            class="w-full bg-gray-50 dark:bg-white/[0.04]
                                   border border-gray-200 dark:border-white/[0.07]
                                   rounded-xl px-4 py-3 text-sm
                                   text-gray-900 dark:text-slate-200
                                   placeholder:text-gray-300 dark:placeholder:text-slate-700
                                   outline-none transition-all
                                   focus:border-blue-500/60 focus:ring-4 focus:ring-blue-500/10
                                   dark:focus:bg-blue-900/[0.07]"
                            placeholder="امسح أو أدخل الباركود..." required>
                    </div>

                    {{-- القسم --}}
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-slate-500 tracking-wide uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                            القسم
                        </label>
                        <div class="relative">
                            <select name="category_id"
                                class="w-full appearance-none bg-gray-50 dark:bg-white/[0.04]
                                       border border-gray-200 dark:border-white/[0.07]
                                       rounded-xl px-4 py-3 text-sm
                                       text-gray-600 dark:text-slate-300
                                       outline-none transition-all
                                       focus:border-blue-500/60 focus:ring-4 focus:ring-blue-500/10" required>
                                <option value="">-- اختر القسم --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2">
                                <svg class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    {{-- المخزن --}}
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-slate-500 tracking-wide uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                            المخزن الأساسي
                        </label>
                        <div class="relative">
                            <select name="warehouse_id"
                                class="w-full appearance-none bg-gray-50 dark:bg-white/[0.04]
                                       border border-gray-200 dark:border-white/[0.07]
                                       rounded-xl px-4 py-3 text-sm
                                       text-gray-600 dark:text-slate-300
                                       outline-none transition-all
                                       focus:border-blue-500/60 focus:ring-4 focus:ring-blue-500/10" required>
                                <option value="">-- اختر المخزن --</option>
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}" {{ old('warehouse_id') == $wh->id ? 'selected' : '' }}>
                                        {{ $wh->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2">
                                <svg class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    {{-- الحد الأدنى --}}
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-slate-500 tracking-wide uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span>
                            الحد الأدنى للمخزون
                            <span class="mr-auto text-gray-300 dark:text-slate-700 normal-case tracking-normal font-normal text-xs">(اختياري)</span>
                        </label>
                        <input type="number" name="minimum_stock" value="{{ old('minimum_stock', 5) }}"
                            class="w-full bg-gray-50 dark:bg-white/[0.04]
                                   border border-gray-200 dark:border-white/[0.07]
                                   rounded-xl px-4 py-3 text-sm
                                   text-gray-900 dark:text-slate-200
                                   outline-none transition-all
                                   focus:border-blue-500/60 focus:ring-4 focus:ring-blue-500/10">
                    </div>

                    {{-- سعر البيع --}}
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-2 text-xs font-semibold text-gray-500 dark:text-slate-500 tracking-wide uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>
                            سعر البيع
                        </label>
                        <input type="number" step="0.01" name="selling_price" value="{{ old('selling_price') }}"
                            class="w-full bg-gray-50 dark:bg-white/[0.04]
                                   border border-gray-200 dark:border-white/[0.07]
                                   rounded-xl px-4 py-3 text-sm
                                   text-gray-900 dark:text-slate-200
                                   placeholder:text-gray-300 dark:placeholder:text-slate-700
                                   outline-none transition-all
                                   focus:border-blue-500/60 focus:ring-4 focus:ring-blue-500/10"
                            placeholder="0.00" required>
                    </div>

                </div>

                {{-- قسم: صورة المنتج --}}
                <div class="section-divider">صورة المنتج</div>

                <input type="file" name="image" id="imgInput" accept="image/*" class="hidden">
                <label for="imgInput" class="upload-zone block text-center cursor-pointer">
                    <div id="uploadDefault" class="flex flex-col items-center gap-2">
                        <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700/40
                                    flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                                <polyline points="17 8 12 3 7 8"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-slate-500">اسحب الصورة هنا أو اضغط للاختيار</span>
                        <span class="text-xs text-gray-300 dark:text-slate-700">PNG، JPG، WEBP — حجم أقصى 5MB</span>
                    </div>
                    <img id="previewImg" src="" alt="" class="upload-preview mx-auto">
                </label>

                {{-- زر الحفظ --}}
                <button type="submit"
                    class="group relative w-full mt-7 py-3.5 rounded-xl font-semibold text-sm text-white overflow-hidden
                           flex items-center justify-center gap-2
                           bg-blue-600 hover:bg-blue-700
                           shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40
                           transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                    <span class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%]
                                 bg-gradient-to-r from-transparent via-white/10 to-transparent
                                 transition-transform duration-500"></span>
                    <svg class="relative w-4 h-4" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v14z"/>
                        <polyline points="17,21 17,13 7,13 7,21"/>
                        <polyline points="7,3 7,8 15,8"/>
                    </svg>
                    <span class="relative">حفظ المنتج الجديد</span>
                </button>

                <div class="flex items-center justify-center gap-2 mt-5">
                    <span class="w-1 h-1 rounded-full bg-gray-200 dark:bg-slate-800"></span>
                    <p class="text-xs text-gray-300 dark:text-slate-700">الحقول المميزة بنقطة زرقاء إلزامية</p>
                    <span class="w-1 h-1 rounded-full bg-gray-200 dark:bg-slate-800"></span>
                </div>

            </form>
        </div>
    </div>

</div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // معاينة الصورة
    document.getElementById('imgInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            const preview = document.getElementById('previewImg');
            const def = document.getElementById('uploadDefault');
            preview.src = ev.target.result;
            preview.style.display = 'block';
            def.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });


    // SweetAlert
    function showCustomAlert(config) {
        const isDark = document.documentElement.classList.contains('dark');
        return Swal.fire({
            icon: config.icon || 'info',
            title: config.title || '',
            text: config.text || '',
            timer: config.timer || null,
            showConfirmButton: config.showConfirmButton ?? true,
            confirmButtonText: config.confirmButtonText || 'موافق',
            background: isDark ? '#070f1f' : '#ffffff',
            color: isDark ? '#e2e8f0' : '#1e293b',
            confirmButtonColor: '#1d4ed8',
            customClass: {
                popup: 'rounded-[1.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl',
                title: 'text-xl font-semibold',
                confirmButton: 'rounded-xl px-8 py-2.5 text-sm font-semibold'
            },
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            showCustomAlert({
                icon: 'success',
                title: 'تم الحفظ بنجاح',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500
            });
        @endif
        @if($errors->any())
            showCustomAlert({
                icon: 'error',
                title: 'عذراً، هناك خطأ',
                text: 'يرجى التأكد من ملء جميع الحقول المطلوبة بشكل صحيح.'
            });
        @endif
    });
</script>
@endpush