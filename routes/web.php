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

Route::get('/', 'HomeController@welcome');

Auth::routes();

Route::get('/trace', 'HomeController@trace')->name('trace');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/score', 'HomeController@score')->name('score');
Route::get('/my_courses', 'HomeController@myCourses')->name('my_courses');
Route::get('/feedback', 'HomeController@feedback')->name('feedback');
Route::get('/score_list', 'HomeController@scoreList')->name('score_list');

Route::resource('courses', 'CourseController');
Route::resource('scores', 'ScoreController');
Route::resource('users', 'UserController');
Route::resource('feedbacks', 'FeedbackController');
Route::resource('signs', 'SignController');

