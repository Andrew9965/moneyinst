<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invites;

class removeInvites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'removeInvites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление просроченных инвайтов';

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
        $droped = Invites::where('status',1)->where('timestamp', '<=', time()-86400)->get();
        foreach ($droped as $drop) $drop->delete();
    }
}
