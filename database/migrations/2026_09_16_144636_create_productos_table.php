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
    Schema::create('productos', function (Blueprint $table) {
        $table->id(); // Crea 'id' como clave primaria automática
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->decimal('precio_venta', 8, 2);
        $table->string('unidad_medida'); // Ej: 'Kg', 'Bandeja'
        $table->enum('estado', ['activo', 'inactivo'])->default('activo');
        $table->timestamps(); // Crea 'created_at' y 'updated_at'
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
