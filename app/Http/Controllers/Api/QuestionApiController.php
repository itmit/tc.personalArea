<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use App\Models\Place;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\Actions;
use App\Models\Client;

class QuestionApiController extends ApiBaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone_number' => 'required|min:18',
            'text' => 'required',
            'place_number' => 'required|string|max:255',
            'block' => 'required|string|max:255',
            'row' => 'required|string',
            'floor' => 'required|string|max:255',
            'type' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors()->first());
        }

        $this->place = Place::checkValidPlaceNumber($request->input('block'), $request->input('floor'), $request->input('place_number'), $request->input('row'));  

        $validator->after(function ($validator) {
            if ($this->place == null) {
                $validator->errors()->add('PlaceNumber', 'В этом блоке нет места с указанным номером.');
            }
        });

        $newQuestion = Question::create([
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'text' => $request->input('text'),
            'place' => $this->place->id,
            'type' => $request->input('type')
        ]);

        QuestionHistory::create([
            'bid' => $newQuestion->id,
            'status' => 'не обработана',
        ]);

        return $this->sendResponse([], 'Stored');
    }

    // public function test()
    // {
    //     $now = time();

    //     $reservations = Reservation::where('accepted', '=', '0')->get();
    //     foreach($reservations as $reservation)
    //     {
    //         $expire_at = strtotime($reservation->expires_at);
    //         $diff =(int) $expire_at - $now;
    //         return 'now: ' . $now . ' exp: ' . $expire_at . ' diff: ' . $diff;
    //         if($diff <= 0)
    //         {
    //             Reservation::where('id', '=', $reservation->id)->update([
    //                 'expire' => 1
    //             ]);
    //         }
    //     }
    // }
}
