<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('auth/logout', 'AuthController@getLogout');
    $router->get('auth/users_balance/{user}', 'UserController@users_balance')->name('users_balance');
    $router->post('auth/users_balance/{user}', 'UserController@users_balance_post')->name('users_balance_post');
    $router->get('auth/users_balance_get_statistic/{user}', 'UserController@get_statistic')->name('users_balance_get_statistic');

    $router->resource('auth/users', 'UserController');
    $router->resource('sites', 'SitesController');

    $router->resource('/scriptFiles', ScriptsController::class);
    $router->resource('/news', NewsController::class);
    $router->resource('/news_categories', NewsCategoriesController::class);
    $router->get('/payments/wallet', 'PaymentsController@get_wallet');
    $router->resource('/payments', PaymentsController::class);
    $router->resource('/script_pages', ScriptPagesController::class);
    $router->post('/messages/{messages}', 'MessagesController@enter_to_message')->name('enter_to_message');
    $router->resource('/messages', MessagesController::class);
    $router->resource('/invites', InvitesController::class);

    $router->get('pageScript', 'PageScriptsController@index');
    $router->get('pageConditions', 'PageConditionsController@index');
    $router->post('pageScript', 'PageScriptsController@save')->name('admin.scripts.save');

});



Route::get('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
Route::post('/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\UploadController@upload');

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => 'auth',
], function ($router) {
    $router->get('auth/login', 'AuthController@getLogin');
});