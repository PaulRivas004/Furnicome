<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');


// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['id_producto'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/valoracion.php');
    require_once('../../entities/dto/producto.php');
    // Se instancian las entidades correspondientes.
    $valoracion = new Valoracion;
    $producto = new Producto;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($valoracion->setId($_GET['id_producto']) && $valoracion->setIdProducto($_GET['id_producto'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowValoracion= $valoracion->readValoracion() ) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Valoraciones de producto: ' . $rowValoracion['nombre_producto'] );
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataValoracion = $valoracion->readComentarios()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(116, 10, 'Comentario', 1, 0, 'C', 1);
                $pdf->cell(30, 10, $pdf->encodeString('Calificación'), 1, 0, 'C', 1);
                $pdf->cell(40, 10, $pdf->encodeString('Fecha de publicación'), 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataValoracion as $rowValoracion) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(116, 10, $pdf->encodeString($rowValoracion['comentario_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowValoracion['calificacion_producto'], 1, 0);
                    $pdf->cell(40, 10, $rowValoracion['fecha_comentario'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay valoraciones para el producto'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Valoraciones por producto.pdf');
        } else {
            print('Aún no hay valoraciones ');
        }
    } else {
        print('Producto incorrecta');
    }
} else {
    print('Debe seleccionar una producto');
}
