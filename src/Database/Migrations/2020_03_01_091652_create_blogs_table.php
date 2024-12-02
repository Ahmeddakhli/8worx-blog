<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order')->nulllable();
            $table->string('media_type')->nullable();
            $table->string('video_type')->nullable();
            $table->text('video')->nulllable();
            $table->integer('views')->nulllable();
            $table->boolean('is_')->default(false)->unsigned()->index();
            $table->bigInteger('category_id')->unsigned()->nullable()->index();
            $table->boolean('is_featured')->default(true)->unsigned()->index();
            $table->boolean('is_published')->default(false)->unsigned()->index();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


           // Add UserStamps
           Schema::table('blogs', function (Blueprint $table) {
            $table->bigInteger('created_by')->unsigned()->nullable()->index()->after('created_at');
            $table->bigInteger('updated_by')->unsigned()->nullable()->index()->after('updated_at');
            $table->bigInteger('deleted_by')->unsigned()->nullable()->index()->after('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
