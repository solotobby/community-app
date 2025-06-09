<div class="container-fluid">
    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar-container me-3">
                                <div
                                    class="avatar bg-primary text-white d-flex align-items-center justify-content-center">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="mb-1">{{ $user->name }}</h3>
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    Level: {{ $user->levelInfo->name ?? 'Not assigned' }}
                                </small>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Users
                            </a>
                            {{-- <a href="{{ route('admin.users.index', $user) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i>Edit User
                            </a> --}}

                            <a href="{{ route('admin.users.raffle', ['id' => $user->id]) }}"
                                class="btn btn-primary" onclick="event.stopPropagation()">
                                View Raffle Draw
                            </a>

                            <a href="{{ route('admin.users.referral', $user) }}"
                                class="btn btn-primary" onclick="event.stopPropagation()">
                                View Referral
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Personal Information --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-grey border-bottom-0">
                    <h5 class="mb-0">
                        <i class="fas fa-user text-primary me-2"></i>
                        Personal Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted">Full Name</label>
                            <div class="fw-medium text-light">{{ $user->name }}</div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-muted">Email Address</label>
                            <div class="fw-medium text-light">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Referral Code</label>
                            <div class="d-flex align-items-center">
                                <code
                                    class="bg-light px-2 py-1 rounded me-2">{{ $user->referral_code ?? 'N/A' }}</code>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Referred By</label>
                            <div class="fw-medium text-light">{{ $user->referred_by ?? 'Direct signup' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Roles</label>
                            <div>
                                @forelse($user->getRoleNames() as $role)
                                    <span class="badge bg-primary me-1">{{ $role }}</span>
                                @empty
                                    <span class="text-muted">No roles assigned</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Email Verified</label>
                            <div>
                                @if ($user->email_verified_at)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Verified
                                    </span>
                                    <small
                                        class="text-muted d-block">{{ $user->email_verified_at->format('d M, Y') }}</small>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Not Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-grey border-bottom-0">
                    <h5 class="mb-0">
                        <i class="fas fa-address-book text-primary me-2"></i>
                        Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted">Phone Number</label>
                            <div class="d-flex align-items-center">
                                <div class="fw-medium font-monospace text-light">{{ $user->phone ?? 'Not provided' }}
                                </div>
                                @if ($user->phone && !$user->phone_verified)
                                    <span class="badge bg-warning text-dark ms-2">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Unverified
                                    </span>
                                @elseif($user->phone && $user->phone_verified)
                                    <span class="badge bg-success ms-2">
                                        <i class="fas fa-check me-1"></i>
                                        Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Address</label>
                            <div class="fw-medium text-light">{{ $user->address ?? 'Not provided' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Landmark</label>
                            <div class="fw-medium text-light">{{ $user->landmark ? null : 'Not provided' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">LGA</label>
                            <div class="fw-medium text-light">{{ $user->lga ?? 'Not provided' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">State</label>
                            <div class="fw-medium text-light">{{ $user->state ?? 'Not provided' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Country</label>
                            <div class="fw-medium text-light">{{ $user->country ?? 'Not provided' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Security Settings --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-grey border-bottom-0">
                    <h5 class="mb-0">
                        <i class="fas fa-shield-alt text-primary me-2"></i>
                        Security Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-3">
                        <div>
                            <div class="fw-medium">Transaction PIN</div>
                            <small class="text-muted">
                                @if ($user->transaction_pin)
                                    <i class="fas fa-check-circle text-success me-1"></i>
                                    PIN is configured and secure
                                @else
                                    <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                    No PIN set - transactions may be restricted
                                @endif
                            </small>
                        </div>
                        <span class="badge bg-{{ $user->transaction_pin ? 'success' : 'warning' }}">
                            {{ $user->transaction_pin ? 'Configured' : 'Not Set' }}
                        </span>
                    </div>
                    {{-- <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Created At</label>
                            <div class="fw-medium">{{ $user->created_at->format('d M, Y h:i A') }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Updated At</label>
                            <div class="fw-medium">{{ $user->updated_at->format('d M, Y h:i A') }}</div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

        {{-- Bank Information --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-grey border-bottom-0">
                    <h5 class="mb-0">
                        <i class="fas fa-university text-primary me-2"></i>
                        Bank Information
                    </h5>
                </div>
                <div class="card-body">
                    @if ($user->bankInfo && $user->bankInfo->bank_name && $user->bankInfo->account_number && $user->bankInfo->account_name)
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-muted">Bank Name</label>
                                <div class="fw-medium  text-light ">{{ $user->bankInfo->bank_name }}</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted">Account Number</label>
                                <div class="fw-medium  text-light font-monospace">
                                    {{ $user->bankInfo->account_number }}</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted">Account Name</label>
                                <div class="fw-medium text-light ">{{ $user->bankInfo->account_name }}</div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-university text-muted fa-3x mb-3"></i>
                            <p class="text-muted mb-0">No bank details added yet</p>
                            <small class="text-muted">User hasn't provided bank details</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <style>
        .avatar-container {
            width: 80px;
            height: 80px;
        }

        .avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .card-header.bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
</div>
