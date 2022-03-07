<?php

namespace App\Listeners;

use App\Events\ScheduleCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendRoomToStep
{
    public function handle(ScheduleCreated $event)
    {
        $token = env('STEP_TOKEN');
        $response = Http::withToken($token)
            ->accept('application/json')
            ->post('http://127.0.0.1:8080/api/rooms', $event->room);
    }
}
