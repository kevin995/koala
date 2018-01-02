<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterScores extends Migration
{

    public function up()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->json('score')->default(null)->change();
            $table->text('question')->after('score');
            $table->text('suggest')->after('question');
        });
    }

    public function down()
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->integer('score')->default(0)->change();
            $table->removeColumn('question');
            $table->removeColumn('suggest');
        });
    }
}
