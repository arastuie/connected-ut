<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('firstname', 100)->nullable();
			$table->string('lastname', 100)->nullable();
			$table->string('contact_email')->nullable();
			$table->boolean('use_email')->default(true);
			$table->string('phone_number')->nullable();
			$table->boolean('use_phone')->default(false);
			$table->boolean('active')->default(false);
			$table->rememberToken();
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
		Schema::drop('users');
	}

}
