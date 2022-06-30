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
        'name.required' => 'The name field is required',
        'name.string'   => 'The name field only accepts letters',
        'name.max'      => 'The name cannot be longer than 255 characters',
        'email.required'=> 'The name field is required',
        'email.email'   => 'The email field must be in email format',
        'email.max'     => 'The email cannot be longer than 255 characters',
        'email.unique'  => 'The email field is already registered',
        'rol.required' => 'The rol is required'
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
