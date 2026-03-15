@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#04080f] p-6 text-gray-200">
    <div class="max-w-4xl mx-auto">
        <div class="bg-[#0a1120] border border-white/5 rounded-[1.5rem] p-8 shadow-xl">
            <h2 class="text-2xl font-bold mb-6 text-warning">تعديل بيانات الزبون: {{ $customer->name }}</h2>
            
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs text-gray-500 uppercase tracking-widest">اسم الزبون</label>
                        <input type="text" name="name" value="{{ $customer->name }}" required 
                               class="w-full bg-[#161f32] border border-gray-700 rounded-xl py-2.5 px-4 focus:border-blue-500 outline-none transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs text-gray-500 uppercase tracking-widest">رقم الهاتف</label>
                        <input type="text" name="phone" value="{{ $customer->phone }}" required 
                               class="w-full bg-[#161f32] border border-gray-700 rounded-xl py-2.5 px-4 focus:border-blue-500 outline-none transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs text-gray-500 uppercase tracking-widest">الرصيد (Balance)</label>
                        <input type="number" name="balance" value="{{ $customer->balance }}" step="0.01" 
                               class="w-full bg-[#161f32] border border-gray-700 rounded-xl py-2.5 px-4 focus:border-blue-500 outline-none transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs text-gray-500 uppercase tracking-widest">نسبة الخصم (Discount %)</label>
                        <input type="number" name="discount" value="{{ $customer->discount }}" step="0.01" 
                               class="w-full bg-[#161f32] border border-gray-700 rounded-xl py-2.5 px-4 focus:border-blue-500 outline-none transition">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs text-gray-500 uppercase tracking-widest">العنوان الكامل</label>
                        <textarea name="address" rows="3" 
                                  class="w-full bg-[#161f32] border border-gray-700 rounded-xl py-2.5 px-4 focus:border-blue-500 outline-none transition">{{ $customer->address }}</textarea>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-800 flex justify-end gap-3">
                    <a href="{{ route('customers.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-700 text-gray-400 hover:bg-gray-800 transition text-sm">إلغاء</a>
                    <button type="submit" class="px-8 py-2.5 rounded-xl bg-warning text-black font-bold hover:bg-yellow-500 transition shadow-lg shadow-yellow-500/10">
                        تحديث البيانات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // التحقق من رسالة التحديث
    @if(session('update_success'))
        Swal.fire({
            title: 'تم التحديث!',
            text: "{{ session('update_success') }}",
            icon: 'success',
            background: '#0a1120', // نفس لون تصميمك الداكن
            color: '#fff',
            confirmButtonColor: '#fbbf24', // لون أصفر/برتقالي يناسب زر التعديل
            confirmButtonText: 'موافق',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    // عرض أخطاء الإدخال إن وجدت (Validation Errors)
    @if($errors->any())
        Swal.fire({
            title: 'خطأ!',
            text: "{{ $errors->first() }}",
            icon: 'error',
            background: '#0a1120',
            color: '#fff',
            confirmButtonColor: '#ef4444'
        });
    @endif
</script>

<style>
    /* لتحسين شكل النافذة مع تصميمك المظلم */
    .swal2-popup {
        border-radius: 1.5rem !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
    }
</style>
@endsection