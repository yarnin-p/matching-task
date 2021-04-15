<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group([
    'middlewares' => ['web'],
    'prefix' => 'v1/auth'
], function () {
    Route::post('/login/check-login', '\App\Modules\Auth\Controllers\AuthController@checkLogin');
});


Route::group([
    'middlewares' => ['web'],
    'prefix' => 'v1/projects'
], function () {
    Route::post('/add', '\App\Modules\Project\Controllers\ProjectController@create');
    Route::post('/edit/{id}', '\App\Modules\Project\Controllers\ProjectController@update');
    Route::post('/delete/{id}', '\App\Modules\Project\Controllers\ProjectController@delete');

    Route::post('/{projectId}/tasks/add', '\App\Modules\Task\Controllers\TaskController@create');
    Route::post('/{projectId}/tasks/{taskId}/edit', '\App\Modules\Task\Controllers\TaskController@update');
    Route::post('/{projectId}/tasks/{taskId}/delete', '\App\Modules\Task\Controllers\TaskController@delete');

});
