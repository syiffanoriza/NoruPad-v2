<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// AUTH
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    // AUTH
    Route::get('/logout', [AuthController::class, 'logout']);

    // CRUD
    Route::get('/notes', [NotesController::class, 'index']);
    Route::post('/create', [NotesController::class, 'create']);
    Route::get('/read/{id}', [NotesController::class, 'read'])->middleware('note.owner');
    Route::patch('/update/{id}', [NotesController::class, 'update'])->middleware('note.owner');
    Route::delete('/delete/{id}', [NotesController::class, 'delete'])->middleware('note.owner');
});