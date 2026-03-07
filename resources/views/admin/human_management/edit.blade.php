<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Worker: {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">

<div class="bg-white w-full max-w-4xl rounded-3xl shadow-xl overflow-hidden border border-gray-100">
    <div class="bg-blue-600 p-6 text-white flex justify-between items-center">
        <h2 class="text-2xl font-bold italic">Edit Profile: {{ $user->name }}</h2>
        <a href="{{ route('users.index') }}" class="text-white opacity-80 hover:opacity-100"><i class="fas fa-times text-xl"></i></a>
    </div>

    @php
        // تفكيك نص التفاصيل لاستخراج القيم الفردية
        // المتوقع: Age: 25; Gender: Male; Job: Dev; Phone: 123
        $details = $user->details ?? '';
        preg_match('/Age: (.*?);/', $details, $age);
        preg_match('/Gender: (.*?);/', $details, $gender);
        preg_match('/Job: (.*?);/', $details, $job);
        preg_match('/Phone: (.*)/', $details, $phone);
    @endphp

    <form id="editWorkerForm" method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" class="p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex flex-col items-center space-y-4">
                <div class="relative group w-40 h-40">
                    <img id="image-preview" 
                         src="{{ $user->image ? asset('storage/'.$user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
                         class="w-full h-full rounded-2xl object-cover border-4 border-blue-50 shadow-md">
                    <div class="absolute inset-0 bg-black/40 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <i class="fas fa-camera text-white text-2xl"></i>
                    </div>
                    <input type="file" name="image" id="image-input" class="absolute inset-0 opacity-0 cursor-pointer">
                </div>
                <p class="text-xs text-gray-400">Click to change photo</p>
            </div>

            <div class="md:col-span-2 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1">Age</label>
                        <input type="number" name="age" value="{{ trim($age[1] ?? '') }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1">Gender</label>
                        <select name="gender" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="Male" {{ (trim($gender[1] ?? '') == 'Male') ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ (trim($gender[1] ?? '') == 'Female') ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1">Phone</label>
                        <input type="text" name="phone" value="{{ trim($phone[1] ?? '') }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1">Job Title</label>
                        <input type="text" name="job_title" value="{{ trim($job[1] ?? '') }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1">Warehouse</label>
                        <select name="warehouse_id" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ $user->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1">Salary ($)</label>
                        <input type="number" name="salary" step="0.01" value="{{ old('salary', $user->salary) }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase ml-1">Hire Date</label>
                        <input type="date" name="hire_date" value="{{ old('hire_date', $user->hire_date) }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="pt-6 flex gap-3">
                    <button type="button" onclick="confirmUpdate()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-blue-100">
                        Update Information
                    </button>
                    <a href="{{ route('users.index') }}" class="px-8 py-3 bg-gray-100 text-gray-500 font-bold rounded-xl hover:bg-gray-200 transition">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // معاينة الصورة
    document.getElementById('image-input').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    function confirmUpdate() {
        Swal.fire({
            title: 'Save Changes?',
            text: "Employee data will be updated.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Yes, Update!',
            customClass: { popup: 'rounded-3xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('editWorkerForm').submit();
            }
        });
    }

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: '{!! implode("<br>", $errors->all()) !!}',
            confirmButtonColor: '#ef4444'
        });
    @endif
</script>

</body>
</html>