<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => []], function () {
        Route::group(['prefix' => 'blogs'], function () {

            Route::get('/ahmed', function () {
                return " view('welcome')";
            });
            // Route::post('index', 'BlogsController@index');
            // Route::resource('blogs', BlogsController::class);

            Route::group(['middleware' => ['auth:api']], function () {
                // Route::resource('blogs', BlogsController::class);
            });

            Route::group(['prefix' => 'front'], function () {
                Route::get('index', 'a8worx\Blogs\Http\Controllers\V1\BlogsController@indexFront');
                // Route::resource('blogs', BlogsController::class)->only(['show']);
            });
        });
    });
    // Route::group(['prefix' => 'blog_categories'], function () {
    //     Route::get('all', 'BlogCategoriesController@index');
    //     Route::post('store', 'BlogCategoriesController@store');
    //     Route::patch('update', 'BlogCategoriesController@update');
    //     Route::delete('delete', 'BlogCategoriesController@delete');
    // });
    // Route::group(['middleware' => ['localization']], function () {
    //     Route::group(['prefix' => 'comments'], function () {
    //         Route::get('homeBlogs', 'BlogsController@index');
    //         Route::get('front/all', 'BlogsController@indexFront');
    //         Route::get('show', 'BlogsController@show');
    //     });
    // });
});
Route::group(['prefix' => 'v1', 'middleware' => ['cors', 'localization']], function () {
    Route::group(['prefix' => 'comments'], function () {
        //with  middleware auth
        // Route::Post('/index', 'CommentsController@index');
        // Route::group(['middleware' => ['auth:api']], function () {
        //     Route::resource('comments', CommentsController::class);
        //     Route::get('user/comments', 'CommentsController@usercomes')->middleware('verified');
        // });
    });
});
