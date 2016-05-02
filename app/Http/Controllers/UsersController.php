<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Tags\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfoRequest;
use App\Http\Requests\changePasswordRequest;

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
    public function changePassword()
    {
        return view('users.change_password');
    }


    /**
     * Updates password
     *
     * @param changePasswordRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        if (Hash::check(($request->current_password), Auth::user()->password)
            && $request->new_password != $request->current_password)
        {

            $user = Auth::user();
            $user->password = bcrypt($request->new_password);
            $user->save();

            flash('success', 'Password Changed!', 'Your password has been updated successfully!');
            return redirect('account');
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


    /**
     * Shows all the books listed by the user
     *
     * @return \Illuminate\View\View
     */
    public function myBooks()
    {
        $books = Auth::user()->books()->orderBy('created_at', 'DESC')->get();

        foreach($books as $book)
            $book->photos = explode(';', $book->photos)[0];

        return view('users.mybooks', compact('books'));
    }


    /**
     * Update request for all the user info
     *
     * @return \Illuminate\View\View
     */
    public function editInfo()
    {
        $user = Auth::user()->toArray();

        $userDepartments = Auth::user()->departments->lists('name', 'id')->toArray();
        $user['created_at'] = Carbon::parse($user['created_at'])->toFormattedDateString();
        $user['department_list'] = $userDepartments;

        $departments = Department::lists('name', 'id');
        return view('users.updateInfo', compact('user', 'departments'));
    }


    /**
     * Updates user info
     *
     * @param UserInfoRequest $request
     * @return \Illuminate\View\View
     */
    public function updateInfo(UserInfoRequest $request)
    {
        $user = Auth::user();

        if($request->exists('department_list'))
            $this->syncDepartments($user, $request->input('department_list'));

        // Check to make sure one contact info is provided
        if(($request->exists('use_phone') && $request->use_phone == 0 && $user->use_email == false) ||
            $request->exists('use_email') && $request->use_email == 0 && $user->use_phone == false)
        {
            flash('error', 'Update denied!', 'You cannot have both your email and phone number not listed in your contact info, otherwise buyers have no way of contacing you.');
            return $this->editInfo();
        }


        $user->update($request->all());

        flash('success', 'Info updated!', 'Your personal information has been updated!');
        return $this->editInfo();
    }

    /**
     * Sync up the list of departments in the database
     *
     * @param User $user
     * @param array $departments
     */
    public static function syncDepartments(User $user, $departments)
    {
        if(is_null($departments))
            $departments = [];
        $user->departments()->sync($departments);
    }
}