<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// modelos
use App\Clientes;
use App\Pedidos;
use App\Detalles_Pedidos;
use App\productos;
// Extras
use Carbon\Carbon;
//-------------------------------------- Autenticacion ---------------
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class pedidosController extends Controller
{
    public function __construct(){
    	// Modelos
    	$this->clientes=new Clientes();
    	$this->pedidos=new Pedidos();
    	$this->productos=new productos();
        // Autenticacion
         $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function confirmar_pedido(Request $request){

        $this->pedidos->idcliente=$request->input('usuario')['idcliente'];
        $this->pedidos->total_productos=count($request->input('productos'));
        $this->pedidos->total=$request->input('total');
        $this->pedidos->fecha=Carbon::now()->toDateString();
        $this->pedidos->estado_p=0;
        $this->pedidos->entrega_estado=0;
        $this->pedidos->save();
        $idpedido = $this->pedidos->id;

        foreach ($request->input('productos') as $key => $value) {
            $producto=$this->productos->select('stock')->where('idproducto',$value['idproducto'])->first();
            if ($producto['stock']>0) {
            $stock=$producto['stock']-$value['cantidad'];
            $this->productos->where('idproducto',$value['idproducto'])->update(['stock'=>$stock]);
            $detalles_pedidos=new Detalles_Pedidos();
            $detalles_pedidos->idproducto=$value['idproducto'];
            $detalles_pedidos->cantidad=$value['cantidad'];
            $detalles_pedidos->idcliente=$request->input('usuario')['idcliente'];
            $detalles_pedidos->estado=0;
            $detalles_pedidos->idpedido=$idpedido;
            $detalles_pedidos->save();
            }
        }

		return response()->json(["respuesta"=>true]);
    }

    public function mis_pedidos(Request $request){

        $pedidos=$this->pedidos->where('idcliente',$this->user['cedula'])->get();
    
    return response()->json(["respuesta"=>$pedidos]);
    }   

}
