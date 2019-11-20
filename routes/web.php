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

Route::get('/', 'AuthController@index')->middleware('guest');

Route::post('/login', 'AuthController@login')->name('login');
Route::get('/logout', 'AuthController@logout')->name('logout');

Route::middleware(['role:admin|user'])->group(function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/sumarize-expenses', 'DashboardController@getExpense');

    Route::get('/expense/manage', 'ExpenseController@index')->name('expense.manage');
    Route::get('/expense/manage/get', 'ExpenseController@getExpense');
    Route::post('/expense/manage/add', 'ExpenseController@addExpense');
    Route::post('/expense/manage/delete', 'ExpenseController@deleteExpense');
    Route::post('/expense/manage/update', 'ExpenseController@updateExpense');

    Route::get('/expense/categories/get', 'CategoriesController@getCategory');
});

Route::middleware(['role:admin'])->group(function() {
    Route::get('/user/role', 'RoleController@index')->name('user.role');
    Route::get('/user/role/get', 'RoleController@getRole');
    Route::post('/user/role/add', 'RoleController@saveRole');
    Route::post('/user/role/delete', 'RoleController@deleteRole');
    Route::post('/user/role/edit', 'RoleController@editRole');

    Route::get('/user/manage', 'UserManageController@index')->name('user.manage');
    Route::get('/user/manage/get', 'UserManageController@getUser');
    Route::post('/user/manage/add', 'UserManageController@saveUser');
    Route::post('/user/manage/delete', 'UserManageController@deleteUser');
    Route::post('/user/manage/edit', 'UserManageController@editUser');

    Route::get('/expense/categories', 'CategoriesController@index')->name('expense.categories');

    Route::post('/expense/categories/add', 'CategoriesController@addCategory');
    Route::post('/expense/categories/delete', 'CategoriesController@deleteCategory');
    Route::post('/expense/categories/update', 'CategoriesController@updateCategory');
});