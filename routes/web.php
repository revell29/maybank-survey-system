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
    return redirect('/dashboard');
});
// Auth::routes();
Route::post('login', 'Auth\LoginController@attemptLogin')->name('login');
Route::get('login', 'Auth\LoginController@showFormLogin')->name('login');
Route::get('logout', 'Auth\LoginController@logout');
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard');
    Route::prefix('master')->group(function () {

        /**
         *  User Route
         **/
        Route::get('user/lists', 'User\UserController@data')->name('User::list');
        Route::get('user/delete/{id}', 'User\UserController@destroy')->name('user.delete'); // New Route
        Route::resource('user', 'User\UserController');

        /*
            Branch User
        */
        Route::post('branch/lists', 'User\UserBranchController@data')->name('UserBranch::list');
        Route::get('user_branch/delete/{id}', 'User\UserBranchController@destroy')->name('user_branch.delete');
        Route::resource('user_branch', 'User\UserBranchController');

        /**
         * Branch Master
         */
        Route::get('branch/master/lists', 'Branch\BranchController@data')->name('Branch::list');
        Route::get('branch/delete/{id}', 'Branch\BranchController@destroy')->name('branch.delete'); // New Route
        Route::resource('branch', 'Branch\BranchController');

        /**
         *  User Role
         */
        Route::get('role/data', 'Role\RoleController@data')->name('Role::data');
        Route::get('role/delete/{id}', 'Role\RoleController@destroy')->name('role.delete'); // New Route
        Route::resource('role', 'Role\RoleController');

        /*
            Branch User
        */
        Route::post('customer_service/lists', 'User\CustomerService@data')->name('CustomerService::list');
        Route::get('customer_service/delete/{id}', 'User\CustomerService@destroy')->name('CustomerService.delete');
        Route::resource('customer_service', 'User\CustomerService');
    });

    Route::post('report/data', 'Report\ReportController@data')->name('Report::list');
    Route::post('report/detail/list/', 'Report\ReportController@detailList')->name('ReportDetail::list');
    Route::get('report/detail/{id}', 'Report\ReportController@detail')->name('Report::detail');
    Route::get('report/data/export', 'Report\ReportController@export')->name('Report::export');
    Route::get('report/data/export/detail', 'Report\ReportController@exportDetail')->name('Report::exportDetail');
    Route::get('report/export/pdf_detail', 'Report\ReportController@exportSelect')->name('Report::export');
    Route::get('report/export/index', 'Report\ReportController@exportSelectIndex')->name('Report::exportIndex');
    Route::resource('report', 'Report\ReportController');

    /* Report User Branch */
    Route::post('report_user/data', 'Report\UserBranchReport@data')->name('ReportUser::list');
    Route::post('report_user/data/detail', 'Report\UserBranchReport@detailList')->name('ReportUser::detailList');
    Route::get('report_user/detail/{id}', 'Report\UserBranchReport@detail')->name('ReportUser::detail');
    Route::get('report_user/data/export/detail', 'Report\UserBranchReport@exportSelect')->name('ReportUser::exportSelect');
    Route::get('report_user/data/export', 'Report\UserBranchReport@exportSelectIndex')->name('ReportUser::exportIndex');
    Route::resource('report_user', 'Report\UserBranchReport');

    /* Activity Log */
    Route::get('log/data', 'Log\Activity@data')->name('log.data');
    Route::get('log/activity', 'Log\Activity@index')->name('log.index');
});

Route::post('client', 'Front\Auth\LoginController2@attemptLogin')->name('login.survei');
Route::get('client/logout', 'Front\Auth\LoginController2@logout');
Route::get('client/login', 'Front\Auth\LoginController@index')->name('survei');
Route::get('client', function () {
    return redirect('/client/home');
});

Route::group(['middleware' => 'auth:user_branch'], function () {
    Route::prefix('client')->group(function () {
        Route::get('/home', 'Front\Home\HomeController@index')->name('home.index')->middleware('survei');
        Route::post('post/survei', 'Front\Home\HomeController@store')->name('home.store');
    });
});

Route::get('testing', function () {
    return \Carbon\Carbon::today();
});
