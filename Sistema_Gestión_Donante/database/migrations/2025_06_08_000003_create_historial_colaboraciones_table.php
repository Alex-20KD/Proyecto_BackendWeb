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
        Schema::create('historial_colaboraciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donante_id')->constrained('donantes')->onDelete('cascade');
            $table->string('tipo_colaboracion'); // Mascota, Económica, Voluntariado, etc.
            $table->text('descripcion');
            $table->date('fecha_colaboracion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_colaboraciones');
    }
};
