<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'previous_stock',
        'new_stock',
        'user_id',
        'order_id',
        'reason',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'previous_stock' => 'decimal:2',
        'new_stock' => 'decimal:2',
    ];

    // Relación: Un movimiento pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación: Un movimiento fue registrado por un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un movimiento puede estar relacionado con un pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}