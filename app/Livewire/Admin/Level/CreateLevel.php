<?php

namespace App\Livewire\Admin\Level;

use App\Models\Level;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateLevel extends Component
{
    public $name, $registration_amount, $referral_bonus, $currency, $entry_gift;

    protected $rules = [
        'name' => 'required|string|max:255',
        'currency' => 'required|string|max:255',
        'registration_amount' => 'required|numeric|min:0',
        'referral_bonus' => 'required|numeric|min:0|max:100',
        'entry_gift' => 'required|numeric|min:0|max:100'
    ];

    public function submit()
    {
        $this->validate();

        $referral = ($this->referral_bonus/100) * $this->registration_amount;
        $entry = ($this->entry_gift/100) * $this->registration_amount;
        Level::create([
            'name' => $this->name,
            'registration_amount' => $this->registration_amount,
            'referral_bonus' => $referral,
            'entry_gift' => $entry,
            'currency' => $this->currency,
            'created_by' => Auth::id(),
        ]);

        session()->flash('success', 'Level created successfully.');

        // $this->reset();
         return redirect()->route('admin.list.level');
    }
    public function render()
    {
        return view('livewire.admin.level.create-level');
    }
}
