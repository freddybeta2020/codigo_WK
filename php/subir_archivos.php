<?php

include_once '../../config/config.php';

$Id_proceso = $_POST['Id_proceso'];
$File = $_FILES['File'];

$peso = number_format($File['size'] / 1024, 2);

if ($peso > 10000) {
    echo "El archivo tiene que ser menor de 10Mb";
    return;
}

// Separa el nombre del archivo para validar su extension
$ext = explode('.', $File['name']);
$nombre = strtolower(reset($ext));
$ext = strtolower(end($ext));
$Nombre = $nombre . "." . $ext;
$Nombre_hash = md5($nombre) . "." . $ext;

function check_doc_mime($tmpname)
{
    // MIME types: http://filext.com/faq/office_mime_types.php
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mtype = finfo_file($finfo, $tmpname);
    finfo_close($finfo);

    if (

        $mtype == ("image/jpeg") || $mtype == ("application/pdf") ||  $mtype == ("image/png") ||
        $mtype == ("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
    ) {

        return TRUE;
    } else {
        return FALSE;
    }
}

// Si la extension es valida guarda el archivo en la carpeta y guarda registro en la base de datos
if (!check_doc_mime($File['tmp_name'])) {
    echo "Extensión no permitida";
    return;
}
try {



    $sql = "INSERT INTO Crm_adjuntos(Nombre,Id_proceso, Nombre_hash)  SELECT :Nombre, :Id_proceso, :Nombre_hash
        WHERE NOT EXISTS (SELECT * FROM Crm_adjuntos WHERE Nombre = :Nombre AND Id_proceso = :Id_proceso)
        ";
    $query = $conexion->prepare($sql);
    $query->bindParam(':Id_proceso', $Id_proceso);
    $query->bindParam(':Nombre', $Nombre);
    $query->bindParam(':Nombre_hash', $Nombre_hash);

    if ($query->execute()) {
        if ($query->rowCount() > 0) {


            if (!is_dir('../../assets/adjuntos/' . $Id_proceso)) {
                mkdir('../../assets/adjuntos/' . $Id_proceso);
            }

            move_uploaded_file($File['tmp_name'], "../../assets/adjuntos/" . $Id_proceso . "/" .  $Nombre_hash);
            echo "Subido correctamente";
        } else {
            echo "duplicado";
        }
    } else {
        echo "Error al subir adjunto " . $query->errorInfo();
    }
    $query->closeCursor();
    $query = null;
    $conexion = null;
} catch (Exception $e) {
    echo "ERROR : " . $e->getMessage();
}


