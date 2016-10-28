<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productos extends Model
{
    protected $connection='mysql';
    protected $table='producto';
    public $timestamps=false;
    protected $fillable = [
							'codigo_producto',
							'idproducto',
							'nombre_producto',
							'fecha_add',
							'nombre_categoria',
							'estado',
							'nombre_color',
							'numero_talla',
							'peso',
							'id_socio',
							'stock',
							'precio',
							'precio_venta',
							'ganacia',
							'descripcion'
						    ];
}
