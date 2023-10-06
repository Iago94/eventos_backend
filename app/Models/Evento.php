<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'status',
    ];

    public function inscritos()
    {
        return $this->belongsToMany(Inscrito::class, 'inscritos_eventos', 'evento_id', 'inscrito_id')
            ->where('status', true);
    }
    
}
