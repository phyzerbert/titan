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
    return redirect(route('home'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/home', 'HomeController@admin_home')->name('admin.home');
Route::get('/accountant/home', 'HomeController@accountant_home')->name('accountant.home');
Route::get('/manager/home', 'HomeController@manager_home')->name('project_manager.home');
Route::get('/member/home', 'HomeController@member_home')->name('course_member.home');

Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/save_profile', 'HomeController@save_profile')->name('save_profile');

Route::get('/user/index', 'UserController@index')->name('user.index');
Route::post('/user/create', 'UserController@create')->name('user.create');
Route::post('/user/edit', 'UserController@edit')->name('user.edit');
Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

Route::any('/project/index', 'ProjectController@index')->name('project.index');
Route::get('/project/detail/{id}', 'ProjectController@detail')->name('project.detail');
Route::post('/project/create', 'ProjectController@create')->name('project.create');
Route::post('/project/edit', 'ProjectController@edit')->name('project.edit');
Route::post('/project/report', 'ProjectController@report')->name('project.report');
Route::get('/project/delete/{id}', 'ProjectController@delete')->name('project.delete');

Route::get('/project/create/course', 'ProjectController@create_course')->name('create_course');
Route::post('/project/save/course', 'ProjectController@save_course')->name('save_course');
Route::get('/project/course/delete/{id}', 'ProjectController@delete_course')->name('course.delete');
Route::get('/project/course/detail/{id}', 'ProjectController@detail_course')->name('course.detail');
Route::post('/project/get_courses', 'ProjectController@get_courses')->name('get_courses');
Route::post('/project/add_member', 'ProjectController@add_member')->name('add.member');
Route::get('/project/export', 'ExcelController@export_project')->name('project.export');
Route::get('/project/{id}/course/export', 'ExcelController@export_course')->name('course.export');

Route::get('/project/request/index', 'ProjectController@requests')->name('request.index');
Route::post('/project/create/request', 'ProjectController@create_request')->name('request.create');
Route::get('/project/request/delete/{id}', 'ProjectController@delete_request')->name('request.delete');
Route::post('/project/request/response', 'ProjectController@response_to_request')->name('request.response');
Route::get('/project/request/export', 'ExcelController@export_request')->name('request.export');