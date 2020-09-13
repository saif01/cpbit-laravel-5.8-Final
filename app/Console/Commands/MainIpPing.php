<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\Network\NetworkMainIpPingController;

class MainIpPing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mainIp:ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Main Ip Auto Ping';

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
        $Object = new NetworkMainIpPingController();

        $Object->MainIpPingBySchedule();

       \Log::info("Cron is working for Main IP Ping");
    }
}
