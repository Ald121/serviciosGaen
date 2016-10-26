<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincias extends Model
{
     protected $connection='mysql';
    protected $table='provincia';
    protected $fillable = [
'nombre_provincia'
    ];
}
