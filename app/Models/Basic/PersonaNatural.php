<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaNatural extends Model
{
    use HasFactory;
    protected $table = 'basic.persona_natural';
    protected $fillable = [
        'personaid',
        'titulo',
        'ape_pat',
        'ape_mat',
        'nombre',
        'sexo',
        'est_civil',
        'nacimiento'
    ];
    public $incrementing = false;
    public $timestamps = false;
}
