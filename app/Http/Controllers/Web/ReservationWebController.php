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
        $places = Reservation::where('accepted', '=', '0')->orderBy('created_at', 'desc')->get();

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
        $response = [];
        switch ($request->selectByAccept) {
            case 'all':
                $reservations = Reservation::orderBy('created_at', 'desc')->get();
                foreach ($reservations as $reservation) {
                    $response[] = [
                        'id'   => $reservation->id,
                        'first_name' => $reservation->first_name,
                        'last_name' => $reservation->last_name,
                        'phone' => $reservation->phone,
                        'accepted' => $reservation->accepted,
                        'created_at' => substr($reservation->created_at->timezone('Europe/Moscow'), 0),
                        'updated_at' => substr($reservation->updated_at->timezone('Europe/Moscow'), 0),
                        'place' => [
                            'id' => $reservation->place()->id,
                            'block' => $reservation->place()->block,
                            'floor' => $reservation->place()->floor,
                            'row' => $reservation->place()->row,
                            'place_number' => $reservation->place()->place_number
                        ]
                    ];
                }
                return response()->json($response);
                break;
            case 'active':
                $reservations = Reservation::where('accepted', '=', '0')->orderBy('created_at', 'desc')->get();
                foreach ($reservations as $reservation) {
                    $response[] = [
                        'id'   => $reservation->id,
                        'first_name' => $reservation->first_name,
                        'last_name' => $reservation->last_name,
                        'phone' => $reservation->phone,
                        'accepted' => $reservation->accepted,
                        'created_at' => substr($reservation->created_at->timezone('Europe/Moscow'), 0),
                        'updated_at' => substr($reservation->updated_at->timezone('Europe/Moscow'), 0),
                        'place' => [
                            'id' => $reservation->place()->id,
                            'block' => $reservation->place()->block,
                            'floor' => $reservation->place()->floor,
                            'row' => $reservation->place()->row,
                            'place_number' => $reservation->place()->place_number
                        ]
                    ];
                }
                return response()->json($response);
                break;
            case 'accepted':
                $reservations = Reservation::where('accepted', '<>', '0')->orderBy('created_at', 'desc')->get();
                foreach ($reservations as $reservation) {
                    $response[] = [
                        'id'   => $reservation->id,
                        'first_name' => $reservation->first_name,
                        'last_name' => $reservation->last_name,
                        'phone' => $reservation->phone,
                        'accepted' => $reservation->accepted,
                        'created_at' => substr($reservation->created_at->timezone('Europe/Moscow'), 0),
                        'updated_at' => substr($reservation->updated_at->timezone('Europe/Moscow'), 0),
                        'place' => [
                            'id' => $reservation->place()->id,
                            'block' => $reservation->place()->block,
                            'floor' => $reservation->place()->floor,
                            'row' => $reservation->place()->row,
                            'place_number' => $reservation->place()->place_number
                        ]
                    ];
                }
                return response()->json($response);
                break;
            default:
                return response()->json(['Error']);
        }

        return response()->json(['Reservated']);
    }

    /**
     * Изменяет статус места с забронировано на свободно.
     *
     * @return Factory|View
     */
    public function deleteReservation(Request $request)
    {
        $place = Place::where('id', '=', $request->place_id)
            ->update(['status' => 'Свободен']);

        return response()->json(['Status updated']);
    }

    /**
     * Откланяет заявку на бронирование.
     *
     * @return Factory|View
     */
    public function cancelReservation(Request $request)
    {
        // return $request->place_id;

        $reservation = Reservation::where('id', '=', $request->place_id)
            ->update(['accepted' => 2]);

        return response()->json(['Status reservation updated']);
    }
}