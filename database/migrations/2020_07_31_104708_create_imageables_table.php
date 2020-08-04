<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imageables', function (Blueprint $table) {
            $table->id();
            $table->string('image_url')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_title')->nullable();
            $table->boolean('is_tiny')->default(false);
            $table->boolean('is_icon')->default(false);
            $table->boolean('is_icon2')->default(false);
            $table->boolean('is_gallery')->default(false);

            $table->bigInteger('imageable_id')->unsigned();
            $table->string('imageable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
