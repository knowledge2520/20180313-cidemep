<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemedic__medical_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clinic_id')->unsigned()->nullable();
            $table->string('clinic_name');
            $table->string('title')->nullable();
            $table->integer('patient_id')->unsigned();
            $table->integer('doctor_id')->nullable();
            $table->string('doctor_name')->nullable();
            $table->date('date');
            $table->integer('type');
            $table->integer('ordering');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pemedic__medical_record_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medical_id')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->string('path');
            $table->string('thumbnail');
            $table->boolean('deleted_portal')->default(0)->comment = "1:delete by clinic portal";
            $table->boolean('deleted_app')->default(0)->comment = "1:delete by app";
            $table->foreign('medical_id')->references('id')->on('pemedic__medical_records')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('pemedic__medical_records', function (Blueprint $table) {
            $table->dropForeign('pemedic__medical_records_clinic_id_foreign');
            $table->dropColumn('clinic_id');

            $table->dropForeign('pemedic__medical_records_patient_id_foreign');
            $table->dropColumn('patient_id');
        });

        Schema::table('pemedic__medical_record_files', function (Blueprint $table) {
            $table->dropForeign('pemedic__medical_record_files_medical_id_foreign');
            $table->dropColumn('medical_id');

            $table->dropForeign('pemedic__medical_record_files_patient_id_foreign');
            $table->dropColumn('patient_id');
        });

        Schema::dropIfExists('pemedic__medical_records');
        Schema::dropIfExists('pemedic__medical_record_files');
    }
}
