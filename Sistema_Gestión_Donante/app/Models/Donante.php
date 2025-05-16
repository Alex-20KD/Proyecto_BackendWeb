<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donante extends Model
{
    use HasFactory;

    protected $table = 'donantes';
    
    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
        'direccion',
        'tipo_documento',
        'numero_documento',
        'fecha_registro',
        'estado'
    ];

    protected $casts = [
        'fecha_registro' => 'date',
    ];

    /**
     * Obtener las mascotas donadas por este donante
     */
    public function mascotasDonadas(): HasMany
    {
        return $this->hasMany(MascotaDonada::class, 'donante_id');
    }

    /**
     * Obtener el historial de colaboraciones del donante
     */
    public function historialColaboraciones(): HasMany
    {
        return $this->hasMany(HistorialColaboracion::class, 'donante_id');
    }

    /**
     * Obtener los contactos de emergencia del donante
     */
    public function informacionContactos(): HasMany
    {
        return $this->hasMany(InformacionContacto::class, 'donante_id');
    }

    /**
     * Obtener las verificaciones del donante
     */
    public function verificaciones(): HasMany
    {
        return $this->hasMany(VerificacionDonante::class, 'donante_id');
    }
}
