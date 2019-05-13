<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Foundation\Auth\RegistersUsers;
use Bestmomo\LaravelEmailConfirmation\Traits\RegistersUsers;
use App\Models\Invites;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'invite.required' => 'Обязательный параметр',
            'invite.min' => 'Не правильные данные',
            'invite.exists' => 'Инвайт не найден'
        ];

        $valid_fields = [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'wmr' => 'required|string|regex:/^r\d{12}$/i',
            'invite' => ['required','min:30',
                Rule::exists('invites')->where(function ($query) {
                    $query->where('user_id', 0)->where('status',1);
                })]
        ];

        return Validator::make($data, $valid_fields, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $return = User::create([
            'name' => $data['username'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'skype' => $data['skype'],
            'icq' => $data['icq'],
            'wmr' => $data['wmr'],
            'invite' => $data['invite']
        ]);

        Invites::where('invite', $data['invite'])->update([
            'user_id' => $return->id,
            'registred_at' => now(),
            'status' => 0
        ]);

        return $return;
    }
}
