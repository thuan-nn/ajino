<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomyPostsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('taxonomy_posts', function (Blueprint $table) {
            $table->foreignUuid('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreignUuid('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
            $table->string('locale')->nullable();
            $table->unique(['post_id', 'taxonomy_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('taxonomy_posts');
    }
}
