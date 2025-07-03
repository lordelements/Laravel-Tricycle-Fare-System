<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\AuditTrail;
use Illuminate\Console\Command;

class DeleteOldAuditLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:delete-old';
    protected $description = 'Deletes user activity logs older than 30 days.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $deletedRows = AuditTrail::where('created_at', '<', $thirtyDaysAgo)->delete();

        $this->info("Deleted {$deletedRows} audit trail entries older than 30 days.");

        return 0;
    }
}
