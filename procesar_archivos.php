<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se subieron archivos
    if (isset($_FILES['archivos_txt'])) {
        $archivos = $_FILES['archivos_txt'];
        $datosArchivos = [];

        // Agregar CSS para las tablas
        echo "<style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                padding: 8px 12px;
                text-align: left;
                border: 1px solid #ddd;
            }
            th {
                background-color: #f2f2f2;
                color: #333;
                font-weight: bold;
            }
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            tr:hover {
                background-color: #f1f1f1;
            }
            h3 {
                font-family: Arial, sans-serif;
                color: #333;
            }
        </style>";

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
                    $datosArchivos[$nombreArchivo] = [];
                    foreach ($lineas as $linea) {
                        // Dividir cada línea por comas y almacenar en el array
                        $campos = explode(',', $linea);
                        $datosArchivos[$nombreArchivo][] = $campos;
                    }

                    // Imprimir los campos y posiciones
                    echo "<h3>Campos y posiciones para: " . htmlspecialchars($nombreArchivo) . "</h3>";
                    echo "<table>";
                    echo "<thead><tr>";

                    // Encabezados de columnas
                    $numColumnas = isset($datosArchivos[$nombreArchivo][0]) ? count($datosArchivos[$nombreArchivo][0]) : 0;
                    for ($col = 1; $col <= $numColumnas; $col++) {
                        echo "<th>Columna $col</th>";
                    }
                    echo "</tr></thead><tbody>";

                    // Filas de datos
                    foreach ($datosArchivos[$nombreArchivo] as $fila) {
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

        // Asignar datos de los archivos a variables, según el nombre del archivo
        $acCampos = isset($datosArchivos['AC.txt']) ? $datosArchivos['AC.txt'] : [];
        $afCampos = isset($datosArchivos['AF.txt']) ? $datosArchivos['AF.txt'] : [];
        $apCampos = isset($datosArchivos['AP.txt']) ? $datosArchivos['AP.txt'] : [];
        $usCampos = isset($datosArchivos['US.txt']) ? $datosArchivos['US.txt'] : [];
        $ahCampos = isset($datosArchivos['AH.txt']) ? $datosArchivos['AH.txt'] : [];
        $auCampos = isset($datosArchivos['AU.txt']) ? $datosArchivos['AU.txt'] : [];
        $atCampos = isset($datosArchivos['AT.txt']) ? $datosArchivos['AT.txt'] : [];
        $ctCampos = isset($datosArchivos['CT.txt']) ? $datosArchivos['CT.txt'] : [];
        $amCampos = isset($datosArchivos['AM.txt']) ? $datosArchivos['AM.txt'] : [];
        $anCampos = isset($datosArchivos['AN.txt']) ? $datosArchivos['AN.txt'] : [];

        // echo"\n".'<pre> $datosArchivos[AC.txt]:'."\n";
        // print_r($datosArchivos['AC.txt']);
        // echo"\n<br></pre>(".date('Y-m-d h:i:s A').")<br>\n";

        // die();

        $zip = new ZipArchive();
        $zipFileName = 'archivos_json.zip';

        // Abrir el archivo ZIP para escribir
        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            // Agrupar las líneas por número de factura para el archivo AC (consultas)
            if (!empty($acCampos)) {
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
            }


            // Generar archivos JSON para el archivo AP (procedimientos)
            // Agrupar las líneas de AP por número de factura
            if (!empty($apCampos)) {
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

                    // Solo crear el archivo JSON si hay procedimientos
                    if (!empty($procedimientos)) {
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
                }
            }



            if (!empty($auCampos)) {
                $facturasAu = [];
                foreach ($auCampos as $auFila) {
                    $numFactura = isset($auFila[0]) ? str_replace('-', '', $auFila[0]) : 'sin_factura';
                    if (!isset($facturasAu[$numFactura])) {
                        $facturasAu[$numFactura] = [];
                    }
                    $facturasAu[$numFactura][] = $auFila;
                }

                // Procesar cada grupo de urgencias
                foreach ($facturasAu as $numFactura => $urgenciasFacturas) {
                    $urgencias = [];
                    foreach ($urgenciasFacturas as $auIndex => $urgencia) {
                        $urgencias[] = [
                            "codPrestador" => isset($urgencia[0]) ? $urgencia[0] : '',
                            "fechalnicioAtencion" => isset($urgencia[1]) ? $urgencia[1] : null,
                            "causaMotivoAtencion" => isset($urgencia[2]) ? $urgencia[2] : '',
                            "codDiagnosticoPrincipal" => isset($urgencia[3]) ? $urgencia[3] : '',
                            "codDiagnosticoPrincipalE" => isset($urgencia[4]) ? $urgencia[4] : '',
                            "codDiagnosticoRelacionadoE1" => isset($urgencia[5]) ? $urgencia[5] : '',
                            "codDiagnosticoRelacionadoE2" => isset($urgencia[6]) ? $urgencia[6] : '',
                            "codDiagnosticoRelacionadoE3" => isset($urgencia[7]) ? $urgencia[7] : '',
                            "condicionDestinoUsuarioEgreso" => isset($urgencia[8]) ? $urgencia[8] : null,
                            "codDiagnosticoCausaMuerte" => isset($urgencia[9]) ? $urgencia[9] : null,
                            "fechaEgreso" => isset($urgencia[10]) ? $urgencia[10] : null,
                            "consecutivo" => $auIndex + 1
                        ];
                    }

                    // Crear el JSON con los datos agrupados de urgencias
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
                                "fechaNacimiento" => isset($urgenciasFacturas[0][1]) ? $urgenciasFacturas[0][1] : null, // columna 2 au
                                "codSexo" => isset($usCampos[0][10]) ? $usCampos[0][10] : null, // campo 11 del us
                                "codPaisResidencia" => "169", // Colombia
                                "codMunicipioResidencia" => "76001", // Cali
                                "codZonaTerritorialResidencia" => "02", // Urbana
                                "incapacidad" => "NO",
                                "consecutivo" => 1,
                                "codPaisOrigen" => "169", // Colombia
                                "servicios" => [
                                    "urgencias" => $urgencias // Múltiples urgencias
                                ]
                            ]
                        ]
                    ];

                    // Generar el archivo JSON
                    $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    // Definir el nombre del archivo usando el número de la factura
                    $nombreArchivo = $numFactura . '_au.json';

                    // Agregar el archivo JSON al ZIP
                    $zip->addFromString($nombreArchivo, $json);
                }
            }

            $facturasAh = [];
            foreach ($ahCampos as $ahFila) {
                $numFactura = isset($ahFila[0]) ? str_replace('-', '', $ahFila[0]) : 'sin_factura';
                if (!isset($facturasAh[$numFactura])) {
                    $facturasAh[$numFactura] = [];
                }
                $facturasAh[$numFactura][] = $ahFila;
            }

            // Procesar cada grupo de hospitalización
            foreach ($facturasAh as $numFactura => $hospitalizacionesFacturas) {
                $hospitalizaciones = [];
                foreach ($hospitalizacionesFacturas as $ahIndex => $hospitalizacion) {
                    $hospitalizaciones[] = [
                        "codPrestador" => isset($hospitalizacion[0]) ? $hospitalizacion[0] : '',
                        "viaIngresoServicioSalud" => isset($hospitalizacion[1]) ? $hospitalizacion[1] : '',
                        "fechalnicioAtencion" => isset($hospitalizacion[2]) ? $hospitalizacion[2] : null,
                        "numAutorizacion" => isset($hospitalizacion[3]) ? $hospitalizacion[3] : '',
                        "causaMotivoAtencion" => isset($hospitalizacion[4]) ? $hospitalizacion[4] : '',
                        "codDiagnosticoPrincipal" => isset($hospitalizacion[5]) ? $hospitalizacion[5] : '',
                        "codDiagnosticoPrincipalE" => isset($hospitalizacion[6]) ? $hospitalizacion[6] : '',
                        "codDiagnosticoRelacionadoE1" => isset($hospitalizacion[7]) ? $hospitalizacion[7] : '',
                        "codDiagnosticoRelacionadoE2" => isset($hospitalizacion[8]) ? $hospitalizacion[8] : '',
                        "codDiagnosticoRelacionadoE3" => isset($hospitalizacion[9]) ? $hospitalizacion[9] : '',
                        "codComplicacion" => isset($hospitalizacion[10]) ? $hospitalizacion[10] : '',
                        "condicionDestinoUsuarioEgreso" => isset($hospitalizacion[11]) ? $hospitalizacion[11] : null,
                        "codDiagnosticoMuerte" => isset($hospitalizacion[12]) ? $hospitalizacion[12] : null,
                        "fechaEgreso" => isset($hospitalizacion[13]) ? $hospitalizacion[13] : null,
                        "consecutivo" => $ahIndex + 1
                    ];
                }

                // Crear el JSON con los datos agrupados de hospitalización
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
                            "fechaNacimiento" => isset($hospitalizacionesFacturas[0][2]) ? $hospitalizacionesFacturas[0][2] : null, // columna 3 ah
                            "codSexo" => isset($usCampos[0][10]) ? $usCampos[0][10] : null, // campo 11 del us
                            "codPaisResidencia" => "169", // Colombia
                            "codMunicipioResidencia" => "76001", // Cali
                            "codZonaTerritorialResidencia" => "02", // Urbana
                            "incapacidad" => "NO",
                            "consecutivo" => 1,
                            "codPaisOrigen" => "169", // Colombia
                            "servicios" => [
                                "hospitalizacion" => $hospitalizaciones // Múltiples hospitalizaciones
                            ]
                        ]
                    ]
                ];

                // Generar el archivo JSON
                $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                // Definir el nombre del archivo usando el número de la factura
                $nombreArchivo = $numFactura . '_ah.json';

                // Agregar el archivo JSON al ZIP
                $zip->addFromString($nombreArchivo, $json);
            }

            if (!empty($anCampos)) {
                $facturasRN = [];
                foreach ($anCampos as $rnFila) {
                    $numFactura = isset($rnFila[0]) ? str_replace('-', '', $rnFila[0]) : 'sin_factura';
                    if (!isset($facturasRN[$numFactura])) {
                        $facturasRN[$numFactura] = [];
                    }
                    $facturasRN[$numFactura][] = $rnFila;
                }

                // Procesar cada grupo de recién nacidos
                foreach ($facturasRN as $numFactura => $recienNacidosFacturas) {
                    $recienNacidos = [];
                    foreach ($recienNacidosFacturas as $rnIndex => $recienNacido) {
                        $recienNacidos[] = [
                            "codPrestador" => isset($recienNacido[0]) ? $recienNacido[0] : '',
                            "tipoDocumentoIdentificacion" => isset($recienNacido[1]) ? $recienNacido[1] : '',
                            "numDocumentoIdentificacion" => isset($recienNacido[2]) ? $recienNacido[2] : '',
                            "fechaNacimiento" => isset($recienNacido[3]) ? $recienNacido[3] : null,
                            "edadGestacional" => isset($recienNacido[4]) ? $recienNacido[4] : null,
                            "numConsultasCPrenatal" => isset($recienNacido[5]) ? $recienNacido[5] : null,
                            "codSexoBiologico" => isset($recienNacido[6]) ? $recienNacido[6] : '',
                            "peso" => isset($recienNacido[7]) ? $recienNacido[7] : null,
                            "codDiagnosticoPrincipal" => isset($recienNacido[8]) ? $recienNacido[8] : '',
                            "condicionDestinoUsuarioEgreso" => isset($recienNacido[9]) ? $recienNacido[9] : '',
                            "codDiagnosticoCausaMuerte" => isset($recienNacido[10]) ? $recienNacido[10] : null,
                            "fechaEgreso" => isset($recienNacido[11]) ? $recienNacido[11] : null,
                            "consecutivo" => $rnIndex + 1
                        ];
                    }

                    // Crear el JSON con los datos agrupados de recién nacidos
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
                                "fechaNacimiento" => isset($recienNacidosFacturas[0][3]) ? $recienNacidosFacturas[0][3] : null, // columna 4 rn
                                "codSexo" => isset($usCampos[0][10]) ? $usCampos[0][10] : null, // campo 11 del us
                                "codPaisResidencia" => "169", // Colombia
                                "codMunicipioResidencia" => "76001", // Cali
                                "codZonaTerritorialResidencia" => "02", // Urbana
                                "incapacidad" => "NO",
                                "consecutivo" => 1,
                                "codPaisOrigen" => "169", // Colombia
                                "servicios" => [
                                    "recienNacidos" => $recienNacidos // Múltiples recién nacidos
                                ]
                            ]
                        ]
                    ];

                    // Generar el archivo JSON
                    $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    // Definir el nombre del archivo usando el número de la factura
                    $nombreArchivo = $numFactura . '_rn.json';

                    // Agregar el archivo JSON al ZIP
                    $zip->addFromString($nombreArchivo, $json);
                }
            }


            if (!empty($amCampos)) {
                $facturasAm = [];
                foreach ($amCampos as $amFila) {
                    $numFactura = isset($amFila[0]) ? str_replace('-', '', $amFila[0]) : 'sin_factura';
                    if (!isset($facturasAm[$numFactura])) {
                        $facturasAm[$numFactura] = [];
                    }
                    $facturasAm[$numFactura][] = $amFila;
                }

                // Procesar cada grupo de medicamentos
                foreach ($facturasAm as $numFactura => $medicamentosFacturas) {
                    $medicamentos = [];
                    foreach ($medicamentosFacturas as $amIndex => $medicamento) {
                        $medicamentos[] = [
                            "codPrestador" => isset($medicamento[0]) ? $medicamento[0] : '',
                            "numAutorizacion" => isset($medicamento[1]) ? $medicamento[1] : '',
                            "idMIPRES" => isset($medicamento[2]) ? $medicamento[2] : null,
                            "fechaDispensAdmon" => isset($medicamento[3]) ? $medicamento[3] : null,
                            "codDiagnosticoPrincipal" => isset($medicamento[4]) ? $medicamento[4] : '',
                            "codDiagnosticoRelacionado" => isset($medicamento[5]) ? $medicamento[5] : '',
                            "tipoMedicamento" => isset($medicamento[6]) ? $medicamento[6] : '',
                            "codTecnologiaSalud" => isset($medicamento[7]) ? $medicamento[7] : '',
                            "nomTecnologiaSalud" => isset($medicamento[8]) ? $medicamento[8] : '',
                            "concentracionMedicamento" => isset($medicamento[9]) ? $medicamento[9] : null,
                            "unidadMedida" => isset($medicamento[10]) ? $medicamento[10] : null,
                            "formaFarmaceutica" => isset($medicamento[11]) ? $medicamento[11] : null,
                            "unidadMinDispensa" => isset($medicamento[12]) ? (float)$medicamento[12] : 0,
                            "cantidadMedicamento" => isset($medicamento[13]) ? (float)$medicamento[13] : 0,
                            "diasTratamiento" => isset($medicamento[14]) ? (int)$medicamento[14] : 0,
                            "tipoDocumentoIdentificacion" => isset($medicamento[15]) ? $medicamento[15] : '',
                            "numDocumentoIdentificacion" => isset($medicamento[16]) ? $medicamento[16] : '',
                            "vrUnitMedicamento" => isset($medicamento[17]) ? (float)$medicamento[17] : 0,
                            "vrServicio" => isset($medicamento[18]) ? (float)$medicamento[18] : 0,
                            "conceptoRecaudo" => isset($medicamento[19]) ? $medicamento[19] : null,
                            "valorPagoModerador" => isset($medicamento[20]) ? $medicamento[20] : null,
                            "numFEVPagoModerador" => isset($medicamento[21]) ? $medicamento[21] : null,
                            "consecutivo" => $amIndex + 1
                        ];
                    }

                    // Crear el JSON con los datos agrupados de los medicamentos
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
                                "fechaNacimiento" => isset($medicamentosFacturas[0][4]) ? $medicamentosFacturas[0][4] : null, // columna 5 ap
                                "codSexo" => isset($usCampos[0][10]) ? $usCampos[0][10] : null, // campo 11 del us
                                "codPaisResidencia" => "169", // Colombia
                                "codMunicipioResidencia" => "76001", // Cali
                                "codZonaTerritorialResidencia" => "02", // Urbana
                                "incapacidad" => "NO",
                                "consecutivo" => 1,
                                "codPaisOrigen" => "169", // Colombia
                                "servicios" => [
                                    "medicamentos" => $medicamentos // Múltiples medicamentos
                                ]
                            ]
                        ]
                    ];

                    // Generar el archivo JSON
                    $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    // Definir el nombre del archivo usando el número de la factura
                    $nombreArchivo = $numFactura . '_am.json';

                    // Agregar el archivo JSON al ZIP
                    $zip->addFromString($nombreArchivo, $json);
                }
            }

            if (!empty($atCampos)) {
                $facturasAt = [];
                foreach ($atCampos as $atFila) {
                    $numAutorizacion = isset($atFila[1]) ? $atFila[1] : 'sin_autorizacion';
                    if (!isset($facturasAt[$numAutorizacion])) {
                        $facturasAt[$numAutorizacion] = [];
                    }
                    $facturasAt[$numAutorizacion][] = $atFila;
                }

                foreach ($facturasAt as $numAutorizacion => $otrosServiciosFacturas) {
                    $otrosServicios = [];
                    foreach ($otrosServiciosFacturas as $atIndex => $servicio) {
                        $otrosServicios[] = [
                            "codPrestador" => isset($servicio[0]) ? $servicio[0] : null,
                            "numAutorizacion" => isset($servicio[1]) ? $servicio[1] : null,
                            "idMIPRES" => isset($servicio[2]) ? $servicio[2] : null,
                            "fechaSuministroTecnologia" => isset($servicio[3]) ? $servicio[3] : null,
                            "tipoOS" => isset($servicio[4]) ? $servicio[4] : null,
                            "codTecnologiaSalud" => isset($servicio[5]) ? $servicio[5] : null,
                            "nomTecnologiaSalud" => isset($servicio[6]) ? $servicio[6] : null,
                            "cantidadOS" => isset($servicio[7]) ? (int)$servicio[7] : null,
                            "tipoDocumentoIdentificacion" => isset($servicio[8]) ? $servicio[8] : null,
                            "numDocumentoIdentificacion" => isset($servicio[9]) ? $servicio[9] : null,
                            "vrUnitOS" => isset($servicio[10]) ? (float)$servicio[10] : null,
                            "vrServicio" => isset($servicio[11]) ? (float)$servicio[11] : null,
                            "conceptoRecaudo" => isset($servicio[12]) ? $servicio[12] : null,
                            "valorPagoModerador" => isset($servicio[13]) ? (float)$servicio[13] : null,
                            "numFEVPagoModerador" => isset($servicio[14]) ? $servicio[14] : null,
                            "consecutivo" => $atIndex + 1
                        ];
                    }

                    // Crear el JSON con los datos agrupados de otrosServicios
                    $jsonData = [
                        "numDocumentoIdObligado" => isset($afCampos[0][3]) ? $afCampos[0][3] : null, // nit
                        "numAutorizacion" => $numAutorizacion, // Número de autorización
                        "tipoNota" => null,
                        "numNota" => null,
                        "usuarios" => [
                            [
                                "tipoDocumentoIdentificacion" => isset($usCampos[0][0]) ? $usCampos[0][0] : null,
                                "numDocumentoIdentificacion" => isset($usCampos[0][1]) ? $usCampos[0][1] : null,
                                "tipoUsuario" => "01", // tabla RIPSTipoUsuarioVersion2
                                "fechaNacimiento" => isset($otrosServiciosFacturas[0][4]) ? $otrosServiciosFacturas[0][4] : null, // columna 5 at
                                "codSexo" => isset($usCampos[0][10]) ? $usCampos[0][10] : null, // campo 11 del us
                                "codPaisResidencia" => "169", // Colombia
                                "codMunicipioResidencia" => "76001", // Cali
                                "codZonaTerritorialResidencia" => "02", // Urbana
                                "incapacidad" => "NO",
                                "consecutivo" => 1,
                                "codPaisOrigen" => "169", // Colombia
                                "servicios" => [
                                    "otrosServicios" => $otrosServicios // Múltiples otrosServicios
                                ]
                            ]
                        ]
                    ];

                    // Generar el archivo JSON
                    $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    // Definir el nombre del archivo usando el número de autorización
                    $nombreArchivo = $numFactura  . '_at.json';

                    // Agregar el archivo JSON al ZIP
                    $zip->addFromString($nombreArchivo, $json);
                }
            }

            // Cerrar el archivo ZIP
            $zip->close();

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
            echo "<a href='$zipFileName' download class='btn btn-success btn-lg'>Descargar archivos JSON</a>";
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