<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marked_items', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->string('lang');
            $table->longText('description');
            $table->longText('title');
            $table->date('date');
            $table->boolean('is_analyzed')->default(false);
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
        Schema::dropIfExists('marked_items');
    }
}
