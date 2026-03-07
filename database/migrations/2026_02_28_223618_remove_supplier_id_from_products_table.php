<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // 1. حذف القيد (Foreign Key Constraint) أولاً
            $table->dropForeign(['supplier_id']);
            
            // 2. حذف العمود نفسه
            $table->dropColumn('supplier_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // كود التراجع (إعادة العمود في حال أردت إلغاء Migration)
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
};