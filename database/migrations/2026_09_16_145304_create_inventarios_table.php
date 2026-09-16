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
    Schema::create('inventarios', function (Blueprint $table) {
        $table->id();
        // Relación escalable con productos (si borras un producto, se borra su stock)
        $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
        $table->integer('cantidad_disponible')->default(0);
        $table->timestamp('fecha_ingreso')->useCurrent();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
