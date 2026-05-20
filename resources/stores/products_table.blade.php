@foreach($products as $product)
    @foreach($product->warehouses as $warehouse)
        <tr>
            <!-- الصورة -->
            <td>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="product-img border">
                @else
                    <img src="https://via.placeholder.com/50" class="product-img">
                @endif
            </td>

            <!-- اسم المنتج -->
            <td class="fw-bold">{{ $product->name }}</td>

            <!-- الباركود -->
            <td><span class="badge bg-light text-dark border">{{ $product->barcode }}</span></td>

            <!-- اسم القسم -->
            <td>{{ $product->category->category_name ?? '-' }}</td>

            <!-- اسم المخزن -->
            <td>{{ $warehouse->name }}</td>

            <!-- المخزون المنخفض -->
            <td>
                @if(($warehouse->pivot->quantity ?? 0) <= 5)
                    <span class="badge bg-danger">منخفض: {{ $warehouse->pivot->quantity ?? 0 }}</span>
                @else
                    <span class="badge bg-primary">{{ $warehouse->pivot->quantity ?? 0 }}</span>
                @endif
            </td>

            <!-- عدد الصناديق -->
            <td>{{ $warehouse->pivot->boxes_count ?? 0 }}</td>

            <!-- السعر -->
            <td class="text-success fw-bold">{{ number_format($product->selling_price, 2) }}</td>

            <!-- زر الحذف -->
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $product->id }})">
                    <i class="fas fa-trash"></i> حذف
                </button>
            </td>

            <!-- زر التعديل -->
            <td>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit"></i> تعديل
                </a>
            </td>
        </tr>
    @endforeach
@endforeach