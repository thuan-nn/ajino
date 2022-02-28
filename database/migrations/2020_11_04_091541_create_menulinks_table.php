<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenulinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menulinks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('menu_id')->nullable()->references('id')->on('menus')->onDelete('cascade');
            $table->foreignUuid('taxonomy_id')->nullable()->references('id')->on('taxonomies')->onDelete('cascade');
            $table->foreignUuid('post_id')->nullable()->references('id')->on('posts')->onDelete('cascade');
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->string('class')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('menulinks', function (Blueprint $table) {
            $table->foreignUuid('parent_id')->nullable()->references('id')->on('menulinks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menulinks');
    }
}
