<?php

namespace App\Http\Controllers\Api;

use App\Models\Series;
use App\Http\Controllers\Controller;


class SeriesController extends Controller
{
   

    public function index()
    {

        return Series::all();
    }

}
