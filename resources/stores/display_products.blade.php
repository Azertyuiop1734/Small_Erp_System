@extends('layouts.app')

@section('title', 'قائمة المنتجات والمخزون')
@section('page_icon_url', asset('imgs/browseproductsimg.png'))

@section('content')

<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- بطاقة إحصاء واحدة كمثال (طبقها على البقية) --}}
    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center space-x-4 rtl:space-x-reverse transition-colors duration-300">
        <div class="p-4 bg-blue-600/10 rounded-xl text-blue-600 dark:text-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_products'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">إجمالي المنتجات</p>
        </div>
    </div>

    {{-- مستودعات --}}
    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center space-x-4 rtl:space-x-reverse transition-colors duration-300">
        <div class="p-4 bg-emerald-600/10 rounded-xl text-emerald-600 dark:text-emerald-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['warehouses'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">المستودعات</p>
        </div>
    </div>

    {{-- مخزون منخفض --}}
    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center space-x-4 rtl:space-x-reverse transition-colors duration-300">
        <div class="p-4 bg-amber-600/10 rounded-xl text-amber-600 dark:text-amber-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['low_stock'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">مخزون منخفض</p>
        </div>
    </div>

    {{-- نفذت الكمية --}}
    <div class="bg-white dark:bg-[#0f172a] p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center space-x-4 rtl:space-x-reverse transition-colors duration-300">
        <div class="p-4 bg-rose-600/10 rounded-xl text-rose-600 dark:text-rose-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['out_of_stock'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">نفذت الكمية</p>
        </div>
    </div>
</section>

<div class="bg-white dark:bg-[#0f172a] rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden transition-colors duration-300">
    <div class="p-8 border-b border-gray-100 dark:border-gray-800 flex flex-col md:flex-row justify-between items-center gap-4 bg-gray-50/50 dark:bg-[#020617]/30">
        <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">جدول المنتجات</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">يمكنك إدارة وتعديل كافة المنتجات المسجلة في النظام</p>
        </div>
        <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold transition-all flex items-center gap-2 shadow-lg shadow-blue-600/20 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            إضافة منتج جديد
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-gray-50/50 dark:bg-[#020617]/50 text-gray-600 dark:text-gray-400 uppercase text-xs font-bold tracking-wider">
                    <th class="px-8 py-5 border-b dark:border-gray-800">المنتج</th>
                    <th class="px-8 py-5 border-b dark:border-gray-800 text-center">المستودع</th>
                    <th class="px-8 py-5 border-b dark:border-gray-800 text-center">الكمية</th>
                    <th class="px-8 py-5 border-b dark:border-gray-800 text-center">سعر البيع</th>
                    <th class="px-8 py-5 border-b dark:border-gray-800 text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($products as $product)
                <tr class="hover:bg-gray-50/80 dark:hover:bg-[#020617]/40 transition-colors group">
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-white leading-tight">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400 font-mono mt-1">#PRD-{{ $product->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <span class="px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-bold">
                            {{ $product->store->name ?? 'غير محدد' }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <span class="font-bold {{ $product->quantity <= 5 ? 'text-rose-500' : 'text-gray-700 dark:text-gray-300' }}">
                            {{ $product->quantity }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center font-bold text-blue-600 dark:text-blue-400 font-mono">
                        {{ number_format($product->selling_price, 2) }} د.ج
                    </td>
                    <td class="px-8 py-5 text-left">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform group-hover:translate-x-0 translate-x-4">
                            <a href="{{ route('products.edit', $product->id) }}" class="p-2.5 rounded-xl bg-amber-500/10 text-amber-600 hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                           <form action="{{ route('products.delete', $product->id) }}" method="POST" class="delete-form inline">
    @csrf
    @method('DELETE')
    <button type="button" class="btn-delete p-2.5 rounded-xl bg-rose-500/10 text-rose-600 hover:bg-rose-500 hover:text-white transition-all shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
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
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 
    if(toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('translate-x-full');
            if (sidebar.classList.contains('translate-x-full')) {
                mainContent.classList.replace('mr-72', 'mr-0');
            } else {
                mainContent.classList.replace('mr-0', 'mr-72');
            }
        });
    }

    // 3. وظيفة التنبيهات الموحدة (تدعم الوضع الليلي)
    const fireStyledAlert = (config) => {
        const isDark = document.documentElement.classList.contains('dark');
        return Swal.fire({
            ...config,
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#1e293b',
            confirmButtonColor: config.icon === 'warning' ? '#e11d48' : '#2563eb',
            cancelButtonColor: isDark ? '#334155' : '#94a3b8',
            customClass: {
                popup: 'rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-2xl',
                confirmButton: 'rounded-xl px-8 py-3 font-bold',
                cancelButton: 'rounded-xl px-8 py-3 font-bold'
            }
        });
    };

    // 4. معالجة زر الحذف (مرة واحدة فقط لجميع الأزرار)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-delete')) {
            const button = e.target.closest('.btn-delete');
            const form = button.closest('form');
            
            fireStyledAlert({
                title: 'تأكيد الحذف',
                text: "هل أنت متأكد من حذف هذا المنتج نهائياً؟",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });

    // 5. رسائل النجاح من الجلسة (Session)
    @if(session('success'))
        fireStyledAlert({
            icon: 'success',
            title: 'تمت العملية بنجاح',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500
        });
    @endif
</script>
@endpush
