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

Route::group([
    'middlewares' => ['web'],
    'prefix' => ''
], function () {
    Route::get('/', '\App\Modules\Auth\Controllers\AuthController@login');
    Route::get('/logout', '\App\Modules\Auth\Controllers\AuthController@logout');

});

Route::group([
    'middlewares' => ['web'],
    'prefix' => 'projects'
], function () {

    /* Project Routes */
    Route::get('/', '\App\Modules\Project\Controllers\ProjectController@index');
    Route::get('/{id}/tasks', '\App\Modules\Project\Controllers\ProjectController@detailView');
    Route::get('/add', '\App\Modules\Project\Controllers\ProjectController@createView');
    Route::get('/edit/{id}', '\App\Modules\Project\Controllers\ProjectController@editView');

    /* Task Routes */
    Route::get('/{projectId}/tasks/add', '\App\Modules\Task\Controllers\TaskController@taskCreateView');
    Route::get('/{projectId}/tasks/{taskId}/edit', '\App\Modules\Task\Controllers\TaskController@taskEditView');

});

Route::group([
    'middlewares' => ['web'],
    'prefix' => 'matching'
], function () {

    /* Project Routes */
    Route::get('/', '\App\Modules\Matching\Controllers\MatchingController@index');
    Route::get('/{id}/tasks', '\App\Modules\Project\Controllers\ProjectController@detailView');
    Route::get('/add', '\App\Modules\Project\Controllers\ProjectController@createView');
    Route::get('/edit/{id}', '\App\Modules\Project\Controllers\ProjectController@editView');

    /* Task Routes */
    Route::get('/{projectId}/tasks/add', '\App\Modules\Task\Controllers\TaskController@taskCreateView');
    Route::get('/{projectId}/tasks/{taskId}/edit', '\App\Modules\Task\Controllers\TaskController@taskEditView');

});



Route::group([
    'middlewares' => ['web'],
    'prefix' => 'home'
], function () {
    Route::get('/', '\App\Modules\Home\Controllers\HomeController@index');
});


