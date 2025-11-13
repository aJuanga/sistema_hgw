# 🔍 CÓMO VER LAS TABLAS EN PGADMIN - GUÍA PASO A PASO

## ✅ ¡BUENAS NOTICIAS!
Tu base de datos **SÍ EXISTE** y tiene **33 TABLAS** creadas. Solo necesitas saber dónde buscarlas en pgAdmin.

## 📍 PASOS PARA VER LAS TABLAS EN PGADMIN

### Paso 1: Conectar al Servidor Correcto

1. Abre **pgAdmin 4**
2. En el panel izquierdo, busca tu servidor PostgreSQL
3. **IMPORTANTE:** Asegúrate de que el puerto sea **5433** (no 5432)
   - Si no ves el servidor, haz clic derecho en "Servers" → "Create" → "Server..."
   - En la pestaña "Connection":
     - Host: `127.0.0.1` o `localhost`
     - Port: **5433** ⚠️ (NO 5432)
     - Username: `postgres`
     - Password: `14107802`

### Paso 2: Expandir la Base de Datos

1. Una vez conectado, expande el servidor (haz clic en la flecha ▶)
2. Expande **"Databases"** (haz clic en la flecha ▶)
3. Busca y expande **"hgw_db"** (haz clic en la flecha ▶)

### Paso 3: Ver las Tablas

1. Expande **"Schemas"** (haz clic en la flecha ▶)
2. Expande **"public"** (haz clic en la flecha ▶)
3. Expande **"Tables"** (haz clic en la flecha ▶)
4. **¡AHÍ ESTÁN!** Deberías ver las 33 tablas

## 📊 ESTRUCTURA EN PGADMIN

```
Servers
  └── PostgreSQL 18 (localhost:5433)  ← Asegúrate del puerto
      └── Databases
          └── hgw_db  ← Tu base de datos
              └── Schemas
                  └── public  ← Esquema por defecto
                      └── Tables  ← ¡AQUÍ ESTÁN LAS TABLAS!
                          ├── allergies
                          ├── categories
                          ├── customers
                          ├── diseases
                          ├── failed_jobs
                          ├── health_profiles
                          ├── products
                          ├── users
                          └── ... (y 24 más)
```

## 🔄 Si NO VES LAS TABLAS

### Opción 1: Refrescar
- Haz clic derecho en "Tables" → "Refresh"

### Opción 2: Verificar el Esquema
- Asegúrate de estar en el esquema **"public"**, no en otro esquema

### Opción 3: Verificar la Base de Datos
- Asegúrate de estar en **"hgw_db"**, no en otra base de datos como "postgres"

### Opción 4: Verificar el Servidor
- Asegúrate de estar conectado al servidor en el puerto **5433**

## 🎯 VERIFICACIÓN RÁPIDA

Ejecuta este comando en la terminal para verificar:

```bash
php verificar_bd.php
```

Este script te mostrará:
- ✅ Si la conexión funciona
- ✅ Qué base de datos estás usando
- ✅ Todas las tablas que existen

## 📝 TABLAS QUE DEBERÍAS VER (33 en total)

1. allergies
2. categories
3. customers
4. diseases
5. failed_jobs
6. health_profile_allergy
7. health_profile_disease
8. health_profiles
9. health_properties
10. inventory
11. inventory_movements
12. migrations
13. notifications
14. order_items
15. order_status_history
16. orders
17. password_reset_tokens
18. payment_methods
19. payments
20. permissions
21. personal_access_tokens
22. product_disease_contraindication
23. product_health_property
24. productos
25. products
26. recommendation_logs
27. recommendations
28. role_permission
29. roles
30. settings
31. suppliers
32. user_role
33. users

## 💡 CONSEJO

Si aún no ves las tablas después de seguir estos pasos:
1. Cierra y vuelve a abrir pgAdmin
2. Verifica que PostgreSQL esté corriendo
3. Ejecuta `php verificar_bd.php` para confirmar que todo está bien

---

**¡No te preocupes!** Todo está funcionando correctamente. Solo necesitas navegar correctamente en pgAdmin. 😊



