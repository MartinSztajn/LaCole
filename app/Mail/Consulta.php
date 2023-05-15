<?php


namespace App\Mail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Consulta extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre, $apellido, $mensaje, $enviado;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre, $apellido, $mensaje, $enviado)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->mensaje = $mensaje;
        $this->enviado = $enviado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.enviar_consulta')
            ->with('nombre',$this->nombre)
            ->with('apellido',$this->apellido)
            ->with('mensaje', $this->mensaje)
            ->with('enviado', $this->enviado);
    }
}
