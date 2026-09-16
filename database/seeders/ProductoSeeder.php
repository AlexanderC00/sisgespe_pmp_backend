<?php

namespace Database\Seeders;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear o actualizar el producto "Chocho"
        $productoChocho = Producto::updateOrCreate(
            ['nombre' => 'Chocho'],
            [
                'descripcion' => 'Producto desaguado, listo para consumo sin ingredientes extras.',
                'precio_venta' => 1.00,
                'unidad_medida' => 'libras',
                'estado' => 'activo',
            ]
        );

        // Crear o actualizar su inventario inicial
        Inventario::updateOrCreate(
            ['producto_id' => $productoChocho->id],
            [
                'cantidad_disponible' => 10,
                'fecha_ingreso' => now(),
            ]
        );
    }
}
