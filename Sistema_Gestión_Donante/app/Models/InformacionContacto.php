<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InformacionContacto extends Model
{
    use HasFactory;

    protected $table = 'informacion_contactos';
    
    protected $fillable = [
        'donante_id',
        'nombre_contacto',
        'telefono',
        'relacion'
    ];

    /**
     * Obtener el donante asociado a este contacto
     */
    public function donante(): BelongsTo
    {
        return $this->belongsTo(Donante::class, 'donante_id');
    }
}
