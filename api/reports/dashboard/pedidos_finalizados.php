<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/pedidos.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Pedidos con estado en finalizados');
// Se instancia el módelo Categoría para obtener los datos.
$pedidos = new Pedidos;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataPedidos = $pedidos->readAllPedidosTrue()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(215, 198, 153);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(40, 10, $pdf->encodeString('N° pedido'), 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Fecha', 1, 0, 'C', 1);
    $pdf->cell(106, 10, $pdf->encodeString('Dirección'), 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(215, 198, 153);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Helvetica', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataPedidos as $rowPedidos) {
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(40, 10, $pdf->encodeString($rowPedidos['id_pedido']), 'B', 0, 'C');
        $pdf->cell(40, 10, $rowPedidos['fecha_pedido'], 1, 0, 'C');
        $pdf->cell(106, 10, $pdf->encodeString($rowPedidos['direccion_pedido']), 'B', 1);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay pedidos para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Pedidos finalizado.pdf');
