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
        $schedule->call(function () {
            $reservations = Reservation::where('accepted', '=', '1')->get();
            foreach($reservations as $item)
            {
                $history = ReservationHistory::where('bid', '=', $item->id)->latest()->first();
                if($history->action()->type == "reservation")
                {
                    $stats_at = strtotime($lastAction->created_at->timezone('Europe/Moscow'));
                    $ends_at = strtotime($lastAction->created_at->timezone('Europe/Moscow') . " + " . $lastAction->timer ." hours");
                    if($ends_at <= $stats_at)
                    {
                        Reservation::where('id', '=', $item->id)->update([
                            'accepted' => 2
                        ]);
                    }
                }
            }

        })->everyMinute()->when(function () {
            return true;
        });;
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
