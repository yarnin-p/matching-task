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
    'prefix' => 'v1/users'
], function () {
    Route::post('/add', '\App\Modules\User\Controllers\UserController@create');
    Route::post('/edit/{userId}', '\App\Modules\User\Controllers\UserController@update');
    Route::delete('/delete/{userId}', '\App\Modules\User\Controllers\UserController@delete');
});

Route::group([
    'middlewares' => ['web'],
    'prefix' => 'v1/projects'
], function () {
    Route::post('/add', '\App\Modules\Project\Controllers\ProjectController@create');
    Route::post('/{id}/edit', '\App\Modules\Project\Controllers\ProjectController@update');
    Route::post('/{id}/delete/', '\App\Modules\Project\Controllers\ProjectController@delete');

    Route::post('/{projectId}/tasks/add', '\App\Modules\Task\Controllers\TaskController@create');
    Route::post('/{projectId}/tasks/{taskId}/edit', '\App\Modules\Task\Controllers\TaskController@update');
    Route::post('/{projectId}/tasks/{taskId}/delete', '\App\Modules\Task\Controllers\TaskController@delete');

});


Route::group([
    'middlewares' => ['web'],
    'prefix' => 'v1/tasks'
], function () {
    Route::get('/project/{projectId}', '\App\Modules\Task\Controllers\TaskController@getTaskBySelectedProject');
    Route::post('/send-task/{taskId}', '\App\Modules\Task\Controllers\TaskController@sendTask');
});


Route::group([
    'middlewares' => ['web'],
    'prefix' => 'v1/skills'
], function () {
    Route::post('/add', '\App\Modules\Skill\Controllers\SkillController@create');
    Route::post('/{id}/edit', '\App\Modules\Skill\Controllers\SkillController@update');
    Route::post('/{id}/delete', '\App\Modules\Skill\Controllers\SkillController@delete');
});

Route::group([
    'middlewares' => ['web'],
    'prefix' => 'v1/menus'
], function () {
    Route::post('/add', '\App\Modules\Menu\Controllers\MenuController@create');
    Route::post('/{id}/edit', '\App\Modules\Menu\Controllers\MenuController@update');
    Route::post('/{id}/delete', '\App\Modules\Menu\Controllers\MenuController@delete');
});


Route::group([
    'middlewares' => ['web'],
    'prefix' => 'v1/matching'
], function () {
    Route::post('/search', '\App\Modules\Matching\Controllers\MatchingController@search');
    Route::post('/save', '\App\Modules\Matching\Controllers\MatchingController@save');
});
