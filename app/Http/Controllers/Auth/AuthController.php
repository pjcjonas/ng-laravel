<?php
namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests\Auth\LoginRequest;


class AuthController extends Controller
{

    /*
    * User Model Instance
    * @var User
    */
    protected $user;

    /*
    * Auth Gaurd
    * @var Auth
    */
    protected $auth;

    /**
     * Auth controller constructor
     *
     * @param  Authenticator  $auth
     * @return void
     */
    public function __construct(Guard $auth, User $user)
    {
        $this->user = $user;
        $this->auth = $auth;

        //$this->middleware('guest', ['except' => ['getLogout']]);
    }

    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function loginPage()
    {
        return view('login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return Response
     */
    public function postLogin(LoginRequest $request)
    {
        if ($this->auth->attempt($request->only('email', 'password'))) {
            return redirect('/dashboard');
        }

        return redirect('/login')->withErrors([
            'email' => 'Invalid credentials. Remember, be better.',
        ]);
    }

    /**
     * User Logout.
     *
     * @return Response
     */
    public function getLogout()
    {
        $this->auth->logout();

        return redirect('/login');
    }

}
