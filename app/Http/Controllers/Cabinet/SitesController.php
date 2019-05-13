<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sites;
use App\ApiService;

class SitesController extends Controller
{
    public function index(ApiService $apiService, Request $request)
    {
        //dd($apiService->overall_stats(4));

        $apiService->set_key_api();
        $sites = \App\Models\Sites::mySites();

        return view('sites', ['sites' => $sites]);
    }

    public function add(Request $request)
    {

        return view('addSite');
    }

    public function addPost(ApiService $apiService, Request $request)
    {
        $messages = [
            'name.required' => 'Поле имени сайта не может быть пустым.',
            'site.required' => 'Поле ввода сайта не может быть пустым.',
            'site.url' => 'Введите корректную ссылку.',
            'site.unique' => 'Такая ссылка уже существует в нашей базе данных!',
        ];
        $data = $this->validate($request, [
            'name' => 'required',
            'site' => 'required|url|unique:sites'
        ], $messages);

        $data['user_id'] = \Auth::user()->id;
        $site = Sites::create($data);
        if($site){
            return redirect()->route('cabinet.sites')->with(['status' => 'Сайт успешно добавлен!']);
        }
        else return back()->withInput()->withErrors(['Произошла ошибка при добовлении сайта!']);
        dd($request->all());
    }
}
