<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'basic.persona';
    protected $fillable = [
        'personaid',
        'registro',
        'tipo',
        'direccion',
        'distritoid',
        'foto',
        'telefono',
        'email',
        'rol',
        'usuarioid',
        'ip',
        'estado',
        'paisid',
    ];
    protected $primaryKey = 'personaid';
    public $incrementing = true;
    public $timestamps = false;
}
