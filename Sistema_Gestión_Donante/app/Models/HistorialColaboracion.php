<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialColaboracion extends Model
{
    use HasFactory;

    protected $table = 'historial_colaboraciones';
    
    protected $fillable = [
        'donante_id',
        'tipo_colaboracion',
        'descripcion',
        'fecha_colaboracion'
    ];

    protected $casts = [
        'fecha_colaboracion' => 'date',
    ];

    /**
     * Obtener el donante asociado a esta colaboración
     */
    public function donante(): BelongsTo
    {
        return $this->belongsTo(Donante::class, 'donante_id');
    }
}
