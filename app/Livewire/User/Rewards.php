<?php

namespace App\Livewire\User;

use App\Http\Controllers\PaystackController;
use App\Models\BankInfo;
use App\Models\Reward;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Rewards extends Component
{
    use WithPagination;

    public $user;
    public $currentDraw;
    public $showClaimModal = false;
    public $showPinModal = false;
    public $showSetPinModal = false;
    public $selectedReward; // Changed from selectedDraw to selectedReward
    public $hasBankAccount = false;
    public $bankInfo;
    public $pin = '';
    public $new_transaction_pin = '';
    public $new_transaction_pin_confirmation = '';
    public $confirm_transaction_pin = '';
    public $bank_name = '';
    public $account_name = '';
    public $account_number = '';
    public $banks = [];
    public $showBankModal = false;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $rewards = Reward::with('referrer')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('livewire.user.rewards', compact('rewards'));
    }
}
