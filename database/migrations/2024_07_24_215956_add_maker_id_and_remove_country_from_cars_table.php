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
        Schema::table('cars', function (Blueprint $table) {
             $table->dropColumn('country');

            // makerカラムを削除し、maker_idカラムを追加
            $table->dropColumn('maker');
            $table->foreignId('maker_id')->constrained('makers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // countryカラムを再追加
            $table->string('country', 25);

            // makerカラムを再追加
            $table->string('maker', 25);

            // 外部キー制約を削除
            $table->dropForeign(['maker_id']);
            $table->dropColumn('maker_id');
        });
    }
};
