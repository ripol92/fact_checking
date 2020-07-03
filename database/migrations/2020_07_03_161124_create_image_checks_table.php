<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_checks', function (Blueprint $table) {
            $table->id();
            $table->uuid("identifier")->unique();
            $table->string("image_path");
            $table->string("global_detector_error")->nullable();
            $table->string("local_detector_error")->nullable();
            $table->string("analyze_msg")->nullable();
            $table->string("results_path")->nullable();
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
        Schema::dropIfExists('image_checks');
    }
}
