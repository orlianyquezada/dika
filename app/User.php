<?php

namespace App;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;
    
    protected const MESSAGES = [
        'name.required' => 'Nombre es requerido', 
        'name.string'   => 'Nombre debe ser un string',
        'name.max'      => 'El nombre no puede tener mas de 255 caracteres', 
        'email.required'=> 'Email es requerido',
        'email.email'   => 'Email debe tener un formato email',
        'email.max'     => 'Email no puede tener mas de 255 caracteres',
        'email.unique'  => 'Email ya se encuentra registrado',
        'rol.required' => 'El rol es requerido'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
