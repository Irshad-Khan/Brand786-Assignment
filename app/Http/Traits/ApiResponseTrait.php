<?php


namespace App\Http\Traits;


use Illuminate\Http\JsonResponse;
use stdClass;

trait ApiResponseTrait
{
    /**
     * @param $status
     * @param null $message
     * @param null $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function responseWithSuccess($message=null, $data=null, $statusCode=200)
    {
        return response()->json(
            [
                'error' => false,
                'message' => $message,
                'data' => $data ?: new stdClass
            ], $statusCode
        );
    }

    /**
     * @param $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function responseWithError($message, $statusCode=200)
    {
        return response()->json(
            [
                'error' => false,
                'message' => $message,
                'data' => (new stdClass)
            ], $statusCode
        );
    }
}
