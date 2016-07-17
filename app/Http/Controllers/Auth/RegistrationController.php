<?php namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class RegistrationController extends Controller {

    use RedirectsUsers;

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \App\Http\Requests\RegisterRequest $request
     * @param AppMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function postRegister(RegisterRequest $request, AppMailer $mailer)
    {
        $user = $this->createUser($request->all());

        $this->createAndSendEmailConfirmation($user, $mailer);

        flash('success_info', 'Check your email!', 'Please confirm your email address and you are done!');

        return redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    private function createUser(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'contact_email' => $data['email']
        ]);
    }

    /**
     * Creates a email confirmation record and sends an email to the user
     *
     * @param User $user
     * @param AppMailer $mailer
     */
    private function createAndSendEmailConfirmation(User $user, AppMailer $mailer)
    {
        $token = hash_hmac('sha256', str_random(40), env('HMAC_HASH'));

        DB::table('user_email_confirmations')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $mailer->sendEmailConfirmation($token, $user);
    }

    /**
     * Gets the token passed by the user to verify his/her email address
     *
     * @param $token
     * @throws NotFoundHttpException
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmEmail($token)
    {
        if (is_null($token))
            throw new NotFoundHttpException;

        $confirmToken = DB::table('user_email_confirmations')->where('token', $token)->first();

        $isExpired = Carbon::parse($confirmToken->created_at)->diffInHours(Carbon::now()) > 24;

        if($confirmToken == null || $isExpired)
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
    public function disconfirmEmail($token)
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

        $this->createAndSendEmailConfirmation($user, $mailer);
    }
}