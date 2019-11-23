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
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            // $table->foreign('parent_id')->references('id')->on('course_categories')->onUpdate('cascade')->onDelete('set null');
            // Category Order
            $table->integer('order')->default(1);
            
            // Category Icon
            $table->string('icon')->nullable();

            $table->string('name');
            
            // Category URL Friendly
            $table->string('slug')->unique();
            
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
