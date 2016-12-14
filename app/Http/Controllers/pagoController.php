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
use DB;
use Carbon\Carbon;

class pagoController extends Controller
{
    public function __construct(){
    	$this->empresa=new Empresas();
    	$this->pedidos=new Pedidos();
    }

    public function get_datos_deposito(Request $request){
		$datos=$this->empresa->orderBy('idempresa','ASC')->first();
		return response()->json(["respuesta"=>$datos]);
    }

    public function get_costo_envio(Request $request){
        // return response()->json(["repuesta"=>$request->all()]);
        $datos=DB::table('precios')->where('idciudad',$request->nombre_ciudad)->where('idempresas',$request->idempresas)->first();
        return response()->json(["respuesta"=>$datos]);
    }

    public function upload_deposito(Request $request){
		$datos_pedido=$this->pedidos->where('idpedido',$request->input('idpedido'))->where('estado_p',0)->first();

        if (count($datos_pedido)>0) {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $id_img='comprobante_pedido_'.$request->input('idpedido').'.'.$extension;
        Storage::disk('custom')->put($id_img,  File::get($file));
        
        DB::table('deposito')->insert(['numero_deposito'=>$request->input('numero_deposito'),
                                    'fecha'=>Carbon::now()->toDateString(),
                                    'banco'=>$request->input('banco'),
                                    'valor'=>$datos_pedido->total,
                                    'imagen_deposito'=>$id_img,
                                    'idpedido'=>$request->input('idpedido')]);
        $this->pedidos->where('idpedido',$request->input('idpedido'))->update(['estado_p'=>1]);

        return response()->json(["respuesta"=>true]);
        }
        else{
            return response()->json(["respuesta"=>false]);
        }
    	
    }
}
