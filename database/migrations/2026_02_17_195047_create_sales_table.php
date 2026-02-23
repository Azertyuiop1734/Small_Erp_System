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
        Schema::create('sales', function (Blueprint $table) {
    $table->id();
    $table->string('invoice_number')->unique();
    
    $table->foreignId('customer_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete();

    $table->foreignId('user_id')->constrained()->onDelete('cascade');

    $table->decimal('total_amount', 12, 2);
    $table->decimal('paid_amount', 12, 2)->default(0);
    $table->decimal('remaining_amount', 12, 2);
    $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');

    $table->enum('status', ['paid', 'partial', 'unpaid'])->default('paid');

    $table->string('payment_method')->nullable();
    $table->date('sale_date');
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
