<div class="block block-rounded">

    <div class="block-header d-flex justify-content-between align-items-center">
        <h3 class="block-title">All Games</h3>
        <a href="{{ route('user.games.create') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus-circle"></i> Create Game
        </a>

    </div>

    <div class="block-content">

        {{-- Filters --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <label>Filter by Category:</label>
                <select wire:model="category" class="form-control">
                    <option value="">All</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Premium:</label>
                <select wire:model="isPremium" class="form-control">
                    <option value="">All</option>
                    <option value="1">Premium</option>
                    <option value="0">Free</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Premium?</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($games as $game)
                        <tr onclick="window.location='{{ route('user.games.details', $game->id) }}'"
                            style="cursor: pointer;">
                            <td>{{ $game->name }}</td>
                            <td>{{ $game->category->name ?? '-' }}</td>
                            <td>{{ $game->is_premium ? 'Yes' : 'No' }}</td>
                            <td>{{ $game->amount ?? '-' }}</td>
                            <td>{{ ucfirst($game->status) }}</td>
                            <td>{{ $game->creator->name ?? 'Admin' }}</td>
                            <td>{{ $game->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No game found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $games->links() }}
        </div>
    </div>
    <style>
        tr[onclick]:hover {
            background-color: #f5f5f5;
        }
    </style>

</div>
