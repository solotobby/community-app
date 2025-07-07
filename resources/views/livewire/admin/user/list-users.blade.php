<div class="content">
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Users</h3>

            <!-- Per‑page selector -->
                <div class="d-flex align-items-center">
                    <label class="me-2 mb-0 small text-muted">Per Page:</label>
                    <select wire:model.live="perPage" class="form-select form-select-sm w-auto">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
        </div>

        <div class="block-content">

            <!-- Search -->
            <div class="block pull-t pull-x">
    <div class="block-content block-content-full block-content-sm bg-body-light">
        <div class="input-group">
            <!-- Livewire search binding -->
            <input type="text"
                   wire:model.debounce.500ms="search"
                   class="form-control"
                   placeholder="Search users by name or email..." />

            <!-- Optional icon button; no submit -->
            <button type="button" class="btn btn-secondary">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</div>

            <!-- END Search -->


            <table class="table table-borderless table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <th class="text-center">
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->levelInfo?->name ?? 'N/A' }}</td>
                            <td>{{ $user->has_subscribed ? 'Subscribed' : 'Unsubscribed' }}</td>
                            {{-- <td>{{ $user->getRoleNames()->implode(', ') }}</td> --}}
                            <td>{{ $user->created_at->format('d M, Y') }}</td>
                             <td>
                                <a href="{{ route('admin.users.details', ['id' => $user->id]) }}"
                                    class="btn btn-sm btn-primary" onclick="event.stopPropagation()">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

             @if ($users->hasPages())
                <div class="mt-3 d-flex justify-content-between align-items-center px-3">
                    <small class="text-muted">
                        Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                    </small>
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
