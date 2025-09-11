<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified', 'can:admin'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::redirect('settings', 'settings/profile');

    Route::middleware('can:admin.account.edit')->group(function () {
        Route::get('settings/profile', Profile::class)->name('settings.profile');
        Route::get('settings/password', Password::class)->name('settings.password');
        Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    });

    Route::middleware('can:admin.users.index')->group(function () {
        Route::get('/users', \App\Livewire\Users\Index::class)->name('users.index');
        Route::get('/users/create', \App\Livewire\Users\Create::class)->name('users.create')->middleware('can:admin.users.create');
        Route::get('/users/{user}', \App\Livewire\Users\Show::class)->name('users.show')->middleware('can:admin.users.show');
        Route::get('/users/{user}/edit', \App\Livewire\Users\Edit::class)->name('users.edit')->middleware('can:admin.users.edit');
    });

    Route::middleware('can:admin.audits.index')->group(function () {
        Route::get('/audits', \App\Livewire\Audits\Index::class)->name('audits.index');
        Route::get('/audits/{audit}', \App\Livewire\Audits\Show::class)->name('audits.show')->middleware('can:admin.audits.show');
    });

    // Route::middleware('can:admin.roles.index')->group(function () {
    //     Route::get('/roles', \App\Livewire\Roles\Index::class)->name('roles.index');
    //     Route::get('/roles/create', \App\Livewire\Roles\Create::class)->name('roles.create')->middleware('can:admin.roles.create');
    //     Route::get('/roles/{role}', \App\Livewire\Roles\Show::class)->name('roles.show')->middleware('can:admin.roles.show');
    //     Route::get('/roles/{role}/edit', \App\Livewire\Roles\Edit::class)->name('roles.edit')->middleware('can:admin.roles.edit');
    // });

});

require __DIR__.'/auth.php';
