<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

  protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'boxes_count',    // تأكد من إضافة هذا السطر
        'units_per_box',   // تأكد من إضافة هذا السطر
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
