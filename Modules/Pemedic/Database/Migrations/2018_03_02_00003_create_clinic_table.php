<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemedic__clinic_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('clinic_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('vip_phone')->nullable();
            $table->string('address')->nullable();
            $table->string('map')->nullable();
            $table->string('word_time')->nullable();
            $table->string('website')->nullable();
            $table->string('issurance')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(0);
            $table->integer('ordering');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pemedic__user_clinic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('clinic_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('pemedic__clinic_profiles', function (Blueprint $table) {
            $table->dropForeign('pemedic__clinic_profiles_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('pemedic__user_clinic', function (Blueprint $table) {
            $table->dropForeign('pemedic__user_clinic_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropForeign('pemedic__user_clinic_clinic_id_foreign');
            $table->dropColumn('clinic_id');
        });

        Schema::dropIfExists('pemedic__clinic_profiles');
        Schema::dropIfExists('pemedic__user_clinic');
    }
}
