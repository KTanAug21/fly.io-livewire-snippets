<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;

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

Route::get('/documents',[\App\Http\Controllers\DocumentController::class,'index']);
Route::get('/documents/display/{id}',[\App\Http\Controllers\DocumentController::class,'display']);
Route::post('/documents/upload',[\App\Http\Controllers\DocumentCrudController::class,'upload'])->middleware(['with-secret']);
Route::post('/documents/uploadfra',[\App\Http\Controllers\DocumentCrudController::class,'uploadFra'])->middleware(['with-secret']);
Route::post('/files/upload-part',[\App\Http\Controllers\BufferedFileUploaderController::class,'uploadPart']);


Route::get('/documents/nuke',[\App\Http\Controllers\DocumentCrudController::class,'deleteAll'])->middleware(['with-secret']);

