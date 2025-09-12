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
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropUnique('product_categories_name_unique');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('products_product_code_unique');
            $table->dropUnique('products_sku_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->unique('name');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unique('product_code');
            $table->unique('sku');
        });
    }
};
