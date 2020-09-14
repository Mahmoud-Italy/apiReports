<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccreditationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->string('bgTitle')->nullable();
            $table->string('bgColor')->nullable();

            $table->longText('body1_1')->nullable();

            $table->longText('body2_1')->nullable();
            $table->longText('body2_2')->nullable();
            $table->longText('body2_3')->nullable();
            $table->longText('body2_4')->nullable();
            $table->longText('body2_5')->nullable();
            $table->longText('body2_6')->nullable();
            $table->longText('body2_7')->nullable();
            $table->longText('body2_8')->nullable();
            $table->longText('body2_9')->nullable();
            $table->longText('body2_10')->nullable();
            $table->longText('body2_11')->nullable();
            $table->longText('body2_12')->nullable();
            $table->longText('body2_13')->nullable();

            $table->longText('body3_1')->nullable();

            $table->longText('line3_2')->nullable();
            $table->longText('mask3_2')->nullable();
            $table->longText('color3_2')->nullable();
            $table->longText('body3_2_1')->nullable();
            $table->longText('body3_2_2')->nullable();

            $table->longText('line3_3')->nullable();
            $table->longText('mask3_3')->nullable();
            $table->longText('color3_3')->nullable();
            $table->longText('body3_3_1')->nullable();
            $table->longText('body3_3_2')->nullable();

            $table->longText('line3_4')->nullable();
            $table->longText('mask3_4')->nullable();
            $table->longText('color3_4')->nullable();
            $table->longText('body3_4_1')->nullable();
            $table->longText('body3_4_2')->nullable();

            $table->longText('line3_5')->nullable();
            $table->longText('mask3_5')->nullable();
            $table->longText('color3_5')->nullable();
            $table->longText('body3_5_1')->nullable();
            $table->longText('body3_5_2')->nullable();

            $table->longText('line3_6')->nullable();
            $table->longText('mask3_6')->nullable();
            $table->longText('color3_6')->nullable();
            $table->longText('body3_6_1')->nullable();
            $table->longText('body3_6_2')->nullable();

            $table->longText('line3_7')->nullable();
            $table->longText('mask3_7')->nullable();
            $table->longText('color3_7')->nullable();
            $table->longText('body3_7_1')->nullable();
            $table->longText('body3_7_2')->nullable();

            $table->longText('line3_8')->nullable();
            $table->longText('mask3_8')->nullable();
            $table->longText('color3_8')->nullable();
            $table->longText('body3_8_1')->nullable();
            $table->longText('body3_8_2')->nullable();

            $table->longText('line3_9')->nullable();
            $table->longText('mask3_9')->nullable();
            $table->longText('color3_9')->nullable();
            $table->longText('body3_9_1')->nullable();
            $table->longText('body3_9_2')->nullable();

            $table->longText('body4_0')->nullable();
            $table->longText('body4_1')->nullable();
            $table->longText('body4_2')->nullable();
            $table->longText('body4_3')->nullable();
            $table->longText('body4_4')->nullable();
            $table->longText('body4_5')->nullable();
            $table->longText('body4_6')->nullable();
            $table->longText('body4_7')->nullable();
            $table->longText('body4_8')->nullable();
            $table->longText('body4_9')->nullable();
            $table->longText('body4_10')->nullable();
            
            $table->integer('sort')->default(false);
            $table->string('download_name')->nullable();
            $table->boolean('has_download')->default(false);
            $table->boolean('has_application')->default(false);
            $table->boolean('has_faq')->default(false);
            $table->boolean('status')->default(true);
            $table->boolean('trash')->default(false);
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
        Schema::dropIfExists('accreditations');
    }
}
