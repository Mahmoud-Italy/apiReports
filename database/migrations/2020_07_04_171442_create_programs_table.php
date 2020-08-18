<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->nullable();
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('has_sectors')->default(false);
            $table->boolean('status')->default(true);
            $table->boolean('trash')->default(false);
            $table->timestamps();
        });

        Schema::create('program_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sector_id')->unsigned()->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('title')->nullable();
            $table->longText('body')->nullable();

            $table->string('overview_title')->nullable();
            $table->longText('overview_body')->nullable();

            $table->string('learn_title')->nullable();
            $table->longText('learn_body')->nullable();

            $table->string('applay_title')->nullable();
            $table->longText('applay_body')->nullable();

            $table->string('price')->nullable();
            $table->longText('entry_requirements')->nullable();
            
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('sector_id')->references('id')->on('sectors')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
        Schema::dropIfExists('program_lists');
    }
}
