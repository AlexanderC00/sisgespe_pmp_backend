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
    Schema::create('pedidos', function (Blueprint $table) {
        $table->id();
        // Relación con la tabla de usuarios (Laravel por defecto usa 'users')
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->dateTime('fecha_pedido');
        $table->enum('estado_pedido', ['pendiente', 'preparando', 'entregado', 'cancelado'])->default('pendiente');
        $table->decimal('total', 10, 2)->default(0.00);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
