<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        // إضافة عمود عدد الوحدات في كل صندوق (بجانب عدد الصناديق)
        $table->integer('units_per_box')->default(1)->after('boxes_count');
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('units_per_box');
    });
}
};
