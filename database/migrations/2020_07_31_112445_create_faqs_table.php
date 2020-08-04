<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('destination_id')->unsigned()->nullable();

            $table->text('title')->nullable();
            $table->longText('body')->nullable();
            $table->integer('order')->nullable();

            $table->boolean('view_in_home')->default(false);
            $table->boolean('status')->default(false);
            $table->boolean('trash')->default(false);
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('destination_id')->references('id')->on('destinations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('faqs');
    }
}
