<?php

namespace App\Http\Controllers\Api;

use App\Models\Series;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
   
    public function __construct(private SeriesRepository $seriesRepository) {
        
    }

    public function watched(Episode $episode, Request $request)
    {   

        $episode->watched = $request->watched;
        $episode->save();

        return $episode;
        
    }


}
