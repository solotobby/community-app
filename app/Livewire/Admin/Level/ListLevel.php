<?php

namespace App\Livewire\Admin\Level;

use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;

class ListLevel extends Component
{
      use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.admin.level.list-level',
    [
          'levels' => Level::latest()->paginate(10)
    ]);
    }
}
