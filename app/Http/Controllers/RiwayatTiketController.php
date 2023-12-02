<?php

namespace App\Http\Controllers;

use App\Events\HistoryChat;
use App\Models\RiwayatTiket;
use Illuminate\Http\Request;

class RiwayatTiketController extends Controller
{
    public function store(Request $request) {
        $message = RiwayatTiket::create($request->all());
        // HistoryChat::dispatch($message);
        broadcast(new HistoryChat($message))->toOthers();
        return $message;
    }
}
