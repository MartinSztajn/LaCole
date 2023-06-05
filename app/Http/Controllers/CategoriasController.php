<?php

namespace App\Http\Controllers;


use App\Models\Categorias;
use App\Models\Fotos_Producto;
use App\Models\Fotos_Banner;
use App\Models\Fotos_Categoria;


use App\Models\User;
use App\Models\UsuarioGuardado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
Use Auth;
use Intervention\Image\ImageManagerStatic as Image;

class CategoriasController extends Controller
{
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function verCategoria(){
        if(Auth::user()->es_admin) {
            $categorias = Categorias::all();

            foreach ($categorias as $cate){
                $fotos = Fotos_categoria::where('categoria_id', $cate->id)->get()->toArray();
                $cate->path = '';
                if ($fotos != []) {
                    $cate->path = $fotos[0]['path'];
                }
                if ($cate->padre_id != null){
                    $nomPadre = Categorias::select('nombre')->where('id', $cate->padre_id)->get()->toArray();
                    $cate->nomPadre = $nomPadre[0]['nombre'];
                }
                else{
                    $cate->nomPadre = "x";
                }
            }

            return Inertia::render('Categoria/Index', ['categorias' => $categorias]);
        }
    }
    public function verBanner(){
        if(Auth::user()->es_admin) {
            $fotosBanner = Fotos_banner::all();
            return Inertia::render('Fotos/banner', ['fotosBanner' => $fotosBanner]);
        }
    }

    public function guardarCategoria(Request $request)
    {
        if(Auth::user()->es_admin) {
            $cate = new Categorias;
            $cate->nombre = $request->nombre;
            $cate->padre_id = $request->padre_id;
            $cate->save();

            if ($request->path) {
                foreach ($request->path as $key => $foto) {
                    $extension = 'jpg';
                    $nombre = $this->generateRandomString(10);
                    $myFileName = $nombre . '.' . $extension;

                    Image::make($foto)->fit(340, 340)->save(public_path('/fotos/' . $myFileName));

                    $fotoCate = new Fotos_categoria;
                    $fotoCate->categoria_id = $cate->id;
                    $fotoCate->path = $myFileName;
                    $fotoCate->nombre = $request->nombre;
                    $fotoCate->save();
                }
            }

            return back();
        }
    }
    public function guardarBanner(Request $request){
        if(Auth::user()->es_admin) {
            if ($request->path) {
                foreach ($request->path as $key => $foto) {
                    $extension = 'jpg';
                    $nombre = $this->generateRandomString(10);
                    $myFileName = $nombre . '.' . $extension;

                    $fotoBanner = new Fotos_banner;
                    $fotoBanner->nombre = $request->nombre;
                    $fotoBanner->path = $myFileName;
                    $fotoBanner->url = $request->url;
                    $fotoBanner->save();

                    Image::make($foto)->save(public_path('/fotos/' . $myFileName));

                }
            }
            return back();
        }
    }
    public function activarBanner($id){
        if(Auth::user()->es_admin) {

            $fotoBanner = Fotos_banner::find($id);
            $fotoBanner->activo = 1;
            $fotoBanner->save();
            return back();
        }
    }
    public function desactivarBanner($id){
        if(Auth::user()->es_admin) {

            $fotoBanner = Fotos_banner::find($id);
            $fotoBanner->activo = 0;
            $fotoBanner->save();
            return back();
        }
    }

    public function borrarCategoria($id){
        if(Auth::user()->es_admin) {
            $cate = Categorias::find($id);
            $cate->delete();
            return redirect()->back()->with('success', 'Saved!');
        }
    }
}
