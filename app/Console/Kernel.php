<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\MainIpPing::class,
        Commands\CarpoolTodayBookedMsg::class,
        Commands\RoomTodayBookedMsg::class,
        Commands\ScheduleCheck::class,
        // 'App\Console\Commands\MainIpPing',
        // 'App\Console\Commands\CarpoolTodayBookedMsg',
        // 'App\Console\Commands\RoomTodayBookedMsg',
        // 'App\Console\Commands\ScheduleCheck',
        //'App\Console\Commands\DbBackup',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('mainIp:ping')
                      ->everyTenMinutes();
                    //->everyFiveMinutes();
                    //->everyMinute();


        $schedule->command('carpool:today')
                     ->dailyAt('08:00');
                     //->everyMinute();

        $schedule->command('room:today')
                    ->dailyAt('08:01');
                    //->everyMinute();


        $schedule->command('schedule:check')
                    ->everyMinute()
                    ->onSuccess(function () {
                        // The task succeeded...
                        \Log::info("Laravel Schedule Ok From Kernel");
                    })
                    ->onFailure(function () {
                        // The task failed...
                        \Log::info("Laravel Schedule Fail From Kernel");
                    });

        // $schedule->command('db:backup')
        //             ->everyMinute();

       // $schedule->command('backup:run')->daily()->at('02:55');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
