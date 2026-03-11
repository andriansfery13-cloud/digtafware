<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CancelOldOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-old-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel pending orders that are older than 4 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = \App\Models\Order::where('status', 'pending')
            ->where('created_at', '<=', now()->subHours(4))
            ->update(['status' => 'cancelled']);

        $this->info("Cancelled {$count} old pending orders.");
    }
}
