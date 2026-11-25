<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->foreignId('mascota_id')->constrained('mascotas')->cascadeOnDelete();
            $table->foreignId('veterinario_id')->constrained('veterinarios')->cascadeOnDelete();
            $table->date('fecha');
            $table->time('hora');
            $table->text('motivo')->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'atendida', 'cancelada'])->default('pendiente');
            $table->timestamps();

            $table->unique(['veterinario_id', 'fecha', 'hora']);
            $table->index(['fecha', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
