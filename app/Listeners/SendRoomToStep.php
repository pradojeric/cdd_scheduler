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
        $token = config('step.step.token');
        $url = config('step.step.url');
        $response = Http::withToken($token)
            ->accept('application/json')
            ->post($url.'/api/rooms', $event->room);
    }
}
