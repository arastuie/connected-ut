<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Tables that need to be truncated
	 *
	 * @var tables
	 */
	private $tables = [
		'book_instructor',
		'book_course',
		'author_book',
		'books',
		'authors'
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->cleanDatabase();

		//$this->call('BooksTableSeeder');
	}

	/**
	 * Truncate all the tables in $tables parameter
     */
	private function cleanDatabase()
	{
		DB::statement("SET foreign_key_checks = 0");

		foreach($this->tables as $table)
			DB::table($table)->truncate();

		DB::statement("SET foreign_key_checks = 1");
	}
}
