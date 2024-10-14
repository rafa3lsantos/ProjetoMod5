<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExplorerController;

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

Route::post('/explorers', [ExplorerController::class, 'store'])->name('explorers.store');
Route::put('explorers/{id}', [ExplorerController::class, 'update'])->name('explorers.update');
Route::post('explorers/inventario', [ExplorerController::class, 'addItems'])->name('explorers.addItems');
Route::post('explorers/trocar', [ExplorerController::class, 'trocar'])->name('explorers.trocar');
Route::get('explorers/{id}', [ExplorerController::class, 'show'])->name('explorers.show');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
