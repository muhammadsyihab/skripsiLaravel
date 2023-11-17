<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function notifications() {
        $tickets = Notification::with('user')
        ->where('users_id', auth()->user()->id)
        ->whereMonth('created_at', now()->format('m'))
        ->whereYear('created_at', now()->format('Y'))
        ->get();
        
        if (!empty($tickets)) {
            return response()->json([
                'code' => 200,
                'message' => 'success',
                'datas' =>  NotificationResource::collection($tickets),
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'failed',
        ])->setStatusCode(400);
    }
}
