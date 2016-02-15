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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Services\Search;

class BooksController extends ApiController {

    /**
     * @var array Book's possible conditions
     */
    private $conditions = ['New', 'Like New', 'Very Good', 'Good', 'Acceptable'];

    const WITH_ALL_PHOTOS = false;

    /**
     * @var \App\Helpers\Transformers\BookTransformer;
     */
    protected $bookTransformer;

    /**
     * @var \App\Helpers\Transformers\AuthorTransformer;
     */
    protected $authorTransformer;

    /**
     * @var \App\Helpers\Transformers\TagTransformer;
     */
    protected $tagTransformer;


    /**
     * Create a new instance of books controller.
     *
     * Setting middleware for auth users
     * @param BookTransformer $bookTransformer
     * @param AuthorTransformer $authorTransformer
     * @param TagTransformer $tagTransformer
     */
    public function __construct(BookTransformer $bookTransformer, AuthorTransformer $authorTransformer,
                                TagTransformer $tagTransformer)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('owner:books', ['only' => ['edit', 'destroy', 'update']]);

        $this->bookTransformer = $bookTransformer;
        $this->authorTransformer = $authorTransformer;
        $this->tagTransformer = $tagTransformer;
    }


    /**
     * Preforms searches and returns all books if no search was requested
     *
     * @param Search $search
     * @return \Illuminate\View\View
     */
    public function index(Search $search)
    {
        $result = null;
        $seachInputs = null;
        $limit = (int)(Input::get('limit', 10));

        if($limit > 50 || $limit < 1)
            $limit = 10;


        if(Input::get('search'))
        {
            $result = $search->on('books')->filter(Input::all())->get();
            $result = $result->paginate($limit);
            $seachInputs = Input::only(['title', 'author_list', 'course_list', 'instructor_list', 'ISBN_13', 'ISBN_10']);
        }
        else
            $result = Book::paginate($limit);


        $respond = $this->respondWithPagination($result, Input::except('page'), [
            'data' => $this->bookTransformer->transformCollection($result->all()),
            'search' => $seachInputs
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
        {
            return $this->respondNotFound();
        }

        return $this->respond([
            'data' => $this->bookTransformer->transform($book, self::WITH_ALL_PHOTOS)
        ]);
    }


    public function search(Search $search, Request $searchRequest)
    {
        $result = $search->on('books')->filter(Input::all())->get();
        dd($result);
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
        BookHelper::create_book($request);

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
        BookHelper::update_book($request, $book);

        return redirect('books');
    }

    /**
     * Deletes an existing book and moves it to sold_deleted_books table
     * Also moves the book's photos to images/sold_deleted_books/user_id
     *
     * @param Book $book
     * @param sold
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Book $book, $sold)
    {
        BookHelper::insert_into_sold_deleted_books_table($book, $sold);

        BookHelper::move_photos($book);

        $book->delete();

        return redirect('account/mybooks');
    }
}