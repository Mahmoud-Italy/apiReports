<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('has_member')->default(false);
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
        Schema::dropIfExists('online_trainings');
    }
}
