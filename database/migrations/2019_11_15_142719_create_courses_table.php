<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');

            // User
            $table->integer('teacher_id')->unsigned();
            // $table->foreign('teacher_id')->references('id')->on('users');

            // Course Basic
            $table->string('title');
            $table->string('slug')->unique();

            // Description
            $table->text('excerpt');
            $table->longText('description');

            // Category
            $table->integer('category_id')->unsigned();
            // $table->foreign('category_id')->references('id')->on('course_categories');

            // Published
            $table->enum('status', ['PUBLISHED', 'DRAFT', 'PENDING'])->default('DRAFT');

            // Language
            $table->integer('language_id')->unsigned();

            // Level
            $table->enum('level', ['BEGINNER', 'ADVANCE', 'INTERMEDIATE'])->default('BEGINNER');
            $table->boolean('top_course')->default(false);

            // Price
            $table->boolean('free_course')->default(0);
            $table->decimal('price', 15, 2)->nullable();
            $table->boolean('has_discount')->default(0);
            $table->integer('discount')->default(0)->nullable();

            // Media
            $table->string('image')->nullable();
            $table->enum('course_overview_provider', ['Youtube', 'Vimeo', 'HTML5'])->default('Youtube');
            $table->string('course_overview_url');

            // SEO
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();

            $table->timestamps();

            // Delete Course
            $table->softDeletes();
            $table->index(['deleted_at']);
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
    }
}
