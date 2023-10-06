<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome'       ,
        'data_inicio', 
        'data_fim'   , 
        'status'     
    ];

    Public function eventos(){
        return $this->belongsToMany('App\Models\Evento', 'inscritos_eventos', 'inscrito_id', 'evento_id');
    }
    
}
