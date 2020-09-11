<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMarkedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marked_items', function (Blueprint $table) {
            $table->longText('html_encoded')->nullable();
            $table->string('source')->nullable();
            $table->string('img')->nullable();
            $table->string('fact_check_url')->nullable();
            $table->unique('link', 'marked_items_link_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marked_items', function (Blueprint $table) {
            $table->dropColumn('html_encoded');
            $table->dropColumn('source');
            $table->dropColumn('image');
            $table->dropColumn('html_encoded');
            $table->dropUnique('marked_items_link_unique');
        });
    }
}
