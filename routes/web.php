<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;

Route::get('/', function () {
    return redirect()->route('login');
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

     Route::middleware('can:admin.roles.index')->group(function () {
        Route::get('/roles', \App\Livewire\Roles\Index::class)->name('roles.index');
        Route::get('/roles/create', \App\Livewire\Roles\Create::class)->name('roles.create')->middleware('can:admin.roles.create');
        Route::get('/roles/{role}', \App\Livewire\Roles\Show::class)->name('roles.show')->middleware('can:admin.roles.show');
        Route::get('/roles/{role}/edit', \App\Livewire\Roles\Edit::class)->name('roles.edit')->middleware('can:admin.roles.edit');
    });

    Route::middleware('can:admin.companies.index')->group(function () {
        Route::get('/companies', \App\Livewire\Companies\Index::class)->name('companies.index');
        Route::get('/companies/create', \App\Livewire\Companies\Create::class)->name('companies.create');
        Route::get('/companies/{company}', \App\Livewire\Companies\Show::class)->name('companies.show');
        Route::get('/companies/{company}/edit', \App\Livewire\Companies\Edit::class)->name('companies.edit');
    });

    Route::middleware('can:admin.product-categories.index')->group(function () {
        Route::get('/product-categories', \App\Livewire\ProductCategories\Index::class)->name('product-categories.index');
        Route::get('/product-categories/create', \App\Livewire\ProductCategories\Create::class)->name('product-categories.create');
        Route::get('/product-categories/{productCategory}', \App\Livewire\ProductCategories\Show::class)->name('product-categories.show');
        Route::get('/product-categories/{productCategory}/edit', \App\Livewire\ProductCategories\Edit::class)->name('product-categories.edit');
    });

    Route::middleware('can:admin.products.index')->group(function () {
        Route::get('/products', \App\Livewire\Products\Index::class)->name('products.index');
        Route::get('/products/create', \App\Livewire\Products\Create::class)->name('products.create');
        Route::get('/products/{product}', \App\Livewire\Products\Show::class)->name('products.show');
        Route::get('/products/{product}/edit', \App\Livewire\Products\Edit::class)->name('products.edit');
    });

    Route::middleware('can:admin.suppliers.index')->group(function () {
        Route::get('/suppliers', \App\Livewire\Suppliers\Index::class)->name('suppliers.index');
        Route::get('/suppliers/create', \App\Livewire\Suppliers\Create::class)->name('suppliers.create');
        Route::get('/suppliers/{supplier}', \App\Livewire\Suppliers\Show::class)->name('suppliers.show');
        Route::get('/suppliers/{supplier}/edit', \App\Livewire\Suppliers\Edit::class)->name('suppliers.edit');
    });

    Route::middleware('can:admin.transactions.index')->group(function () {
        Route::get('/transactions', \App\Livewire\Transactions\Index::class)->name('transactions.index');
        Route::get('/transactions/create', \App\Livewire\Transactions\Create::class)->name('transactions.create');
        Route::get('/transactions/{transaction}', \App\Livewire\Transactions\Show::class)->name('transactions.show');
        Route::get('/transactions/{transaction}/edit', \App\Livewire\Transactions\Edit::class)->name('transactions.edit');
    });

    Route::middleware('can:admin.storage1-transactions.index')->group(function () {
        Route::get('/storage1-transactions', \App\Livewire\Storage1Transactions\Index::class)->name('storage1-transactions.index');
        Route::get('/storage1-transactions/create', \App\Livewire\Storage1Transactions\Create::class)->name('storage1-transactions.create');
        Route::get('/storage1-transactions/{storage1Transaction}', \App\Livewire\Storage1Transactions\Show::class)->name('storage1-transactions.show');
        Route::get('/storage1-transactions/{storage1Transaction}/edit', \App\Livewire\Storage1Transactions\Edit::class)->name('storage1-transactions.edit');
    });

    Route::middleware('can:admin.storage2-transactions.index')->group(function () {
        Route::get('/storage2-transactions', \App\Livewire\Storage2Transactions\Index::class)->name('storage2-transactions.index');
        Route::get('/storage2-transactions/create', \App\Livewire\Storage2Transactions\Create::class)->name('storage2-transactions.create');
        Route::get('/storage2-transactions/{storage2Transaction}', \App\Livewire\Storage2Transactions\Show::class)->name('storage2-transactions.show');
        Route::get('/storage2-transactions/{storage2Transaction}/edit', \App\Livewire\Storage2Transactions\Edit::class)->name('storage2-transactions.edit');
    });


});

require __DIR__.'/auth.php';
