<div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Users</h3>
        </div>

        <div class="block-content">
            {{-- <div class="mb-3">
                <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="Search users by name or email...">
            </div> --}}

              <!-- Search -->
          <div class="block pull-t pull-x">
            <div class="block-content block-content-full block-content-sm bg-body-light">
                <div class="input-group">
                  <input type="text" class="form-control"  placeholder="Search users by name or email...">
                  <button type="submit" wire:model.debounce.500ms="search" class="btn btn-secondary">
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
                        <th>Role</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <th class="text-center">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                            <td>{{ $user->created_at->format('d M, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
