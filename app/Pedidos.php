<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $connection='mysql';
    protected $table='pedido';
    public $timestamps=false;
    protected $fillable = [
				'idpedido',
				'idcliente',
				'total_productos',
				'total',
				'fecha',
				'estado_p',
				'entrega_estado'
						    ];
}
