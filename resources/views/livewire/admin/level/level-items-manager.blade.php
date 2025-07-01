<div class="content">
    <div class="mt-4 mx-4">
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Items for Level: <strong>{{ $level->name }}</strong></h3>
            <button type="button" class="btn btn-primary" wire:click="openModal">
                Add New Item
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade @if ($showModal) show d-block @endif" tabindex="-1" role="dialog"
            @if ($showModal) style="background-color: rgba(0,0,0,0.5);" @endif>
            {{-- <div class="modal-dialog" role="document"> --}}
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content theme-sensitive border-0 shadow-lg">
                    <div
                        class="modal-header bg-gradient-success text-white text-center border-0 position-relative overflow-hidden">
                        <h5 class="modal-title">Add New Item</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="submit">
                            <div class="mb-3">
                                <label class="form-label">Item Name</label>
                                <input wire:model="itemname" type="text"
                                    class="form-control @error('itemname') is-invalid @enderror">
                                @error('itemname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input wire:model="price" type="number" step="0.01"
                                    class="form-control @error('price') is-invalid @enderror">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Item Image</label>
                                <input wire:model="image" type="file"
                                    class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($image)
                                    <div class="mt-2">
                                        <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail"
                                            style="max-height: 150px;">
                                    </div>
                                @endif
                            </div>

                            <button class="btn btn-primary" type="submit">Add Item</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- List of Items -->
        @if ($items->count())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;"></th>
                        <th>Item Name</th>
                        <th>Item Image</th>
                        <th>Price ({{ $level->currency }})</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->item_name }}</td>
                            <td>
                                @if ($item && $item->item_url)
                                    <div class="mb-2">
                                        @php
                                            $imageUrl = Str::startsWith($item->item_url, ['http://', 'https://'])
                                                ? $item->item_url
                                                : Storage::url($item->item_url);
                                        @endphp
                                        <img src="{{ $imageUrl }}" class="img-thumbnail" style="max-height: 100px;">
                                    </div>
                                @endif
                            </td>

                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ optional($item->creator)->name ?? 'N/A' }}</td>
                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $item->id }})">
                                    Delete
                                </button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No items found for this level.</p>
        @endif
    </div>

    <div wire:ignore.self class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content theme-sensitive border-0 shadow-lg">
                <div
                    class="modal-header bg-gradient-success text-white text-center border-0 position-relative overflow-hidden">
                    <h5 class="modal-title" id="confirmDeleteLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteItem">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('show-delete-modal', () => {
            let modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        });

        window.addEventListener('hide-delete-modal', () => {
            let modalEl = document.getElementById('confirmDeleteModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
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
