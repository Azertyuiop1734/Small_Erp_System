<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductWarehouse;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    /**
     * Show the POS interface.
     */
    public function index()
    {
        return view('worker.pos');
    }

    /**
     * Get product details by barcode for the user's specific warehouse.
     */
    public function getProductByBarcode($barcode)
    {
        $barcode = trim($barcode);
        $user = Auth::user();
        
        // البحث عن المنتج في مخزن المستخدم الحالي باستخدام العلاقات
        $productEntry = ProductWarehouse::with('product')
            ->where('warehouse_id', $user->warehouse_id)
            ->whereHas('product', function($query) use ($barcode) {
                $query->where('barcode', $barcode);
            })
            ->first();

        // التحقق من وجود المنتج
        if (!$productEntry) {
            return response()->json(['error' => 'Product not found in this warehouse'], 404);
        }

        // التحقق من المخزون
        if ($productEntry->quantity <= 0) {
            return response()->json(['error' => 'Product is out of stock'], 400);
        }

        return response()->json([
            'id'            => $productEntry->product->id,
            'name'          => $productEntry->product->name,
            'price'         => (float)$productEntry->product->selling_price,
            'image'         => $productEntry->product->image ? asset('storage/' . $productEntry->product->image) : asset('images/no-image.png'),
            'available_qty' => $productEntry->quantity,
        ]);
    }

    /**
     * Store a new sale transaction.
     */
    public function storeSale(Request $request)
    {
        $request->validate([
            'items'       => 'required|array',
            'total'       => 'required|numeric',
            'paid'        => 'required|numeric',
            'customer_id' => 'nullable|exists:customers,id', 
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $user = Auth::user();
                
                // تحديد الحالة (Status)
                $status = $this->determineSaleStatus($request->paid, $request->total);

                // 1. إنشاء الفاتورة
                $sale = Sale::create([
                    'invoice_number'   => 'INV-' . time() . rand(10, 99),
                    'customer_id'      => $request->customer_id,
                    'user_id'          => $user->id,
                    'warehouse_id'     => $user->warehouse_id,
                    'total_amount'     => $request->total,
                    'paid_amount'      => $request->paid,
                    'remaining_amount' => $request->total - $request->paid,
                    'status'           => $status,
                    'payment_method'   => 'POS',
                    'sale_date'        => now()->toDateString(),
                ]);

                // 2. معالجة العناصر وتحديث المخزن
                foreach ($request->items as $item) {
                    $sale->saleItems()->create([
                        'product_id' => $item['id'],
                        'quantity'   => $item['quantity'],
                        'price'      => $item['price'],
                        'total'      => $item['price'] * $item['quantity'],
                    ]);

                    // خصم الكمية من المخزن المربوط بالمستخدم
                    ProductWarehouse::where('warehouse_id', $user->warehouse_id)
                        ->where('product_id', $item['id'])
                        ->decrement('quantity', $item['quantity']);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Sale recorded successfully',
                    'sale_id' => $sale->id
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving sale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search for customers by name or phone.
     */
    public function searchCustomers(Request $request)
    {
        $term = $request->query('term');
        
        $customers = Customer::where('name', 'LIKE', "%{$term}%")
            ->orWhere('phone', 'LIKE', "%{$term}%")
            ->limit(10)
            ->get(['id', 'name', 'discount']);

        return response()->json($customers);
    }

    /**
     * Display the invoice for printing.
     */
    public function printInvoice($id) 
    {
        $sale = Sale::with(['saleItems.product', 'customer', 'user'])->findOrFail($id);
        return view('worker.print_invoice', compact('sale'));
    }

    /**
     * Helper: Determine sale status based on payment.
     */
    private function determineSaleStatus($paid, $total)
    {
        if ($paid <= 0) return 'unpaid';
        if ($paid < $total) return 'partial';
        return 'paid';
    }
}