<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'fecha_pedido' => $this->fecha_pedido?->toDateTimeString(),
            'estado_pedido' => $this->estado_pedido,
            'total' => (float) $this->total,
            'cliente' => new UserResource($this->whenLoaded('user')),
            'detalles' => DetallePedidoResource::collection($this->whenLoaded('detalles')),
        ];
    }
}
