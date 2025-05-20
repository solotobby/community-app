<?php

namespace App\Livewire\Admin\Level;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LevelItem;

class AllLevelItems extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // or 'tailwind' depending on your CSS

    public function delete($id)
    {
        $item = LevelItem::findOrFail($id);
        $item->delete();

        session()->flash('success', 'Level item deleted successfully.');
    }

    public function render()
    {
        $items = LevelItem::latest()->paginate(10);

        return view('livewire.admin.level.all-level-items', [
            'items' => $items,
        ]);
    }
}
