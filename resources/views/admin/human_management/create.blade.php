@extends('layouts.app')

@section('title', 'إضافة موظف جديد')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white dark:bg-[#0f172a] rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl overflow-hidden transition-colors duration-300">
        
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 p-8 text-white flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold uppercase tracking-wider">تسجيل موظف جديد</h2>
                <p class="text-blue-100 mt-1 text-sm">يرجى إدخال البيانات المطلوبة لإنشاء حساب الموظف في النظام</p>
            </div>
            <div class="p-3 bg-white/10 rounded-2xl backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
        </div>

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                <div class="flex flex-col items-center space-y-4">
                    <label class="block text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest text-center w-full">الصورة الشخصية</label>
                    <div class="relative group">
                        <div class="w-56 h-56 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden bg-gray-50 dark:bg-[#020617] transition-all group-hover:border-blue-500 cursor-pointer shadow-inner">
                            <img id="image-preview" src="" class="w-full h-full object-cover hidden">
                            <div id="placeholder-icon" class="text-gray-400 flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px] font-bold tracking-widest uppercase">اضغط للرفع</span>
                            </div>
                        </div>
                        <input type="file" name="image" id="image-input" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                    </div>
                    <p class="text-[10px] text-gray-400 italic text-center">الحد الأقصى: 2 ميجابايت (JPG, PNG)</p>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">الاسم الكامل</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none placeholder-gray-400"
                                placeholder="علي محمد">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none placeholder-gray-400"
                                placeholder="example@test.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">كلمة المرور</label>
                            <input type="password" name="password" required
                                class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none"
                                placeholder="••••••••">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">رقم الهاتف</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none"
                                placeholder="+213 XXXXXXXX">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-5 bg-gray-50 dark:bg-[#020617]/50 rounded-2xl border border-gray-100 dark:border-gray-800">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400">العمر</label>
                            <input type="number" name="age" value="{{ old('age') }}" required
                                class="w-full bg-white dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-gray-900 dark:text-white transition outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400">الجنس</label>
                            <select name="gender" class="w-full bg-white dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-gray-900 dark:text-white transition outline-none appearance-none">
                                <option value="Male">ذكر</option>
                                <option value="Female">أنثى</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400">المسمى الوظيفي</label>
                            <input type="text" name="job_title" value="{{ old('job_title') }}" required
                                class="w-full bg-white dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 text-gray-900 dark:text-white transition outline-none"
                                placeholder="محاسب">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">المخزن</label>
                            <select name="warehouse_id" required
                                class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none appearance-none">
                                <option value="">اختر المخزن...</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">الراتب (د.ج)</label>
                            <input type="number" step="0.01" name="salary" value="{{ old('salary') }}"
                                class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none"
                                placeholder="0.00">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 ml-1">تاريخ التوظيف</label>
                            <input type="date" name="hire_date" value="{{ old('hire_date') }}"
                                class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none">
                        </div>
                    </div>

                    <div class="pt-6 flex justify-end gap-4 border-t border-gray-100 dark:border-gray-800">
                        <button type="reset" class="px-6 py-3 rounded-xl text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 font-bold transition">إعادة تعيين</button>
                        <button type="submit" 
                            class="px-10 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-600/20 transition-all transform hover:scale-[1.02] flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            إنشاء حساب الموظف
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function setupDropdown(btnId, menuId, arrowId) {
        const btn = document.getElementById(btnId);
        const menu = document.getElementById(menuId);
        const arrow = document.getElementById(arrowId);
        
        if(btn && menu) {
            btn.addEventListener('click', () => {
                const isOpen = menu.style.maxHeight !== '0px' && menu.style.maxHeight !== '';
                menu.style.maxHeight = isOpen ? '0px' : menu.scrollHeight + 'px';
                if(arrow) arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        }
    }

    // تفعيل كل القوائم
    setupDropdown('supplierBtn', 'supplierMenu', 'supplierArrow');
    setupDropdown('warehouseBtn', 'warehouseMenu', 'warehouseArrow');
    setupDropdown('employeeBtn', 'employeeMenu', 'employeeArrow');
    setupDropdown('purchasesBtn', 'purchasesMenu', 'purchasesArrow');
    setupDropdown('expensesBtn', 'expensesMenu', 'expensesArrow');

    // 2. وظيفة إغلاق وفتح السايد بار (Sidebar Toggle)
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
toggleBtn.addEventListener('click', () => {
    // إخفاء السايد بار بإزاحته لليمين خارج الشاشة
    sidebar.classList.toggle('translate-x-full');
    
    if (sidebar.classList.contains('translate-x-full')) {
        // توسيع المحتوى والناف بار ليأخذا كامل الشاشة
        mainContent.classList.replace('mr-72', 'mr-0');
    } else {
        // إعادة الهامش لحجز مكان للسايد بار
        mainContent.classList.replace('mr-0', 'mr-72');
    }
});

    // 3. تنبيه النجاح (SweetAlert)
    @if(session('success'))
        Swal.fire({
            title: 'تم الحفظ!',
            text: "{{ session('success') }}",
            icon: 'success',
            background: '#0f172a',
            color: '#fff',
            confirmButtonColor: '#2563eb'
        });
    @endif
    // 1. منطق معاينة الصورة الشخصية
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const placeholderIcon = document.getElementById('placeholder-icon');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                placeholderIcon.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // 2. إعدادات التنبيهات المتوافقة مع الـ Dark Mode
    const swalConfig = {
        background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#fff',
        color: document.documentElement.classList.contains('dark') ? '#fff' : '#000',
    };

    @if(session('success'))
        Swal.fire({
            ...swalConfig,
            icon: 'success',
            title: 'تمت العملية!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#2563eb'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            ...swalConfig,
            icon: 'error',
            title: 'خطأ في البيانات!',
            html: `<ul class="text-right text-sm text-rose-500">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                  </ul>`,
            confirmButtonColor: '#e11d48'
        });
    @endif
</script>
@endpush