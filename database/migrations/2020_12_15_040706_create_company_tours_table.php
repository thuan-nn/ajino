<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_tours', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('location_id')->references('id')->on('locations');
            $table->date('date');
            $table->string('type');
            $table->string('description')->nullable();
            $table->integer('people_amount')->default(180);
            $table->integer('registry_amount')->default(0);
            $table->integer('participant_amount')->default(0);
            $table->boolean('is_published')->default(true);
            $table->boolean('is_cancel')->default(false);
            $table->json('additional')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_tours');
    }
}
