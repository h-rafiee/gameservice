<?php



Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'admin.auth'],function(){
    Route::get('/',function(){
        return view('admin.index');
    });
    Route::get('logout','AdminController@logout');

    Route::resource('users','UserController');


    Route::resource('categories','CategoryController');


    Route::resource('games','GameController');


    Route::get('achievements/game/{id}','GameAchievementController@index');
    Route::get('achievements/game/{id}/add','GameAchievementController@create');

    Route::resource('achievements','GameAchievementController',['only'=>[
        'store','edit','destroy','update'
    ]]);


    Route::get('items/game/{id}','GameItemController@index');
    Route::get('items/game/{id}/add','GameItemController@create');

    Route::resource('items','GameItemController',['only'=>[
        'store','edit','destroy','update'
    ]]);

    // Ajax
    Route::group(['middleware' => 'ajax','prefix'=>'ajax'],function(){

    });

});
Route::get('/admin-login',['middleware' => 'admin.guest','uses'=>'Admin\AdminController@getLogin']);
Route::post('/admin-login',['middleware' => 'admin.guest','uses'=>'Admin\AdminController@postLogin']);