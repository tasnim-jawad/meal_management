<?php

namespace App\Console\Commands;

use App\Http\Controllers\DueController;
use Illuminate\Console\Command;



class EndOfMonthReport extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:eomr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dd('hi');
        eomr();
    }
}
