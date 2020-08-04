<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('destination_id')->unsigned()->nullable();
            $table->bigInteger('package_type_id')->unsigned()->nullable();

            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('short_title')->nullable();
            $table->longText('body')->nullable();
            $table->longText('short_body')->nullable();
            $table->string('stars')->nullable();
            $table->string('star_num')->nullable();
            $table->string('start_price')->nullable();
            $table->string('popular')->nullable();
            $table->integer('order')->nullable();

            $table->longText('included')->nullable();
            $table->longText('excluded')->nullable();
            $table->string('duration')->nullable();
            $table->string('tour_type')->nullable();
            $table->longText('visited_locations')->nullable();

            $table->boolean('view_in_home')->default(false);
            $table->boolean('view_in_destination_home')->default(false);
            $table->boolean('is_combined_tour')->default(false);

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
            $table->foreign('category_id')->references('id')->on('categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('destination_id')->references('id')->on('destinations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('package_type_id')->references('id')->on('package_types')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('package_destinations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_id')->unsigned()->nullable();
            $table->bigInteger('destination_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('destination_id')->references('id')->on('destinations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('package_related', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_id')->unsigned()->nullable();
            $table->bigInteger('related_package_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('related_package_id')->references('id')->on('packages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('package_hotels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_id')->unsigned()->nullable();
            $table->bigInteger('hotel_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('package_views', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });


        Schema::create('package_itineraries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_id')->unsigned()->nullable();

            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('package_prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_id')->unsigned()->nullable();

            $table->string('name')->nullable();
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('package_price_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_price_id')->unsigned()->nullable();
            
            $table->string('price_value')->nullable();
            $table->longText('body')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->foreign('package_price_id')->references('id')->on('package_prices')
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
        Schema::dropIfExists('packages');
        Schema::dropIfExists('package_destinations');
        Schema::dropIfExists('package_related');
        Schema::dropIfExists('package_hotels');
        Schema::dropIfExists('package_views');
        Schema::dropIfExists('package_itineraries');
        Schema::dropIfExists('package_prices');
        Schema::dropIfExists('package_price_items');
    }
}
