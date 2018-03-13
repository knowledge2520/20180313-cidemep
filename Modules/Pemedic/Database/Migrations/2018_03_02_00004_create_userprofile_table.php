<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemedic__user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender',['Male', 'Female'])->default('Male');
            $table->date('dob')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->enum('type',['Normal', 'Vip'])->default('Normal');
            $table->string('image')->nullable();
            $table->text('other_info')->nullable();
            $table->boolean('is_receive_voucher')->default(0)->comment = "0:receive push voucher/1:not receive push voucher";
            $table->boolean('is_support')->default(0)->comment = "1:is supporter of clinic";
            $table->boolean('status')->default(0);
            $table->integer('ordering');
            $table->boolean('deleted_portal')->default(0)->comment = "1:delete by clinic portal";
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('pemedic__user_profiles', function (Blueprint $table) {
            $table->dropForeign('pemedic__user_profiles_user_id_foreign');
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('pemedic__user_profiles');
    }
}
