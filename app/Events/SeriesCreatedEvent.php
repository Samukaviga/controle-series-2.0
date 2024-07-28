<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SeriesCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

  
    public function __construct(
        public readonly string $seriesName, //apenas para leitura
        public readonly int $seriesId,
        public readonly int $seasonsQty,
        public readonly int $episodesPerSeason,
    )
    {
        //
    }

   
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
