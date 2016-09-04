<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Pessoa extends Authenticatable
{
    use EnumTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pessoas';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'dataNascimento', 'cpf', 'password', 'telefoneFixo', 'telefoneCelular', 'status', 'sexo', 'endereco',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}