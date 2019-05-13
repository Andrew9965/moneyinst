<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index(Request $request)
    {

        return view('profile');
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        if($data['pk']!=\Auth::user()->id) return response('User not found!', 404);
        \App\User::where('id', $data['pk'])->update([$data['name'] => $data['value']]);
        return response('success', 200);
    }

    public function cgange_password(Request $request)
    {
        $messages = [
            'password.required' => 'Поле с паролем не может быть пустым.',
            'password.min' => 'Пароль должен состоять не менее чем из 6-ти символов.',
            'password.confirmed' => 'Пароли не совподают.',
        ];

        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed',
        ], $messages);

        \Auth::user()->password = bcrypt($request->password);
        \Auth::user()->save();

        return redirect()->route('cabinet.profile')->with(['status' => 'Ваш пароль успешно изменён!']);
    }
}
