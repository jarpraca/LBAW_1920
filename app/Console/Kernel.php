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
        Log::emergency("Schedule");

        $schedule->call(function () {
            Log::emergency("Ending date schedule");
            $auctions = Auction::where('id_status', '=', 0)->get();

            foreach ($auctions as $auction) {
                // if (Carbon::now()->greaterThan(new Carbon($auction->ending_date))) {
                    Log::emergency("Auction " . $auction->id . " finished.");
                    $winner = Bid::where('id_auction', $auction->id)->leftJoin('users', 'users.id', '=', 'bids.id_buyer')->select('users.id as id')->orderBy('value', 'desc')->first()->get();
                    $auction->id_winner = $winner->id;
                    $auction->id_status = 1;
                    $auction->save();
                // }
            }
            // })->daily();
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
