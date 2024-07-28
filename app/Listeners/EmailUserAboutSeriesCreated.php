<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Series;
use App\Mail\SeriesCreated;
use App\Events\SeriesCreatedEvent;


use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailUserAboutSeriesCreated implements ShouldQueue
{
  
    public function __construct()
    {
        //  
    }

                                            
    public function handle(SeriesCreatedEvent $event) //esse evento vai ter acesso a todas as propiedades
    {
        $UserList = User::all();
        
        
        foreach($UserList as $index => $user){
    
            $email = new SeriesCreated(
                $event->seriesName,
                $event->seriesId,
                $event->seasonsQty,
                $event->episodesPerSeason,
            );
    
            $when = now()->addSeconds($index * 10);
    
            Mail::to($user)->later($when, $email); //ao inves de send vamos queue. Adicionando QUEUE_CONNECTION=database, o queue vai adicionar o email em uma fila para enviar
          //  sleep(3);                         //esta enviado para tabela jobs do banco de dados, agora é necessario processar esses dados para que seja enviado para o email
        }
    }
}
