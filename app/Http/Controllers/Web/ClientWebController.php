<?php

namespace App\Http\Controllers\Web;

use App\Models\Place;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\Actions;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class ClientWebController extends Controller
{
    public function show($id)
    {
        return view("manager.clientDetail",
    [
        'client' => Client::where('id', '=', $id)->first(),
        'reservation' => $r = Reservation::where('client', '=', $id)->get(),
        'reservationHistory' => ReservationHistory::where('bid', '=', $r->id)->get()
    ]);
    }
}