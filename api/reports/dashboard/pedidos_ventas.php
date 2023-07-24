<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/Subcategoria.php');
require_once('../../entities/dto/pedidos.php');
require_once('../../entities/dto/producto.php');

$subcategoria = new Subcategoria;
// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Ventas de productos por subcategoría');
// Se instancia el módelo Categoría para obtener los datos.

// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataSubcategorias = $subcategoria->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(215, 198, 153);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(80, 10, 'Producto', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Unidades vendidas', 1, 0, 'C', 1);
    $pdf->cell(30, 10, 'Precio unitario', 1, 0, 'C', 1);
    $pdf->cell(36, 10, 'Subtotal (US$)', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataSubcategorias as $rowSubcategoria) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->setFillColor(238, 220, 170);
        $pdf->cell(186, 10, $pdf->encodeString('Subcategoría: ' . $rowSubcategoria['nombre_sub']), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $producto = new Producto;
        $pedido = new Pedidos;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($producto->setSubcategoria($rowSubcategoria['id_subcategoria'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataVentas = $producto->productosVentas()) {
                // Se recorren los registros fila por fila.
                foreach ($dataVentas as $rowDetalle) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(80, 10, $pdf->encodeString($rowDetalle['nombre_producto']), 1, 0);
                    $pdf->cell(40, 10, $rowDetalle['total_cantidad'], 1, 0, 'C');
                    $pdf->cell(30, 10, $pdf->encodeString($rowDetalle['precio_producto']), 1, 0);
                    $pdf->cell(36, 10, $rowDetalle['subtotal'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Categoría incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay categorías para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
