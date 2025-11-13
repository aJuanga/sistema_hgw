<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';  // ← LÍNEA NUEVA AGREGADA

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'ingredients',
        'price',
        'image',
        'is_available',
        'is_featured',
        'preparation_time',
        'customization_options',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'preparation_time' => 'integer',
        'customization_options' => 'array',
    ];

    // Relación: Un producto pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación: Un producto tiene muchas propiedades saludables
    public function healthProperties()
    {
        return $this->belongsToMany(HealthProperty::class, 'product_health_property')
                    ->withTimestamps();
    }

    // Relación: Un producto tiene muchas enfermedades contraindicadas
    public function contraindicatedDiseases()
    {
        return $this->belongsToMany(Disease::class, 'product_disease_contraindication')
                    ->withPivot('reason')
                    ->withTimestamps();
    }

    // Relación: Un producto tiene un registro de inventario
    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    // Relación: Un producto tiene muchos movimientos de inventario
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    // Relación: Un producto aparece en muchos items de pedidos
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relación: Un producto tiene muchas valoraciones
    public function ratings()
    {
        return $this->hasMany(ProductRating::class);
    }

    // Relación: Un producto tiene muchas recomendaciones
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}