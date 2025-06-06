<div>
    @php
        use App\Models\Level;
    @endphp

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
                <div class="card-header">
                    <h5 class="mb-0">My Referral(s)</h5>
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
                                <tr>
                                    <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ ucfirst($reward->reward_type) }}</td>
                                    <td>
                                        @php
                                            $level = Level::findOrFail($reward->referrer->level);
                                        @endphp
                                        {{ $level->name }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $reward->referrer->has_subscribed ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $reward->referrer->has_subscribed ? 'Completed' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td>{{ $reward->is_claim ? 'Yes' : 'No' }}</td>
                                    <td>{{ $reward->referrer->name ?? '-' }}</td>
                                    <td>{{ $reward->referrer->email ?? '-' }}</td>
                                    <td>
                                        @if (!$reward->is_claim && $reward->referrer->has_subscribed)
                                            <a href="{{ route('user.raffle.claim') }}"
                                                class="btn btn-sm btn-success">
                                                Claim Now
                                            </a>
                                        @else
                                            <span class="text-muted">Claimed</span>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No rewards found.</td>
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
