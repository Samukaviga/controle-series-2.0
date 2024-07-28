<?php

namespace App\Http\Controllers;

use App\Models\User;


use App\Models\Series;
use Illuminate\Http\Request;
use App\Jobs\SerieCreatedJob;
use App\Events\SeriesCreatedEvent;
use App\Jobs\ImageDeleteSeriesJob;
use Illuminate\Support\Facades\Auth;
use App\Events\DeleteImageSerieEvent;
use App\Repositories\SeriesRepository;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SeriesFormRequest;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Request $request)
    {
        $series = Series::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index')->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    { 

            $coverPath = $request->hasFile('cover') ? $request->file('cover')->store('series_cover', 'public') : $coverPath = null; //armazena em um lugar permanente. O Laravel cria uma pasta com o nome 'series_cover' e retorna o caminho salvo e salva em public (config/filesystems)
        
            $request->coverPath = $coverPath;
        
      
        $serie = $this->repository->add($request);
        
        SerieCreatedJob::dispatch($serie->nome);  //teste JOB. Nao precisa de  Event e nem Listener 
        
      /*
        SeriesCreatedEvent::dispatch( //chama o evento SeriesCreatedEvent, avisando que a serie foi criada e enviando os paramentros. Assim pode executar outras tarefas fora do controller.
            $serie->nome,
            $serie->id,
            $request->seasonsQty,
            $request->episodesPerSeason

        ); */
        
        

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
    }

    public function destroy(Series $series)
    {

        //DeleteImageSerieEvent::dispatch($series->id); //excluindo imagem local

        $series->cover ? ImageDeleteSeriesJob::dispatch($series->cover) : null; //excluindo imagem local, asyc

        $series->delete();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");
    }

    public function edit(Series $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");
    }
}
