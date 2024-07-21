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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title',35);//イベント名称etc.
            $table->string('body',300);//投稿文
            $table->string('photo')->nullable();//s3の保存先ファイルパス
            $table->integer('good')->default(0);//いいね数
            $table->string('address');//実施未定
            $table->double('lat', 10, 8); // latカラムの追加 (小数点以下8桁)
            $table->double('lng', 11, 8); // lngカラムの追加 (小数点以下8桁)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
