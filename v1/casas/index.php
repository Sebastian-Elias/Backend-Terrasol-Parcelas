<?php
include '../version1.php';

// Inicializar parámetros
$existeId = false;
$valorId = null;
$existeAccion = false;
$valorAccion = null;

// Verificar y obtener parámetros
if (count($_parametros) > 0) {
    foreach ($_parametros as $p) {
        $paramParts = explode('=', $p);
        if (count($paramParts) == 2) {
            list($key, $value) = $paramParts;
            if ($key === 'id') {
                $existeId = true;
                $valorId = $value;
            } elseif ($key === 'accion') {
                $existeAccion = true;
                $valorAccion = $value;
            }
        }
    }
}

// Verificar la versión y el mantenedor
if ($_version == 'v1' && $_mantenedor == 'casas') {
    include_once '../casas/controller.php';
    include_once '../conexion.php';

    switch ($_metodo) {
        case 'GET':
            if ($_header == $_token_get) {
                // Verificar si el archivo JSON existe
                $filePath = '../casas/casas.json';
                if (file_exists($filePath)) {
                    // Leer el contenido del archivo JSON
                    $jsonData = file_get_contents($filePath);

                    // Decodificar el JSON a un array asociativo
                    $data = json_decode($jsonData, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        // Asignar los datos decodificados a la variable $lista
                        $lista = [$data];
                        http_response_code(200);
                        echo json_encode(["data" => $lista]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["Error" => "Error al decodificar el JSON"]);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(["Error" => "Archivo historia.json no encontrado"]);
                }
            } else {
                http_response_code(401);
                echo json_encode(["Error" => "No tiene autorización GET"]);
            }
            break;
            case 'POST':
                if ($_header == $_token_post) {
                    // Verificar si el archivo JSON existe
                    $filePath = '../casas/casas.json';
                    $postData = file_get_contents('php://input');
                    $postDataArray = json_decode($postData, true);

                    if (file_exists($filePath)) {
                        // Leer el contenido del archivo JSON
                        $jsonData = file_get_contents($filePath);

                        // Decodificar el JSON a un array asociativo
                        $data = json_decode($jsonData, true);

                        // Agregar nuevos datos al array existente o inicializar uno nuevo si no existe
                        if ($data === null) {
                            $data = [];
                        }
                        $data[] = $postDataArray;

                        // Codificar los datos actualizados a JSON
                        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

                        // Escribir los datos en el archivo JSON
                        if (file_put_contents($filePath, $jsonData)) {
                            http_response_code(201);
                            echo json_encode(["Success" => "Datos agregados correctamente _ POST"]);
                        } else {
                            http_response_code(500);
                            echo json_encode(["Error" => "Error al escribir en el archivo JSON"]);
                        }
                    } else {
                        http_response_code(404);
                        echo json_encode(["Error" => "Archivo historia.json no encontrado"]);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorización POST"]);
                }
                break;

                case 'PATCH':
                    if ($_header == $_token_patch) {
                        // Verificar si el archivo JSON existe
                        $filePath = '../casas/casas.json';
                        $patchData = file_get_contents('php://input');
                        $patchDataArray = json_decode($patchData, true);
                
                        if (file_exists($filePath)) {
                            // Leer el contenido del archivo JSON
                            $jsonData = file_get_contents($filePath);
                
                            // Decodificar el JSON a un array asociativo
                            $data = json_decode($jsonData, true);
                
                            if ($data === null) {
                                // Si la decodificación falla, no hay datos válidos en el archivo
                                http_response_code(500);
                                echo json_encode(["Error" => "No se pudo decodificar el JSON"]);
                                exit;
                            }
                
                            // Verificar si $data es un array antes de iterar sobre él
                            if (!is_array($data)) {
                                // Si no es un array, no podemos aplicar cambios parciales
                                http_response_code(500);
                                echo json_encode(["Error" => "El contenido del archivo no es un array"]);
                                exit;
                            }
                
                            // Aplicar las modificaciones parciales
                            foreach ($patchDataArray as $key => $value) {
                                if (array_key_exists($key, $data)) {
                                    $data[$key] = $value;
                                } else {
                                    // Si el campo no existe, podrías decidir cómo manejarlo
                                    // En este caso, solo lo ignoraremos
                                }
                            }
                
                            // Codificar los datos actualizados a JSON
                            $jsonData = json_encode($data, JSON_PRETTY_PRINT);
                
                            // Escribir los datos en el archivo JSON
                            if (file_put_contents($filePath, $jsonData)) {
                                http_response_code(200);
                                echo json_encode(["Success" => "Datos actualizados correctamente"]);
                            } else {
                                http_response_code(500);
                                echo json_encode(["Error" => "Error al escribir en el archivo JSON"]);
                            }
                        } else {
                            http_response_code(404);
                            echo json_encode(["Error" => "Archivo historia.json no encontrado"]);
                        }
                    } else {
                        http_response_code(401);
                        echo json_encode(["Error" => "No tiene autorización PATCH"]);
                    }
                    break;

            case 'PUT':
                if ($_header == $_token_put) {
                    // Verificar si el archivo JSON existe
                    $filePath = '../casas/casas.json';
                    $putData = file_get_contents('php://input');
                    $putDataArray = json_decode($putData, true);
            
                    if (file_exists($filePath)) {
                        // Leer el contenido del archivo JSON
                        $jsonData = file_get_contents($filePath);
            
                        // Decodificar el JSON a un array asociativo
                        $data = json_decode($jsonData, true);
            
                        // Actualizar los campos del objeto JSON con los nuevos datos proporcionados
                        foreach ($putDataArray as $key => $value) {
                            $data[$key] = $value;
                        }
            
                        // Codificar los datos actualizados a JSON
                        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
            
                        // Escribir los datos en el archivo JSON
                        if (file_put_contents($filePath, $jsonData)) {
                            http_response_code(200);
                            echo json_encode(["Success" => "Datos actualizados correctamente"]);
                        } else {
                            http_response_code(500);
                            echo json_encode(["Error" => "Error al escribir en el archivo JSON"]);
                        }
                    } else {
                        http_response_code(404);
                        echo json_encode(["Error" => "Archivo historia.json no encontrado"]);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorización PUT"]);
                }
                break;

                case 'DELETE':
                    if ($_header == $_token_delete) {
                        // Verificar si el archivo JSON existe
                        $filePath = '../casas/casas.json';
                        
                        if (file_exists($filePath)) {
                            // Eliminar el archivo JSON
                            if (unlink($filePath)) {
                                http_response_code(200);
                                echo json_encode(["Success" => "Archivo eliminado correctamente"]);
                            } else {
                                http_response_code(500);
                                echo json_encode(["Error" => "Error al eliminar el archivo historia.json"]);
                            }
                        } else {
                            http_response_code(404);
                            echo json_encode(["Error" => "Archivo historia.json no encontrado"]);
                        }
                    } else {
                        http_response_code(401);
                        echo json_encode(["Error" => "No tiene autorización DELETE"]);
                    }
                    break;

        default:
            http_response_code(405);
            echo json_encode(["Error" => "Método no implementado"]);
            break;
    }
}
?>












