<?php

namespace App\Console;

use App\Auction;
use App\Bid;
use App\Notification;
use App\User;
use App\Watchlist;
use Carbon\Carbon;
use Exception;
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

                try {
                    $date->subHours(2);
                    if (Carbon::now('GMT+01')->equalTo($date)) {
                        $bids = Bid::distinct()->where('id_auction', $auction->id)->get();
                        $watchs = Watchlist::distinct()->where('id_auction', $auction->id)->whereNotIn('id_buyer', $bids)->get();
                        $users = $bids->merge($watchs);

                        foreach ($users as $user) {
                            $notification = new Notification();
                            $notification->message = $auction->species_name . "'s auction ends in 2 hours! Hurry up!";
                            $notification->read = FALSE;
                            $notification->type = "ending";
                            $notification->id_auction = $auction->id;
                            $notification->id_buyer = $user->id_buyer;
                            $notification->save();
                        }
                    }
                } catch (Exception $e) {
                    Log::emergency($e->getMessage());
                }
            }
        })->everyMinute();;
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
