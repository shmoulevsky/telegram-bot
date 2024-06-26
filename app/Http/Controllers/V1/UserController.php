<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{

    public function show(Request $request)
    {
        $userId = Auth::id();
        return $userId;
    }
}
