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
    'prefix' => 'home'
], function () {
    Route::get('/', '\App\Modules\Home\Controllers\HomeController@index');
});

Route::group([
    'middlewares' => ['web'],
    'prefix' => 'projects'
], function () {

    /* Project Routes */
    Route::get('/', '\App\Modules\Project\Controllers\ProjectController@index');
    Route::get('/{id}/tasks', '\App\Modules\Project\Controllers\ProjectController@detailView');
    Route::get('/add', '\App\Modules\Project\Controllers\ProjectController@createView');
    Route::get('/{id}/edit', '\App\Modules\Project\Controllers\ProjectController@editView');

    /* Task Routes */
    Route::get('/{projectId}/tasks/add', '\App\Modules\Task\Controllers\TaskController@taskCreateView');
    Route::get('/{projectId}/tasks/{taskId}/edit', '\App\Modules\Task\Controllers\TaskController@taskEditView');

});

Route::group([
    'middlewares' => ['web'],
    'prefix' => 'matching'
], function () {
    Route::get('/', '\App\Modules\Matching\Controllers\MatchingController@index');
    Route::get('/history', '\App\Modules\Matching\Controllers\MatchingController@history');
});

Route::group([
    'middlewares' => ['web'],
    'prefix' => 'assignment'
], function () {
    Route::get('/', '\App\Modules\Assignment\Controllers\AssignmentController@index');
    Route::get('/history/complete', '\App\Modules\Assignment\Controllers\AssignmentController@taskHistorySuccessView');
});

Route::group([
    'middlewares' => ['web'],
    'prefix' => 'dashboard'
], function () {
    Route::get('/', '\App\Modules\Dashboard\Controllers\DashboardController@index');
});

Route::group([
    'middlewares' => ['web'],
    'prefix' => 'skills'
], function () {
    Route::get('/', '\App\Modules\Skill\Controllers\SkillController@index');
    Route::get('/add', '\App\Modules\Skill\Controllers\SkillController@createView');
    Route::get('/{id}/edit', '\App\Modules\Skill\Controllers\SkillController@editView');
});

Route::group([
    'middlewares' => ['web'],
    'prefix' => 'menus'
], function () {
    Route::get('/', '\App\Modules\Menu\Controllers\MenuController@index');
    Route::get('/add', '\App\Modules\Menu\Controllers\MenuController@createView');
    Route::get('/{id}/edit', '\App\Modules\Menu\Controllers\MenuController@editView');

});


Route::group([
    'middlewares' => ['web'],
    'prefix' => 'work-experiences'
], function () {
    Route::get('/', '\App\Modules\WorkExperience\Controllers\WorkExperienceController@index');
    Route::get('/add', '\App\Modules\WorkExperience\Controllers\WorkExperienceController@createView');
    Route::get('/{id}/edit', '\App\Modules\WorkExperience\Controllers\WorkExperienceController@editView');
});


Route::group([
    'middlewares' => ['web'],
    'prefix' => 'qa'
], function () {
    Route::get('/', '\App\Modules\QA\Controllers\QAController@index');
    Route::get('/skill/edit', '\App\Modules\QA\Controllers\SkillController@getEdit');
    Route::post('/skill/edit', '\App\Modules\QA\Controllers\SkillController@postEdit');
    Route::get('/skill/delete', '\App\Modules\QA\Controllers\SkillController@delete');
    Route::get('/work-experience/edit/{id?}', '\App\Modules\QA\Controllers\WorkExperienceController@getEdit');
    Route::post('/work-experience/edit/{id?}', '\App\Modules\QA\Controllers\WorkExperienceController@postEdit');
    Route::get('/work-experience/delete', '\App\Modules\QA\Controllers\WorkExperienceController@delete');
});


Route::group([
    'middlewares' => ['web'],
    'prefix' => 'users'
], function () {
    Route::get('/', '\App\Modules\User\Controllers\UserController@index');
    Route::get('/edit/{userId}', '\App\Modules\User\Controllers\UserController@editView');
    Route::get('/delete/{userId}', '\App\Modules\User\Controllers\UserController@delete');
    Route::get('/add', '\App\Modules\User\Controllers\UserController@createView');
});
