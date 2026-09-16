<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventarioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'producto_id' => $this->producto_id,
            'cantidad_disponible' => $this->cantidad_disponible,
            'fecha_ingreso' => $this->fecha_ingreso?->toDateTimeString(),
            'producto' => new ProductoResource($this->whenLoaded('producto')),
        ];
    }
}
