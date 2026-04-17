<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserPetController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PlantController;

Route::get('/', [UserPetController::class, 'index'])->name('pets.index');
Route::post('/pets', [UserPetController::class, 'store'])->name('pets.store');
Route::delete('/pets/{pet}', [UserPetController::class, 'destroy'])->name('pets.destroy');

// People & Food Tracking Routes
Route::get('/people', [PersonController::class, 'index'])->name('people.index');
Route::post('/people/{person}/food', [PersonController::class, 'storeFood'])->name('people.storeFood');
Route::delete('/people/{person}/food/{food}', [PersonController::class, 'destroyFood'])->name('people.destroyFood');

// Master Food Routes
Route::put('/foods/{food}', [PersonController::class, 'updateGlobalFood'])->name('foods.update');
Route::delete('/foods/{food}', [PersonController::class, 'destroyGlobalFood'])->name('foods.destroy');

// Plant & Vivid Form Routes
Route::get('/plants', [PlantController::class, 'index'])->name('plants.index');
Route::post('/plants', [PlantController::class, 'store'])->name('plants.store');
Route::put('/plants/{plant}/vivid-forms', [PlantController::class, 'updateVividForms'])->name('plants.updateVividForms');
Route::delete('/plants/{plant}', [PlantController::class, 'destroy'])->name('plants.destroy');
