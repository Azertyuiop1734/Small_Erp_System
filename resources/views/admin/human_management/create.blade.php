<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Worker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .input-field { @apply w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none bg-gray-50; }
        .label-style { @apply block text-sm font-semibold text-gray-700 mb-1.5 ml-1; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white w-full max-w-4xl rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-blue-600 p-8 text-white flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold uppercase tracking-tight">Add New Worker</h2>
                <p class="text-blue-100 mt-1">Fill in the details to register a new employee</p>
            </div>
            <i class="fas fa-user-plus text-4xl opacity-20"></i>
        </div>

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="flex flex-col items-center space-y-4">
                    <span class="label-style w-full text-center">Profile Picture</span>
                    <div class="relative group">
                        <div class="w-48 h-48 rounded-2xl border-4 border-dashed border-gray-200 flex items-center justify-center overflow-hidden bg-gray-50 transition-all group-hover:border-blue-400">
                            <img id="image-preview" src="https://ui-avatars.com/api/?name=User&background=f1f5f9&color=cbd5e1&size=200" class="w-full h-full object-cover hidden">
                            <div id="placeholder-icon" class="text-gray-300 flex flex-col items-center">
                                <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                                <span class="text-xs uppercase font-bold tracking-widest">Upload Image</span>
                            </div>
                        </div>
                        <input type="file" name="image" id="image-input" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                    </div>
                    <p class="text-xs text-gray-400 italic text-center">Supported: JPG, PNG (Max 2MB)</p>
                </div>

                <div class="md:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label-style italic">Full Name</label>
                            <input type="text" name="name" class="input-field" value="{{ old('name') }}" placeholder="John Doe" required>
                        </div>
                        <div>
                            <label class="label-style italic">Email Address</label>
                            <input type="email" name="email" class="input-field" value="{{ old('email') }}" placeholder="john@example.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="label-style italic">Password</label>
                            <input type="password" name="password" class="input-field" placeholder="••••••••" required>
                        </div>
                        <div>
                            <label class="label-style italic">Phone Number</label>
                            <input type="text" name="phone" class="input-field" value="{{ old('phone') }}" placeholder="+123..." required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <div>
                            <label class="label-style italic text-xs">Age</label>
                            <input type="number" name="age" class="input-field bg-white" value="{{ old('age') }}" placeholder="25" required>
                        </div>
                        <div>
                            <label class="label-style italic text-xs text-gray-600">Gender</label>
                            <select name="gender" class="input-field bg-white">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="label-style italic text-xs">Job Title</label>
                            <input type="text" name="job_title" class="input-field bg-white" value="{{ old('job_title') }}" placeholder="Accountant" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-1">
                            <label class="label-style italic">Warehouse</label>
                            <select name="warehouse_id" class="input-field" required>
                                <option value="">Select...</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label-style italic">Salary ($)</label>
                            <input type="number" step="0.01" name="salary" class="input-field" value="{{ old('salary') }}" placeholder="0.00">
                        </div>
                        <div>
                            <label class="label-style italic">Hire Date</label>
                            <input type="date" name="hire_date" class="input-field" value="{{ old('hire_date') }}">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="reset" class="px-6 py-2.5 rounded-xl text-gray-400 hover:text-gray-600 font-bold transition">Reset</button>
                        <button type="submit" class="px-10 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
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

        // Flash Messages with SweetAlert2
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Done!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2563eb',
                customClass: { popup: 'rounded-3xl' }
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `<ul class="text-left text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                      </ul>`,
                confirmButtonColor: '#ef4444',
                customClass: { popup: 'rounded-3xl' }
            });
        @endif
    </script>
</body>
</html>