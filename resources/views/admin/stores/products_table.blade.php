@foreach($products as $product)
<tr>
    <td>
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="product-img border">
        @else
            <img src="https://via.placeholder.com/50" class="product-img">
        @endif
    </td>

    <td class="fw-bold">{{ $product->product_name }}</td>
    <td><span class="badge bg-light text-dark border">{{ $product->barcode }}</span></td>
    <td>{{ $product->category_name }}</td>
    <td>{{ $product->warehouse_name }}</td>

    <td>
        @if($product->quantity <= 5)
            <span class="badge bg-danger">منخفض: {{ $product->quantity }}</span>
        @else
            <span class="badge bg-primary">{{ $product->quantity }}</span>
        @endif
    </td>

    <td class="text-success fw-bold">
        {{ number_format($product->selling_price, 2) }}
    </td>

   

    <td>
        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $product->id }})">
            <i class="fas fa-trash"></i> حذف
        </button>
    </td>

    <td>
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-edit"></i> تعديل
        </a>
    </td>
</tr>
@endforeach