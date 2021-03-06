<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';
    
    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';
    
    protected $table = 'users';
    protected $dates = ['deleted_at'];

    public function setNameAttribute($valor) {
        $this->attributes['name'] = strtolower($valor);
    }


    public function getNameAttribute($valor) {
        return ucwords($valor);
    }

    public function setEmailAttribute($valor) {
        $this->attributes['email'] = strtolower($valor);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'verification_token',
    ];

    protected function esVerificado()
    {
        return $this->verified == User::USUARIO_VERIFICADO;
    }

    protected function esAdministrador()
    {
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }

    protected static function generarVerificacionToken()
    {
        return str_random(40);
    }
}
