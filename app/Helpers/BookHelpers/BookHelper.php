<?php

namespace App\Helpers\BookHelpers;

use App\Book;
use App\Http\Requests\BookRequest;
use App\Models\Tags\Author;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;


class BookHelper
{
    /**
     *  Insert the sold/deleted book's info into sold_deleted_books table
     *
     * @param Book $book
     * @param $sold: routes wildcard. true = sold, false = deleted
     * @return View
     */
    public static function insert_into_sold_deleted_books_table(Book $book, $sold)
    {
        if(!$book->id)
            return redirect('account/mybooks');

        if($sold === 'true')
            $is_sold = 1;
        else if($sold === 'false')
            $is_sold = 0;
        else
            return redirect('account/mybooks');

        DB::table('sold_deleted_books')->insert([
            'user_id' => $book->user_id,
            'is_sold' => $is_sold,
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
            'photos' => $book->photos,
            'available_by' => $book->getOriginal('available_by'),
            'posted_at' => $book->getOriginal('created_at'),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }


    /**
     *  Resizes all the photos to width=400 then saves all the photos in
     * /images/books/"user's id"/"user's id + time + photo number + extension"
     * Then saves an string of folder/photoName divided by ';' to the database
     *
     * @param BookRequest $request
     * @return array photo_array
     */
    public static function save_photos(BookRequest $request)
    {
        $users_id = Auth::user()->id;
        $users_photos_path = public_path() . '/images/books/' . $users_id . '/';
        $photo_array = [];

        if(count($request->pics) > 4)
            redirect('/');

        foreach($request->pics as $key => $photo)
        {
            if($photo != null)
            {
                $extension = explode('.', $photo->getClientOriginalName());
                $extension = end($extension);
                $image = Image::make($photo);
                $fileName = $users_id . time() . $key . '.' . $extension;

                if(($image->width() / $image->height()) >= 1)
                {
                    $image->resize(400, null, function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }else{
                    $image->resize(null, 400, function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                File::exists($users_photos_path) or File::makeDirectory($users_photos_path);
                $image->save($users_photos_path . $fileName);
                $photo_array[$key] = $users_id . '/' . $fileName;
            }
        }

        $photos = count($photo_array) > 0 ? implode(';', $photo_array) : null;
        $request->request->add(['photos' => $photos]);

        // Just for update to match del pics
        return $photo_array;
    }



    /**
     * delete photos and regenerate photo_array (returned from save_photo()) based on
     * the update request
     *
     * @param BookRequest $request
     * @param $book
     */
    public static function update_photos(BookRequest $request, $book)
    {
        $photo_array = self::save_photos($request);

        $uploaded_pics = ($book->photos != null)? explode(';', $book->photos): null;

        if($request->deleted_pics != '')
        {
            $del_pics = explode(';', $request->deleted_pics);

            foreach($del_pics as $del_pic)
            {
                File::delete(public_path() . '/images/books/' . $uploaded_pics[$del_pic]);

                unset($uploaded_pics[$del_pic]);
            }
        }

        if($uploaded_pics != null)
            $photo_array += $uploaded_pics;


        if(count($photo_array) > 0)
        {
            ksort($photo_array);
            $photos = implode(';', $photo_array);
        }else
            $photos = null;


        $request->request->set('photos' , $photos);
    }


    /**
     * Moves all the photos of the deleted book to /images/sold_deleted_books/user_id
     * Also deletes the deleted's book prev directory if empty
     *
     * @param Book $book
     * @param $book
     */
    public static function move_photos(Book $book)
    {
        if($book->photos === null)
            return;

        $users_deleted_photos_path = public_path() . '/images/sold_deleted_books/';
        $users_photos_path = public_path() . '/images/books/';
        $photos = explode(';', $book->photos);

        File::exists($users_deleted_photos_path . $book->user_id) or File::makeDirectory($users_deleted_photos_path . $book->user_id);

        foreach($photos as $photo)
        {
            if(File::exists($users_photos_path . $photo))
                File::move($users_photos_path . $photo, $users_deleted_photos_path . $photo);
        }

        // Checks if the directory is empty
        if(count(glob(public_path() . '/images/books/' . $book->user_id . '/*', GLOB_NOSORT)) === 0)
            File::deleteDirectory($users_photos_path . $book->user_id);
    }



    /**
     * Replaces the string in $book->photos with an array of photos
     *
     *
     * @param $book Book object
     * @param bool $main true returns just the main photo, false returns all
     */
    public static function photo_explode($book, $main = false)
    {

        if($book->photos === null)
            return;

        if($main)
        {
            $book->photos = explode(';', $book->photos, 2)[0];
            return;
        }

        $book->photos = explode(';', $book->photos);

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
     * @param BookRequest $request
     */
    public static function syncAuthors(Book $book, BookRequest $request)
    {
        $authors = $request->input('author_list');
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



    /**
     * Save a new book
     * @param BookRequest $request
     * @return mixed
     */
    public static function create_book(BookRequest $request)
    {
        self::save_photos($request);

        $book = Auth::user()->books()->create($request->all());

        self::syncInstructors($book, $request->input('instructor_list'));
        self::syncCourses($book, $request->input('course_list'));
        self::syncAuthors($book, $request);

        return $book;
    }



    /**
     * Update an edited book
     *
     * @param BookRequest $request
     * @param Book $book
     * @return mixed
     */
    public static function update_book(BookRequest $request, Book $book)
    {
        self::update_photos($request, $book);

        $book->update($request->all());

        self::syncInstructors($book, $request->input('instructor_list'));
        self::syncCourses($book, $request->input('course_list'));
        self::syncAuthors($book, $request);
    }
}