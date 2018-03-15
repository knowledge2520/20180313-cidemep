<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameNewsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('pemedic__news_transactions', 'pemedic__news_translations');
        Schema::rename('pemedic__term_transactions', 'pemedic__term_translations');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemedic__news_translations');
        Schema::dropIfExists('pemedic__term_translations');
    }
}
