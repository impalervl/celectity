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

Route::get('/', 'HomeController@index');

Route::resource('/conection','ConectionController');

//Route::post('/conection/deleteall', 'ConectionController@destroyAll')->name('conection.deleteall');

Route::post('conection/calculation','ConectionController@calculation')->name('conection.calculation');

Route::post('conection/destroyone','ConectionController@destroyone')->name('conection.destroyone');

Route::resource('/project','ProjectController');

Route::post('project/children','ProjectController@children')->name('project.children');

Route::post('project/calculate','ProjectController@calculate')->name('project.calculate');

Route::post('project/start','ProjectController@start')->name('project.start');


