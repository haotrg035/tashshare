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


Route::group(['prefix' => '/'], function () {

    Route::get('/', function () {
        return redirect('dashboard');
    });
    Route::resource('dashboard','DashboardController',[
        'names' => [
            'index' => 'dashboard'
        ]
    ]);
    Route::get('/search', 'DashboardController@searchProject')->name('dashboard.search');
});


Route::resource('project','ProjectController');
Route::any('project/search','ProjectController@searchUser')->name('project.search');
Route::any('project/adduser','ProjectController@addUser')->name('project.adduser');
Route::any('project/getuser','ProjectController@getProjectsUsers')->name('project.getuser')->middleware('register.ispost');
Route::any('project/addtask','ProjectController@addTask')->name('project.addtask')->middleware('register.ispost');

Route::any('userprojects', 'ProjectController@showUserProjects')->middleware('register.ispost');


Route::name('auth.')->group(function(){
    Route::prefix('login')->group(function(){
        Route::get('/', function () {
            if (Auth::check()) {
                return redirect(route('dashboard'));
            }
            return view('Auth.login');
        });
        Route::post('/', 'Auth\LoginController@login')->name('login');
    });
    Route::get('logout', function () {
        if (Auth::check()) {Auth::logout();}
        return redirect(route('auth.login'));
    })->name('logout');
    Route::prefix('register')->group(function(){
        Route::any('/', 'Auth\RegisterController@createUser')->name('register');
        Route::any('/validate', 'Auth\RegisterController@validateAjax')->name('register.validate');
        Route::any('/validate/username', 'Auth\RegisterController@validateUserName');
        Route::any('/validate/password', 'Auth\RegisterController@validatePassword');
        Route::any('/validate/email', 'Auth\RegisterController@validateEmail');
        Route::any('/validate/passwordconfirm', 'Auth\RegisterController@validatePasswordConfirm');
    });
});




Route::get('check', function () {
    if (Auth::check()) {
        return Auth::user()->user_name;
    } else{
        return "Bạn chưa đăng nhập";
    }
});
Route::get('hash/{id}', function ($id) {
    return Hash::make($id);
});

