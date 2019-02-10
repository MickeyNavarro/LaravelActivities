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
    return view('welcome');
});

Route::get('hello/', function()
{
    //return "Hello World"; 
});

Route::get('helloworld/', function()
{
    return view('helloworld');
});

Route::get('/test', 'TestController@test2');

//END OF ACTIVITY 1

//route to get the form 
Route::get('/askme', function()
{
    return view('whoami'); 
});
Route::post('/whoami', 'WhatsMyNameController@index'); 

//login routes without using blade
Route::get('/login', function() { 
    return view('login'); 
}); 

Route::post('/dologin', 'LoginController@index');

//login routes when using blade
Route::get('/login2', function() {
    return view('login2');
});
    
Route::post('/dologin2', 'Login2Controller@index');

//login routes when using blade
Route::get('/login3', function() {
    return view('login3');
});
    
    Route::post('/dologin3', 'Login3Controller@index');