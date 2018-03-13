<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemedic__notification', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('metadata')->nullable();
            $table->integer('message_type')->nullable();
            $table->integer('is_reading')->nullable();
            $table->integer('sender_id')->unsigned()->nullable();
            $table->integer('receiver_id')->unsigned()->nullable();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('pemedic__notification', function (Blueprint $table) {
            $table->dropForeign('pemedic__notification_sender_id_foreign');
            $table->dropColumn('sender_id');

            $table->dropForeign('pemedic__notification_receiver_id_foreign');
            $table->dropColumn('receiver_id');
        });
        Schema::dropIfExists('pemedic__notification');
    }
}
