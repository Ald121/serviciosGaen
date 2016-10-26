<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{
     protected $connection='mysql';
    protected $table='ciudad';
    protected $fillable = [
						'nombre_ciudad','nombre_provincia'
						    ];
}
