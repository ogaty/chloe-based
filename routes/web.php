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

Auth::routes();

Route::get('/', 'Frontend\BlogController@index')->name('home');
Route::get('/sitemap.xml', 'Frontend\BlogController@sitemap')->name('front.sitemap');
Route::get('/feed', 'Frontend\BlogController@feed')->name('front.feed');
Route::get('/blog/post/{slug}', 'Frontend\BlogController@showPost')->name('front.post');
Route::get('/search', 'Frontend\SearchController@index')->name('front.search');

Route::group([
    'middleware' => ['auth'],
    'namespace' => 'Backend',
], function () {
    Route::get('/adm', 'HomeController@index')->name('admin');
});
