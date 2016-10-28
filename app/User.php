<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection='mysql';
    protected $primaryKey='idusuario';
    protected $table='usuarios';
    protected $fillable = [
        'idusuario', 'usuario', 'pass_app',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pass_app', 'remember_token',
    ];

    public function getAuthPassword() {
    return $this->pass_app;
    }
}
