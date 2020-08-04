<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('package_id')->unsigned()->nullable();

            $table->string('name')->nullable();
            
            $table->boolean('status')->default(false);
            $table->boolean('trash')->default(false);
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('package_id')->references('id')->on('packages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('accommodation_hotels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('accommodation_id')->unsigned()->nullable();
            $table->bigInteger('hotel_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('accommodation_id')->references('id')->on('accommodations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('accommodation_prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('accommodation_id')->unsigned()->nullable();

            $table->string('name')->nullable();
            $table->timestamps();

            $table->foreign('accommodation_id')->references('id')->on('accommodations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('accommodation_price_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('accommodation_price_id')->unsigned()->nullable();
            
            $table->string('price_value')->nullable();
            $table->longText('body')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->foreign('accommodation_price_id')->references('id')->on('accommodation_prices')
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
        Schema::dropIfExists('accommodations');
        Schema::dropIfExists('accommodation_hotels');
        Schema::dropIfExists('accommodation_prices');
        Schema::dropIfExists('accommodation_price_items');
    }
}
