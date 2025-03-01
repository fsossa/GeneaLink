<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/',function(){ return redirect()->route('index'); });

Route::get('/index', [App\Http\Controllers\PersonController::class, 'index'])->name('index');
Route::get('people/{id_people}',  [App\Http\Controllers\PersonController::class, 'show_people'])->name('show_people');

Route::middleware(['auth'])->group(function () {

    Route::get('create', [App\Http\Controllers\PersonController::class, 'create'])->name('create');
    Route::post('store', [App\Http\Controllers\PersonController::class, 'store'])->name('store');

    Route::get('invitations', [App\Http\Controllers\PersonController::class, 'invitations'])->name('invitations');
    Route::get('contribution-action/{id}/{action}', [App\Http\Controllers\PersonController::class, "make_action_contribution"])->name('make_action_invitation');

    Route::get('edit_relation/{first}/{second}/{action}',[App\Http\Controllers\PersonController::class, "edit_relation"] )->name('edit_relation');
});

Route::get('degre',[App\Http\Controllers\PersonController::class, 'degre'])->name('degre');

Route::get('register-with-invitation/{code}',[App\Http\Controllers\PersonController::class, 'register_invitation'])->name('register_invitation');

require __DIR__.'/auth.php';

// Route::get('/people', [PersonController::class, 'index'])->name('people.index');
// Route::get('/people/create', [PersonController::class, 'create'])->name('people.create');
// Route::post('/people', [PersonController::class, 'store'])->name('people.store');
// Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');

