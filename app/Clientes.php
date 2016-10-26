<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $connection='mysql';
    protected $table='clientes';
    protected $fillable = [
'nombres',
'apellidos',
'direccion',
'telefono',
'email',
'sexo',
'estado',
'foto',
'nombre_ciudad',
'codigo_postal',
'fecha_nacimiento',
'cli_clave'
    ];

     protected $hidden = [
'estado',
'cli_clave'
    ];
}
