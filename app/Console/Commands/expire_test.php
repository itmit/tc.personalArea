<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Place;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\Actions;
use App\Models\Client;

class expire_test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверяет заявки на то, истекло ли время на обработку';

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
        $now = time();

        $reservations = Reservation::where('accepted', '=', '0')->get();
        foreach($reservations as $reservation)
        {
            $expire_at = strtotime($reservation->expire_ats);
            $diff =  $now - (int) $expire_at;
            if($diff <= 0)
            {
                Reservation::where('id', '=', $reservation->id)->update([
                    'expire' => 1
                ]);
            }
        }
    }
}
