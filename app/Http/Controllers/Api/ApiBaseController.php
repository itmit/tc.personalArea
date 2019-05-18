<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse as JsonResponseAlias;

/**
 * Представляет базовый класс для api контроллеров.
 *
 * @package App\Http\Controllers\Api
 */
abstract class ApiBaseController extends Controller
{

    /**
     *
     *
     * @param $result
     * @param $message
     * @return JsonResponseAlias
     */
    public function sendResponse($result, $message)
    {
        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => $message,
        ], 200);
    }

    /**
     *
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponseAlias
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
