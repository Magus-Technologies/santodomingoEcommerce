# Bugs Conocidos y Correcciones Post-Pull

Este archivo documenta los problemas encontrados en la integración entre el eCommerce (PHP/compuvision) y el sistema de facturación (Laravel/factura_santod3). **Aplicar estas correcciones después de cada `git pull`.**

---

## BUG 1 — Marcas no aparecen en el sidebar de `shop-list-prod.php`

**Síntoma:**
`GET http://localhost:8000/api/public/marcas` devuelve `{"success":true,"data":[]}` — lista vacía.

**Causa:**
La tabla `factura_santod3.marcra_productos` tiene todas las marcas con `estado = '0'`. El endpoint público filtra solo `estado = '1'`.

**Corrección — ejecutar en la BD `factura_santod3`:**
```sql
UPDATE marcra_productos SET estado = '1';
```

**O via artisan (desde `facturacion_santoDomingo/`):**
```bash
php artisan tinker --execute="DB::table('marcra_productos')->update(['estado' => '1']);"
```

---

## BUG 2 — Filtro por marcas no filtra productos

**Síntoma:**
Seleccionar una marca en el sidebar no devuelve ningún producto aunque las marcas sí aparecen.

**Causa:**
Todos los productos en `factura_santod3.productos` tienen `marca_id = NULL`. El filtro en `ShopProductosController` hace `WHERE marca_id = ?` y no encuentra nada.

**Corrección:**
Asignar marcas a los productos desde el panel admin de Laravel: `http://localhost:8000` → Almacén → editar cada producto → campo Marca.

**No hay fix automático** — requiere asignación manual de marca por producto.

---

## BUG 3 — Carrito vacío (`[]`) para usuarios logueados

**Síntoma:**
- Usuario logueado agrega productos desde `shop-list-prod.php`.
- Al ir a `shop-cart.php` el carrito aparece vacío.
- `ajax/ajs_productos.php` devuelve `[]`.
- En consola: `Fatal error: Uncaught mysqli_sql_exception: Cannot add or update a child row: a foreign key constraint fails (compuvision.carrito_compra, CONSTRAINT carrito_compra_ibfk_2 FOREIGN KEY (prod_id) REFERENCES producto (prod_id))`

**Causa:**
`shop-list-prod.php` muestra productos de la API Laravel (`factura_santod3.productos`, IDs: `id_producto`). La tabla `compuvision.carrito_compra` tiene una FK que solo acepta `prod_id` de `compuvision.producto`. Los IDs de Laravel no existen en `compuvision.producto` → el INSERT falla → el carrito nunca se guarda en BD → al recargar devuelve `[]`.

> **Nota:** Para usuarios NO logueados el carrito funciona perfectamente vía `localStorage` — este bug solo afecta a usuarios logueados.

**Corrección — ejecutar UNA sola vez en la BD `compuvision`:**
```sql
ALTER TABLE carrito_compra DROP FOREIGN KEY carrito_compra_ibfk_2;
```

**Script PHP temporal** (crear, abrir en browser, eliminar):
```php
<?php
require_once "config/database.php";
$hostPort = explode(':', DB_HOST);
$conn = new mysqli($hostPort[0], DB_USER, DB_PASS, DB_NAME, (int)($hostPort[1] ?? 3306));
$fks = $conn->query("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA='compuvision' AND TABLE_NAME='carrito_compra' AND CONSTRAINT_NAME LIKE '%ibfk%'");
while ($row = $fks->fetch_assoc()) {
    $conn->query("ALTER TABLE carrito_compra DROP FOREIGN KEY {$row['CONSTRAINT_NAME']}");
    echo "FK eliminado: {$row['CONSTRAINT_NAME']}\n";
}
$conn->close();
```

**Adicionalmente**, modificar `ajax/ajs_productos.php`:

**1. Agregar `require "../config.php"` al inicio** (para tener `API_URL`):
```php
<?php
session_start();
require "../config.php";   // ← AGREGAR esta línea
require "../dao/ProductoDao.php";
```

**2. Reemplazar el bloque `usr_crd_svd`** — validar contra ambas BDs antes de insertar:
```php
} elseif ($tipo == 'usr_crd_svd') {
    $listaCrrito = json_decode($_POST['car'], true);
    $sql = "DELETE FROM carrito_compra WHERE usuario_id = '{$_SESSION['usuario']}';";
    $productoDao->exeSQL($sql);
    foreach ($listaCrrito as $car) {
        $chk = $productoDao->exeSQL("SELECT prod_id FROM producto WHERE prod_id='{$car['prod']}'");
        $validProduct = $chk && $chk->num_rows > 0;
        if (!$validProduct) {
            $chkLr = $productoDao->exeSQL("SELECT id_producto FROM factura_santod3.productos WHERE id_producto='{$car['prod']}'");
            $validProduct = $chkLr && $chkLr->num_rows > 0;
        }
        if ($validProduct) {
            $sql = "INSERT INTO carrito_compra SET usuario_id='{$_SESSION['usuario']}',prod_id='{$car['prod']}',cantidad='{$car['cantidad']}'";
            $productoDao->exeSQL($sql);
        }
    }
```

**3. Reemplazar el bloque `usr_crd_lts`** — LEFT JOIN + fallback a Laravel:
```php
} elseif ($tipo == 'usr_crd_lts') {
    $productosApi = new ProductosApi();
    $sql = "SELECT cr.cantidad, cr.carrito_id, cr.prod_id,
               COALESCE(p.prod_cod, '') AS prod_cod,
               COALESCE(p.nombre, lp.nombre, '') AS nombre
            FROM carrito_compra AS cr
            LEFT JOIN producto p ON p.prod_id = cr.prod_id
            LEFT JOIN factura_santod3.productos lp ON lp.id_producto = cr.prod_id
            WHERE cr.usuario_id='{$_SESSION['usuario']}'";
    $result = $productoDao->exeSQL($sql);
    $respuesta = [];
    foreach ($result as $row) {
        $conRay = !empty($row['prod_cod']) ? $productosApi->getDataProd($row['prod_cod'], "") : [];
        if (!empty($conRay)) {
            $row['precio'] = $conRay['precio_venta'];
            $row['stock']  = $conRay['stock'];
        } else {
            $sqlLr = "SELECT precio, cantidad FROM factura_santod3.productos WHERE id_producto = '{$row['prod_id']}'";
            $resLr = $productoDao->exeSQL($sqlLr);
            if ($rowLr = $resLr->fetch_assoc()) {
                $row['precio'] = $rowLr['precio'];
                $row['stock']  = $rowLr['cantidad'];
            } else {
                $row['precio'] = 0;
                $row['stock']  = 0;
            }
        }
        $sql2 = "SELECT * FROM ofertas_productos WHERE fecha_termino >= NOW() AND producto_id = " . $row['prod_id'];
        $result3 = $productoDao->exeSQL($sql2);
        if ($result3->num_rows > 0) {
            foreach ($result3 as $nuevoPrecioOferta) {
                $row['precio'] = $nuevoPrecioOferta['precio_oferta'];
            }
        }
        $result2 = $productoDao->exeSQL("SELECT * FROM producto_foto WHERE prod_id = '{$row['prod_id']}' LIMIT 1");
        $row['imagen'] = '';
        if ($img = $result2->fetch_assoc()) {
            $row['imagen'] = $img['imagen_url'];
        }
        if (empty($row['imagen'])) {
            $sqlImg = "SELECT imagen FROM factura_santod3.productos WHERE id_producto = '{$row['prod_id']}'";
            $resImg = $productoDao->exeSQL($sqlImg);
            if ($rowImg = $resImg->fetch_assoc()) {
                $row['imagen'] = $rowImg['imagen'] ? API_URL . '/storage/' . $rowImg['imagen'] : '';
            }
        }
        $respuesta[] = $row;
    }
```

---

## BUG 4 — Imagen del producto en carrito da 404

**Síntoma:**
```
GET http://localhost/demo/public_html/CYM/productos/1773835066_Captura...png 404 (Not Found)
```

**Causa:**
`ShopProductosController` devuelve `imagen1` como nombre de archivo relativo (ej: `1773835066_foto.png`). `shop-cart.php` lo concatena como `../public/img/productos/` + filename, pero esas imágenes están en el storage de Laravel (`http://localhost:8000/storage/`).

**Corrección — en `facturacion_santoDomingo/app/Http/Controllers/Api/ShopProductosController.php`:**
```php
// Cambiar línea:
'imagen1'  => $prod->imagen ?? null,

// Por:
'imagen1'  => $prod->imagen ? asset('storage/' . $prod->imagen) : null,
```

Esto hace que la API devuelva la URL completa (`http://localhost:8000/storage/archivo.png`) y el template de `shop-cart.php` la detecta como URL absoluta (`startsWith('http')`) y la usa directamente.

---

## BUG 5 — Imágenes no aparecen en las tarjetas de `shop-list-prod.php`

**Síntoma:**
Las tarjetas de producto en el shop muestran imágenes rotas. En el carrito sí aparecen.

**Causa:**
`ShopProductosController` devuelve `imagen1` como URL completa (`http://localhost:8000/storage/archivo.png`). El template de `shop-list-prod.php` la prefija con `API_URL + '/storage/'`, resultando en URL duplicada:
```
http://localhost:8000/storage/http://localhost:8000/storage/archivo.png
```
El carrito sí funciona porque su template usa `startsWith('http')` para detectar URLs absolutas.

**Corrección — en `CYM/shop-list-prod.php`:**
```html
<!-- Cambiar: -->
<img :src="item.imagen1 ? '<?= API_URL ?>/storage/'+item.imagen1 : ''" :alt="item.nombre">

<!-- Por: -->
<img :src="item.imagen1 ? (item.imagen1.startsWith('http') ? item.imagen1 : '<?= API_URL ?>/storage/'+item.imagen1) : ''" :alt="item.nombre">
```

---

## Resumen de archivos a modificar post-pull

| Archivo | Tipo de cambio |
|---|---|
| `compuvision.carrito_compra` | DROP FOREIGN KEY `carrito_compra_ibfk_2` (BD, una sola vez) |
| `factura_santod3.marcra_productos` | UPDATE `estado = '1'` (BD, una sola vez) |
| `ajax/ajs_productos.php` | Agregar `require "../config.php"` + reemplazar bloques `usr_crd_svd` y `usr_crd_lts` |
| `facturacion_santoDomingo/app/Http/Controllers/Api/ShopProductosController.php` | Cambiar `imagen1` para devolver URL completa con `asset()` |
| `CYM/shop-list-prod.php` | Proteger `imagen1` con `startsWith('http')` antes de prefijar `/storage/` |
