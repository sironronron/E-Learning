<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseCurricilumSectionQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_curriculum_section_quizzes', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Title - Slug
            $table->string('title');
            $table->string('slug');
            
            // Relationship
            $table->bigInteger('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

            $table->bigInteger('course_curriculum_section_id')->unsigned();
            $table->foreign('course_curriculum_section_id')->references('id')->on('course_curriculum_sections')->onDelete('unsigned');

            // Course Section Quiz Instruction
            $table->text('instruction');
            
            // Order Index
            $table->integer('order_index')->unsigned()->default(0);
            
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
        Schema::dropIfExists('course_curricilum_section_quizzes');
    }
}
