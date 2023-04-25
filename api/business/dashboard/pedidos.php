<?php
require_once('../../entities/dto/pedidos.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pedidos = new Pedidos;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $pedidos->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                case 'readOne':
                    if (!$pedidos->setId($_POST['id_pedido'])) {
                        $result['exception'] = 'Pedido incorrecto';
                    } elseif ($result['dataset'] = $pedidos->readOne()) {
                        $result['status'] = 1;
                    } elseif (Database::getException()) {
                        $result['exception'] = Database::getException();
                    } else {
                        $result['exception'] = 'Pedido inexistente';
                    }
                    break;
                    case 'update':
                        $_POST = Validator::validateForm($_POST);
                        if (!$pedidos->setId($_POST['id_pedido'])) {
                            $result['exception'] = 'Pedido incorrecto';
                        } elseif (!$pedidos->readOne()) {
                            $result['exception'] = 'Pedido inexistente';
                        } elseif (!$pedidos->setNombreCliente($_POST['nombre_cliente'])) {
                            $result['exception'] = 'Nombre incorrecto';
                        }elseif (!$pedidos->setEstado(isset($_POST['estado']) ? 1 : 0)) {
                            $result['exception'] = 'Estado incorrecto';
                        }elseif (!$pedidos->setFecha($_POST['fecha_pedido'])) {
                            $result['exception'] = 'Fecha incorrecto';
                        }elseif (!$pedidos->setDireccion($_POST['direccion'])) {
                            $result['exception'] = 'Direccion incorrecto';
                        }elseif ($pedidos->updateRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Pedido modificado correctamente';
                        } else {
                            $result['exception'] = Database::getException();
                        }
                        break;
                        case 'readDetail':
                            if (!$pedidos->setIdDetalle($_POST['id_detalle'])) {
                                $result['exception'] = 'Pedido incorrecto';
                            } elseif ($result['dataset'] = $pedidos->readDetail()) {
                                $result['status'] = 1;
                            } elseif (Database::getException()) {
                                $result['exception'] = Database::getException();
                            } else {
                                $result['exception'] = 'Pedido inexistente';
                            }
                            break;
                            case 'delete':
                                if (!$pedidos->setId($_POST['id_pedido'])) {
                                    $result['exception'] = 'Categoría incorrecta';
                                } elseif (!$data = $pedidos->readOne()) {
                                    $result['exception'] = 'Categoría inexistente';
                                } elseif ($pedidos->deleteRow()) {
                                    $result['status'] = 1;                   
                                    $result['message'] = 'Pedido eliminado correctamente';
                                } else {
                                    $result['exception'] = Database::getException();
                                }
                                break;
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
