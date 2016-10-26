<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// Modelos
use App\Provincias;
use App\Ciudades;

class cmbController extends Controller
{
    public function __construct(){
        // Modelos
    	$this->Provincias=new Provincias();
        $this->Ciudades=new Ciudades();
    }

    public function get_provincias(Request $request){
    	$provincias=$this->Provincias->orderBy('nombre_provincia','ASC')->get();
    	return response()->json(["repuesta"=>$provincias]);
    }

    public function get_ciudades(Request $request){
    	// $provincias=$this->Ciudades->where('nombre_provincia',$request->input('nombre_provincia'))->orderBy('nombre_ciudad','DESC')->get();
    	$provincias=$this->Ciudades->orderBy('nombre_ciudad','ASC')->get();
    	return response()->json(["repuesta"=>$provincias]);
    }
}
