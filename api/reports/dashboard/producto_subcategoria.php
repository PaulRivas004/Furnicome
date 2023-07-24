<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');


// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['id_subcategoria'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/Subcategoria.php');
    require_once('../../entities/dto/producto.php');
    // Se instancian las entidades correspondientes.
    $subcategoria = new Subcategoria;
    $producto = new Producto;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($subcategoria->setId($_GET['id_subcategoria']) && $producto->setSubcategoria($_GET['id_subcategoria'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowSubcategoria = $subcategoria->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de la subcategoría: ' . $rowSubcategoria['nombre_sub']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->productosSubcategoria()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(215, 198, 153);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Arial', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(126, 10, 'Nombre', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Precio (US$)', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Helvetica', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataProductos as $rowProducto) {
                    ($rowProducto['estado_producto']) ? $estado = 'Activo' : $estado = 'Inactivo';
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowProducto['nombre_producto']), 'B', 0,);
                    $pdf->cell(30, 10, $rowProducto['precio_producto'], '1', 0);
                    $pdf->cell(30, 10, $estado, 'B', 1);
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay productos para la categoría'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'subcategoria.pdf');
        } else {
            print('Subcategoría inexistente');
        }
    } else {
        print('Subcategoría incorrecta');
    }
} else {
    print('Debe seleccionar una Subcategoría');
}
