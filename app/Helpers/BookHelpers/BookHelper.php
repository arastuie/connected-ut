<?php namespace App\Helpers\BookHelpers;

use App\Models\Book;
use App\Models\Tags\Author;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class BookHelper
{
    /**
     *  Insert the sold/deleted book's info into sold_deleted_books table
     *
     * @param Book $book
     * @param $sold: true = sold, false = deleted
     * @return void
     */
    public static function insertIntoSoldDeletedBooksTable(Book $book, $sold)
    {
        DB::table('sold_deleted_books')->insert([
            'user_id' => $book->user_id,
            'is_sold' => $sold,
            'title' => $book->title,
            'edition' => $book->edition,
            'instructors' => implode(', ', $book->instructor_list),
            'courses' => implode(', ', $book->course_list),
            'authors' => implode(', ', $book->author_list),
            'publisher' => $book->publisher,
            'ISBN_10' => $book->ISBN_10,
            'ISBN_13' => $book->ISBN_13,
            'published_year' => $book->published_year,
            'description' => $book->description,
            'condition' => $book->condition,
            'price' => $book->price,
            'obo' => $book->obo,
            'photo_count' => $book->photos()->count(),
            'available_by' => $book->getOriginal('available_by'),
            'posted_at' => $book->getOriginal('created_at'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }


    /**
     *  Resize the photo to width=500 and creates a thumbnail then saves them in
     * /images/books/"user's id"/"user's id + uniqueid + photo number + extension"
     * then inserts a new record to book_photos table
     *
     * @param BookRequest $request
     * @param Book $book
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function savePhoto(BookRequest $request, Book $book)
    {
        $photo = $request->photo;

        $image = Image::make($photo);

        if(($image->width() / $image->height()) >= 1)
        {
            $image->resize(700, null, function($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        else
        {
            $image->resize(null, 700, function($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        $user_id = Auth::user()->id;
        $photo_public_path = '/images/books/' . $user_id . '/';
        $user_photos_path = public_path() . $photo_public_path;
        $extension = explode('.', $photo->getClientOriginalName());
        $extension = '.' . end($extension);
        $fileName = $user_id . '-' .  uniqid();

        // Check if the file exists, just add '-1' since it is based on milliseconds
        if(File::exists($user_photos_path . $fileName  . $extension))
            $fileName .= '-1';

        File::exists($user_photos_path) or File::makeDirectory($user_photos_path);
        $image->save($user_photos_path . $fileName  . $extension);

        // Creating and saving thumbnail
        $thumb_image = Image::make($photo);
        $thumb_image->resize(150, 150, function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $thumb_fileName = $fileName . '-thumb';
        $thumb_image->save($user_photos_path . $thumb_fileName . $extension);

        $uploadedPhoto = $book->photos()->create([
            'path' => $photo_public_path . $fileName . $extension,
            'filename' => $fileName  . $extension,
            'thumbnail_path' => $photo_public_path . $thumb_fileName . $extension,
            'thumbnail_filename' => $thumb_fileName . $extension,
            'is_main' => ($book->photos()->count() == 0)
        ]);

        return $uploadedPhoto;
    }


    /**
     * Sync up the list of instructors in the database
     *
     * @param Book $book
     * @param array $instructors
     */
    public static function syncInstructors(Book $book, $instructors)
    {
        if(is_null($instructors))
            $instructors = [];
        $book->instructors()->sync($instructors);
    }


    /**
     * Sync up the list of courses in the database:
     *
     * @param Book $book
     * @param array $courses
     */
    public static function syncCourses(Book $book, $courses)
    {
        if(is_null($courses))
            $courses = [];
        $book->courses()->sync($courses);
    }


    /**
     * Sync up the list of authors in the database
     * And create a new author if not existed
     *
     * @param Book $book
     * @param array $authors
     */
    public static function syncAuthors(Book $book, $authors)
    {
        if(is_null($authors))
            $authors = [];
        foreach($authors as $key => $author)
        {
            if(!strpos($author, '#^'))
            {
                $newAuthor = Author::firstOrCreate(['full_name' => $author]);
                $authors[$key] = $newAuthor['id'];
            }
            else
            {
                $oldAuthor = explode('#^', $author);
                $authorID = $oldAuthor[0];
                $authorName = $oldAuthor[1];
                if(Author::find($authorID)['full_name'] == $authorName)
                    $authors[$key] = $authorID;
                else
                    unset($authors[$key]);
            }
        }

        $book->authors()->sync($authors);
    }


    /**
     * Returns all the authors as a key-value pair as 'id#^full_name'
     *
     * @param
     * @return array
     */
    public static function get_authors_list()
    {
        $authors = Author::lists('full_name', 'id');

        foreach($authors as $id => $author)
        {
            $authors[$id . '#^' . $author] = $authors[$id];
            unset($authors[$id]);
        }

        return $authors;
    }
}