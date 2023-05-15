<?php


namespace App\Http\Controllers;


use App\Models\Categorias;
use App\Models\Estado_producto;
use App\Models\Fotos_Producto;
use App\Models\Fotos_banner;
use App\Models\Fotos_categoria;

use App\Models\Ofertas;
use App\Models\Precios;
use App\Models\Productos;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
Use Auth;

class IndexController extends Controller
{

    public function buscar(Request $request){
        $buscador = $request['text'];
        $productos = [];
        if ($buscador != '') {
            $productos = Productos::where('nombre', 'like', '%' . $buscador . '%')->where('estado', 1)->get();
            foreach ($productos as $pro) {
                $ofertas = Ofertas::where('producto_id', $pro->id)->get()->toArray();
                $pro->cantOfertas = (count($ofertas));
                $nomCat = Categorias::select('nombre')->where('id', $pro['categoria_id'])->get()->toArray();
                $nomEstado = Estado_producto::select('nombre')->where('id', $pro['estado_id'])->get()->toArray();
                if ($nomEstado != []) {
                    $pro->nomEstado = $nomEstado[0]['nombre'];
                }
                if ($nomCat != []) {
                    $pro->nomCat = $nomCat[0]['nombre'];
                }
                $fotos = Fotos::where('producto_id', $pro->id)->get()->toArray();
                $pro->path = '';
                if ($fotos != []) {
                    $pro->path = $fotos[0]['path'];
                }
            }
        }
        $categorias = Categorias::all()->where('padre_id',null);
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

        return Inertia::render('Productos/verProductosBuscar', ['productos' => $productos,'categorias' => $categorias, 'fotosBanner' => $fotosBanner]);
    }
    public function inicio(){
        if (Auth::user() != null && Auth::user()->es_admin){
            $usuarios = User::all()->toArray();
            $cantidad = count($usuarios);
            return Inertia::render('Usuarios/Index', ['Usuarios' => $usuarios, 'cant' => $cantidad]);
        }
        if (Auth::user() != null && !Auth::user()->es_admin){
            $fotosBanner = Fotos_banner::where('activo', 1)->get()->toArray();
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
            return Inertia::render('Negocio/verNegocioDueno', ['categorias' => $categorias, 'fotosBanner' => $fotosBanner]);
        }

        $productos = Productos::all()->where('estado', 1);
        foreach ($productos as $pro) {
            $now = Carbon::now();
            $fechaDeLanzamiento = new Carbon($pro->created_at);
            $difference = ($fechaDeLanzamiento->diff($now)->days < 3)
                ? 1
                : 0;
            $pro->esNovedad = $difference;

            $ofertas = Ofertas::where('producto_id', $pro->id)->get()->toArray();
            $pro->cantOfertas = (count($ofertas));

            $nomCat = Categorias::select('nombre')->where('id', $pro['categoria_id'])->get()->toArray();
            if ($nomCat != []) {
                $pro->nomCat = $nomCat[0]['nombre'];
            }
            $nomEstado = Estado_producto::select('nombre')->where('id', $pro['estado_id'])->get()->toArray();
            if ($nomEstado != []) {
                $pro->nomEstado = $nomEstado[0]['nombre'];
            }
            $fotos = Fotos_Producto::where('producto_id', $pro->id)->get()->toArray();
            $pro->path = '';
            if ($fotos != []) {
                $pro->path = $fotos[0]['path'];
            }
        }

        $cateTotales = Categorias::select('categorias.*')->where('padre_id', null)->get();
        foreach ($cateTotales as $cate) {
            $fotos = Fotos_categoria::where('categoria_id', $cate->id)->get()->toArray();
            $cate->path = '';
            $cate->hijos = 0;
            if ($fotos != []) {
                $cate->path = $fotos[0]['path'];
            }
            $catePrueba = Categorias::select('categorias.*')->where('padre_id', $cate->id)->get()->toArray();
            if($catePrueba != []){
                $cate->hijos = 1;
            }
        }

        $categorias = Categorias::all()->where('padre_id',null);
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

        $nove = $productos->where('esNovedad', 1)->toArray();
        $ofe = $productos->where('esOferta', 1)->toArray();
        $novedades = []; $ofertas = []; $i = 0;
        foreach ($nove as $nov){
            $novedades[$i] = $nov;
            $i++;
        }
        $i = 0;
        foreach ($ofe as $of){
            $ofertas[$i] = $of;
            $i++;
        }

        $fotosBanner = Fotos_banner::where('activo', 1)->get()->toArray();

        $admin = 0;
        if(Auth::check()){
            $admin = Auth::user()->es_admin;
        }

        return Inertia::render('Inicio/Index', ['productos' => $productos, 'categorias' => $categorias, 'novedades' => $novedades, 'ofertas' => $ofertas, 'fotosBanner' => $fotosBanner, 'admin' => $admin, 'cateTotales' => $cateTotales]);
    }
    public function verPagina(){
        $productos = Productos::all()->where('estado', 1);
        foreach ($productos as $pro) {
            $now = Carbon::now();
            $fechaDeLanzamiento = new Carbon($pro->created_at);
            $difference = ($fechaDeLanzamiento->diff($now)->days < 3)
                ? 1
                : 0;
            $pro->esNovedad = $difference;

            $ofertas = Ofertas::where('producto_id', $pro->id)->get()->toArray();
            $pro->cantOfertas = (count($ofertas));

            $nomCat = Categorias::select('nombre')->where('id', $pro['categoria_id'])->get()->toArray();
            if ($nomCat != []) {
                $pro->nomCat = $nomCat[0]['nombre'];
            }
            $fotos = Fotos_Producto::where('producto_id', $pro->id)->get()->toArray();
            $pro->path = '';
            if ($fotos != []) {
                $pro->path = $fotos[0]['path'];
            }
            $nomEstado = Estado_producto::select('nombre')->where('id', $pro['estado_id'])->get()->toArray();
            if ($nomEstado != []) {
                $pro->nomEstado = $nomEstado[0]['nombre'];
            }
        }
        $cateTotales = Categorias::select('categorias.*')->where('padre_id', null)->get();
        foreach ($cateTotales as $cate) {
            $fotos = Fotos_categoria::where('categoria_id', $cate->id)->get()->toArray();
            $cate->path = '';
            $cate->hijos = 0;
            if ($fotos != []) {
                $cate->path = $fotos[0]['path'];
            }
            $catePrueba = Categorias::select('categorias.*')->where('padre_id', $cate->id)->get()->toArray();
            if($catePrueba != []){
                $cate->hijos = 1;
            }
          }


        $categorias = Categorias::all()->where('padre_id',null);

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

        $nove = $productos->where('esNovedad', 1)->toArray();
        $ofe = $productos->where('esOferta', 1)->toArray();
        $novedades = []; $ofertas = []; $i = 0;
        foreach ($nove as $nov){
            $novedades[$i] = $nov;
            $i++;
        }
        $i = 0;
        foreach ($ofe as $of){
            $ofertas[$i] = $of;
            $i++;
        }

        $fotosBanner = Fotos_banner::where('activo', 1)->get()->toArray();

        $admin = 0;
        if(Auth::check()){
            $admin = Auth::user()->es_admin;
        }
        $this->actualizarPrecios();

        return Inertia::render('Inicio/Index', ['productos' => $productos, 'categorias' => $categorias, 'novedades' => $novedades, 'ofertas' => $ofertas, 'fotosBanner' => $fotosBanner, 'admin' => $admin, 'cateTotales' => $cateTotales,]);
    }


    public function enviarConsulta(){
        $categorias = Categorias::all()->where('padre_id',null);
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

        return Inertia::render('Inicio/consultas', ['categorias' => $categorias, 'fotosBanner' => $fotosBanner]);
    }

    public function enviarMensajeConsulta(Request $request){
        $destinatario = "admin@wop.com.ar";
        $nombre = $request->nombre;
        $apellido = $request->apellido;
        $mensaje = $request->mensaje;
        $enviado = $request->mail;

        Mail::to($destinatario)->send(new \App\Mail\Consulta($nombre, $apellido, $mensaje, $enviado));

        return back();
    }

    public function actualizarPrecios(){
        $fecha_actual = \Carbon\Carbon::now();

        $precios = Precios::all();
        foreach ($precios as $pre){
            $fecha_creacion  = $pre->created_at;
            $diferencia_dias = $fecha_actual->diffInDays($fecha_creacion);
            $pre->dias_restantes = $pre->dias - $diferencia_dias;

            if ($pre->dias_restantes == 0){
                $pre->created_at = $fecha_actual;
                $pre->veces =$pre->veces + 1;
                $pre->dias_restantes = $pre->dias;

                $producto = Productos::find($pre->producto_id);
                $aumento = $producto->precio_max * $pre->porcentaje / 100;
                $producto->precio_max =  $producto->precio_max + $aumento;
                $producto->save();
            }
            $pre->save();
        }
        return back();
    }
}

