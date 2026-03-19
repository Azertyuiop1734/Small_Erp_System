<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Add New Worker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #0b1120; /* اللون الداكن من الكود الأول */
            color: #94a3b8;
        }
        .glass-card { 
            background: rgba(30, 41, 59, 0.7); 
            border: 1px solid rgba(255, 255, 255, 0.05); 
        }
        .gradient-header { 
            background: linear-gradient(90deg, #2563eb, #0891b2); 
        }
        .input-field { 
            @apply w-full px-4 py-2.5 rounded-xl border border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none bg-[#0f172a] text-white; 
        }
        .label-style { 
            @apply block text-sm font-semibold text-gray-400 mb-1.5 ml-1 italic; 
        }
        /* تحسين مظهر الـ select في الوضع الداكن */
        select.input-field option {
            background-color: #0f172a;
            color: white;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">

    <div class="glass-card w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden">
        <div class="gradient-header p-8 text-white flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold uppercase tracking-wider italic">Add New Worker</h2>
                <p class="text-blue-100 mt-1">Fill in the details to register a new employee</p>
            </div>
            <i class="fas fa-user-plus text-4xl opacity-50"></i>
        </div>

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="p-8 bg-[#0B1220]">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="flex flex-col items-center space-y-4">
                    <span class="label-style w-full text-center uppercase tracking-widest text-xs">Profile Picture</span>
                    <div class="relative group">
                        <div class="w-48 h-48 rounded-2xl border-2 border-dashed border-gray-600 flex items-center justify-center overflow-hidden bg-[#0f172a] transition-all group-hover:border-blue-500 cursor-pointer">
                            <img id="image-preview" src="" class="w-full h-full object-cover hidden">
                            <div id="placeholder-icon" class="text-gray-500 flex flex-col items-center">
                                <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                                <span class="text-[10px] font-bold tracking-widest uppercase">Upload Image</span>
                            </div>
                        </div>
                        <input type="file" name="image" id="image-input" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                    </div>
                    <p class="text-[10px] text-gray-500 italic text-center">Supported: JPG, PNG (Max 2MB)</p>
                </div>

                <div class="md:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label-style">Full Name</label>
                            <input type="text" name="name" class="input-field" value="{{ old('name') }}" placeholder="Ali Mohammed" required>
                        </div>
                        <div>
                            <label class="label-style">Email Address</label>
                            <input type="email" name="email" class="input-field" value="{{ old('email') }}" placeholder="admin@test.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label-style">Password</label>
                            <input type="password" name="password" class="input-field" placeholder="••••••••" required>
                        </div>
                        <div>
                            <label class="label-style">Phone Number</label>
                            <input type="text" name="phone" class="input-field" value="{{ old('phone') }}" placeholder="+213 5XX XX XX XX" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-[#0f172a]/50 p-4 rounded-2xl border border-gray-800">
                        <div>
                            <label class="label-style text-xs">Age</label>
                            <input type="number" name="age" class="input-field" value="{{ old('age') }}" placeholder="25" required>
                        </div>
                        <div>
                            <label class="label-style text-xs">Gender</label>
                            <select name="gender" class="input-field">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="label-style text-xs">Job Title</label>
                            <input type="text" name="job_title" class="input-field" value="{{ old('job_title') }}" placeholder="Accountant" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="label-style">Warehouse</label>
                            <select name="warehouse_id" class="input-field" required>
                                <option value="">Select...</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label-style">Salary (DZD)</label>
                            <input type="number" step="0.01" name="salary" class="input-field" value="{{ old('salary') }}" placeholder="0.00">
                        </div>
                        <div>
                            <label class="label-style">Hire Date</label>
                            <input type="date" name="hire_date" class="input-field" value="{{ old('hire_date') }}">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="reset" class="px-6 py-2.5 rounded-xl text-gray-500 hover:text-gray-300 font-bold transition">Reset</button>
                        <button type="submit" class="px-10 py-2.5 gradient-header text-white rounded-xl font-bold shadow-lg transition-all transform hover:scale-105 flex items-center gap-2">
                            <i class="fas fa-check"></i> Create Worker
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Image Preview Logic
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

        // Flash Messages with SweetAlert2 (Laravel Integration)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Done!',
                text: "{{ session('success') }}",
                background: '#1e293b',
                color: '#fff',
                confirmButtonColor: '#2563eb',
                customClass: { popup: 'rounded-3xl border border-gray-700' }
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                background: '#1e293b',
                color: '#fff',
                html: `<ul class="text-left text-sm text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                      </ul>`,
                confirmButtonColor: '#ef4444',
                customClass: { popup: 'rounded-3xl border border-gray-700' }
            });
        @endif
    </script>
</body>
</html>