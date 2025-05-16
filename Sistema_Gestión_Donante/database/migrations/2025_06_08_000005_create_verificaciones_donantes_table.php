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
        Schema::create('verificaciones_donantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donante_id')->constrained('donantes')->onDelete('cascade');
            $table->date('fecha_verificacion');
            $table->string('resultado'); // Aprobado, Observación, Rechazado
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verificaciones_donantes');
    }
};
