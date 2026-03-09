# Seguridad de Credenciales - Base de Datos

## Cambios Realizados

Se ha centralizado la configuración de credenciales de base de datos en un archivo único para mejorar la seguridad y mantenibilidad.

### Archivo de Configuración Centralizado

**Ubicación:** `config/database.php`

Este archivo contiene:
- Detección automática de ambiente (local vs producción)
- Definición de constantes de conexión
- Validación de credenciales

```php
// DESARROLLO LOCAL (ACTUALIZADO)
define('DB_HOST', 'localhost:33068');
define('DB_USER', 'root');
define('DB_PASS', '7616');
define('DB_NAME', 'compuvision');

// PRODUCCIÓN (usa variables de entorno)
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));
```

### Archivos Actualizados

✅ **Clases de Conexión:**
- `utils/Conexion.php` - Actualizada para usar `config/database.php`
- `utils/Conexion2.php` - Actualizada para usar `config/database.php`

✅ **Archivos de Configuración:**
- `testapi/BD.php` - Ahora importa `config/database.php`
- `server-side/serverside.php` - Ahora importa `config/database.php`
- `public/librorec/BD.php` - Pendiente de actualizar (requiere ajuste de rutas)

### Credenciales Encontradas

Durante la auditoría se encontraron las siguientes credenciales hardcodeadas:

| Archivo | Usuario | Contraseña | Base de Datos |
|---------|---------|-----------|---------------|
| utils/Conexion.php | root | c4alab4az5% | compuvision |
| utils/Conexion2.php | root | c4p1cu4$ | compuvision |
| testapi/BD.php | root | c4alab4az5% | compuvision |
| server-side/serverside.php | root | c4alab4az5% | compuvision |
| public/librorec/BD.php | root | c4p1cu4%%$ | compuvision |

### Recomendaciones de Seguridad

1. **Para Producción:**
   - NO incluir `config/database.php` en el repositorio
   - Usar variables de entorno del servidor
   - Cambiar contraseñas de base de datos
   - Usar usuarios con permisos limitados

2. **Para Desarrollo Local:**
   - Mantener `config/database.php` en `.gitignore`
   - Crear `.env.example` con placeholders
   - Documentar las credenciales locales en README

3. **Próximos Pasos:**
   - Crear `.env.example` con estructura de variables
   - Implementar carga de `.env` con `vlucas/phpdotenv`
   - Auditar otros archivos con credenciales hardcodeadas

### Archivos a Revisar Manualmente

Los siguientes archivos contienen referencias que pueden necesitar actualización:
- `model/EnvioEmail.php` - Credenciales SMTP comentadas
- `CYM/checkout.php` - URLs de logos
- `admin/productos_pc_armada_add.php` - URLs de imágenes

### Cómo Usar en Producción

1. Crear archivo `.env` en la raíz del proyecto:
```
DB_HOST=tu-servidor.com
DB_USER=usuario_produccion
DB_PASS=contraseña_segura
DB_NAME=base_datos_produccion
```

2. Actualizar `config/database.php` para cargar desde `.env`:
```php
require_once __DIR__ . '/../.env';
```

3. Asegurar que `.env` NO esté en el repositorio (agregar a `.gitignore`)

---

**Última actualización:** 2026-03-05
**Estado:** Parcialmente completado - Requiere finalización de archivos pendientes
