<?php

use App\Http\Controllers\Api\ActivationController;
use App\Http\Controllers\Api\AllianceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\FileController;

//logueo de usuario
Route::post("login", [ApiController::class, "login"]);
// Protected Routes
// creacion de usuarios
Route::post("register", [ApiController::class, "store"]); 
Route::group([
    "middleware" => ["auth:sanctum"]
], function(){
    
    // actualizacion de usuarios
    Route::put("user", [ApiController::class, "update"]);
    // trae un usuario por id
    Route::get("user", [ApiController::class, "show"]); 
    // cierre de session
    Route::get("logout", [ApiController::class, "logout"]);
    //agrega un archivo
    Route::post("file", [FileController::class, "store"]);
    //trae los archivos del usuario
    Route::get("file", [FileController::class, "getAllFile"]);
    Route::get("file/{fileName}", [FileController::class, "download"]);
    //elimina un archivo
    Route::delete("file/{fileName}", [FileController::class, "deleteFile"]); 

});
