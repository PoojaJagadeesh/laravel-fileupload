<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('upload_file', function () {
    return view('upload');
});
Route::get('listing', function () {
    return view('list');
});
Route::get('list', 'FileuploadController@show');
Route::delete('/{user}/delete', 'FileuploadController@destroy');
Route::post('store_file', 'FileuploadController@store');
