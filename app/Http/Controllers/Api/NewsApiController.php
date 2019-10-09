<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;

class NewsApiController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
            return $this->sendResponse(
                News::all()->toArray()->sortByDesc('created_at'),
                'News retrieved successfully.'
        );
    }

    public function getHourlyNews()
    {
        return $this->sendResponse(
            News::where('created_at', '>=', Carbon::now()->subHour())->get()->toArray(),
            'Hourly news retrieved successfully.'
        );
    }
}
