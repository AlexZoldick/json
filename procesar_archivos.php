<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se subieron archivos
    if (isset($_FILES['archivos_txt'])) {
        $archivos = $_FILES['archivos_txt'];
        $datosArchivos = [];

        // Iterar sobre los archivos subidos
        for ($i = 0; $i < count($archivos['name']); $i++) {
            // Comprobar si hubo algún error en la subida del archivo
            if ($archivos['error'][$i] === UPLOAD_ERR_OK) {
                $archivoTmp = $archivos['tmp_name'][$i];
                $nombreArchivo = $archivos['name'][$i];
                $tipoArchivo = $archivos['type'][$i];

                // Asegurarse de que el archivo sea de texto
                if ($tipoArchivo == 'text/plain') {
                    $contenidoArchivo = file_get_contents($archivoTmp);

                    // Procesar líneas del archivo
                    $lineas = explode(PHP_EOL, $contenidoArchivo);
                    $datosArchivos[$i] = [];
                    foreach ($lineas as $linea) {
                        // Dividir cada línea por comas y almacenar en el array
                        $campos = explode(',', $linea);
                        $datosArchivos[$i][] = $campos;
                    }

                    // Mostrar el contenido del archivo
                    // echo "<h2>Contenido del archivo: " . htmlspecialchars($nombreArchivo) . "</h2>";
                    // echo "<pre>" . htmlspecialchars($contenidoArchivo) . "</pre>";

                    // Imprimir los campos y posiciones
                    echo "<h3>Campos y posiciones para: " . htmlspecialchars($nombreArchivo) . "</h3>";
                    echo "<table border='1' cellpadding='5' cellspacing='0'>";
                    echo "<thead><tr>";

                    // Encabezados de columnas
                    $numColumnas = isset($datosArchivos[$i][0]) ? count($datosArchivos[$i][0]) : 0;
                    for ($col = 1; $col <= $numColumnas; $col++) {
                        echo "<th>Columna $col</th>";
                    }
                    echo "</tr></thead><tbody>";

                    // Filas de datos
                    foreach ($datosArchivos[$i] as $fila) {
                        echo "<tr>";
                        foreach ($fila as $campo) {
                            echo "<td>" . htmlspecialchars($campo) . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</tbody></table><hr>";
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo no válido',
                            text: 'Uno de los archivos no es un .txt válido.'
                        }).then(function() {
                            window.location.href = 'subir_archivo.php';
                        });
                    </script>";
                    exit;
                }
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al subir archivo',
                        text: 'Ocurrió un error al intentar subir uno de los archivos.'
                    }).then(function() {
                        window.location.href = 'subir_archivo.php';
                    });
                </script>";
                exit;
            }
        }

        // Asegúrate de que se han subido los 4 archivos necesarios
        // if (count($archivos['name']) == 4) {
        // Asigna los datos a las variables correspondientes según el índice del archivo
        // Asignar datos de los archivos a variables, si existen

        $acCampos = isset($datosArchivos[0]) ? $datosArchivos[0] : [];
        $afCampos = isset($datosArchivos[1]) ? $datosArchivos[1] : [];
        $apCampos = isset($datosArchivos[2]) ? $datosArchivos[2] : [];
        $usCampos = isset($datosArchivos[3]) ? $datosArchivos[3] : [];
        $ctCampos = isset($datosArchivos[4]) ? $datosArchivos[4] : [];

        $zip = new ZipArchive();
        $zipFileName = 'archivos_json.zip';

        // Abrir el archivo ZIP para escribir
        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            // Agrupar las líneas por número de factura para el archivo AC (consultas)
            $facturasAc = [];
            foreach ($acCampos as $acFila) {
                $numFactura = isset($acFila[0]) ? str_replace('-', '', $acFila[0]) : 'sin_factura';
                $facturasAc[$numFactura][] = $acFila;
            }

            // Agrupar las líneas por número de factura para el archivo AP (procedimientos)
            $facturasAp = [];
            foreach ($apCampos as $apFila) {
                $numFactura = isset($apFila[0]) ? str_replace('-', '', $apFila[0]) : 'sin_factura';
                $facturasAp[$numFactura][] = $apFila;
            }

            // Generar archivos JSON para el archivo AC (consultas) agrupadas por número de factura
            foreach ($facturasAc as $numFactura => $consultasFacturas) {
                $consultas = [];
                foreach ($consultasFacturas as $acIndex => $consulta) {
                    $consultas[] = [
                        "codPrestador" => isset($ctCampos[0][0]) ? $ctCampos[0][0] : (isset($afCampos[0][0]) ? $afCampos[0][0] : null),
                        "fechaInicioAtencion" => isset($consulta[4]) ? $consulta[4] : null,
                        "numAutorizacion" => isset($consulta[5]) ? $consulta[5] : null,
                        "codConsulta" => isset($consulta[6]) ? $consulta[6] : null,
                        "modalidadGrupoServicioTecSal" => "01",
                        "grupoServicios" => "01",
                        "codServicio" => "328", // Medicina general
                        "finalidadTecnologiaSalud" => isset($consulta[7]) ? $consulta[7] : null,
                        "causaMotivoAtencion" => "38", // Enfermedad general
                        "codDiagnosticoPrincipal" => isset($consulta[9]) ? $consulta[9] : null,
                        "codDiagnosticoRelacionado1" => isset($consulta[10]) ? $consulta[10] : null,
                        "codDiagnosticoRelacionado2" => isset($consulta[11]) ? $consulta[11] : null,
                        "codDiagnosticoRelacionado3" => isset($consulta[12]) ? $consulta[12] : null,
                        "tipoDiagnosticoPrincipal" => isset($consulta[13]) ? $consulta[13] : null,
                        "tipoDocumentoIdentificacion" => isset($consulta[18]) ? $consulta[18] : null,
                        "numDocumentoIdentificacion" => isset($consulta[19]) ? $consulta[19] : null,
                        "vrServicio" => isset($consulta[20]) ? $consulta[20] : null,
                        "conceptoRecaudo" => isset($consulta[21]) ? $consulta[21] : null,
                        "valorPagoModerador" => isset($consulta[22]) ? $consulta[22] : 0,
                        "numFEVPagoModerador" => isset($consulta[23]) ? $consulta[23] : null,
                        "consecutivo" => $acIndex + 1
                    ];
                }

                // Crear el JSON con los datos agrupados de las consultas
                $jsonData = [
                    "numDocumentoIdObligado" => isset($afCampos[0][3]) ? $afCampos[0][3] : null, // nit
                    "numFactura" => $numFactura, // Número de factura Dian
                    "tipoNota" => null,
                    "numNota" => null,
                    "usuarios" => [
                        [
                            "tipoDocumentoIdentificacion" => isset($usCampos[0][0]) ? $usCampos[0][0] : null,
                            "numDocumentoIdentificacion" => isset($usCampos[0][1]) ? $usCampos[0][1] : null,
                            "tipoUsuario" => "01", // tabla RIPSTipoUsuarioVersion2
                            "fechaNacimiento" => isset($consultasFacturas[0][4]) ? $consultasFacturas[0][4] : null, // columna 5 ac
                            "codSexo" => isset($usCampos[0][10]) ? $usCampos[0][10] : null, // campo 11 del us
                            "codPaisResidencia" => "169", // Colombia
                            "codMunicipioResidencia" => "76001", // Cali
                            "codZonaTerritorialResidencia" => "02", // Urbana
                            "incapacidad" => "NO",
                            "consecutivo" => 1,
                            "codPaisOrigen" => "169", // Colombia
                            "servicios" => [
                                "consultas" => $consultas // Múltiples consultas
                            ]
                        ]
                    ]
                ];

                // Generar el archivo JSON
                $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                // Definir el nombre del archivo usando el número de la factura
                $nombreArchivo = $numFactura . '.json';

                // Agregar el archivo JSON al ZIP
                $zip->addFromString($nombreArchivo, $json);
            }

            // Generar archivos JSON para el archivo AP (procedimientos)
            // Agrupar las líneas de AP por número de factura
            $facturasAp = [];
            foreach ($apCampos as $apFila) {
                $numFactura = isset($apFila[0]) ? str_replace('-', '', $apFila[0]) : 'sin_factura';
                if (!isset($facturasAp[$numFactura])) {
                    $facturasAp[$numFactura] = [];
                }
                $facturasAp[$numFactura][] = $apFila;
            }

            // Generar archivos JSON para el archivo AP (procedimientos) agrupados por número de factura
            foreach ($facturasAp as $numFactura => $procedimientosFacturas) {
                $procedimientos = [];
                foreach ($procedimientosFacturas as $apIndex => $procedimiento) {
                    $procedimientos[] = [
                        "codPrestador" => "760010254101",
                        "fechaInicioAtencion" => isset($procedimiento[4]) ? $procedimiento[4] : null,
                        "idMIPRES" => null,
                        "numAutorizacion" => isset($procedimiento[5]) ? $procedimiento[5] : null,
                        "codProcedimiento" => isset($procedimiento[6]) ? $procedimiento[6] : null,
                        "viaIngresoServicioSalud" => "",
                        "modalidadGrupoServicioTecSal" => "",
                        "grupoServicios" => null,
                        "codServicio" => null,
                        "finalidadTecnologiaSalud" => "15",
                        "tipoDocumentoIdentificacion" => "CC",
                        "numDocumentoIdentificacion" => "1112883280",
                        "codDiagnosticoPrincipal" => "J46X",
                        "codDiagnosticoRelacionado" => "J46X",
                        "codComplicacion" => "",
                        "vrServicio" => 87702,
                        "conceptoRecaudo" => null,
                        "valorPagoModerador" => 0,
                        "numFEVPagoModerador" => null,
                        "consecutivo" => $apIndex + 1
                    ];
                }

                // Crear el JSON con los datos agrupados de los procedimientos
                $jsonData = [
                    "numDocumentoIdObligado" => isset($afCampos[0][3]) ? $afCampos[0][3] : null, // nit
                    "numFactura" => $numFactura, // Número de factura Dian
                    "tipoNota" => null,
                    "numNota" => null,
                    "usuarios" => [
                        [
                            "tipoDocumentoIdentificacion" => isset($usCampos[0][0]) ? $usCampos[0][0] : null,
                            "numDocumentoIdentificacion" => isset($usCampos[0][1]) ? $usCampos[0][1] : null,
                            "tipoUsuario" => "01", // tabla RIPSTipoUsuarioVersion2
                            "fechaNacimiento" => isset($procedimientosFacturas[0][4]) ? $procedimientosFacturas[0][4] : null, // columna 5 ap
                            "codSexo" => isset($usCampos[0][10]) ? $usCampos[0][10] : null, // campo 11 del us
                            "codPaisResidencia" => "169", // Colombia
                            "codMunicipioResidencia" => "76001", // Cali
                            "codZonaTerritorialResidencia" => "02", // Urbana
                            "incapacidad" => "NO",
                            "consecutivo" => 1,
                            "codPaisOrigen" => "169", // Colombia
                            "servicios" => [
                                "procedimientos" => $procedimientos // Múltiples procedimientos
                            ]
                        ]
                    ]
                ];

                // Generar el archivo JSON
                $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                // Definir el nombre del archivo usando el número de la factura
                $nombreArchivo = $numFactura . '_ap.json';

                // Agregar el archivo JSON al ZIP
                $zip->addFromString($nombreArchivo, $json);
            }

            // Cerrar el archivo ZIP
            $zip->close();

            // Retornar o descargar el archivo ZIP

            // Mostrar el mensaje de éxito y enlace de descarga
            echo "<!DOCTYPE html>";
            echo "<html lang='es'>";
            echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
            echo "<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>";
            echo "<title>Descarga completada</title>";
            echo "</head>";
            echo "<body>";
            echo "<div class='container text-center mt-4'>";
            echo "<h2>Archivo ZIP generado exitosamente.</h2>";
            echo "<br>";
            echo "<a href='$zipFileName' download class='btn btn-Warning btn-lg'>Descargar archivos JSON</a>";
            echo "</div>";
            echo "<script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>";
            echo "<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js'></script>";
            echo "<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>";
            echo "</body>";
            echo "</html>";
        } else {
            echo "Error al crear el archivo ZIP.";
        }
        // } else {
        //     echo "Por favor, sube los 4 archivos necesarios (af, us, ct, ac).";
        // }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'No se seleccionaron archivos',
                text: 'Por favor, selecciona al menos un archivo para subir.'
            }).then(function() {
                window.location.href = 'subir_archivo.php';
            });
        </script>";
    }
} else {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Solicitud no válida',
            text: 'Método de solicitud no válido.'
        }).then(function() {
            window.location.href = 'subir_archivo.php';
        });
    </script>";
}
?>

<!-- Botón "Volver" -->
<div style="text-align: center; margin-top: 20px;">
    <a href="http://localhost/json/html">
        <button style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Volver
        </button>
    </a>
</div>
