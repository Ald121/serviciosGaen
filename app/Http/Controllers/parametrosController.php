<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Extras
use DB;
class parametrosController extends Controller
{

    public function get_parametros(Request $request){
		$datos=DB::table('parametros')->get();
		return response()->json(["respuesta"=>$datos]);
    }
}
