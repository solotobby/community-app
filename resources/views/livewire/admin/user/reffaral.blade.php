<div>
    <div class="content">
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="container-fluid p-0 m-0">
            <div class="card border-0">

                <div class="card-header bg-grey d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <a href="{{ route('admin.users.details', ['id' => $user->id]) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                        <i class="fas fa-gift text-primary me-2"></i>
                        {{ $user->name }} Referrals
                    </h5>
                    <div class="d-flex gap-2 align-items-center">
                        <div class="badge bg-info">
                            Total: {{ $user->referrals()->count() }}
                        </div>
                        <div class="badge bg-success">
                            Earned: {{ $user->referralCount()->where('reward_status', 'earned')->count() }}
                        </div>
                        <div class="badge bg-warning">
                            Completed: {{ $user->referralCount()->where('reward_status', 'completed')->count() }}
                        </div>
                        <div class="badge bg-danger">
                            Pending: {{ $user->referralCount()->where('reward_status', 'pending')->count() }}
                        </div>
                    </div>
                </div>

                <div class="card-body p-2 table-responsive">
                    <table class="table table-bordered table-hover" style="background-color: transparent;">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">S/N</th>
                                <th>Type</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Claimed</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rewards as $reward)
                                @php
                                    $referrer = optional($reward->referrer);
                                    $levelName = optional(\App\Models\Level::find($referrer->level))->name ?? '-';
                                    $isClaimed = $reward->is_claim;
                                    $hasSubscribed = $referrer->has_subscribed ?? false;

                                    if (!$isClaimed && !$hasSubscribed) {
                                        $status = 'Pending';
                                        $badgeClass = 'bg-warning text-dark';
                                    } elseif ($isClaimed && $hasSubscribed) {
                                        $status = 'Earned';
                                        $badgeClass = 'bg-success';
                                    } elseif (!$isClaimed && $hasSubscribed) {
                                        $status = 'Completed';
                                        $badgeClass = 'bg-primary';
                                    } else {
                                        $status = 'Unknown';
                                        $badgeClass = 'bg-secondary';
                                    }
                                @endphp
                                <tr>
                                    <th class="text-center">{{ $loop->iteration }}</th>
                                    <td>{{ ucfirst($reward->reward_type) }}</td>
                                    <td>{{ $levelName }}</td>
                                    <td><span class="badge {{ $badgeClass }}">{{ $status }}</span></td>
                                    <td>{{ $isClaimed ? 'Yes' : 'No' }}</td>
                                    <td>{{ $referrer->name ?? '-' }}</td>
                                    <td>{{ $referrer->email ?? '-' }}</td>
                                    <td>
                                        @if (!$isClaimed && $hasSubscribed)
                                            <span class="btn btn-sm btn-danger">Unclaimed</span>
                                        @else
                                            <span class="btn btn-sm btn-success">Claimed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No referrals found.</td>
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
