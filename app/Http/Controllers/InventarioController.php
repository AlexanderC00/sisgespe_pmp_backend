<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInventarioRequest;
use App\Http\Resources\InventarioResource;
use App\Models\Inventario;
use Illuminate\Http\JsonResponse;

class InventarioController extends Controller
{
    public function index(): JsonResponse
    {
        $inventarios = Inventario::with('producto')->get();

        return response()->json([
            'message' => 'Inventario obtenido exitosamente',
            'data' => InventarioResource::collection($inventarios),
        ]);
    }

    public function update(UpdateInventarioRequest $request, int $id): JsonResponse
    {
        $inventario = Inventario::where('id', $id)
            ->orWhere('producto_id', $id)
            ->first();

        if (!$inventario) {
            return response()->json(['message' => 'Registro de inventario o producto no encontrado'], 404);
        }

        $inventario->update([
            'cantidad_disponible' => $request->validated()['cantidad_disponible'],
            'fecha_ingreso' => now(),
        ]);

        return response()->json([
            'message' => 'Inventario actualizado exitosamente',
            'data' => new InventarioResource($inventario->load('producto')),
        ]);
    }
}
