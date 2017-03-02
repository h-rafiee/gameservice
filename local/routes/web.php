<?php



Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'admin.auth'],function(){
    Route::get('/',function(){
        return view('admin.index');
    });
    Route::get('logout','AdminController@logout');


    // Ajax
    Route::group(['middleware' => 'ajax','prefix'=>'ajax'],function(){

    });

});
Route::get('/admin-login',['middleware' => 'admin.guest','uses'=>'Admin\AdminController@getLogin']);
Route::post('/admin-login',['middleware' => 'admin.guest','uses'=>'Admin\AdminController@postLogin']);