<?php
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\APi\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('listeContact', [ContactController::class, 'listeContact']);
    Route::post('ajoutContact', [ContactController::class, 'ajoutContact']);
    Route::put('updateContact/{contact}', [ContactController::class, 'updateContact']);
    Route::delete('deleteContact/{contact}', [ContactController::class, 'deleteContact']);
    Route::post('addUser', [UserController::class, 'addUser']);
});
