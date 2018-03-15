<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNewsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemedic__news_translations', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('image_thumb')->nullable();
            $table->string('title')->nullable();
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
                $table->dropColumn('image');
                $table->dropColumn('image_thumb');
                $table->dropColumn('title');
        });
    }
}
