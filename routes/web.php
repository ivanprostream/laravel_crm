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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    Route::resource('/', 'HomeController');

	Route::resource('/users', 'UsersController');

	Route::get('/my-profile', 'UsersController@getProfile');
	Route::get('/my-profile/edit', 'UsersController@getEditProfile');
    Route::patch('/my-profile/edit', 'UsersController@postEditProfile');

    Route::resource('/permissions', 'PermissionsController');

    Route::resource('/roles', 'RolesController');

    Route::resource('/divisions', 'DivisionsController');

    Route::get('/users/role/{id}', 'UsersController@getRole');
	Route::put('/users/role/{id}', 'UsersController@updateRole');

    Route::resource('/projects', 'ProjectsController');

	Route::resource('/documents', 'DocumentsController');

    Route::get('/users/role/{id}', 'UsersController@getRole');
	Route::put('/users/role/{id}', 'UsersController@updateRole');

	Route::resource('/tasks', 'TasksController');
    Route::get('/tasks/{status}/status', 'TasksController@getTasksByStatus');
    Route::get('/tasks/{id}/assign', 'TasksController@getAssignTask');
    Route::put('/tasks/{id}/assign', 'TasksController@postAssignTask');
    Route::get('/tasks/{id}/update-status', 'TasksController@getUpdateStatus');
    Route::put('/tasks/{id}/update-status', 'TasksController@postUpdateStatus');
    Route::post('/tasks/{id}/chat', 'TasksController@postTaskMessage');

    Route::match(['get', 'post'], '/tasks/{id}/{task}/document', 'TasksController@getTaskDocument');
    //Route::post('/tasks/{id}/{task}/document', 'TasksController@postTaskDocument');

    Route::get('/mailbox/{folder?}', 'MailboxController@index');
    Route::get('/mailbox-create', 'MailboxController@create');
    Route::post('/mailbox-create', 'MailboxController@store');
    Route::get('/mailbox-show/{id}', 'MailboxController@show');
    Route::put('/mailbox-toggle-important', 'MailboxController@toggleImportant');
    Route::delete('/mailbox-trash', 'MailboxController@trash');
    Route::delete('/mailbox-trash-one', 'MailboxController@trash_one');
    
    Route::get('/mailbox-reply/{id}', 'MailboxController@getReply');
    Route::post('/mailbox-reply/{id}', 'MailboxController@postReply');
    Route::get('/mailbox-forward/{id}', 'MailboxController@getForward');
    Route::post('/mailbox-forward/{id}', 'MailboxController@postForward');
    Route::get('/mailbox-send/{id}', 'MailboxController@send');

    Route::get('/calendar', 'CalendarController@index');
    Route::post('/calendar', 'CalendarController@postTasksByUser');

	Route::get('/forbidden', function () {
        return view('pages.forbidden.forbidden_area');
    });
    
});


Route::get('/', function () {
    return redirect()->to('/admin');
});

Auth::routes();


