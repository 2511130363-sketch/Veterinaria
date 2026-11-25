<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('especie');
            $table->string('raza')->nullable();
            $table->enum('sexo', ['macho', 'hembra'])->default('macho');
            $table->date('fecha_nacimiento')->nullable();
            $table->decimal('peso', 6, 2)->nullable();
            $table->string('color')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['nombre', 'especie']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
