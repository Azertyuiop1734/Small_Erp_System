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
    Schema::table('purchase_items', function (Blueprint $table) {
        $table->integer('units_per_box')->default(1)->after('boxes_count');
    });
}

public function down(): void
{
    Schema::table('purchase_items', function (Blueprint $table) {
        $table->dropColumn('units_per_box');
    });
}
};
