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
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        // الربط مع جدول المستخدمين (المعرف الخاص بالمستخدم)
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        
        $table->string('title');        // عنوان التقرير
        $table->text('description');    // وصف التقرير
        $table->date('report_date');    // تاريخ التقرير
        
        $table->timestamps();           // تاريخ الإنشاء والتحديث تلقائياً
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
