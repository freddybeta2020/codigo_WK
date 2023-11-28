<?php
include_once '../config/config.php';

$currentDate = date('Ymd');

    // ELIMINAR EL CONTENIDO DE LA TABLA DATOS GRAFICO

    $sqlTruncaTables = "TRUNCATE `conceptb_torre_control`.`tbl_datos_grafico`";

    $queryTruncaTables = $conexion->prepare($sqlTruncaTables);

    if (!$queryTruncaTables->execute()) {
        echo "Error";
        return;
    }

    $queryTruncaTables->closeCursor();


// Consulta 4173 PROSALCO - modulo praxisalud    
try {

    // 4173 PROSALCO - modulo praxisalud
    $curl = curl_init();

    
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

    if ($datosProsalco['code'] == 200) {
        // Verificar si la respuesta es válida
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new Exception('Error al decodificar la respuesta JSON de la API.');
        }

        // Inicializar un array para almacenar los datos del gráfico
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4173"
            if (isset($row['skill_id']) && $row['skill_id'] === '4173') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4173';
                    $servicio = 'Prosalco';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }

    
        echo "Datos guardados en la base de datos exitosamente 4173.\n";
    } else {
        echo "No hay resultados";
    }
    
    //FIN CONSULTA 4173 PROSALCO - modulo praxisalud

    // Consulta 4140 PRAXISALUD - modulo praxisalud
    $curl = curl_init();

    
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

    if ($datosProsalco['code'] == 200) {
        // Verificar si la respuesta es válida
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new Exception('Error al decodificar la respuesta JSON de la API.');
        }

        // Inicializar un array para almacenar los datos del gráfico
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4140"
            if (isset($row['skill_id']) && $row['skill_id'] === '4140') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4140';
                    $servicio = 'Praxisalud';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }

    
        echo "Datos guardados en la base de datos exitosamente 4140.\n";
    } else {
        echo "No hay resultados";
    }
    //FIN  Consulta 4140 PRAXISALUD - modulo praxisalud

    // Consulta 4009 ASESORIA CREDITO - modulo confiar
    $curl = curl_init();

    
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4173"
            if (isset($row['skill_id']) && $row['skill_id'] === '4009') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4009';
                    $servicio = 'Confiar';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4009.\n";
    } else {
        echo "No hay resultados";
    }

    //FIN Consulta 4009 ASESORIA CREDITO - modulo confiar

    // Consulta 4027 CLIENTE CORPORATIVO - modulo confiar
    $curl = curl_init();

    
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4027"
            if (isset($row['skill_id']) && $row['skill_id'] === '4027') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4027';
                    $servicio = 'Confiar';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4027.\n";
    } else {
        echo "No hay resultados";
    }

    //FIN  Consulta 4027 CLIENTE CORPORATIVO - modulo confiar

    // Consulta 4231 INB_CLIENTE CORPORATIVO - modulo confiar

    $curl = curl_init();

    
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4231"
            if (isset($row['skill_id']) && $row['skill_id'] === '4231') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4231';
                    $servicio = 'Confiar';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4231.\n";
    } else {
        echo "No hay resultados";
    }

    //FIN Consulta 4231 INB_CLIENTE CORPORATIVO - modulo confiar

    //Consulta 4229 INB_INFORMACION GENERAL - modulo confiar

    $curl = curl_init();

    
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4229"
            if (isset($row['skill_id']) && $row['skill_id'] === '4229') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4229';
                    $servicio = 'Confiar';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4229.\n";
    } else {
        echo "No hay resultados";
    }
    //FIN Consulta 4229 INB_INFORMACION GENERAL - modulo confiar

    //Consulta 4230 INB_SOPORTE CANALES Y MEDIOS DE PAGO  - modulo confiar
    $curl = curl_init();

    
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4230"
            if (isset($row['skill_id']) && $row['skill_id'] === '4230') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4230';
                    $servicio = 'Confiar';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4230.\n";
    } else {
        echo "No hay resultados";
    }
    //FIN Consulta 4230 INB_SOPORTE CANALES Y MEDIOS DE PAGO  - modulo confiar

    // Consulta 4215 INB_SUPER USUARIO   - modulo confiar
    $curl = curl_init();

    
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4215"
            if (isset($row['skill_id']) && $row['skill_id'] === '4215') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4215';
                    $servicio = 'Confiar';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4215.\n";
    } else {
        echo "No hay resultados";
    }
    //FIN Consulta 4215 INB_SUPER USUARIO   - modulo confiar
    // Consulta 4226 INB_VIVIENDA   - modulo confiar

    $curl = curl_init();

    
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4226"
            if (isset($row['skill_id']) && $row['skill_id'] === '4226') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4226';
                    $servicio = 'Confiar';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4226.\n";
    } else {
        echo "No hay resultados";
    }
    //FIN Consulta 4226 INB_VIVIENDA   - modulo confiar

    // Consulta 4162 INFORMACION GENERAL   - modulo confiar
    
    $curl = curl_init();

    
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4162"
            if (isset($row['skill_id']) && $row['skill_id'] === '4162') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4162';
                    $servicio = 'Confiar';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4162.\n";
    } else {
        echo "No hay resultados";
    }

    //FIN Consulta 4162 INFORMACION GENERAL   - modulo confiar

    // Consulta 4069 RADICACION DE CREDITOS    - modulo confiar

    $curl = curl_init();

    
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4069"
            if (isset($row['skill_id']) && $row['skill_id'] === '4069') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4069';
                    $servicio = 'Confiar';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4069.\n";
    } else {
        echo "No hay resultados";
    }
    //FIN Consulta 4069 RADICACION DE CREDITOS    - modulo confiar

    //Consulta 4034 SOPORTE CANALES Y MEDIOS DE PAGO - modulo confiar
    $curl = curl_init();

    
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4034"
            if (isset($row['skill_id']) && $row['skill_id'] === '4034') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4034';
                    $servicio = 'Confiar';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4034.\n";
    } else {
        echo "No hay resultados";
    }

    //FIN Consulta 4034 SOPORTE CANALES Y MEDIOS DE PAGO - modulo confiar

    // Consulta 4008 CHAT WHATSAPP OLIVOS	- modulo olivos
    $curl = curl_init();

    
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
            'wolkvox-token: 7b69645f6469737472697d2d3230323230393031313732313235'
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4008"
            if (isset($row['skill_id']) && $row['skill_id'] === '4008') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4008';
                    $servicio = 'Olivos';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4008.\n";
    } else {
        echo "No hay resultados";
    }

    //FIN Consulta 4008 CHAT WHATSAPP OLIVOS	- modulo olivos

    // Consulta 4097 COORDINAR HOMENAJE	- modulo olivos

    $curl = curl_init();

    
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
            'wolkvox-token: 7b69645f6469737472697d2d3230323230393031313732313235'
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4097"
            if (isset($row['skill_id']) && $row['skill_id'] === '4097') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4097';
                    $servicio = 'Olivos';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4097.\n";
    } else {
        echo "No hay resultados";
    }
    //FIN Consulta 4097 COORDINAR HOMENAJE	- modulo olivos

    
    // Consulta 4279 SKILL OLIVOS - modulo olivos
    $curl = curl_init();

    
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
            'wolkvox-token: 7b69645f6469737472697d2d3230323230393031313732313235'
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4279"
            if (isset($row['skill_id']) && $row['skill_id'] === '4279') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4279';
                    $servicio = 'Olivos';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4279.\n";
    } else {
        echo "No hay resultados";
    }
    
    //FIN Consulta 4279 SKILL OLIVOS - modulo olivos

    // Consulta 4008 ASEGURADORAS - modulo localiza
    $curl = curl_init();

    
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
            'wolkvox-token: 7b69645f6469737472697d2d3230323230393035313233363235'
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4008"
            if (isset($row['skill_id']) && $row['skill_id'] === '4008') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4008';
                    $servicio = 'Localiza';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4008.\n";
    } else {
        echo "No hay resultados";
    }   

    //FIN Consulta 4008 ASEGURADORAS - modulo localiza

    // Consulta 4139 PERSONA NATURAL - modulo localiza
    $curl = curl_init();

    
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
            'wolkvox-token: 7b69645f6469737472697d2d3230323230393035313233363235'
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4139"
            if (isset($row['skill_id']) && $row['skill_id'] === '4139') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4139';
                    $servicio = 'Localiza';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4139.\n";
    } else {
        echo "No hay resultados";
    }   

    //FIN Consulta 4139 PERSONA NATURAL - modulo localiza

    // Consulta 4037 WHATSAPP - modulo localiza	
    $curl = curl_init();

    
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
            'wolkvox-token: 7b69645f6469737472697d2d3230323230393035313233363235'
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
        $sumCallsByHour = [];
        $chartData = [
            'labels' => [],
            'data' => [],
            'backgroundColor' => [],
            'borderColor' => [],
            'borderWidth' => 1,
        ];

        foreach ($datosProsalco['data'] as $row) {
            // Filtrar por skill_id "4037"
            if (isset($row['skill_id']) && $row['skill_id'] === '4037') {
                // Verificar si la fila es un array y si tiene las claves esperadas
                if (is_array($row) && isset($row['hour']) && isset($row['inbound_calls'])) {
                    $hourLabel = 'Hora ' . $row['hour'];

                    // Asignar las llamadas actuales a la etiqueta de hora
                    $sumCallsByHour[$hourLabel] = (int)$row['inbound_calls'];

                    // Resto del código para el gráfico
                    $chartData['labels'][] = $hourLabel;
                    $chartData['data'][] = $sumCallsByHour[$hourLabel];

                    // Generar un color de fondo aleatorio
                    $red = rand(0, 255);
                    $green = rand(0, 255);
                    $blue = rand(0, 255);

                    $chartData['backgroundColor'][] = 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
                    $chartData['borderColor'][] = 'rgba(255, 255, 255, 1)';

                    // Guardar en la base de datos
                    $hora = $hourLabel;
                    $llamadas = $sumCallsByHour[$hourLabel];
                    $colorFondoRed = $red;
                    $colorFondoGreen = $green;
                    $colorFondoBlue = $blue;
                    $colorBorde = $chartData['borderColor'][count($chartData['borderColor']) - 1];
                    $grosorBorde = $chartData['borderWidth'];

                    $requestType = '4037';
                    $servicio = 'Localiza';

                    $stmt = $conexion->prepare("INSERT INTO tbl_datos_grafico (hora, llamadas, color_fondo_red, color_fondo_green, color_fondo_blue, color_borde, grosor_borde, request_type, servicio)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hora);
                    $stmt->bindParam(2, $llamadas);
                    $stmt->bindParam(3, $colorFondoRed);
                    $stmt->bindParam(4, $colorFondoGreen);
                    $stmt->bindParam(5, $colorFondoBlue);
                    $stmt->bindParam(6, $colorBorde);
                    $stmt->bindParam(7, $grosorBorde);
                    $stmt->bindParam(8, $requestType);
                    $stmt->bindParam(9, $servicio);

                    $stmt->execute();
                }
            }
        }    
        echo "Datos guardados en la base de datos exitosamente 4037.\n";
    } else {
        echo "No hay resultados";
    }      
    //FIN  Consulta 4037 WHATSAPP - modulo localiza	

} catch (Exception $e) {
    echo json_encode(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
}
