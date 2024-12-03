<?php

use App\Http\Controllers\Api\ActivationController;
use App\Http\Controllers\Api\AllianceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;


//logueo de usuario
Route::post("login", [ApiController::class, "login"]);
// Protected Routes
Route::group([
    "middleware" => ["auth:sanctum"]
], function(){
    // creacion de usuarios
    Route::post("user", [ApiController::class, "store"]); 
    // actualizacion de usuarios
    Route::put("user", [ApiController::class, "update"]);
    // trae un usuario por id
    Route::get("user", [ApiController::class, "show"]); 
    // cierre de session
    Route::get("logout", [ApiController::class, "logout"]);

});
