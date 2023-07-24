<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/pedidos.php');

$pedido = new Pedidos;
// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Comprobante de pago');

// Se instancia el módelo Categoría para obtener los datos.

// Se establece un color de relleno para los encabezados.
$pdf->setFillColor(215, 198, 153);
// Se establece la fuente para los encabezados.
$pdf->setFont('Arial', 'B', 11);

// Se imprimen las celdas con los encabezados.
$pdf->cell(86, 10, $pdf->encodeString('Producto'), 1, 0, 'C', 1);
$pdf->cell(20, 10, 'Unidades', 1, 0, 'C', 1);
$pdf->cell(40, 10, 'Precio (US$)', 1, 0, 'C', 1);
$pdf->cell(40, 10, 'Subtotal (US$)', 1, 1, 'C', 1);

// Se establece un color de relleno para mostrar el nombre de la categoría.
$pdf->setFillColor(225);
// Se establece la fuente para los datos de los productos.
$pdf->setFont('Helvetica', '', 11);

// Se instancia el módelo Producto para procesar los datos.
$totalPrecio = 0; // Se inicializa la variable en 0 para guardar datos

// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataVentas = $pedido->comprobanteFactura()) {
    // Se recorren los registros fila por fila.
    foreach ($dataVentas as $rowPedido) {
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(86, 10,$pdf->encodeString( $rowPedido['nombre_producto']), 1, 0);
        $pdf->cell(20, 10, $rowPedido['cantidad_producto'], 1, 0, 'C');
        $pdf->cell(40, 10, $rowPedido['precio_producto'], 1, 0);
        $pdf->cell(40, 10, $rowPedido['Monto_total'], 1, 1);

        $pdf->setFillColor(215, 198, 153);
        $pdf->setFont('Helvetica', 'B', 12);
        $totalPrecio += $rowPedido['Monto_total'];
    }
    
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay productos comprados'), 1, 1);
}
$pdf->cell(86, 10, 'Total Precio (US$)', 1, 0, 'C', 1);
$pdf->cell(100, 10, $totalPrecio, 1, 1, 'C', 1);
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
