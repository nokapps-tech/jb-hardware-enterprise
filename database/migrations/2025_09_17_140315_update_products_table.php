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
        Schema::table('products', function (Blueprint $table) {
            $table->string('size')->nullable()->after('cost');
            $table->string('unit')->nullable()->after('size');

            $table->renameColumn('description', 'notes');

            $table->dropColumn('sku');

            $table->string('product_code')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('name');

            $table->renameColumn('notes', 'description');

            $table->dropColumn(['size', 'unit']);

            $table->string('product_code')->nullable(false)->change();
        });
    }
};
