<?php


namespace App\Http\Controllers;
use App\Http\Controllers\IndexController;
use App\Models\Clientes;
use App\Models\Productos;
use App\Models\Consultas;
use App\Models\User;
use Inertia\Inertia;
use Auth;

class UsersController extends Controller
{
    protected $otroController;

    public function __construct(IndexController $otroController)
    {
        $this->otroController = $otroController;
    }
    public function verUsuarios()
    {
        if (Auth::user()->es_admin) {
            $usuarios = User::all()->toArray();
            $cantidad = count($usuarios);
            return Inertia::render('Usuarios/Index', ['Usuarios' => $usuarios, 'cant' => $cantidad]);
        }
    }
    public function verConsultas(){
        $consultas = Consultas::select('consultas.*','clientes.nombre','clientes.apellido','clientes.email','clientes.numero')
            ->leftJoin('clientes','clientes.id','consultas.cliente_id')->get();
        return Inertia::render('Consultas/Index', ['consultas' => $consultas]);

    }
    public function eliminarUsuario($id)
    {
        if (Auth::user()->es_admin) {

            $usuario = User::find($id);
            $usuario->delete();
            return back();
        }
    }
    public function eliminarConsulta($id)
    {
        if (Auth::user()->es_admin) {

            $consultas = Consultas::find($id);
            $consultas->delete();
            return back();
        }
    }
    public function verVentas(){
        if(Auth::user()->es_admin) {

            $ventas = Ventas::select('venta_producto.*','ventas.*')
            ->leftJoin('venta_producto','venta_producto.venta_id','ventas.id')
            ->get();

                foreach ($ventas as $ven) {
                    $prod = Productos::find($ven->producto_id);
                    $ven->prodNombre = $prod['nombre'];
                    $ven->prodPrecio = $prod['precio_max'];
                    $cli = Clientes::find($ven->cliente_id);
                    $ven->cliNombre = $cli['nombre'] . ' ' . $cli['apellido'];
                    $ven->cliMail = $cli['email'];
                    $prov = Provincias::find($ven->provincia_id);
                    $ven->cliProvNom = $prov['nombre'];
                    $ven->cliProvPre = $prov['precio'];
                    $neg = Negocio::find($ven->negocio_id);
                    $ven->negNom = $neg['nombre'];
            }

        return Inertia::render('Usuarios/Ventas', ['ventas' => $ventas]);
      }
    }
}
