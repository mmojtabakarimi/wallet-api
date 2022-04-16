<?php

namespace App\Console\Commands;

use App\Services\WalletService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateDaliyAmountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:dailyAmount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate daily amount';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(WalletService $walletService)
    {
        dump($walletService->calculateDailyTransaction(Carbon::now()));

        return 0;
    }

}
