<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_articles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('blog_writer_id')->unsigned()->nullable();
            $table->bigInteger('destination_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->longText('short_body')->nullable();

            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(false);
            $table->boolean('trash')->default(false);
            $table->timestamps();

            $table->unique(['tenant_id', 'slug']);
            $table->foreign('tenant_id')->references('id')->on('tenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('blog_writer_id')->references('id')->on('blog_writers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('destination_id')->references('id')->on('destinations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('blog_article_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blog_article_id')->unsigned()->nullable();
            
            $table->longText('content')->nullable();
            $table->longText('link')->nullable();
            $table->timestamps();

            $table->foreign('blog_article_id')->references('id')->on('blog_articles')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('blog_packages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blog_article_id')->unsigned()->nullable();
            $table->bigInteger('package_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('blog_article_id')->references('id')->on('blog_articles')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('package_id')->references('id')->on('packages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('blog_hotels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('blog_article_id')->unsigned()->nullable();
            $table->bigInteger('hotel_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('blog_article_id')->references('id')->on('blog_articles')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_articles');
        Schema::dropIfExists('blog_article_items');
        Schema::dropIfExists('blog_packages');
        Schema::dropIfExists('blog_hotels');
    }
}
