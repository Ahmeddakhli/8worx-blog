<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_trans', function (Blueprint $table) {
            $table->bigInteger('language_id')->unsigned()->index();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->bigInteger('blog_id')->unsigned()->index();
            $table->foreign('blog_id')->references('id')->on('blogs');
            $table->primary(['blog_id', 'language_id']);

            // Information
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->mediumText('short_description')->nullable();
            $table->mediumText('description')->nullable();

            // SEO
            $table->string('slug')->nullable();
            $table->mediumText('meta_title')->nullable();
            $table->mediumText('meta_description')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // Add UserStamps
        Schema::table('blog_trans', function (Blueprint $table) {
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
        Schema::dropIfExists('blog_trans');
    }
}
