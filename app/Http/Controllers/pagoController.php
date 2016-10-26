<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// modelos
use App\Empresas;

class pagoController extends Controller
{
    public function __construct(){
    	$this->empresa=new Empresas();
    }

    public function get_datos_deposito(Request $request){
    	$datos=$this->empresa->orderBy('idempresa','ASC')->first();
    	return response()->json(["repuesta"=>$datos]);
    }
}
