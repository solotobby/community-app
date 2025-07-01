<?php

namespace App\Livewire\Admin\Level;

use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;

class ListLevel extends Component
{
    use WithPagination;

    public $edit = [
        'id' => null,
        'name' => '',
        'registration_amount' => '',
        'entry_gift' => '',
        'referral_bonus' => '',
        'currency' => '',
    ];

    protected $paginationTheme = 'bootstrap';

    public function editLevel($id)
    {
        $level = Level::findOrFail($id);
        $this->edit = [
            'id' => $level->id,
            'name' => $level->name,
            'registration_amount' => $level->registration_amount,
            'entry_gift' => $level->registration_amount == 0 ? 0 : ($level->entry_gift / $level->registration_amount) * 100,
            'referral_bonus' => $level->registration_amount == 0 ? 0 : ($level->referral_bonus / $level->registration_amount) * 100,
            'currency' => $level->currency,
        ];
    }

    public function updateLevel()
    {
        $this->validate([
            'edit.name' => 'required|string|max:255',
            'edit.registration_amount' => 'required|numeric',
            'edit.entry_gift' => 'required|numeric|max:100',
            'edit.referral_bonus' => 'required|numeric|max:100',
            'edit.currency' => 'required|in:NGN,USD,EUR,GBP',
        ]);

        $referral = ($this->edit['referral_bonus'] / 100) * $this->edit['registration_amount'];
        $entry = ($this->edit['entry_gift'] / 100) * $this->edit['registration_amount'];

        Level::where('id', $this->edit['id'])->update([
            'name' => $this->edit['name'],
            'registration_amount' => $this->edit['registration_amount'],
            'referral_bonus' => $referral,
            'entry_gift' => $entry,
            'currency' => $this->edit['currency'],
        ]);

        session()->flash('success', 'Level updated successfully.');
        $this->reset('edit');
        $this->resetPage();

        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.admin.level.list-level', [
            'levels' => Level::orderBy('registration_amount')->paginate(10)
        ]);
    }
}
