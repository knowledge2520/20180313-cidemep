<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemedic__message', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('doctor_id')->unsigned();
            $table->text('message');
            $table->boolean('is_read_patient')->default(0)->comment = "1:read by patient";
            $table->boolean('is_read_doctor')->default(0)->comment = "1:read by docter";
            $table->boolean('patient_deleted')->default(0)->comment = "1:delete by patient";
            $table->boolean('doctor_deleted')->default(0)->comment = "1:delete by doctor";
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemedic__message', function (Blueprint $table) {
            $table->dropForeign('pemedic__message_patient_id_foreign');
            $table->dropColumn('patient_id');

            $table->dropForeign('pemedic__message_doctor_id_foreign');
            $table->dropColumn('doctor_id');
        });
        Schema::dropIfExists('pemedic__message');
    }
}
