# Ejemplo de Personalización de Productos

Para agregar opciones de personalización a un producto (por ejemplo, cantidad de azúcar en un jugo verde), actualiza el campo `customization_options` del producto con el siguiente formato JSON:

## Ejemplo: Jugo Verde con opciones de azúcar

```json
[
  {
    "label": "Cantidad de Azúcar",
    "name": "sugar",
    "options": [
      {
        "value": "sin_azucar",
        "label": "Sin azúcar"
      },
      {
        "value": "poca_azucar",
        "label": "Poca azúcar"
      },
      {
        "value": "normal",
        "label": "Azúcar normal"
      },
      {
        "value": "mucha_azucar",
        "label": "Mucha azúcar"
      }
    ]
  }
]
```

## Ejemplo: Café con múltiples opciones

```json
[
  {
    "label": "Tipo de Leche",
    "name": "milk_type",
    "options": [
      {
        "value": "entera",
        "label": "Leche entera"
      },
      {
        "value": "deslactosada",
        "label": "Leche deslactosada"
      },
      {
        "value": "almendra",
        "label": "Leche de almendra"
      },
      {
        "value": "soya",
        "label": "Leche de soya"
      }
    ]
  },
  {
    "label": "Intensidad",
    "name": "intensity",
    "options": [
      {
        "value": "suave",
        "label": "Suave"
      },
      {
        "value": "medio",
        "label": "Medio"
      },
      {
        "value": "fuerte",
        "label": "Fuerte"
      }
    ]
  }
]
```

## Cómo configurar en la base de datos

1. Ve a la tabla `products`
2. Encuentra el producto que quieres personalizar
3. Actualiza el campo `customization_options` con el JSON de arriba
4. Guarda los cambios

## Nota

- El campo `label` es lo que se mostrará al cliente
- El campo `name` es un identificador interno (opcional)
- Cada opción debe tener `value` y `label`
- Las personalizaciones se guardan en el campo `notes` del `order_item`


