<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;

Route::get('/',function(){ return redirect()->route('people.index'); });
Route::get('dashboard',function(){ return redirect()->route('people.index'); });

Route::get('people', [PersonController::class, 'index'])->name('people.index');
Route::get('people/{id_people}',  [PersonController::class, 'show'])->name('people.show');


Route::middleware(['auth'])->group(function () {

    Route::get('/people/create', [PersonController::class, 'create'])->name('people.create');
    Route::post('/people/store', [PersonController::class, 'store'])->name('people.store');
    Route::get('/people/contribution-action/{id}/{action}', [PersonController::class, "make_action_contribution"])->name('people.make_action_invitation');

    Route::get('/people/invitations', [PersonController::class, 'invitations'])->name('people.invitations');
    Route::get('/people/edit_relation/{first}/{second}/{action}',[PersonController::class, "edit_relation"] )->name('people.edit_relation');
});

Route::get('/people/degre',[PersonController::class, 'degre'])->name('people.degre');

Route::get('/people/register-with-invitation/{code}',[PersonController::class, 'register_invitation'])->name('people.register_invitation');

require __DIR__.'/auth.php';

// Route::get('/people', [PersonController::class, 'index'])->name('people.index');
// Route::get('/people/create', [PersonController::class, 'create'])->name('people.create');
// Route::post('/people', [PersonController::class, 'store'])->name('people.store');
// Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');

