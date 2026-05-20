@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in pb-12">
    
    @php
        $detailsArray = [];
        if($user->details) {
            $parts = explode(';', $user->details);
            foreach($parts as $part) {
                $item = explode(':', $part);
                if(count($item) == 2) {
                    $detailsArray[trim($item[0])] = trim($item[1]);
                }
            }
        }
        $isAdmin = optional($user->role)->role_name === 'Admin';
    @endphp

    <div class="relative overflow-hidden bg-white dark:bg-[#0a1120] p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-2xl">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="relative flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight">الملف الشخصي</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">إدارة بياناتك الشخصية وإعدادات الحساب</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold transition-all shadow-lg shadow-blue-500/25 flex items-center">
                <i class="fas fa-edit ml-2"></i> تعديل البيانات
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white dark:bg-[#0a1120] p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-xl text-center">
                <div class="relative inline-block group">
                    <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=3b82f6&color=fff' }}" 
                         class="w-40 h-40 rounded-[2.5rem] object-cover border-4 border-blue-500/20 p-1 shadow-2xl group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute bottom-2 left-2 w-6 h-6 bg-green-500 border-4 border-white dark:border-[#0a1120] rounded-full"></span>
                </div>
                
                <h2 class="mt-6 text-2xl font-black text-gray-800 dark:text-white">{{ $user->name }}</h2>
                <p class="text-blue-600 dark:text-blue-400 font-bold tracking-widest uppercase text-sm mt-1">
                    {{ $isAdmin ? 'مسؤول النظام' : ($user->role->name ?? 'موظف') }}
                </p>

                <div class="mt-8 pt-8 border-t border-gray-100 dark:border-white/5 space-y-4 text-right" dir="rtl">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold text-xs uppercase">المستودع</span>
                        <span class="text-gray-800 dark:text-white font-black text-sm">{{ $user->warehouse->name ?? 'غير محدد' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold text-xs uppercase">تاريخ التعيين</span>
                        <span class="text-gray-800 dark:text-white font-black text-sm">{{ $user->hire_date ?? '---' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-[#0a1120] p-10 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-xl">
                <h3 class="text-gray-800 dark:text-white font-black text-xl mb-8 flex items-center">
                    <i class="fas fa-info-circle ml-3 text-blue-500"></i> المعلومات الأساسية
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-6 bg-gray-50 dark:bg-white/5 rounded-3xl border border-gray-100 dark:border-white/5 transition-hover">
                        <label class="text-gray-400 font-bold text-xs uppercase block mb-1">البريد الإلكتروني</label>
                        <span class="text-gray-800 dark:text-white font-black">{{ $user->email }}</span>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-white/5 rounded-3xl border border-gray-100 dark:border-white/5 transition-hover">
                        <label class="text-gray-400 font-bold text-xs uppercase block mb-1">الراتب الشهري</label>
                        <span class="text-green-500 font-black fs-5">{{ number_format($user->salary, 2) }} DA</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                    @foreach(['Age' => ['العمر', 'birthday-cake', 'warning'], 'Gender' => ['الجنس', 'venus-mars', 'info'], 'Job' => ['الوظيفة', 'user-tag', 'secondary'], 'Phone' => ['الهاتف', 'phone-alt', 'success']] as $key => $meta)
                    <div class="p-4 rounded-3xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 text-center transition-hover">
                        <i class="fas fa-{{ $meta[1] }} text-{{ $meta[2] }} mb-2 text-lg"></i>
                        <label class="text-gray-400 font-bold text-[10px] uppercase block">{{ $meta[0] }}</label>
                        <span class="text-gray-800 dark:text-white font-black text-sm">{{ $detailsArray[$key] ?? 'N/A' }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-10 p-6 bg-blue-600/5 rounded-3xl border-r-4 border-blue-600">
                    <label class="text-blue-600 dark:text-blue-400 font-black text-xs uppercase mb-1 block">عن الحساب</label>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        هذا الحساب موثق لصالح <strong>{{ $user->name }}</strong>. 
                        يعمل حالياً في فرع <strong>{{ $user->warehouse->name ?? 'الرئيسي' }}</strong> بصلاحيات <strong>{{ $isAdmin ? 'مسؤول' : 'موظف' }}</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .transition-hover:hover { transform: translateY(-3px); transition: all 0.3s ease; }
</style>
@endsection
