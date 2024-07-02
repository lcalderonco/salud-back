<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\common\CommonController;
use App\Http\Controllers\Salud\ConsultaController;
use App\Http\Controllers\Salud\OdontogramaController;
use App\Http\Controllers\Salud\RecetaController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('tipoid', [CommonController::class, 'getTipoid']);
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::prefix('salud')->group(function () {
        Route::get('teeth/{tipoodontogramaid}', [OdontogramaController::class, 'getTeeth']);
        Route::get('numero-pieza/{tipoodontogramaid}', [OdontogramaController::class, 'getPiezas']);
        Route::get('face-type', [OdontogramaController::class, 'getFaceType']);
        Route::get('type-treatment', [OdontogramaController::class, 'getTypeTreatment']);

        Route::get('consultation', [ConsultaController::class, 'getConsultations']);
        Route::get('consultation/{consultaid}/odontogram', [ConsultaController::class, 'getOdontogramConsultation']);
        Route::post('consultation/{consultaid}/odontogram', [ConsultaController::class, 'addOdontogramConsultation']);
        Route::patch('consultation/{consultaid}/odontogram/{piezaid}', [ConsultaController::class, 'patchOdontogramConsultation']);
        Route::delete('consultation/{consultaid}/odontogram/{piezaid}', [ConsultaController::class, 'deleteOdontogramConsultation']);

        Route::get('recipe', [RecetaController::class, 'getRecipes']);
        Route::post('recipe', [RecetaController::class, 'addRecipe']);
        Route::delete('recipe/{recetaid}', [RecetaController::class, 'deleteRecipe']);
    });
});
