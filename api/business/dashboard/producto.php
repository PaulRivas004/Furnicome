<?php
require_once('../../entities/dto/producto.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $producto = new Producto;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                if ($result['dataset'] = $producto->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                 //Función para cargar datos en el select asignado a Subcategorias
            case 'readSub':
                if ($result['dataset'] = $producto->readSub()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                //Función para cargar datos en el select asignado a usuarios
            case 'cargarUsuario':
                if ($result['dataset'] = $producto->cargarUsuario()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                //Acción para crear un nuevo dato en la tabla de productos 
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!isset($_POST['subcategoria'])) {
                    $result['exception'] = 'Seleccione una subcategoría';
                }elseif (!$producto->setSubcategoria($_POST['subcategoria'])) {
                    $result['exception'] = 'Subcategoría incorrecta';
                } elseif(!$producto->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$producto->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$producto->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';
                } elseif (!$producto->setEstado(isset($_POST['estado']) ? 0 : 1)) {
                    $result['exception'] = 'Estado incorrecto';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    $result['exception'] = 'Seleccione una imagen';
                }elseif(!$producto->setExistencia($_POST['existencia'])) {
                        $result['exception'] = 'existencia incorrecta';
                } elseif (!$producto->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($producto->createRow()) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $producto->getRuta(), $producto->getImagen())) {
                        $result['message'] = 'Producto creado correctamente';
                    } else {
                        $result['message'] = 'Producto creado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();;
                }
                break;
                //Selecccionar un registro por medio de consultas en las queries accionado por un onUpdate
            case 'readOne':
                if (!$producto->setId($_POST['id'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $producto->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Producto inexistente';
                }
                break;
                //Acción para actualizar un dato en la tabla de productos
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if(!$producto->setId($_POST['id'])) {
                    $result['exception'] = 'producto incorrecto'; 
                }elseif (!$data = $producto->readOne()) {
                    $result['exception'] = 'producto inexistente'; 
                }elseif (!isset($_POST['subcategoria'])) {
                    $result['exception'] = 'Seleccione una subcategoría';
                }elseif (!$producto->setSubcategoria($_POST['subcategoria'])) {
                    $result['exception'] = 'Subcategoría incorrecta';
                } elseif(!$producto->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$producto->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif (!$producto->setPrecio($_POST['precio'])) {
                    $result['exception'] = 'Precio incorrecto';   
                }elseif (!$producto->setEstado(isset($_POST['estados']) ? 1 : 0)) {
                    $result['exception'] = 'Estado incorrecto';
                }elseif(!$producto->setExistencia($_POST['existencia'])) {
                        $result['exception'] = 'existencia incorrecta';
                } elseif (!is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                    if ($producto->updateRow($data['imagen_producto'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Producto modificado correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                } elseif (!$producto->setImagen($_FILES['archivo'])) {
                    $result['exception'] = Validator::getFileError();
                } elseif ($producto->updateRow($data['imagen_producto'])) {
                    $result['status'] = 1;
                    if (Validator::saveFile($_FILES['archivo'], $producto->getRuta(), $producto->getImagen())) {
                        $result['message'] = 'producto modificado correctamente';
                    } else {
                        $result['message'] = 'producto modificado pero no se guardó la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Acción para eliminar un dato de la tabla de productos 
            case 'delete':
                if (!$producto->setId($_POST['id_producto'])) {
                    $result['exception'] = 'Producto incorrecto';
                } elseif (!$data = $producto->readOne()) {
                    $result['exception'] = 'Producto inexistente';
                } elseif ($producto->deleteRow()) {
                    $result['status'] = 1;
                    if (Validator::deleteFile($producto->getRuta(), $data['imagen_producto'])) {
                        $result['message'] = 'Producto eliminado correctamente';
                    } else {
                        $result['message'] = 'Producto eliminado pero no se borró la imagen';
                    }
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Sacar un grafico dependiendo de cuantas categorias existen
                case 'cantidadProductosSubCategoria':
                    if ($result['dataset'] = $producto->cantidadProductosSubCategoria()) {
                        $result['status'] = 1;
                    } else {
                        $result['exception'] = 'No hay datos disponibles';
                    }
                    break;
                    case 'cantidadProductosexistencia':
                        if ($result['dataset'] = $producto->cantidadProductosExistencia()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'No hay datos disponibles';
                        }
                    break;
                    case 'cantidadProductosVendidos':
                        if ($result['dataset'] = $producto->cantidadProductosVendidos()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'No hay datos disponibles';
                        }
                    break;
                    case 'cantidadValoraciones':
                        if ($result['dataset'] = $producto->cantidadValoraciones()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'No hay datos disponibles';
                        }
                    break;
                    case 'cantidadPedidos':
                        if ($result['dataset'] = $producto->clientesPedidos()) {
                            $result['status'] = 1;
                        } else {
                            $result['exception'] = 'No hay datos disponibles';
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