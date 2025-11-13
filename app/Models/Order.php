<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'user_id',
        'payment_method_id',
        'delivery_type',
        'status',
        'subtotal',
        'tax',
        'total',
        'estimated_time',
        'notes',
        'delivered_at',
        'completed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'estimated_time' => 'integer',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // Relación: Un pedido pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un pedido pertenece a un método de pago
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    // Relación: Un pedido tiene muchos items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relación: Un pedido tiene muchos cambios de estado
    public function statusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    // Relación: Un pedido tiene muchos pagos
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relación: Un pedido tiene movimientos de inventario
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
}