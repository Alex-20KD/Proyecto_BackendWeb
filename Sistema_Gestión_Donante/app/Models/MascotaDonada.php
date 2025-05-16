<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MascotaDonada extends Model
{
    use HasFactory;

    protected $table = 'mascotas_donadas';
    
    protected $fillable = [
        'donante_id',
        'mascota_id',
        'fecha_donacion',
        'motivo_donacion',
        'estado_revision'
    ];

    protected $casts = [
        'fecha_donacion' => 'date',
    ];

    /**
     * Obtener el donante que donó esta mascota
     */
    public function donante(): BelongsTo
    {
        return $this->belongsTo(Donante::class, 'donante_id');
    }

    /**
     * Obtener la mascota que fue donada
     * Nota: Asumimos que existe un modelo Mascota en otra parte del sistema
     */
    public function mascota(): BelongsTo
    {
        // Esta relación apuntaría a un modelo Mascota que estaría en otro módulo
        return $this->belongsTo('App\Models\Mascota', 'mascota_id');
    }
}
