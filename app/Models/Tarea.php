<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'completada',
        'prioridad',
        'fecha_limite',
        'categoria',
    ];

    protected $casts = [
        'completada' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}