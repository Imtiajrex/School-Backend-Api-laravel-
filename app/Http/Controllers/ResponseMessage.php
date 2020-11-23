<?php

namespace App\Http\Controllers;

class ResponseMessage
{
    public static function fail(string $message)
    {
        return response()->json(["msg" => $message, "success" => false]);
    }

    public static function success(string $message)
    {
        return response()->json(["msg" => $message, "success" => true]);
    }

    public static function unauthorized(string $permission)
    {
        return response()->json(["msg" => "Unauthorized!", "error" => "User Doesn't Have Permission To " . $permission, "success" => false]);
    }
}
