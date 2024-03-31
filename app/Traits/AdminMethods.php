<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AdminMethods
{
    public function view($path, $obj = [])
    {
        $user = Auth::user();
        $dir = "admin.";
        return view($dir.$path, array_merge($obj, [
            'admin' => $user
        ]));
    }

    public function sendError($errorMessage)
    {
        return response()->json(['error' => $errorMessage]);
    }

    public function successMsgAndRedirect($msg, $redirectRoute)
    {
        return response()->json(['msg' => $msg, 'redirectRoute' => route($redirectRoute)]);
    }
}