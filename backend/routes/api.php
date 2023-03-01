<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/category",[CategoryController::class,'index']);
Route::post("/category/add",[CategoryController::class,'add']);
Route::post("/category/edit/{id}",[CategoryController::class,'store']);
Route::post("/category/delete/{id}",[CategoryController::class,'delete']);


Route::get("/game",[GameController::class,'index']);
Route::get("/game/search",[GameController::class,'search']);
Route::post("/game/add",[GameController::class,'add']);
Route::post("/game/edit/{id}",[GameController::class,'store']);
Route::post("/game/delete/{id}",[GameController::class,'delete']);
Route::post("/game/import",[GameController::class,'import']);
Route::get("/game/export",[GameController::class,'export']);