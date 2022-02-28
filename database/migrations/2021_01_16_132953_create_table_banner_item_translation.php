<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBannerItemTranslation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_item_translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('banner_item_id')
                  ->references('id')
                  ->on('banner_items')
                  ->onDelete('cascade');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->text('url')->nullable();
            $table->string('locale');
            $table->string('type');
            $table->text('video_url')->nullable();
            $table->string('created_by')->nullable()->index();
            $table->string('updated_by')->nullable()->index();
            $table->string('deleted_by')->nullable()->index();
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
        Schema::dropIfExists('banner_item_translations');
    }
}
