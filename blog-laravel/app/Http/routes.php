<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//前台路由
Route::group(['namespace' => 'Home'], function () {

    Route::get('/', 'IndexController@index');

    Route::get('cate/{cate_id}', 'IndexController@cate');

    Route::get('a/{art_id}', 'IndexController@article');
});

//后台路由
Route::any('admin/login', 'Admin\LoginController@login');

Route::get('admin/code', 'Admin\LoginController@code');

Route::get('admin/password_key', 'Admin\LoginController@password_key');

Route::group(['middleware' => ['admin.login'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::get('/', 'IndexController@index');

    Route::get('info', 'IndexController@info');

    Route::get('quit', 'LoginController@quit');

    Route::any('pass', 'IndexController@pass');

    Route::post('cate/changeorder', 'CategoryController@changeOrder');

    Route::resource('category', 'CategoryController');

    Route::resource('article', 'ArticleController');

    Route::post('links/changeorder', 'LinksController@changeOrder');

    Route::resource('links', 'LinksController');

    Route::post('navs/changeorder', 'NavsController@changeOrder');

    Route::resource('navs', 'NavsController');

    Route::post('config/changeorder', 'ConfigController@changeOrder');

    Route::post('config/changecontent', 'ConfigController@changeContent');

    Route::get('config/putfile', 'ConfigController@putFile');

    Route::resource('config', 'ConfigController');

    Route::any('upload', 'CommonController@upload');

});