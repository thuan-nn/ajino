<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenulinkTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menulink_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('menu_link_id')->references('id')->on('menulinks')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('locale')->nullable();
            $table->text('url')->nullable();
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
        Schema::dropIfExists('menulink_translations');
    }
}
