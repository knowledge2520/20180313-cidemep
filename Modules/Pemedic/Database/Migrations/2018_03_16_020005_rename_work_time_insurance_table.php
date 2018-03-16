<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameWorkTimeInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemedic__issurance', function ($table) {
            $table->renameColumn('word_time', 'work_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('pemedic__news_translations', function (Blueprint $table) {
                $table->renameColumn('work_time', 'word_time');
        });
    }
}
