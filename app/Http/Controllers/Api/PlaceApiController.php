<?php

namespace App\Http\Controllers\Api;

use App\Models\Place;
use Illuminate\Http\JsonResponse;

/**
 * Представляет контпроллеп для обработки api запросов, связаных с сущностью место.
 *
 * @package App\Http\Controllers\Api
 */
class PlaceApiController extends ApiBaseController
{
    /**
     * Обрабатывает запрос на получение всех мест.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse(
            Place::select('id', 'block', 'floor', 'row', 'place_number', 'status', 'price')
                ->get()->toArray(),
            'Places retrieved successfully.'
        );
    }

    /**
     * Обрабатывает запрос на получение всех мест в блоке.
     *
     * @param string $block
     * @return JsonResponse
     */
    public function show(string $block): JsonResponse
    {
        return $this->sendResponse(
            Place::select('id', 'block', 'floor', 'row', 'place_number', 'status', 'price')
                ->where('block', '=', $block)->get()->toArray(),
            "Places in block \"$block\" retrieved successfully.");
    }

    public function showPlacesInBlockWithStatus(string $block, string $status)
    {
        return $this->sendResponse(
            Place::select('id', 'block', 'floor', 'row', 'place_number', 'status', 'price')
                ->where('block', '=', $block)
                ->where('status', '=', $status)->get()->toArray(),
            "Places in block \"$block\", with status $status retrieved successfully.");
    }
}
