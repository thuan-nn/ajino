<?php

namespace App\Console\Commands;

use App\Actions\CreateSitemapAction;
use Illuminate\Console\Command;

class SiteMapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap for website';

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
        (new CreateSitemapAction)->generate();

        $this->info('The sitemap was successful!');
    }
}
