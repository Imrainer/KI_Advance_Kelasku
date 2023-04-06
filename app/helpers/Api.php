<?php

namespace App\Helpers;

class Api
{

protected static $response = [
    'status' => null,
    'message' => null,
    'data' => null,
    // 'token' => null
];

public static function createApi($status = 
null, $message = null, $data = null) {
    self::$response['status']=$status;;
    self::$response['message'] = $message;
    self::$response['data'] = $data;
    // self::$response['token'] = $token;

    return response()->json(self::$response,
    self::$response['status']);
}


}


?>