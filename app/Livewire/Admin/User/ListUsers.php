<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ListUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $filterByLevel = '';
    public $filterByStatus = '';

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'filterByLevel' => ['except' => ''],
        'filterByStatus' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function resetFilters()
    {
        $this->resetPage();
        $this->reset([
            'search',
            'filterByStatus',
            'filterByLevel'
        ]);
    }
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

    public function updatingFilterByLevel()
    {
        $this->resetPage();
    }

    public function updatingFilterByStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterByUserType()
    {
        $this->resetPage();
    }

    public function downloadCsv()
    {
        $users = $this->getCSVUsersQuery()->get();

        $filename = 'famlic_users_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Referral Code',
                'Level',
                'Status',
                'Address',
                'Created At'
            ]);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->referral_code,
                    $user->levelInfo?->name ?? 'N/A',
                    $user->has_subscribed
                        ? 'Subscribed' : ($user->free_user
                            ? 'Free Account' : 'Unsubscribed'),
                    $user->address . ' ' . $user->landmark . ' ' . $user->lga . ' ' . $user->state . ' ' . $user->country,
                    $user->created_at->format('d M, Y'),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function getCSVUsersQuery()
    {
        return User::role('user')
            ->with('levelInfo');
    }
    private function getFilteredUsersQuery()
    {
        $query = User::role('user')
            ->with('levelInfo');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterByLevel) {
            $query->where('level', $this->filterByLevel);
        }

        if ($this->filterByStatus !== '') {
            $query->where(function ($q) {
                if ($this->filterByStatus == '1') {
                    $q->where('has_subscribed', true);
                } elseif ($this->filterByStatus == '2') {
                    $q->where('has_subscribed', false)
                        ->where('free_user', true);
                } elseif ($this->filterByStatus == '3') {
                    $q->where('status', false);
                } else {
                    $q->where('has_subscribed', false)
                        ->where('free_user', false);
                }
            });
        }

        return $query->latest();
    }


    public function render()
    {
        $users = $this->getFilteredUsersQuery()->paginate($this->perPage);

        // Get filter options
        $levels = Level::all();

        return view('livewire.admin.user.list-users', compact('users', 'levels'));
    }
}
