<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTranslationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('post_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->longText('content')->nullable();
            $table->longText('description')->nullable();
            $table->string('locale');
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
    public function down() {
        Schema::dropIfExists('post_translations');
    }
}
