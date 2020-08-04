<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCruisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cruises', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            
            $table->string('slug')->nullable();
            $table->text('title')->nullable();
            $table->text('short_title')->nullable();
            $table->longText('body')->nullable();
            $table->longText('short_body')->nullable();
            $table->string('stars')->nullable();
            $table->string('star_num')->nullable();
            $table->string('start_price')->nullable();

            $table->integer('order')->nullable();
            $table->longText('inclusion')->nullable();
            $table->longText('visited_locations')->nullable();
            $table->string('duration')->nullable();
            
            $table->boolean('status')->default(false);
            $table->boolean('trash')->default(false);
            $table->timestamps();

            $table->unique(['tenant_id', 'slug']);
            $table->foreign('tenant_id')->references('id')->on('tenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('cruise_itineraries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cruise_id')->unsigned()->nullable();

            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->foreign('cruise_id')->references('id')->on('cruises')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('cruise_views', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cruise_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('cruise_id')->references('id')->on('cruises')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('cruise_cabins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cruise_id')->unsigned()->nullable();

            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->string('price')->nullable();
            $table->timestamps();

            $table->foreign('cruise_id')->references('id')->on('cruises')
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
        Schema::dropIfExists('cruises');
        Schema::dropIfExists('cruise_itineraries');
        Schema::dropIfExists('cruise_views');
        Schema::dropIfExists('cruise_cabins');
    }
}
