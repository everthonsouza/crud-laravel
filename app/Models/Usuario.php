<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Usuario extends Model implements 
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use HasFactory, Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

    protected $table = 'usuarios';

    protected $fillable = [
        'primeiro_nome',
        'sobrenome',
        'email',
        'ativo'
    ];

    protected $attributes = [
        'ativo' => true,
    ];
}
