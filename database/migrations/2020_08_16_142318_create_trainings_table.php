<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('residential_address')->nullable();
            $table->string('telephone_no')->nullable();
            $table->string('email_Address')->nullable();
            $table->string('video_url')->nullable();
            
            $table->boolean('status')->default(false);
            $table->boolean('trash')->default(false);
            $table->timestamps();
        });

        Schema::create('training_qualifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('training_id')->unsigned();
            $table->string('educational')->nullable();
            $table->string('univeristy')->nullable();
            $table->string('grade')->nullable();
            $table->string('year')->nullable();
            $table->timestamps();

            $table->foreign('training_id')->references('id')->on('trainings')
                    ->onDelete('cascade');
        });

        Schema::create('training_courses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('training_id')->unsigned();
            $table->string('program')->nullable();
            $table->string('institute')->nullable();
            $table->string('duration')->nullable();
            $table->string('date')->nullable();
            $table->timestamps();

            $table->foreign('training_id')->references('id')->on('trainings')
                    ->onDelete('cascade');
        });

        Schema::create('training_languages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('training_id')->unsigned();
            $table->string('language')->nullable();
            $table->string('level')->nullable();
            $table->timestamps();

            $table->foreign('training_id')->references('id')->on('trainings')
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
        Schema::dropIfExists('trainings');
        Schema::dropIfExists('training_qualifications');
        Schema::dropIfExists('training_courses');
        Schema::dropIfExists('training_languages');
    }
}
