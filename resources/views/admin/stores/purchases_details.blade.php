<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Invoice Details - #{{ $purchase->id }}</title>
    <style>
        body { background-color: #04080f; color: #e5e7eb; font-family: 'Inter', sans-serif; }
        .card { background-color: #0a1120; border: 1px solid rgba(255,255,255,0.05); }
        .text-secondary { color: #94a3b8; }
        .accent-blue { color: #3b82f6; }
        .accent-green { color: #10b981; }
        @media print {
            .no-print { display: none; }
            body { background-color: white; color: black; }
            .card { border: 1px solid #eee; background: white; color: black; }
            .accent-blue, .accent-green { color: black !important; }
        }
    </style>
</head>
<body class="p-6">

    <header class="flex justify-between items-center mb-8 no-print">
        <div class="flex items-center gap-2">
            <div class="bg-blue-500 p-1.5 rounded-lg"><i class="fas fa-shopping-cart text-white text-sm"></i></div>
            <div>
                <h1 class="font-bold text-sm tracking-tighter leading-none">ERP SYSTEM</h1>
                <p class="text-[10px] text-gray-500 uppercase">Management</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-gray-400">Admin</span>
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold">A</div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        <div class="flex flex-wrap justify-between items-end mb-6 gap-4">
            <div class="space-y-4">
                <a href="{{ route('purchases.index') }}" class="no-print bg-[#161f32] text-xs px-4 py-2 rounded-lg border border-gray-700 hover:bg-gray-800 transition inline-block">
                    <i class="fas fa-chevron-left mr-2"></i> Back to Invoices
                </a>
                <div class="flex items-center gap-3">
                    <h2 class="text-3xl font-bold tracking-tight">Invoice Details</h2>
                    <span class="bg-blue-900/30 text-blue-400 text-xs px-3 py-1 rounded-full border border-blue-800/50">#{{ $purchase->id }}</span>
                    
                    @if($purchase->remaining_amount <= 0)
                        <span class="bg-green-900/30 text-green-400 text-xs px-3 py-1 rounded-full border border-green-800/50 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span> Paid
                        </span>
                    @else
                        <span class="bg-yellow-900/30 text-yellow-400 text-xs px-3 py-1 rounded-full border border-yellow-800/50 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span> Unpaid
                        </span>
                    @endif
                </div>
                <p class="text-gray-500 text-xs">Generated on {{ \Carbon\Carbon::parse($purchase->created_at)->format('M d, Y — h:i A') }}</p>
            </div>
            <div class="flex gap-3 no-print">
                <button onclick="window.print()" class="bg-[#161f32] text-sm px-5 py-2.5 rounded-xl border border-gray-700 flex items-center gap-2 hover:bg-gray-800 transition">
                    <i class="fas fa-print"></i> Print Invoice
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6 rounded-[1.5rem]">
                    <h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-6 border-b border-gray-800 pb-2">Information</h3>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase mb-1">Invoice Number</p>
                            <p class="accent-blue font-bold">#{{ $purchase->id }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase mb-1">Purchase Date</p>
                            <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('F d, Y') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-900/20 rounded-lg flex items-center justify-center text-blue-400">
                                <i class="far fa-user"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 uppercase">Supplier</p>
                                <p class="text-sm font-bold">{{ $purchase->supplier_name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-cyan-900/20 rounded-lg flex items-center justify-center text-cyan-400">
                                <i class="fas fa-warehouse text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 uppercase">Warehouse</p>
                                <p class="text-sm font-bold">{{ $purchase->warehouse_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card p-6 rounded-[1.5rem] overflow-x-auto">
                    <h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-6 border-b border-gray-800 pb-2">Items List</h3>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] text-gray-500 uppercase">
                                <th class="pb-4 font-medium">Product</th>
                                <th class="pb-4 font-medium">Barcode</th>
                                <th class="pb-4 font-medium text-center">Qty</th>
                                <th class="pb-4 font-medium">Price</th>
                                <th class="pb-4 font-medium">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($items as $item)
                            <tr class="border-t border-gray-800/50">
                                <td class="py-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-900/10 rounded-lg border border-blue-900/30 flex items-center justify-center text-blue-400">
                                        <i class="fas fa-cube text-xs"></i>
                                    </div>
                                    <p class="font-semibold">{{ $item->product_name }}</p>
                                </td>
                                <td class="text-gray-500">{{ $item->barcode }}</td>
                                <td class="text-center">
                                    <span class="bg-blue-900/40 px-2 py-1 rounded text-xs">{{ $item->quantity }}</span>
                                </td>
                                <td>{{ number_format($item->price, 2) }} DZD</td>
                                <td class="accent-green font-bold">{{ number_format($item->total, 2) }} DZD</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card p-6 rounded-[1.5rem]">
                    <h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-6 border-b border-gray-800 pb-2">Financial Summary</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Subtotal</span>
                            <span class="font-bold text-gray-200">{{ number_format($purchase->total_amount, 2) }} DZD</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-800 pb-4">
                            <span class="text-gray-400">Discount/Tax</span>
                            <span class="font-bold text-gray-200">0.00 DZD</span>
                        </div>
                        
                        <div class="flex justify-between items-center pt-2">
                            <span class="font-bold text-base text-blue-400">Grand Total</span>
                            <span class="text-xl font-bold">{{ number_format($purchase->total_amount, 2) }} DZD</span>
                        </div>

                        <div class="flex justify-between pt-4">
                            <span class="text-gray-400">Paid Amount</span>
                            <span class="font-bold text-green-500">{{ number_format($purchase->paid_amount, 2) }} DZD</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-400">Balance Due</span>
                            <span class="font-bold {{ $purchase->remaining_amount > 0 ? 'text-red-500' : 'text-gray-500' }}">
                                {{ number_format($purchase->remaining_amount, 2) }} DZD
                            </span>
                        </div>
                    </div>

                    @if($purchase->remaining_amount <= 0)
                        <button class="w-full mt-6 py-3 rounded-xl border border-green-900/30 bg-green-900/10 text-green-400 text-xs font-bold flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i> FULLY PAID
                        </button>
                    @else
                        <button class="w-full mt-6 py-3 rounded-xl border border-yellow-900/30 bg-yellow-900/10 text-yellow-400 text-xs font-bold flex items-center justify-center gap-2">
                            <i class="fas fa-exclamation-circle"></i> PENDING BALANCE
                        </button>
                    @endif
                </div>

                <div class="card p-6 rounded-[1.5rem]">
                    <h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-6 border-b border-gray-800 pb-2">System Log</h3>
                    <div class="relative space-y-8 before:absolute before:inset-0 before:ml-[13px] before:h-full before:w-0.5 before:bg-gray-800">
                        <div class="relative flex items-start gap-4">
                            <div class="relative z-10 w-7 h-7 bg-blue-900/40 rounded-full border border-blue-500/50 flex items-center justify-center text-[10px] text-blue-400">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold leading-none">Invoice Created</p>
                                <p class="text-[10px] text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($purchase->created_at)->toFormattedDateString() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>