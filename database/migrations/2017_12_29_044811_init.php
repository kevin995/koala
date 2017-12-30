<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('id', 100)->unique()->primary();
            $table->string('name')->index();
            $table->string('speaker');
            $table->string('location');
            $table->timestamp('date')->nullable();
            $table->smallInteger("isclose")->default(0);
            $table->softDeletes('deleted_at');
            $table->timestamp('created_at')->nullable();

            $table->foreign('speaker')->references('id')->on('users');
        });

        Schema::create('scores', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('id', 100)->unique()->primary();
            $table->string('course_id', 100);
            $table->string('scorer');
            $table->integer('score')->default(0);
            $table->integer('lscore')->default(0);
            $table->timestamp('created_at')->nullable();

            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('scorer')->references('id')->on('users');
        });

        Schema::create('feedback', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('id', 100)->unique()->primary();
            $table->smallInteger('type');
            $table->string('course_id')->nullable();
            $table->string('proposer');
            $table->text('question');
            $table->integer('score')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('proposer')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
        Schema::dropIfExists('scores');
        Schema::dropIfExists('feedback');
    }
}
