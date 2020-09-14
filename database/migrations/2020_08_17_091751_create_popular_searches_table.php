<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopularSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popular_searches', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->string('bgTitle')->nullable();
            $table->string('bgColor')->nullable();

            $table->longText('body1_1')->nullable();

            $table->longText('line1_2')->nullable();
            $table->longText('mask1_2')->nullable();
            $table->longText('color1_2')->nullable();
            $table->longText('body1_2_1')->nullable();
            $table->longText('body1_2_2')->nullable();

            $table->longText('line1_3')->nullable();
            $table->longText('mask1_3')->nullable();
            $table->longText('color1_3')->nullable();
            $table->longText('body1_3_1')->nullable();
            $table->longText('body1_3_2')->nullable();

            $table->longText('line1_4')->nullable();
            $table->longText('mask1_4')->nullable();
            $table->longText('color1_4')->nullable();
            $table->longText('body1_4_1')->nullable();
            $table->longText('body1_4_2')->nullable();

            $table->longText('line1_5')->nullable();
            $table->longText('mask1_5')->nullable();
            $table->longText('color1_5')->nullable();
            $table->longText('body1_5_1')->nullable();
            $table->longText('body1_5_2')->nullable();

            // d2
            $table->longText('line2_1')->nullable();
            $table->longText('mask2_1')->nullable();
            $table->longText('color2_1')->nullable();
            $table->longText('body2_1')->nullable();

            $table->longText('line2_2')->nullable();
            $table->longText('mask2_2')->nullable();
            $table->longText('color2_2')->nullable();
            $table->longText('body2_2')->nullable();

            $table->longText('line2_3')->nullable();
            $table->longText('mask2_3')->nullable();
            $table->longText('color2_3')->nullable();
            $table->longText('body2_3')->nullable();

            $table->longText('line2_4')->nullable();
            $table->longText('mask2_4')->nullable();
            $table->longText('color2_4')->nullable();
            $table->longText('body2_4')->nullable();

            // d3
            $table->longText('body3_1')->nullable();
            $table->longText('body3_2')->nullable();
            $table->longText('body3_3')->nullable();
            $table->longText('body3_4')->nullable();
            $table->longText('body3_5')->nullable();
            $table->longText('body3_6')->nullable();
            $table->longText('body3_7')->nullable();
            $table->longText('body3_8')->nullable();
            $table->longText('body3_9')->nullable();

            // d4
            $table->longText('body4_1')->nullable();
            $table->longText('body4_2')->nullable();
            $table->longText('body4_3')->nullable();
            $table->longText('body4_4')->nullable();

            // d5
            $table->longText('line5_1')->nullable();
            $table->longText('mask5_1')->nullable();
            $table->longText('color5_1')->nullable();
            $table->longText('body5_1')->nullable();

            $table->longText('line5_2')->nullable();
            $table->longText('mask5_2')->nullable();
            $table->longText('color5_2')->nullable();
            $table->longText('body5_2')->nullable();

            $table->longText('line5_3')->nullable();
            $table->longText('mask5_3')->nullable();
            $table->longText('color5_3')->nullable();
            $table->longText('body5_3')->nullable();

            $table->longText('line5_4')->nullable();
            $table->longText('mask5_4')->nullable();
            $table->longText('color5_4')->nullable();
            $table->longText('body5_4')->nullable();

            
            // d6
            $table->longText('body6_1')->nullable();
            $table->longText('body6_2')->nullable();
            $table->longText('body6_3')->nullable();
            $table->longText('body6_4')->nullable();

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
        Schema::dropIfExists('popular_searches');
    }
}
