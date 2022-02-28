<?php

namespace App\Console\Commands;

use App\Actions\SendMailVisitedAction;
use App\Enums\LocationEnum;
use App\Models\Location;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LocationParseNameCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse location name';

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
    public function handle()
    {
        $location = Location::query()->where('type', LocationEnum::JOB)->get()->map(function ($value) {
            $city = mb_strrpos($value->name, 'Thành phố');

            if ($city !== false) {
                $value->name_en = str_replace('Thành phố ', '', $value->name);
                $value->name_en = stripVN($value->name_en).' City';
            } else {
                $value->name_en = str_replace('Tỉnh ', '', $value->name);
                $value->name_en = stripVN($value->name_en);
            }

            return $value;
        })->toArray();

        foreach ($location as $value) {
            Location::find($value['id'])->update($value);
        }
    }
}
