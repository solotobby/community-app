<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetWalletBalances extends Command
{
    /**
     * The name and signature of the console command.
     */
protected $signature = 'wallets:reset-balances {--dry-run : Show what would be reset without making changes}';

    /**
     * The console command description.
     */
    protected $description = 'Reset all wallet balances (total, withdrawable, processing) to 0';

    /**
     * Execute the console command.
     */
    public function handle()
{
    if ($this->option('dry-run')) {
        $count = DB::table('wallets')->count();

        $this->info("🔍 Dry run: {$count} wallet(s) would be updated (set balances to 0).");
        return;
    }

    try {
        $count = DB::table('wallets')->update([
            'balance'        => 0,
            'withdrawable_balance' => 0,
            'processing_balance'   => 0,
            'updated_at'           => now(),
        ]);

        $this->info("✅ Wallet reset successful. Affected rows: {$count}");
    } catch (\Throwable $e) {
        $this->error("❌ Failed to reset wallet balances: " . $e->getMessage());
    }
}

}
