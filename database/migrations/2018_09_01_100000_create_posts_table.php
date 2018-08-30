<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->default(1);
            $table->string('slug', 191)->unique();
            $table->string('custom_code', 191)->default('blog');
            $table->string('title', 191);
            $table->text('description_raw');
            $table->text('description_html');
            $table->text('content_raw');
            $table->text('content_html');
            $table->string('page_image', 191);
            $table->string('meta_description', 191);
            $table->tinyInteger('is_published')->default(0);
            $table->string('layout', 191)->default('default');
            $table->tinyInteger('ad1')->default(0);
            $table->tinyInteger('ad2')->default(0);
            $table->timestamps();
            $table->dateTime('published_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
