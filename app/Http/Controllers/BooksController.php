<?php namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests;
use App\Models\Tags\Author;
use App\Models\Tags\Course;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use App\Services\SearchService;
use App\Models\Tags\Instructor;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Helpers\BookHelpers\BookHelper;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Response;
use App\Helpers\Transformers\TagTransformer;
use App\Helpers\Transformers\BookTransformer;
use App\Helpers\Transformers\AuthorTransformer;

class BooksController extends ApiController {
    // A flag for photos
    const WITH_ALL_PHOTOS = false;
    const DEF_PAGINATION_LIMIT = 10;

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
        $this->middleware('auth', ['except' => ['index', 'show', 'search']]);
        $this->middleware('owner:books', ['only' => ['edit', 'destroy', 'update', 'sold']]);

        $this->bookTransformer = $bookTransformer;
    }


    /**
     * Returns all books ordered by most recent
     *
     * @param SearchService $search
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(SearchService $search, Request $request)
    {
        $limit = SearchHelper::getPaginateLimit($request, self::DEF_PAGINATION_LIMIT);

        $result = Book::orderBy('created_at', 'DESC')->paginate($limit);

        $respond = $this->respondWithPagination($result, $request->only('limit'), [
            'data' => $this->bookTransformer->transformCollection($result->all()),
            'search' => null,
            'query' => "",
            'current_url' => $request->url()
        ]);

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