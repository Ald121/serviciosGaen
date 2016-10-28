<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalles_Pedidos extends Model
{
    protected $connection='mysql';
    protected $table='pedido_detalle';
    public $timestamps=false;
    protected $fillable = [
						'idpedidos',
						'idproducto',
						'cantidad',
						'idcliente',
						'estado',
						'idpedido'
						    ];
}
