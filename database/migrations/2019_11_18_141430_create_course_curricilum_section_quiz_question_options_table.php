<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseCurricilumSectionQuizQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_curricilum_section_quiz_question_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('question_id')->unsigned();
            $table->string('question_name');
            $table->boolean('correct_answer')->default(false);
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
        Schema::dropIfExists('course_curricilum_section_quiz_question_options');
    }
}
