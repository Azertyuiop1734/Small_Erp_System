<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        // حذف عمود سعر الشراء فقط
        if (Schema::hasColumn('products', 'purchase_price')) {
            $table->dropColumn('purchase_price');
        }
        
        // لا تضع كود حذف supplier_id هنا لأنه حُذف في الميجريشن السابق
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->decimal('purchase_price', 10, 2)->default(0);
    });
}
};