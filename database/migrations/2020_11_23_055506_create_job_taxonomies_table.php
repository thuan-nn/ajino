<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_taxonomies', function (Blueprint $table) {
            $table->foreignUuid('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->foreignUuid('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
            $table->unique(['job_id', 'taxonomy_id']);
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
        Schema::dropIfExists('job_taxonomies');
    }
}
