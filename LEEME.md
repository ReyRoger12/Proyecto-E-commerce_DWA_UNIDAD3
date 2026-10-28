# Archivos de Julio

Este paquete reúne la parte de ventas, bitácoras e integración. Las carpetas conservan la misma ruta que tienen dentro del proyecto Laravel.

## Contenido principal

- Modelo, migración, controlador, FormRequest y Policy de Venta.
- CRUD completo y vistas de ventas.
- Relaciones con producto, cliente y vendedor.
- Evento `VentaCreada` y listener de la bitácora.
- Configuración de los tres canales en `config/logging.php`.
- `autenticacion.log`, `productos.log` y `ventas.log` con contenido real.
- Relación de categorías mediante productos usando la tabla pivote.
- Rutas, Policies y Seeder principal integrados.
- Pruebas de ventas y de categorías por usuario.
- Capturas relacionadas y reporte PDF.

## Archivos compartidos

Los modelos y migraciones de Usuario, Producto y Categoria se incluyen porque Venta y la relación solicitada dependen de ellos. Estos archivos representan la integración final y se deben comparar antes de mezclarlos con otras ramas.

Este ZIP contiene únicamente la aportación asignada y sus evidencias; no es una instalación independiente de Laravel.
