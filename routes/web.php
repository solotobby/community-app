<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaystackController;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Level\AllLevelItems;
use App\Livewire\Admin\Level\CreateLevel;
use App\Livewire\Admin\Level\LevelItemsManager;
use App\Livewire\Admin\Level\ListLevel;
use App\Livewire\Admin\Transaction\ListTransactions;
use App\Livewire\Admin\User\ListUsers;
use App\Livewire\Admin\User\RaffleDraw as UserRaffleDraw;
use App\Livewire\Admin\User\Reffaral;
use App\Livewire\Admin\User\UserDetails;
use App\Livewire\Admin\User\UserWallet;
use App\Livewire\Public\Gifting;
use App\Livewire\User\CreateGift;
use App\Livewire\User\GiftDetail;
use App\Livewire\User\GiftIndex;
use App\Livewire\User\RaffleClaim;
use App\Livewire\User\RaffleDraw;
use App\Livewire\User\Rewards;
use App\Livewire\User\UserDashboard;
use App\Livewire\User\Wallet;

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');


Route::get('/', [GeneralController::class, 'index']);
Route::get('about-us', [GeneralController::class, 'aboutUs']);
Route::get('blog', [GeneralController::class, 'blog']);
Route::get('food-fundraising', [GeneralController::class, 'foodFundraising']);

Route::get('/gift/{slug}', Gifting::class)->name('gift.public');


Route::middleware(['auth'])->group(function () {
    Route::get('home', [HomeController::class, 'home'])->name('home');
});

Route::middleware([
    'auth',
    'role:admin'
])->prefix(
    'admin'
)->group(function () {
    Route::get('dashboard', AdminDashboard::class)->name('admin');

    //Levels
    Route::get('level', ListLevel::class)->name('admin.list.level');
    Route::get('create-level', CreateLevel::class)->name('admin.create.level');
    Route::get('level-item/{level}', LevelItemsManager::class)->name('admin.item.level');
    Route::get('level/items', AllLevelItems::class)->name('admin.level.items.all');

    // Users
    Route::get('/users', ListUsers::class)->name('admin.users.index');
    Route::get('user-details/{id}', UserDetails::class)->name('admin.users.details');
    Route::get('user-raffle-draw/{id}', UserRaffleDraw::class)->name('admin.users.raffle');
    Route::get('user-referral/{id}', Reffaral::class)->name('admin.users.referral');
    Route::get('user-wallet/{id}', UserWallet::class)->name('admin.users.wallet');

    //Transactions
    Route::get('transactions', ListTransactions::class)->name('admin.transactions.all');
});

Route::middleware([
    'auth',
    'role:user'
])->prefix(
    'user'
)->name(
    'user.'
)->group(function () {

    Route::get('/gift-claim', RaffleClaim::class)->name('raffle.claim');
    Route::get('/dashboard', UserDashboard::class)->name('dashboard');
    Route::get('/referrals', Rewards::class)->name('referrals');
    Route::get('settings/profile', Profile::class)->name('settings');
    Route::get('gift/draw', RaffleDraw::class)->name('raffle.draw');
    Route::post('claim/gift', RaffleDraw::class)->name('claim.draw');
    Route::get('wallet', Wallet::class)->name('wallet');
    Route::get('crowdfund/gifts', GiftIndex::class)->name('gift.index');
    Route::get('crowdfund/gift-details/{giftId}', GiftDetail::class)->name('gift.detail');
    Route::get('crowdfund/request-gift', CreateGift::class)->name('gift.create-gift');
    Route::get('/level-upgrade/callback', [PaystackController::class, 'upgradeCallback'])->name('paystack.upgrade.callback');

});

require __DIR__ . '/auth.php';
