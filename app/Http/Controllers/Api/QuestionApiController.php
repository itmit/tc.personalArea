<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
            return $this->sendError($validator->errors(), "Validation error", 401);
        }

        Question::create([
            'name' => $request->input('name'),
            'phone_number' => $request->input('phone_number'),
            'text' => $request->input('text')
        ]);

        return $this->sendResponse([], 'Stored');
    }
}
