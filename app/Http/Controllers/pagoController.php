<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// modelos
use App\Empresas;
use App\Pedidos;
// Extras
use Storage;
use File;

class pagoController extends Controller
{
    public function __construct(){
    	$this->empresa=new Empresas();
    	    	$this->pedidos=new Pedidos();
    }

    public function get_datos_deposito(Request $request){
		$datos=$this->empresa->orderBy('idempresa','ASC')->first();
		return response()->json(["repuesta"=>$datos]);
    }

    public function upload_deposito(Request $request){
		// $datos=$this->empresa->orderBy('idempresa','ASC')->first();
    	$this->pedidos->where('idpedido',$request->input('idpedido'))->update(['estado_p'=>1]);
    	$id_img=$request->input('idpedido');
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        
        Storage::disk('custom')->put('comprobante_pedido_'.$id_img.'.'.$extension,  File::get($file));

		return response()->json(["repuesta"=>$request->all()]);
    }
}
