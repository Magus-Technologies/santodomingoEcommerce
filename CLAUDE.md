# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

**ViñaSantoDomingo** — ecommerce de vinos (Perú). Stack: PHP monolítico sin framework, MySQLi, Bootstrap 4, jQuery/AJAX, Vue.js (solo en panel admin). Servido via XAMPP en `http://localhost/public_html/`.

## Local Development

No build step. Editar archivos PHP directamente; recarga de página muestra los cambios.

- **Frontend cliente:** `http://localhost/public_html/CYM/`
- **Panel admin:** `http://localhost/public_html/admin/`
- **Base de datos:** MySQL en `localhost:33068`, base `compuvision`, user `root`, pass `7616`
- **Configuración BD local:** `config/database.php` — detecta automáticamente si es local o producción

## Architecture

### Flujo de datos

```
Browser → CYM/*.php o admin/*.php
              ↓ (AJAX fetch)
          ajax/ajs_*.php   ←→   dao/*Dao.php   ←→   MySQL (MySQLi directo)
              ↓                       ↑
          JSON response           model/*.php (clases POPO con propiedades)
```

Las páginas del frontend consultan datos via AJAX a los handlers en `/ajax/`. Los handlers instancian DAOs que ejecutan SQL directamente con `$this->conexion->query($sql)`. No hay ORM ni prepared statements — SQL concatenado con variables directamente.

### Capas

| Capa | Carpeta | Responsabilidad |
|---|---|---|
| Vistas frontend | `CYM/` | Páginas del cliente (HTML+PHP mezclado) |
| Vistas admin | `admin/` | Panel administrativo (usa Vue.js para tablas/modales) |
| Handlers AJAX | `ajax/` | Reciben POST, devuelven JSON, orquestan DAOs |
| DAOs | `dao/` | Acceso a BD — todas las queries SQL viven aquí |
| Modelos | `model/` | Clases con propiedades (sin lógica, solo estructura) |
| Utils | `utils/` | `Conexion.php` (wrapper MySQLi), `Tools.php` (helpers), `funciones.php` (funciones globales) |
| Config | `config/` | `database.php` (credenciales por ambiente), `urls.php` (URLs base y APIs externas) |
| APIs externas | `extra/` | Clientes para APIs de productos, marcas, categorías, tasa de cambio |
| REST API | `api/` | Endpoints JSON públicos (sin auth): categorías, marcas, productos |
| Auth | `auth/` | Login, registro, logout, reset de contraseña |
| Facturación | `facturacion_santoDomingo/` | Submódulo Laravel separado para facturación electrónica SUNAT |

### Archivos clave

- `utils/Conexion.php` — wrapper de MySQLi, requiere `config/database.php`
- `utils/Tools.php` — helpers de formato (money, fechas, estados de pedido)
- `utils/funciones.php` — funciones PHP globales (helpers de string, arrays)
- `config/urls.php` — URLs base, emails, constantes de APIs externas
- `dao/ProductoDao.php` — DAO más grande (~27KB), contiene todas las queries de productos
- `CYM/checkout.php` — lógica de compra completa (~72KB), incluye Stripe y generación de pedidos
- `ajax/ajs_productos.php` — handler central de operaciones de productos (carrito, listados)

### Patrón DAO

```php
// Instanciar conexión en constructor
$this->conexion = (new Conexion())->getConexion();

// Ejecutar query (sin prepared statements)
$sql = "SELECT * FROM producto WHERE categoria='$categ' AND estado='1'";
return $this->conexion->query($sql);
```

Los DAOs extienden sus modelos: `class ProductoDao extends Producto`.

### Handlers AJAX

Todos siguen este patrón:
```php
session_start();
require "../dao/ProductoDao.php";
$tipo = $_POST['tipo'];  // dispatch por tipo
$respuesta = array("res" => false);
// ... lógica por tipo ...
echo json_encode($respuesta);
```

### Admin panel

Las páginas admin usan **Vue.js 2** directamente en script tags (sin compilación) para manejar tablas con DataTables y modales de CRUD. Hacen fetch a los mismos handlers AJAX que el frontend.

## Convenciones

- Nombres de variables en español (camelCase): `$productoDao`, `$listaCategorias`
- Nombres de columnas BD en español con guiones bajos: `prod_id`, `prod_cod`, `cat_nombre`
- Imágenes de productos: `public/img/prod/`
- Imágenes de banners: `public/img/banner/`
- Imágenes de marcas: `public/img/mar/`
- Estado activo de productos: columna `estado = '1'`
- IDs de categorías: strings de 3 dígitos (`'001'`, `'002'`, etc.)

## Integraciones externas

- **Stripe** — pagos con tarjeta en checkout (`utils/config.php` tiene las keys)
- **PHPMailer** — envío de emails SMTP
- **mPDF / FPDI** — generación de PDFs (boletas, cotizaciones)
- **API DNI/RUC** — consulta de documentos peruanos via `config/urls.php::API_DNI_URL`
- **Facturación electrónica SUNAT** — submódulo Laravel en `facturacion_santoDomingo/` con su propio `CLAUDE.md`
- **Tasa de cambio** — `extra/TasaCambioApi.php`

## Known Issues

- SQL Injection en toda la capa DAO (concatenación directa sin prepared statements)
- APIs REST en `api/` no tienen autenticación
- Algunas secciones del frontend (`CYM/index.php`) tienen HTML estático que no está conectado a la BD aunque el admin sí gestiona esas entidades
