<?php

namespace App\Console;

use App\Auction;
use App\Bid;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $auctions = Auction::where('id_status', '=', 0)->get();

            foreach ($auctions as $auction) {
                $date = new Carbon($auction->ending_date, 'GMT+01');
                if (Carbon::now('GMT+01')->greaterThan($date)) {
                    $auction->id_status = 1;
                    $auction->save();
                }
            }
        })->everyMinute();
        ;
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
