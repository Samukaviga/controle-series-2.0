<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SeriesCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public string $nomeSerie,
        public int $idSerie,
        public int $qtdTemporadas,
        public int $episodiosPorTemporada,
    )
    {
        $this->subject = "Série $nomeSerie criada"; //assunto do email
    }

    /**
     * Build the message.
     *
     * @return $this
     */

     //metodo responsavel por construir o email
    public function build()
    {
        return $this->markdown('mail.series-created'); //markdow tras algumas facilidades em questao de exibicao
    }
}
