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
                        <th>Registration Amount</th>
                        <th>Entry Gift Amount</th>
                        <th>Referral Bonus</th>
                        {{-- <th>Created By</th> --}}
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
                            {{-- <td>{{ $level->creator->name ?? 'N/A' }}</td> --}}
                            <td>{{ $level->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.item.level', ['level' => $level->id]) }}"
                                    class="btn btn-sm btn-primary" onclick="event.stopPropagation()">
                                    View Items
                                </a>
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
</div>
