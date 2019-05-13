<?php

Auth::routes();


Route::group(['middleware' => 'web'], function(){

    Route::get('/', 'HomeController@index')->name('home');

    Route::group(['as' => 'cabinet.', 'middleware' => 'auth', 'namespace' => 'Cabinet'], function(){
        Route::get('cabinet', 'SitesController@index')->name('sites');
        Route::get('cabinet/sites/add', 'SitesController@add')->name('sites.new');
        Route::post('cabinet/sites/addPost', 'SitesController@addPost')->name('sites.addPost');
        Route::get('cabinet/statistic/{site?}', 'StatisticController@index')->name('statistic');

        Route::get('cabinet/news/{category?}', 'NewsController@index')->name('news');
        Route::get('cabinet/news/{category}/{new}', 'ViewNewController@index')->name('view_new');

        Route::get('cabinet/contacts', 'ContactsController@index')->name('contacts');
        Route::get('cabinet/conditions', 'ConditionsController@index')->name('conditions');
        Route::get('cabinet/scripts/{scriptPages}', 'ScriptsController@index')->name('scripts');

        Route::group(['as' => 'messages.'], function(){
            Route::get('cabinet/message/write/{re_id?}', 'MessagesController@writeIndex')->name('write');
            Route::post('cabinet/message/write', 'MessagesController@writePost')->name('writePost');

            Route::get('cabinet/message/read/{id}', 'MessagesController@readIndex')->name('read');
            Route::get('cabinet/messages/inbox', 'MessagesController@inboxIndex')->name('inbox');
            Route::get('cabinet/messages/outbox', 'MessagesController@outboxIndex')->name('outbox');

            Route::group(['middleware' => 'ajax'], function(){
                Route::delete('cabinet/messages/outbox/delete', 'MessagesController@outboxDelete')->name('outbox.delete');
                Route::delete('cabinet/messages/inbox/delete', 'MessagesController@inboxDelete')->name('inbox.delete');
            });
        });

        Route::get('cabinet/profile', 'ProfileController@index')->name('profile');
        Route::post('cabinet/profile', 'ProfileController@edit')->name('profile_edit');
        Route::post('cabinet/profile/change_password', 'ProfileController@cgange_password')->name('profile_change_password');

        Route::get('cabinet/balance', 'BalanceController@index')->name('balance');
        Route::get('cabinet/payments', 'PaymentsController@index')->name('payments');
    });

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
