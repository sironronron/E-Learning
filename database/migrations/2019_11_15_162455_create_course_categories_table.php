<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_categories', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relationships 
            $table->bigInteger('parent_id')->unsigned()->nullable()->default(null);
            $table->foreign('parent_id')->references('id')->on('course_categories')->onUpdate('cascade')->onDelete('set null');

            // Featured Course
            $table->bigInteger('featured_course_id')->unsigned();
            $table->foreign('featured_course_id')->references('id')->on('courses')->onDelete('cascade');
            
            // Category Icon
            $table->string('icon')->nullable();
            $table->string('name');
            
            // Category URL Friendly
            $table->string('slug')->unique();

            // Category Order
            $table->integer('order_index')->default(1);
            
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
        Schema::dropIfExists('course_categories');
    }
}
