<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserPetController;

Route::get('/', [UserPetController::class, 'index'])->name('pets.index');
Route::post('/pets', [UserPetController::class, 'store'])->name('pets.store');
Route::delete('/pets/{pet}', [UserPetController::class, 'destroy'])->name('pets.destroy');
