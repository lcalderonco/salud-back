<?php

namespace App\Models\Salud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaOdontograma extends Model
{
    use HasFactory;

    protected $table = 'salud.consulta_odontograma';
    protected $fillable = [
        'consultaid',
        'piezaid',
        'tipotratamientoid',
        'tipocaraid',
        'es_tratamiento',
        'detalle',
        'observacion',
        'imagen',
    ];

    protected $primaryKey = ['consultaid', 'piezaid'];
    public $incrementing = false;
    public $timestamps = false;

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('consultaid', $this->getAttribute('consultaid'))
            ->where('piezaid', $this->getAttribute('piezaid'));
    }
}
