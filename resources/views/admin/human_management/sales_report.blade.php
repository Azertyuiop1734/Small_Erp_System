<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ $worker->name }} - Sales Report</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 p-8 font-sans">

<div class="max-w-7xl mx-auto">

<h2 class="text-2xl font-bold mb-6">📊 Sales Performance : {{ $worker->name }}</h2>

<div class="grid md:grid-cols-3 gap-5 mb-8">

@php
$stats=[
['title'=>'Total Invoices','value'=>$totalSalesCount,'color'=>'border-blue-500'],
['title'=>'Total Revenue', 'value'=>number_format($totalRevenue,2).' $','color'=>'border-green-500'],
['title'=>'Total Profit', 'value'=>number_format($totalProfit,2).' $','color'=>'border-orange-500'],
];
@endphp

@foreach($stats as $s)
<div class="bg-white p-5 rounded-xl shadow border-l-4 {{ $s['color'] }}">
<h4 class="text-sm text-gray-500">{{ $s['title'] }}</h4>
<p class="text-2xl font-bold mt-2">{{ $s['value'] }}</p>
</div>
@endforeach

</div>

<table class="w-full bg-white rounded-xl overflow-hidden shadow">
<thead class="bg-gray-100 text-left text-sm">
<tr>
<th class="p-4">Invoice</th>
<th>Date</th>
<th>Amount</th>
<th>Status</th>
<th>Details</th>
</tr>
</thead>

<tbody>

@foreach($sales as $sale)

@php
$items=$sale->saleItems->map(fn($item)=>[
"name"=>$item->product->name ?? "Unknown",
"qty"=>$item->quantity,
"price"=>number_format($item->price,2),
"total"=>number_format($item->total,2)
]);
@endphp

<tr class="border-t hover:bg-gray-50 transition">

<td class="p-4">#{{ $sale->invoice_number }}</td>
<td>{{ $sale->sale_date }}</td>
<td>{{ number_format($sale->total_amount,2) }} $</td>

<td>
<span class="px-3 py-1 text-xs rounded-full font-bold 
{{ $sale->status=='completed' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-500' }}">
{{ ucfirst($sale->status) }}
</span>
</td>

<td>
<button
class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded viewDetails"
data-items='@json($items)'
>
View
</button>
</td>

</tr>

@endforeach

</tbody>
</table>

</div>
<div id="saleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">

<div class="bg-white p-6 rounded-xl w-[500px]">

<h2 class="text-xl font-bold mb-4">Sale Details</h2>

<table class="w-full text-sm">
<thead>
<tr>
<th class="text-left">Product</th>
<th>Qty</th>
<th>Price</th>
<th>Total</th>
</tr>
</thead>

<tbody id="modalBody"></tbody>

</table>

<button onclick="closeModal()"
class="mt-5 bg-red-500 text-white px-4 py-2 rounded">
Close
</button>

</div>
</div>
<script>

const modal = document.getElementById("saleModal");
const modalBody = document.getElementById("modalBody");

document.querySelectorAll(".viewDetails").forEach(btn=>{
    btn.addEventListener("click", function(){

        let items = JSON.parse(this.dataset.items);

        modalBody.innerHTML = "";

        items.forEach(item=>{
            modalBody.innerHTML += `
            <tr class="border-t">
                <td class="py-2">${item.name}</td>
                <td class="text-center">${item.qty}</td>
                <td class="text-center">${item.price} $</td>
                <td class="text-center">${item.total} $</td>
            </tr>
            `;
        });

        modal.classList.remove("hidden");
    });
});

function closeModal(){
    modal.classList.add("hidden");
}

</script>
</body>
</html>