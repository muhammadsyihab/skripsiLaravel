<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\ServiceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendServiceNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Log::alert($event->notif);

        $users = User::where('role', 1)->orWhere('role', 2)->get();
        foreach ($users as $user) {
            Notification::create([
                'users_id' => $user->id,
                'judul' => 'Service',
                'isi' => $event->notif,
                'priority' => 1,
            ]);
        }
        

    }
}
