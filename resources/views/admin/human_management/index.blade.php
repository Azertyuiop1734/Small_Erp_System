<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-8 font-sans text-gray-800">

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm">
            <div>
                <h2 class="text-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-users-cog text-blue-600"></i> Worker Management
                </h2>
                <p class="text-gray-500 text-sm mt-1">Directory of all employees and their operational details</p>
            </div>
            <a href="{{ route('users.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl font-bold transition flex items-center gap-2 shadow-lg shadow-green-100">
                <i class="fas fa-plus text-xs"></i> Add New Worker
            </a>
        </div>

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false,
                    customClass: { popup: 'rounded-3xl' }
                });
            </script>
        @endif

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                    <tr>
                        <th class="p-4 border-b">Worker</th>
                        <th class="p-4 border-b">Warehouse</th>
                        <th class="p-4 border-b">Additional Info</th>
                        <th class="p-4 border-b">Financials</th>
                        <th class="p-4 border-b text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($workers as $worker)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $worker->image ? asset('storage/' . $worker->image) : 'https://ui-avatars.com/api/?name='.urlencode($worker->name).'&background=random' }}" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm ring-1 ring-gray-100">
                                <div>
                                    <div class="font-bold text-gray-800">{{ $worker->name }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $worker->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            <span class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-3 py-1 rounded-lg text-xs font-bold border border-blue-100">
                                <i class="fas fa-warehouse text-[10px]"></i> 
                                {{ $worker->warehouse->name ?? 'N/A' }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex flex-wrap gap-1 max-w-xs">
                                @php
                                    // تحويل النص المخزن Age: 25; Gender: Male... إلى مصفوفة لعرضها بشكل جميل
                                    $detailsArray = explode(';', $worker->details);
                                @endphp
                                @foreach($detailsArray as $detail)
                                    @if(trim($detail))
                                    <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[10px] font-medium border border-gray-200">
                                        {{ trim($detail) }}
                                    </span>
                                    @endif
                                @endforeach
                            </div>
                        </td>

                        <td class="p-4">
                            <div class="text-sm font-bold text-green-600">${{ number_format($worker->salary, 2) }}</div>
                            <div class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Hired: {{ $worker->hire_date }}</div>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('users.sales', $worker->id) }}" class="text-purple-600 hover:bg-purple-50 p-2 rounded-lg transition" title="View Sales">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                <a href="{{ route('users.edit', $worker->id) }}" class="text-blue-600 hover:bg-blue-50 p-2 rounded-lg transition" title="Edit Profile">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy', $worker->id) }}" method="POST" class="delete-form inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition" title="Delete Worker">
                                        <i class="fas fa-trash-alt"></i>
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

    <script>
        function confirmDelete(button) {
            const form = button.closest('.delete-form');
            Swal.fire({
                title: 'Are you sure?',
                text: "Removing this worker is permanent!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, remove them',
                customClass: { popup: 'rounded-3xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>