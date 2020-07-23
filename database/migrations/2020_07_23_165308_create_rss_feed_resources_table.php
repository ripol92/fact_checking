<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssFeedResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_feed_resources', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->string('name');
            $table->string('display_name');
            $table->integer('order')->nullable();

            $table->bigInteger('language_id')->unique()->unsigned();
            $table->foreign('language_id')->references('id')
                ->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rss_feed_resources');
    }
}
