<?php


namespace App\Http\Controllers;

use App\Http\Controllers\IndexController;
use App\Models\Categorias;
use App\Models\Clientes;
use App\Models\Colores;
use App\Models\Estado_Producto;
use App\Models\Fotos;
use App\Models\Fotos_Banner;
use App\Models\Fotos_Categoria;
use App\Models\Fotos_Producto;
use App\Models\Negocio;
use App\Models\Ofertas;
use App\Models\Productos;
use App\Models\Provincias;
use App\Models\User;
use App\Models\Usuarios_negocio;
use App\Models\Ventas;
use App\Models\Ventas_producto;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
Use Auth;
use Mail;

class VendedoresController extends Controller
{
    protected $otroController;

    public function __construct(IndexController $otroController)
    {
        $this->otroController = $otroController;
    }
    public function verProductosVendedor(){
        $productos = Productos::select('productos.*')->where('user_id', Auth::user()->id)->where('estado', 1)->get();
        foreach ($productos as $pro) {
            $fechaDeLanzamiento = new Carbon($pro->fecha_fin);
            $now = Carbon::now();

            $difference = ($fechaDeLanzamiento->diff($now)->days < 1)
                ? 1
                : $fechaDeLanzamiento->diffInDays($now);

            $pro->fechaLanzamiento = $difference;

            $nomCat = Categorias::select('nombre')->where('id', $pro['categoria_id'])->get()->toArray();
            if ($nomCat != []) {
                $pro->nomCat = $nomCat[0]['nombre'];
            }
            $fotos = Fotos_Producto::where('producto_id', $pro->id)->get()->toArray();
            $pro->path = '';
            if($fotos != []) {
                $pro->path = $fotos[0]['path'];
            }
        }
        $categorias = Categorias::all();

        return Inertia::render('Vendedor/verProductosVendedor', ['productos' => $productos, 'categorias' => $categorias]);

    }
    public function verCrearProducto(){

        $fotosBanner = Fotos_Banner::where('activo', 1)->get()->toArray();
        $categorias = Categorias::orderBy('nombre','ASC')->get();
        $estados = Estado_producto::all();
        $colores = Colores::orderBy('nombre','ASC')->get();
        $user = User::find(Auth::user()->id);

        return Inertia::render('Vendedor/crearProducto', ['categorias' => $categorias, 'fotosBanner' => $fotosBanner, 'estados' => $estados, 'colores' => $colores, 'user' => $user]);

    }


    public function verOfertas($id){
        if (Auth::user() != null) {
            $admin = Auth::user()->es_admin;
            $producto = Productos::find($id);
            if ($producto->user_id == Auth::user()->id || Auth::user()->es_admin) {
                $ofertas = Ofertas::select('ofertas.*', 'clientes.nombre', 'clientes.apellido', 'clientes.email','clientes.numero')
                    ->leftJoin('clientes', 'clientes.id', 'ofertas.cliente_id')
                    ->where('producto_id', $id)->get();

                if (Auth::user() != null && $admin) {
                    return Inertia::render('Vendedor/verOfertas', ['producto' => $producto, 'ofertas' => $ofertas, 'admin' => $admin]);
                }
                $categorias = Categorias::all()->where('padre_id', null);
                foreach ($categorias as $cate) {
                    $cateHijo = Categorias::where('padre_id', $cate->id)->get()->toArray();
                    if ($cateHijo != []) {
                        $cate->hijos = $cateHijo;
                    }
                    $fotos = Fotos_categoria::where('categoria_id', $cate->id)->get()->toArray();
                    $cate->path = '';
                    if ($fotos != []) {
                        $cate->path = $fotos[0]['path'];
                    }
                }
                $fotosBanner = Fotos_banner::where('activo', 1)->get()->toArray();
                return Inertia::render('Vendedor/verOfertasDueno', ['producto' => $producto, 'ofertas' => $ofertas, 'categorias' => $categorias, 'fotosBanner' => $fotosBanner]);
            }
        }
    }
    public function guardarOferta(Request $request){
        $cliente = Clientes::select('clientes.*')->where('email', $request->mail)->get()->toArray();
        if ($cliente == []){
            $cli = new Clientes;
            $cli->nombre = $request->nombre;
            $cli->apellido = $request->apellido;
            $cli->email = $request->mail;
            $cli->celular = $request->celular;
            $cli->save();
            $cliId = $cli->id;
        }
        else{
            $cliId = $cliente[0]['id'];
        }

        $oferta = new Ofertas;
        $oferta->cliente_id = $cliId;
        $oferta->producto_id = $request->producto_id;
        $oferta->provincia_id = $request->provincia_id;
        $oferta->precio = $request->precio;
        $oferta->cantidad = $request->cant;
        $oferta->save();


        $this->enviarMailOferta($request);

        return back();
    }
    public function enviarMailOferta($request){
        $destinatario = $request->mail;
        $precio = $request->precio;
        $cantidad = $request->cant;
        $nombre = $request->nombre;
        $apellido = $request->apellido;
        $producto = $request->celular;

        $fotos = Fotos_Producto::where('producto_id', $request->producto_id)->get()->toArray();
        $foto = '';
        if($fotos != []) {
            $foto = $fotos[0]['path'];
        }
        Mail::to($destinatario)->send(new \App\Mail\CompraRealizada($precio, $cantidad, $nombre, $apellido, $producto, $foto));

        return response()->json(['mensaje' => 'Correo enviado']);
    }
    public function aceptarOferta($id){
        $ofe = Ofertas::find($id);
        if ($ofe->estado == 0) {
            $ofe->estado = 1;
            $ofe->save();
        }
        return back();
    }
    public function rechazarOferta($id){
        $ofe = Ofertas::find($id);
        if ($ofe->estado == 0) {
            $ofe->estado = 2;
            $ofe->save();
        }
        return back();
    }

    public function borrarVendedor($id)
    {
        if (Auth::user()->es_admin) {
            $productos = Productos::select('id')->where('user_id', $id)->get();
            foreach ($productos as $prod) {
                $prod->delete();
                $ofertas = Ofertas::where('producto_id', $prod->id)->get();
                foreach ($ofertas as $ofe) {
                    $ofe->delete();
                }
                $ventasPro = Ventas_producto::where('producto_id', $prod->id)->get();
                foreach ($ventasPro as $vp) {
                    $vp->delete();
                }
            }
            return redirect()->back()->with('success', 'Saved!');
        }
    }
    public function comprarProducto(Request $request){
        $cliente = Clientes::select('clientes.*')->where('email', $request->mail)->get()->toArray();
        if ($cliente == []){
            $cli = new Clientes;
            $cli->nombre = $request->nombre;
            $cli->apellido = $request->apellido;
            $cli->email = $request->mail;
            $cli->numero = $request->celular;
            $cli->save();
            $cliId = $cli->id;
        }
        else{
            $cliId = $cliente[0]['id'];
        }

        $oferta = new Ofertas;
        $oferta->cliente_id = $cliId;
        $oferta->producto_id = $request->producto_id;
        $oferta->estado = 0;
        $oferta->save();

        return back();
    }
}
