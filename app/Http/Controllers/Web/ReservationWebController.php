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
        $reservation = Reservation::where('id', '=', $request->place_id)
            ->first(['place_id']);

        $place = Place::where('id', '=', $reservation->place_id)
            ->update(['status' => 'Свободен']);

        if($place != 0)
        {
            $reservation = Reservation::where('id', '=', $request->place_id)
                ->update(['accepted' => 2]);

            return response()->json(['Status updated']);
        }

        return response()->json(['Error']);
    }

    /**
     * Отклоняет заявку на бронирование.
     *
     * @return Factory|View
     */
    public function cancelReservation(Request $request)
    {
        $reservation = Reservation::where('id', '=', $request->place_id)
            ->update(['accepted' => 2]);

        if($reservation != 0)
        {
            return response()->json(['Status reservation updated']);
        }

        return response()->json(['Error']);
    }

    /**
     * Показать страницу заявочки.
     *
     * @return Factory|View
     */
    public function show($id)
    {
        $reservation = Reservation::where('id', '=', $id)->first();
        $history = ReservationHistory::where('bid', '=', $id)->get();
        $lastAction = ReservationHistory::where('bid', '=', $id)->latest()->first();
        $actions = Actions::all();

        return view("manager.reservationDetail", [
            'reservation' => $reservation,
            'history' => $history,
            'lastAction' => $lastAction,
            'actions' => $actions,
        ]);
    }

    /**
     * Изменить статус заявки.
     *
     * @return Factory|View
     */
    public function changeReservationStatus(Request $request)
    {
        $action = Actions::where('id', '=', $request->new_status)->first();
        DB::beginTransaction();
        try {
            if($action->type == 'cancel')
            {
                return response()->json($request->client_id);
                $rating = Client::where('id', '=', Auth::id())->first(['rating']);
                Reservation::where('id', '=', $request->reservation_id)->update([
                    'accepted' => 2
                ]);
                ReservationHistory::create([
                    'bid' => $request->reservation_id,
                    'action' => $action->id
                ]);
                $newRating = $rating + $action->points;
                Client::where('id', '=', $request->client_id)->update([
                    'rating' => $newRating
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(false);
        }

        return response()->json(true);
    }
}