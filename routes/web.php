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

Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

Route::view('scan', 'scan');

Route::get('/threads', 'ThreadsController@index')->name('threads');
Route::get('/threads/create', 'ThreadsController@create')->middleware('must-confirm-email');

Route::get('/threads/search', 'SearchController@show');

Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::patch('/threads/{channel}/{thread}', 'ThreadsController@update');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::post('/threads', 'ThreadsController@store')->middleware('must-confirm-email');
Route::get('/threads/{channel}', 'ThreadsController@index');

Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

Route::post('pinned-threads/{thread}', 'PinnedThreadsController@store')->name('pinned-threads.store')->middleware('admin');
Route::delete('pinned-threads/{thread}', 'PinnedThreadsController@destroy')->name('pinned-threads.destroy')->middleware('admin');

Route::get('/threads/{thread}', 'ThreadsController@show');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy')->middleware('auth');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');

Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('/register/confirm', 'Auth\ResgisterConfirmationController@index')->name('confirm.register');

Route::get('api/users', 'Api\UsersController@index');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => 'admin',
        'namespace' => 'Admin'
    ],
    function () {
        Route::get('/', 'DashboardController@index')->name('admin.dashboard.index');
        Route::post('/channels', 'ChannelsController@store')->name('admin.channels.store');
        Route::get('/channels', 'ChannelsController@index')->name('admin.channels.index');
        Route::get('/channels/create', 'ChannelsController@create')->name('admin.channels.create');
        Route::get('/channels/{channel}/edit', 'ChannelsController@edit')->name('admin.channels.edit');
        Route::patch('/channels/{channel}', 'ChannelsController@update')->name('admin.channels.update');
    }
);
