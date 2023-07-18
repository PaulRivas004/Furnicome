<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');


// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la categoría, de lo contrario se muestra un mensaje.
if (isset($_GET['id_subcategoria'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../entities/dto/Subcategoria.php');
    require_once('../../entities/dto/categoria.php');
    // Se instancian las entidades correspondientes.
    $subcategoria = new Subcategoria;
    $categoria = new Categoria;
    // Se establece el valor de la categoría, de lo contrario se muestra un mensaje.
    if ($subcategoria->setId($_GET['id_subcategoria']) && $subcategoria->setCategoria($_GET['id_categoria'])) {
        // Se verifica si la categoría existe, de lo contrario se muestra un mensaje.
        if ($rowSubcategoria = $subcategoria->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Productos de la subcategoría ' . $rowSubcategoria['nombre_categoria']);
            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataSubCategoria = $subcategoria->readSubXCategorias()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(126, 10, 'Nombre Subcategoria', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Nombre Categoria', 1, 0, 'C', 1);
                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 11);
                // Se recorren los registros fila por fila.
                foreach ($dataSubCategoria as $rowSubCategoria) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, $pdf->encodeString($rowSubCategoria['nombre_categoria']), 1, 0);
                    $pdf->cell(30, 10, $rowSubCategoria['nombre_sub'], 1, 0);
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
