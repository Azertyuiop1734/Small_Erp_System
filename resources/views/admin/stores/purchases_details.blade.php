<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Invoice Details - #{{ $purchase->id }}</title>
    <style>
        /* التعديل هنا للون الخلفية الأزرق الغامق */
        body { 
            background-color: #0B1426; /* أزرق غامق عميق */
            color: #e5e7eb; 
            font-family: 'Inter', sans-serif; 
        }
        /* تعديل الكروت لتتناسب مع الخلفية الجديدة */
        .card { 
            background-color: #152033; 
            border: 1px solid rgba(255,255,255,0.08); 
        }
        .text-secondary { color: #94a3b8; }
        .accent-blue { color: #3b82f6; }
        .accent-green { color: #10b981; }

        @media print {
            @page { margin: 0; }
            body { 
                background-color: white !important; 
                color: black !important; 
                width: 80mm; 
                margin: 0; 
                padding: 5mm; 
            }
            .no-print { display: none !important; }
            
            main { max-width: 100% !important; width: 100% !important; padding: 0 !important; margin: 0 !important; }
            
            .grid { display: block !important; } 
            .lg\:grid-cols-3, .grid-cols-2 { display: block !important; width: 100% !important; }
            .lg\:col-span-2 { width: 100% !important; }

            .card { 
                border: 1px solid #eee !important; 
                background: white !important; 
                color: black !important;
                padding: 10px !important;
                margin-bottom: 5mm !important;
                border-radius: 0 !important;
                width: 100% !important;
            }

            table { width: 100% !important; font-size: 10px !important; }
            th, td { border-bottom: 1px dashed #ccc !important; padding: 2mm 0 !important; color: black !important; }
            
            .bg-blue-900\/20, .bg-blue-500, .bg-cyan-900\/20, .bg-blue-900\/10, .bg-blue-900\/40 { 
                background: none !important; 
                color: black !important; 
                border: none !important;
            }
            
            .text-xl, .text-3xl { font-size: 16px !important; color: black !important; }
            .accent-blue, .accent-green, .text-blue-400, .text-green-400, .text-gray-200 { color: black !important; font-weight: bold; }
            .text-gray-500, .text-gray-400 { color: #333 !important; }

            .before\:bg-gray-800::before { background-color: #ccc !important; }
        }
    </style>
</head>
<body class="p-6">

    <header class="flex justify-between items-center mb-8 no-print">
        <div class="flex items-center gap-2">
            <div class="bg-blue-600 p-1.5 rounded-lg"><i class="fas fa-shopping-cart text-white text-sm"></i></div>
            <div>
                <h1 class="font-bold text-sm tracking-tighter leading-none">ERP SYSTEM</h1>
                <p class="text-[10px] text-gray-400 uppercase">Management</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-gray-400">Admin</span>
            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-xs font-bold text-white">A</div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto">
        <div class="flex flex-wrap justify-between items-end mb-6 gap-4 print:mb-2">
            <div class="space-y-4 print:space-y-1">
                <a href="{{ route('purchases.index') }}" class="no-print bg-[#1e293b] text-xs px-4 py-2 rounded-lg border border-gray-700 hover:bg-gray-800 transition inline-block text-white">
                    <i class="fas fa-chevron-left mr-2"></i> Back to Invoices
                </a>
                <div class="flex items-center gap-3 print:block">
                    <h2 class="text-3xl font-bold tracking-tight print:text-lg">Invoice Details</h2>
                    <span class="bg-blue-900/40 text-blue-300 text-xs px-3 py-1 rounded-full border border-blue-700/50 print:border-none print:p-0 print:text-black">#{{ $purchase->id }}</span>
                    
                    @if($purchase->remaining_amount <= 0)
                        <span class="bg-green-900/30 text-green-400 text-xs px-3 py-1 rounded-full border border-green-800/50 flex items-center gap-1 print:text-black no-print">
                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span> Paid
                        </span>
                    @else
                        <span class="bg-yellow-900/30 text-yellow-400 text-xs px-3 py-1 rounded-full border border-yellow-800/50 flex items-center gap-1 print:text-black no-print">
                            <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span> Unpaid
                        </span>
                    @endif
                </div>
                <p class="text-gray-400 text-xs print:text-black">Generated on {{ \Carbon\Carbon::parse($purchase->created_at)->format('M d, Y — h:i A') }}</p>
            </div>
            <div class="flex gap-3 no-print">
                <button onclick="window.print()" class="bg-blue-600 text-white text-sm px-5 py-2.5 rounded-xl border border-blue-500 flex items-center gap-2 hover:bg-blue-700 transition shadow-lg">
                    <i class="fas fa-print"></i> Print Invoice
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6 rounded-[1.5rem]">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-700 pb-2 print:border-black print:text-black">Information</h3>
                    <div class="grid grid-cols-2 gap-8 print:gap-2">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase mb-1 print:text-black">Invoice Number</p>
                            <p class="accent-blue font-bold print:text-black">#{{ $purchase->id }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase mb-1 print:text-black">Purchase Date</p>
                            <p class="text-sm font-semibold print:text-black">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('F d, Y') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-900/40 rounded-lg flex items-center justify-center text-blue-300 no-print border border-blue-800/50">
                                <i class="far fa-user"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase print:text-black">Supplier</p>
                                <p class="text-sm font-bold print:text-black">{{ $purchase->supplier_name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-cyan-900/40 rounded-lg flex items-center justify-center text-cyan-300 no-print border border-cyan-800/50">
                                <i class="fas fa-warehouse text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase print:text-black">Warehouse</p>
                                <p class="text-sm font-bold print:text-black">{{ $purchase->warehouse_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card p-6 rounded-[1.5rem] overflow-x-auto">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-700 pb-2 print:border-black print:text-black">Items List</h3>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] text-gray-400 uppercase print:text-black">
                                <th class="pb-4 font-medium">Product</th>
                                <th class="pb-4 font-medium no-print">Barcode</th>
                                <th class="pb-4 font-medium text-center">Qty</th>
                                <th class="pb-4 font-medium no-print">Price</th>
                                <th class="pb-4 font-medium text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($items as $item)
                            <tr class="border-t border-gray-700/50 print:border-black">
                                <td class="py-4 flex items-center gap-3 print:py-2">
                                    <div class="w-10 h-10 bg-blue-900/20 rounded-lg border border-blue-800/30 flex items-center justify-center text-blue-300 no-print">
                                        <i class="fas fa-cube text-xs"></i>
                                    </div>
                                    <p class="font-semibold print:text-xs">{{ $item->product_name }}</p>
                                </td>
                                <td class="text-gray-400 no-print">{{ $item->barcode }}</td>
                                <td class="text-center">
                                    <span class="bg-blue-900/40 px-2 py-1 rounded text-xs text-blue-200 print:bg-none print:text-black">{{ $item->quantity }}</span>
                                </td>
                                <td class="no-print text-gray-300">{{ number_format($item->price, 2) }}</td>
                                <td class="accent-green font-bold print:text-black text-right">{{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card p-6 rounded-[1.5rem]">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-700 pb-2 print:border-black print:text-black">Financial Summary</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400 print:text-black">Subtotal</span>
                            <span class="font-bold text-gray-200 print:text-black">{{ number_format($purchase->total_amount, 2) }} DZD</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-700 pb-4 print:border-black">
                            <span class="text-gray-400 print:text-black">Discount/Tax</span>
                            <span class="font-bold text-gray-200 print:text-black">0.00 DZD</span>
                        </div>
                        
                        <div class="flex justify-between items-center pt-2">
                            <span class="font-bold text-base text-blue-400 print:text-black">Grand Total</span>
                            <span class="text-xl font-bold text-white print:text-sm print:text-black">{{ number_format($purchase->total_amount, 2) }} DZD</span>
                        </div>

                        <div class="flex justify-between pt-4">
                            <span class="text-gray-400 print:text-black">Paid Amount</span>
                            <span class="font-bold text-green-500 print:text-black">{{ number_format($purchase->paid_amount, 2) }} DZD</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-400 print:text-black">Balance Due</span>
                            <span class="font-bold {{ $purchase->remaining_amount > 0 ? 'text-red-400' : 'text-gray-400' }} print:text-black">
                                {{ number_format($purchase->remaining_amount, 2) }} DZD
                            </span>
                        </div>
                    </div>

                    <div class="no-print">
                        @if($purchase->remaining_amount <= 0)
                            <button class="w-full mt-6 py-3 rounded-xl border border-green-800/50 bg-green-900/20 text-green-400 text-xs font-bold flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle"></i> FULLY PAID
                            </button>
                        @else
                            <button class="w-full mt-6 py-3 rounded-xl border border-yellow-800/50 bg-yellow-900/20 text-yellow-400 text-xs font-bold flex items-center justify-center gap-2">
                                <i class="fas fa-exclamation-circle"></i> PENDING BALANCE
                            </button>
                        @endif
                    </div>
                </div>

                <div class="card p-6 rounded-[1.5rem]">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-700 pb-2 print:border-black print:text-black">System Log</h3>
                    <div class="relative space-y-8 before:absolute before:inset-0 before:ml-[13px] before:h-full before:w-0.5 before:bg-gray-700 print:before:bg-gray-300">
                        <div class="relative flex items-start gap-4">
                            <div class="relative z-10 w-7 h-7 bg-blue-900/60 rounded-full border border-blue-500/50 flex items-center justify-center text-[10px] text-blue-300 print:bg-white print:text-black print:border-black">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold leading-none print:text-black">Invoice Created</p>
                                <p class="text-[10px] text-gray-400 mt-1 print:text-black">
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