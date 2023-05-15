<?php


namespace App\Mail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompraRealizada extends Mailable
{
    use Queueable, SerializesModels;

    public $precio;
    public $cantidad;
    public $nombre;
    public $apellido;
    public $producto;
    public $foto;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($precio, $cantidad, $nombre, $apellido, $producto, $foto)
    {
        $this->precio = $precio;
        $this->cantidad = $cantidad;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->producto = $producto;
        $this->foto = $foto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.compra_realizada')
            ->with('precio', $this->precio)
            ->with('cantidad', $this->cantidad)
            ->with('nombre',$this->nombre)
            ->with('apellido',$this->apellido)
            ->with('producto', $this->producto)
            ->with('foto', $this->foto);
    }
}
