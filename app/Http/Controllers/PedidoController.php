<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Models\DetallePedido;
use App\Models\Inventario;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        // Si es admin ve todos, si es cliente solo los suyos
        $pedidos = ($user->rol === 'admin')
            ? Pedido::with(['user', 'detalles.producto'])->latest()->get()
            : Pedido::where('user_id', $user->id)->with('detalles.producto')->latest()->get();

        return response()->json([
            'message' => 'Pedidos obtenidos exitosamente',
            'data' => PedidoResource::collection($pedidos),
        ]);
    }

    public function store(StorePedidoRequest $request): JsonResponse
    {
        $items = $request->validated()['items'];
        $user = $request->user();

        // Validar stock antes de procesar
        foreach ($items as $item) {
            $producto = Producto::with('inventario')->find($item['producto_id']);

            if (!$producto || $producto->estado !== 'activo') {
                return response()->json(['message' => "El producto con ID {$item['producto_id']} no está activo"], 400);
            }

            $stock = $producto->inventario ? $producto->inventario->cantidad_disponible : 0;
            if ($stock < $item['cantidad']) {
                return response()->json([
                    'message' => "Stock insuficiente para '{$producto->nombre}'. Disponible: {$stock}, solicitado: {$item['cantidad']}.",
                ], 400);
            }
        }

        // Crear pedido y descontar stock
        $pedido = DB::transaction(function () use ($user, $items) {
            $nuevoPedido = Pedido::create([
                'user_id' => $user->id,
                'fecha_pedido' => now(),
                'estado_pedido' => 'pendiente',
                'total' => 0,
            ]);

            $total = 0;

            foreach ($items as $item) {
                $producto = Producto::find($item['producto_id']);
                $subtotal = $producto->precio_venta * $item['cantidad'];
                $total += $subtotal;

                DetallePedido::create([
                    'pedido_id' => $nuevoPedido->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario_historico' => $producto->precio_venta,
                ]);

                // Descontar inventario
                Inventario::where('producto_id', $producto->id)
                    ->decrement('cantidad_disponible', $item['cantidad']);
            }

            $nuevoPedido->update(['total' => $total]);

            return $nuevoPedido;
        });

        return response()->json([
            'message' => 'Pedido registrado exitosamente',
            'data' => new PedidoResource($pedido->load(['user', 'detalles.producto'])),
        ], 201);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = $request->user();
        $pedido = Pedido::with('detalles')->find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        // Solo el dueño del pedido o un admin puede borrarlo
        if ($user->rol !== 'admin' && $pedido->user_id !== $user->id) {
            return response()->json(['message' => 'Acceso denegado'], 403);
        }

        // Reintegrar stock al inventario
        if (in_array($pedido->estado_pedido, ['pendiente', 'preparando'])) {
            foreach ($pedido->detalles as $detalle) {
                Inventario::where('producto_id', $detalle->producto_id)
                    ->increment('cantidad_disponible', $detalle->cantidad);
            }
        }

        $pedido->delete();

        return response()->json(['message' => 'Pedido eliminado exitosamente y stock devuelto']);
    }
}
