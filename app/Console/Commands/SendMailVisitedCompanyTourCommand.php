<?php

namespace App\Console\Commands;

use App\Actions\SendMailVisitedAction;
use Illuminate\Console\Command;

class SendMailVisitedCompanyTourCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitedCompanyTour:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to user when company tour was finished';

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
     * @param \App\Actions\SendMailVisitedAction $action
     */
    public function handle(SendMailVisitedAction $action)
    {
        $action->execute();
    }
}
