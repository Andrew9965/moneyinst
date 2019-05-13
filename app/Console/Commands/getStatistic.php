<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ApiService;
use App\Models\Sites;
use App\Models\Ststistic;

class getStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:statistic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get site statistic from API';

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
     * @return mixed
     */
    public function handle()
    {
        foreach (Sites::where('status', '1')->get() as $site){
            $statistic = (new ApiService())->overall_stats($site->id, $site->user_id);
            if(!$statistic['error']){
                foreach ($statistic['result'] as $key=>$val) $statistic['result'][$key] = is_numeric($val) ? $val : 0;
                Ststistic::updateOrCreate(
                    ['user_id' => $site->user_id, 'site_id' => $site->id, 'date' => date('d.m.Y')],
                    $statistic['result']
                );
            }
        }

    }
}
