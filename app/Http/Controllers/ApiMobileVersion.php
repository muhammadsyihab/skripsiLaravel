<?php

namespace App\Http\Controllers;

use App\Models\MobileVersion;
use Illuminate\Http\Request;

class ApiMobileVersion extends Controller
{
    public function getVersion()
    {
        $version = MobileVersion::first();
        return response()->json([
            'code' => 200,
            'messages' => 'Logged',
            'data' => $version,
        ]);
    }   
}
