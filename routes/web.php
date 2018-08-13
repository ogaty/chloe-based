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

//Auth::routes();
Route::get('/adm/lin', '\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/adm/lin', '\App\Http\Controllers\Auth\LoginController@login')->name('login');

Route::get('/adm/lout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::post('/adm/lout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/', 'Frontend\BlogController@index')->name('home');
Route::get('/sitemap.xml', 'Frontend\BlogController@sitemap')->name('front.sitemap');
Route::get('/feed', 'Frontend\BlogController@feed')->name('front.feed');
Route::get('/blog/post/{slug}', 'Frontend\BlogController@showPost')->name('front.post');
Route::get('/search', 'Frontend\SearchController@index')->name('front.search');

Route::group([
    'middleware' => ['auth'],
    'namespace' => 'Backend',
], function () {
    Route::get('/adm', 'HomeController@index')->name('admin.home');
    Route::resource('/adm/post', 'PostController', [
        'except' => 'show',
        'names' => [
            'index' => 'admin.post.index',
            'create' => 'admin.post.create',
            'store' => 'admin.post.store',
            'edit' => 'admin.post.edit',
            'update' => 'admin.post.update',
            'destroy' => 'admin.post.destroy',
        ],
    ]);
    Route::resource('/adm/tag', 'TagController', [
        'except' => 'show',
        'names' => [
            'index' => 'admin.tag.index',
            'create' => 'admin.tag.create',
            'store' => 'admin.tag.store',
            'edit' => 'admin.tag.edit',
            'update' => 'admin.tag.update',
            'destroy' => 'admin.tag.destroy',
        ],
    ]);
    Route::resource('/adm/setting', 'SettingsController', [
        'except' => 'show',
        'names' => [
            'index' => 'admin.setting.index',
            'create' => 'admin.setting.create',
            'store' => 'admin.setting.store',
            'edit' => 'admin.setting.edit',
            'update' => 'admin.setting.update',
            'destroy' => 'admin.setting.destroy',
        ],
    ]);
    Route::resource('/adm/user', 'UserController', [
        'except' => 'show',
        'names' => [
            'index' => 'admin.user.index',
            'create' => 'admin.user.create',
            'store' => 'admin.user.store',
            'edit' => 'admin.user.edit',
            'update' => 'admin.user.update',
            'destroy' => 'admin.user.destroy',
        ],
    ]);
    Route::get('/adm/search', 'SearchController@index')->name('admin.search.index');
    Route::resource('/adm/profile', 'ProfileController', [
        'only' => ['index', 'update'],
        'names' => [
            'index' => 'admin.profile.index',
            'update' => 'admin.profile.update',
        ],
    ]);
    Route::get('/adm/upload', 'UploadController@index')->name('admin.upload');
    Route::get('/adm/upload/ls', 'UploadController@ls')->name('admin.upload.list');

    Route::get('/adm/tools', 'ToolsController@index')->name('admin.tools');
    Route::post('/adm/tools/reset_index', 'ToolsController@resetIndex')->name('admin.tools.reset_index');
    Route::post('/adm/tools/cache_clear', 'ToolsController@clearCache')->name('admin.tools.cache_clear');
    Route::post('/adm/tools/download_archive', 'ToolsController@handleDownload')->name('admin.tools.download_archive');
    Route::post('/adm/tools/enable_maintenance_mode', 'ToolsController@enableMaintenanceMode')->name('admin.tools.enable_maintenance_mode');
    Route::post('/adm/tools/disable_maintenance_mode', 'ToolsController@disableMaintenanceMode')->name('admin.tools.disable_maintenance_mode');

});

$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');


$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

