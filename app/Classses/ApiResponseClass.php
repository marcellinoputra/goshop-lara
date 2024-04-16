<?php

namespace App\Classses;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{
    public static function rollback($e, $message = 'Something Went Wrong! Process not Completed')
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $message = 'Something Went Wrong! Process not Completed')
    {
        Log::info($e);
        throw new HttpResponseException(response()->json([
            "message" => $message
        ]));
    }

    public static function sendResponseWithData($result, $message, $status)
    {
        $response = [
            "status" => $status,
            'data' => $result,
            'success' => true
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $status);
    }

    public static function sendResponseOnlyMessage($message, $status)
    {
        $response = [
            'status' => $status,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $status);
    }
}
