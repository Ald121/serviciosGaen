<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class productosController extends Controller
{
    public function __construct(){

    }

    public function get_productos(){

    	$prods=DB::connection('mysql')->select("SELECT idproducto,
														nombre_producto,
														fecha_add,
														nombre_categoria,
														nombre_color,
														numero_talla,
														peso,
														stock,
														precio,
														precio_venta,
														descripcion,id_socio
														 FROM producto WHERE estado='PUBLICADO' ");

    	foreach ($prods as $key => $value) {
    		$img_prod=DB::connection('mysql')->select("SELECT * FROM img_producto WHERE idproducto='".$value->idproducto."'");
    		$detalles_prod=DB::connection('mysql')->select("SELECT nombre_material,
																	cantidad,
																	precio_anterior FROM detalles_producto where idproducto='" . $value->idproducto . "'");
    		$cate_prod=DB::connection('mysql')->select("SELECT direccion FROM categoria where nombre_categoria='" . $value->nombre_categoria . "'");
    		$socio=DB::connection('mysql')->select("SELECT idcedula,
															socio_nombres,
															socio_apellidos,
															socio_direccion,
															socio_telefono,
															socio_email from socios where socio_email='".$value->id_socio."'");
   
    		$value->img='http://www.asociacion-gaen.com/admin/archivos/'.$cate_prod[0]->direccion.'/'.$img_prod[0]->direccion_foto;
    		$value->detalles=$detalles_prod;
    		$value->socio=$socio;
    	}
    return response()->json(['respuesta'=>$prods]);

    }

    public function get_productos_by_id(Request $request){

    	$prods=DB::connection('mysql')->select("SELECT idproducto,
														nombre_producto,
														fecha_add,
														nombre_categoria,
														nombre_color,
														numero_talla,
														peso,
														stock,
														precio,
														precio_venta,
														descripcion,id_socio
														 FROM producto WHERE estado='PUBLICADO' and idproducto='".$request->input('idproducto')."'");

    	foreach ($prods as $key => $value) {
    		$img_prod=DB::connection('mysql')->select("SELECT * FROM img_producto WHERE idproducto='".$value->idproducto."'");
    		$detalles_prod=DB::connection('mysql')->select("SELECT nombre_material,
																	cantidad,
																	precio_anterior FROM detalles_producto where idproducto='" . $value->idproducto . "'");
    		$cate_prod=DB::connection('mysql')->select("SELECT direccion FROM categoria where nombre_categoria='" . $value->nombre_categoria . "'");
    		$socio=DB::connection('mysql')->select("SELECT idcedula,
															socio_nombres,
															socio_apellidos,
															socio_direccion,
															socio_telefono,
															socio_email from socios where socio_email='".$value->id_socio."'");
   
    		$value->img='http://www.asociacion-gaen.com/admin/archivos/'.$cate_prod[0]->direccion.'/'.$img_prod[0]->direccion_foto;
    		$value->detalles=$detalles_prod;
    		$value->socio=$socio;
    	}
    return response()->json(['respuesta'=>$prods[0]]);
    }
}
