<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Bestmomo\LaravelEmailConfirmation\Traits\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    protected function validateLogin(Request $request)
    {
        $loginData = $request->all();

        $messages = [
            $this->username().'.exists' => 'Пользователь "'.$loginData[$this->username()].'" не найден',
            'password.exists' => 'Неверный пароль',
        ];

        $this->validate($request, [
            $this->username() => [
                'required',
                'string',
                Rule::exists('users')->where(function ($query) use ($request, $loginData) {
                    $query->where($this->username(), $loginData[$this->username()]);
                })
            ],
        ], $messages);

        $credentials = $request->only(['username', 'password']);
        $credentials['is_admin'] = 1;
        Auth::guard('admin')->attempt($credentials);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            //$this->username() => [trans('auth.failed')],
            'password' => ['Неверный пароль']
        ]);
    }
}
