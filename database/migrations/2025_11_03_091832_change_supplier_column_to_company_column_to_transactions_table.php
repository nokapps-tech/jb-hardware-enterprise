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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']); 
            $table->dropColumn('supplier_id');

            $table->foreignId('company_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete()
                  ->after('transaction_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');

            $table->foreignId('supplier_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete()
                  ->after('id');
        });
    }
};
