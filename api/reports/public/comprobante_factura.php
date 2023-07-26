<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/pedidos.php');

$pedido = new Pedidos;
// Se instancia la clase para crear el reporte.
$pdf = new Report;

// ...


// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Comprobante de pago');

// Se establece un color de relleno para mostrar los datos del cliente.
$pdf->setFillColor(225);
// Se establece la fuente para los datos del cliente.
$pdf->setFont('Helvetica', '', 11);

// Se instancia el modelo Pedidos para obtener los datos.
if ($dataVentas = $pedido->comprobanteFactura()) {
    $clienteData = $pedido->InfoClienteFactura(); // Se obtiene la información del cliente una vez
    if ($clienteData) {
        // Se imprime el cuadro de texto con los datos del cliente.
        $pdf->MultiCell(186, 10, 
            'Cliente: ' . $pdf->encodeString($clienteData['nombre_cliente']) . "\n" .
            'Direccion: ' . $clienteData['direccion_pedido'] . "\n" .
            'Fecha del pedido: ' . $clienteData['fecha_pedido'],
            0, 'L', 0,
            'R', 'L', false);
        
        // Salto de línea para separar el cuadro de texto del detalle de los productos.
        $pdf->Ln(5);

        // Se establece un color de relleno para los encabezados de los productos.
        $pdf->setFillColor(215, 198, 153);
        // Se establece la fuente para los encabezados de los productos.
        $pdf->setFont('Arial', 'B', 11);

        // Se imprimen las celdas con los encabezados de los productos.
        $pdf->cell(86, 10, $pdf->encodeString('Producto'), 1, 0, 'C', 1);
        $pdf->cell(20, 10, 'Unidades', 1, 0, 'C', 1);
        $pdf->cell(40, 10, 'Precio (US$)', 1, 0, 'C', 1);
        $pdf->cell(40, 10, 'Subtotal (US$)', 1, 1, 'C', 1);

        // Se establece la fuente para los datos de los productos.
        $pdf->setFont('Helvetica', '', 11);

        $totalPrecio = 0; // Se inicializa la variable en 0 para guardar datos

        // Se recorren los registros fila por fila.
        foreach ($dataVentas as $rowPedido) {
            // Se imprimen las celdas con los datos de los productos.
            $pdf->cell(86, 10, $pdf->encodeString($rowPedido['nombre_producto']), 1, 0);
            $pdf->cell(20, 10, $rowPedido['cantidad_producto'], 1, 0, 'C');
            $pdf->cell(40, 10, $rowPedido['precio_producto'], 1, 0);
            $pdf->cell(40, 10, $rowPedido['Monto_total'], 1, 1);
            $pdf->setFillColor(215, 198, 153);
            $pdf->setFont('Helvetica', 'B', 12);
            $totalPrecio += $rowPedido['Monto_total'];
        }
    } else {
        // Si no se encontraron datos del cliente, se imprime un mensaje.
        $pdf->cell(0, 10, $pdf->encodeString('Cliente no encontrado'), 1, 1);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay productos comprados'), 1, 1);
}

// Se imprime la celda con el total del precio de todos los productos.
$pdf->cell(86, 10, 'Total Precio (US$)', 1, 0, 'C', 1);
$pdf->cell(100, 10, $totalPrecio, 1, 1, 'C', 1);

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'productos.pdf');
