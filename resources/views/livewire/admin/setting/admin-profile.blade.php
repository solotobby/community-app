<div class="content">
    <div class="content-side content-side-full">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h4 class="mb-1">
                    <i class="fa fa-cog text-primary me-2"></i>Admin Settings
                </h4>
                <p class="text-muted mb-0">Manage admin users and system settings</p>
            </div>
            <div class="col-md-6 text-end">
                @if (auth()->user()->hasAnyRole(['super_admin']))
                    <button wire:click="openCreateModal" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Create Admin
                    </button>
                @endif
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Current User Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">
                            <i class="fa fa-user text-info me-2"></i>Your Account Details
                        </h3>
                    </div>
                    <div class="block-content">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <div class="avatar avatar-xl bg-primary text-white mb-2">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Name:</td>
                                        <td>{{ auth()->user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Email:</td>
                                        <td>{{ auth()->user()->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Role:</td>
                                        <td>
                                            @foreach(auth()->user()->getRoleNames() as $role)
                                                <span
                                                    class="badge bg-{{ $role === 'super_admin' ? 'danger' : 'primary' }} me-1">
                                                    {{ str_replace('_', ' ', ($role)) }}
                                                </span>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Phone:</td>
                                        <td>{{ auth()->user()->phone ?? 'Not provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Member Since:</td>
                                        <td>{{ auth()->user()->created_at->format('M d, Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Users List -->
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">
                            <i class="fa fa-users text-success me-2"></i>Admin Users
                        </h3>
                    </div>
                    <div class="block-content">
                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input wire:model.live.debounce.300ms="search" type="text" class="form-control"
                                    placeholder="Search by name, email, or phone...">
                            </div>
                            <div class="col-md-3">
                                <select wire:model.live="roleFilter" class="form-select">
                                    <option value="">All Roles</option>
                                    @foreach($availableRoles as $role)
                                        <option value="{{ $role->name }}">{{ str_replace('_', ' ', ($role->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select wire:model.live="statusFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="text-muted small mt-2">
                                    {{ $admins->total() }} admin(s) found
                                </div>
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div wire:loading.delay wire:target="search,roleFilter,statusFilter">
                            <div class="text-center py-3">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Table -->
                        <div wire:loading.remove wire:target="search,roleFilter,statusFilter">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Admin</th>
                                            <th>Roles</th>
                                            <th>Status</th>
                                            <th>Phone</th>
                                            <th>Joined</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($admins as $admin)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div
                                                            class="avatar avatar-sm bg-{{ $admin->hasRole('super_admin') ? 'danger' : 'primary' }} text-white me-3">
                                                            {{ strtoupper(substr($admin->name, 0, 2)) }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $admin->name }}</div>
                                                            <small class="text-muted">{{ $admin->email }}</small>
                                                            @if($admin->id === auth()->id())
                                                                <span class="badge bg-info ms-1">You</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @foreach($admin->getRoleNames() as $role)
                                                        <span
                                                            class="badge bg-{{ $role === 'super_admin' ? 'danger' : 'primary' }} me-1">
                                                            {{ str_replace('_', ' ', ($role)) }}
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $admin->status ? 'success' : 'secondary' }}">
                                                        {{ $admin->status ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>{{ $admin->phone ?? '-' }}</td>
                                                <td>
                                                    <div>
                                                        <span
                                                            class="d-block">{{ $admin->created_at->format('M d, Y') }}</span>
                                                        <small
                                                            class="text-muted">{{ $admin->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        @if (auth()->user()->hasAnyRole(['super_admin']))
                                                            <button wire:click="editAdmin({{ $admin->id }})"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        @endif

                                                        @if (auth()->user()->hasAnyRole(['super_admin']))
                                                            @if($admin->id !== auth()->id())
                                                                <button wire:click="confirmDelete({{ $admin->id }})"
                                                                    class="btn btn-sm btn-outline-danger">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="fa fa-users fa-2x mb-2 text-muted"></i>
                                                    <p class="mb-0">No admin users found</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($admins->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $admins->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Admin Modal -->
    @if($showCreateModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow theme-sensitive">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-user-plus text-primary me-2"></i>Create New Admin
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeCreateModal"></button>
                    </div>
                    <form wire:submit.prevent="createAdmin">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" wire:model="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" wire:model="email"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Role *</label>
                                    <select wire:model="role" class="form-select @error('role') is-invalid @enderror">
                                        @foreach($availableRoles as $availableRole)
                                            <option value="{{ $availableRole->name }}">
                                                {{ str_replace('_', ' ', ($availableRole->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" wire:model="phone"
                                        class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeCreateModal">Cancel</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Create Admin</span>
                                <span wire:loading>Creating...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Edit Admin Modal -->
    @if($showEditModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow theme-sensitive">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-edit text-warning me-2"></i>Edit Admin
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeEditModal"></button>
                    </div>
                    <form wire:submit.prevent="updateAdmin">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" wire:model="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" wire:model="email"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Role *</label>
                                    <select wire:model="role" class="form-select @error('role') is-invalid @enderror">
                                        @foreach($availableRoles as $availableRole)
                                            <option value="{{ $availableRole->name }}">
                                                {{ str_replace('_', ' ', ($availableRole->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" wire:model="phone"
                                        class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select wire:model="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeEditModal">Cancel</button>
                            <button type="submit" class="btn btn-warning" wire:loading.attr="disabled">
                                <span wire:loading.remove>Update Admin</span>
                                <span wire:loading>Updating...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow theme-sensitive">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-exclamation-triangle text-danger me-2"></i>Confirm Delete
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeDeleteModal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this admin user? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDeleteModal">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="deleteAdmin" wire:loading.attr="disabled">
                            <span wire:loading.remove>Delete</span>
                            <span wire:loading>Deleting...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
