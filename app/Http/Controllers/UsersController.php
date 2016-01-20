<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\changePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller {

    /**
     * Users Authentication middleware for all pages
     */
    public function __construct()
    {
        $this->middleware('auth');
    }



    /**
     * Returns users account manager page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $books = Auth::user()->books;
        foreach($books as $book)
        {
            $book->photos = explode(';', $book->photos)[0];
        }
        return view('users.index', compact('books'));
    }



    /**
     * Returns change password page view
     *
     * @return \Illuminate\View\View
     */
    public function change_password()
    {
        return view('users.change_password');
    }



    /**
     * Updates password
     *
     * @param changePasswordRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update_password(ChangePasswordRequest $request)
    {
        if (Hash::check(($request->current_password), Auth::user()->password)
            && $request->new_password != $request->current_password)
        {

            $user = Auth::user();
            $user->password = bcrypt($request->new_password);
            $user->save();

            return redirect('account')->with([
                'flash_message' => 'Your password has been changed successfully!'
            ]);
        }

        if (Hash::check(($request->current_password), Auth::user()->password))
        {
            return view('users.change_password')->withErrors(
                'The new password cannot be the same as your current one.'
            );

        }

        return view('users.change_password')->withErrors(
            'Your current password does not match with our records.'
        );
    }

    public function update()
    {
        return view('users.update');
    }

    public function my_books()
    {
        $books = Auth::user()->books;
        foreach($books as $book)
            $book->photos = explode(';', $book->photos)[0];

        return view('users.mybooks', compact('books'));
    }
}