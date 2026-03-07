<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. حذف الأعمدة من جدول المنتجات
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'boxes_count')) {
                $table->dropColumn('boxes_count');
            }
            if (Schema::hasColumn('products', 'units_per_box')) {
                $table->dropColumn('units_per_box');
            }
        });

        // 2. إضافة الأعمدة لجدول مخزن المنتجات (المكان الصحيح)
        Schema::table('product_warehouse', function (Blueprint $table) {
            $table->integer('boxes_count')->default(0)->after('quantity');
            $table->integer('units_per_box')->default(1)->after('boxes_count');
        });
    }

    public function down(): void
    {
        // لإلغاء التعديل (Reverse)
        Schema::table('product_warehouse', function (Blueprint $table) {
            $table->dropColumn(['boxes_count', 'units_per_box']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('boxes_count')->default(0);
            $table->integer('units_per_box')->default(1);
        });
    }
};