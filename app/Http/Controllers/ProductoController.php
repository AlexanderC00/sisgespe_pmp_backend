<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;

class ProductoController extends Controller
{
    public function index(): JsonResponse
    {
        $productos = Producto::with('inventario')->get();

        return response()->json([
            'message' => 'Productos obtenidos exitosamente',
            'data' => ProductoResource::collection($productos),
        ]);
    }

    public function store(StoreProductoRequest $request): JsonResponse
    {
        $producto = Producto::create($request->validated());

        // Stock inicial en 0
        $producto->inventario()->create([
            'cantidad_disponible' => 0,
            'fecha_ingreso' => now(),
        ]);

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'data' => new ProductoResource($producto->load('inventario')),
        ], 201);
    }

    public function destroy(int $id): JsonResponse
    {
        $producto = Producto::with(['inventario', 'detallePedidos'])->find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        // Si tiene pedidos no se elimina
        if ($producto->detallePedidos()->count() > 0) {
            return response()->json([
                'message' => 'No se puede eliminar el producto porque ya tiene pedidos registrados.',
            ], 400);
        }

        // Si tiene stock no se elimina
        $stock = $producto->inventario ? $producto->inventario->cantidad_disponible : 0;
        if ($stock > 0) {
            return response()->json([
                'message' => "No se puede eliminar el producto porque aún tiene {$stock} unidades en inventario. Debe agotarlo primero.",
            ], 400);
        }

        if ($producto->inventario) {
            $producto->inventario->delete();
        }
        $producto->delete();

        return response()->json(['message' => 'Producto eliminado exitosamente']);
    }
}
