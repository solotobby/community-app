<div>
     @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="alert alert-success"
        >
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Levels</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Registration Amount</th>
                        <th>Referral Bonus</th>
                        <th>Currency</th>
                        <th>Created By</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($levels as $level)
                        <tr>
                            <td>{{ $level->name }}</td>
                            <td>{{ number_format($level->registration_amount, 2) }}</td>
                            <td>{{ number_format($level->referral_bonus, 2) }}</td>
                            <td>{{ $level->currency }}</td>
                            <td>{{ $level->creator->name ?? 'N/A' }}</td>
                            <td>{{ $level->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No levels found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $levels->links() }}
            </div>
        </div>
    </div>
</div>
