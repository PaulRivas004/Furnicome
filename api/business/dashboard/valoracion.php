<?php
require_once('../../entities/dto/valoracion.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $valoracion = new Valoracion;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $valoracion->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readCategorias':
                if ($result['dataset'] = $valoracion->readDetalle()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
            case 'readOne':
                if (!$valoracion->setId($_POST['id_valoracion'])) {
                    $result['exception'] = 'valoracion incorrecta';
                } elseif ($result['dataset'] = $valoracion->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'valoracion inexistente';
                }
                break;
                // Acción para actualizar un dato en la tabla de clientes
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$valoracion->setId($_POST['id_valoracion'])) {
                    $result['exception'] = 'valoración incorrecta';
                } elseif (!$data = $valoracion->readOne()) {
                    $result['exception'] = 'valoración inexistente';
                } elseif (!$valoracion->setDetalle($_POST['detalle'])) {
                    $result['exception'] = 'Seleccione un detalle';
                }elseif (!$valoracion->setCalificacion($_POST['calificacion'])) {
                    $result['exception'] = 'Calificaión incorrecta';
                }elseif (!$valoracion->setComentario($_POST['comentario'])) {
                    $result['exception'] = 'Comentario incorrecto';
                }elseif (!$valoracion->setFecha($_POST['fecha'])) {
                    $result['exception'] = 'Fecha incorrecto';
                }elseif (!$valoracion->setEstado(isset($_POST['estados']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';   
                }  elseif ($cliente->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Estado de la valoración modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }    
                break;
                //Acción para eliminar un dato en la tabla de clientes
            case 'delete':
                if (!$cliente->setId($_POST['id_valoracion'])) {
                    $result['exception'] = 'cliente incorrecta';
                } elseif (!$data = $cliente->readOne()) {
                    $result['exception'] = 'cliente inexistente';
                } elseif ($cliente->deleteRow()) {
                    $result['status'] = 1;                   
                    $result['message'] = 'cliente eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}