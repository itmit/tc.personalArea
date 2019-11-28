<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Question;
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
            'phone_number' => 'required',
            'text' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors()->first());
        }

        Question::create([
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'text' => $request->input('text')
        ]);

        return $this->sendResponse([], 'Stored');
    }

    public function test()
    {
        $now = time();

        $reservations = Reservation::where('accepted', '=', '0')->get();
        foreach($reservations as $reservation)
        {
            $expire_at = strtotime($reservation->expires_at);
            $diff =(int) $expire_at - $now;
            return 'now: ' . $now . ' exp: ' . $expire_at . ' diff: ' . $diff;
            if($diff <= 0)
            {
                Reservation::where('id', '=', $reservation->id)->update([
                    'expire' => 1
                ]);
            }
        }
    }
}
