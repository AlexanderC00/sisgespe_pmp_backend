<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    /**
     * Los atributos que se pueden asignar de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'fecha_pedido',
        'estado_pedido',
        'total',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_pedido' => 'datetime',
        'total' => 'decimal:2',
    ];

    /**
     * Relación con el usuario cliente que realizó el pedido.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con los detalles de este pedido (items solicitados).
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }
}

