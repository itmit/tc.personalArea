<?php

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Place;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\Actions;
use App\Models\Client;

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
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function () {
            // $reservations = Reservation::where('accepted', '=', '1')->get();
            // $action = Actions::where('type', '=', 'cancelByExpiredTime')->first();
            // foreach($reservations as $item)
            // {
            //     $history = ReservationHistory::where('bid', '=', $item->id)->latest()->first();
            //     if($history->action()->type == "reservation")
            //     {
            //         $now = time() + 10800;
            //         $ends_at = strtotime($history->created_at->timezone('Europe/Moscow') . " + " . $history->timer ." hours");
            //         $diff = (int) $ends_at - $now;
                    
            //         if($diff <= 0)
            //         {
            //             $rating = Client::where('id', '=', $item->client)->first(['rating']);

            //             Reservation::where('id', '=', $item->id)->update([
            //                 'accepted' => 2
            //             ]);

            //             ReservationHistory::create([
            //                 'bid' => $item->id,
            //                 'action' => $action->id
            //             ]);

            //             $newRating = $rating->rating + $action->points;

            //             Client::where('id', '=', $item->client)->update([
            //                 'rating' => $newRating
            //             ]);
            //         }
            //     }
            // }
            // return true;
        // })->everyMinute()->when(function () {
        //     return true;
        // });;
        $schedule->command('minute:update')->everyMinute();
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
