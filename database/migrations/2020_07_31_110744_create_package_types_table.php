<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_types', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tenant_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            
            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->boolean('view_in_header')->default(false);
            $table->boolean('view_in_footer')->default(false);

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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_types');
    }
}
