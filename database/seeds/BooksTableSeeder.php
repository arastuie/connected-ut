<?php

use Carbon\Carbon;
use App\Models\Book;
use App\Models\User;
use App\Models\Tags\Author;
use App\Models\Tags\Course;
use Faker\Factory as Faker;
use App\Models\Tags\Instructor;
use Illuminate\Support\Facades\DB;


Class BooksTableSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $count = 100; // Number of fake books needed

        $faker = Faker::create();

        $users = User::lists('id')->all();

        foreach(range(1, $count) as $index)
        {
            $date = Carbon::createFromTimestamp($faker->dateTimeBetween('-20 days', 'now')->getTimestamp());

            Book::create([
                'user_id' => $faker->randomElement($users),
                'title' => $faker->realText(40, 2),
                'edition' => $faker->numberBetween(4, 20) . 'th',
                'publisher' => $faker->company,
                'ISBN_10' => $faker->isbn10,
                'ISBN_13' => $faker->isbn13,
                'published_year' => $faker->numberBetween(1990, 2016),
                'description' => $faker->realText(120, 2),
                'condition' => $faker->numberBetween(0, 3),
                'price' => $faker->randomFloat(2, 1, 200),
                'obo' => $faker->boolean(),
                'available_by' => Carbon::createFromTimestamp($faker->dateTimeBetween('now', '+10 days')->getTimestamp()),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        foreach(range(1, (int)($count * 1.5)) as $index)
        {
            Author::create([
                'full_name' => $faker->name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $instructors = Instructor::lists('id')->all();
        $courses = Course::lists('id')->all();

        foreach(range(1, (int)($count * 1.5)) as $index)
        {
            DB::table('book_instructor')->insert([
                'book_id' => $faker->numberBetween(1, $count),
                'instructor_id' => $faker->randomElement($instructors),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::table('book_course')->insert([
               'book_id' => $faker->numberBetween(1, $count),
                'course_id' => $faker->randomElement($courses),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::table('author_book')->insert([
                'book_id' => $faker->numberBetween(1, $count),
                'author_id' => $faker->numberBetween(1, (int)($count * 1.5)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}