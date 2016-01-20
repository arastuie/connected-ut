<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('department', 5);
            $table->foreign('department')->references('acronym')->on('departments');

            $table->integer('course_number');
            $table->string('course_name', 100);
            $table->string('full_course_name', 100);
            $table->string('associated_term', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courses');
    }
}
