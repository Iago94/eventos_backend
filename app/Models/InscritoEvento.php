<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscritoEvento extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'inscritos_eventos';

    protected $fillable = [
        'inscrito_id',
        'evento_id',
    ];

    public $timestamps = true;
}
