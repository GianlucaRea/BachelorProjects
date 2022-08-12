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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users','UtenteController');
Route::apiResource('admins','AdminController');
Route::apiResource('contents','ContentController');
Route::apiResource('documents','DocumentController');
Route::apiResource('reviews','ReviewController');
Route::apiResource('statistics','StatisticController');
Route::apiResource('tags','TagController');
Route::apiResource('versions','VersionController');

Route::get('statistics/id','StatisticController@average_feedback_single_doc');
Route::get('users/docs/{id}','UtenteController@getDoc');
Route::get('users/reviews/{id}','UtenteController@getReviews');
Route::get('users/statistic/{id}','UtenteController@getStatistic');
Route::get('documents/content/{id}','DocumentController@getContent');
Route::get('documents/tags/{id}','DocumentController@getTags');
Route::get('documents/reviews/{id}','DocumentController@getReviews');
Route::get('documents/versions/{id}','DocumentController@getVersions');
Route::get('documents/user/{id}','DocumentController@getUser');
Route::get('contents/document/{id}','ContentController@getDocument');
Route::get('reviews/user/{id}','ReviewController@getUser');
Route::get('reviews/document/{id}','ReviewController@getDocument');
Route::get('statistics/user/{id}','StatisticController@getUser');
Route::get('tags/document/{id}','TagController@getDocument');
Route::get('versions/document/{id}','VersionController@getDocument');
Route::get('users/documents/university/{id}','UtenteController@SearchDocByUniversity');
Route::get('statistics/avg/{id}','StatisticController@getAvgFeedbackDoc');
Route::get('statistics/nupload/{id}','StatisticController@getNumberUploadedDoc');
Route::get('statistics/pointsdoc/{id}','StatisticController@getPointsFeedbackTotalDoc');








