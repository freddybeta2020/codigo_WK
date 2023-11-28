<?php
include_once '../config/config.php';

$currentDate = date('Ymd');

//Consulta los Olivos 
if (isset($_GET['requestType'])) {
    $requestType = $_GET['requestType'];

    if ($requestType === 'Olivos') {
        try {
            $curl = curl_init();

            // Olivos
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://wv0015.wolkvox.com/api/v2/reports_manager.php?api=skill_7&skill_id=all&date_ini=' . $currentDate . '000000&date_end=' . $currentDate . '235959',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'wolkvox-token: 7b69645f6469737472697d2d3230323230393031313034333239'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $datosOlivos = json_decode($response, true);

            if ($datosOlivos['code'] == 200) {
                // Verificar si la respuesta es válida
                if (json_last_error() != JSON_ERROR_NONE) {
                    throw new Exception('Error al decodificar la respuesta JSON de la API.');
                }

                // Inicializar un array para almacenar los datos del gráfico
                $chartData = [
                    'labels' => [],
                    'data' => [],
                    'backgroundColor' => [],
                    'borderColor' => [],
                    'borderWidth' => 1,
                ];

                foreach ($datosOlivos['data'] as $row) {
                    // Verificar si la fila es un array y si tiene las claves esperadas
                    if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                        $hourLabel = 'Hora ' . $row['hour'];

                        // Asignar las llamadas actuales a la etiqueta de hora
                        $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                        // Resto del código para el gráfico
                        $chartData['labels'][] = $hourLabel;
                        $chartData['data'][] = $sumCallsByHour[$hourLabel];
                        $chartData['backgroundColor'][] = 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')';
                        $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';
                    }
                }

                // Imprimir los datos en formato JSON
                header('Content-Type: application/json');
                echo json_encode($chartData);
            } else {
                echo "No hay resultados";
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }
}

//Consulta Prosalco
if (isset($_GET['requestType'])) {
    $requestType = $_GET['requestType'];

    if ($requestType === 'Prosalco') {
        try {
            $curl = curl_init();

            // Prosalco
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://wv0013.wolkvox.com/api/v2/reports_manager.php?api=skill_7&skill_id=all&date_ini=' . $currentDate . '000000&date_end=' . $currentDate . '235959',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'wolkvox-token: 7b69645f6469737472697d2d3230323230393031313332383137'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $datosProsalco = json_decode($response, true);
            // echo var_dump($datosProsalco['data']);
            //  return;

            if ($datosProsalco['code'] == 200) {
                // Verificar si la respuesta es válida
                if (json_last_error() != JSON_ERROR_NONE) {
                    throw new Exception('Error al decodificar la respuesta JSON de la API.');
                }

                // Inicializar un array para almacenar los datos del gráfico
                $chartData = [
                    'labels' => [],
                    'data' => [],
                    'backgroundColor' => [],
                    'borderColor' => [],
                    'borderWidth' => 1,
                ];

                foreach ($datosProsalco['data'] as $row) {
                    // Verificar si la fila es un array y si tiene las claves esperadas
                    if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                        $hourLabel = 'Hora ' . $row['hour'];

                        // Asignar las llamadas actuales a la etiqueta de hora
                        $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                        // Resto del código para el gráfico
                        $chartData['labels'][] = $hourLabel;
                        $chartData['data'][] = $sumCallsByHour[$hourLabel];
                        $chartData['backgroundColor'][] = 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')';
                        $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';
                    }
                }

                // Imprimir los datos en formato JSON
                header('Content-Type: application/json');
                echo json_encode($chartData);
            } else {
                echo "No hay resultados";
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }
}
//Consulta Localiza
if (isset($_GET['requestType'])) {
    $requestType = $_GET['requestType'];

    if ($requestType === 'Localiza') {
        try {
            $curl = curl_init();

            // Localiza
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://wv0035.wolkvox.com/api/v2/reports_manager.php?api=skill_7&skill_id=all&date_ini=' . $currentDate . '000000&date_end=' . $currentDate . '235959',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'wolkvox-token: 7b69645f6469737472697d2d3230323230393031313530303134'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $datosProsalco = json_decode($response, true);

            if ($datosProsalco['code'] == 200) {
                // Verificar si la respuesta es válida
                if (json_last_error() != JSON_ERROR_NONE) {
                    throw new Exception('Error al decodificar la respuesta JSON de la API.');
                }

                // Inicializar un array para almacenar los datos del gráfico
                $chartData = [
                    'labels' => [],
                    'data' => [],
                    'backgroundColor' => [],
                    'borderColor' => [],
                    'borderWidth' => 1,
                ];

                foreach ($datosProsalco['data'] as $row) {
                    // Verificar si la fila es un array y si tiene las claves esperadas
                    if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                        $hourLabel = 'Hora ' . $row['hour'];

                        // Asignar las llamadas actuales a la etiqueta de hora
                        $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                        // Resto del código para el gráfico
                        $chartData['labels'][] = $hourLabel;
                        $chartData['data'][] = $sumCallsByHour[$hourLabel];
                        $chartData['backgroundColor'][] = 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')';
                        $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';
                    }
                }

                // Imprimir los datos en formato JSON
                header('Content-Type: application/json');
                echo json_encode($chartData);
            } else {
                echo "No hay resultados";
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }
}
//Consulta Confiar
if (isset($_GET['requestType'])) {
    $requestType = $_GET['requestType'];

    if ($requestType === 'Confiar') {
        try {
            $curl = curl_init();

            // Confiar
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://wv0009.wolkvox.com/api/v2/reports_manager.php?api=skill_7&skill_id=all&date_ini=' . $currentDate . '000000&date_end=' . $currentDate . '235959',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'wolkvox-token: 7b69645f6469737472697d2d3230323330343133313731393437'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $datosProsalco = json_decode($response, true);
          
            if ($datosProsalco['code'] == 200) {
                // Verificar si la respuesta es válida
                if (json_last_error() != JSON_ERROR_NONE) {
                    throw new Exception('Error al decodificar la respuesta JSON de la API.');
                }

                // Inicializar un array para almacenar los datos del gráfico
                $chartData = [
                    'labels' => [],
                    'data' => [],
                    'backgroundColor' => [],
                    'borderColor' => [],
                    'borderWidth' => 1,
                ];

                foreach ($datosProsalco['data'] as $row) {
                    // Verificar si la fila es un array y si tiene las claves esperadas
                    if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                        $hourLabel = 'Hora ' . $row['hour'];

                        // Asignar las llamadas actuales a la etiqueta de hora
                        $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                        // Resto del código para el gráfico
                        $chartData['labels'][] = $hourLabel;
                        $chartData['data'][] = $sumCallsByHour[$hourLabel];
                        $chartData['backgroundColor'][] = 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')';
                        $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';
                    }
                }

                // Imprimir los datos en formato JSON
                header('Content-Type: application/json');
                echo json_encode($chartData);
            } else {
                echo "No hay resultados";
            }
        } catch (Exception $e) {
            echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }
}