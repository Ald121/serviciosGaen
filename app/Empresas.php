<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    protected $connection='mysql';
    protected $table='empresa';
    public $timestamps=false;
    protected $fillable = [
'idempresa',
'nombre',
'direccion',
'telefono',
'cuenta_banco',
'celular',
'propietario',
'banco',
'Tipo_cuenta',
    ];

protected $hidden = [
'idempresa'
    ];
}
