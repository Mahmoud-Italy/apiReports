<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWikisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wikis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('destination_id')->unsigned()->nullable();
            
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->longText('short_body')->nullable();

            $table->integer('order')->nullable();
            $table->boolean('view_in_home')->default(false);

            $table->boolean('status')->default(false);
            $table->boolean('trash')->default(false);
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('destination_id')->references('id')->on('destinations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('wiki_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wiki_id')->unsigned()->nullable();
            
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();

             $table->foreign('wiki_id')->references('id')->on('wikis')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('wiki_packages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wiki_id')->unsigned()->nullable();
            $table->bigInteger('package_id')->unsigned()->nullable();
            $table->timestamps();

             $table->foreign('wiki_id')->references('id')->on('wikis')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('package_id')->references('id')->on('packages')
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
        Schema::dropIfExists('wikis');
        Schema::dropIfExists('wiki_items');
        Schema::dropIfExists('wiki_packages');
    }
}
