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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('photo')->nullable(); // アイコン・保存先S3のファイルパス
            $table->foreignId('car1_id')->nullable()->constrained('cars')->nullOnDelete(); // 3台まで登録可能
            $table->foreignId('car2_id')->nullable()->constrained('cars')->nullOnDelete();
            $table->foreignId('car3_id')->nullable()->constrained('cars')->nullOnDelete();
            $table->string('greeting', 300); // 挨拶
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
