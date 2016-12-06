<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincias extends Model
{
     protected $connection='mysql';
    protected $table='provincias';
    public $timestamps=false;
    protected $fillable = [
'nombre_provincias'
    ];
}
