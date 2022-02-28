<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->json('salary')->nullable();
            $table->string('locale');
            $table->boolean('is_feature')->default(false);
            $table->json('additional')->nullable();
            $table->string('created_by')->nullable()->index();
            $table->string('updated_by')->nullable()->index();
            $table->string('deleted_by')->nullable()->index();
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
        Schema::dropIfExists('job_translations');
    }
}
