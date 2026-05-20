<!DOCTYPE html>
<html lang="en" dir="ltr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Worker: {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        darkBg: '#0f172a',
                        darkCard: 'rgba(30, 41, 59, 0.7)',
                    },
                    animation: {
                        blob: "blob 7s infinite",
                    },
                    keyframes: {
                        blob: {
                            "0%": { transform: "translate(0px, 0px) scale(1)" },
                            "33%": { transform: "translate(30px, -50px) scale(1.1)" },
                            "66%": { transform: "translate(-20px, 20px) scale(0.9)" },
                            "100%": { transform: "translate(0px, 0px) scale(1)" },
                        },
                    },
                }
            }
        }
        
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.4s ease; }
        
        .glass-card { 
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px);
        }
        .dark .glass-card { 
            background: rgba(30, 41, 59, 0.7); 
            border-color: rgba(255, 255, 255, 0.08);
        }

        .input-focus { transition: all 0.3s ease; }
        .input-focus:focus { transform: translateY(-2px); box-shadow: 0 10px 20px -10px rgba(37, 99, 235, 0.1); }

        .swal2-popup { font-family: 'Plus Jakarta Sans', sans-serif !important; }
    </style>
</head>

<body class="bg-[#f8fafc] dark:bg-darkBg min-h-screen flex items-center justify-center p-4 md:p-8 relative overflow-x-hidden">

<div class="fixed top-6 right-6 z-50">
         <button id="theme-toggle" type="button"  class="w-14 h-14 flex items-center justify-center rounded-2xl bg-white/90 dark:bg-slate-800/90 shadow-xl border border-gray-200 dark:border-slate-700 transition-all hover:scale-110 active:scale-95 group backdrop-blur-sm">
            <i id="theme-icon" class="fas fa-moon text-xl text-indigo-500 group-hover:rotate-12 transition-transform"></i>
        </button>
    </div>
    <div class="absolute inset-0 z-0 opacity-40 dark:opacity-20 pointer-events-none">
        <div class="absolute top-10 left-10 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <div class="glass-card z-10 w-full max-w-5xl rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.1)] overflow-hidden border border-white/50 relative">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-600 p-8 text-white flex justify-between items-center relative">
            <div class="relative z-10">
                <nav class="text-blue-100 text-xs font-bold uppercase tracking-widest mb-2 flex items-center gap-2">
                    <i class="fas fa-user-edit"></i> Management System
                </nav>
                
                <h2 class="text-3xl font-extrabold tracking-tight">Edit Profile: <span class="font-light opacity-90">{{ $user->name }}</span></h2>
            </div>
            
            <a href="{{ route('users.index') }}" class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white/10 hover:bg-white/20 transition-all backdrop-blur-md">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>

        @php
            $details = $user->details ?? '';
            preg_match('/Age: (.*?);/', $details, $age);
            preg_match('/Gender: (.*?);/', $details, $gender);
            preg_match('/Job: (.*?);/', $details, $job);
            preg_match('/Phone: (.*)/', $details, $phone);
        @endphp

        <form id="editWorkerForm" method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" class="p-8 md:p-12">
            @csrf
            @method('PUT')

            <div class="flex flex-col lg:flex-row gap-12">
                <div class="flex flex-col items-center space-y-6 lg:w-48">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-tr from-blue-600 to-purple-500 rounded-[2.2rem] blur opacity-25 group-hover:opacity-60 transition duration-500"></div>
                        <div class="relative w-48 h-48 bg-white dark:bg-slate-800 rounded-[2rem] p-2 border border-gray-100 dark:border-slate-700 shadow-inner">
                            <img id="image-preview" 
                                 src="{{ $user->image ? asset('storage/'.$user->image) : 'https://ui-avatars.com/api/?background=random&name='.urlencode($user->name) }}" 
                                 class="w-full h-full rounded-[1.8rem] object-cover">
                            <label for="image-input" class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-[1.8rem] opacity-0 group-hover:opacity-100 transition-all duration-300 cursor-pointer backdrop-blur-sm">
                                <div class="bg-white/20 p-4 rounded-full border border-white/30 text-white hover:scale-110 transition-transform">
                                    <i class="fas fa-camera text-2xl"></i>
                                </div>
                            </label>
                            <input type="file" name="image" id="image-input" class="hidden">
                        </div>
                    </div>
                    <span class="px-4 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold rounded-full uppercase">ID: #{{ $user->id }}</span>
                </div>

                <div class="flex-1 space-y-8">
                    <div class="space-y-4">
                        <h3 class="flex items-center gap-2 text-gray-800 dark:text-gray-100 font-bold text-sm">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center"><i class="fas fa-user text-xs"></i></span>
                            Personal Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input-focus w-full px-5 py-3.5 rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 outline-none focus:bg-white dark:focus:bg-slate-800 focus:border-blue-500 text-gray-700 dark:text-gray-200" placeholder="John Doe">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="input-focus w-full px-5 py-3.5 rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 outline-none focus:bg-white dark:focus:bg-slate-800 focus:border-blue-500 text-gray-700 dark:text-gray-200" placeholder="email@company.com">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Age</label>
                            <input type="number" name="age" value="{{ trim($age[1] ?? '') }}" class="input-focus w-full px-5 py-3.5 rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 outline-none dark:text-gray-200 focus:border-blue-500" placeholder="25">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Gender</label>
                            <div class="relative">
                                <select name="gender" class="input-focus w-full px-5 py-3.5 rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 outline-none dark:text-gray-200 focus:border-blue-500 appearance-none cursor-pointer">
                                    <option value="Male" {{ (trim($gender[1] ?? '') == 'Male') ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ (trim($gender[1] ?? '') == 'Female') ? 'selected' : '' }}>Female</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1 flex justify-between">
                                Phone Number
                                <span id="status_icon"><i class="fas fa-circle-info text-gray-300"></i></span>
                            </label>
                            <input type="text" id="phone_input" name="phone" value="{{ old('phone', trim($phone[1] ?? '')) }}" placeholder="0XXXXXXXXX" maxlength="10" class="input-focus w-full px-5 py-3.5 rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 outline-none dark:text-gray-200 focus:border-blue-500 font-bold tracking-wider" dir="ltr">
                            <div id="phone_error_msg" class="hidden flex items-center gap-2 mt-2 px-3 py-1.5 bg-red-500/10 border border-red-500/20 rounded-xl">
                                <i class="fas fa-exclamation-triangle text-red-500 text-[10px]"></i>
                                <p class="text-red-500 text-[10px] font-bold uppercase tracking-tighter">Starts with 0, total 10 digits</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 space-y-4">
                        <h3 class="flex items-center gap-2 text-gray-800 dark:text-gray-100 font-bold text-sm">
                            <span class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center"><i class="fas fa-briefcase text-xs"></i></span>
                            Professional Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Job Title</label>
                                <div class="relative">
                                    <i class="fas fa-id-badge absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" name="job_title" value="{{ trim($job[1] ?? '') }}" class="input-focus w-full pl-12 pr-5 py-3.5 rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 outline-none dark:text-gray-200 focus:border-blue-500" placeholder="e.g. Manager">
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Monthly Salary ($)</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 font-bold">$</span>
                                    <input type="number" step="0.01" name="salary" value="{{ old('salary', $user->salary) }}" class="input-focus w-full pl-10 pr-5 py-3.5 rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 outline-none dark:text-gray-200 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Hire Date</label>
                                <input type="date" name="hire_date" value="{{ old('hire_date', $user->hire_date) }}" class="input-focus w-full px-5 py-3.5 rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 outline-none dark:text-gray-200 focus:border-blue-500">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest ml-1">Warehouse Assignment</label>
                                <div class="relative">
                                    <select name="warehouse_id" class="input-focus w-full px-5 py-3.5 rounded-2xl border border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 outline-none dark:text-gray-200 focus:border-blue-500 appearance-none cursor-pointer">
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ $user->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-warehouse absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 flex flex-col sm:flex-row gap-4 border-t border-gray-100 dark:border-slate-700/50">
                        <button type="button" id="submit_btn" onclick="confirmUpdate()" class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-3 active:scale-95 group">
                            <i class="fas fa-save group-hover:animate-pulse"></i> Save Changes
                        </button>
                        <a href="{{ route('users.index') }}" class="flex-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-500 dark:text-gray-400 font-bold py-4 rounded-2xl hover:bg-gray-50 dark:hover:bg-slate-700 transition-all text-center flex items-center justify-center gap-2">
                             Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // --- Theme Management ---
     const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    function updateIcons() {
        if (document.documentElement.classList.contains('dark')) {
            lightIcon.classList.remove('hidden');
            darkIcon.classList.add('hidden');
        } else {
            darkIcon.classList.remove('hidden');
            lightIcon.classList.add('hidden');
        }
    }

    themeToggleBtn.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        updateIcons();
    });

    updateIcons();

        // --- Image Preview ---
        document.getElementById('image-input').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                const preview = document.getElementById('image-preview');
                reader.onload = e => {
                    preview.style.opacity = 0;
                    setTimeout(() => { preview.src = e.target.result; preview.style.opacity = 1; }, 200);
                };
                reader.readAsDataURL(file);
            }
        });

        // --- Phone Validation ---
        const phoneInput = document.getElementById('phone_input');
        const errorMsg = document.getElementById('phone_error_msg');
        const statusIcon = document.getElementById('status_icon');
        const submitBtn = document.getElementById('submit_btn');

        function validatePhone() {
            let val = phoneInput.value.replace(/[^0-9]/g, '');
            phoneInput.value = val;
            const isValid = val.startsWith('0') && val.length === 10;

            phoneInput.classList.remove('border-green-500', 'border-red-500');
            
            if (val.length === 0) {
                statusIcon.innerHTML = '<i class="fas fa-circle-info text-gray-300"></i>';
                errorMsg.classList.add('hidden');
            } else if (isValid) {
                statusIcon.innerHTML = '<i class="fas fa-check-circle text-green-500 animate-pulse"></i>';
                phoneInput.classList.add('border-green-500');
                errorMsg.classList.add('hidden');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                statusIcon.innerHTML = '<i class="fas fa-times-circle text-red-500"></i>';
                phoneInput.classList.add('border-red-500');
                errorMsg.classList.remove('hidden');
                // اختياري: تعطيل الزر إذا كان الرقم خطأ
                // submitBtn.disabled = true;
                // submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
        phoneInput.addEventListener('input', validatePhone);
        window.addEventListener('load', validatePhone);

        // --- SweetAlert Management ---
        function confirmUpdate() {
            const isDark = document.documentElement.classList.contains('dark');
            Swal.fire({
                title: 'حفظ التعديلات؟',
                text: "سيتم تطبيق التعديلات الجديدة على ملف الموظف فوراً.",
                icon: 'question',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-[2.5rem] p-10 shadow-2xl border border-gray-100 dark:border-slate-700',
                    title: 'text-2xl text-gray-800 dark:text-gray-50 font-bold',
                    htmlContainer: 'text-gray-600 dark:text-gray-400 text-base mt-3',
                    confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-blue-500/20 active:scale-95 mx-2',
                    cancelButton: 'bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-600 dark:text-gray-300 font-bold py-3.5 px-8 rounded-xl transition-all mx-2'
                },
                background: isDark ? '#1e293b' : '#ffffff',
                iconColor: isDark ? '#818cf8' : '#3b82f6',
                confirmButtonText: '<i class="fas fa-check-circle mr-2"></i>نعم، حفظ',
                cancelButtonText: 'مراجعة',
                showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' },
                hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'جاري الحفظ...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); },
                        customClass: { popup: 'rounded-[2rem] p-10 bg-white dark:bg-slate-800' },
                        background: isDark ? '#1e293b' : '#ffffff',
                    });
                    document.getElementById('editWorkerForm').submit();
                }
            });
        }
    </script>
</body>
</html>