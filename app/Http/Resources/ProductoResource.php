<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio_venta' => (float) $this->precio_venta,
            'unidad_medida' => $this->unidad_medida,
            'estado' => $this->estado,
            'inventario' => new InventarioResource($this->whenLoaded('inventario')),
        ];
    }
}
