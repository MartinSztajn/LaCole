<?php


namespace App\Http\Controllers;


use App\Mail\Consulta;
use App\Models\Categorias;
use App\Models\Clientes;
use App\Models\Colores;
use App\Models\Consultas;
use App\Models\Estado_producto;
use App\Models\Fotos_Producto;
use App\Models\Fotos_banner;
use App\Models\Fotos_categoria;
use Illuminate\Support\Facades\App;
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
use function Ramsey\Collection\add;
use function Termwind\ValueObjects\getLength;


class IndexController extends Controller
{
    public function buscar(Request $request)
    {
        $texto = $request->input('text');
        $productos = Productos::where('nombre', 'like', '%' . $texto . '%')->take(5)->get();
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
            $fotos = Fotos_Producto::where('producto_id', $pro->id)->get()->toArray();
            $pro->path = '';
            if ($fotos != []) {
                $pro->path = $fotos[0]['path'];
            }
        }
        return response()->json($productos);
    }
    public function buscarCategorias(){
        $categorias = Categorias::all();
        foreach ($categorias as $cate){
            $fotos = Fotos_categoria::where('categoria_id', $cate->id)->get()->toArray();
            $cate->path = '';
            if ($fotos != []) {
                $cate->path = $fotos[0]['path'];
            }
        }

        return response()->json($categorias);

    }
    public function buscarBanner(){
        $banner = Fotos_banner::all();
        return response()->json($banner);
    }
    public function buscarColores(){
        $colores = Colores::all();
        return $colores;
    }
    public function buscarCantOfetasTotal(){
        $cant = 0;
        $productos = Productos::where('user_id', Auth::user()->id)->get();
        foreach ($productos as $pro) {
            $cant = $cant + sizeof(Ofertas::where('producto_id', $pro->id)->where('estado',0)->get());
        }
        return $cant;
    }
    public function buscarCategoriasHijos(){
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

        return response()->json($categorias);

    }
    public function filtrar(Request $request){
        $productos = Productos::where('estado', 1);

        if($request['categorias'] != null)
        {
            $categorias = str_replace('-',' ',$request['categorias']);
            $categorias = explode(',',$categorias);
            $filtrosCate = [];
            foreach ($categorias as $cate){
                $id =  Categorias::select('id')->where('nombre', $cate)->get()->toArray()[0]['id'];
                array_push($filtrosCate, $id);
            }
            $productos = $productos->whereIn('categoria_id', $filtrosCate);
        }
        if($request['colores'] != null)
        {
            $colores = str_replace('-',' ',$request['colores']);
            $colores = explode(',',$colores);
            $filtrosCol = [];
            foreach ($colores as $col){
                $id =  Colores::select('id')->where('nombre', $col)->get()->toArray()[0]['id'];
                array_push($filtrosCol, $id);
            }
            $productos = $productos->whereIn('color_id', $filtrosCol);
        }
        if($request['min'] != null)
        {
            $productos = $productos->where('precio', '>=' , $request['min']);
        }
        if($request['max'] != null)
        {
            $productos = $productos->where('precio', '<=' , $request['max']);
        }
        if($request['estado'] != null && $request['estado'] != 0)
        {
            $productos = $productos->where('estado_id', $request['estado']);
        }

        $cant = intval(sizeof($productos->get()) / 20);
        if(fmod($cant, 1) !== 0){
            $cant = $cant + 1;
        }

        if($request['pagina'] != null)
        {
            $productos =  $productos->skip($request['pagina'] * 20)->take(20);
        }
        else {
            $productos =  $productos->skip(0)->take(20);
        }

        $productos = $productos->get();
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
            $fotos = Fotos_Producto::where('producto_id', $pro->id)->get()->toArray();
            $pro->path = '';
            if ($fotos != []) {
                $pro->path = $fotos[0]['path'];
            }
        }

        return [
            'productos' => $productos,
             'cant' => $cant];
    }
    public function buscarTexto(Request $request){
        $productos = Productos::where('estado', 1);
        $buscador = $request['text'];
        $nombreCategoria = $request['categoria'];

        $color = $request['color'];
        if ($buscador != '') {
            $productos = $productos->where('nombre', 'like', '%' . $buscador . '%');
        }
        if ($buscador != '') {
            $productos = $productos->where('nombre', 'like', '%' . $buscador . '%');
        }
        if ($nombreCategoria != '') {
            $id = Categorias::select('categorias.*')->where('nombre', $nombreCategoria)->get()->toArray();
            if ($id != []) {
                $id = $id[0]['id'];
                $productos = $productos->where('categoria_id', $id);

            }
        }
        if ($color != '') {
            $productos = $productos->where('color_id', $color);
        }
        $cant = intval(sizeof($productos->get()) / 20);
        if(fmod($cant, 1) !== 0){
            $cant = $cant + 1;
        }
        $productos->skip(0)->take(20);
        $productos = $productos->get();


        foreach ($productos as $pro) {
            $nomCat = Categorias::select('nombre')->where('id', $pro['categoria_id'])->get()->toArray();
            $nomEstado = Estado_producto::select('nombre')->where('id', $pro['estado_id'])->get()->toArray();
            if ($nomEstado != []) {
                $pro->nomEstado = $nomEstado[0]['nombre'];
            }
            if ($nomCat != []) {
                $pro->nomCat = $nomCat[0]['nombre'];
            }
            $fotos = Fotos_Producto::where('producto_id', $pro->id)->get()->toArray();
            $pro->path = '';
            if ($fotos != []) {
                $pro->path = $fotos[0]['path'];
            }
        }
        $categorias = Categorias::all();
        foreach ($categorias as $cate){
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
        $colores = Colores::all();
        $estados = Estado_producto::all();
        return Inertia::render('Productos/verProductosBuscar', ['productos' => $productos,'categorias' => $categorias, 'fotosBanner' => $fotosBanner, 'colores' => $colores, 'estados' => $estados, 'cantPaginate' => $cant]);
    }
    public function inicio(){
        if (Auth::user() != null && Auth::user()->es_admin){
            $usuarios = User::all()->toArray();
            $cantidad = count($usuarios);
            return Inertia::render('Usuarios/Index', ['Usuarios' => $usuarios, 'cant' => $cantidad]);
        }
        if (Auth::user() != null && !Auth::user()->es_admin){
            $fotosBanner = Fotos_banner::where('activo', 1)->get()->toArray();

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
            $productos = Productos::select('productos.*')->where('user_id', Auth::user()->id)->where('estado', 1)->get();
            foreach ($productos as $pro) {
                $nomCat = Categorias::select('nombre')->where('id', $pro['categoria_id'])->get()->toArray();
                if ($nomCat != []) {
                    $pro->nomCat = $nomCat[0]['nombre'];
                }
                $fotos = Fotos_Producto::where('producto_id', $pro->id)->get()->toArray();
                $pro->path = '';
                if($fotos != []) {
                    $pro->path = $fotos[0]['path'];
                }
                $pro->cantOfertas = sizeof(Ofertas::where('producto_id', $pro->id)->where('estado',0)->get());
            }
            $categorias = Categorias::all();
            $estados = Estado_producto::all();
            $colores = Colores::all();
            $user = User::find(Auth::user()->id);
            return Inertia::render('Vendedor/verProductosVendedor', ['productos' => $productos, 'categorias' => $categorias, 'fotosBanner' => $fotosBanner, 'estados' => $estados, 'colores' => $colores, 'user' => $user]);
        }

        $novedades = Productos::where('estado', 1)->latest()->take(20)->get();

        $topProductIds = Ofertas::selectRaw('producto_id, COUNT(*) as count') ->groupBy('producto_id')->orderBy('count', 'desc')->take(20)->pluck('producto_id');
        $ofertados = Productos::whereIn('id', $topProductIds)->where('estado', 1)->get();
        $produCateEspecial = Productos::where('estado', 1)->where('categoria_id', 2)->latest()->take(20)->get();
        foreach ($produCateEspecial as $pro) {
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
        foreach ($novedades as $pro) {
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
        foreach ($ofertados as $pro) {
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


        $cateTotales = Categorias::select('categorias.*')->get();
        foreach ($cateTotales as $cate) {
            $fotos = Fotos_categoria::where('categoria_id', $cate->id)->get()->toArray();
            $cate->path = '';
            if ($fotos != []) {
                $cate->path = $fotos[0]['path'];
            }
        }
        $categorias = Categorias::all()->where('padre_id',null);
        foreach ($categorias as $cate) {
            $cate->zoomed = false;
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
        $colores = Colores::all();

        $this->actualizarPrecios();

        return Inertia::render('Inicio/Index', ['novedades' => $novedades, 'categorias' => $categorias, 'ofertados' => $ofertados, 'fotosBanner' => $fotosBanner,'cateTotales' => $cateTotales, 'colores' => $colores, 'produCateEspecial' => $produCateEspecial]);
    }
    public function verPagina(){
        $novedades = Productos::where('estado', 1)->latest()->take(20)->get();
        $topProductIds = Ofertas::selectRaw('producto_id, COUNT(*) as count') ->groupBy('producto_id')->orderBy('count', 'desc')->take(20)->pluck('producto_id');

        $ofertados = Productos::whereIn('id', $topProductIds)->get();
        $produCateEspecial = Productos::where('estado', 1)->where('categoria_id', 2)->latest()->take(20)->get();
        foreach ($produCateEspecial as $pro) {
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
        foreach ($novedades as $pro) {
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
        foreach ($ofertados as $pro) {
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


        $cateTotales = Categorias::select('categorias.*')->get();
        foreach ($cateTotales as $cate) {
            $fotos = Fotos_categoria::where('categoria_id', $cate->id)->get()->toArray();
            $cate->path = '';
            if ($fotos != []) {
                $cate->path = $fotos[0]['path'];
            }
          }
        $categorias = Categorias::all()->where('padre_id',null);
        foreach ($categorias as $cate) {
            $cate->zoomed = false;
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
        $colores = Colores::all();
        $this->actualizarPrecios();

        return Inertia::render('Inicio/Index', ['novedades' => $novedades, 'categorias' => $categorias, 'ofertados' => $ofertados, 'fotosBanner' => $fotosBanner,'cateTotales' => $cateTotales, 'colores' => $colores, 'produCateEspecial' => $produCateEspecial]);
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
    public function enviarPublicidad(){
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
        return Inertia::render('Inicio/hola', ['categorias' => $categorias, 'fotosBanner' => $fotosBanner]);
    }
    public function verPolitica(){
        $fotosBanner = Fotos_banner::where('activo', 1)->get()->toArray();
        return Inertia::render('Inicio/politica', ['fotosBanner' => $fotosBanner]);
    }

    public function enviarMensajeConsulta(Request $request){
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

        $consultas = new Consultas;
        $consultas->cliente_id = $cliId;
        $consultas->mensaje = $request->mensaje;
        $consultas->save();

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

