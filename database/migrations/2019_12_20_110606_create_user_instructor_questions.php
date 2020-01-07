<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInstructorQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_instructor_questions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Questions

            // Title - Share your knowledge
            // Udemy courses are video based experiences that give students the chance to learn actionable skills. Whether you have experience teaching, or it's your first time, we'll help you package your knowledge into an online course that improves student lives.

            $table->enum('teaching_skills', ['PERSON_INFORMAL', ['PERSON_PROFESSIONAL', 'ONLINE', 'OTHER']]);
            $table->string('teaching_skill_other')->nullable();

           // Title - Create a Course
           // Over the years we’ve helped thousands of instructors learn how to record at home. No matter your experience level, you can become a video pro too. We’ll equip you with the latest resources, tips, and support to help you succeed. 

            $table->enum('video_skills', ['BEGINNER', 'SOME_KNOWLEDGE', 'EXPERIENCED', 'READY_UPLOAD']);

            // Title - Expand your reach
            // Once you publish your course, you can grow your student audience and make an impact with the support of Udemy's marketplace promotions and also through your own marketing efforts. Together, we’ll help the right students discover your course.

            // NAM = Not at the moment, SMF = SMALL FOLLOWING, SZF = Sizeable Following
            $table->enum('audience_number', ['NAM', 'SMF', 'SZF']);
            
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
        Schema::dropIfExists('user_instructor_questions');
    }
}
