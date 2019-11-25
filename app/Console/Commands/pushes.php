<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;

class pushes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:send';

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
        $countOfReservations = Reservation::where('accepted', '=', '0')->get();
        $countOfReservations = $countOfReservations->count();

        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/tc-gardener/messages:send");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"message":{"notification":{"body":"У вас '.$countOfReservations.' необработанных заявок.","title":"Внимание"},"topic":"AdminNotification"}}');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization : Bearer ya29.ImOyB2NvUZji_VZEKsK22DR6SRsnxIbqNbkD_kCUQuOSQ_UdXyDWk-bLMyGqHdf-auwSH0L4AaukaJADR9hH2Q-tFVUz-vGOBoBeICrBadBadi9ev3Qt1zNDm4ZuAsVGgHxw9No"
        ]);

        curl_exec($ch);

        curl_close($ch); 
    }
}
