# Instrucciones para Mostrar Imágenes de Productos

## Problema
Las imágenes de productos no se muestran correctamente.

## Solución

### 1. Crear el enlace simbólico de storage

Ejecuta el siguiente comando en la terminal desde la raíz del proyecto:

```bash
php artisan storage:link
```

Este comando crea un enlace simbólico desde `public/storage` hacia `storage/app/public`, permitiendo que las imágenes almacenadas sean accesibles públicamente.

### 2. Verificar permisos

Asegúrate de que la carpeta `storage/app/public` tenga permisos de escritura:

**En Windows:**
- Verifica que la carpeta tenga permisos de lectura/escritura

**En Linux/Mac:**
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 3. Verificar que las imágenes se suban correctamente

Cuando subas una imagen desde el panel de administración:
- La imagen se guarda en `storage/app/public/products/`
- El enlace simbólico permite accederla desde `public/storage/products/`

### 4. Si las imágenes aún no se ven

1. Verifica que el archivo existe en `storage/app/public/products/[nombre-archivo]`
2. Verifica que el enlace simbólico existe en `public/storage` (debe ser un enlace, no una carpeta)
3. Limpia la caché:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

### 5. Verificar en la base de datos

El campo `image` en la tabla `products` debe contener solo la ruta relativa, por ejemplo:
- ✅ Correcto: `products/imagen.jpg`
- ❌ Incorrecto: `storage/products/imagen.jpg` o `/storage/products/imagen.jpg`


