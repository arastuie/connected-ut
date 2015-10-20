<?php namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;

use App\Models\Tags\Instructor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class BooksController extends Controller {

    /**
     * @var array Book's possible conditions
     */
    private $conditions = ['New', 'Like New', 'Very Good', 'Good','Acceptable'];



    /**
     * Create a new instance of books controller.
     *
     * Setting middleware for auth users
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('owner:books', ['only' => 'edit']);
    }



    /**
     * Show all books.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $books = Book::latest('created_at')->get();

        foreach($books as $book)
        {
            $this->photo_explode($book, true);
        }

        $conditions = $this->conditions;

        return view('books.index', compact('books', 'conditions'));
    }


    /**
     * Show a single book.
     *
     * @param Book $book
     * @return \Illuminate\View\View
     */
    public function show(Book $book)
    {
        $this->photo_explode($book);

        $conditions = $this->conditions;

        return view('books.show', compact('book', 'conditions'));
    }



    /**
     * Show the page to create a new book.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $instructors = Instructor::lists('name', 'id');
        return view('books.create', compact('instructors'));
    }



    /**
     * Save a new book.
     *
     * @return string
     */
    public function store(BookRequest $request)
    {
        $this->save_photos($request);

        $this->createBook($request);

        return redirect('books');
    }



    /**
     * Show the page to edit an existing book.
     *
     * @param Book $book
     * @return \Illuminate\View\View
     */
    public function edit(Book $book)
    {
        $this->photo_explode($book);

        $available_by = date('m/d/Y', strtotime($book->available_by));

        return view('books.edit', compact('book', 'available_by'));
    }


    /**
     * Update an existing book.
     *
     * @param BookRequest $request
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(BookRequest $request, Book $book)
    {
        $this->update_photos($request, $book);

        $book->update($request->all());

        $this->syncInstructors($book, $request->input('instructor_list'));

        return redirect('books');
    }



    /**
     *  Resizes all the photos to width=400 then saves all the photos in
     * /images/books/"user's id"/"user's id + time + photo number + extension"
     * Then saves an string of folder/photoName divided by ';' to the database
     *
     * @param $request
     * @return array photo_array
     */
    private function save_photos($request)
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
                //  array_push($photos, $users_id . '/' . $fileName);
            }
        }

        $photos = count($photo_array) > 0 ? implode(';', $photo_array) : null;
        $request->request->add(['photos' => $photos]);

        // Just for update to match with del pics
        return $photo_array;
    }



    /**
     * delete photos and regenerate photo_array (returned from save_photo()) based on
     * the update request
     *
     * @param $request
     * @param $book
     */
    private function update_photos($request, $book)
    {
        $photo_array = $this->save_photos($request);

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

        }else{

            $photos = null;
        }


        $request->request->set('photos' , $photos);
    }



    /**
     * Replaces the string in $book->photos with an array of photos
     *
     *
     * @param $book Book object
     * @param bool $main true returns just the main photo, false returns all
     */
    private function photo_explode($book, $main = false)
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
    private function syncInstructors(Book $book, array $instructors)
    {
        $book->instructors()->sync($instructors);
    }


    /**
     * Save a new book
     * @param BookRequest $request
     * @return mixed
     */
    private function createBook(BookRequest $request)
    {
        $book = Auth::user()->books()->create($request->all());

        $this->syncInstructors($book, $request->input('instructor_list'));

        return $book;
    }
}