<?php


namespace App\Http\Controllers;

use App\Http\Controllers\IndexController;
use App\Models\Categorias;
use App\Models\Colores_Producto;
use App\Models\Estado_Producto;
use App\Models\Fotos_Categorias_Banner;
use App\Models\Fotos_Producto;
use App\Models\Fotos_Banner;
use App\Models\Fotos_Categoria;
use App\Models\Ofertas;
use App\Models\Precios;
use App\Models\Productos;
use App\Models\Colores;
use App\Models\User;
use Carbon\Carbon;
use Faker\Core\Color;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
Use Auth;
use Monolog\Handler\IFTTTHandler;
use function Ramsey\Collection\add;
use function Termwind\ValueObjects\getLength;


class ProductosController extends Controller
{
    protected $otroController;

    public function __construct(IndexController $otroController)
    {
        $this->otroController = $otroController;
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function editarEstado(Request $request){
        $estado = Estado_producto::find($request->id);
        if($request->tipo == 'Nombre')
        {
            $estado->nombre = $request->valor;
        }
        $estado->save();

        return 'OK';
    }
    public function editarColor(Request $request){
        $color = Colores::find($request->id);
        if($request->tipo == 'Nombre')
        {
            $color->nombre = $request->valor;
        }
        if($request->tipo == 'Color')
        {
            $color->color = $request->valor;
        }
        $color->save();

        return 'OK';
    }
    public function editarPrecio(Request $request){
        $precio = Precios::find($request->id);
        if($request->tipo == 'Porcentaje')
        {
            $precio->porcentaje = $request->valor;
        }
        elseif ($request->tipo == 'Dias')
        {
            $precio->dias = $request->valor;
        }
        $precio->save();

        return 'OK';
    }
    public function editarCategoria(Request $request){
        $categoria = Categorias::find($request->id);
        if($request->tipo == 'Nombre')
        {
            $categoria->nombre = $request->valor;
        }
        elseif ($request->tipo == 'Padre')
        {
            $categoria->padre_id = $request->valor;
        }
        elseif ($request->tipo == 'Foto')
        {
            foreach ($request->valor as $key => $foto)
            {
                $extension = 'jpg';
                $nombre = $this->generateRandomString(10);
                $myFileName = $nombre . '.' . $extension;
                Image::make($foto)->save(public_path('/fotos/' . $myFileName));

                $ima = Fotos_categoria::where('categoria_id', $request->id)->get();
                if (sizeof($ima) == 0) {
                    $ima = new Fotos_categoria;
                    $ima->categoria_id = $request->id;
                    $ima->nombre = 'nombre';
                    $ima->path = $myFileName;
                    $ima->save();
                }
                else{
                    $ima = Fotos_categoria::find($ima[0]->id);
                    $ima->path = $myFileName;
                    $ima->save();
                }
            }
        }
        $categoria->save();

        return 'OK';
    }

    public function editarProducto(Request $request){
        $producto = Productos::find($request->id);
        if ($request->tipo == 'Nombre'){
            $producto->nombre = $request->valor;
        }
        else if($request->tipo == 'Precio'){
            $producto->precio = $request->valor;
        }
        else if($request->tipo == 'Stock'){
            $producto->stock = $request->valor;
        }
        else if($request->tipo == 'cant_minimo'){
            $producto->cant_minimo = $request->valor;
        }
        else if($request->tipo == 'Descripcion'){
            $producto->descripcion = $request->valor;
        }
        else if($request->tipo == 'Categoria'){
            $producto->categoria_id = $request->valor;
        }
        else if($request->tipo == 'Color'){
            $coloresProducto = Colores_Producto::where('producto_id', $request->id)->get();
            foreach ($coloresProducto as $item) {
                $item->delete();
            }
            foreach ($request->valor as $item){
                $colorNuevo = new Colores_Producto;
                $colorNuevo->producto_id = $request->id;
                $colorNuevo->color_id = $item['id'];
                $colorNuevo->save();
            }
        }
        else if($request->tipo == 'Foto'){
                foreach ($request->valor as $key => $foto)
                {
                    $extension = 'jpg';
                    $nombre = $this->generateRandomString(10);
                    $myFileName = $nombre . '.' . $extension;
                    Image::make($foto)->save(public_path('/fotos/' . $myFileName));

                    $ima = Fotos_Producto::find($request->imagen);
                    $ima->path = $myFileName;
                    $ima->save();
                }
        }
        $producto->save();

        return back();
    }
    public function verProductosCategoria($nombre)
    {
            $id = Categorias::select('categorias.*')->where('nombre', $nombre)->get()->toArray();
            if ($id != []) {
                $id = $id[0]['id'];
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

                $cateHijos = Categorias::select('categorias.*')->where('padre_id', $id)->get();
                if (sizeof($cateHijos) > 0) {
                    $i = 0;
                    $productos = [];
                    foreach ($cateHijos as $cate) {
                        $fotos = Fotos_categoria::where('categoria_id', $cate->id)->get()->toArray();
                        $cate->path = '';
                        if ($fotos != []) {
                            $cate->path = $fotos[0]['path'];
                        }

                        $produc = Productos::select('producto.*')->where('categoria_id',  $cate->id)->where('estado', 1)->get();
                        foreach ($produc as $pro) {
                            $pro->nomCate = $cate->nombre;
                            $ofertas = Ofertas::where('producto_id', $pro->id)->get()->toArray();
                            $pro->cantOfertas = (count($ofertas));

                            $nomEstado = Estado_producto::select('nombre')->where('id', $pro['estado_id'])->get()->toArray();
                            if ($nomEstado != []) {
                                $pro->nomEstado = $nomEstado[0]['nombre'];
                            }

                            $fotos = Fotos_Producto::where('producto_id', $pro->id)->get()->toArray();
                            $pro->path = '';
                            if ($fotos != []) {
                                $pro->path = $fotos[0]['path'];
                            }

                            $productos[$i] = $pro; $i++;
                        }
                    }

                } else {

                    $productos = Productos::select('producto.*')->where('categoria_id', $id)->where('estado', 1)->get();
                    foreach ($productos as $pro) {
                        $pro->nomCate = $nombre;

                        $ofertas = Ofertas::where('producto_id', $pro->id)->get()->toArray();
                        $pro->cantOfertas = (count($ofertas));

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
                }

                return Inertia::render('Productos/productosCategoria', ['productos' => $productos, 'nombre' => $nombre,
                    'categorias' => $categorias, 'fotosBanner' => $fotosBanner, 'cateHijos' => $cateHijos]);

            }
            else{
                $this->otroController->inicio();
            }

    }

    public function verPerfilProducto($id)
        {
            $producto = Productos::find($id);
            if ($producto->user_id == Auth::user()->id || Auth::user()->es_admin) {
                $nomCat = Categorias::select('nombre')->where('id', $producto->categoria_id)->get()->toArray();
                if ($nomCat != []) {
                    $producto->nomCat = $nomCat[0]['nombre'];
                }

                $nomEstado = Estado_producto::select('nombre')->where('id', $producto->estado_id)->get()->toArray();
                if ($nomEstado != []) {
                    $producto->nomEstado = $nomEstado[0]['nombre'];
                }

                $nomColor = Colores::select('nombre')->where('id', $producto->color_id)->get()->toArray();
                if ($nomColor != []) {
                    $producto->nomColor = $nomColor[0]['nombre'];
                }

                $fotos = Fotos_Producto::where('producto_id', $id)->get()->toArray();
                $producto->path = '';
                if ($fotos != []) {
                    $producto->path = $fotos;
                }

                $coloresProducto = Colores_Producto::select('colores.*')->where('colores_producto.producto_id', $id)
                    ->leftJoin('colores', 'colores.id', 'colores_producto.color_id')
                    ->get()->toArray();
                $producto->coloresProducto = $coloresProducto;

                $categorias = Categorias::all();
                $colores = Colores::all();
                $estados = Estado_producto::all();
                $fotosBanner = Fotos_banner::all();

                return Inertia::render('Productos/perfilProducto', ['producto' => $producto, 'categorias' => $categorias, 'colores' => $colores, 'estados' => $estados, 'fotosBanner' => $fotosBanner]);
            }
    }
    public function verProductos()
    {
        if (Auth::user()->es_admin) {

            $productos = Productos::all();
            foreach ($productos as $pro) {
                $ofertas = Ofertas::where('producto_id', $pro->id)->get()->toArray();
                $pro->cantOfertas = (count($ofertas));

                $nomCat = Categorias::select('nombre')->where('id', $pro['categoria_id'])->get()->toArray();
                $nomEstado = Estado_producto::select('nombre')->where('id', $pro['estado_id'])->get()->toArray();
                if ($nomCat != []) {
                    $pro->nomCat = $nomCat[0]['nombre'];
                }
                if ($nomEstado != []) {
                    $pro->nomEstado = $nomEstado[0]['nombre'];
                }
                $user = User::find($pro->user_id);
                $pro->usuario = $user;
            }

            $categoriasTodas = Categorias::all();
            $categorias = []; $i = 0;
            foreach ($categoriasTodas as $cate){
                $posibleCate = Categorias::select('categorias.*')->where('padre_id', $cate->id)->get()->toArray();
                if ($posibleCate == []){
                    $posiblePadre = Categorias::select('nombre')->where('id', $cate->padre_id)->get()->toArray();
                    if ($posiblePadre != []){
                        $cate->nombre = "(" . $posiblePadre[0]['nombre'] . ") " . $cate->nombre;
                    }
                    $categorias[$i] = $cate;
                    $i++;
                }
            }
            $estados = Estado_producto::all();
            $colores = Colores::all();
            return Inertia::render('Productos/Index', ['productos' => $productos, 'categorias' => $categorias, 'estados' => $estados, 'colores' => $colores]);
        }
    }
    public function verProductoDetalle($nomCat, $producto)
    {
        if ($nomCat != '' && $producto != '') {
            $produ = Productos::select('producto.*')->leftJoin('categorias', 'categorias.id', 'producto.categoria_id')
                ->where('producto.nombre', $producto)
                ->where('categorias.nombre', $nomCat)
                ->firstOrFail();

            if ($produ->estado == 1) {
                $fotosBanner = Fotos_banner::where('activo', 1)->get()->toArray();

                $id = $produ->id;
                $nomEstado = Estado_producto::select('nombre')->where('id', $produ->estado_id)->get()->toArray();
                $ofertas = Ofertas::where('producto_id', $id)->orderBy('created_at', 'DESC')->get();

                $produ->cantOfertas = count($ofertas->toArray());
                $produ->ofertas = $ofertas;

                if ($nomEstado != []) {
                    $produ->nomEstado = $nomEstado[0]['nombre'];
                }
                $nomCat = Categorias::select('nombre')->where('id', $produ->categoria_id)->get()->toArray();
                if ($nomCat != []) {
                    $produ->nomCat = $nomCat[0]['nombre'];
                }

                $fotos = Fotos_Producto::where('producto_id', $id)->get()->toArray();
                $produ->path = [];
                if ($fotos != []) {
                    $produ->path = $fotos;
                }

                $coloresProducto = Colores_Producto::select('colores.*')->where('colores_producto.producto_id', $id)
                    ->leftJoin('colores','colores.id','colores_producto.color_id')
                    ->get()->toArray();
                $produ->coloresProducto = $coloresProducto;

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

                $otrosCategoria = Productos::where('categoria_id', $produ->categoria_id)->where('id', '!=', $id)->where('estado', 1)->get();
                $otrosVendedor = Productos::where('user_id', $produ->user_id)->where('id', '!=', $id)->where('estado', 1)->get();

                foreach ($otrosCategoria as $pro) {
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
                    $fotos = Fotos_Producto::where('producto_id', $pro['id'])->get()->toArray();
                    $pro->path = '';
                    if ($fotos != []) {
                        $pro->path = $fotos[0]['path'];
                    }
                }
                foreach ($otrosVendedor as $pro) {
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
                    $fotos = Fotos_Producto::where('producto_id', $pro['id'])->get()->toArray();
                    $pro->path = '';
                    if ($fotos != []) {
                        $pro->path = $fotos[0]['path'];
                    }
                }
                return Inertia::render('Productos/verProducto', ['producto' => $produ, 'categorias' => $categorias, 'otrosCategoria' => $otrosCategoria, 'otrosVendedor' => $otrosVendedor, 'fotosBanner' => $fotosBanner]);
                } else {
                    $this->otroController->inicio();
                }
            }
            else {
                $this->otroController->inicio();
            }
    }

    public function verPrecios(){

        $productos = Productos::all();
        $precios = Precios::select('precios.*', 'producto.nombre', 'producto.precio')
        ->leftJoin('producto','producto.id','precios.producto_id')
        ->get();


        return Inertia::render('Productos/verPrecios', ['productos' => $productos, 'precios' => $precios]);
    }
    public function guardarPrecioProducto(Request $request){
        $precio = new Precios();
        $precio->producto_id = $request->producto_id;
        $precio->porcentaje = $request->porcentaje;
        $precio->dias = $request->dias;
        $precio->dias_restantes = $request->dias;
        $precio->veces = 0;
        $precio->save();

        return back();
    }
    public function actualizarTodosPrecios($cantidad){
        $productos = Productos::all();
        foreach ($productos as $pro){
            $aumento = $pro->precio * $cantidad / 100;
            $pro->precio =  $pro->precio + $aumento;

            $pro->save();
        }

        return back();
    }
    public function guardarProducto(Request $request)
    {
        $producto = new Productos;
        $producto->user_id = Auth::user()->id;
        $producto->nombre = $request->nombre;
        $producto->categoria_id = $request->categoria_id;
        $producto->estado_id = $request->estado_id;
        $producto->precio = $request->precio;
        $producto->stock = 2;
        $producto->cant_minimo = 1;
        $producto->estado = 1;
        $producto->descripcion = $request->descripcion;
        $producto->save();

        foreach ($request->color_id as $color){
            $colorProdu = new Colores_Producto();
            $colorProdu->producto_id = $producto->id;
            $colorProdu->color_id = $color['id'];
            $colorProdu->save();
        }

        if ($request->path) {
            foreach ($request->path as $key => $foto) {
                $extension = 'jpg';
                $nombre = $this->generateRandomString(10);
                $myFileName = $nombre . '.' . $extension;

                Image::make($foto)->save(public_path('/fotos/' . $myFileName));

                $imagen = new Fotos_Producto();
                $imagen->path = $myFileName;
                $imagen->producto_id = $producto->id;
                $imagen->save();
            }
        }

        return 'OK';

    }
    public function borrarBanner($id){
        $fotoBanner = Fotos_banner::find($id);
        $fotoBanner->delete();
        return back();
    }
    public function borrarBannerCategoria($id){
        $fotoBanner = Fotos_Categorias_Banner::find($id);
        $fotoBanner->delete();
        return back();
    }

    public function borrarProducto($id)
    {

        $producto = Productos::find($id);
        if (Auth::user()->es_admin || $producto->user_id == Auth::user()->id) {
            $ofertas = Ofertas::where('producto_id', $id)->get();
            foreach ($ofertas as $ofe) {
                $ofe->delete();
            }


            $fotos = Fotos_Producto::where('producto_id', $id)->get();
            foreach ($fotos as $fot) {
                $fot->delete();
            }
            $producto->delete();
            return back();
        }
    }

    public function habilitarProducto($id)
    {
        if(Auth::user()->es_admin) {

            $producto = Productos::find($id);
            if ($producto->estado == 0) {
                $producto->estado = 1;
            } else {
                $producto->estado = 0;
            }

            $producto->save();
            return back();
        }
    }

    public function verEstadoProducto(){
        if(Auth::user()->es_admin) {
            $estados = Estado_producto::all();
            return Inertia::render('Productos/estadoProducto', ['estados' => $estados]);
        }
    }
    public function verColoresProducto(){
        if(Auth::user()->es_admin) {
            $colores = Colores::all();
            return Inertia::render('Productos/coloresProducto', ['colores' => $colores]);
        }
    }

    public function guardarEstadoProducto(Request $request)
    {
        if(Auth::user()->es_admin) {
            $est = new Estado_producto;
            $est->nombre = $request->nombre;
            $est->save();
            return back();
        }
    }
    public function guardarColorProducto(Request $request){
        if(Auth::user()->es_admin) {
            $col = new Colores;
            $col->nombre = $request->nombre;
            $col->color = $request->color;
            $col->save();
            return back();
        }
    }

    public function borrarEstadoProducto($id)
    {
        if (Auth::user()->es_admin) {
            $est = Estado_producto::find($id);
            $est->delete();
            return redirect()->back()->with('success', 'Saved!');
        }
    }
    public function eliminarFotoProducto($id){
        $foto_producto = Fotos_Producto::find($id);
        $foto_producto->delete();
        return back();
    }
    public function agregarFotos(Request $request){
        foreach ($request->pathNuevas as $key => $foto)
        {
            $extension = 'jpg';
            $nombre = $this->generateRandomString(10);
            $myFileName = $nombre . '.' . $extension;
            Image::make($foto)->save(public_path('/fotos/' . $myFileName));

            $ima = new Fotos_Producto;
            $ima->path = $myFileName;
            $ima->producto_id = $request->producto_id;
            $ima->save();
        }
    }
}
