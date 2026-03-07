<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Management</title>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 p-8 font-sans text-gray-800">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm">
            <div>
                <h2 class="text-2xl font-bold flex items-center gap-3">
                    <i class="fas fa-file-alt text-blue-500"></i> General Reports Log
                </h2>
                <p class="text-gray-500 text-sm mt-1">Manage and view all employee submissions</p>
            </div>
           
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                    <tr>
                        <th class="p-4 border-b">ID</th>
                        <th class="p-4 border-b">Employee</th>
                        <th class="p-4 border-b">Warehouse</th>
                        <th class="p-4 border-b">Title</th>
                        <th class="p-4 border-b">Date</th>
                        <th class="p-4 border-b text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($reports as $report)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-mono text-gray-400 text-sm">#{{ $report->id }}</td>
                        
                        <td class="p-4">
                            <span class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-bold">
                                <i class="fas fa-user text-[10px]"></i> {{ $report->user->name }}
                            </span>
                        </td>

                        <td class="p-4 text-sm font-medium text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-warehouse text-orange-400"></i>
                                {{ $report->user->warehouse->name ?? 'Unassigned' }}
                            </div>
                        </td>

                        <td class="p-4 font-medium text-gray-700">{{ $report->title }}</td>

                        <td class="p-4 text-sm text-gray-500">
                            {{ $report->report_date }}
                        </td>
                        
                       <td class="p-4 text-center">
    <div class="flex items-center justify-center gap-2">
        <button onclick="viewFullReport('{{ $report->title }}', '{{ addslashes($report->description) }}', '{{ $report->user->name }}', '{{ $report->user->warehouse->name ?? 'N/A' }}')" 
                class="text-green-600 hover:text-green-700 font-semibold text-sm flex items-center gap-1 transition bg-green-50 px-3 py-1.5 rounded-lg hover:bg-green-100">
            <i class="fas fa-eye text-xs"></i> View
        </button>

        <form id="delete-form-{{ $report->id }}" action="{{ route('reports.destroy', $report->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="button" onclick="confirmDelete({{ $report->id }})" 
                    class="text-red-600 hover:text-red-700 font-semibold text-sm flex items-center gap-1 transition bg-red-50 px-3 py-1.5 rounded-lg hover:bg-red-100">
                <i class="fas fa-trash-alt text-xs"></i> Delete
            </button>
        </form>
    </div>
</td>

<script>
    // Confirmation for Delete
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This report will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Tailwind red-500
            cancelButtonColor: '#6b7280',  // Tailwind gray-500
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                popup: 'rounded-3xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function viewFullReport(title, desc, user, warehouse) {
            Swal.fire({
                title: `<span class="text-blue-600 font-bold">${title}</span>`,
                html: `
                    <div class="text-left mt-4">
                        <div class="flex flex-col gap-1 mb-4 text-sm text-gray-500 bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-circle text-blue-400"></i>
                                <span>Employee: <strong>${user}</strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-warehouse text-orange-400"></i>
                                <span>Warehouse: <strong>${warehouse}</strong></span>
                            </div>
                        </div>
                        <div class="bg-white p-5 rounded-xl border-l-4 border-green-500 text-gray-700 leading-relaxed shadow-sm ring-1 ring-gray-100">
                            ${desc}
                        </div>
                    </div>
                `,
                showCloseButton: true,
                confirmButtonText: 'Close',
                confirmButtonColor: '#2563eb',
                customClass: {
                    popup: 'rounded-3xl'
                },
                width: '600px'
            });
        }
    </script>

</body>
</html>