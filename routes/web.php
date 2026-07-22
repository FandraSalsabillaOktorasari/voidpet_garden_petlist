<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserPetController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\SpeciesController;

Route::get('/', [UserPetController::class, 'index'])->name('pets.index');
Route::get('/pets/duplicates', [UserPetController::class, 'duplicates'])->name('pets.duplicates');
Route::get('/pets/create', [UserPetController::class, 'create'])->name('pets.create');
Route::post('/pets', [UserPetController::class, 'store'])->name('pets.store');
Route::get('/pets/{pet}/edit', [UserPetController::class, 'edit'])->name('pets.edit');
Route::put('/pets/{pet}', [UserPetController::class, 'update'])->name('pets.update');
Route::delete('/pets/{pet}', [UserPetController::class, 'destroy'])->name('pets.destroy');
Route::get('/checklist', [App\Http\Controllers\ChecklistController::class, 'index'])->name('pets.checklist');

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

// Species Sync Route
Route::post('/species/sync', [SpeciesController::class, 'sync'])->name('species.sync');
