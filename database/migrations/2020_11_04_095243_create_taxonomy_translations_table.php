<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomyTranslationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('taxonomy_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('locale');
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
    public function down() {
        Schema::dropIfExists('taxonomy_translations');
    }
}
