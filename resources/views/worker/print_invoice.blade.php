<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>فاتورة رقم {{ $sale->invoice_number }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; width: 80mm; margin: 0 auto; padding: 5px; font-size: 12px; }
        .text-center { text-align: center; }
        .header { border-bottom: 1px dashed #000; padding-bottom: 10px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { border-bottom: 1px solid #000; }
        .footer { border-top: 1px dashed #000; margin-top: 10px; padding-top: 10px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print();">
    <div class="header text-center">
        <h2> الفرع : {{Auth::user()->warehouse->name}} </h2>
        <p>التاريخ: {{ $sale->sale_date }}</p>
        <p>رقم الفاتورة: {{ $sale->invoice_number }}</p>
        @if($sale->customer) <p>الزبون: {{ $sale->customer->name }}</p> @endif
    </div>

    <table>
        <thead>
            <tr>
                <th align="right">المنتج</th>
                <th>الكمية</th>
                <th align="left">الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td align="center">{{ $item->quantity }}</td>
                <td align="left">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div style="display: flex; justify-content: space-between;">
            <span>المجموع:</span> <strong>{{ number_format($sale->total_amount, 2) }} DA</strong>
        </div>
        <div style="display: flex; justify-content: space-between;">
            <span>المدفوع:</span> <span>{{ number_format($sale->paid_amount, 2) }} DA</span>
        </div>
        <p class="text-center">شكراً لزيارتكم!</p>
    </div>

    <button class="no-print" onclick="window.close();" style="width: 100%; margin-top: 20px;">إغلاق</button>
</body>
</html>