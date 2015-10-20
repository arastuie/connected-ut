<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('book_instructor', function(Blueprint $table)
        {
            $table->integer('book_id')->unsigned()->index();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');

            $table->integer('instructor_id')->unsigned()->index();
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');

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
        Schema::drop('instructors');
        Schema::drop('book_instructor');
    }
}
