<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsShowToBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add Role ID
        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('is_show_creator')->default(true);
            $table->boolean('is_show_date')->default(true);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('is_show_date');
            $table->dropColumn('is_show_creator');

        });
    }
}
