<?php

use App\Http\Controllers\HomeController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Level\AllLevelItems;
use App\Livewire\Admin\Level\CreateLevel;
use App\Livewire\Admin\Level\LevelItemsManager;
use App\Livewire\Admin\Level\ListLevel;
use App\Livewire\User\UserDashboard;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('home', [HomeController::class, 'home'])->name('home');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', AdminDashboard::class)->name('admin');

    //Levels
    Route::get('level', ListLevel::class)->name('admin.list.level');
    Route::get('create-level', CreateLevel::class)->name('admin.create.level');
    Route::get('level-item/{level}', LevelItemsManager::class)->name('admin.item.level');
    Route::get('level/items', AllLevelItems::class)->name('admin.level.items.all');

    // Users
    //   Route::get('/users', ListUsers::class)->name('admin.users.index');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', UserDashboard::class)->name('dashboard');
});

require __DIR__ . '/auth.php';
