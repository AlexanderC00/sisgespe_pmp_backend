<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetallePedidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'producto_id' => $this->producto_id,
            'cantidad' => $this->cantidad,
            'precio_unitario_historico' => (float) $this->precio_unitario_historico,
            'subtotal' => (float) ($this->cantidad * $this->precio_unitario_historico),
            'producto' => new ProductoResource($this->whenLoaded('producto')),
        ];
    }
}
