<?php

namespace App\Models\Salud;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontograma extends Model
{
    use HasFactory;
    protected $table = 'salud.odontograma';
    protected $fillable = [
        'odontogramaid',
        'tipoodontogramaid'
    ];
    protected $primaryKey = 'odontogramaid';
    public $incrementing = true;
    public $timestamps = false;
}
