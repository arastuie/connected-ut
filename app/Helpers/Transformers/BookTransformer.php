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
     * @var instance of PhotoTransfomer class
     */
    private $photoTransformer;

    /**
     * Creates am instance of TagTransformer class
     *
     * @param \App\Helpers\Transformers\TagTransformer $tagTransformer
     * @param PhotoTransformer $photoTransformer
     */
    public function __construct(TagTransformer $tagTransformer, PhotoTransformer $photoTransformer){
        $this->tagTransformer = $tagTransformer;
        $this->photoTransformer = $photoTransformer;
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

        $book->condition = ($book->condition != null) ? $this->conditions[$book->condition] : null;
        $book->edition = ($book->edition != null) ? str_replace(['edition', 'Edition', 'ed'], '', $book->edition) : null;

        $bookObject = Book::find($book->id);
        $book->instructors = $this->tagTransformer->tagsName('name')->transformCollection($bookObject->instructors->toArray());

        $book->courses = $this->tagTransformer->tagsName('full_course_name')->transformCollection($bookObject->courses->toArray());

        $book->authors = $this->tagTransformer->tagsName('full_name')->transformCollection($bookObject->authors->toArray());


        $mainPhoto = $bookObject->mainPhoto();
        if(! is_null($mainPhoto))
            $book->main_photo = $mainPhoto->toArray();
        else
            $book->main_photo = null;

        if(! $only_main_photo)
            $book->photos = $this->photoTransformer->transformCollection($bookObject->photos->toArray());

        return $book;
    }
}