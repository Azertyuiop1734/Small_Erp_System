@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#04080f] p-6 text-gray-200">
    <div class="max-w-4xl mx-auto">
        <div class="bg-[#0a1120] border border-white/5 rounded-[1.5rem] p-8 shadow-xl">
            <h2 class="text-2xl font-bold mb-6">إضافة زبون جديد</h2>
            
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs text-gray-500 uppercase">اسم الزبون</label>
                        <input type="text" name="name" required class="w-full bg-[#161f32] border border-gray-700 rounded-xl py-2 px-4 focus:border-blue-500 outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs text-gray-500 uppercase">رقم الهاتف</label>
                        <input type="text" name="phone" required class="w-full bg-[#161f32] border border-gray-700 rounded-xl py-2 px-4 focus:border-blue-500 outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs text-gray-500 uppercase">الرصيد الافتتاحي (Balance)</label>
                        <input type="number" name="balance" value="0.00" step="0.01" class="w-full bg-[#161f32] border border-gray-700 rounded-xl py-2 px-4 focus:border-blue-500 outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs text-gray-500 uppercase">نسبة الخصم (Discount)</label>
                        <input type="number" name="discount" value="0.00" step="0.01" class="w-full bg-[#161f32] border border-gray-700 rounded-xl py-2 px-4 focus:border-blue-500 outline-none">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs text-gray-500 uppercase">العنوان</label>
                        <textarea name="address" rows="2" class="w-full bg-[#161f32] border border-gray-700 rounded-xl py-2 px-4 focus:border-blue-500 outline-none"></textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-2 rounded-xl font-bold transition shadow-lg shadow-blue-500/20">
                        حفظ الزبون
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'تمت العملية',
            text: "{{ session('success') }}",
            background: '#0a1120',
            color: '#fff',
            confirmButtonColor: '#2563eb',
            timer: 2500
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'خطأ في البيانات',
            text: "{{ $errors->first() }}",
            background: '#0a1120',
            color: '#fff',
            confirmButtonColor: '#ef4444'
        });
    @endif
</script>
@endsection