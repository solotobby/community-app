<div>
    <div class="block block-rounded">
        <div class="block-header d-flex justify-content-between align-items-center">
            <h3 class="block-title">{{ $game->name }} - Details</h3>
            <a href="{{ route('user.games.index') }}" class="btn btn-sm btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back to Games
            </a>
        </div>

        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Game Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" style="width: 40%;">Category:</th>
                                        <td>{{ $game->category->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0">Premium:</th>
                                        <td>
                                            @if($game->is_premium)
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0">Amount:</th>
                                        <td>
                                            @if($game->amount)
                                                #{{ number_format($game->amount, 2) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0">Status:</th>
                                        <td>
                                            @if($game->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning">{{ ucfirst($game->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Game Configuration</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" style="width: 40%;">Number of Players:</th>
                                        <td>{{ $game->number_of_players }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0">Number of Questions:</th>
                                        <td>{{ $game->number_of_questions }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0">Created By:</th>
                                        <td>{{ $game->creator->name ?? 'Admin' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0">Created:</th>
                                        <td>
                                            <span title="{{ $game->created_at }}">{{ $game->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Questions Section --}}
    <div class="block block-rounded mt-4">
        <div class="block-header d-flex justify-content-between align-items-center">
            <h3 class="block-title">
                Questions
                <span class="badge bg-primary ms-2">{{ $game->questions->count() }}</span>
            </h3>
            <a href="{{ route('user.games.questions.create', $game->id) }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-circle me-1"></i> Add Question
            </a>
        </div>

        <div class="block-content">
            @if($game->questions->isEmpty())
                <div class="text-center py-4">
                    <div class="mb-3">
                        <i class="fa fa-question-circle fa-3x text-muted"></i>
                    </div>
                    <p class="text-muted">No questions added to this game yet.</p>
                    <a href="{{ route('user.games.questions.create', $game->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-plus-circle me-1"></i> Add Your First Question
                    </a>
                </div>
            @else
                <div class="list-group">
                    @foreach($game->questions as $index => $question)
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-secondary me-2">{{ $index + 1 }}</span>
                                {{ $question->text }}
                            </div>
                            <div>
                                <a href="{{ route('user.games.questions.edit', ['game' => $game->id, 'question' => $question->id]) }}"
                                   class="btn btn-sm btn-outline-primary me-2">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button wire:click="confirmDeleteQuestion({{ $question->id }})"
                                        class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Players Section (commented but improved) --}}
    @if($game->players->isNotEmpty())
    <div class="block block-rounded mt-4">
        <div class="block-header d-flex justify-content-between align-items-center">
            <h3 class="block-title">
                Players
                <span class="badge bg-info ms-2">{{ $game->players->count() }}</span>
            </h3>
        </div>
        <div class="block-content table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($game->players as $player)
                        <tr>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->email }}</td>
                            <td>{{ $player->pivot->created_at->diffForHumans() }}</td>
                            <td>{{ $player->pivot->score ?? '0' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
