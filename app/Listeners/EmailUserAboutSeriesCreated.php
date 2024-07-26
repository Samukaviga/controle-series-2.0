<?php

namespace App\Listeners;

use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Models\User;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailUserAboutSeriesCreated
{
  
    public function __construct()
    {
        //
    }

    
    public function handle(App\Events\SeriesCreated $event) //esse evento vai ter acesso a todas as propiedades
    {
        $UserList = User::all();
        
        
        foreach($UserList as $index => $user){
    
            $email = new SeriesCreated(
                $event->seriesName,
                $event->$seriesId,
                $event->seasonsQty,
                $event->episodesPerSeason,
            );
    
            $when = now()->addSeconds($index * 10);
    
            Mail::to($user)->later($when, $email); //ao inves de send vamos queue. Adicionando QUEUE_CONNECTION=database, o queue vai adicionar o email em uma fila para enviar
          //  sleep(3);                         //esta enviado para tabela jobs do banco de dados, agora é necessario processar esses dados para que seja enviado para o email
        }
    }
}
