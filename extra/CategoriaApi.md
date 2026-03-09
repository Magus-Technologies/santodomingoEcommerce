# CategoriaApi — Documentación

## Descripción

Clase que obtiene el listado de categorías activas desde el sistema de facturación (Laravel) para usarlas en el panel admin del ecommerce.

## Fuente de datos

| Campo | Valor |
|---|---|
| Sistema | `facturacion_santoDomingo` (Laravel 12) |
| Base de datos | `factura_santoD` |
| Tabla | `categorias` |
| Host | `localhost:33068` |
| Usuario | `root` |

## Endpoint equivalente (no usado)

```
GET http://localhost:8000/api/categorias
```

Requiere `auth:sanctum` — por eso se consulta directo a BD en lugar de HTTP.

## Métodos

### `getLista()`

Retorna todas las categorías con `estado = '1'`, ordenadas por nombre.

**Retorna:**
```php
[
    ['cod_sub1' => 1, 'nom_sub1' => 'Vinos Tintos'],
    ['cod_sub1' => 2, 'nom_sub1' => 'Vinos Blancos'],
    ...
]
```

- `cod_sub1` → `id` de la tabla `categorias`
- `nom_sub1` → `nombre` de la tabla `categorias`

Estas claves son compatibles con el dropdown del panel `admin/categorias.php`.

### `getData($codigo)`

Consulta una categoría por código desde la tabla `sopsub1` (legado, no migrada).

## Flujo completo

```
factura_santoD.categorias
        ↓  CategoriaApi::getLista()
ajax/ajs_categoria.php (tipo: 'lis')
        ↓
Dropdown "Categorías sin agregar" en admin/categorias.php
        ↓  Al agregar
compuvision.grupo_seleccion (con imagen y nombre web)
        ↓
CYM/index.php — sección "Nuestra Selección" (home)
```
