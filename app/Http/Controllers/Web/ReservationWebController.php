<?php

namespace App\Http\Controllers\Web;

use App\Models\Place;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReservationWebController extends Controller
{
    /**
     * Показывает список заявок на бронирование.
     *
     * @return Factory|View
     */
    public function index()
    {
        $places = Reservation::where('accepted', '<>', '1')->orderBy('created_at', 'desc')->get();

        return view('manager.reservationList', [
            'title' => 'Заявки на бронь',
            'places' => $places
        ]);
    }

    /**
     * Меняет статус на забронировано.
     *
     * @return Factory|View
     */
    public function confirmReservation(Request $request)
    {
        $place = Place::where('id', '=', $request->place_id)
            ->update(['status' => 'Забронировано']);

        $reservation = Reservation::where('id', '=', $request->user_id)
            ->update(['accepted' => 1]);

        return response()->json(['Reservated']);
    }
}
