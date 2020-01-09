<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerServiceInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_service_inquiries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('role', ['STUDENT', 'INSTRUCTOR'])->default('STUDENT');
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->longText('body');
            $table->boolean('agreed_terms');

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
        Schema::dropIfExists('customer_service_inquiries');
    }
}
