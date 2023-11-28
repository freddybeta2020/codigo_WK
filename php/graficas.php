<?php

use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;

include_once '../config/config.php';

$fechaActual = date('Y-m-d');


//Consulta Los Olivos
if (isset($_GET['requestType'])) {
    $requestType = $_GET['requestType'];

    if ($requestType === 'Olivos') {
        try {
            $fechaActual = date('Y-m-d');
            
            $query = "SELECT fecha_pronostico, llamadas_pronosticadas, hora_pronosticada, servicio FROM tbl_pronostico WHERE servicio = 'Olivos' AND fecha_pronostico = '$fechaActual' LIMIT 24";

            $statement = $conexion->query($query);

            // Paso 3: Recuperar los resultados de la consulta
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Paso 4: Formatear los datos para Chart.js
            $labels = [];
            $llamadas = [];
            $horas = []; // Nuevo array para almacenar las horas pronosticadas
            $servicio = [];

            foreach ($data as $row) {
                $labels[] = $row['fecha_pronostico'];
                $llamadas[] = $row['llamadas_pronosticadas'];

                // Formatear la hora en el formato "Hora 01"
                $horaFormateada = date('H', strtotime($row['hora_pronosticada']));
                $horas[] = "Hora " . str_pad($horaFormateada, 2, '0', STR_PAD_LEFT); // Agregar las horas pronosticadas

                $servicio[] = $row['servicio'];
            }
            $chartData = [
                'labels' => $labels, // Etiquetas (horas)
                'hora_pronosticada' => $horas, // Horas pronosticadas
                'llamadas_pronosticadas' => $llamadas, // Llamadas pronosticadas
                'servicio' => $servicio,
            ];

            // Paso 5: Imprimir los datos en formato JSON
            header('Content-Type: application/json');
            echo json_encode($chartData);
        } catch (\Throwable $th) {
            echo json_encode(array('error' => 'Ocurrió un error: ' . $th->getMessage()));
        }
    }
}
//Consulta Prosalco
if (isset($_GET['requestType'])) {
    $requestType = $_GET['requestType'];

    if ($requestType === 'Prosalco') {
        try {

            $query = "SELECT fecha_pronostico, llamadas_pronosticadas, hora_pronosticada, servicio FROM tbl_pronostico WHERE servicio = 'Prosalco' AND fecha_pronostico = '$fechaActual' LIMIT 24";
            $statement = $conexion->query($query);

            // Paso 3: Recuperar los resultados de la consulta
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Paso 4: Formatear los datos para Chart.js
            $labels = [];
            $llamadas = [];
            $horas = []; // Nuevo array para almacenar las horas pronosticadas
            $servicio = [];

            foreach ($data as $row) {
                $labels[] = $row['fecha_pronostico'];
                $llamadas[] = $row['llamadas_pronosticadas'];

                // Formatear la hora en el formato "Hora 01"
                $horaFormateada = date('H', strtotime($row['hora_pronosticada']));
                $horas[] = "Hora " . str_pad($horaFormateada, 2, '0', STR_PAD_LEFT); // Agregar las horas pronosticadas

                $servicio[] = $row['servicio'];
            }
            $chartData = [
                'labels' => $labels, // Etiquetas (horas)
                'hora_pronosticada' => $horas, // Horas pronosticadas
                'llamadas_pronosticadas' => $llamadas, // Llamadas pronosticadas
                'servicio' => $servicio,
            ];

            // Paso 5: Imprimir los datos en formato JSON
            header('Content-Type: application/json');
            echo json_encode($chartData);
        } catch (\Throwable $th) {
            echo json_encode(array('error' => 'Ocurrió un error: ' . $th->getMessage()));
        }
    }
}
//Consulta Localiza
if (isset($_GET['requestType'])) {
    $requestType = $_GET['requestType'];

    if ($requestType === 'Localiza') {
        try {

            $fechaActual = date('Y-m-d');

            $query = "SELECT fecha_pronostico, llamadas_pronosticadas, hora_pronosticada, servicio FROM tbl_pronostico WHERE servicio = 'Localiza' AND fecha_pronostico = '$fechaActual' LIMIT 24";

            $statement = $conexion->query($query);

            // Paso 3: Recuperar los resultados de la consulta
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Paso 4: Formatear los datos para Chart.js
            $labels = [];
            $llamadas = [];
            $horas = []; // Nuevo array para almacenar las horas pronosticadas
            $servicio = [];

            foreach ($data as $row) {
                $labels[] = $row['fecha_pronostico'];
                $llamadas[] = $row['llamadas_pronosticadas'];

                // Formatear la hora en el formato "Hora 01"
                $horaFormateada = date('H', strtotime($row['hora_pronosticada']));
                $horas[] = "Hora " . str_pad($horaFormateada, 2, '0', STR_PAD_LEFT); // Agregar las horas pronosticadas

                $servicio[] = $row['servicio'];
            }
            $chartData = [
                'labels' => $labels, // Etiquetas (horas)
                'hora_pronosticada' => $horas, // Horas pronosticadas
                'llamadas_pronosticadas' => $llamadas, // Llamadas pronosticadas
                'servicio' => $servicio,
            ];

            // Paso 5: Imprimir los datos en formato JSON
            header('Content-Type: application/json');
            echo json_encode($chartData);
        } catch (\Throwable $th) {
            echo json_encode(array('error' => 'Ocurrió un error: ' . $th->getMessage()));
        }
    }
}
//Consulta Confiar
if (isset($_GET['requestType'])) {
    $requestType = $_GET['requestType'];

    if ($requestType === 'Confiar') {
        try {

            $fechaActual = date('Y-m-d');

            $query = "SELECT fecha_pronostico, llamadas_pronosticadas, hora_pronosticada, servicio FROM tbl_pronostico WHERE servicio = 'Localiza' AND fecha_pronostico = '$fechaActual' LIMIT 24";

            $statement = $conexion->query($query);

            // Paso 3: Recuperar los resultados de la consulta
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Paso 4: Formatear los datos para Chart.js
            $labels = [];
            $llamadas = [];
            $horas = []; // Nuevo array para almacenar las horas pronosticadas
            $servicio = [];

            foreach ($data as $row) {
                $labels[] = $row['fecha_pronostico'];
                $llamadas[] = $row['llamadas_pronosticadas'];

                // Formatear la hora en el formato "Hora 01"
                $horaFormateada = date('H', strtotime($row['hora_pronosticada']));
                $horas[] = "Hora " . str_pad($horaFormateada, 2, '0', STR_PAD_LEFT); // Agregar las horas pronosticadas

                $servicio[] = $row['servicio'];
            }
            $chartData = [
                'labels' => $labels, // Etiquetas (horas)
                'hora_pronosticada' => $horas, // Horas pronosticadas
                'llamadas_pronosticadas' => $llamadas, // Llamadas pronosticadas
                'servicio' => $servicio,
            ];

            // Paso 5: Imprimir los datos en formato JSON
            header('Content-Type: application/json');
            echo json_encode($chartData);
        } catch (\Throwable $th) {
            echo json_encode(array('error' => 'Ocurrió un error: ' . $th->getMessage()));
        }
    }
}

