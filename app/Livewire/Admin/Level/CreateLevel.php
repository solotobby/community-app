<?php

namespace App\Livewire\Admin\Level;

use App\Models\Level;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateLevel extends Component
{
    public $name, $registration_amount, $referral_bonus, $currency;

    protected $rules = [
        'name' => 'required|string|max:255',
        'registration_amount' => 'required|numeric|min:0',
        'referral_bonus' => 'required|numeric|min:0'
    ];

    public function submit()
    {
        $this->validate();

        Level::create([
            'name' => $this->name,
            'registration_amount' => $this->registration_amount,
            'referral_bonus' => $this->referral_bonus,
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
