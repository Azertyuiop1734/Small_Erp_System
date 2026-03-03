<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Warehouse;
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'barcode', 'category_id', 'supplier_id',
        'purchase_price', 'selling_price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

  
    public function productWarehouse()
    {
        return $this->hasMany(ProductWarehouse::class);
    }

 
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

 
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    public function warehouses()
{
    return $this->belongsToMany(
        Warehouses::class,
        'product_warehouse',
        'product_id',
        'warehouse_id'
    )->withPivot('quantity');
}
}
