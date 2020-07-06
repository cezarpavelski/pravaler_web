<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->string('name');
            $table->string('cpf');
            $table->dateTime('birth_date');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('number');
            $table->string('district');
            $table->string('city');
            $table->string('country');
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
