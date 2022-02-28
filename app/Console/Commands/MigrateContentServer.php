<?php

namespace App\Console\Commands;

use App\Actions\CreateSitemapAction;
use App\Actions\MigrateContentAction;
use Illuminate\Console\Command;

class MigrateContentServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:server';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate content server';

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
     */
    public function handle()
    {
        (new MigrateContentAction())->execute();
    }
}
