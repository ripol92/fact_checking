<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUnnecessaryColumnsInAnalysedUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analysed_urls', function (Blueprint $table) {
            $table->dropColumn('text_ru_response_received');
            $table->dropColumn('fal_detector_finished');
            $table->dropColumn('notifications_send');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analysed_urls', function (Blueprint $table) {
            $table->boolean('text_ru_response_received')->default(false);
            $table->boolean('fal_detector_finished')->default(false);
            $table->boolean('notifications_send')->default(false);
        });
    }
}
