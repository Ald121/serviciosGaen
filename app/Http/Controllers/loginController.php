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
// Extras
use DB;
use Carbon\Carbon;

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
        $datos['nombre_empresa']='Servientrega';

        return response()->json(["respuesta"=>$datos,"token"=>$token]);

    }

    public function registro(Request $request){

$date=explode('T',  $request->input('fecha_nacimiento'));

DB::table('clientes')->insert(
    [
'idcliente'=>$request->input('idcliente'),
'nombres'=>$request->input('nombres'),
'apellidos'=>$request->input('apellidos'),
'direccion'=>$request->input('direccion'),
'telefono'=>$request->input('telefono'),
'email'=>$request->input('email'),
'sexo'=>$request->input('choice'),
'estado'=>'0',
'foto'=>'foto',
'nombre_ciudad'=>$request->input('nombre_ciudad'),
'codigo_postal'=>'0000',
'fecha_nacimiento'=>$date[0]]
);

      return response()->json(["respuesta"=>true]);  
    }
}
