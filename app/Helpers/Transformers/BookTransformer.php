<?php

namespace App\Helpers\Transformers;

use App\Models\Book;
use App\Helpers\Transformers\TagTransformer;


class BookTransformer extends Transformer
{
    /**
     * @var array Book's possible conditions
     */
    private $conditions = ['New', 'Like New', 'Very Good', 'Good', 'Acceptable'];

    /**
     * @var instance of TagTransfomer class
     */
    private $tagTransformer;


    /**
     * Creates am instance of TagTransformer class
     *
     * @param \App\Helpers\Transformers\TagTransformer $tagTransformer
     */
    public function __construct(TagTransformer $tagTransformer){
        $this->tagTransformer = $tagTransformer;
    }

    /**
     * Transforms books for json response
     *
     * @param $book
     * @param bool $only_main_photo => true if book only needs the main photo
     * @return mixed
     */
    public function transform($book, $only_main_photo = true)
    {
        unset($book->user_id);
        unset($book->updated_at);

        $book->condition = "Very Good";

        $bookObject = Book::find($book->id);
        $book->instructors = $this->tagTransformer->tagsName('name')->transformCollection($bookObject->instructors->toArray());

        $book->courses = $this->tagTransformer->tagsName('full_course_name')->transformCollection($bookObject->courses->toArray());

        $book->authors = $this->tagTransformer->tagsName('full_name')->transformCollection($bookObject->authors->toArray());


        if($book->photos === null)
            return $book;

        if($only_main_photo)
        {
            $book->photos = explode(';', $book->photos, 2)[0];
            return $book;
        }

        $book->photos = explode(';', $book->photos);
        return $book;
    }
}