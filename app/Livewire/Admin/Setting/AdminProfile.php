<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminProfile extends Component
{
    use WithPagination;

    // Modal properties
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // Form properties
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'admin';
    public $phone = '';
    public $status = 'active';

    // Edit/Delete properties
    public $editingUserId = null;
    public $deletingUserId = null;

    // Filters
    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ];

        if ($this->showEditModal && $this->editingUserId) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->editingUserId;
        }

        return $rules;
    }

    public function mount()
    {
        // Set default role to first available admin role
        $this->role = $this->getAvailableRoles()->first()?->name ?? 'admin';
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function createAdmin()
    {
        $this->validate();

        // Check if current user can assign this role
        // if (!$this->canAssignRole($this->role)) {
        //     session()->flash('error', 'You do not have permission to assign this role.');
        //     return;
        // }

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make('password123'),
            'phone' => $this->phone,
            'status' => $this->status,
            'email_verified_at' => now(),
        ]);

        // Assign role using Spatie
        $user->assignRole($this->role);

        $this->closeCreateModal();
        session()->flash('success', 'Admin user created successfully!');
    }

    public function editAdmin($userId)
    {
        $user = User::findOrFail($userId);

        // Check if current user can edit this user
        if (!$this->canEditUser($user)) {
            session()->flash('error', 'You do not have permission to edit this user.');
            return;
        }

        $this->editingUserId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->getRoleNames()->first() ?? 'admin';
        $this->phone = $user->phone;
        $this->status = $user->status ?? 'active';
        $this->password = '';
        $this->password_confirmation = '';

        $this->showEditModal = true;
    }

    public function updateAdmin()
    {
        $this->validate();

        $user = User::findOrFail($this->editingUserId);

        // Check permissions
        // if (!$this->canEditUser($user) || !$this->canAssignRole($this->role)) {
        //     session()->flash('error', 'You do not have permission to perform this action.');
        //     return;
        // }

        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
        ];

        if (!empty($this->password)) {
            $updateData['password'] = Hash::make($this->password);
        }

        $user->update($updateData);

        // Update role using Spatie
        $user->syncRoles([$this->role]);

        $this->closeEditModal();
        session()->flash('success', 'Admin user updated successfully!');
        return;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
        $this->resetValidation();
        $this->editingUserId = null;
    }

    public function confirmDelete($userId)
    {
        $user = User::findOrFail($userId);

        // Check if current user can delete this user
        if (!$this->canDeleteUser($user)) {
            session()->flash('error', 'You do not have permission to delete this user.');
            return;
        }

        // Prevent self-deletion
        if ($user->id === Auth::id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $this->deletingUserId = $userId;
        $this->showDeleteModal = true;
    }

    public function deleteAdmin()
    {
        $user = User::findOrFail($this->deletingUserId);

        // Final permission check
        if (!$this->canDeleteUser($user) || $user->id === Auth::id()) {
            session()->flash('error', 'You cannot delete this user.');
            return;
        }

        $user->delete();

        $this->closeDeleteModal();
        session()->flash('success', 'Admin user deleted successfully!');
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingUserId = null;
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->role = $this->getAvailableRoles()->first()?->name ?? 'admin';
        $this->phone = '';
        $this->status = 'active';
    }

    // Helper methods for role management
    private function getAvailableRoles()
    {
        $user = Auth::user();

        // if ($user->hasRole('super_admin')) {
            return Role::whereIn('name', ['admin', 'super_admin'])->get();
        // }

        // return Role::where('name', 'admin')->get();
    }

    private function canAssignRole($roleName)
    {
        $user = Auth::user();

        if ($roleName === 'super_admin' && !$user->hasRole('super_admin')) {
            return false;
        }

        return $user->hasAnyRole(['admin', 'super_admin']);
    }

    private function canEditUser($user)
    {
        $currentUser = Auth::user();

        if ($user->hasRole('super_admin') && !$currentUser->hasRole('super_admin')) {
            return false;
        }

        return $currentUser->hasAnyRole(['admin', 'super_admin']);
    }

    private function canDeleteUser($user)
    {
        $currentUser = Auth::user();

        if ($user->hasRole('super_admin') && !$currentUser->hasRole('super_admin')) {
            return false;
        }

        return $currentUser->hasRole('super_admin');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedRoleFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $admins = User::role(['admin', 'super_admin'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->role($this->roleFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $availableRoles = $this->getAvailableRoles();

        return view('livewire.admin.setting.admin-profile', compact('admins', 'availableRoles'));
    }
}
