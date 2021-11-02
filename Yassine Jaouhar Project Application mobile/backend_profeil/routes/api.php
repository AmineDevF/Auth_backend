<?php

use App\Http\Controllers\AuthentificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::post('inscription', [AuthentificationController::class, 'register']);
Route::post('connexion', [AuthentificationController::class, 'login']);
Route::get('home', [AuthentificationController::class, 'loadImage']);

Route::middleware('auth:api')->group(function () {
Route::post('update_profil', [AuthentificationController::class, 'update']);
Route::post('logout',  [AuthentificationController::class, 'logout']);
}); 