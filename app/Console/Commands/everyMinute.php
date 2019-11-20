<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Place;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\Actions;
use App\Models\Client;
require __DIR__.'/../vendor/autoload.php';

class everyMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $reservations = Reservation::where('accepted', '=', '1')->get();
        $action = Actions::where('type', '=', 'cancelByExpiredTime')->first();
        foreach($reservations as $item)
        {
            $history = ReservationHistory::where('bid', '=', $item->id)->latest()->first();
            if($history->action()->type == "reservation")
            {
                $now = time() + 10800;
                $ends_at = strtotime($history->created_at->timezone('Europe/Moscow') . " + " . $history->timer ." hours");
                $diff = (int) $ends_at - $now;
                
                if($diff <= 0)
                {
                    $rating = Client::where('id', '=', $item->client)->first(['rating']);

                    Reservation::where('id', '=', $item->id)->update([
                        'accepted' => 2
                    ]);

                    ReservationHistory::create([
                        'bid' => $item->id,
                        'action' => $action->id
                    ]);

                    $newRating = $rating->rating + $action->points;

                    Client::where('id', '=', $item->client)->update([
                        'rating' => $newRating
                    ]);
                }
            }
        }
        // return true;
    }
}
