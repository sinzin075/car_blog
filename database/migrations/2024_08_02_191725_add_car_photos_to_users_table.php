<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarPhotosToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('car1_photo')->nullable()->after('car1_id');
            $table->string('car2_photo')->nullable()->after('car2_id');
            $table->string('car3_photo')->nullable()->after('car3_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('car1_photo');
            $table->dropColumn('car2_photo');
            $table->dropColumn('car3_photo');
        });
    }
}

