<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWarehouse extends Model
{
    use HasFactory;

    // هذا السطر هو المفتاح لحل المشكلة 
    // يخبر لارافل أن يستخدم اسم الجدول الفردي الموجود في قاعدة بياناتك
    protected $table = 'product_warehouse'; 

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'minimum_stock'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        // تأكد أن الموديل هنا اسمه Warehouse وليس Warehouses
        return $this->belongsTo(Warehouse::class); 
    }
}