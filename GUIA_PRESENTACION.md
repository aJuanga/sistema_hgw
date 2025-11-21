# GUÍA PARA PRESENTACIÓN - SISTEMA HGW
**Sistema de Gestión para Empresa de Productos Saludables**

---

## PREPARACIÓN ANTES DE LA PRESENTACIÓN

### 1. Verificar que el servidor está corriendo
```bash
cd C:\Users\JUAN GABRIEL\Desktop\sistema_hgw\sistema_hgw
php artisan serve --port=8001
```

### 2. Abrir navegador
```
http://127.0.0.1:8001
```

### 3. Tener preparadas las credenciales
- **Jefa**: jefa@hgw.com
- **Admin**: admin@hgw.com
- **Empleado**: empleado@hgw.com

---

## FLUJO DE DEMOSTRACIÓN RECOMENDADO

### PARTE 1: INTRODUCCIÓN (2 minutos)

**Qué decir**:
"Buenos días/tardes. El día de hoy les presento el Sistema HGW, un sistema de gestión integral desarrollado en Laravel para una empresa de productos saludables. Este sistema permite gestionar usuarios, productos, inventario, pedidos y reportes con un sistema de roles multinivel."

**Características principales a mencionar**:
- Sistema web desarrollado en Laravel 10
- Base de datos relacional
- Sistema de roles (Jefa, Administrador, Empleado)
- Gestión completa de inventario
- Reportes en PDF y Excel

---

### PARTE 2: LOGIN Y SEGURIDAD (3 minutos)

**Demostración**:
1. Mostrar pantalla de login
2. Intentar acceder sin credenciales (mostrar validación)
3. Iniciar sesión como Jefa

**Qué resaltar**:
- "El sistema cuenta con autenticación segura"
- "Las contraseñas están encriptadas con bcrypt"
- "Validación de formularios en frontend y backend"
- "Protección CSRF en todos los formularios"

**Pantallas a mostrar**:
- `http://127.0.0.1:8001/login`
- Dashboard de Jefa después del login

---

### PARTE 3: SISTEMA DE ROLES (5 minutos)

**Como Jefa - Mostrar**:
1. Dashboard con métricas (ventas, pedidos, usuarios)
2. Menú lateral personalizado color amber/emerald
3. Acceso a todas las funcionalidades

**Qué resaltar**:
- "La Jefa tiene acceso total al sistema"
- "Puede ver métricas en tiempo real"
- "Gestiona todos los usuarios del sistema"
- "Tiene vista de todos los reportes"

**Cerrar sesión y mostrar otro rol**:
1. Logout
2. Login como Administrador
3. Mostrar diferencias en el menú (color blue/indigo)
4. Mostrar que no tiene acceso a gestión de usuarios

**Qué resaltar**:
- "Cada rol tiene un diseño visual diferente"
- "Permisos específicos según el nivel de acceso"
- "Sistema escalable para agregar más roles"

---

### PARTE 4: GESTIÓN DE USUARIOS (5 minutos)

**Volver a login como Jefa**

**Ir a Gestión de Usuarios**: `http://127.0.0.1:8001/users`

**Demostración**:
1. Mostrar listado de usuarios
   - "Aquí vemos todos los usuarios del sistema"
   - Mostrar filtros por rol
   - Mostrar búsqueda

2. Crear nuevo usuario
   - Click en "Nuevo Usuario"
   - Llenar formulario:
     - Nombre: "Juan Pérez"
     - Email: "juan.perez@test.com"
     - Contraseña: "password123"
     - Teléfono: "71234567"
     - Rol: Seleccionar "Empleado"
   - **Mostrar campos dinámicos**: Al seleccionar Empleado aparecen CI y Dirección
   - Llenar: CI "12345678" y Dirección "Zona Sur, La Paz"
   - Guardar

**Qué resaltar**:
- "Validación en tiempo real"
- "Campos condicionales según el rol seleccionado"
- "Solo Jefa puede gestionar usuarios"
- "Fotos de perfil con placeholder de iniciales"

3. Intentar eliminar un usuario
   - Buscar un usuario que tenga pedidos
   - Click en eliminar
   - **Mostrar mensaje de error**: "No se puede eliminar porque tiene pedidos asociados"

**Qué resaltar**:
- "Integridad referencial protegida"
- "Sistema previene eliminación de datos relacionados"

4. Activar/Desactivar usuario
   - Click en botón de estado
   - Mostrar cambio inmediato

5. Protección de Jefa
   - Buscar usuario "Jefa"
   - Mostrar que NO tiene botón de eliminar/desactivar
   - "El sistema protege automáticamente al usuario Jefa"

---

### PARTE 5: GESTIÓN DE PRODUCTOS (5 minutos)

**Ir a Productos**: `http://127.0.0.1:8001/products`

**Demostración**:
1. Mostrar catálogo de productos
   - "Vista tipo tarjetas, diseño atractivo"
   - Mostrar productos con imágenes
   - **Mostrar productos sin imagen**: "Placeholder HGW automático"

2. Crear nuevo producto
   - Click en "Nuevo Producto"
   - Llenar formulario:
     - Nombre: "Jugo Detox Verde"
     - Categoría: Seleccionar "Jugos"
     - Precio: 25.00
     - Tiempo de preparación: 10 minutos
     - Descripción: "Jugo verde rico en antioxidantes"
     - Ingredientes: "Espinaca, pepino, manzana verde, limón"
   - **Marcar propiedades saludables**: Antioxidante, Digestivo
   - **Marcar contraindicaciones**: Diabetes (si aplica)
   - Subir imagen (opcional)
   - Marcar "Disponible" y "Destacado"
   - Guardar

**Qué resaltar**:
- "Relación con múltiples propiedades saludables"
- "Sistema de contraindicaciones por enfermedades"
- "Sincronización automática con inventario"
- "Validación de datos numéricos"

3. Ver detalle de producto
   - Click en un producto
   - Mostrar toda la información organizada
   - Badges de disponibilidad y destacado

4. Editar producto
   - Click en editar
   - Cambiar precio
   - Actualizar imagen
   - Guardar

**Qué resaltar**:
- "Preview de imagen actual antes de cambiar"
- "Formulario pre-llenado con datos existentes"

---

### PARTE 6: INVENTARIO (5 minutos)

**Ir a Inventario**: `http://127.0.0.1:8001/inventory`

**Demostración**:
1. Mostrar tabla de inventario
   - Columnas: Producto, Stock Actual, Stock Mínimo, Stock Máximo
   - **Mostrar alertas de colores**:
     - Rojo: Stock bajo (menos del 20%)
     - Amarillo: Stock medio (20-50%)
     - Verde: Stock bueno

**Qué resaltar**:
- "Sistema de alertas visuales automático"
- "Cálculo de porcentaje de stock"

2. Registrar entrada de stock
   - Click en "Entrada" de algún producto
   - Cantidad: 50
   - Razón: "Compra a proveedor"
   - Guardar

**Qué resaltar**:
- "Registro de movimientos con trazabilidad"
- "Stock se actualiza automáticamente"
- "Validación de cantidades positivas"

3. Registrar salida de stock
   - Click en "Salida"
   - Cantidad: 10
   - Razón: "Ajuste de inventario"
   - Guardar

4. Ver historial de movimientos
   - Click en "Ver Movimientos"
   - Mostrar tabla con:
     - Tipo (Entrada/Salida)
     - Cantidad
     - Stock anterior y nuevo
     - Usuario que registró
     - Fecha

**Qué resaltar**:
- "Auditoría completa de movimientos"
- "Rastro de quién hizo cada cambio"
- "Transparencia total en el inventario"

5. Intentar dejar stock negativo
   - Intentar salida mayor al stock disponible
   - **Mostrar error**: "No se puede registrar, stock insuficiente"

**Qué resaltar**:
- "Protección contra stock negativo"
- "Validación en tiempo real"

---

### PARTE 7: PEDIDOS (6 minutos)

**Ir a Pedidos**: `http://127.0.0.1:8001/orders`

**Demostración**:
1. Mostrar listado de pedidos
   - Tabla con: ID, Cliente, Total, Estado, Pago
   - Badges de colores para estados
   - Filtros por estado

2. Crear nuevo pedido
   - Click en "Nuevo Pedido"
   - Seleccionar cliente del dropdown
   - **Agregar primer producto**:
     - Seleccionar producto (muestra precio y stock)
     - Cantidad: 2
     - Ver que el total se actualiza automáticamente

   - **Agregar segundo producto**:
     - Click en "+ Agregar Producto"
     - Seleccionar otro producto
     - Cantidad: 3
     - Ver total actualizado en tiempo real

   - Llenar campos:
     - Método de pago: Efectivo
     - Estado de pago: Pagado
     - Dirección de entrega: "Calle 21, Sopocachi"
     - Teléfono: "71234567"
     - Notas: "Sin azúcar adicional"

   - **Mostrar total calculado automáticamente**
   - Guardar pedido

**Qué resaltar**:
- "Interfaz dinámica con JavaScript"
- "Cálculo automático de totales"
- "Múltiples productos en un pedido"
- "Validación de stock disponible"
- "Actualización automática de inventario"
- "Asignación de puntos al empleado"

3. Ver detalle de pedido
   - Click en un pedido
   - Mostrar:
     - Información del cliente
     - Lista de productos con cantidades
     - Subtotal, total
     - Estado y método de pago
     - Dirección de entrega

4. Cambiar estado de pedido
   - Desde el listado, cambiar estado
   - De "Pendiente" a "En preparación"
   - De "En preparación" a "Completado"

**Qué resaltar**:
- "Flujo de estados para seguimiento"
- "Actualización inmediata"

---

### PARTE 8: REPORTES (5 minutos)

**Ir a Reportes**: `http://127.0.0.1:8001/reports`

**Demostración**:
1. **Reporte de Inventario**
   - Seleccionar "Reporte de Inventario"
   - Click en "Generar PDF"
   - Mostrar PDF con:
     - Listado de productos
     - Stock actual, mínimo, máximo
     - Estado de alertas
     - Fecha de generación

**Qué resaltar**:
- "Reportes profesionales en PDF"
- "Información actualizada al momento"
- "Listo para imprimir o enviar"

2. **Reporte de Ventas**
   - Seleccionar "Reporte de Ventas"
   - Filtrar por rango de fechas (última semana)
   - Generar Excel
   - Mostrar:
     - Ventas por día
     - Total de ventas
     - Productos más vendidos
     - Métodos de pago utilizados

**Qué resaltar**:
- "Exportación a Excel para análisis"
- "Filtros personalizables"
- "Métricas de negocio"

3. **Reporte Financiero**
   - Seleccionar "Reporte Financiero"
   - Generar PDF
   - Mostrar:
     - Ingresos totales
     - Desglose por método de pago
     - Gráficos (si implementado)

**Qué resaltar**:
- "Visión completa del negocio"
- "Toma de decisiones basada en datos"

---

### PARTE 9: CARACTERÍSTICAS TÉCNICAS (3 minutos)

**Cambiar a vista de código (opcional)**

**Qué mencionar**:

1. **Arquitectura**:
   - "Patrón MVC (Modelo-Vista-Controlador)"
   - "Framework Laravel 10"
   - "Base de datos relacional con migraciones"
   - "ORM Eloquent para consultas"

2. **Seguridad**:
   - "Protección CSRF en todos los formularios"
   - "Validación backend y frontend"
   - "Hash de contraseñas con bcrypt"
   - "Middleware de autenticación y autorización"
   - "Prevención de inyección SQL"

3. **Buenas Prácticas**:
   - "Código organizado y comentado"
   - "Validación de integridad referencial"
   - "Transacciones en operaciones críticas"
   - "Manejo de errores apropiado"
   - "Responsive design con Tailwind CSS"

4. **Funcionalidades Destacadas**:
   - "Sistema de roles multinivel"
   - "Carga dinámica de formularios"
   - "Cálculos en tiempo real"
   - "Alertas visuales inteligentes"
   - "Generación de reportes PDF/Excel"

---

### PARTE 10: CONCLUSIÓN (2 minutos)

**Qué decir**:
"En resumen, el Sistema HGW es una solución completa que permite:

✅ **Gestionar usuarios** con roles y permisos específicos
✅ **Administrar productos** con propiedades y contraindicaciones
✅ **Controlar inventario** con alertas y trazabilidad
✅ **Procesar pedidos** con cálculo automático
✅ **Generar reportes** profesionales para toma de decisiones

Todo esto con:
- **Seguridad robusta**
- **Interfaz intuitiva**
- **Validaciones completas**
- **Diseño responsive**
- **Código mantenible**

El sistema está **100% funcional** y listo para producción."

---

## PREGUNTAS FRECUENTES Y RESPUESTAS

### P: ¿Qué tecnologías utilizaste?
**R**: Laravel 10, PHP 8.2, MySQL, Tailwind CSS, Alpine.js, Blade Templates

### P: ¿Cómo manejas la seguridad?
**R**: Implementé autenticación con Laravel, protección CSRF, validación de datos, middleware de roles y hash de contraseñas con bcrypt.

### P: ¿El sistema es escalable?
**R**: Sí, usa arquitectura MVC, base de datos relacional normalizada, y permite agregar nuevos roles y funcionalidades fácilmente.

### P: ¿Cómo se generan los reportes?
**R**: Utilizo librerías de PHP para generar PDF (DomPDF) y Excel (Maatwebsite), con datos en tiempo real de la base de datos.

### P: ¿Funciona en móvil?
**R**: Sí, es completamente responsive gracias a Tailwind CSS. Funciona en móvil, tablet y escritorio.

### P: ¿Qué pasa si elimino un producto que tiene pedidos?
**R**: El sistema valida la integridad referencial y no permite eliminar productos/usuarios con datos relacionados, mostrando un mensaje de error claro.

### P: ¿Cómo se controla el inventario?
**R**: Cada vez que se crea un pedido, el sistema actualiza automáticamente el inventario. Registra todos los movimientos con fecha, usuario y razón.

### P: ¿Puedo agregar más roles?
**R**: Sí, el sistema está diseñado para ser extensible. Solo necesitas crear el rol en la base de datos y configurar los permisos en el middleware.

---

## TIPS PARA LA PRESENTACIÓN

### ✅ HACER:
- Hablar claro y pausado
- Mostrar confianza en el sistema
- Resaltar las validaciones y seguridad
- Mencionar buenas prácticas aplicadas
- Preparar datos de prueba atractivos
- Tener el sistema corriendo antes de empezar
- Practicar el flujo completo antes

### ❌ NO HACER:
- Ir muy rápido
- Saltarse las validaciones
- Ignorar errores si aparecen (explicarlos)
- Leer el código línea por línea
- Usar datos de prueba poco profesionales (ej: "asdasd")

---

## CHECKLIST FINAL

- [ ] Servidor corriendo en puerto 8001
- [ ] Base de datos con datos de prueba
- [ ] Storage link creado
- [ ] Navegador preparado
- [ ] Credenciales a la mano
- [ ] Esta guía impresa o en otra pantalla
- [ ] Proyector/pantalla funcionando
- [ ] Audio funcionando (si hay video)
- [ ] Plan B si algo falla (tener capturas)

---

## CRONOGRAMA SUGERIDO (35 minutos total)

| Tiempo | Actividad |
|--------|-----------|
| 0-2 min | Introducción y contexto |
| 2-5 min | Login y seguridad |
| 5-10 min | Sistema de roles |
| 10-15 min | Gestión de usuarios |
| 15-20 min | Gestión de productos |
| 20-25 min | Inventario |
| 25-31 min | Pedidos |
| 31-36 min | Reportes |
| 36-39 min | Características técnicas |
| 39-41 min | Conclusión |
| 41-45 min | Preguntas y respuestas |

---

**¡MUCHO ÉXITO EN TU PRESENTACIÓN!** 🚀

El sistema está **100% funcional** y listo para impresionar.
