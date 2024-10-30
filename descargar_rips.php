<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rips-json";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Error de conexión: ' . $conn->connect_error]));
}

// Inicializa un arreglo para almacenar los datos a insertar
$datosParaInsertar = [];

// Itera sobre los datos recibidos en $_POST
foreach ($_POST as $key => $value) {
    // Verifica si la clave comienza con "CN-"
    if (strpos($key, 'CN-') === 0) {
        // Extrae el prefijo del número de factura
        $prefijo = substr($key, 0, strpos($key, '_'));

        // Organiza los datos en el arreglo
        $datosParaInsertar[$prefijo][$key] = $value;
    }
}
// Verifica si se envió AC
if (!empty($_POST['AC'])) { 
    // Prepara la inserción en la base de datos
    foreach ($datosParaInsertar as $prefijo => $datos) {
        // Extrae los valores correspondientes
        $tipoDoc = $datos["{$prefijo}_tipoDoc_"] ?? null;
        $Doc = $datos["{$prefijo}_Doc_"] ?? null;
        $numeroFacturaAC = $datos["{$prefijo}_numeroFacturaAC_"] ?? null;
        $codPrestador = $datos["{$prefijo}_codPrestador_"] ?? null;
        // Convierte la fecha de inicio de atención
        $fechaInicioAtencionStr = $datos["{$prefijo}_fechaInicioAtencion_"] ?? null;
        $fechaInicioAtencion = null;

        if ($fechaInicioAtencionStr) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $fechaInicioAtencionStr);
            if ($dateTime) {
                $fechaInicioAtencion = $dateTime->format('Y-m-d'); // Cambia a formato YYYY-MM-DD
            }
        }
        $numAutorizacion = $datos["{$prefijo}_numAutorizacion_"] ?? null;
        $codConsulta = $datos["{$prefijo}_codConsulta_"] ?? null;

        // Prepara la consulta SQL
        $sql = "INSERT INTO consultas (tipoDoc, Doc, numeroFacturaAC, codPrestador, fechaInicioAtencion, numAutorizacion, codConsulta) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Maneja errores de preparación
        if (!$stmt) {
            echo json_encode(['success' => false, 'error' => 'Error en la preparación de la consulta: ' . $conn->error]);
            exit;
        }
        // Asigna los parámetros
        $stmt->bind_param("sssssss", $tipoDoc, $Doc, $numeroFacturaAC, $codPrestador, $fechaInicioAtencion, $numAutorizacion, $codConsulta);
        // Ejecuta la consulta
        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'error' => 'Error al ejecutar la consulta: ' . $stmt->error]);
            exit;
        }
        // Cierra la declaración después de ejecutar
        $stmt->close();
    }
}

if (!empty($_POST['AF'])) {
    // Prepara la inserción en la base de datos para AF
    foreach ($datosParaInsertar as $prefijo => $datos) {
        // Extrae los valores correspondientes para AF
        $numDocumentoIdObligado = $datos["{$prefijo}_numDocumentoIdObligado_"] ?? null;
        $numFacturaAF = $datos["{$prefijo}_numFactura_"] ?? null;
        $tipoNota = $datos["{$prefijo}_tipoNota_"] ?? null;
        $numNota = $datos["{$prefijo}_numNota_"] ?? null;

        $numNota = $datos["{$prefijo}_numNota_"] ?? null;
        // Prepara la consulta SQL
        $sqlAF = "INSERT INTO facturas (numDocumentoIdObligado, numFactura, tipoNota, numNota) VALUES (?, ?, ?, ?)";
        $stmtAF = $conn->prepare($sqlAF);

        // Maneja errores de preparación
        if (!$stmtAF) {
            echo json_encode(['success' => false, 'error' => 'Error en la preparación de la consulta para AF: ' . $conn->error]);
            exit;
        }

        // Asigna los parámetros
        $stmtAF->bind_param("ssss", $numDocumentoIdObligado, $numFacturaAF, $tipoNota, $numNota);

        // Ejecuta la consulta
        if (!$stmtAF->execute()) {
            echo json_encode(['success' => false, 'error' => 'Error al ejecutar la consulta para AF: ' . $stmtAF->error]);
            exit;
        }

        // Cierra la declaración después de ejecutar
        $stmtAF->close();
    }
}

// echo "\n" . '<pre> _POST:' . "\n";
// print_r($_POST);
// echo "\n<br></pre>(" . date('Y-m-d h:i:s A') . ")<br>\n"; 
// die();


if (!empty($_POST['US'])) {
    // Prepara la inserción en la base de datos para US
    $datosParaInsertar1 = []; // Inicializa el arreglo

    foreach ($_POST as $key => $value) {
        // Verifica si la clave contiene "_tipoDocumentoIdentificacion_"
        if (strpos($key, '_') !== false) {
            // Extrae el prefijo del número de documento de identificación
            $prefijo = substr($key, 0, strpos($key, '_'));

            // Organiza los datos en el arreglo
            $datosParaInsertar1[$prefijo][$key] = $value;
        }
    }

    // Verifica si $datosParaInsertar1 tiene elementos antes de entrar al foreach
    if (!empty($datosParaInsertar1)) {
        foreach ($datosParaInsertar1 as $prefijo => $datos) {
            // Extrae los valores correspondientes para US
            $tipoDocumentoIdentificacion = $datos["{$prefijo}_tipoDocumentoIdentificacion"] ?? null;
            $numDocumentoIdentificacion = $datos["{$prefijo}_numDocumentoIdentificacion"] ?? null;
            $numDocumentoIdObligado = $datos["{$prefijo}_numDocumentoIdObligado"] ?? null;

            // Prepara la consulta SQL
            $sqlUS = "INSERT INTO usuarios (tipoDocumentoIdentificacion, numDocumentoIdentificacion, num_DocumentoIdObligado) VALUES (?, ?, ?)";
            $stmtUS = $conn->prepare($sqlUS);

            // Maneja errores de preparación
            if (!$stmtUS) {
                echo json_encode(['success' => false, 'error' => 'Error en la preparación de la consulta para US: ' . $conn->error]);
                exit;
            }

            // Asigna los parámetros
            $stmtUS->bind_param("sss", $tipoDocumentoIdentificacion, $numDocumentoIdentificacion, $numDocumentoIdObligado);

            // Ejecuta la consulta
            if (!$stmtUS->execute()) {
                echo json_encode(['success' => false, 'error' => 'Error al ejecutar la consulta para US: ' . $stmtUS->error]);
                exit;
            }

            // Cierra la declaración después de ejecutar
            $stmtUS->close();
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No se encontraron datos para insertar.']);
    }
}



if (!empty($_POST['AP'])) {
    // Prepara la inserción en la base de datos para AP
    foreach ($datosParaInsertar as $prefijo => $datos) {
        // Extrae los valores correspondientes para AP
        $tipoDoc = $datos["{$prefijo}_tipoDoc_"] ?? null;
        $Doc = $datos["{$prefijo}_Doc_"] ?? null;
        $numDocumentoIdObligado = $datos["{$prefijo}_Doc_"] ?? null; // Manteniendo la lógica original
        $numFacturaAP = $datos["{$prefijo}_numeroFacturaAP"] ?? null; // Manteniendo el nombre original
        $numAutorizacion = $datos["{$prefijo}_numAutorizacionAP"] ?? null; // Capturando autorización
        $codPrestador = $datos["{$prefijo}_codPrestadorAP"] ?? null; // Capturando código de prestador
        $codProcedimiento = $datos["{$prefijo}_codProcedimientoAP"] ?? null; // Capturando código de procedimiento
        $idMIPRESAP = $datos["{$prefijo}_idMIPRESAP"] ?? null;

        // Manejo de la fecha de inicio de atención
        $fechaInicioAtencionStr = $datos["{$prefijo}_fechaInicioAtencionAP"] ?? null;
        $fechaInicioAtencion = null;

        if ($fechaInicioAtencionStr) {
            $dateTime = DateTime::createFromFormat('d/m/Y', $fechaInicioAtencionStr);
            if ($dateTime) {
                $fechaInicioAtencion = $dateTime->format('Y-m-d'); // Cambia a formato YYYY-MM-DD
            }
        }

        // Prepara la consulta SQL
        $sqlAP = "INSERT INTO procedimientos (tipoDoc, doc, numeroFacturaAP, codPrestador, fechaInicioAtencion, idMIPRES, numAutorizacion, codProcedimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtAP = $conn->prepare($sqlAP);

        // Maneja errores de preparación
        if (!$stmtAP) {
            echo json_encode(['success' => false, 'error' => 'Error en la preparación de la consulta para AP: ' . $conn->error]);
            exit;
        }

        // Asigna los parámetros
        $stmtAP->bind_param("ssssssss", $tipoDoc, $Doc, $numDocumentoIdObligado, $numFacturaAP, $fechaInicioAtencion, $idMIPRESAP, $numAutorizacion, $codProcedimiento);

        // Ejecuta la consulta
        if (!$stmtAP->execute()) {
            echo json_encode(['success' => false, 'error' => 'Error al ejecutar la consulta para AP: ' . $stmtAP->error]);
            exit;
        }

        // Cierra la declaración después de ejecutar
        $stmtAP->close();
    }
}




// Cierra la conexión
$conn->close();

echo json_encode(['success' => true]);
