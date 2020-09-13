<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScheduleCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Checking Description';

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
       // \Log::info("Laravel Schedule Ok");
    }
}
