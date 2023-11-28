<?php
include_once '../config/config.php';

try {
    $query = "SELECT servicio, COUNT(*) as totalServicios FROM tbl_agentes_realtime GROUP BY servicio";

    $statement = $conexion->query($query);

    // Paso 3: Recuperar los resultados de la consulta
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Paso 4: Calcular porcentajes y formatear los datos para Chart.js
    $totalServicios = array_sum(array_column($data, 'totalServicios'));
    $servicioTotales = [];
    $servicioPorcentajes = [];

    foreach ($data as $row) {
        $porcentaje = ($row['totalServicios'] / $totalServicios) * 100;
        $servicioTotales[] = $row['totalServicios'];
        $servicioPorcentajes[] = round($porcentaje, 2);
    }

    $chartData = [
        'serviciosTotales' => $servicioTotales,
        'servicioPorcentajes' => $servicioPorcentajes,
        'servicio' => array_column($data, 'servicio'),
    ];

    // Paso 5: Imprimir los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($chartData);

} catch (\Throwable $th) {
    echo json_encode(['error' => 'Ocurrió un error: ' . $th->getMessage()]);
}
?>
