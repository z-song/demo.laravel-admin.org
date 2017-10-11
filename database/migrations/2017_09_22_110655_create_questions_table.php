<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_questions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('author_id');
            $table->string('title');
            $table->text('description');

            $table->string('ip');

            $table->timestamps();
        });

        Schema::create('demo_answers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('author_id');
            $table->integer('question_id');
            $table->text('content');

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
        Schema::dropIfExists('demo_questions');
        Schema::dropIfExists('demo_answers');
    }
}
