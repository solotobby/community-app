<div>
    <div class="content">
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="container-fluid p-0 m-0">
            <div class="card border-0">
                <div class="card-header">
                    <h5 class="mb-0">My Rewards</h5>
                </div>
                <div class="card-body p-2 table-responsive">
                    <table class="table table-bordered table-hover" style="background-color: transparent;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">S/N</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Currency</th>
                                <th>Status</th>
                                <th>Claimed</th>
                                <th>Referred User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rewards as $reward)
                                <tr>
                                    <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ ucfirst($reward->reward_type) }}</td>
                                    <td>{{ number_format($reward->amount, 2) }}</td>
                                    <td>{{ strtoupper($reward->currency) }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $reward->reward_status === 'earned' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ ucfirst($reward->reward_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $reward->is_claim ? 'Yes' : 'No' }}</td>
                                    <td>{{ $reward->user->name ?? '-' }}</td>
                                    <td>
                                        @if (!$reward->isclaim && $reward->reward_status === 'pending')
                                            <button wire:click="claim({{ $reward->id }})"
                                                class="btn btn-sm btn-success">
                                                Claim
                                            </button>
                                        @else
                                            <span class="text-muted">Claimed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No rewards found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $rewards->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
