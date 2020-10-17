<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_apps', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_accrediation')->default(false);

            $table->string('name_of_institution')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('type')->nullable();
            $table->string('establishment_date')->nullable();
            $table->string('commerical_register_no')->nullable();
            $table->string('telephone_no')->nullable();
            $table->string('email_address')->nullable();
            $table->string('website_url')->nullable();

            $table->boolean('general1')->default(false);
            $table->boolean('general2')->default(false);
            $table->boolean('general3')->default(false);
            $table->boolean('general4')->default(false);
            $table->boolean('general5')->default(false);

            $table->boolean('authority1')->default(false);
            $table->boolean('authority2')->default(false);
            $table->boolean('authority3')->default(false);
            $table->boolean('authority4')->default(false);
            $table->boolean('authority5')->default(false);
            $table->boolean('authority6')->default(false);

            $table->string('name')->nullable();
            $table->string('date')->nullable();
            
            $table->boolean('status')->default(false);
            $table->boolean('trash')->default(false);
            $table->timestamps();
        });
        Schema::create('new_app_layouts', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_accrediation')->default(false);
            $table->string('bgColor')->nullable();
            $table->string('bgTitle')->nullable();

            $table->string('text1')->nullable();
            $table->string('text2')->nullable();
            $table->string('text3')->nullable();
            $table->string('pdf1')->nullable();
            $table->string('pdf2')->nullable();
            $table->string('pdf3')->nullable();
            $table->string('pdf4')->nullable();
            $table->string('pdf5')->nullable();
            $table->string('pdf6')->nullable();
            $table->string('text4')->nullable();

            $table->string('general1_title')->nullable();
            $table->string('general1_body')->nullable();
            $table->string('general2_title')->nullable();
            $table->string('general2_body')->nullable();
            $table->string('general3_title')->nullable();
            $table->string('general3_body')->nullable();
            $table->string('general4_title')->nullable();
            $table->string('general4_body')->nullable();
            $table->string('general5_title')->nullable();
            $table->string('general5_body')->nullable();

            $table->string('note1')->nullable();
            $table->string('note2')->nullable();

            $table->string('text5')->nullable();
            
            $table->string('authority_note')->nullable();
            $table->string('authority_title')->nullable();

            $table->string('authority1')->nullable();
            $table->string('authority2')->nullable();
            $table->string('authority3')->nullable();
            $table->string('authority4')->nullable();
            $table->string('authority5')->nullable();
            $table->string('authority6')->nullable();

            $table->string('head')->nullable();
            $table->string('last_confirm')->nullable();
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
        Schema::dropIfExists('new_apps');
        Schema::dropIfExists('new_app_layout');
    }
}
