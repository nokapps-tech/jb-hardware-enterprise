<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('company_id');
        });

        DB::statement('
            UPDATE transactions t
            LEFT JOIN companies c ON t.company_id = c.id
            SET t.company_name = c.name
        ');

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('company_name', 'name');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->dropColumn('name');
        });
    }
};
