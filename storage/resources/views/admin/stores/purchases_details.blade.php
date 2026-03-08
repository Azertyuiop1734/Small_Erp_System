<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<title>Invoice Details</title>

<style>
body{
background-color:#04080f;
color:#e5e7eb;
font-family:sans-serif;
}

.card{
background-color:#0a1120;
border:1px solid rgba(255,255,255,0.05);
}

.accent-blue{color:#3b82f6;}
.accent-green{color:#10b981;}
</style>

</head>

<body class="p-6">

<header class="flex justify-between items-center mb-8">

<div class="flex items-center gap-2">
<div class="bg-blue-500 p-1.5 rounded-lg">
<i class="fas fa-shopping-cart text-white text-sm"></i>
</div>

<div>
<h1 class="font-bold text-sm">ERP System</h1>
<p class="text-[10px] text-gray-500 uppercase">Management</p>
</div>
</div>

<div class="flex items-center gap-3">
<span class="text-xs text-gray-400">Admin</span>
<div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-xs font-bold">
A
</div>
</div>

</header>


<main class="max-w-7xl mx-auto">

<div class="flex flex-wrap justify-between items-end mb-6 gap-4">

<div class="space-y-4">

<a href="{{ route('purchases.index') }}"
class="bg-[#161f32] text-xs px-4 py-2 rounded-lg border border-gray-700 hover:bg-gray-800 transition">

<i class="fas fa-chevron-left mr-2"></i>
Back to Invoices

</a>

<div class="flex items-center gap-3">

<h2 class="text-3xl font-serif font-bold">
Invoice Details
</h2>

<span class="bg-blue-900/30 text-blue-400 text-xs px-3 py-1 rounded-full border border-blue-800/50">

# {{ $purchase->id }}

</span>

<span class="bg-green-900/30 text-green-400 text-xs px-3 py-1 rounded-full border border-green-800/50 flex items-center gap-1">

<span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>

Paid

</span>

</div>

<p class="text-gray-500 text-xs">

{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y/m/d') }}

</p>

</div>


<div class="flex gap-3">

<button onclick="window.print()"
class="bg-[#161f32] text-sm px-5 py-2.5 rounded-xl border border-gray-700 flex items-center gap-2">

<i class="fas fa-print"></i>
Print

</button>

</div>

</div>


<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


<div class="lg:col-span-2 space-y-6">


<div class="card p-6 rounded-[1.5rem]">

<h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-6 border-b border-gray-800 pb-2">

Invoice Information

</h3>

<div class="grid grid-cols-2 gap-8">

<div>
<p class="text-[10px] text-gray-500 uppercase mb-1">Invoice Number</p>
<p class="accent-blue font-bold">

# {{ $purchase->id }}

</p>
</div>

<div>
<p class="text-[10px] text-gray-500 uppercase mb-1">Purchase Date</p>

<p class="text-sm font-semibold">

{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y/m/d') }}

</p>

</div>


<div>
<p class="text-[10px] text-gray-500 uppercase">Supplier</p>

<p class="text-sm font-bold">

{{ $purchase->supplier_name }}

</p>

</div>


<div>
<p class="text-[10px] text-gray-500 uppercase">Receiving Warehouse</p>

<p class="text-sm font-bold">

{{ $purchase->warehouse_name }}

</p>

</div>

</div>

</div>



<div class="card p-6 rounded-[1.5rem]">

<h3 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-6 border-b border-gray-800 pb-2">

Purchased Products

</h3>


<table class="w-full text-left">

<thead>

<tr class="text-[10px] text-gray-500 uppercase">

<th class="pb-4">Product</th>
<th class="pb-4">Barcode</th>
<th class="pb-4 text-center">Qty</th>
<th class="pb-4">Unit Price</th>
<th class="pb-4">Total</th>

</tr>

</thead>


<tbody class="text-sm">

@foreach($items as $item)

<tr class="border-t border-gray-800/50">

<td class="py-4">

{{ $item->product_name }}

</td>

<td class="text-gray-500">

{{ $item->barcode }}

</td>

<td class="text-center">

{{ $item->quantity }}

</td>

<td>

{{ number_format($item->price,2) }} DZD

</td>

<td class="accent-green font-bold">

{{ number_format($item->total,2) }} DZD

</td>

</tr>

@endforeach

</tbody>

</table>


<div class="mt-6 pt-4 border-t border-gray-800 flex justify-end items-center gap-4">

<span class="text-gray-500 text-xs">

Invoice Total:

</span>

<span class="accent-green text-xl font-bold">

{{ number_format($purchase->total_amount,2) }} DZD

</span>

</div>

</div>

</div>

</div>

</main>

</body>
</html>