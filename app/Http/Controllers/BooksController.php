<?php namespace App\Http\Controllers;

use Exception;
use App\Models\Book;
use App\Models\Tags\Course;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use App\Services\SearchService;
use App\Models\Tags\Instructor;
use App\Models\Photos\BookPhoto;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Helpers\BookHelpers\BookHelper;
use App\Helpers\Transformers\BookTransformer;
use App\Helpers\Transformers\PhotoTransformer;


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
        $this->middleware('owner:books', ['only' => ['edit', 'destroy', 'update', 'sold', 'uploadPhoto', 'deletePhoto', 'updateStatus']]);

        $this->bookTransformer = $bookTransformer;
    }


    /**
     * Returns all books ordered by most recent
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = SearchHelper::getPaginateLimit($request, self::DEF_PAGINATION_LIMIT);

        $result = Book::whereStatus(Book::STATUS['listed'])->orderBy('created_at', 'DESC')->paginate($limit);

        $respond = $this->respondWithPagination($result, $request->only('limit'), [
            'data' => $this->bookTransformer->transformCollection($result->all()),
            'search' => null,
            'query' => "",
            'current_url' => $request->url()
        ]);

        return view('books.index', compact('respond'));
    }


    /**
     * Show a single book
     *
     * @param Book $book
     * @return \Illuminate\View\View
     */
    public function show(Book $book)
    {
        if(!$book->id || ($book->status != Book::STATUS['listed'] && $book->user_id != Auth::id()))
            return abort(404);

        $contactInfo = $book->owner()->getContactInfo();

        $respond = $this->respond([
            'data' => $this->bookTransformer->transform($book, self::WITH_ALL_PHOTOS),
            'seller-info' => $contactInfo
        ]);

        return view('books.show', compact('respond'));
    }


    /**
     * Returns create book view
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::user();

        if($user->phone_number == null && ($user->firstname == null && $user->lastname == null))
            flash('update_persoanl_info', 'Update your contact info', 'Update your personal info for your convenience.');

        return view('books.create');
    }


    /**
     * Save a new book.
     *
     *
     * @param BookRequest $request
     * @return string
     */
    public function store(BookRequest $request)
    {
        try
        {
            $book = Auth::user()->books()->create(['title' => $request->title, 'status' => Book::STATUS['saved_for_later']]);
        }
        catch (Exception $e)
        {
            flash('error', 'Listing failed', 'Please try again. If the problem persist do not hesitate to contact us at support@connectedut.com.');
            return redirect('account/mybooks');
        }

        return redirect('books/'  .  $book->id . '/edit/');
    }


    /**
     * Show the page to edit an existing book.
     *
     * @param Book $book
     * @param PhotoTransformer $photoTransformer
     * @return \Illuminate\View\View
     */
    public function edit(Book $book, PhotoTransformer $photoTransformer)
    {
        $available_by = (is_null($book->available_by)) ? null : date('m/d/Y', strtotime($book->getOriginal('available_by')));

        $instructors = Instructor::lists('name', 'id');
        $courses = Course::lists('full_course_name', 'id');
        $authors = BookHelper::get_authors_list();

        $book->photos = $photoTransformer->transformCollection($book->photos()->get()->toArray());

        return view('books.edit', compact('book', 'available_by', 'instructors', 'courses', 'authors'));
    }


    /**
     * Update an existing book. Updates only one field per request, accessed by AJAX.
     *
     * @param BookRequest $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BookRequest $request, Book $book)
    {
        try{
            if($request->has('instructor_list'))
                BookHelper::syncInstructors($book, $request->input('instructor_list'));

            else if($request->has('course_list'))
                BookHelper::syncCourses($book, $request->input('course_list'));

            else if($request->has('author_list'))
                BookHelper::syncAuthors($book, $request->input('author_list'));

            else if($request->has('mainPhotoID')){
                $photo = BookPhoto::find($request->mainPhotoID);
                if($photo == null)
                    return response()->json(['success' => false, 'message' => 'Photo not found.'], 400);

                if($photo->book()->first()->id != $book->id)
                    return response()->json(['success' => false, 'message' => 'Authentication failed!'], 403);

                $currentMain = $book->mainPhoto();
                $currentMain->is_main = false;
                $currentMain->save();

                $photo->is_main = true;
                $photo->save();
            }
            else
                $book->update($request->all());
        }
        catch(Exception $e)
        {
            return response()->json(['success' => false, 'message' => 'Server error!'], 500);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Handles book photo uploads from an AJAX request
     *
     * @param BookRequest|Request $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPhoto(BookRequest $request, Book $book)
    {
        if(! $request->hasFile('photo'))
            return response()->json(['success' => false, 'message' => 'No photo received!'], 400);

        if(count($request->photo) > 1)
            return response()->json(['success' => false, 'message' => 'Upload only one photo at a time.'], 400);

        if(Auth::user()->id != $book->user_id)
            return response()->json(['success' => false, 'message' => 'Authentication failed!'], 403);

        // Check if more photos are allowed
        if($book->photos()->count() >= 4)
            return response()->json(['success' => false, 'message' => 'A book cannot have more than 4 photos.'], 400);

        // Save the photo
        $photo = null;
        try
        {
            $photo = BookHelper::savePhoto($request, $book);
        }
        catch(Exception $e)
        {
            return response()->json(['success' => false, 'message' => 'Server error.'], 500);
        }

        return response()->json(['success' => true, 'photo' => ['id' => $photo->id, 'isMain' => $photo->is_main], 'photoCount' => $book->photos()->count()], 201);
    }


    /**
     * Deletes a photo of a book
     *
     * @param Request $request
     * @param Book $book
     * @return mixed
     */
    public function deletePhoto(Request $request, Book $book)
    {
        if(! $request->has('photoID') || !is_numeric($request->photoID))
            return response()->json(['success' => false, 'message' => 'No photo id found.'], 400);

        $photo = BookPhoto::find($request->photoID);
        if($photo == null)
            return response()->json(['success' => false, 'message' => 'Photo not found.'], 400);

        if($photo->book()->first()->id != $book->id || $book->user_id != Auth::id())
            return response()->json(['success' => false, 'message' => 'Authentication failed!'], 403);

        $mainPhotoID = null;
        try
        {
            if(File::exists(public_path() . $photo->path))
                File::delete(public_path() . $photo->path);

            if(File::exists(public_path() . $photo->thumbnail_path))
                File::delete(public_path() . $photo->thumbnail_path);

            $was_main = $photo->is_main;

            $photo->delete();

            if($was_main && $book->photos()->count() > 0)
            {
                $mainPhoto = $book->photos()->first();
                $mainPhoto->is_main = true;
                $mainPhoto->save();
                $mainPhotoID = $mainPhoto->id;
            }

        }
        catch (Exception $e)
        {
            return response()->json(['success' => false, 'message' => 'Server error!'], 500);
        }

        return response()->json(['success' => true, 'photoCount' => $book->photos()->count(), 'mainPhotoID' => $mainPhotoID]);
    }


    /**
     * Changes book status
     *
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Book $book)
    {

        if($book->status == Book::STATUS['listed'])
        {
            $book->status = Book::STATUS['saved_for_later'];
        }
        else if($book->status == Book::STATUS['saved_for_later'])
        {
            if(empty($book->title) || empty($book->available_by) || is_null($book->condition) || is_null($book->price))
                return response()->json(['success' => false, 'bookStatus' => $book->status, 'message' => 'Required fields are not filled!'], 400);
            else
                $book->status = Book::STATUS['listed'];
        }

        try
        {
            $book->save();
        }
        catch(Exception $e)
        {
            return response()->json(['success' => false, 'bookStatus' => $book->status, 'message' => $e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'bookStatus' => $book->status]);
    }


    /**
     * Deletes an existing book and moves it to sold_deleted_books table as a sold book
     * Also moves the book's photos to images/sold_deleted_books/user_id
     *
     * @param Request $request
     * @param Book $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function soldOrDelete(Request $request, Book $book)
    {
        if(! $book->id)
            return response()->json(['success' => false, 'message' => 'Book not found!'], 400);

        if(Auth::user()->id != $book->user_id)
            return response()->json(['success' => false, 'message' => 'Authentication failed!'], 403);

        $isSold = (! $request->method() == "DELETE");

        // A book cannot be marked as sold if it was not listed
        if($isSold && $book->status == Book::STATUS['saved_for_later'])
            return response()->json(['success' => false, 'message' => 'A book cannot be marked as sold if it was not listed'], 400);

        try
        {
            BookHelper::insertIntoSoldDeletedBooksTable($book, $isSold);

            // Delete photos
            foreach($book->photos()->get() as $photo)
            {
                if(File::exists(public_path() . $photo->path))
                    File::delete(public_path() . $photo->path);

                if(File::exists(public_path() . $photo->thumbnail_path))
                    File::delete(public_path() . $photo->thumbnail_path);

                // BookPhoto table will get updated b/c of constraints
            }

            $book->delete();
        }
        catch (Exception $e)
        {
            return response()->json(['success' => false, 'message' => 'Server error!'], 500);
        }

        return response()->json(['success' => true], 200);
    }
}