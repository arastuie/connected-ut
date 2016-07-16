<?php namespace App\Http\Controllers\Auth;

use create;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        return User::create([
            'email' => strtolower($data['email']),
            'password' => bcrypt($data['password']),
            'contact_email' => strtolower($data['email'])
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * If you change the password validation, change it on ChangePasswordRequest too.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        $rules = [
            'email' => 'required|email|max:255|unique:users|regex:/.+@rockets.utoledo.edu/i',
            'password' => 'required|min:6|confirmed'
        ];

        $messages = [
            'regex' => 'You must use your @rockets.utoledo.edu email address to sign up.',
            'min' => 'Your password must have at least 6 characters'
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
	 * Gets the token passed by the user to verify his/her email address
	 *
	 * @param $token
	 * @throws NotFoundHttpException
	 * * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function confirmEmail($token)
	{
		if (is_null($token))
			throw new NotFoundHttpException;

		$confirmToken = DB::table('user_email_confirmations')->where('token', $token)->first();

		if($confirmToken == null)
		{
			flash('error', 'Invalid!', 'This link is either not valid or has been expired!');
			return redirect('/');
		}

		$user = User::whereId($confirmToken->user_id)->first();

		if($user->active)
		{
			DB::table('user_email_confirmations')->where('user_id', $confirmToken->user_id)->delete();
			flash('error', 'Invalid!', 'This link is either not valid or has been expired!');
			return redirect('/');
		}

		$user->confirmEmail();

		DB::table('user_email_confirmations')->where('user_id', $confirmToken->user_id)->delete();

		flash('success', 'Confirmed!', 'Your email address is verified! You can login now!');

		return redirect('auth/login');
	}

	/**
	 * Deletes a user who signed up with an invalid email address
	 *
	 * @param $token
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws NotFoundHttpException
	 */
	public function DisconfirmEmail($token)
	{
		if (is_null($token))
			throw new NotFoundHttpException;

		$userID = DB::table('user_email_confirmations')->where('token', $token)->value('user_id');

		if($userID == null)
		{
			flash('error', 'Invalid!', 'This link is either not valid or has been expired!');
			return redirect('/');
		}

		$user = User::whereId($userID)->delete();

		DB::table('user_email_confirmations')->where('user_id', $userID)->delete();

		flash('info', 'We Apologies!', 'Your email has been removed from our records. Sorry for the inconvenience.');

		return redirect('/');
	}


	/**
	 * Resends a new email confirmation email and deletes the old one
	 *
	 * @param Request $request
	 * @param AppMailer $mailer
	 * @throws NotFoundHttpException
     */
	public function resendConfirmEmail(Request $request, AppMailer $mailer)
	{
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required',
		]);

		$user = User::whereEmail($request->input('email'))->first();

		if($user == null || ! Hash::check($request->input('password'), $user->password) || $user->active == true)
			throw new NotFoundHttpException;

		if(DB::table('user_email_confirmations')->where('user_id', $user->id)->value('token') == null)
			throw new NotFoundHttpException;

		DB::table('user_email_confirmations')->where('user_id', $user->id)->delete();

		$newToken = hash_hmac('sha256', str_random(40), env('HMAC_HASH'));
		$confirmEmail = DB::table('user_email_confirmations')->insert([
			'user_id' => $user->id,
			'token' => $newToken,
			'created_at' => Carbon::now()
		]);

		$mailer->sendEmailConfirmation($newToken, $user);
	}
}
