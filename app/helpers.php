<?php

if (!function_exists('product_image_url')) {
    /**
     * Obtiene la URL de la imagen del producto o un placeholder
     */
    function product_image_url($imagePath)
    {
        if (!$imagePath) {
            return asset('images/placeholder-product.png');
        }
        
        $fullPath = storage_path('app/public/' . $imagePath);
        
        if (file_exists($fullPath)) {
            return asset('storage/' . $imagePath);
        }
        
        return asset('images/placeholder-product.png');
    }
}


