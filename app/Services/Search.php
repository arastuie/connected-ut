<?php
namespace App\Services;

use App\Contracts\Search as SearchInterface;
use \Illuminate\Support\Facades\DB;
use App\Book;

class Search implements SearchInterface
{
    protected $table;
    protected $itemIds;

    public function __construct()
    {
        $this->itemIds = "";
    }

    public function on($index)
    {
        $this->table = $index;

        return $this;
    }

    public function get()
    {
        if($this->itemIds != "")
            $result = collect(DB::select($this->itemIds))->lists('book_id')->all();
        else
            $result = [];

        $result = $this->sort_by_most_repeated($result);
//        $result = implode("','", $result);
//        $result = Book::select("SELECT * FROM `$this->table` WHERE `id` IN ('$result')");
        $result = Book::whereIn('id', $result);

        return $result;
    }

    public function filter(array $filters)
    {

        $filteredBookIds = "";

        if(array_key_exists('title', $filters) && $filters['title'] != "")
        {
            $title = preg_replace('/\s+/', '|', trim($filters['title']));
            $filteredBookIds .= "SELECT `id` AS 'book_id' FROM `books` WHERE `title` REGEXP '$title'";
        }

        if(array_key_exists('course_list', $filters))
        {
            $course_ids = implode("','", $filters['course_list']);
            $filteredBookIds .= ($filteredBookIds != "")? " UNION ALL " : "";
            $filteredBookIds .= "SELECT `book_id` FROM `book_course` WHERE `course_id` IN ('$course_ids')";
        }

        if(array_key_exists('author_list', $filters))
        {
            $author_ids = implode("','", $filters['author_list']);

            $filteredBookIds .= ($filteredBookIds != "")? " UNION ALL " : "";
            $filteredBookIds .= "SELECT `book_id` FROM `author_book` WHERE `author_id` IN ('$author_ids')";
        }

        if(array_key_exists('instructor_list', $filters))
        {
            $instructor_ids = implode("','", $filters['instructor_list']);

            $filteredBookIds .= ($filteredBookIds != "")? " UNION ALL " : "";
            $filteredBookIds .= "SELECT `book_id` FROM `book_instructor` WHERE `instructor_id` IN ('$instructor_ids')";
        }

        if(array_key_exists('ISBN_13', $filters) && $filters['ISBN_13'] != "")
        {
            $ISBN_13 = $filters['ISBN_13'];
            $filteredBookIds .= ($filteredBookIds != "")? " UNION ALL " : "";
            $filteredBookIds .= "SELECT `id` AS 'book_id' FROM `books` WHERE `ISBN_13` = '$ISBN_13'";
        }

        if(array_key_exists('ISBN_10', $filters) && $filters['ISBN_13'] != "")
        {
            $ISBN_10 = $filters['ISBN_10'];
            $filteredBookIds .= ($filteredBookIds != "")? " UNION ALL " : "";
            $filteredBookIds .= "SELECT `id` AS 'book_id' FROM `books` WHERE `ISBN_10` = '$ISBN_10'";
        }

        $this->itemIds = $filteredBookIds;
        return $this;
    }

    /**
     * Sorts the result based on the most repeated records
     *
     * @param array $result
     * @return array
     */
    private function sort_by_most_repeated(array $result)
    {
        $count = array_count_values($result);
        arsort($count);

        return array_keys($count);
    }
}