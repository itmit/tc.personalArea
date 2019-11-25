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

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array (
            'to' => '/topics/AdminNotification',
            "notification" => [
                "body" => "У вас ".$countOfReservations." необработанных заявок.",
                "title" => "Внимание"
            ]
        );
        $fields = json_encode ( $fields );

        $headers = array (
                'Authorization: key=' . "AAAAcZkfTDU:APA91bGgoysHhtZfk272579GGadndryldrSN49MEIO3QGrgI1aKTYir62YbtVXHEaICk1-G1NIWq9DsmCwQGmcmnqqlXWltysqQRoXPoXEdkvz-1oiHS-cF54VSNsWOvut-I_0gBQgrx",
                'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        curl_exec ( $ch );

        curl_close ( $ch );
    }
}
