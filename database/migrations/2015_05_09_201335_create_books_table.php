<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function(Blueprint $table)
		{
			$table->increments('id');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('title', 200);
			$table->string('edition', 50)->nullable();
			$table->string('publisher', 100)->nullable();
			$table->string('ISBN_10', 20)->nullable();
			$table->string('ISBN_13', 20)->nullable();
			$table->integer('published_year')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('condition')->nullable();
            $table->decimal('price', 8, 2)->nullable();
			$table->boolean('obo')->default(false);
            $table->timestamp('available_by')->nullable();
            $table->tinyInteger('status')->nullable();
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
		Schema::drop('books');
	}

}
