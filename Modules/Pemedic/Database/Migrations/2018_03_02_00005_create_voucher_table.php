<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemedic__vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clinic_id')->unsigned();
            $table->string('name');
            $table->date('start_date');
            $table->date('expiry_date');
            $table->string('image');
            $table->string('image_thumb');
            $table->string('description')->nullable();
            $table->integer('ordering');
            $table->boolean('deleted_portal')->default(0)->comment = "1:delete by clinic portal";
            $table->boolean('deleted_app')->default(0)->comment = "1:delete by app";
            $table->foreign('clinic_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pemedic__voucher_patient', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('voucher_id')->unsigned();
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('voucher_id')->references('id')->on('pemedic__vouchers')->onDelete('cascade');
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
        Schema::table('pemedic__vouchers', function (Blueprint $table) {
            $table->dropForeign('pemedic__vouchers_clinic_id_foreign');
            $table->dropColumn('clinic_id');
        });

        Schema::table('pemedic__voucher_patient', function (Blueprint $table) {
            $table->dropForeign('pemedic__voucher_patient_patient_id_foreign');
            $table->dropColumn('patient_id');

            $table->dropForeign('pemedic__voucher_patient_voucher_id_foreign');
            $table->dropColumn('voucher_id');
        });

        Schema::dropIfExists('pemedic__vouchers');
        Schema::dropIfExists('pemedic__voucher_patient');
    }
}
