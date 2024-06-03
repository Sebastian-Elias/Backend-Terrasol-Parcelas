<?php
include_once '../version1.php';

// Valores de los parámetros
$existeId = false;
$valorId = 0;

if (count($_parametros) > 0) {
    foreach ($_parametros as $p) {
        if (strpos($p, 'id') !== false) {
            $existeId = true;
            $valorId = explode('=', $p)[1];
        }
    }
}

if ($_version == 'v1') {
    if ($_mantenedor == 'parcelas') {
        switch ($_metodo) {
            case 'GET':
                if ($_header == $_token_get_parcelas) {
                    // Verificar si el archivo JSON existe
                    $filePath = '../parcelas/parcelas.json';
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
            default:
                http_response_code(405);
                echo json_encode(["Error" => "Método no implementado"]);
                break;
        }
    }
}
?>