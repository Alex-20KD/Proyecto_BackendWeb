<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificacionDonante extends Model
{
    use HasFactory;

    protected $table = 'verificaciones_donantes';
    
    protected $fillable = [
        'donante_id',
        'fecha_verificacion',
        'resultado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_verificacion' => 'date',
    ];

    /**
     * Obtener el donante asociado a esta verificación
     */
    public function donante(): BelongsTo
    {
        return $this->belongsTo(Donante::class, 'donante_id');
    }
}
