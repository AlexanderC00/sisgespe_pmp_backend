<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    /**
     * Los atributos que se pueden asignar de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_venta',
        'unidad_medida',
        'estado',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio_venta' => 'decimal:2',
    ];

    /**
     * Relación con el registro de inventario (un producto tiene un registro de inventario).
     */
    public function inventario(): HasOne
    {
        return $this->hasOne(Inventario::class, 'producto_id');
    }

    /**
     * Relación con los detalles de pedido en los que aparece este producto.
     */
    public function detallePedidos(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'producto_id');
    }
}

