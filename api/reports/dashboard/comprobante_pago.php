<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se verifica si existe un valor para el id del pedido, de lo contrario se muestra un mensaje.
if (isset($_GET['id_pedido'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/pedidos.php');
    // Se instancian las entidades correspondientes.
    $pedidos = new Pedidos;
    // Se establece el valor del id del pedido, de lo contrario se muestra un mensaje.
    if ($pedidos->setId($_GET['id_pedido']) && $pedidos->setIdCliente($_GET['id_cliente']) ) {
        // Se verifica si el pedido existe, de lo contrario se muestra un mensaje.
        if ($rowPedidos = $pedidos->readDetail()) {
            // Se instancia la clase para crear el reporte.
            $pdf = new Report();
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos del pedido ' . $rowPedidos['id_pedido']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataPedidos = $pedidos->readDetail()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(100, 10, 'Producto', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Cantidad', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataPedidos as $rowPedido) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(100, 10, $pdf->encodeString($rowPedido['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowPedido['precio_producto'], 1, 0);
                    $pdf->cell(30, 10, $rowPedido['cantidad_producto'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay comprobante'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'pedido.pdf');
        } else {
            print('Pedido inexistente');
        }
    } else {
        print('Id del pedido incorrecto');
    }
} else {
    print('Debe seleccionar un pedido');
}
?>
