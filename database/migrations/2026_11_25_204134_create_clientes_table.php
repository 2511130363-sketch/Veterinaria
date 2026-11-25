<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dni', 20)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('direccion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['nombres', 'apellidos']);
            $table->index('telefono');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
