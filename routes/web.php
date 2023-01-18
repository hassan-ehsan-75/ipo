<?php

use App\BankBranch;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\BankBranchController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\CheckRole;
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

Route::group(['middleware'=>['guest']],function(){
    Route::get('/login', [UsersController::class,'loginPage'])->name('login');
    Route::post('/login',[UsersController::class,'login']);
});
Route::group(['middleware'=>['auth']],function(){
    Route::get('/logout','UsersController@logout');
    Route::get('/register',[UsersController::class,'registerPage'])->middleware('createUser');
    Route::post('/register',[UsersController::class,'register'])->middleware('createUser');
    Route::get('/home','HomeController@index')->name('home');
    Route::get('/','HomeController@index')->name('home');
    Route::get('/stockss/{bank?}/{branch?}/{status?}/{duplicate?}',[StockController::class,'index'])->middleware('viewStock');
    Route::get('/stocks/create/{type}',[StockController::class,'create'])->middleware('createStock');
    Route::post('/stocks/update/{id}',[StockController::class,'update'])->middleware('updateStock');
    Route::get('/stocks/edit/{id}',[StockController::class,'edit'])->middleware('updateStock');
    Route::post('/stocks/store/{type}',[StockController::class,'store'])->middleware('createStock');
    Route::get('/stocks/show/{id}',[StockController::class,'show'])->middleware('viewStock');
    Route::get('/stocks/active/{id}',[StockController::class,'showActive'])->middleware('createStock');
    Route::get('//stocks/deactive/{id}',[StockController::class,'deActive'])->middleware('createUser');
    Route::post('/stocks/activate/{id?}',[StockController::class,'activate'])->name('stock.activate')->middleware('viewStock');
    Route::delete('/stocks/destroy/{id}',[StockController::class,'destroy'])->middleware('deleteStock');
    Route::post('/roles/update/{id}',[RolesController::class,'update'])->middleware('editRoles');
    Route::get('/roles/create',[RolesController::class,'create'])->middleware('createRole');
    Route::post('/roles/store',[RolesController::class,'store'])->middleware('createRole');
    Route::delete('/roles/destroy/{id}',[RolesController::class,'destroy'])->middleware('deleteRole');
    Route::get('/roles',[RolesController::class,'index'])->middleware('viewRole');
    Route::get('/backups',[\App\Http\Controllers\BackupsController::class,'index'])->middleware('viewRole');
    Route::get('/backups/backup',[\App\Http\Controllers\BackupsController::class,'backup'])->middleware('viewRole');;
    Route::view('/settings','setting')->middleware('viewRole');;
    Route::post('/settings/update',[\App\Http\Controllers\CompanyController::class,'saveSetting'])->middleware('createRole');;
    Route::get('/personalizations/{bank?}/{branch?}',[\App\Http\Controllers\PersonalizationController::class,'index'])->name('personalization')->middleware('createRole');;
    Route::post('/personalizations/',[\App\Http\Controllers\PersonalizationController::class,'import'])->name('personalization.store')->middleware('createRole');;
    Route::get('/personalizations-export/{id?}',[\App\Http\Controllers\PersonalizationController::class,'export'])->name('personalization.export')->middleware('createRole');;
    Route::get('/return/{bank?}/{branch?}',[\App\Http\Controllers\PersonalizationController::class,'returning'])->name('return.index')->middleware('createRole');;
    Route::get('/return-print/{id}',[\App\Http\Controllers\PersonalizationController::class,'printReturn'])->name('return.print')->middleware('createRole');;
    Route::get('/exportPdf/{id}',[\App\Http\Controllers\PersonalizationController::class,'pdfExport']);
    Route::get('/exportPdf2/{id}',[\App\Http\Controllers\PersonalizationController::class,'pdfExport2']);
//    Route::post('/backups/import',[\App\Http\Controllers\BackupsController::class,'import']);
    Route::get('/companies',[CompanyController::class,'index'])->middleware('viewCompany')->name('companies.index');
    Route::get('/companies/create',[CompanyController::class,'create'])->middleware('createCompany');
    Route::get('/companies/show/{id}',[CompanyController::class,'show'])->middleware('viewCompany');
    Route::get('/companies/edit/{id}',[CompanyController::class,'edit'])->middleware('editCompany');
    Route::put('/companies/update/{id}',[CompanyController::class,'update'])->middleware('editCompany');
    Route::post('/companies/store',[CompanyController::class,'store'])->middleware('createCompany');
    Route::delete('/companies/destroy/{id}',[CompanyController::class,'destroy'])->middleware('deleteCompany');
    Route::get('/banks',[BankController::class,'index'])->middleware('viewBank');
    Route::get('/banks/show/{id}',[BankController::class,'show'])->middleware('viewBank');
    Route::get('/banks/create',[BankController::class,'create'])->middleware('createBank');
    Route::post('/banks/store',[BankController::class,'store'])->middleware('createBank');
    Route::get('/banks/edit/{id}',[BankController::class,'edit'])->middleware('updateBank');
    Route::post('/banks/update/{id}',[BankController::class,'update'])->middleware('updateBank');
    Route::delete('/banks/destroy/{id}',[BankController::class,'destroy'])->middleware('deleteBank');
    Route::delete('/banks/destroyBulk',[BankController::class,'destroyBulk'])->middleware('deleteBank');
    Route::get('/roles/edit/{id}',[RolesController::class,'edit'])->middleware('editRoles');
    Route::get('/branches',[BankBranchController::class,'index'])->middleware('viewBankBranch');
    Route::get('/branches/show/{id}',[BankBranchController::class,'show'])->middleware('viewBankBranch');
    Route::get('/branches/edit/{id}',[BankBranchController::class,'edit'])->middleware('updateBankBranch');
    Route::post('/branches/update/{id}',[BankBranchController::class,'update'])->middleware('updateBankBranch');
    Route::get('/branches/create',[BankBranchController::class,'create'])->middleware('createBankBranch');
    Route::post('/branches/store',[BankBranchController::class,'store'])->middleware('createBankBranch');
    Route::delete('/branches/destroy/{id}',[BankBranchController::class,'destroy'])->middleware('deleteBankBranch');
    Route::get('/users',[UsersController::class,'index'])->middleware('viewUser');
    Route::get('/users/edit/{id}',[UsersController::class,'edit'])->middleware('updateUser');
    Route::post('/users/update/{id}',[UsersController::class,'update'])->middleware('updateUser');
    Route::delete('/users/destroy/{id}',[UsersController::class,'destroy'])->middleware('deleteUser');
    Route::get('/users/show/{id}',[UsersController::class,'show'])->middleware('viewUser');
    Route::get('/users/profile',[UsersController::class,'profile']);
    Route::post('/user/chang_pass',[UsersController::class,'changePass']);
    Route::get('/reports',[ReportController::class,'index'])->middleware('viewReport');
    Route::get('/forms',[FormsController::class,'index'])->middleware('viewForm');
    Route::get('/forms/show/{id}',[FormsController::class,'show'])->middleware('viewForm');
    Route::get('/forms/create',[FormsController::class,'create'])->middleware('createForm');
    Route::post('/forms/store',[FormsController::class,'store'])->middleware('createForm');
    Route::get('/forms/edit/{id}',[FormsController::class,'edit'])->middleware('updateForm');
    Route::post('/forms/update/{id}',[FormsController::class,'update'])->middleware('updateForm');
    Route::delete('/forms/destroy/{id}',[FormsController::class,'destroy'])->middleware('deleteForm');
    Route::get('/reports/stocks',[ReportController::class,'stocks'])->middleware('viewReport');
    Route::get('/reports/singleStock/{id}',[ReportController::class,'singleStockPrint'])->middleware('viewStock');
    Route::get('/reports/stocks/print',[ReportController::class,'stocksPrint']);
    Route::get('/reports/banks/print',[ReportController::class,'bankPrint']);
    Route::get('/reports/branches/print',[ReportController::class,'branchPrint']);
});

Route::get('storage/{folder}/{date}/{filename}', function ($folder, $date, $filename)
{
    
    
    $path = storage_path('app/' .$folder."/".$date."/". $filename);


    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

