<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();

            $table->string('name')->nullable();
            
            $table->boolean('status')->default(false);
            $table->boolean('trash')->default(false);
            $table->timestamps();

            $table->unique(['tenant_id', 'name']);
            $table->foreign('tenant_id')->references('id')->on('tenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tag_id')->unsigned();
            $table->bigInteger('taggable_id')->unsigned();
            $table->string('taggable_type');
            $table->timestamps();

            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
            $table->foreign('tag_id')->references('id')->on('tags')
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
        Schema::dropIfExists('tags');
    }
}
