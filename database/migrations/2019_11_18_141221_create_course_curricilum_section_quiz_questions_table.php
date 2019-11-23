<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseCurricilumSectionQuizQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_curricilum_section_quiz_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quiz_id')->unsigned();
            $table->integer('number_of_questions');
            $table->string('question_title');
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
        Schema::dropIfExists('course_curricilum_section_quiz_questions');
    }
}
