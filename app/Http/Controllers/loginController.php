<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// Modelos
use App\User;
use App\Clientes;
use App\Ciudades;
//-------------------------------------- Autenticacion ---------------
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;

class loginController extends Controller
{
    public function __construct(){
        // Modelos
    	$this->usuario=new User();
        $this->clientes=new Clientes();
        $this->ciudades=new Ciudades();
    }
    public function login(Request $request){

        $credentials = ['usuario' => $request->usuario, 'password' => $request->pass_app];
        try {
            // Verificar si el usuario existe
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['respuesta' => false], 401);
            }
        } catch (JWTException $e) {
            // no se pudo crear el token
            return response()->json(['respuesta' => false], 500);
        }

        $datos = User::select('idusuario','usuario','cedula')->where('usuario',$request->usuario)->first();
        $token = JWTAuth::fromUser($datos);
        // retornar token
        $datos=$this->clientes->where('idcliente',$datos['cedula'])->first();
        $fecha=explode('-', $datos['fecha_nacimiento']);
        $datos['fecha_nacimiento']=$fecha[1].'-'.$fecha[2].'-'.$fecha[0];
        $prov = $this->ciudades->select('nombre_provincia')->where('nombre_ciudad',$datos['nombre_ciudad'])->first();
        $datos['nombre_provincia']=$prov['nombre_provincia'];

        return response()->json(["respuesta"=>$datos,"token"=>$token]);

    }
}
