<?php

namespace App\Livewire\Admin\Level;

use Livewire\Component;
use App\Models\Level;
use App\Models\LevelItem;
use Illuminate\Support\Facades\Auth;

class LevelItemsManager extends Component
{
    public $level;
    public $items;

    public $itemname;
    public $price;

    public $showModal = false;

    public function mount($level)
    {
      $this->level = Level::findOrFail($level); // Convert ID to model
    $this->loadItems();
    }

    public function loadItems()
    {
        $this->items = $this->level->levelItems()->latest()->get();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['itemname', 'price']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    protected $rules = [
        'itemname' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ];

    public function submit()
    {
        $this->validate();

        $this->level->levelItems()->create([
            'item_name' => $this->itemname,
            'price' => $this->price,
            'created_by' => Auth::id(),
        ]);

        session()->flash('success', 'Item added successfully.');

        $this->loadItems();

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.level.level-items-manager');
    }
}

