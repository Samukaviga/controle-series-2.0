<?php

namespace App\Http\Controllers\Api;

use App\Models\Series;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
   
    public function __construct(private SeriesRepository $seriesRepository) {
        
    }

    public function index(Request $request)
    {
        
        $query = Series::query(); //retorna um objeto que pode ser usado para add condicoes, ordenar, limitar, etc.

        if($request->has('nome')){
            return $query->where('nome', 'like', "%$request->nome%")->get();    
        }

        return $query->paginate(5);
  
    }


    public function store(SeriesFormRequest $request)
    {
        return response()->json($this->seriesRepository->add($request), 201);
    }

    public function show(int $id)
    {

       $serie = Series::with('seasons.episodes')->where('id', $id)->first();

        if(!$serie) {

            return response()->json(["message" => "series not found"], 404);
       
        }
  
        return $serie;


        //$series = Series::with('seasons')->get();
        // $serie = Series::find($request->id);
        //return response()->json($serie, 200); 
        
    }

    public function update(Series $series, Request $request) 
    {

        $series->fill($request->all());
        $series->save();

        return $series;

        //Series::where(‘id’, $series)->update($request->all());

    }

    public function destroy(Series $series) 
    {

        $series->delete();

        return response()->noContent(); //retorna uma resposta vazia com o status 204
    }

    public function findSeasons(int $series)
    {


        $serieCreated = Series::find($series);

        if(!$serieCreated){
            return response()->json(["mensage" => "seasons not found"], 404);
        }

        return $serieCreated->seasons;



    }

    public function findEpisodes(int $series) 
    {
        $serieCreated = Series::find($series);


        if(!$series){
            return response()->json(["mensage" => "episodes not found"], 404);
        }

        return $serieCreated->episodes;
    }

}
