<?php

namespace App\Livewire\Admin\Level;

use Livewire\Component;
use App\Models\Level;
use App\Models\LevelItem;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LevelItemsManager extends Component
{

    use WithFileUploads;
    public $level;
    public $items;
    public $itemname;
    public $price;
    public $image;
    public $status;
    public $itemToDeleteId;

    public $showModal = false;

    public function mount($level)
    {
        $this->level = Level::findOrFail($level);
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->items = $this->level->levelItems()->latest()->get();
    }

    public function openModal()
    {
        $this->resetValidation();

        if ($this->level->registration_amount == 0) {

            session()->flash('error', 'Item can not be added to a free level.');
            $this->reset(['itemname', 'price', 'image']);
            $this->loadItems();
            $this->closeModal();
            return;
        }
        $this->reset(['itemname', 'price']);
        $this->showModal = true;
    }


    public function confirmDelete($id)
    {
        $this->itemToDeleteId = $id;
        $this->dispatch('show-delete-modal');
    }
    public function closeModal()
    {
        $this->showModal = false;
    }

    protected $rules = [
        'itemname' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'image' => 'required|image|max:2048',
    ];

    public function submit()
    {
        $this->validate();

        if ($this->price > $this->level->entry_gift) {
            session()->flash('error', 'Item Price can not be greater than the level cap amount');
            $this->reset(['itemname', 'price', 'image']);
            $this->loadItems();
            $this->closeModal();
            return;
        }
        $filePath = 'levelItems/' . time() . '.' . $this->image->getClientOriginalExtension();
        Storage::disk('public')->put($filePath, file_get_contents($this->image->getRealPath()));

        $url = asset('storage/' . $filePath);

        $this->level->levelItems()->create([
            'item_name' => $this->itemname,
            'price' => $this->price,
            'created_by' => Auth::id(),
            'item_url' => $url,
        ]);

        session()->flash('success', 'Item added successfully.');

        $this->reset(['itemname', 'price', 'image']);
        $this->loadItems();
        $this->closeModal();
    }
    public function deleteItem()
    {
        $item = LevelItem::find($this->itemToDeleteId);
        if ($item) {
            $item->delete();
        }

        $this->itemToDeleteId = null;
        $this->dispatch('hide-delete-modal');
        $this->loadItems();
        session()->flash('success', 'Level item deleted successfully.');
    }


    public function toggleItemStatus($id)
    {
        $item = LevelItem::findOrFail($id);

        $item->status = ! $item->status;

        $item->save();

        $this->loadItems();

        session()->flash(
            'success',
            $item->status
                ? 'Level item activated successfully.'
                : 'Level item deactivated successfully.'
        );
    }


    public function render()
    {
        return view('livewire.admin.level.level-items-manager');
    }
}
