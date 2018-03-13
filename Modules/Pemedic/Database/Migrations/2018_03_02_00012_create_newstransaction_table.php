<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewstransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemedic__news_transactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('new_id')->unsigned();
            $table->string('locale')->index();

            $table->tinyInteger('status')->default(0);
            $table->text('content');

            $table->unique(['new_id', 'locale']);
            $table->foreign('new_id')->references('id')->on('pemedic__news')->onDelete('cascade');
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
        Schema::table('pemedic__news_transactions', function (Blueprint $table) {
            $table->dropForeign('pemedic__news_transactions_new_id_foreign');
            $table->dropColumn('new_id');
        });
        Schema::dropIfExists('pemedic__news_transactions');
    }
}
