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
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(40, 10, 'N° pedido', 1, 0, 'C', 1);
    $pdf->cell(40, 10, 'Fecha', 1, 0, 'C', 1);
    $pdf->cell(106, 10, 'Direccion', 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataPedidos as $rowPedidos) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, $pdf->encodeString('Estado de los pedidos: Finalizados'), 1, 1, 'C', 1);
        // Se instancia el módelo Producto para procesar los datos.
        $pedidos = new Pedidos;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($pedidos->setId($rowPedidos['id_pedido']) ) {
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataPedidos = $pedidos->readAllPedidosTrue()) {
                // Se recorren los registros fila por fila.
                foreach ($dataPedidos as $rowPedidos) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(40, 10, $pdf->encodeString($rowPedidos['id_pedido']), 1, 0);
                    $pdf->cell(40, 10, $rowPedidos['fecha_pedido'], 1, 0);
                    $pdf->cell(106, 10, $rowPedidos['direccion_pedido'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay pedidos para estado finalizado'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, $pdf->encodeString('Pedido incorrecto o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay pedidos para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Pedidos finalizado.pdf');
