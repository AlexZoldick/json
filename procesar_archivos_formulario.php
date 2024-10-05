<?php
// Verificar si hay datos POST

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Inicializar arrays
    $procedimientos = [];
    $urgencias = [];
    $hospitalizacion = [];
    $recienNacidos = [];
    $medicamentos = [];
    $otrosServicios = [];

    if (!empty($_POST['fechaSuministroTecnologiaOtrosservicios'])) {
        $otrosServicios = [
            [
                'cantidadOS' => isset($_POST['cantidadOSOtrosservicios']) ? $_POST['cantidadOSOtrosservicios'] : null,
                'codPrestador' => isset($_POST['codPrestador']) ? $_POST['codPrestador'] : null,
                'codTecnologiaSalud' => isset($_POST['codTecnologiaSaludOtrosservicios']) ? $_POST['codTecnologiaSaludOtrosservicios'] : null,
                'conceptoRecaudo' => isset($_POST['conceptoRecaudoOtrosservicios']) ? $_POST['conceptoRecaudoOtrosservicios'] : null,
                'consecutivo' => isset($_POST['consecutivoOtrosServicios']) ? $_POST['consecutivoOtrosServicios'] : null,
                'fechaSuministroTecnologia' => isset($_POST['fechaSuministroTecnologiaOtrosservicios']) ? $_POST['fechaSuministroTecnologiaOtrosservicios'] : null,
                'nomTecnologiaSalud' => isset($_POST['nomTecnologiaSaludOtrosservicios']) ? $_POST['nomTecnologiaSaludOtrosservicios'] : null,
                'numDocumentoIdentificacion' => isset($_POST['numDocumentoIdentificacionOtrosServicios']) ? $_POST['numDocumentoIdentificacionOtrosServicios'] : null,
                'numFEVPagoModerador' => isset($_POST['numFEVPagoModeradorOtrosServicios']) ? $_POST['numFEVPagoModeradorOtrosServicios'] : null,
                'tipoDocumentoIdentificacion' => isset($_POST['tipoDocumentoIdentificacionOtrosServicios']) ? $_POST['tipoDocumentoIdentificacionOtrosServicios'] : null,
                'tipoOS' => isset($_POST['tipoOS']) ? $_POST['tipoOS'] : null,
                'valorPagoModerador' => isset($_POST['valorPagoModeradorOtrosservicios']) ? $_POST['valorPagoModeradorOtrosservicios'] : null,
                'vrServicio' => isset($_POST['vrServicioOtrosservicios']) ? $_POST['vrServicioOtrosservicios'] : null,
                'vrUnitOS' => isset($_POST['vrUnitOSOtrosservicios']) ? $_POST['vrUnitOSOtrosservicios'] : null
            ]
        ];
    }

    if (!empty($_POST['fechaDispensAdmonmedicamentos'])) {
        $medicamentos = [
            [
                'codPrestador' => isset($_POST['codPrestadormedicamentos']) ? $_POST['codPrestadormedicamentos'] : null,
                'numAutorizacion' => isset($_POST['numAutorizacionmedicamentos']) ? $_POST['numAutorizacionmedicamentos'] : null,
                'idMIPRES' => isset($_POST['idMIPRESmedicamentos']) ? $_POST['idMIPRESmedicamentos'] : null,
                'fechaDispensAdmon' => isset($_POST['fechaDispensAdmonmedicamentos']) ? $_POST['fechaDispensAdmonmedicamentos'] : null,
                'codDiagnosticoPrincipal' => isset($_POST['codDiagnosticoPrincipalmedicamentos']) ? $_POST['codDiagnosticoPrincipalmedicamentos'] : null,
                'codDiagnosticoRelacionado' => isset($_POST['codDiagnosticoRelacionadomedicamentos']) ? $_POST['codDiagnosticoRelacionadomedicamentos'] : null,
                'tipoMedicamento' => isset($_POST['tipoMedicamentomedicamentos']) ? $_POST['tipoMedicamentomedicamentos'] : null,
                'codTecnologiaSalud' => isset($_POST['codTecnologiaSaludmedicamentos']) ? $_POST['codTecnologiaSaludmedicamentos'] : null,
                'nomTecnologiaSalud' => isset($_POST['nomTecnologiaSaludmedicamentos']) ? $_POST['nomTecnologiaSaludmedicamentos'] : null,
                'concentracionMedicamento' => isset($_POST['concentracionMedicamentomedicamentos']) ? $_POST['concentracionMedicamentomedicamentos'] : null,
                'unidadMedida' => isset($_POST['unidadMedidamedicamentos']) ? $_POST['unidadMedidamedicamentos'] : null,
                'formaFarmaceutica' => isset($_POST['formaFarmaceuticamedicamentos']) ? $_POST['formaFarmaceuticamedicamentos'] : null,
                'unidadMinDispensa' => isset($_POST['unidadMinDispensamedicamentos']) ? $_POST['unidadMinDispensamedicamentos'] : null,
                'cantidadMedicamento' => isset($_POST['cantidadMedicamento']) ? $_POST['cantidadMedicamento'] : null,
                'diasTratamiento' => isset($_POST['diasTratamientomedicamentos']) ? $_POST['diasTratamientomedicamentos'] : null,
                'tipoDocumentoIdentificacion' => isset($_POST['tipoDocumentoIdentificacionmedicamentos']) ? $_POST['tipoDocumentoIdentificacionmedicamentos'] : null,
                'numDocumentoIdentificacion' => isset($_POST['numDocumentoIdentificacionmedicamentos']) ? $_POST['numDocumentoIdentificacionmedicamentos'] : null,
                'vrUnitMedicamento' => isset($_POST['vrUnitMedicamento']) ? $_POST['vrUnitMedicamento'] : null,
                'vrServicio' => isset($_POST['vrServiciomedicamentos']) ? $_POST['vrServiciomedicamentos'] : null,
                'conceptoRecaudo' => isset($_POST['conceptoRecaudomedicamentos']) ? $_POST['conceptoRecaudomedicamentos'] : null,
                'valorPagoModerador' => isset($_POST['valorPagoModeradormedicamentos']) ? $_POST['valorPagoModeradormedicamentos'] : null,
                'numFEVPagoModerador' => isset($_POST['numFEVPagoModeradorMedicamentos']) ? $_POST['numFEVPagoModeradorMedicamentos'] : null,
                'consecutivo' => isset($_POST['consecutivoMedicamentos']) ? $_POST['consecutivoMedicamentos'] : null
            ]
        ];
    }

    if (!empty($_POST['fechaNacimientoRecienNacidos'])) {
        $recienNacidos = [
            [
                'codPrestador' => isset($_POST['codPrestadorRecienNacidos']) ? $_POST['codPrestadorRecienNacidos'] : null,
                'tipoDocumentoIdentificacion' => isset($_POST['tipoDocumentoIdentificacionRecienNacidos']) ? $_POST['tipoDocumentoIdentificacionRecienNacidos'] : null,
                'numDocumentoIdentificacion' => isset($_POST['numDocumentoIdentificacionRecienNacidos']) ? $_POST['numDocumentoIdentificacionRecienNacidos'] : null,
                'fechaNacimiento' => isset($_POST['fechaNacimientoRecienNacidos']) ? $_POST['fechaNacimientoRecienNacidos'] : null,
                'edadGestacional' => isset($_POST['edadGestacionalRecienNacidos']) ? $_POST['edadGestacionalRecienNacidos'] : null,
                'numConsultasCPrenatal' => isset($_POST['numConsultasCPrenatalRecienNacidos']) ? $_POST['numConsultasCPrenatalRecienNacidos'] : null,
                'codSexoBiologico' => isset($_POST['codSexoBiologicoRecienNacidos']) ? $_POST['codSexoBiologicoRecienNacidos'] : null,
                'peso' => isset($_POST['pesoRecienNacidos']) ? $_POST['pesoRecienNacidos'] : null,
                'codDiagnosticoPrincipal' => isset($_POST['codDiagnosticoPrincipalRecienNacidos']) ? $_POST['codDiagnosticoPrincipalRecienNacidos'] : null,
                'condicionDestinoUsuarioEgreso' => isset($_POST['condicionDestinoUsuarioEgresoRecienNacidos']) ? $_POST['condicionDestinoUsuarioEgresoRecienNacidos'] : null,
                'codDiagnosticoCausaMuerte' => isset($_POST['codDiagnosticoCausaMuerteRecienNacidos']) ? $_POST['codDiagnosticoCausaMuerteRecienNacidos'] : null,
                'fechaEgreso' => isset($_POST['fechaEgresoRecienNacidos']) ? $_POST['fechaEgresoRecienNacidos'] : null,
                'consecutivo' => isset($_POST['consecutivoRecienNacidos']) ? $_POST['consecutivoRecienNacidos'] : null
            ]
        ];
    }

    if (!empty($_POST['fechaInicioAtencionHospitalizacion'])) {
        $hospitalizacion = [
            [
                'codPrestador' => isset($_POST['codPrestador']) ? $_POST['codPrestador'] : null,
                'viaIngresoServicioSalud' => isset($_POST['viaIngresoServicioSaludHospitalizacion']) ? $_POST['viaIngresoServicioSaludHospitalizacion'] : null,
                'fechaInicioAtencion' => isset($_POST['fechaInicioAtencionHospitalizacion']) ? $_POST['fechaInicioAtencionHospitalizacion'] : null,
                'numAutorizacion' => isset($_POST['numAutorizacionHospitalizacion']) ? $_POST['numAutorizacionHospitalizacion'] : null,
                'causaMotivoAtencion' => isset($_POST['causaMotivoAtencionHospitalizacion']) ? $_POST['causaMotivoAtencionHospitalizacion'] : null,
                'codDiagnosticoPrincipal' => isset($_POST['codDiagnosticoPrincipalHospitalizacion']) ? $_POST['codDiagnosticoPrincipalHospitalizacion'] : null,
                'codDiagnosticoPrincipalE' => isset($_POST['codDiagnosticoPrincipalEHospitalizacion']) ? $_POST['codDiagnosticoPrincipalEHospitalizacion'] : null,
                'codDiagnosticoRelacionadoE1' => isset($_POST['codDiagnosticoRelacionadoE1Hospitalizacion']) ? $_POST['codDiagnosticoRelacionadoE1Hospitalizacion'] : null,
                'codDiagnosticoRelacionadoE2' => isset($_POST['codDiagnosticoRelacionadoE2Hospitalizacion']) ? $_POST['codDiagnosticoRelacionadoE2Hospitalizacion'] : null,
                'codDiagnosticoRelacionadoE3' => isset($_POST['codDiagnosticoRelacionadoE3Hospitalizacion']) ? $_POST['codDiagnosticoRelacionadoE3Hospitalizacion'] : null,
                'codComplicacion' => isset($_POST['codComplicacionHospitalizacion']) ? $_POST['codComplicacionHospitalizacion'] : null,
                'condicionDestinoUsuarioEgreso' => isset($_POST['condicionDestinoUsuarioEgresoHospitalizacion']) ? $_POST['condicionDestinoUsuarioEgresoHospitalizacion'] : null,
                'codDiagnosticoCausaMuerte' => isset($_POST['codDiagnosticoCausaMuerteHospitalizacion']) ? $_POST['codDiagnosticoCausaMuerteHospitalizacion'] : null,
                'fechaEgreso' => isset($_POST['fechaEgresoHospitalizacion']) ? $_POST['fechaEgresoHospitalizacion'] : null,
                'consecutivo' => isset($_POST['consecutivoHospitalizacion']) ? $_POST['consecutivoHospitalizacion'] : null
            ]
        ];
    }

    if (!empty($_POST['fechaInicioAtencionUrgencias'])) {
        $urgencias = [
            [
                'codPrestador' => isset($_POST['codPrestador']) ? $_POST['codPrestador'] : null,
                'fechaInicioAtencion' => isset($_POST['fechaInicioAtencionUrgencias']) ? $_POST['fechaInicioAtencionUrgencias'] : null,
                'causaMotivoAtencion' => isset($_POST['causaMotivoAtencionUrgencias']) ? $_POST['causaMotivoAtencionUrgencias'] : null,
                'codDiagnosticoPrincipal' => isset($_POST['codDiagnosticoPrincipalUrgencias']) ? $_POST['codDiagnosticoPrincipalUrgencias'] : null,
                'codDiagnosticoPrincipalE' => isset($_POST['codDiagnosticoPrincipalEUrgencias']) ? $_POST['codDiagnosticoPrincipalEUrgencias'] : null,
                'codDiagnosticoRelacionadoE1' => isset($_POST['codDiagnosticoRelacionadoE1Urgencias']) ? $_POST['codDiagnosticoRelacionadoE1Urgencias'] : null,
                'codDiagnosticoRelacionadoE2' => isset($_POST['codDiagnosticoRelacionadoE2Urgencias']) ? $_POST['codDiagnosticoRelacionadoE2Urgencias'] : null,
                'condicionDestinoUsuarioEgreso' => isset($_POST['condicionDestinoUsuarioEgresoUrgencias']) ? $_POST['condicionDestinoUsuarioEgresoUrgencias'] : null,
                'codDiagnosticoCausaMuerte' => isset($_POST['codDiagnosticoCausaMuerteUrgencias']) ? $_POST['codDiagnosticoCausaMuerteUrgencias'] : null,
                'fechaEgreso' => isset($_POST['fechaEgresoUrgencias']) ? $_POST['fechaEgresoUrgencias'] : null,
                'consecutivo' => isset($_POST['consecutivoUrgencias']) ? $_POST['consecutivoUrgencias'] : null
            ]
        ];
    }

    if (!empty($_POST['fechaInicioAtencionProcedimientos'])) {
        $procedimientos = [
            [
                'codPrestador' => isset($_POST['codPrestador']) ? $_POST['codPrestador'] : null,
                'fechaInicioAtencion' => isset($_POST['fechaInicioAtencionProcedimientos']) ? $_POST['fechaInicioAtencionProcedimientos'] : null,
                'idMIPRES' => isset($_POST['idMIPRESProcedimientos']) ? $_POST['idMIPRESProcedimientos'] : null,
                'numAutorizacion' => isset($_POST['numAutorizacionProcedimientos']) ? $_POST['numAutorizacionProcedimientos'] : null,
                'codProcedimiento' => isset($_POST['codProcedimientoProcedimientos']) ? $_POST['codProcedimientoProcedimientos'] : null,
                'viaIngresoServicioSalud' => isset($_POST['viaIngresoServicioSalud']) ? $_POST['viaIngresoServicioSalud'] : null,
                'modalidadGrupoServicioTecSal' => isset($_POST['modalidadGrupoServicioTecSalProcedimientos']) ? $_POST['modalidadGrupoServicioTecSalProcedimientos'] : null,
                'grupoServicios' => isset($_POST['grupoServiciosProcedimientos']) ? $_POST['grupoServiciosProcedimientos'] : null,
                'codServicio' => isset($_POST['codServicioProcedimientos']) ? $_POST['codServicioProcedimientos'] : null,
                'finalidadTecnologiaSalud' => isset($_POST['finalidadTecnologiaSaludProcedimientos']) ? $_POST['finalidadTecnologiaSaludProcedimientos'] : null,
                'tipoDocumentoIdentificacion' => isset($_POST['tipoDocumentoIdentificacionProcedimientos']) ? $_POST['tipoDocumentoIdentificacionProcedimientos'] : null,
                'numDocumentoIdentificacion' => isset($_POST['numDocumentoIdentificacionProcedimientos']) ? $_POST['numDocumentoIdentificacionProcedimientos'] : null,
                'codDiagnosticoPrincipal' => isset($_POST['codDiagnosticoPrincipalProcedimientos']) ? $_POST['codDiagnosticoPrincipalProcedimientos'] : null,
                'codDiagnosticoRelacionado' => isset($_POST['codDiagnosticoRelacionadoProcedimientos']) ? $_POST['codDiagnosticoRelacionadoProcedimientos'] : null,
                'codComplicacion' => isset($_POST['codComplicacionProcedimientos']) ? $_POST['codComplicacionProcedimientos'] : null,
                'vrServicio' => isset($_POST['vrServicioProcedimientos']) ? $_POST['vrServicioProcedimientos'] : null,
                'conceptoRecaudo' => isset($_POST['conceptoRecaudoProcedimientos']) ? $_POST['conceptoRecaudoProcedimientos'] : null,
                'valorPagoModerador' => isset($_POST['valorPagoModerador']) ? $_POST['valorPagoModerador'] : null,
                'numFEVPagoModerador' => isset($_POST['numFEVPagoModeradorProcedimientos']) ? $_POST['numFEVPagoModeradorProcedimientos'] : null,
                'consecutivo' => isset($_POST['consecutivoProcedimientos']) ? $_POST['consecutivoProcedimientos'] : null,
            ]
        ];
    }

    if (!empty($_POST['fechaInicioAtencionConsultas'])) {
        $consultas = [
            [
                'codPrestador' => isset($_POST['codPrestador']) ? $_POST['codPrestador'] : null,
                'fechaInicioAtencion' => isset($_POST['fechaInicioAtencionConsultas']) ? $_POST['fechaInicioAtencionConsultas'] : null,
                'numAutorizacion' => isset($_POST['numAutorizacionConsultas']) ? $_POST['numAutorizacionConsultas'] : null,
                'codConsulta' => isset($_POST['codConsultaConsultas']) ? $_POST['codConsultaConsultas'] : null,
                'modalidadGrupoServicioTecSal' => isset($_POST['modalidadGrupoServicioTecSalConsultas']) ? $_POST['modalidadGrupoServicioTecSalConsultas'] : null,
                'grupoServicios' => isset($_POST['grupoServiciosConsultas']) ? $_POST['grupoServiciosConsultas'] : null,
                'codServicio' => isset($_POST['codServicioConsultas']) ? $_POST['codServicioConsultas'] : null,
                'finalidadTecnologiaSalud' => isset($_POST['finalidadTecnologiaSaludConsultas']) ? $_POST['finalidadTecnologiaSaludConsultas'] : null,
                'causaMotivoAtencion' => isset($_POST['causaMotivoAtencionConsultas']) ? $_POST['causaMotivoAtencionConsultas'] : null,
                'codDiagnosticoPrincipal' => isset($_POST['codDiagnosticoPrincipalConsultas']) ? $_POST['codDiagnosticoPrincipalConsultas'] : null,
                'codDiagnosticoRelacionado1' => isset($_POST['codDiagnosticoRelacionado1']) ? $_POST['codDiagnosticoRelacionado1'] : null,
                'codDiagnosticoRelacionado2' => isset($_POST['codDiagnosticoRelacionado2']) ? $_POST['codDiagnosticoRelacionado2'] : null,
                'codDiagnosticoRelacionado3' => isset($_POST['codDiagnosticoRelacionado3']) ? $_POST['codDiagnosticoRelacionado3'] : null,
                'tipoDiagnosticoPrincipal' => isset($_POST['tipoDiagnosticoPrincipal']) ? $_POST['tipoDiagnosticoPrincipal'] : null,
                'tipoDocumentoIdentificacion' => isset($_POST['tipoDocumentoIdentificacionConsultas']) ? $_POST['tipoDocumentoIdentificacionConsultas'] : null,
                'numDocumentoIdentificacion' => isset($_POST['numDocumentoIdentificacionConsultas']) ? $_POST['numDocumentoIdentificacionConsultas'] : null,
                'vrServicio' => isset($_POST['vrServicioConsultas']) ? $_POST['vrServicioConsultas'] : null,
                'conceptoRecaudo' => isset($_POST['conceptoRecaudoConsultas']) ? $_POST['conceptoRecaudoConsultas'] : null,
                'valorPagoModerador' => isset($_POST['valorPagoModeradorConsultas']) ? $_POST['valorPagoModeradorConsultas'] : null,
                'numFEVPagoModerador' => isset($_POST['numFEVPagoModeradorConsultas']) ? $_POST['numFEVPagoModeradorConsultas'] : null,
                'consecutivo' => isset($_POST['consecutivoConsultas']) ? $_POST['consecutivoConsultas'] : null
            ]
        ];
    }

    $respuesta = [
        'numDocumentoIdObligado' => isset($_POST['num_DocumentoIdObligado']) ? $_POST['num_DocumentoIdObligado'] : null,
        'numFactura' => isset($_POST['numFactura']) ? $_POST['numFactura'] : null,
        'tipoNota' => isset($_POST['TipoNota']) ? $_POST['TipoNota'] : null,
        'numNota' => isset($_POST['numNota']) ? $_POST['numNota'] : null,
        'usuarios' => [
            [
                'tipoDocumentoIdentificacion' => isset($_POST['tipoDocumentoIdentificacionUsuario']) ? $_POST['tipoDocumentoIdentificacionUsuario'] : null,
                'numDocumentoIdentificacion' => isset($_POST['numDocumentoIdentificacionUsuario']) ? $_POST['numDocumentoIdentificacionUsuario'] : null,
                'tipoUsuario' => isset($_POST['tipoUsuario']) ? $_POST['tipoUsuario'] : null,
                'fechaNacimiento' => isset($_POST['fechaNacimientoUsuario']) ? $_POST['fechaNacimientoUsuario'] : null,
                'codSexo' => isset($_POST['tipoSexo']) ? $_POST['tipoSexo'] : null,
                'codPaisResidencia' => isset($_POST['codPaisResidencia']) ? $_POST['codPaisResidencia'] : null,
                'codMunicipioResidencia' => isset($_POST['codMunicipioResidenciaUsuarios']) ? $_POST['codMunicipioResidenciaUsuarios'] : null,
                'codZonaTerritorialResidencia' => isset($_POST['codZonaTerritorialResidencia']) ? $_POST['codZonaTerritorialResidencia'] : null,
                'incapacidad' => isset($_POST['incapacidad']) ? $_POST['incapacidad'] : null,
                'codPaisOrigen' => isset($_POST['codPaisOrigen']) ? $_POST['codPaisOrigen'] : null,
                'consecutivo' => isset($_POST['consecutivoUsuarios']) ? (int)$_POST['consecutivoUsuarios'] : null,
                'servicios' => array_filter([
                    'consultas' => array_filter($consultas, function ($consulta) {
                        return !empty($consulta);
                    }),
                    'procedimientos' => array_filter($procedimientos, function ($procedimiento) {
                        return !empty($procedimiento);
                    }),
                    'urgencias' => array_filter($urgencias, function ($urgencia) {
                        return !empty($urgencia);
                    }),
                    'hospitalizacion' => array_filter($hospitalizacion, function ($hospital) {
                        return !empty($hospital);
                    }),
                    'recienNacidos' => array_filter($recienNacidos, function ($recienNacido) {
                        return !empty($recienNacido);
                    }),
                    'medicamentos' => array_filter($medicamentos, function ($medicamento) {
                        return !empty($medicamento);
                    }),
                    'otrosServicios' => array_filter($otrosServicios, function ($servicio) {
                        return !empty($servicio);
                    })
                ], function ($value) {
                    return !empty($value); // Elimina los servicios vacíos
                })
            ]
        ]
    ];

    // Resto del código para crear archivos JSON y el ZIP
    $tempDir = 'temp_files/';
    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0777, true);
    }

    // Función para generar archivos JSON
    function crearArchivoJson($nombreArchivo, $data, $dir)
    {
        $filePath = $dir . $nombreArchivo . '.json';
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
        return $filePath;
    }

    // Generar archivos JSON y almacenar en el directorio temporal
    $archivosGenerados = [];
    $archivosGenerados[] = crearArchivoJson($_POST['numFactura'], $respuesta, $tempDir);

    // Crear el archivo ZIP
    $zip = new ZipArchive();
    $zipFileName = 'archivos_json.zip';
    $zipFilePath = $tempDir . $zipFileName;

    if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
        foreach ($archivosGenerados as $archivo) {
            $zip->addFile($archivo, basename($archivo));
        }
        $zip->close();

        // Forzar la descarga del archivo ZIP
        if (file_exists($zipFilePath)) {
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename=' . basename($zipFilePath));
            header('Content-Length: ' . filesize($zipFilePath));
            readfile($zipFilePath);

            // Limpiar archivos temporales
            foreach ($archivosGenerados as $archivo) {
                unlink($archivo);
            }
            unlink($zipFilePath);
            rmdir($tempDir);
        }
    } else {
        echo "No se pudo crear el archivo ZIP.";
    }
}
