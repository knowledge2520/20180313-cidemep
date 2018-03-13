<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemedic__groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clinic_id')->unsigned();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->enum('type',['Normal', 'Vip'])->default('Normal');
            $table->integer('ordering');
            $table->foreign('clinic_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pemedic__patient_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('pemedic__groups')->onDelete('cascade');
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
        Schema::table('pemedic__groups', function (Blueprint $table) {
            $table->dropForeign('pemedic__groups_clinic_id_foreign');
            $table->dropColumn('clinic_id');
        });

        Schema::table('pemedic__patient_group', function (Blueprint $table) {
            $table->dropForeign('pemedic__patient_group_patient_id_foreign');
            $table->dropColumn('patient_id');

            $table->dropForeign('pemedic__patient_group_group_id_foreign');
            $table->dropColumn('group_id');
        });

        Schema::dropIfExists('pemedic__groups');
        Schema::dropIfExists('pemedic__patient_group');
    }
}
