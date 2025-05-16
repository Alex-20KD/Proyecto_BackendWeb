<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mascotas_donadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donante_id')->constrained('donantes')->onDelete('cascade');
            $table->unsignedBigInteger('mascota_id'); // FK a tabla de mascotas en otro módulo
            $table->date('fecha_donacion');
            $table->text('motivo_donacion');
            $table->string('estado_revision')->default('Pendiente'); // Pendiente, Aceptada, Rechazada
            $table->timestamps();
            
            // Índice para búsquedas rápidas
            $table->index('mascota_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas_donadas');
    }
};
