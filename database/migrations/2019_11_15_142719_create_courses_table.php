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
            $table->bigInteger('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('users');

            // Course Basic
            $table->string('title');
            $table->string('slug')->unique();

            // Description
            $table->text('excerpt');
            $table->longText('description');

            // Category
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('course_categories');

            // Published
            $table->enum('status', ['UNPUBLISH', 'PUBLISHED', 'DRAFT', 'PENDING', 'APPROVED'])->default('PENDING');

            // Language
            $table->enum('language', ['English'])->default('English');

            // Level
            $table->enum('level', ['BEGINNER', 'ADVANCE', 'INTERMEDIATE'])->default('BEGINNER');
            $table->boolean('top_course')->default(false);

            // Price
            $table->boolean('free_course')->default(false);
            $table->decimal('price', 15, 2)->nullable();
            $table->boolean('has_discount')->default(false);
            $table->decimal('discount', 15, 2)->default(0)->nullable();

            // Media
            $table->string('image')->nullable();
            $table->string('image_public_id')->nullable();
            
            // Course Media
            $table->enum('course_overview_provider', ['Youtube', 'Vimeo', 'HTML5'])->default('Youtube');
            $table->string('course_overview_url');

            // Featured
            $table->boolean(('featured'))->default(0);

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
