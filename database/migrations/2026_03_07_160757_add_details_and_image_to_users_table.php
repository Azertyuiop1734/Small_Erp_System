<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // إضافة عمود التفاصيل (نص طويل) وعمود الصورة (اسم الملف)
        $table->text('details')->nullable()->after('email');
        $table->string('image')->nullable()->after('details');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // حذف الأعمدة عند التراجع
        $table->dropColumn(['details', 'image']);
    });
}
};
