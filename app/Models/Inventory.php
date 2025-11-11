<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'current_stock',
        'minimum_stock',
        'maximum_stock',
        'unit',
        'last_restock_date',
    ];

    protected $casts = [
        'current_stock' => 'integer',
        'minimum_stock' => 'integer',
        'maximum_stock' => 'integer',
        'last_restock_date' => 'date',
    ];

    // Relación: Un inventario pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Método helper: Verificar si el stock está bajo
    public function isLowStock()
    {
        return $this->current_stock <= $this->minimum_stock;
    }

    // Método helper: Verificar si está agotado
    public function isOutOfStock()
    {
        return $this->current_stock <= 0;
    }
}