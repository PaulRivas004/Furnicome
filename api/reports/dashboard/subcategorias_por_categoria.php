<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../entities/dto/categoria.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Subcategorias por categoria existente');
// Se instancia el módelo Categoría para obtener los datos.
$categorias = new Categoria;
// Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
if ($dataCategorias = $categorias->readSubXCategorias()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(175);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(90, 10, $pdf->encodeString('Nombre categoria'), 1, 0, 'C', 1);
    $pdf->cell(100, 10, $pdf->encodeString('subcategoria existente'), 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(225);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataCategorias as $rowCategoria) {
        // Se imprimen las celdas con los datos de los productos.
        $pdf->cell(90, 10, $pdf->encodeString($rowCategoria['nombre_categoria']), 1, 0);
        $pdf->cell(100, 10, $pdf->encodeString($rowCategoria['subcategorias']), 1, 1);
    }
} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay pedidos para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Pedidos finalizado.pdf');
