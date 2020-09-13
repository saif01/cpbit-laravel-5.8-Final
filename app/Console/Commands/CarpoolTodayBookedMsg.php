<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
 
use App\Http\Controllers\CarBookingController;

class CarpoolTodayBookedMsg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carpool:today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Today Car Booked Message';

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
        $Object = new CarBookingController();

        $Object->DailyBookedLineMsg();
        
        \Log::info("Today CarPool Message Send");
        
    }
}
