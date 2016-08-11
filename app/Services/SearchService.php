<?php
namespace App\Services;

use App\Models\Book;
use App\Contracts\ISearch;
use \Illuminate\Support\Facades\DB;


class SearchService implements ISearch
{
    protected $table;
    protected $selectStatement;
    protected $bindings;

    /**
     * sets the protected variables
     */
    public function __construct()
    {
        $this->selectStatement = "";
        $this->bindings = [];
    }

    /**
     * Sets the table which to be used for search
     *
     * @param $index
     * @return $this
     */
    public function on($index)
    {
        $this->table = $index;

        return $this;
    }

    /**
     * Runs the prepared query and sorts the most repeated results
     *
     * @return array
     */
    public function get()
    {
        if($this->selectStatement != "")
            $result = collect(DB::select(DB::raw($this->selectStatement), $this->bindings))->lists('book_id')->all();
        else
            $result = [];

        $result = $this->sortByMostRepeated($result);
        $result = Book::whereIn('id', $result)->whereStatus(Book::STATUS['listed']);

        return $result;
    }

    /**
     * Prepares a select statement based on keywords passed
     *
     * @param $keywords
     * @return $this
     */
    public function by($keywords)
    {
        $this->selectStatement = "";
        $regexKeywords = preg_replace('/\b[a-z]{1,2}\b/', '', $keywords);
        $regexKeywords = preg_replace('/\b(are|they|the|that|edition)\b/', '', $keywords);
        $regexKeywords = preg_replace('/\s+/', '|', trim($regexKeywords));

        // return if there is nothing to search for
        if($regexKeywords == "")
            return $this;

        // Title
        $this->bindings['title'] = $regexKeywords;
        $this->selectStatement = "SELECT `id` AS 'book_id' FROM `books` WHERE `title` REGEXP :title";

        // Edition
        $this->bindings['edition'] = $regexKeywords;
        $this->selectStatement .= " UNION ALL SELECT `id` AS 'book_id' FROM `books` WHERE `edition` REGEXP :edition";

        // publisher
        $this->bindings['publisher'] = $regexKeywords;
        $this->selectStatement .= " UNION ALL SELECT `id` AS 'book_id' FROM `books` WHERE `publisher` REGEXP :publisher";

        // Courses
        $this->bindings['course'] = $regexKeywords;
        $this->selectStatement .= " UNION ALL SELECT `book_id` FROM `book_course` WHERE `course_id` IN (SELECT `id` FROM `courses` WHERE `full_course_name` REGEXP :course)";

        // Instructors
        $this->bindings['instructor'] = $regexKeywords;
        $this->selectStatement .= " UNION ALL SELECT `book_id` FROM `book_instructor` WHERE `instructor_id` IN (SELECT `id` FROM `instructors` WHERE `name` REGEXP :instructor)";

        // Authors
        $this->bindings['author'] = $regexKeywords;
        $this->selectStatement .= " UNION ALL SELECT `book_id` FROM `author_book` WHERE `author_id` IN (SELECT `id` FROM `authors` WHERE `full_name` REGEXP :author)";

        return $this;
    }

    /**
     * Prepares a select query based on the filters passed
     *
     * @param array $filters
     * @return $this
     */
    public function filter(array $filters)
    {
        $filteredBookIds = "";

        if(array_key_exists('title', $filters))
        {
            $filters['title'] = preg_replace('/\b[a-z]{1,2}\b/', '', $filters['title']);
            $this->bindings['title'] = preg_replace('/\s+/', '|', trim($filters['title']));
            $filteredBookIds .= "SELECT `id` AS 'book_id' FROM `books` WHERE `title` REGEXP :title";
        }

        if(array_key_exists('course_list', $filters))
        {
            $this->deleteNonNumerics($filters['course_list']);
            $course_ids = implode("','", $filters['course_list']);
            $filteredBookIds .= ($filteredBookIds != "")? " UNION ALL " : "";
            $filteredBookIds .= "SELECT `book_id` FROM `book_course` WHERE `course_id` IN ('$course_ids')";
        }

        if(array_key_exists('author_list', $filters))
        {
            $this->deleteNonNumerics($filters['author_list']);
            $author_ids = implode("','", $filters['author_list']);
            $filteredBookIds .= ($filteredBookIds != "")? " UNION ALL " : "";
            $filteredBookIds .= "SELECT `book_id` FROM `author_book` WHERE `author_id` IN ('$author_ids')";
        }

        if(array_key_exists('instructor_list', $filters))
        {
            $this->deleteNonNumerics($filters['instructor_list']);
            $instructor_ids = implode("','", $filters['instructor_list']);
            $filteredBookIds .= ($filteredBookIds != "")? " UNION ALL " : "";
            $filteredBookIds .= "SELECT `book_id` FROM `book_instructor` WHERE `instructor_id` IN ('$instructor_ids')";
        }

        if(array_key_exists('ISBN_13', $filters) && is_numeric($filters['ISBN_13']))
        {
            $this->bindings['ISBN_13'] = $filters['ISBN_13'];
            $filteredBookIds .= ($filteredBookIds != "")? " UNION ALL " : "";
            $filteredBookIds .= "SELECT `id` AS 'book_id' FROM `books` WHERE `ISBN_13` = :ISBN_13";
        }

        if(array_key_exists('ISBN_10', $filters)  && is_numeric($filters['ISBN_10']))
        {
            $this->bindings['ISBN_10'] = $filters['ISBN_10'];
            $filteredBookIds .= ($filteredBookIds != "")? " UNION ALL " : "";
            $filteredBookIds .= "SELECT `id` AS 'book_id' FROM `books` WHERE `ISBN_10` = :ISBN_10";
        }

        $this->selectStatement = $filteredBookIds;
        return $this;
    }

    /**
     * Sorts the result based on the most repeated records
     *
     * @param array $result
     * @return array
     */
    private function sortByMostRepeated(array $result)
    {
        $count = array_count_values($result);
        arsort($count);

        return array_keys($count);
    }

    /**
     * Unsets array elements if not numeric
     *
     * @param array $numbers
     */
    private function deleteNonNumerics(array &$numbers)
    {
        foreach($numbers as $key => $val)
        {
            if(! is_numeric($val))
                unset($numbers[$key]);
        }
    }
}