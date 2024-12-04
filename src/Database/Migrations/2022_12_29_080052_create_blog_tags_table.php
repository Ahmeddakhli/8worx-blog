<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')->on('lookups');
            $table->bigInteger('blog_id')->unsigned()->index()->nullable();
            $table->foreign('blog_id')->references('id')->on('blogs');
            $table->softDeletes();
            $table->timestamps();
        });

        // Add UserStamps
        Schema::table('blog_tags', function (Blueprint $table) {
            $table->bigInteger('created_by')->unsigned()->nullable()->index()->after('created_at');
            $table->foreign('created_by')->references('id')->on('users');
            $table->bigInteger('updated_by')->unsigned()->nullable()->index()->after('updated_at');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->bigInteger('deleted_by')->unsigned()->nullable()->index()->after('deleted_at');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tags');
    }
}
