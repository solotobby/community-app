<?php

use App\Http\Controllers\HomeController;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Level\AllLevelItems;
use App\Livewire\Admin\Level\CreateLevel;
use App\Livewire\Admin\Level\LevelItemsManager;
use App\Livewire\Admin\Level\ListLevel;
use App\Livewire\User\RaffleClaim;
use App\Livewire\User\RaffleDraw;
use App\Livewire\User\Rewards;
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

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    Route::get('/raffle-claim/{reward_id}', RaffleClaim::class)->name('raffle.claim');

    Route::get('/dashboard', UserDashboard::class)->name('dashboard');
    Route::get('/rewards', Rewards::class)->name('rewards');
    Route::get('settings/profile', Profile::class)->name('settings');
    Route::get('raffle/draw', RaffleDraw::class)->name('raffle.draw');
    Route::post('claim/draw', RaffleDraw::class)->name('claim.draw');
});

require __DIR__ . '/auth.php';
