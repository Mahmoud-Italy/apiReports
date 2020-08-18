<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('residential_address')->nullable();
            $table->string('telephone_no')->nullable();
            $table->string('email_Address')->nullable();
            $table->string('passport_file')->nullable();
            $table->string('passport_size_file')->nullable();
            $table->string('occupation_file')->nullable();
            $table->string('detailed_resume')->nullable();
            $table->string('hr_letter_file')->nullable();
            $table->string('video_url')->nullable();
            
            $table->boolean('seen')->default(false);
            $table->boolean('trash')->default(false);
            $table->timestamps();
        });

        Schema::create('member_qualifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned();
            $table->string('educational')->nullable();
            $table->string('univeristy')->nullable();
            $table->string('grade')->nullable();
            $table->string('year')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')
                    ->onDelete('cascade');
        });

        Schema::create('member_courses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned();
            $table->string('program')->nullable();
            $table->string('institute')->nullable();
            $table->string('duration')->nullable();
            $table->string('date')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')
                    ->onDelete('cascade');
        });

        Schema::create('member_languages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id')->unsigned();
            $table->string('language')->nullable();
            $table->string('level')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')
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
        Schema::dropIfExists('members');
        Schema::dropIfExists('member_qualifications');
        Schema::dropIfExists('member_courses');
        Schema::dropIfExists('member_languages');
    }
}
