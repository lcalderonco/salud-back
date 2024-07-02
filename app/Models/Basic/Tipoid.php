<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipoid extends Model
{
    use HasFactory;
    protected $table = 'basic.tipoid';
    protected $fillable = [
        'tipoid',
        'nombre',
        'abreviatura',
        'codigo_contable',
        'longitud',
        'tipopersona',
        'webservice',
        'orden',
        'estado',
    ];
}
