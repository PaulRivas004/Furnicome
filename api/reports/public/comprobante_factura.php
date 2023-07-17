<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/pedidos.php');
require_once('../../entities/dto/producto.php');

$pedido = new Pedidos;
// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Historial de ventas');
// Se instancia el módelo Categoría para obtener los datos.

// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataPedido = $pedido->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Helvetica', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(110, 10, 'Producto', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Unidades vendidas', 1, 0, 'C', 1);
    $pdf->cell(36, 10, 'Subtotal (US$)', 1, 1, 'C', 1);
    $pdf->cell(36, 10, 'Fecha', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataPedido as $rowPedido) {
        // Se instancia el módelo Producto para procesar los datos.
        $producto = new Producto;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($pedido->setId($rowPedido['id_pedido'])) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataVentas = $producto->comprobanteFactura()) {
                // Se recorren los registros fila por fila.
                foreach ($dataVentas as $rowPedido) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(110, 10, $pdf->encodeString($rowPedido['nombre_producto']), 1, 0);
                    $pdf->cell(40, 10, $rowPedido['total_cantidad'], 1, 0);
                    $pdf->cell(36, 10, $rowPedido['subtotal'], 1, 1);
                    $pdf->cell(36, 10, $rowPedido['fecha'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos comprados'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Peoducto incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay productos para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
