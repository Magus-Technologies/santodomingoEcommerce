# Configuración del Proyecto para Ambiente Local

## Cambios Realizados para Localhost

Este documento detalla todos los cambios realizados para convertir el proyecto de URLs de dominio a localhost.

### URLs Actualizadas

#### 1. **Redirecciones Principales**
- `index.php`: `https://viñasantodomingo.com/public_html/CYM` → `http://localhost/public_html/CYM`
- `index_probando.php`: URLs actualizadas a localhost
- `indexss.php`: URLs actualizadas a localhost

#### 2. **Autenticación**
- `auth/logout.php`: Redirección a `http://localhost/public_html/CYM/`
- `auth/reset_password.php`: URLs en emails a `http://localhost/public_html/CYM`
- `auth/promociones.php`: URLs en emails a `http://localhost/public_html/CYM/`
- `auth/avisar_suscripcion.php`: URLs en emails a `http://localhost/public_html/CYM`

#### 3. **Emails**
- `ajax/ajs_compras.php`: URLs en emails de compra a `http://localhost/public_html/CYM/lista_compras_cliente.php`
- Imágenes en emails: Actualizadas a `http://localhost/public_html/public/`

#### 4. **APIs y Servicios**
- `testapi/RestAlmacen.php`: Origin header actualizado a `http://localhost/public_html/testapi/RestAlmacen.php`

### Configuración Centralizada

Se creó un archivo de configuración centralizado en `config/urls.php` que permite:
- Detectar automáticamente si estamos en local o producción
- Definir URLs base dinámicamente
- Centralizar todas las constantes de URLs

**Uso:**
```php
require '../config/urls.php';

// Usar las constantes definidas
echo BASE_URL;      // http://localhost/public_html
echo CYM_URL;       // http://localhost/public_html/CYM
echo EMAIL_EMPRESA; // ventas@viñasantodomingo.com
```

### APIs Externas (Sin Cambios)

Las siguientes APIs externas se mantienen como están (requieren conexión a internet):
- `http://magustechnologies.com:9091/consulta/dni2/` - Consulta de DNI
- `https://magustechnologies.com/api/consulta/ruc/` - Consulta de RUC
- `http://computer.brunoas.com/marcas.php` - Listado de marcas
- `https://magustechnologies.com/factura_santodomingo/datosrec.php` - Datos de facturación

**Nota:** Si necesitas usar estas APIs en local sin conexión a internet, deberás:
1. Crear endpoints locales que repliquen estas APIs
2. Actualizar las URLs en `config/urls.php`
3. Implementar mocks o bases de datos locales

### Estructura de Navegación

El proyecto mantiene la siguiente estructura de navegación:
```
http://localhost/public_html/
├── CYM/                    (Frontend principal)
├── admin/                  (Panel administrativo)
├── auth/                   (Autenticación)
├── ajax/                   (Endpoints AJAX)
├── api/                    (APIs REST)
├── facturacion_santoDomingo/  (Sistema de facturación Laravel)
└── public/                 (Recursos estáticos)
```

### Próximos Pasos

1. **Verificar APIs Externas**: Si necesitas usar las APIs de DNI/RUC, asegúrate de tener conexión a internet
2. **Configurar Base de Datos**: Actualiza la conexión en `utils/Conexion.php` si es necesario
3. **Probar Emails**: Los emails se enviarán a través del servidor configurado en `model/EnvioEmail.php`
4. **Certificados SUNAT**: Para facturación, asegúrate de tener el certificado en `facturacion_santoDomingo/storage/app/sunat/certificados/`

### Archivos Modificados

- ✅ index.php
- ✅ index_probando.php
- ✅ indexss.php
- ✅ auth/logout.php
- ✅ auth/reset_password.php
- ✅ auth/promociones.php
- ✅ auth/avisar_suscripcion.php
- ✅ ajax/ajs_compras.php
- ✅ testapi/RestAlmacen.php
- ✅ config/urls.php (NUEVO)

### Archivos Pendientes de Revisión

Los siguientes archivos contienen referencias a dominios pero pueden no necesitar cambios:
- `fragment/footer_gen.php` - Créditos a magustechnologies.com
- `fragment/content_contac.php` - Email de contacto
- `CYM/` - Múltiples archivos con referencias a VIÑASANTODOMINGO (branding, no URLs)
- `admin/` - Múltiples archivos con referencias a magustechnologies.com

### Revertir a Producción

Para volver a producción, simplemente:
1. Cambiar las URLs en los archivos modificados de `http://localhost/public_html` a `https://viñasantodomingo.com/public_html`
2. O actualizar `config/urls.php` para detectar el ambiente correctamente

---

**Última actualización:** 2026-03-05
**Ambiente:** Local (localhost)
