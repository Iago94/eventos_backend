<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscrito extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'cpf',
        'email'
    ];

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'inscritos_eventos', 'inscrito_id', 'evento_id');
    }
}
