<?php namespace App\Http\Controllers;

use App\Book;
use App\Helpers\BookHelpers\BookHelper;
use App\Helpers\Transformers\AuthorTransformer;
use App\Helpers\Transformers\BookTransformer;
use App\Helpers\Transformers\TagTransformer;
use App\Http\Requests;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\ApiController;
use App\Models\Tags\Author;
use App\Models\Tags\Instructor;
use App\Models\Tags\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Services\Search;

class BooksController extends ApiController {
    // A flag for photos
    const WITH_ALL_PHOTOS = false;

    /**
     * @var \App\Helpers\Transformers\BookTransformer;
     */
    protected $bookTransformer;

    /**
     * Create a new instance of books controller.
     *
     * Setting middleware for auth users
     * @param BookTransformer $bookTransformer
     */
    public function __construct(BookTransformer $bookTransformer)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('owner:books', ['only' => ['edit', 'destroy', 'update', 'sold']]);

        $this->bookTransformer = $bookTransformer;
    }


    /**
     * Preforms searches and returns all books if no search was requested
     *
     * @param Search $search
     * @return \Illuminate\View\View
     */
    public function index(Search $search, Request $request)
    {
        $result = null;
        $seachInputs = null;
        $limit = (int)(Input::get('limit', 10));

        if($limit > 50 || $limit < 5)
            $limit = 10;

        if(Input::get('search'))
        {
            $result = $search->on('books')->filter(Input::all())->get();
            $result = $result->paginate($limit);
            $seachInputs = Input::only(['title', 'author_list', 'course_list', 'instructor_list', 'ISBN_13', 'ISBN_10']);
        }
        else
            $result = Book::orderBy('created_at', 'DESC')->paginate($limit);
//            $books = Auth::user()->books()->orderBy('created_at', 'DESC')->get();

        $respond = $this->respondWithPagination($result, Input::except('page'), [
            'data' => $this->bookTransformer->transformCollection($result->all()),
            'search' => $seachInputs,
            'query' => http_build_query(Input::except(['limit', 'page']))
        ]);

//        dd($respond->getContent());
        return view('books.index', compact('respond'));
    }


    /**
     * Show a single book.
     *
     * @param Book $book
     * @return \Illuminate\View\View
     */
    public function show(Book $book)
    {
//        BookHelper::photo_explode($book);
//
//        $conditions = $this->conditions;
//
//        return view('books.show', compact('book', 'conditions'));

        if(!$book->id)
            return $this->respondNotFound();

        $contactInfo = $book->owner()->getContactInfo();

        $respond = $this->respond([
            'data' => $this->bookTransformer->transform($book, self::WITH_ALL_PHOTOS),
            'seller-info' => $contactInfo
        ]);

        return view('books.show', compact('respond'));
    }


    /**
     * Show the page to create a new book.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $instructors = Instructor::lists('name', 'id');
        $courses = Course::lists('full_course_name', 'id');
        $authors = BookHelper::get_authors_list();
//        $authors = Author::all();
//        $instructors = Instructor::all();
//        $courses = Course::all();
//
//        $data = $this->respond([
//            'data' => [
//                'authors' => $this->authorTransformer->transformCollection($authors->toArray()),
//                'instructors' => $this->tagTransformer->transformCollection($instructors->toArray()),
//                'courses' => $this->tagTransformer->tagsName('full_course_name')->transformCollection($courses->toArray()),
//            ]
//        ]);

        $user = Auth::user();
        if($user->phone_number == null || $user->firstname == null || $user->lastname == null)
            flash('update_persoanl_info', 'Update your contact info', 'Update your personal info for your convenience.');

        return view('books.create', compact('instructors', 'courses', 'authors'));
    }


    /**
     * Save a new book.
     *
     * @return string
     * @param BookRequest $request
     */
    public function store(BookRequest $request)
    {
        try
        {
            BookHelper::create_book($request);
        }
        catch(Exception $ex)
        {
            flash('error', 'Listing failed', 'Please try again. If the problem persist do not hesitate to contact us.');
            return redirect('books');
        }

        flash('success', 'Listed!', 'Your book has been listed successfully.');

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
        BookHelper::photo_explode($book);
        $available_by = date('m/d/Y', strtotime($book->available_by));

        $instructors = Instructor::lists('name', 'id');
        $courses = Course::lists('full_course_name', 'id');
        $authors = BookHelper::get_authors_list();

        return view('books.edit', compact('book', 'available_by', 'instructors', 'courses', 'authors'));
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
        try
        {
            BookHelper::update_book($request, $book);
        }
        catch(Exception $ex)
        {
            flash('error', 'Update failed!', 'Please try again. If the problem persist do not hesitate to contact us.');
            return redirect('books');
        }

        flash('success', 'Updated!', 'Your book has been successfully updated.');

        return redirect('books');
    }

    /**
     * Deletes an existing book and moves it to sold_deleted_books table as a sold book
     * Also moves the book's photos to images/sold_deleted_books/user_id
     *
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sold(Book $book)
    {
        if(!$book->id)
            return redirect('/books');

        BookHelper::insert_into_sold_deleted_books_table($book, true);

        BookHelper::move_photos($book);

        $book->delete();
    }


    /**
     * Deletes an existing book and moves it to sold_deleted_books table as a deleted book
     * Also moves the book's photos to images/sold_deleted_books/user_id
     *
     * @param Book $book
     * @param sold
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Book $book)
    {
        if(!$book->id)
            return redirect('/books');

        BookHelper::insert_into_sold_deleted_books_table($book, false);

        BookHelper::move_photos($book);

        $book->delete();
    }
}