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
        Schema::table('blog_comments', function (Blueprint $table) {
            $table->integer('good')->unsigned()->default(0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_comments', function (Blueprint $table) {
            $table->integer('good')->unsigned()->default(0)->nullable(false)->change();
        });
    }
};
