<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserMarkedItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_marked_item', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unique()->unsigned();
            $table->bigInteger('marked_item_id')->unique()->unsigned();

            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');

            $table->foreign('marked_item_id')->references('id')
                ->on('marked_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_marked_item');
    }
}
