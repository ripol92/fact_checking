<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdjectivesColumnsInAnalysedUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analysed_urls', function (Blueprint $table) {
            $table->string('lng')->nullable();
            $table->json("adjectives_analyse")->nullable();
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
            $table->dropColumn('lng');
            $table->dropColumn('adjectives_analyse');
        });
    }
}
