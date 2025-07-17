<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class ListUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage  = 10;
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search'   => ['except' => ''],
        'perPage'  => ['except' => 10],
        'page'     => ['except' => 1],
    ];


    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }



    public function render()
    {
        $users = User::role('user')
            ->with('levelInfo')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.user.list-users', compact('users'));
    }
}
