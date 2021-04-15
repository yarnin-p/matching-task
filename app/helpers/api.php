<?php

/**
 * @param int $statusCode
 * @param int $responseCode
 * @param string $message
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
function responseSuccess($statusCode = 200, $responseCode = 200, $message = 'Successfully', $data = [])
{
    return response()->json([
        'success' => true,
        'code' => $responseCode,
        'message' => $message,
        'data' => $data
    ], $statusCode);
}


/**
 * @param int $statusCode
 * @param int $responseCode
 * @param string $message
 * @param array $data
 * @return \Illuminate\Http\JsonResponse
 */
function responseError($statusCode = 500, $responseCode = 500, $message = 'Error', $data = [])
{
    return response()->json([
        'success' => false,
        'code' => $responseCode,
        'message' => $message,
        'data' => $data
    ], $statusCode);
}
