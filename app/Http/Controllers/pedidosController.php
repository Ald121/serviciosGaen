<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// modelos
use App\Clientes;
use App\Pedidos;
use App\Detalles_Pedidos;
use App\productos;
use App\Empresas;
// Extras
use Carbon\Carbon;
use Mail;
use DB;
//-------------------------------------- Autenticacion ---------------
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class pedidosController extends Controller
{
    public function __construct(){
    	// Modelos
    	$this->clientes=new Clientes();
        $this->empresa=new Empresas();
    	$this->pedidos=new Pedidos();
    	$this->productos=new productos();
        // Autenticacion
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function confirmar_pedido(Request $request){

        $this->pedidos->idcliente=$this->user['idsocio'];
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
        $datos_pago=$this->empresa->orderBy('idempresa','ASC')->first();

       $data=['correo'=>$request->usuario['email'],'total'=>$request->total,'banco'=>$datos_pago->banco,'tipo_cuenta'=>$datos_pago->Tipo_cuenta,'numero_cuenta'=>$datos_pago->cuenta_banco,'nombre_cuenta'=>$datos_pago->propietario];
       $this->enviar_email($data);
		return response()->json(["respuesta"=>$datos_pago]);
    }

    public function mis_pedidos(Request $request){

        $pedidos=$this->pedidos->where('idcliente',$this->user['cedula'])->get();
    
    return response()->json(["respuesta"=>$pedidos]);
    }

    public function enviar_email($data){

        $correo_enviar=$data['correo'];
        
        Mail::send('email_pago', $data, function($message)use ($correo_enviar)
            {
                $message->from("admin@asociacion-gaen.com",'GAEN');
                $message->to($correo_enviar)->subject('Datos para Deposito');
            });
    }   

}
