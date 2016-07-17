<?php namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller {

    //use AuthenticatesAndRegistersUsers
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(LoginRequest $request)
    {
        if ($this->hasTooManyLoginAttempts($request))
            return $this->sendLockoutResponse($request);

        $credentials = $this->getCredentials($request);

        // Check if credentials are right but user is not active
        if(Auth::validate($request->only($this->loginUsername(), 'password')) && ! Auth::validate($credentials))
            return view('/auth/reconfirm')->with(['email' => $request->input($this->loginUsername())]);

        if (Auth::attempt($credentials, $request->has('remember')))
            return $this->handleUserWasAuthenticated($request);

        $this->incrementLoginAttempts($request);

        return redirect('/auth/login')
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => 'These credentials do not match our records.',
            ]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request)
    {
        $this->clearLoginAttempts($request);

        flash('success', 'Welcome Back!', 'Have a good time connecting!');

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return [
            $this->loginUsername() => $request->input($this->loginUsername()),
            'password' => $request->password,
            'active' => 1
        ];
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Auth::logout();

        flash('success', 'See you soon!', 'Hope you had a good time connecting!');

        return redirect('/');
    }
}
