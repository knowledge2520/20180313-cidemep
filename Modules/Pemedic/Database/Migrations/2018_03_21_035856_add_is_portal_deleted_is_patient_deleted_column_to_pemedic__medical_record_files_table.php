<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsPortalDeletedIsPatientDeletedColumnToPemedicMedicalRecordFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemedic__medical_record_files', function (Blueprint $table) {
            $table->string('is_patient_deleted')->default(0);
            $table->string('is_clinic_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemedic__medical_record_files', function (Blueprint $table) {
            $table->dropColumn(['is_patient_deleted', 'is_clinic_deleted']);
        });
    }
}
