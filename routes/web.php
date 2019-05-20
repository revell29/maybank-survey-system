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

Route::get('/', function() { return redirect('/dashboard'); });
// Auth::routes();
Route::post('login','Auth\LoginController@attemptLogin')->name('login');
Route::get('login','Auth\LoginController@showFormLogin')->name('login');
Route::get('logout', 'Auth\LoginController@logout');
Route::group(['middleware' => 'auth:web'],function(){
    
    Route::get('/dashboard','Dashboard\DashboardController@index')->name('dashboard');
    Route::prefix('master')->group(function(){
        
        /**
         *  User Route
         **/
        Route::get('user/lists','User\UserController@data')->name('User::list');
        Route::resource('user','User\UserController');
        
        /*
            Branch User
        */
        Route::get('branch/lists','User\UserBranchController@data')->name('UserBranch::list');
        Route::get('branch/delete/{id}','User\UserBranchController@delete')->name('user_branch.delete');
        Route::resource('user_branch','User\UserBranchController');

        /**
         * Branch Master
         */
        Route::get('branch/master/lists','Branch\BranchController@data')->name('Branch::list');
        Route::resource('branch','Branch\BranchController');

        /**
         *  User Role
         */
        Route::get('role/data','Role\RoleController@data')->name('Role::data');
        Route::resource('role','Role\RoleController');

    });

    Route::post('report/data','Report\ReportController@data')->name('Report::list');
    Route::post('report/detail/list/','Report\ReportController@detailList')->name('ReportDetail::list');
    Route::get('report/detail/{id}','Report\ReportController@detail')->name('Report::detail');
    Route::get('report/data/export','Report\ReportController@export')->name('Report::export');
    Route::get('report/data/export/detail','Report\ReportController@exportDetail')->name('Report::exportDetail');
    Route::get('report/export/pdf_detail','Report\ReportController@exportSelect')->name('Report::export');
    Route::get('report/export/index','Report\ReportController@exportSelectIndex')->name('Report::exportIndex');
    Route::resource('report','Report\ReportController');

    /* Activity Log */
    Route::get('log/data','Log\Activity@data')->name('log.data');
    Route::get('log/activity','Log\Activity@index')->name('log.index');
});

Route::post('client','Front\Auth\LoginController2@attemptLogin')->name('login.survei');
Route::get('client/logout','Front\Auth\LoginController2@logout');
Route::get('client/login','Front\Auth\LoginController@index')->name('survei');
Route::get('client', function() { return redirect('/client/home'); });
Route::group(['middleware' => 'auth:user_branch'],function(){
    Route::prefix('client')->group(function(){
        Route::get('/home','Front\Home\HomeController@index')->name('home.index')->middleware('survei');
        Route::post('post/survei','Front\Home\HomeController@store')->name('home.store');
    });
});
Route::get('testing',function(){

    $get_client_ip = $_SERVER['REMOTE_ADDR'];
    $get_token = '3277320038'; // ini token didapet secara acak.
    $combine_before = join('',array($get_client_ip,$get_token));
    $combine_after = md5(join('',array($get_client_ip,$get_token)));

    echo "Flow untuk encrypt IP client, ketika client pertama kali login, system akan mendeteksi ip client tersebut<br>
          kemudian ip yg didapat oleh sistem akan digabungkan dengan token atau kode acak secara otomatis dan di encrypt kedua nya.<br><br>";
    echo "sebelum alamat IP client di encrypt format nya seperti ini <br><strong>".$combine_before."</strong>";
    echo "<br><br>Sesudah alamat IP client di encrypt <br><strong>".$combine_after."<strong>";
});