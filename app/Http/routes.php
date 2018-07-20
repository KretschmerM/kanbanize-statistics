<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/'          ,'AllController@index');
Route::get('/generate/{boardId}' ,'AllController@loadDataOnButtonClick');
Route::get('/settings/{settingId}', 'AllController@openSettingsOnButtonClick');
Route::post('/settings/{settingId}', 'AllController@saveSettingsOnButtonClick');


//Route::resource('/','AllController@index');



/*
Route::get('registered', function () {
    return view('auth.registered');
});


Route::group(['namespace' => '\App\Http\Controllers', 'middleware' => 'web'],
    function()
    {
        // Authentication Routes...
        Route::get('login', 'Auth\AuthController@showLoginForm');
        Route::post('login', 'Auth\AuthController@login');
        Route::get('logout', 'Auth\AuthController@logout');
        // Registration Routes...
        Route::get('register', 'Auth\AuthController@showRegistrationForm');
        Route::post('register', 'Auth\AuthController@register');
        // Password Reset Routes...
        Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
        Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'Auth\PasswordController@reset');
        Route::get('/overview', 'HomeController@index');
        Route::get('/', function () {
            return view('welcome')->with('body',10);
        });
        Route::get('/doc/','DevDocController@landingPage');
        Route::get('/doc/howto','DevDocController@howto');
        Route::get('/doc/{dirName}/{siteName}', 'DevDocController@showPage');
    }
);
*/
