<?php

namespace App\Http\Controllers\Web;

use App\Models\Place;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
            $place = Place::where('id', '=', $request->place_id)
                ->update(['status' => 'Забронировано']);

            $reservation = Reservation::where('id', '=', $request->user_id)
                ->update(['accepted' => 1]);
        DB::commit();

        return response()->json(['Reservated']);
    }

    /**
     * Отображает места с разными статусами.
     *
     * @return Factory|View
     */
    public function selectByAccept(Request $request)
    {
        switch ($request->selectByAccept) {
            case 'all':
                return response()->json([Reservation::orderBy('created_at', 'desc')->get()]);
                break;
            case 'active':
                return response()->json([Reservation::where('accepted', '<>', '1')->orderBy('created_at', 'desc')->get()]);
                break;
            case 'accepted':
                return response()->json([Reservation::where('accepted', '=', '1')->orderBy('created_at', 'desc')->get()]);
                break;
            default:
                return response()->json(['Error']);
        }

        return response()->json(['Reservated']);
    }
}