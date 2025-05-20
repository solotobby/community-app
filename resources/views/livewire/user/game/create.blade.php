<div>
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">Create New Game</h3>
        </div>
        <div class="block-content">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="create" class="mb-4">
                <div class="row g-3">
                    <!-- Game Name -->
                    <div class="col-md-6 mb-3">
                        <label for="gameName" class="form-label fw-semibold">Game Name</label>
                        <input wire:model="name" type="text" class="form-control" id="gameName"
                            placeholder="Enter game name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Game Category -->
                    <div class="col-md-6 mb-3">
                        <label for="gameCategory" class="form-label fw-semibold">Category</label>
                        <select wire:model="game_category_id" class="form-select" id="gameCategory">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('game_category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Game Configuration -->
                    <div class="col-md-6 mb-3">
                        <label for="numPlayers" class="form-label fw-semibold">Number of Players</label>
                        <input wire:model="number_of_players" type="number" class="form-control" id="numPlayers"
                            min="1" placeholder="1">
                        @error('number_of_players')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="numQuestions" class="form-label fw-semibold">Number of Questions</label>
                        <input wire:model="number_of_questions" type="number" class="form-control" id="numQuestions"
                            min="1" placeholder="10">
                        @error('number_of_questions')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Premium Options -->
                    <div class="col-md-6 mb-3">
                        <h5 class="card-title mb-3">Premium Settings</h5>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Is this a premium game?</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input wire:model="is_premium" class="form-check-input" type="radio"
                                        value="1" id="premiumYes">
                                    <label class="form-label fw-semibold" for="premiumYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input wire:model="is_premium" class="form-check-input" type="radio"
                                        value="0" id="premiumNo">
                                    <label class="form-check-label" for="premiumNo">No</label>
                                </div>
                            </div>
                            @error('is_premium')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Amount field conditionally shown -->
                        @if ($is_premium == '1')
                            <div class="mb-0">
                                <label for="gameAmount" class="form-label fw-semibold">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">#</span>
                                    <input wire:model="amount" type="number" class="form-control" id="gameAmount"
                                        step="0.01" min="0" placeholder="0.00">
                                </div>
                                @error('amount')
                                    {{-- <small class="text-danger">{{ $message }}</small> --}}
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('user.games.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Create Game
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
