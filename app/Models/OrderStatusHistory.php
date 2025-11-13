<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'order_status_history';

    protected $fillable = [
        'order_id',
        'status',
        'changed_by',
        'notes',
    ];

    // Relación: Un historial pertenece a un pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relación: Un historial fue registrado por un usuario
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}