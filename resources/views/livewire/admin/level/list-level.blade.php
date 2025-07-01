<div>
    <div class="content">
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-2">Levels</h3>
            <a href="{{ route('admin.create.level') }}" class="btn btn-primary">
                Add New Level
            </a>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Currency</th>
                        <th>Registration <br>Amount</th>
                        <th>Entry Gift <br> Amount</th>
                        <th>Referral Bonus</th>
                        <th>Items Count</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($levels as $level)
                        <tr style="cursor:pointer"
                            onclick="window.location='{{ route('admin.item.level', ['level' => $level->id]) }}'">
                            <td>{{ $level->name }}</td>
                            <td>{{ $level->currency }}</td>
                            <td>{{ number_format($level->registration_amount, 2) }}</td>
                            <td>{{ number_format($level->entry_gift, 2) }}</td>
                            <td>{{ number_format($level->referral_bonus, 2) }}</td>
                            <td>{{ ($level->levelItems->count()) }}</td>
                            {{-- <td>{{ $level->creator->name ?? 'N/A' }}</td> --}}
                            <td>{{ $level->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.item.level', ['level' => $level->id]) }}"
                                    class="btn btn-sm btn-primary" onclick="event.stopPropagation()">
                                    View Items
                                </a>

                                <button class="btn btn-sm btn-warning" wire:click.stop="editLevel({{ $level->id }})"
                                    data-bs-toggle="modal" data-bs-target="#editLevelModal">
                                    Edit Level
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No levels found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $levels->links() }}
            </div>
        </div>

    </div>

    <!-- Edit Level Modal -->
    <div wire:ignore.self class="modal fade" id="editLevelModal" tabindex="-1" aria-labelledby="editLevelModalLabel"
        aria-hidden="true">

             <div class="modal-dialog modal-dialog-centered modal-lg">

            <form wire:submit.prevent="updateLevel" class="modal-content theme-sensitive border-0 shadow-lg">
                <div class="modal-header bg-gradient-success text-white text-center border-0 position-relative overflow-hidden">
                    <h5 class="modal-title" id="editLevelModalLabel">Edit Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input wire:model.defer="edit.name" type="text" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Registration Amount</label>
                        <input wire:model.defer="edit.registration_amount" type="number" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Entry Gift Percentage</label>
                        <input wire:model.defer="edit.entry_gift" type="number" max="100" class="form-control"
                            placeholder="0-100%">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Referral Bonus Percentage</label>
                        <input wire:model.defer="edit.referral_bonus" type="number" max="100" class="form-control"
                            placeholder="0-100%">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Currency</label>
                        <select wire:model.defer="edit.currency" class="form-control">
                            <option value="">-- Select Currency --</option>
                            <option value="NGN">Naira (NGN)</option>
                            <option value="USD">US Dollar (USD)</option>
                            <option value="EUR">Euro (EUR)</option>
                            <option value="GBP">British Pound (GBP)</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Level</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        window.addEventListener('close-modal', () => {
            const modalEl = document.getElementById('editLevelModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (!modal) {
                modal = new bootstrap.Modal(modalEl);
            }
            modal.hide();
        });
    </script>

 <style>
    .theme-sensitive {
        background-color: #ffffff;
        color: #212529;
    }

    @media (prefers-color-scheme: dark) {
        .theme-sensitive {
            background-color: #1e1e1e !important;
            color: #f1f1f1 !important;
        }

        .theme-sensitive .form-control {
            background-color: #2b2b2b;
            color: #f1f1f1;
            border-color: #444;
        }

        .theme-sensitive .form-control::placeholder {
            color: #aaa;
        }

        .theme-sensitive .modal-header {
            border-bottom-color: #333;
        }

        .theme-sensitive .modal-footer {
            border-top-color: #333;
        }

        .theme-sensitive .btn-close {
            filter: invert(1);
        }

        .theme-sensitive .invalid-feedback {
            color: #ff8888;
        }
    }
</style>
</div>
