<div class="content-side content-side-full">
    <div class="row">
        <!-- Total Games Played -->
        <div class="col-md-3">
            <div class="block block-rounded block-bordered">
                <div class="block-header bg-primary">
                    <h3 class="block-title text-white">Games Played</h3>
                </div>
                <div class="block-content">
                    <p class="fs-3">{{ $totalGamesPlayed }}</p>
                </div>
            </div>
        </div>

        <!-- Wallet Balance -->
        <div class="col-md-3">
            <div class="block block-rounded block-bordered">
                <div class="block-header bg-success">
                    <h3 class="block-title text-white">Wallet Balance</h3>
                </div>
                <div class="block-content">
                    <p class="fs-3">#{{ number_format((int) $wallet, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Active Games -->
        <div class="col-md-3">
            <div class="block block-rounded block-bordered">
                <div class="block-header bg-warning">
                    <h3 class="block-title text-white">Active Games</h3>
                </div>
                <div class="block-content">
                    <p class="fs-3">{{ $activeGames }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Transactions -->
        <div class="col-md-3">
            <div class="block block-rounded block-bordered">
                <div class="block-header bg-danger">
                    <h3 class="block-title text-white">Pending Transactions</h3>
                </div>
                <div class="block-content">
                    <p class="fs-3">{{ $pendingTransactions }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Total Transactions -->
        <div class="col-md-3">
            <div class="block block-rounded block-bordered">
                <div class="block-header bg-danger">
                    <h3 class="block-title text-white">Total Transactions</h3>
                </div>
                <div class="block-content">
                    <p class="fs-3">{{ $totalTransactions }}</p>
                </div>
            </div>
        </div>

        <!-- Total Winnings -->
        <div class="col-md-3">
            <div class="block block-rounded block-bordered">
                <div class="block-header bg-info">
                    <h3 class="block-title text-white">Total Winnings</h3>
                </div>
                <div class="block-content">
                    <p class="fs-3">#{{ number_format($totalWinnings, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
