<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirebaseNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firebase_notifications', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("text");
            $table->unsignedBigInteger("marked_item_id");
            $table->foreign("marked_item_id")
                ->references("id")
                ->on("marked_items");
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")
                ->references("id")
                ->on("users");
            $table->uuid("batch_id")->nullable()->unique();
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
        Schema::dropIfExists('firebase_notifications');
    }
}
