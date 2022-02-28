<?php

namespace App\Console\Commands;

use App\Actions\ConvertUrlFileAction;
use App\Actions\CreateSitemapAction;
use App\Actions\MigrateContentAction;
use Illuminate\Console\Command;

class ConvertUrlFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert url file';

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
        (new ConvertUrlFileAction())->execute();
    }
}
