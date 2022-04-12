<?php
namespace App\Service;

use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseService
{
    public function created($data=[], $message='successful',  $statusCode=Response::HTTP_CREATED)
    {
        return response()->json([
            "status" => "success",
            "status_code" => $statusCode,
            "message" => $message,
            "data" => $data,
        ],$statusCode);
    }

    public function successWithData($data=[], $message='successful',  $statusCode=Response::HTTP_OK)
    {
        return response()->json([
            "status" => "success",
            "status_code" => $statusCode,
            "message" => $message,
            "data" => $data,
        ],$statusCode);
    }

    public function successWithBoolean($data, $message='successful',  $statusCode=Response::HTTP_OK)
    {
        return response()->json([
            "data" => $data,
            "status" => "success",
            "status_code" => $statusCode,
            "message" => $message,
        ],$statusCode);
    }

    public function success($message='',  $statusCode=Response::HTTP_OK)
    {
        return response()->json([
            "status" => "success",
            "status_code" => $statusCode,
            "message" => $message,
        ],$statusCode);
    }

    public function failure($message='', $statusCode=Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            "status" => "failure",
            "status_code" => $statusCode,
            "message" => $message,
        ],$statusCode );
    }

    public function exceptionFailure($th, $message='something went wrong. try again !!!', $statusCode=Response::HTTP_BAD_REQUEST)
    {
        Log::error($th->getMessage());
        Log::error($th->getFile());
        Log::error($th->getLine());
        return response()->json([
            "status" => "failure",
            "status_code" => $statusCode,
            "message" => $message,
        ],$statusCode );
    }
}
