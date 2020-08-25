<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysedUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analysed_urls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('url')->unique();
            $table->text('article');
            $table->json('text_ru')->nullable();
            $table->json('image_links')->nullable();
            $table->boolean('text_ru_response_received')->default(false);
            $table->boolean('fal_detector_finished')->default(false);
            $table->boolean('notifications_send')->default(false);
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
        Schema::dropIfExists('analysed_urls');
    }
}
