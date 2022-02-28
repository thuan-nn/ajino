<?php

namespace App\Console\Commands;

use App\Models\MailHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckOldTourEmailHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companyTourEmailHistory:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete emails were been out of duration';

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
     * @return void
     */
    public function handle()
    {
        $duration = 3; // Duration = 3 month
        $date = Carbon::now()->startOfMonth()->subMonths($duration)->toDateString();
        $mail = MailHistory::query()->where('created_at', '<', $date);
        $mail->delete();
    }
}
