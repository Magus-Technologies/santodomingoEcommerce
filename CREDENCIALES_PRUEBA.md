# 🔐 Credenciales de Prueba

## Usuarios de Prueba Disponibles

### 1. Usuario Regular
```
Email:      test@test.com
Contraseña: test123456
Tipo:       Usuario Regular
Estado:     Activo
```

**Acceso:**
- Frontend: http://localhost/public_html/CYM/login.php
- Carrito de compras
- Historial de pedidos
- Perfil de usuario

### 2. Usuario Administrador
```
Email:      admin@test.com
Contraseña: admin123456
Tipo:       Administrador
Estado:     Activo
```

**Acceso:**
- Panel Administrativo: http://localhost/public_html/admin/
- Gestión de productos
- Gestión de pedidos
- Gestión de usuarios
- Reportes

## Base de Datos

```
Host:     localhost:33068
Usuario:  root
Password: 7616
BD:       compuvision
```

## Crear Usuarios de Prueba

### Opción 1: Automático (Recomendado)

Accede a estos scripts para crear usuarios automáticamente:

1. **Usuario Regular:**
   ```
   http://localhost/public_html/crear_usuario_test.php
   ```

2. **Usuario Administrador:**
   ```
   http://localhost/public_html/crear_admin_test.php
   ```

### Opción 2: Manual (SQL)

Si prefieres crear usuarios manualmente, ejecuta estas consultas:

**Usuario Regular:**
```sql
INSERT INTO usuarios (email, password, nombres, apellidos, documento, telefono, estado, fecha_registro) 
VALUES ('test@test.com', '$2y$10$...', 'Usuario', 'Test', '12345678', '999999999', 1, NOW());
```

**Usuario Administrador:**
```sql
INSERT INTO usuarios (email, password, nombres, apellidos, documento, telefono, estado, fecha_registro) 
VALUES ('admin@test.com', '$2y$10$...', 'Administrador', 'Test', '87654321', '999999998', 1, NOW());
```

## Flujo de Prueba Recomendado

### 1. Crear Usuarios
- [ ] Acceder a `crear_usuario_test.php`
- [ ] Acceder a `crear_admin_test.php`

### 2. Probar Frontend
- [ ] Acceder a http://localhost/public_html/CYM/
- [ ] Login con test@test.com / test123456
- [ ] Explorar catálogo
- [ ] Agregar productos al carrito
- [ ] Realizar compra

### 3. Probar Admin
- [ ] Acceder a http://localhost/public_html/admin/
- [ ] Login con admin@test.com / admin123456
- [ ] Gestionar productos
- [ ] Ver pedidos
- [ ] Ver usuarios

### 4. Probar Facturación
- [ ] Acceder a http://localhost/public_html/facturacion_santoDomingo/public/
- [ ] Crear empresa
- [ ] Generar factura
- [ ] Enviar a SUNAT (modo BETA)

## Información Adicional

### Tabla de Usuarios
- Tabla: `usuarios`
- Campos principales: `use_id`, `email`, `password`, `nombres`, `apellidos`, `documento`, `telefono`, `estado`
- Contraseñas: Hasheadas con bcrypt

### Roles y Permisos
- Los roles se definen en la tabla `roles`
- Los permisos se definen en la tabla `permissions`
- La relación usuario-rol está en `user_roles`

### Seguridad
- Las contraseñas están hasheadas con bcrypt
- No se almacenan contraseñas en texto plano
- Cada usuario tiene un ID único

## Cambiar Contraseña

Para cambiar la contraseña de un usuario, ejecuta:

```sql
UPDATE usuarios 
SET password = '$2y$10$...' 
WHERE email = 'test@test.com';
```

Donde `$2y$10$...` es el hash bcrypt de la nueva contraseña.

## Eliminar Usuarios de Prueba

Si necesitas eliminar los usuarios de prueba:

```sql
DELETE FROM usuarios WHERE email IN ('test@test.com', 'admin@test.com');
```

## Notas Importantes

1. **Desarrollo Local:** Usa estas credenciales solo en desarrollo
2. **Producción:** Crea usuarios reales con contraseñas seguras
3. **Seguridad:** Nunca compartas credenciales en repositorios públicos
4. **Backup:** Realiza backup antes de hacer cambios en usuarios

---

**Última actualización:** 2026-03-05
**Estado:** ✅ Listo para usar
