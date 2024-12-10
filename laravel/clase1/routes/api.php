<?php

use App\Http\controllers\empleadoControlador;
use App\Http\controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/empleado',[empleadocontrolador::class,'index']);
Route::get('/empleado/{idEmpleado}',[empleadocontrolador::class,'show']);
Route::post('/empleado',[empleadocontrolador::class,'store']);
Route::put('/empleado/{idEmpleado}',[empleadocontrolador::class,'update']);
Route::delete('/empleado/{idEmpleado}',[empleadocontrolador::class,'destroy']);
Route::post('/login',[AuthController::class,'login']);



