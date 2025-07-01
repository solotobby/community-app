<div class="content">
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <!-- Header and Add Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Gift Reasons</h4>
        <button class="btn btn-primary" wire:click="openModal">
            <i class="fas fa-plus me-1"></i> Add Reason
        </button>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reasons as $reason)
                        <tr>
                            <td><i class="fa {{ $reason->icon }}"></i></td>
                            <td>{{ $reason->reason }}</td>
                            <td>
                                <span class="badge bg-{{ $reason->status ? 'success' : 'secondary' }}">
                                    {{ $reason->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1" wire:click="edit({{ $reason->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $reason->id }})"
                                    onclick="return confirm('Delete this reason?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No gift reasons added yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form wire:submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $giftReasonId ? 'Edit' : 'Add' }} Gift Reason</h5>
                            <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Reason Name</label>
                                <input type="text" id="name" class="form-control" wire:model.defer="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Select Icon</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($availableIcons as $iconClass)
                                        <div class="border p-2 rounded text-center
                    {{ $icon === $iconClass ? 'border-primary shadow-sm' : 'border-light' }}"
                                            style="cursor: pointer; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;"
                                            wire:click="$set('icon', '{{ $iconClass }}')"
                                            title="{{ $iconClass }}">
                                            <i class="fa {{ $iconClass }} fa-lg"></i>
                                        </div>
                                    @endforeach
                                </div>
                                @error('icon')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" id="status" class="form-check-input"
                                    wire:model.defer="status">
                                <label for="status" class="form-check-label">Active</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="$set('showModal', false)">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                {{ $giftReasonId ? 'Update' : 'Create' }}
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
