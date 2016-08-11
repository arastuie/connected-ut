<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldDeletedBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_deleted_books', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->boolean('is_sold');

            $table->string('title', 200)->nullable();
            $table->string('edition', 50)->nullable();

            $table->text('instructors')->nullable();
            $table->text('courses')->nullable();
            $table->text('authors')->nullable();

            $table->string('publisher', 100)->nullable();
            $table->string('ISBN_10', 20)->nullable();
            $table->string('ISBN_13', 20)->nullable();
            $table->integer('published_year')->nullable();

            $table->text('description')->nullable();
            $table->integer('condition')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->boolean('obo')->nullable();
            $table->integer('photo_count')->nullable();
            $table->timestamp('posted_at');
            $table->timestamp('available_by')->nullable();
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
        Schema::drop('sold_deleted_books');
    }
}
