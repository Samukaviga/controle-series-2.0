<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Storage;

use App\Models\Series;
use App\Events\DeleteImageSerieEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImageUserAboutSeriesDelete
{

    public function __construct()
    {
        //
    }

  
    public function handle(DeleteImageSerieEvent $event)
    {
        $serieId = $event->serieId;
    
        $serie = Series::find($serieId);

        Storage::disk('public')->delete($serie->cover);
    } 


}
