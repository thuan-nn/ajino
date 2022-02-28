<?php

use App\Enums\VisitorStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_tour_id')->references('id')->on('company_tours')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('email');
            $table->string('phone_number', '11');
            $table->integer('amount_visitor')->default(0);
            $table->string('majors');
            $table->string('job_location');
            $table->text('note')->nullable();
            $table->foreignUuid('city')->references('id')->on('locations');
            $table->string('status')->default(VisitorStatusEnum::REGISTERED);
            $table->string('created_by')->nullable()->index();
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
        Schema::dropIfExists('visitors');
    }
}
