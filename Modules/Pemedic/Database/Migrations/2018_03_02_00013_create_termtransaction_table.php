<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermtransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemedic__term_transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('term_id')->unsigned();
            $table->string('locale')->index();

            $table->tinyInteger('status')->default(0);
            $table->text('content');

            $table->unique(['term_id', 'locale']);
            $table->foreign('term_id')->references('id')->on('pemedic__term_conditions')->onDelete('cascade');
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
        Schema::table('pemedic__term_transactions', function (Blueprint $table) {
            $table->dropForeign('pemedic__term_transactions_term_id_foreign');
            $table->dropColumn('term_id');
        });
        Schema::dropIfExists('pemedic__term_transactions');
    }
}
