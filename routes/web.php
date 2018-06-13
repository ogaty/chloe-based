<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'Frontend\HomeController@index')->name('home');
Route::get('/sitemap.xml', 'Frontend\HomeController@sitemap')->name('front.sitemap');
Route::get('/feed', 'Frontend\HomeController@feed')->name('front.feed');
Route::get('/blog/post/{slug}', 'Frontend\HomeController@showPost')->name('front.post');
Route::get('/search', 'Frontend\SearchController@index')->name('front.search');

Route::group([
    'middleware' => ['auth'],
    'namespace' => 'Backend',
], function () {
    Route::get('/adm', 'HomeController@index')->name('admin');
});
