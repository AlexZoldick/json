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

            .alto-select {
                height: 50px; /* Ajusta el valor según lo necesites */
            }
        </style>";

        // Iterar sobre los archivos subidos
        for ($i = 0; $i < count($archivos['name']); $i++) {
            // Comprobar si hubo alg�n error en la subida del archivo
            if ($archivos['error'][$i] === UPLOAD_ERR_OK) {
                $archivoTmp = $archivos['tmp_name'][$i];
                $nombreArchivo = $archivos['name'][$i];
                $tipoArchivo = $archivos['type'][$i];

                // Asegurarse de que el archivo sea de texto
                if ($tipoArchivo == 'text/plain') {
                    $contenidoArchivo = file_get_contents($archivoTmp);

                    // Procesar l�neas del archivo
                    $lineas = explode(PHP_EOL, $contenidoArchivo);
                    $datosArchivos[$nombreArchivo] = [];
                    foreach ($lineas as $linea) {
                        // Dividir cada l�nea por comas y almacenar en el array
                        $campos = explode(',', $linea);
                        $datosArchivos[$nombreArchivo][] = $campos;
                    }

                    // Lista de nombres de columnas especificos para el archivo AC.txt
                    $columnasAC = [
                        'numeroFacturaAC',
                        'codPrestador',
                        'fechaInicioAtencion',
                        'numAutorizacion',
                        'codConsulta',
                        'modalidadGrupoServicioTecSal',
                        'grupoServicios',
                        'codServicio',
                        'finalidadTecnologiaSalud',
                        'causaMotivoAtencion',
                        'codDiagnosticoPrincipal',
                        'codDiagnosticoRelacionado1',
                        'codDiagnosticoRelacionado2',
                        'codDiagnosticoRelacionado3',
                        'tipoDiagnosticoPrincipal',
                        'tipoDocumentoIdentificacion',
                        'numDocumentoIdentificacion',
                        'vrServicio',
                        'conceptoRecaudo',
                        'valorPagoModerador',
                        'numFEVPagoModerador',
                        'consecutivo'
                    ];

                    // Lista de nombres de columnas especificos para el archivo AU.txt
                    $columnasAU = [
                        'numeroFacturaAU',
                        'codPrestador',
                        'fechaInicioAtencion',
                        'causaMotivoAtencion',
                        'codDiagnosticoPrincipal',
                        'codDiagnosticoPrincipalE',
                        'codDiagnosticoRelacionadoE1',
                        'codDiagnosticoRelacionadoE2',
                        'codDiagnosticoRelacionadoE3',
                        'condicionDestinoUsuarioEgreso',
                        'codDiagnosticoCausaMuerte',
                        'fechaEgreso',
                        'consecutivo'
                    ];

                    // Lista de nombres de columnas espec�ficos para el archivo AP.txt
                    $columnasAP = [
                        'numeroFacturaAP',
                        'codPrestador',
                        'fechaInicioAtencion',
                        'idMIPRES',
                        'numAutorizacion',
                        'codProcedimiento',
                        'viaIngresoServicioSalud',
                        'modalidadGrupoServicioTecSal',
                        'grupoServicios',
                        'codServicio',
                        'finalidadTecnologiaSalud',
                        'tipoDocumentoIdentificacion',
                        'numDocumentoIdentificacion',
                        'codDiagnosticoPrincipal',
                        'codDiagnosticoRelacionado',
                        'codComplicacion',
                        'vrServicio',
                        'conceptoRecaudo',
                        'valorPagoModerador',
                        'numFEVPagoModerador',
                        'consecutivo'
                    ];

                    // Lista de nombres de columnas espec�ficos para el archivo AM.txt
                    $columnasAM = [
                        'numeroFacturaAM',
                        'codPrestador',
                        'numAutorizacion',
                        'idMIPRES',
                        'fechaDispensAdmon',
                        'codDiagnosticoPrincipal',
                        'codDiagnosticoRelacionado',
                        'tipoMedicamento',
                        'codTecnologiaSalud',
                        'nomTecnologiaSalud',
                        'concentracionMedicamento',
                        'unidadMedida',
                        'formaFarmaceutica',
                        'unidadMinDispensa',
                        'cantidadMedicamento',
                        'diasTratamiento',
                        'tipoDocumentoIdentificacion',
                        'numDocumentoIdentificacion',
                        'vrUnitMedicamento',
                        'vrServicio',
                        'conceptoRecaudo',
                        'valorPagoModerador',
                        'numFEVPagoModerador',
                        'consecutivo'
                    ];

                    // Lista de nombres de columnas especificos para el archivo AT.txt
                    $columnasAT = [
                        'numeroFacturaAT',
                        'codPrestador',
                        'numAutorizacion',
                        'idMIPRES',
                        'fechaSuministroTecnologia',
                        'tipoOS',
                        'codTecnologiaSalud',
                        'nomTecnologiaSalud',
                        'cantidadOS',
                        'tipoDocumentoIdentificacion',
                        'numDocumentoIdentificacion',
                        'vrUnitOS',
                        'vrServicio',
                        'conceptoRecaudo',
                        'valorPagoModerador',
                        'numFEVPagoModerador',
                        'consecutivo'
                    ];

                    // Lista de nombres de columnas espec�ficos para el archivo AN.txt
                    $columnasAN = [
                        'numeroFacturaAN',
                        'consecutivoUsuario',
                        'codPrestador',
                        'tipoDocumentoIdentificacion',
                        'numDocumentoIdentificacion',
                        'fechaNacimiento',
                        'edadGestacional',
                        'numConsultasCPrenatal',
                        'codSexoBiologico',
                        'peso',
                        'codDiagnosticoPrincipal',
                        'condicionDestinoUsuarioEgreso',
                        'codDiagnosticoCausaMuerte',
                        'fechaEgreso',
                        'consecutivo'
                    ];

                    // Lista de nombres de columnas espec�ficos para el archivo AH.txt
                    $columnasAH = [
                        'numeroFacturaAH',
                        'codPrestador',
                        'viaIngresoServicioSalud',
                        'fechaInicioAtencion',
                        'numAutorizacion',
                        'causaMotivoAtencion',
                        'codDiagnosticoPrincipal',
                        'codDiagnosticoPrincipalE',
                        'codDiagnosticoRelacionadoE1',
                        'codDiagnosticoRelacionadoE2',
                        'codDiagnosticoRelacionadoE3',
                        'codComplicacion',
                        'condicionDestinoUsuarioEgreso',
                        'codDiagnosticoCausaMuerte',
                        'fechaEgreso',
                        'consecutivo'
                    ];

                    $columnasUS = [
                        'tipoDocumentoIdentificacion',
                        'numDocumentoIdentificacion',
                        'num_DocumentoIdObligado',
                        'tipoUsuario',
                        'fechaNacimiento',
                        'codSexo',
                        'codPaisResidencia',
                        'codMunicipioResidencia',
                        'codZonaTerritorialResidencia',
                        'incapacidad',
                        'codPaisOrigen',
                        'consecutivo'
                    ];

                    $columnasAF = [
                        'numDocumentoIdObligado',
                        'numFactura',
                        'tipoNota',
                        'numNota'
                    ];

                    echo "<h3>Campos y posiciones para: " . htmlspecialchars($nombreArchivo) . "</h3>";
                    echo "<form action='procesar_archivos.php' method='POST'>";  // Cambia la acción y el método según tus necesidades
                    echo "<table>";
                    echo "<thead><tr>";

                    // Encabezados de columnas para AC.txt
                    if ($nombreArchivo === 'AC.txt') {
                        foreach ($columnasAC as $nombreColumna) {
                            echo "<th>" . htmlspecialchars($nombreColumna) . "</th>";
                        }
                    } elseif ($nombreArchivo === 'AU.txt') {
                        foreach ($columnasAU as $nombreColumna) {
                            echo "<th>" . htmlspecialchars($nombreColumna) . "</th>";
                        }
                    } elseif ($nombreArchivo === 'AP.txt') {
                        foreach ($columnasAP as $nombreColumna) {
                            echo "<th>" . htmlspecialchars($nombreColumna) . "</th>";
                        }
                    } elseif ($nombreArchivo === 'AM.txt') {
                        foreach ($columnasAM as $nombreColumna) {
                            echo "<th>" . htmlspecialchars($nombreColumna) . "</th>";
                        }
                    } elseif ($nombreArchivo === 'AT.txt') {
                        foreach ($columnasAT as $nombreColumna) {
                            echo "<th>" . htmlspecialchars($nombreColumna) . "</th>";
                        }
                    } elseif ($nombreArchivo === 'AN.txt') {
                        foreach ($columnasAN as $nombreColumna) {
                            echo "<th>" . htmlspecialchars($nombreColumna) . "</th>";
                        }
                    } elseif ($nombreArchivo === 'AH.txt') {
                        foreach ($columnasAH as $nombreColumna) {
                            echo "<th>" . htmlspecialchars($nombreColumna) . "</th>";
                        }
                    } elseif ($nombreArchivo === 'US.txt') {
                        foreach ($columnasUS as $nombreColumna) {
                            echo "<th>" . htmlspecialchars($nombreColumna) . "</th>";
                        }
                    } elseif ($nombreArchivo === 'AF.txt') {
                        foreach ($columnasAF as $nombreColumna) {
                            echo "<th>" . htmlspecialchars($nombreColumna) . "</th>";
                        }
                    } else {
                        $numColumnas = isset($datosArchivos[$nombreArchivo][0]) ? count($datosArchivos[$nombreArchivo][0]) : 0;
                        for ($col = 1; $col <= $numColumnas; $col++) {
                            echo "<th>Columna $col</th>";
                        }
                    }

                    echo "</tr></thead><tbody>";

                    // echo"\n".'<pre> $datosArchivos[$AC.txt]:'."\n";
                    // print_r($datosArchivos['AC.txt']);
                    // echo"\n<br></pre>(".date('Y-m-d h:i:s A').")<br>\n";
                    $contadorFactura = 1; // Inicializar un contador para la factura

                    foreach ($datosArchivos[$nombreArchivo] as $fila) {
                        $numeroFactura = htmlspecialchars($fila[0]) . '-' . $contadorFactura;
                        echo "<tr>";

                        if ($nombreArchivo === 'AC.txt') {
                            echo "<form id='formAC' method='POST'>";
                            foreach ($columnasAC as $index => $nombreColumna) {
                                switch ($nombreColumna) {
                                    case 'numeroFacturaAC':
                                        echo "<td><input type='text' class='form-control' id='_numeroFacturaAC_{$numeroFactura}' name='numeroFacturaAC{$numeroFactura}' value='" . htmlspecialchars($fila[0]) . "'></td>";
                                        break;
                                    case 'codPrestador':
                                        echo "<td><input type='text' class='form-control' id='_codPrestadorAC_{$numeroFactura}' name='codPrestadorAC_{$numeroFactura}' value='" . htmlspecialchars($fila[1]) . "'></td>";
                                        break;
                                    case 'fechaInicioAtencion':
                                        echo "<td><input type='text' class='form-control' id='_fechaInicioAtencionAC_{$numeroFactura}' name='fechaInicioAtencionAC_{$numeroFactura}' value='" . htmlspecialchars($fila[4]) . "'></td>";
                                        break;
                                    case 'numAutorizacion':
                                        echo "<td><input type='text' class='form-control' id='_numAutorizacionAC_{$numeroFactura}' name='numAutorizacionAC_{$numeroFactura}' value='" . htmlspecialchars($fila[5]) . "'></td>";
                                        break;
                                    case 'codConsulta':
                                        echo "<td><input type='text' class='form-control' id='_codConsultaAC_{$numeroFactura}' name='codConsultaAC_{$numeroFactura}' value='" . htmlspecialchars($fila[6]) . "'></td>";
                                        break;
                                    case 'modalidadGrupoServicioTecSal':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_modalidadGrupoServicioTecSalAC_{$numeroFactura}'</label>
                                                        <select class='form-select form-select-lg' id='_modalidadGrupoServicioTecSalAC_{$numeroFactura}' name='modalidadGrupoServicioTecSalAC_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione Modalidad Grupo Servicio</option>
                                                            <option value='01'>Intramural</option>
                                                            <option value='02'>Extramural unidad móvil</option>
                                                            <option value='03'>Extramural domiciliaria</option>
                                                            <option value='04'>Extramural jornada de salud</option>
                                                            <option value='06'>Telemedicina interactiva</option>
                                                            <option value='07'>Telemedicina no interactiva</option>
                                                            <option value='08'>Telemedicina telexperticia</option>
                                                            <option value='09'>Telemedicina telemonitoreo</option>
                                                        </select>
                                                    </div>
                                                  </td>";
                                        break;
                                    case 'grupoServicios':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_grupoServiciosAC_{$numeroFactura}'</label>
                                                        <select class='form-select form-select-lg' id='_grupoServiciosAC_{$numeroFactura}' name='grupoServiciosAC_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione Grupo de servicios</option>
                                                            <option value='01'>Consulta externa</option>
                                                            <option value='02'>Apoyo diagnóstico y complementación terapéutica</option>
                                                            <option value='03'>Internación</option>
                                                            <option value='04'>Quirúrgico</option>
                                                            <option value='05'>Atención inmediata</option>
                                                        </select>
                                                    </div>
                                                  </td>";
                                        break;
                                    case 'codServicio':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_codServicioAC_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_codServicioAC_{$numeroFactura}' name='codServicioAC_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione Codigo de servicio</option>>
                                                        <option value='105'>CUIDADO INTERMEDIO NEONATAL</option>
                                                        <option value='106'>CUIDADO INTERMEDIO PEDIATRICO</option>
                                                        <option value='107'>CUIDADO INTERMEDIO ADULTOS</option>
                                                        <option value='108'>CUIDADO INTENSIVO NEONATAL</option>
                                                        <option value='109'>CUIDADO INTENSIVO PEDIATRICO</option>
                                                        <option value='110'>CUIDADO INTENSIVO ADULTOS</option>
                                                        <option value='1101'>ATENCION DEL PARTO</option>
                                                        <option value='1102'>URGENCIAS</option>
                                                        <option value='1103'>TRANSPORTE ASISTENCIAL BASICO</option>
                                                        <option value='1104'>TRANSPORTE ASISTENCIAL MEDICALIZADO</option>
                                                        <option value='1105'>ATENCION PREHOSPITALARIA</option>
                                                        <option value='120'>CUIDADO BASICO NEONATAL</option>
                                                        <option value='129'>HOSPITALIZACION ADULTOS</option>
                                                        <option value='130'>HOSPITALIZACION PEDIATRICA</option>
                                                        <option value='131'>HOSPITALIZACION EN SALUD MENTAL</option>
                                                        <option value='132'>HOSPITALIZACION PARCIAL</option>
                                                        <option value='133'>HOSPITALIZACION PACIENTE CRONICO CON VENTILADOR</option>
                                                        <option value='134'>HOSPITALIZACION PACIENTE CRONICO SIN VENTILADOR</option>
                                                        <option value='135'>HOSPITALIZACION EN CONSUMO DE SUSTANCIAS PSICOACTIVAS</option>
                                                        <option value='138'>CUIDADO BASICO DEL CONSUMO DE SUSTANCIAS PSICOACTIVAS</option>
                                                        <option value='201'>CIRUGIA DE CABEZA Y CUELLO</option>
                                                        <option value='202'>CIRUGIA CARDIOVASCULAR</option>
                                                        <option value='203'>CIRUGIA GENERAL</option>
                                                        <option value='204'>CIRUGIA GINECOLOGICA</option>
                                                        <option value='205'>CIRUGIA MAXILOFACIAL</option>
                                                        <option value='207'>CIRUGIA ORTOPEDICA</option>
                                                        <option value='208'>CIRUGIA OFTALMOLOGICA</option>
                                                        <option value='209'>CIRUGIA OTORRINOLARINGOLOGIA</option>
                                                        <option value='210'>CIRUGIA ONCOLOGICA</option>
                                                        <option value='211'>CIRUGIA ORAL</option>
                                                        <option value='212'>CIRUGIA PEDIATRICA</option>
                                                        <option value='213'>CIRUGIA PLASTICA Y ESTETICA</option>
                                                        <option value='214'>CIRUGIA VASCULAR Y ANGIOLOGICA</option>
                                                        <option value='215'>CIRUGIA UROLOGICA</option>
                                                        <option value='217'>OTRAS CIRUGIAS</option>
                                                        <option value='218'>CIRUGIA ENDOVASCULAR NEUROLOGICA</option>
                                                        <option value='227'>CIRUGIA ONCOLOGICA PEDIATRICA</option>
                                                        <option value='231'>CIRUGIA DE LA MANO</option>
                                                        <option value='232'>CIRUGIA DE MAMA Y TUMORES TEJIDOS BLANDOS</option>
                                                        <option value='233'>CIRUGIA DERMATOLOGICA</option>
                                                        <option value='234'>CIRUGIA DE TORAX</option>
                                                        <option value='235'>CIRUGIA GASTROINTESTINAL</option>
                                                        <option value='237'>CIRUGIA PLASTICA ONCOLOGICA</option>
                                                        <option value='245'>NEUROCIRUGIA</option>
                                                        <option value='301'>ANESTESIA</option>
                                                        <option value='302'>CARDIOLOGIA</option>
                                                        <option value='303'>CIRUGIA CARDIOVASCULAR</option>
                                                        <option value='304'>CIRUGIA GENERAL</option>
                                                        <option value='306'>CIRUGIA PEDIATRICA</option>
                                                        <option value='308'>DERMATOLOGIA</option>
                                                        <option value='309'>DOLOR Y CUIDADOS PALIATIVOS</option>
                                                        <option value='310'>ENDOCRINOLOGIA</option>
                                                        <option value='311'>ENDODONCIA</option>
                                                        <option value='312'>ENFERMERIA</option>
                                                        <option value='313'>ESTOMATOLOGIA</option>
                                                        <option value='316'>GASTROENTEROLOGIA</option>
                                                        <option value='317'>GENETICA</option>
                                                        <option value='318'>GERIATRIA</option>
                                                        <option value='320'>GINECOBSTETRICIA</option>
                                                        <option value='321'>HEMATOLOGIA</option>
                                                        <option value='323'>INFECTOLOGIA</option>
                                                        <option value='324'>INMUNOLOGIA</option>
                                                        <option value='325'>MEDICINA FAMILIAR</option>
                                                        <option value='326'>MEDICINA FISICA Y DEL DEPORTE</option>
                                                        <option value='327'>MEDICINA FISICA Y REHABILITACION</option>
                                                        <option value='328'>MEDICINA GENERAL</option>
                                                        <option value='329'>MEDICINA INTERNA</option>
                                                        <option value='330'>NEFROLOGIA</option>
                                                        <option value='331'>NEUMOLOGIA</option>
                                                        <option value='332'>NEUROLOGIA</option>
                                                        <option value='333'>NUTRICION Y DIETETICA</option>
                                                        <option value='334'>ODONTOLOGIA GENERAL</option>
                                                        <option value='335'>OFTALMOLOGIA</option>
                                                        <option value='336'>ONCOLOGIA CLINICA</option>
                                                        <option value='337'>OPTOMETRIA</option>
                                                        <option value='338'>ORTODONCIA</option>
                                                        <option value='339'>ORTOPEDIA Y/O TRAUMATOLOGIA</option>
                                                        <option value='340'>OTORRINOLARINGOLOGIA</option>
                                                        <option value='342'>PEDIATRIA</option>
                                                        <option value='343'>PERIODONCIA</option>
                                                        <option value='344'>PSICOLOGIA</option>
                                                        <option value='345'>PSIQUIATRIA</option>
                                                        <option value='346'>REHABILITACION ONCOLOGICA</option>
                                                        <option value='347'>REHABILITACION ORAL</option>
                                                        <option value='348'>REUMATOLOGIA</option>
                                                        <option value='354'>TOXICOLOGIA</option>
                                                        <option value='355'>UROLOGIA</option>
                                                        <option value='356'>OTRAS CONSULTAS DE ESPECIALIDAD</option>
                                                        <option value='361'>CARDIOLOGIA PEDIATRICA</option>
                                                        <option value='362'>CIRUGIA DE CABEZA Y CUELLO</option>
                                                        <option value='363'>CIRUGIA DE MANO</option>
                                                        <option value='364'>CIRUGIA DE MAMA Y TUMORES TEJIDOS BLANDOS</option>
                                                        <option value='365'>CIRUGIA DERMATOLOGICA</option>
                                                        <option value='366'>CIRUGIA DE TORAX</option>
                                                        <option value='367'>CIRUGIA GASTROINTESTINAL</option>
                                                        <option value='368'>CIRUGIA GINECOLOGICA LAPAROSCOPICA</option>
                                                        <option value='369'>CIRUGIA PLASTICA Y ESTETICA</option>
                                                        <option value='370'>CIRUGIA PLASTICA ONCOLOGICA</option>
                                                        <option value='371'>OTRAS CONSULTAS GENERALES</option>
                                                        <option value='372'>CIRUGIA VASCULAR</option>
                                                        <option value='373'>CIRUGIA ONCOLOGICA</option>
                                                        <option value='374'>CIRUGIA ONCOLOGICA PEDIATRICA</option>
                                                        <option value='375'>DERMATOLOGIA ONCOLOGICA</option>
                                                        <option value='377'>COLOPROCTOLOGIA</option>
                                                        <option value='379'>GINECOLOGIA ONCOLOGICA</option>
                                                        <option value='383'>MEDICINA NUCLEAR</option>
                                                        <option value='384'>NEFROLOGIA PEDIATRICA</option>
                                                        <option value='385'>NEONATOLOGIA</option>
                                                        <option value='386'>NEUMOLOGIA PEDIATRICA</option>
                                                        <option value='387'>NEUROCIRUGIA</option>
                                                        <option value='388'>NEUROPEDIATRIA</option>
                                                        <option value='390'>OFTALMOLOGIA ONCOLOGICA</option>
                                                        <option value='391'>ONCOLOGIA Y HEMATOLOGIA PEDIATRICA</option>
                                                        <option value='393'>ORTOPEDIA ONCOLOGICA</option>
                                                        <option value='395'>UROLOGIA ONCOLOGICA</option>
                                                        <option value='396'>ODONTOPEDIATRIA</option>
                                                        <option value='397'>MEDICINA ESTETICA</option>
                                                        <option value='406'>HEMATOLOGIA ONCOLOGICA</option>
                                                        <option value='407'>MEDICINA DEL TRABAJO Y MEDICINA LABORAL</option>
                                                        <option value='408'>RADIOTERAPIA</option>
                                                        <option value='409'>ORTOPEDIA PEDIATRICA</option>
                                                        <option value='410'>CIRUGIA ORAL</option>
                                                        <option value='411'>CIRUGIA MAXILOFACIAL</option>
                                                        <option value='412'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - HOMEOPATICA</option>
                                                        <option value='413'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - AYURVEDICA</option>
                                                        <option value='414'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - TRADICIONAL CHINA
                                                        </option>
                                                        <option value='415'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - NATUROPATICA</option>
                                                        <option value='416'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - NEURALTERAPEUTICA
                                                        </option>
                                                        <option value='417'>TERAPIAS ALTERNATIVAS Y COMPLEMENTARIAS - BIOENERGETICA</option>
                                                        <option value='418'>TERAPIAS ALTERNATIVAS Y COMPLEMENTARIAS - TERAPIA CON FILTROS
                                                        </option>
                                                        <option value='419'>TERAPIAS ALTERNATIVAS Y COMPLEMENTARIAS - TERAPIAS MANUALES
                                                        </option>
                                                        <option value='420'>VACUNACION</option>
                                                        <option value='421'>PATOLOGIA</option>
                                                        <option value='422'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - OSTEOPATICA</option>
                                                        <option value='423'>SEGURIDAD Y SALUD EN EL TRABAJO</option>
                                                        <option value='706'>LABORATORIO CLINICO</option>
                                                        <option value='709'>QUIMIOTERAPIA</option>
                                                        <option value='711'>RADIOTERAPIA</option>
                                                        <option value='712'>TOMA DE MUESTRAS DE LABORATORIO CLINICO</option>
                                                        <option value='714'>SERVICIO FARMACEUTICO</option>
                                                        <option value='715'>MEDICINA NUCLEAR</option>
                                                        <option value='717'>LABORATORIO CITOLOGIAS CERVICO-UTERINAS</option>
                                                        <option value='728'>TERAPIA OCUPACIONAL</option>
                                                        <option value='729'>TERAPIA RESPIRATORIA</option>
                                                        <option value='731'>LABORATORIO DE HISTOTECNOLOGIA</option>
                                                        <option value='733'>HEMODIALISIS</option>
                                                        <option value='734'>DIALISIS PERITONEAL</option>
                                                        <option value='739'>FISIOTERAPIA</option>
                                                        <option value='740'>FONOAUDIOLOGIA Y/O TERAPIA DEL LENGUAJE</option>
                                                        <option value='742'>DIAGNOSTICO VASCULAR</option>
                                                        <option value='743'>HEMODINAMIA E INTERVENCIONISMO</option>
                                                        <option value='744'>IMAGENES DIAGNOSTICAS- IONIZANTES</option>
                                                        <option value='745'>IMAGENES DIAGNOSTICAS - NO IONIZANTES</option>
                                                        <option value='746'>GESTION PRE-TRANSFUSIONAL</option>
                                                        <option value='747'>PATOLOGIA</option>
                                                        <option value='748'>RADIOLOGIA ODONTOLOGICA</option>
                                                        <option value='749'>TOMA DE MUESTRAS DE CUELLO UTERINO Y GINECOLOGICAS</option>
                                                        </select>
                                                    </div>
                                                  </td>";
                                        break;
                                    case 'finalidadTecnologiaSalud':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_finalidadTecnologiaSaludAC_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_finalidadTecnologiaSaludAC_{$numeroFactura}' name='finalidadTecnologiaSaludAC_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione Finalidad Tecnologia Salud</option>
                                                            <option value='11'>VALORACION INTEGRAL PARA LA PROMOCION Y MANTENIMIENTO</option>
                                                            <option value='12'>DETECCION TEMPRANA DE ENFERMEDAD GENERAL</option>
                                                            <option value='13'>DETECCION TEMPRANA DE ENFERMEDAD LABORAL</option>
                                                            <option value='14'>PROTECCION ESPECIFICA</option>
                                                            <option value='15'>DIAGNOSTICO</option>
                                                            <option value='16'>TRATAMIENTO</option>
                                                            <option value='17'>REHABILITACION</option>
                                                            <option value='18'>PALIACION</option>
                                                            <option value='19'>PLANIFICACION FAMILIAR Y ANTICONCEPCION</option>
                                                            <option value='20'>PROMOCION Y APOYO A LA LACTANCIA MATERNA</option>
                                                            <option value='21'>ATENCION BASICA DE ORIENTACION FAMILIAR</option>
                                                            <option value='22'>ATENCION PARA EL CUIDADO PRECONCEPCIONAL</option>
                                                            <option value='23'>ATENCION PARA EL CUIDADO PRENATAL</option>
                                                            <option value='24'>INTERRUPCION VOLUNTARIA DEL EMBARAZO</option>
                                                            <option value='25'>ATENCION DEL PARTO Y PUERPERIO</option>
                                                            <option value='26'>ATENCION PARA EL CUIDADO DEL RECIEN NACIDO</option>
                                                            <option value='27'>ATENCION PARA EL SEGUIMIENTO DEL RECIEN NACIDO</option>
                                                            <option value='28'>PREPARACION PARA LA MATERNIDAD Y LA PATERNIDAD</option>
                                                            <option value='29'>PROMOCION DE ACTIVIDAD FISICA</option>
                                                            <option value='30'>PROMOCION DE LA CESACION DEL TABAQUISMO</option>
                                                            <option value='31'>PREVENCION DEL CONSUMO DE SUSTANCIAS PSICOACTIVAS</option>
                                                            <option value='32'>PROMOCION DE LA ALIMENTACION SALUDABLE</option>
                                                            <option value='33'>PROMOCION PARA EL EJERCICIO DE LOS DERECHOS SEXUALES Y DERECHOS REPRODUCTIVOS</option>
                                                            <option value='34'>PROMOCION PARA EL DESARROLLO DE HABILIDADES PARA LA VIDA</option>
                                                            <option value='35'>PROMOCION PARA LA CONSTRUCCION DE ESTRATEGIAS DE AFRONTAMIENTO FRENTE A SUCESOS VITALES</option>
                                                            <option value='36'>PROMOCION DE LA SANA CONVIVENCIA Y EL TEJIDO SOCIAL</option>
                                                            <option value='37'>PROMOCION DE UN AMBIENTE SEGURO Y DE CUIDADO Y PROTECCION DEL AMBIENTE</option>
                                                            <option value='38'>PROMOCION DEL EMPODERAMIENTO PARA EL EJERCICIO DEL DERECHO A LA SALUD</option>
                                                            <option value='39'>PROMOCION PARA LA ADOPCION DE PRACTICAS DE CRIANZA Y CUIDADO PARA LA SALUD</option>
                                                            <option value='40'>PROMOCION DE LA CAPACIDAD DE LA AGENCIA Y CUIDADO DE LA SALUD</option>
                                                            <option value='41'>DESARROLLO DE HABILIDADES COGNITIVAS</option>
                                                            <option value='42'>INTERVENCION COLECTIVA</option>
                                                            <option value='43'>MODIFICACION DE LA ESTETICA CORPORAL FINES ESTETICOS</option>
                                                            <option value='44'>OTRA</option>
                                                        </select>
                                                    </div>
                                                  </td>";
                                        break;
                                    case 'causaMotivoAtencion':
                                        echo "<td>
                                            <div class='col-md-4'>
                                                <label for='_causaMotivoAtencionAC_{$numeroFactura}'></label>
                                                <select class='form-select form-select-lg' id='_causaMotivoAtencionAC_{$numeroFactura}' name='causaMotivoAtencionAC_{$numeroFactura}'>
                                                    <option value='' disabled selected>Seleccione Causa Motivo Atención</option>
                                                    <option value='21'>Accidente de trabajo</option>
                                                    <option value='22'>Accidente en el hogar</option>
                                                    <option value='23'>Accidente de tránsito de origen común</option>
                                                    <option value='24'>Accidente de tránsito de origen laboral</option>
                                                    <option value='25'>Accidente en el entorno educativo</option>
                                                    <option value='26'>Otro tipo de accidente</option>
                                                    <option value='27'>Evento catastrófico de origen natural</option>
                                                    <option value='28'>Lesión por agresión</option>
                                                    <option value='29'>Lesión auto infligida</option>
                                                    <option value='30'>Sospecha de violencia física</option>
                                                    <option value='31'>Sospecha de violencia psicológica</option>
                                                    <option value='32'>Sospecha de violencia sexual</option>
                                                    <option value='33'>Sospecha de negligencia y abandono</option>
                                                    <option value='34'>IVE relacionado con peligro a la salud o vida de la mujer</option>
                                                    <option value='35'>IVE por malformación congénita incompatible con la vida</option>
                                                    <option value='36'>IVE por violencia sexual, incesto o por inseminación artificial o transferencia de óvulo fecundado no consentida</option>
                                                    <option value='37'>Evento adverso en salud</option>
                                                    <option value='38'>Enfermedad general</option>
                                                    <option value='39'>Enfermedad laboral</option>
                                                    <option value='40'>Promoción y mantenimiento de la salud – intervenciones individuales</option>
                                                    <option value='41'>Intervención colectiva</option>
                                                    <option value='42'>Atención de población materno perinatal</option>
                                                    <option value='43'>Riesgo ambiental</option>
                                                    <option value='44'>Otros eventos catastróficos</option>
                                                    <option value='45'>Accidente de mina antipersonal – MAP</option>
                                                    <option value='46'>Accidente de artefacto explosivo improvisado – AEI</option>
                                                    <option value='47'>Accidente de munición sin explotar – MUSE</option>
                                                    <option value='48'>Otra víctima de conflicto armado colombiano</option>
                                                </select>
                                            </div>
                                           </td>";
                                        break;
                                    case 'codDiagnosticoPrincipal':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoPrincipalAC_{$numeroFactura}' name='codDiagnosticoPrincipalAC_{$numeroFactura}' value='" . htmlspecialchars($fila[9]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoRelacionado1':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionado1AC_{$numeroFactura}' name='codDiagnosticoRelacionado1AC_{$numeroFactura}' value='" . htmlspecialchars($fila[10]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoRelacionado2':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionado2AC_{$numeroFactura}' name='codDiagnosticoRelacionado2AC_{$numeroFactura}' value='" . htmlspecialchars($fila[11]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoRelacionado3':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionado3AC_{$numeroFactura}' name='codDiagnosticoRelacionado3AC_{$numeroFactura}' value='" . htmlspecialchars($fila[12]) . "'></td>";
                                        break;
                                    case 'tipoDiagnosticoPrincipal':
                                        echo "<td>
                                            <div class='col-md-4'>
                                                <label for='_tipoDiagnosticoPrincipalAC_{$numeroFactura}'></label>
                                            <select class='form-select form-select-lg' id='_tipoDiagnosticoPrincipalAC_{$numeroFactura}' name='tipoDiagnosticoPrincipalAC_{$numeroFactura}'>
                                                <option value=''disabled selected>Seleccione Tipo Diagnostico Principal</option>
                                                <option value='01'>Impresión diagnóstica</option>
                                                <option value='02'>Confirmado nuevo</option>
                                                <option value='03'>Confirmado repetido</option>
                                            </select>
                                            </div>
                                            </td>
                                            ";
                                        break;
                                    case 'tipoDocumentoIdentificacion':
                                        echo "<td>
                                                <div class='col-md-4'>
                                                    <label for='_tipoDocumentoIdentificacionAC_{$numeroFactura}'></label>
                                                    <select class='form-select form-select-lg' id='_tipoDocumentoIdentificacionAC_{$numeroFactura}' name='tipoDocumentoIdentificacionAC_{$numeroFactura}'>
                                                        <option value='' disabled selected>Seleccione Tipo Documento Identificacion</option>
                                                        <option value='CN'>Certificado de nacido vivo</option>
                                                        <option value='CC'>Cédula de Ciudadanía</option>
                                                        <option value='CE'>Cédula de Extranjería</option>
                                                        <option value='PA'>Pasaporte</option>
                                                        <option value='DE'>Documento extranjero</option>
                                                        <option value='CD'>Carnet Diplomático</option>
                                                        <option value='SC'>Salvoconducto</option>
                                                        <option value='PE'>Permiso Especial de Permanencia</option>
                                                        <option value='PT'>Permiso por protección temporal</option>
                                                        <option value='AS'>Adulto sin identificación</option>
                                                    </select>
                                                </div>
                                            </td>";
                                        break;
                                    case 'numDocumentoIdentificacion':
                                        echo "<td><input type='text' class='form-control' id='_numDocumentoIdentificacionAC_{$numeroFactura}' name='numDocumentoIdentificacionAC_{$numeroFactura}'></td>";
                                        break;
                                    case 'vrServicio':
                                        echo "<td><input type='text' class='form-control' id='_vrServicioAC_{$numeroFactura}' name='vrServicioAC_{$numeroFactura}' value='" . htmlspecialchars($fila[14]) . "'></td>";
                                        break;
                                    case 'conceptoRecaudo':
                                        echo "<td>
                                        <div class='col-md-4'>
                                            <label for='_conceptoRecaudoAC_{$numeroFactura}'></label>
                                            <select class='form-select form-select-lg' id='_conceptoRecaudoAC_{$numeroFactura}' name='conceptoRecaudoAC_{$numeroFactura}'>
                                                <option value=''disabled selected>Seleccione Concepto Recaudo</option>
                                                <option value='01'>COPAGO</option>
                                                <option value='02'>CUOTA MODERADORA</option>
                                                <option value='03'>PAGOS COMPARTIDOS EN PLANES VOLUNTARIOS DE SALUD</option>
                                                <option value='04'>ANTICIPO</option>
                                                <option value='05'>NO APLICA</option>
                                             </select>
                                        </div>
                                    </td>";
                                        break;
                                    case 'valorPagoModerador':
                                        echo "<td><input type='text' class='form-control' id='_valorPagoModeradorAC_{$numeroFactura}' name='valorPagoModeradorAC_{$numeroFactura}' value='" . htmlspecialchars($fila[15]) . "'></td>";
                                        break;
                                    case 'numFEVPagoModerador':
                                        echo "<td><input type='text' class='form-control' id='_numFEVPagoModeradorAC_{$numeroFactura}' name='numFEVPagoModeradorAC_{$numeroFactura}'></td>";
                                        break;
                                    case 'consecutivo':
                                        echo "<td><input type='text' class='form-control' id='_consecutivoAC_{$numeroFactura}' name='consecutivoAC_{$numeroFactura}'></td>";
                                        break;
                                    default:
                                        echo "<td></td>"; // Si no coincide con ninguno, mostrar celda vacía
                                        break;
                                }
                            }
                            echo "</form>";
                        } elseif ($nombreArchivo === 'AU.txt') {
                            echo "<form id='formAU' method='POST'>";
                            foreach ($columnasAU as $index => $nombreColumna) {
                                switch ($nombreColumna) {
                                    case 'numeroFacturaAU':
                                        echo "<td><input type='text' class='form-control' id='_numeroFacturaAU_{$numeroFactura}' name='numeroFacturaAU_{$numeroFactura}' value='" . htmlspecialchars($fila[0]) . "'></td>";
                                        break;
                                    case 'codPrestador':
                                        echo "<td><input type='text' class='form-control' id='_codPrestadorAU_{$numeroFactura}' name='codPrestadorAU_{$numeroFactura}' value='" . htmlspecialchars($fila[1]) . "'></td>";
                                        break;
                                    case 'fechaInicioAtencion':
                                        echo "<td><input type='text' class='form-control' id='_fechaInicioAtencionAU_{$numeroFactura}' name='fechaInicioAtencionAU_{$numeroFactura}' value='" . htmlspecialchars($fila[4]) . "'></td>";
                                        break;
                                    case 'causaMotivoAtencion':
                                        echo "<td>
                                                <div class='col-md-4'>
                                                    <label for='_causaMotivoAtencionAU_{$numeroFactura}'></label>
                                                    <select class='form-select form-select-lg' id='_causaMotivoAtencionAU_{$numeroFactura}' name='causaMotivoAtencionAU_{$numeroFactura}'>
                                                        <option value='' disabled selected>Seleccione Causa Motivo Atención</option>
                                                        <option value='21'>Accidente de trabajo</option>
                                                        <option value='22'>Accidente en el hogar</option>
                                                        <option value='23'>Accidente de tránsito de origen común</option>
                                                        <option value='24'>Accidente de tránsito de origen laboral</option>
                                                        <option value='25'>Accidente en el entorno educativo</option>
                                                        <option value='26'>Otro tipo de accidente</option>
                                                        <option value='27'>Evento catastrófico de origen natural</option>
                                                        <option value='28'>Lesión por agresión</option>
                                                        <option value='29'>Lesión auto infligida</option>
                                                        <option value='30'>Sospecha de violencia física</option>
                                                        <option value='31'>Sospecha de violencia psicológica</option>
                                                        <option value='32'>Sospecha de violencia sexual</option>
                                                        <option value='33'>Sospecha de negligencia y abandono</option>
                                                        <option value='34'>IVE relacionado con peligro a la salud o vida de la mujer</option>
                                                        <option value='35'>IVE por malformación congénita incompatible con la vida</option>
                                                        <option value='36'>IVE por violencia sexual, incesto o por inseminación artificial o transferencia de óvulo fecundado no consentida</option>
                                                        <option value='37'>Evento adverso en salud</option>
                                                        <option value='38'>Enfermedad general</option>
                                                        <option value='39'>Enfermedad laboral</option>
                                                        <option value='40'>Promoción y mantenimiento de la salud – intervenciones individuales</option>
                                                        <option value='41'>Intervención colectiva</option>
                                                        <option value='42'>Atención de población materno perinatal</option>
                                                        <option value='43'>Riesgo ambiental</option>
                                                        <option value='44'>Otros eventos catastróficos</option>
                                                        <option value='45'>Accidente de mina antipersonal – MAP</option>
                                                        <option value='46'>Accidente de artefacto explosivo improvisado – AEI</option>
                                                        <option value='47'>Accidente de munición sin explotar – MUSE</option>
                                                        <option value='48'>Otra víctima de conflicto armado colombiano</option>
                                                    </select>
                                                </div>
                                            </td>";
                                        break;
                                    case 'codDiagnosticoPrincipal':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoPrincipalAU_{$numeroFactura}' name='codDiagnosticoPrincipalAU_{$numeroFactura}' value='" . htmlspecialchars($fila[8]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoPrincipalE':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoPrincipalEAU_{$numeroFactura}' name='codDiagnosticoPrincipalEAU_{$numeroFactura}' value='" . htmlspecialchars($fila[8]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoRelacionadoE1':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionadoE1AU_{$numeroFactura}' name='codDiagnosticoRelacionadoE1AU_{$numeroFactura}' value='" . htmlspecialchars($fila[9]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoRelacionadoE2':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionadoE2AU_{$numeroFactura}' name='codDiagnosticoRelacionadoE2AU_{$numeroFactura}' value='" . htmlspecialchars($fila[10]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoRelacionadoE3':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionadoE3AU_{$numeroFactura}' name='codDiagnosticoRelacionadoE3AU_{$numeroFactura}' value='" . htmlspecialchars($fila[11]) . "'></td>";
                                        break;
                                    case 'condicionDestinoUsuarioEgreso':
                                        echo "<td>
                                                <div class='col-md-4'>
                                                    <label for='_condicionDestinoUsuarioEgresoAU_{$numeroFactura}'></label>
                                                    <select class='form-select form-select-lg' id='_condicionDestinoUsuarioEgresoAU_{$numeroFactura}' name='condicionDestinoUsuarioEgresoAU_{$numeroFactura}'>
                                                        <option value='' disabled selected>Seleccione Condición Destino Usuario Egreso</option>
                                                        <option value='01'>PACIENTE CON DESTINO A SU DOMICILIO</option>
                                                        <option value='02'>PACIENTE MUERTO</option>
                                                        <option value='03'>PACIENTE DERIVADO A OTRO SERVICIO</option>
                                                        <option value='04'>REFERIDO A OTRA INSTITUCION</option>
                                                        <option value='05'>CONTRAREFERIDO A OTRA INSTITUCION</option>
                                                        <option value='06'>DERIVADO O REFERIDO A HOSPITALIZACION DOMICILIARIA</option>
                                                        <option value='07'>DERIVADO A SERVICIO SOCIAL</option>
                                                        <option value='08'>PACIENTE CONTINUA EN EL SERVICIO (CORTE FACTURACION)</option>
                                                    </select>
                                                </div>
                                            </td>";
                                        break;
                                    case 'codDiagnosticoCausaMuerte':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoCausaMuerteAU_{$numeroFactura}' name='codDiagnosticoCausaMuerteAU_{$numeroFactura}' value='" . htmlspecialchars($fila[14]) . "'></td>";
                                        break;
                                    case 'fechaEgreso':
                                        echo "<td><input type='text' class='form-control' id='_fechaEgresoAU_{$numeroFactura}' name='fechaEgresoAU_{$numeroFactura}' value='" . htmlspecialchars($fila[15]) . "'></td>";
                                        break;
                                    case 'consecutivo':
                                        echo "<td><input type='text' class='form-control' id='_consecutivoAU_{$numeroFactura}' name='consecutivoAU_{$numeroFactura}'></td>";
                                        break;
                                    default:
                                        echo "<td></td>"; // Si no coincide con ninguno, mostrar celda vacía
                                        break;
                                }
                            }
                            echo "</form>";
                        } elseif ($nombreArchivo === 'AP.txt') {
                            echo "<form id='formAP' method='POST'>";
                            foreach ($columnasAP as $index => $nombreColumna) {
                                switch ($nombreColumna) {
                                    case 'numeroFacturaAP':
                                        echo "<td><input type='text' class='form-control' id='_numeroFacturaAP_{$numeroFactura}' name='numeroFacturaAP_{$numeroFactura}' value='" . htmlspecialchars($fila[0]) . "'></td>";
                                        break;
                                    case 'codPrestador':
                                        echo "<td><input type='text' class='form-control' id='_codPrestadorAP_{$numeroFactura}' name='codPrestadorAP_{$numeroFactura}' value='" . (isset($fila[1]) ? htmlspecialchars($fila[1]) : '') . "'></td>";
                                        break;
                                    case 'fechaInicioAtencion':
                                        echo "<td><input type='text' class='form-control' id='_fechaInicioAtencionAP_{$numeroFactura}' name='fechaInicioAtencionAP_{$numeroFactura}' value='" . (isset($fila[4]) ? htmlspecialchars($fila[4]) : '') . "'></td>";
                                        break;
                                    case 'idMIPRES':
                                        echo "<td><input type='text' class='form-control' id='_idMIPRESAP_{$numeroFactura}' name='idMIPRESAP_{$numeroFactura}'></td>";
                                        break;
                                    case 'numAutorizacion':
                                        echo "<td><input type='text' class='form-control' id='_numAutorizacionAP_{$numeroFactura}' name='numAutorizacionAP_{$numeroFactura}' value='" . (isset($fila[5]) ? htmlspecialchars($fila[5]) : '') . "'></td>";
                                        break;
                                    case 'codProcedimiento':
                                        echo "<td><input type='text' class='form-control' id='_codProcedimientoAP_{$numeroFactura}' name='codProcedimientoAP_{$numeroFactura}' value='" . (isset($fila[6]) ? htmlspecialchars($fila[6]) : '') . "'></td>";
                                        break;
                                    case 'viaIngresoServicioSalud':
                                        echo "<td>
                                                <div class='col-md-4'>
                                                    <label for='_viaIngresoServicioSaludAP_{$numeroFactura}'></label>
                                                    <select class='form-select form-select-lg' id='_viaIngresoServicioSaludAP_{$numeroFactura}' name='viaIngresoServicioSaludAP_{$numeroFactura}'>
                                                        <option value='' disabled selected>Seleccione Via Ingreso Servicio Salud</option>
                                                        <option value='01'>DEMANDA ESPONTANEA</option>
                                                        <option value='02'>DERIVADO DE CONSULTA EXTERNA</option>
                                                        <option value='03'>DERIVADO DE URGENCIAS</option>
                                                        <option value='04'>DERIVADO DE HOSPITALZACION</option>
                                                        <option value='05'>DERIVADO DE SALA DE CIRUGIA</option>
                                                        <option value='06'>DERIVADO DE SALA DE PARTOS</option>
                                                        <option value='07'>RECIEN NACIDO EN LA INSTITUCION</option>
                                                        <option value='08'>RECIEN NACIDO EN OTRA INSTITUCION</option>
                                                        <option value='09'>DERIVADO O REFERIDO DE HOSPITALIZACION DOMICILIARIA</option>
                                                        <option value='10'>DERIVADO DE ATENCION DOMICILIARIA</option>
                                                        <option value='11'>DERIVADO DE TELEMEDICINA</option>
                                                        <option value='12'>DERIVADO DE JORNADA DE SALUD</option>
                                                        <option value='13'>REFERIDO DE OTRA INSTITUCION</option>
                                                        <option value='14'>CONTRAREFERIDO DE OTRA INSTITUCION</option>
                                                    </select>
                                                </div>
                                            </td>";
                                        break;
                                    case 'modalidadGrupoServicioTecSal':
                                        echo "<td>
                                                        <div class='col-md-4'>
                                                            <label for='_modalidadGrupoServicioTecSalAP_{$numeroFactura}'</label>
                                                            <select class='form-select form-select-lg' id='_modalidadGrupoServicioTecSalAP_{$numeroFactura}' name='modalidadGrupoServicioTecSalAP_{$numeroFactura}'>
                                                                <option value='' disabled selected>Seleccione Modalidad Grupo Servicio</option>
                                                                <option value='01'>Intramural</option>
                                                                <option value='02'>Extramural unidad móvil</option>
                                                                <option value='03'>Extramural domiciliaria</option>
                                                                <option value='04'>Extramural jornada de salud</option>
                                                                <option value='06'>Telemedicina interactiva</option>
                                                                <option value='07'>Telemedicina no interactiva</option>
                                                                <option value='08'>Telemedicina telexperticia</option>
                                                                <option value='09'>Telemedicina telemonitoreo</option>
                                                            </select>
                                                        </div>
                                                      </td>";
                                        break;
                                    case 'grupoServicios':
                                        echo "<td>
                                                        <div class='col-md-4'>
                                                            <label for='_grupoServiciosAP_{$numeroFactura}'</label>
                                                            <select class='form-select form-select-lg' id='_grupoServiciosAP_{$numeroFactura}' name='grupoServiciosAP_{$numeroFactura}'>
                                                                <option value='' disabled selected>Seleccione Grupo de servicios</option>
                                                                <option value='01'>Consulta externa</option>
                                                                <option value='02'>Apoyo diagnóstico y complementación terapéutica</option>
                                                                <option value='03'>Internación</option>
                                                                <option value='04'>Quirúrgico</option>
                                                                <option value='05'>Atención inmediata</option>
                                                            </select>
                                                        </div>
                                                      </td>";
                                        break;
                                    case 'codServicio':
                                        echo "<td>
                                                        <div class='col-md-4'>
                                                            <label for='_codServicioAP_{$numeroFactura}'></label>
                                                            <select class='form-select form-select-lg' id='_codServicioAP_{$numeroFactura}' name='codServicioAP_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione Codigo de servicio</option>>
                                                            <option value='105'>CUIDADO INTERMEDIO NEONATAL</option>
                                                            <option value='106'>CUIDADO INTERMEDIO PEDIATRICO</option>
                                                            <option value='107'>CUIDADO INTERMEDIO ADULTOS</option>
                                                            <option value='108'>CUIDADO INTENSIVO NEONATAL</option>
                                                            <option value='109'>CUIDADO INTENSIVO PEDIATRICO</option>
                                                            <option value='110'>CUIDADO INTENSIVO ADULTOS</option>
                                                            <option value='1101'>ATENCION DEL PARTO</option>
                                                            <option value='1102'>URGENCIAS</option>
                                                            <option value='1103'>TRANSPORTE ASISTENCIAL BASICO</option>
                                                            <option value='1104'>TRANSPORTE ASISTENCIAL MEDICALIZADO</option>
                                                            <option value='1105'>ATENCION PREHOSPITALARIA</option>
                                                            <option value='120'>CUIDADO BASICO NEONATAL</option>
                                                            <option value='129'>HOSPITALIZACION ADULTOS</option>
                                                            <option value='130'>HOSPITALIZACION PEDIATRICA</option>
                                                            <option value='131'>HOSPITALIZACION EN SALUD MENTAL</option>
                                                            <option value='132'>HOSPITALIZACION PARCIAL</option>
                                                            <option value='133'>HOSPITALIZACION PACIENTE CRONICO CON VENTILADOR</option>
                                                            <option value='134'>HOSPITALIZACION PACIENTE CRONICO SIN VENTILADOR</option>
                                                            <option value='135'>HOSPITALIZACION EN CONSUMO DE SUSTANCIAS PSICOACTIVAS</option>
                                                            <option value='138'>CUIDADO BASICO DEL CONSUMO DE SUSTANCIAS PSICOACTIVAS</option>
                                                            <option value='201'>CIRUGIA DE CABEZA Y CUELLO</option>
                                                            <option value='202'>CIRUGIA CARDIOVASCULAR</option>
                                                            <option value='203'>CIRUGIA GENERAL</option>
                                                            <option value='204'>CIRUGIA GINECOLOGICA</option>
                                                            <option value='205'>CIRUGIA MAXILOFACIAL</option>
                                                            <option value='207'>CIRUGIA ORTOPEDICA</option>
                                                            <option value='208'>CIRUGIA OFTALMOLOGICA</option>
                                                            <option value='209'>CIRUGIA OTORRINOLARINGOLOGIA</option>
                                                            <option value='210'>CIRUGIA ONCOLOGICA</option>
                                                            <option value='211'>CIRUGIA ORAL</option>
                                                            <option value='212'>CIRUGIA PEDIATRICA</option>
                                                            <option value='213'>CIRUGIA PLASTICA Y ESTETICA</option>
                                                            <option value='214'>CIRUGIA VASCULAR Y ANGIOLOGICA</option>
                                                            <option value='215'>CIRUGIA UROLOGICA</option>
                                                            <option value='217'>OTRAS CIRUGIAS</option>
                                                            <option value='218'>CIRUGIA ENDOVASCULAR NEUROLOGICA</option>
                                                            <option value='227'>CIRUGIA ONCOLOGICA PEDIATRICA</option>
                                                            <option value='231'>CIRUGIA DE LA MANO</option>
                                                            <option value='232'>CIRUGIA DE MAMA Y TUMORES TEJIDOS BLANDOS</option>
                                                            <option value='233'>CIRUGIA DERMATOLOGICA</option>
                                                            <option value='234'>CIRUGIA DE TORAX</option>
                                                            <option value='235'>CIRUGIA GASTROINTESTINAL</option>
                                                            <option value='237'>CIRUGIA PLASTICA ONCOLOGICA</option>
                                                            <option value='245'>NEUROCIRUGIA</option>
                                                            <option value='301'>ANESTESIA</option>
                                                            <option value='302'>CARDIOLOGIA</option>
                                                            <option value='303'>CIRUGIA CARDIOVASCULAR</option>
                                                            <option value='304'>CIRUGIA GENERAL</option>
                                                            <option value='306'>CIRUGIA PEDIATRICA</option>
                                                            <option value='308'>DERMATOLOGIA</option>
                                                            <option value='309'>DOLOR Y CUIDADOS PALIATIVOS</option>
                                                            <option value='310'>ENDOCRINOLOGIA</option>
                                                            <option value='311'>ENDODONCIA</option>
                                                            <option value='312'>ENFERMERIA</option>
                                                            <option value='313'>ESTOMATOLOGIA</option>
                                                            <option value='316'>GASTROENTEROLOGIA</option>
                                                            <option value='317'>GENETICA</option>
                                                            <option value='318'>GERIATRIA</option>
                                                            <option value='320'>GINECOBSTETRICIA</option>
                                                            <option value='321'>HEMATOLOGIA</option>
                                                            <option value='323'>INFECTOLOGIA</option>
                                                            <option value='324'>INMUNOLOGIA</option>
                                                            <option value='325'>MEDICINA FAMILIAR</option>
                                                            <option value='326'>MEDICINA FISICA Y DEL DEPORTE</option>
                                                            <option value='327'>MEDICINA FISICA Y REHABILITACION</option>
                                                            <option value='328'>MEDICINA GENERAL</option>
                                                            <option value='329'>MEDICINA INTERNA</option>
                                                            <option value='330'>NEFROLOGIA</option>
                                                            <option value='331'>NEUMOLOGIA</option>
                                                            <option value='332'>NEUROLOGIA</option>
                                                            <option value='333'>NUTRICION Y DIETETICA</option>
                                                            <option value='334'>ODONTOLOGIA GENERAL</option>
                                                            <option value='335'>OFTALMOLOGIA</option>
                                                            <option value='336'>ONCOLOGIA CLINICA</option>
                                                            <option value='337'>OPTOMETRIA</option>
                                                            <option value='338'>ORTODONCIA</option>
                                                            <option value='339'>ORTOPEDIA Y/O TRAUMATOLOGIA</option>
                                                            <option value='340'>OTORRINOLARINGOLOGIA</option>
                                                            <option value='342'>PEDIATRIA</option>
                                                            <option value='343'>PERIODONCIA</option>
                                                            <option value='344'>PSICOLOGIA</option>
                                                            <option value='345'>PSIQUIATRIA</option>
                                                            <option value='346'>REHABILITACION ONCOLOGICA</option>
                                                            <option value='347'>REHABILITACION ORAL</option>
                                                            <option value='348'>REUMATOLOGIA</option>
                                                            <option value='354'>TOXICOLOGIA</option>
                                                            <option value='355'>UROLOGIA</option>
                                                            <option value='356'>OTRAS CONSULTAS DE ESPECIALIDAD</option>
                                                            <option value='361'>CARDIOLOGIA PEDIATRICA</option>
                                                            <option value='362'>CIRUGIA DE CABEZA Y CUELLO</option>
                                                            <option value='363'>CIRUGIA DE MANO</option>
                                                            <option value='364'>CIRUGIA DE MAMA Y TUMORES TEJIDOS BLANDOS</option>
                                                            <option value='365'>CIRUGIA DERMATOLOGICA</option>
                                                            <option value='366'>CIRUGIA DE TORAX</option>
                                                            <option value='367'>CIRUGIA GASTROINTESTINAL</option>
                                                            <option value='368'>CIRUGIA GINECOLOGICA LAPAROSCOPICA</option>
                                                            <option value='369'>CIRUGIA PLASTICA Y ESTETICA</option>
                                                            <option value='370'>CIRUGIA PLASTICA ONCOLOGICA</option>
                                                            <option value='371'>OTRAS CONSULTAS GENERALES</option>
                                                            <option value='372'>CIRUGIA VASCULAR</option>
                                                            <option value='373'>CIRUGIA ONCOLOGICA</option>
                                                            <option value='374'>CIRUGIA ONCOLOGICA PEDIATRICA</option>
                                                            <option value='375'>DERMATOLOGIA ONCOLOGICA</option>
                                                            <option value='377'>COLOPROCTOLOGIA</option>
                                                            <option value='379'>GINECOLOGIA ONCOLOGICA</option>
                                                            <option value='383'>MEDICINA NUCLEAR</option>
                                                            <option value='384'>NEFROLOGIA PEDIATRICA</option>
                                                            <option value='385'>NEONATOLOGIA</option>
                                                            <option value='386'>NEUMOLOGIA PEDIATRICA</option>
                                                            <option value='387'>NEUROCIRUGIA</option>
                                                            <option value='388'>NEUROPEDIATRIA</option>
                                                            <option value='390'>OFTALMOLOGIA ONCOLOGICA</option>
                                                            <option value='391'>ONCOLOGIA Y HEMATOLOGIA PEDIATRICA</option>
                                                            <option value='393'>ORTOPEDIA ONCOLOGICA</option>
                                                            <option value='395'>UROLOGIA ONCOLOGICA</option>
                                                            <option value='396'>ODONTOPEDIATRIA</option>
                                                            <option value='397'>MEDICINA ESTETICA</option>
                                                            <option value='406'>HEMATOLOGIA ONCOLOGICA</option>
                                                            <option value='407'>MEDICINA DEL TRABAJO Y MEDICINA LABORAL</option>
                                                            <option value='408'>RADIOTERAPIA</option>
                                                            <option value='409'>ORTOPEDIA PEDIATRICA</option>
                                                            <option value='410'>CIRUGIA ORAL</option>
                                                            <option value='411'>CIRUGIA MAXILOFACIAL</option>
                                                            <option value='412'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - HOMEOPATICA</option>
                                                            <option value='413'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - AYURVEDICA</option>
                                                            <option value='414'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - TRADICIONAL CHINA
                                                            </option>
                                                            <option value='415'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - NATUROPATICA</option>
                                                            <option value='416'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - NEURALTERAPEUTICA
                                                            </option>
                                                            <option value='417'>TERAPIAS ALTERNATIVAS Y COMPLEMENTARIAS - BIOENERGETICA</option>
                                                            <option value='418'>TERAPIAS ALTERNATIVAS Y COMPLEMENTARIAS - TERAPIA CON FILTROS
                                                            </option>
                                                            <option value='419'>TERAPIAS ALTERNATIVAS Y COMPLEMENTARIAS - TERAPIAS MANUALES
                                                            </option>
                                                            <option value='420'>VACUNACION</option>
                                                            <option value='421'>PATOLOGIA</option>
                                                            <option value='422'>MEDICINA ALTERNATIVA Y COMPLEMENTARIA - OSTEOPATICA</option>
                                                            <option value='423'>SEGURIDAD Y SALUD EN EL TRABAJO</option>
                                                            <option value='706'>LABORATORIO CLINICO</option>
                                                            <option value='709'>QUIMIOTERAPIA</option>
                                                            <option value='711'>RADIOTERAPIA</option>
                                                            <option value='712'>TOMA DE MUESTRAS DE LABORATORIO CLINICO</option>
                                                            <option value='714'>SERVICIO FARMACEUTICO</option>
                                                            <option value='715'>MEDICINA NUCLEAR</option>
                                                            <option value='717'>LABORATORIO CITOLOGIAS CERVICO-UTERINAS</option>
                                                            <option value='728'>TERAPIA OCUPACIONAL</option>
                                                            <option value='729'>TERAPIA RESPIRATORIA</option>
                                                            <option value='731'>LABORATORIO DE HISTOTECNOLOGIA</option>
                                                            <option value='733'>HEMODIALISIS</option>
                                                            <option value='734'>DIALISIS PERITONEAL</option>
                                                            <option value='739'>FISIOTERAPIA</option>
                                                            <option value='740'>FONOAUDIOLOGIA Y/O TERAPIA DEL LENGUAJE</option>
                                                            <option value='742'>DIAGNOSTICO VASCULAR</option>
                                                            <option value='743'>HEMODINAMIA E INTERVENCIONISMO</option>
                                                            <option value='744'>IMAGENES DIAGNOSTICAS- IONIZANTES</option>
                                                            <option value='745'>IMAGENES DIAGNOSTICAS - NO IONIZANTES</option>
                                                            <option value='746'>GESTION PRE-TRANSFUSIONAL</option>
                                                            <option value='747'>PATOLOGIA</option>
                                                            <option value='748'>RADIOLOGIA ODONTOLOGICA</option>
                                                            <option value='749'>TOMA DE MUESTRAS DE CUELLO UTERINO Y GINECOLOGICAS</option>
                                                            </select>
                                                        </div>
                                                      </td>";
                                        break;
                                    case 'finalidadTecnologiaSalud':
                                        echo "<td>
                                                        <div class='col-md-4'>
                                                            <label for='_finalidadTecnologiaSaludAP_{$numeroFactura}'></label>
                                                            <select class='form-select form-select-lg' id='_finalidadTecnologiaSaludAP_{$numeroFactura}' name='finalidadTecnologiaSaludAP_{$numeroFactura}'>
                                                                <option value='' disabled selected>Seleccione Finalidad Tecnologia Salud</option>
                                                                <option value='11'>VALORACION INTEGRAL PARA LA PROMOCION Y MANTENIMIENTO</option>
                                                                <option value='12'>DETECCION TEMPRANA DE ENFERMEDAD GENERAL</option>
                                                                <option value='13'>DETECCION TEMPRANA DE ENFERMEDAD LABORAL</option>
                                                                <option value='14'>PROTECCION ESPECIFICA</option>
                                                                <option value='15'>DIAGNOSTICO</option>
                                                                <option value='16'>TRATAMIENTO</option>
                                                                <option value='17'>REHABILITACION</option>
                                                                <option value='18'>PALIACION</option>
                                                                <option value='19'>PLANIFICACION FAMILIAR Y ANTICONCEPCION</option>
                                                                <option value='20'>PROMOCION Y APOYO A LA LACTANCIA MATERNA</option>
                                                                <option value='21'>ATENCION BASICA DE ORIENTACION FAMILIAR</option>
                                                                <option value='22'>ATENCION PARA EL CUIDADO PRECONCEPCIONAL</option>
                                                                <option value='23'>ATENCION PARA EL CUIDADO PRENATAL</option>
                                                                <option value='24'>INTERRUPCION VOLUNTARIA DEL EMBARAZO</option>
                                                                <option value='25'>ATENCION DEL PARTO Y PUERPERIO</option>
                                                                <option value='26'>ATENCION PARA EL CUIDADO DEL RECIEN NACIDO</option>
                                                                <option value='27'>ATENCION PARA EL SEGUIMIENTO DEL RECIEN NACIDO</option>
                                                                <option value='28'>PREPARACION PARA LA MATERNIDAD Y LA PATERNIDAD</option>
                                                                <option value='29'>PROMOCION DE ACTIVIDAD FISICA</option>
                                                                <option value='30'>PROMOCION DE LA CESACION DEL TABAQUISMO</option>
                                                                <option value='31'>PREVENCION DEL CONSUMO DE SUSTANCIAS PSICOACTIVAS</option>
                                                                <option value='32'>PROMOCION DE LA ALIMENTACION SALUDABLE</option>
                                                                <option value='33'>PROMOCION PARA EL EJERCICIO DE LOS DERECHOS SEXUALES Y DERECHOS REPRODUCTIVOS</option>
                                                                <option value='34'>PROMOCION PARA EL DESARROLLO DE HABILIDADES PARA LA VIDA</option>
                                                                <option value='35'>PROMOCION PARA LA CONSTRUCCION DE ESTRATEGIAS DE AFRONTAMIENTO FRENTE A SUCESOS VITALES</option>
                                                                <option value='36'>PROMOCION DE LA SANA CONVIVENCIA Y EL TEJIDO SOCIAL</option>
                                                                <option value='37'>PROMOCION DE UN AMBIENTE SEGURO Y DE CUIDADO Y PROTECCION DEL AMBIENTE</option>
                                                                <option value='38'>PROMOCION DEL EMPODERAMIENTO PARA EL EJERCICIO DEL DERECHO A LA SALUD</option>
                                                                <option value='39'>PROMOCION PARA LA ADOPCION DE PRACTICAS DE CRIANZA Y CUIDADO PARA LA SALUD</option>
                                                                <option value='40'>PROMOCION DE LA CAPACIDAD DE LA AGENCIA Y CUIDADO DE LA SALUD</option>
                                                                <option value='41'>DESARROLLO DE HABILIDADES COGNITIVAS</option>
                                                                <option value='42'>INTERVENCION COLECTIVA</option>
                                                                <option value='43'>MODIFICACION DE LA ESTETICA CORPORAL FINES ESTETICOS</option>
                                                                <option value='44'>OTRA</option>
                                                            </select>
                                                        </div>
                                                      </td>";
                                        break;
                                    case 'tipoDocumentoIdentificacion':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_tipoDocumentoIdentificacionAP_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_tipoDocumentoIdentificacionAP_{$numeroFactura}' name='tipoDocumentoIdentificacionAP_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione Tipo Documento Identificacion</option>
                                                            <option value='CN'>Certificado de nacido vivo</option>
                                                            <option value='CC'>Cédula de Ciudadanía</option>
                                                            <option value='CE'>Cédula de Extranjería</option>
                                                            <option value='PA'>Pasaporte</option>
                                                            <option value='DE'>Documento extranjero</option>
                                                            <option value='CD'>Carnet Diplomático</option>
                                                            <option value='SC'>Salvoconducto</option>
                                                            <option value='PE'>Permiso Especial de Permanencia</option>
                                                            <option value='PT'>Permiso por protección temporal</option>
                                                            <option value='AS'>Adulto sin identificación</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'numDocumentoIdentificacion':
                                        echo "<td><input type='text' class='form-control' id='_numDocumentoIdentificacionAP_{$numeroFactura}' name='numDocumentoIdentificacionAP_{$numeroFactura}'></td>";
                                        break;
                                    case 'codDiagnosticoPrincipal':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoPrincipalAP_{$numeroFactura}' name='codDiagnosticoPrincipalAP_{$numeroFactura}' value='" . (isset($fila[11]) ? htmlspecialchars($fila[11]) : '') . "'></td>";
                                        break;
                                    case 'codDiagnosticoRelacionado':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionadoAP_{$numeroFactura}' name='codDiagnosticoRelacionadoAP_{$numeroFactura}' value='" . (isset($fila[12]) ? htmlspecialchars($fila[12]) : '') . "'></td>";
                                        break;
                                    case 'codComplicacion':
                                        echo "<td><input type='text' class='form-control' id='_codComplicacionAP_{$numeroFactura}' name='codComplicacionAP_{$numeroFactura}' value='" . (isset($fila[13]) ? htmlspecialchars($fila[13]) : '') . "'></td>";
                                        break;
                                    case 'vrServicio':
                                        echo "<td><input type='text' class='form-control' id='_vrServicioAP_{$numeroFactura}' name='vrServicioAP_{$numeroFactura}' value='" . (isset($fila[14]) ? htmlspecialchars($fila[14]) : '') . "'></td>";
                                        break;
                                    case 'conceptoRecaudo':
                                        echo "<td>
                                            <div class='col-md-4'>
                                                <label for='_conceptoRecaudoAP_{$numeroFactura}'></label>
                                                <select class='form-select form-select-lg' id='_conceptoRecaudoAP_{$numeroFactura}' name='conceptoRecaudoAP_{$numeroFactura}'>
                                                    <option value=''disabled selected>Seleccione Concepto Recaudo</option>
                                                    <option value='01'>COPAGO</option>
                                                    <option value='02'>CUOTA MODERADORA</option>
                                                    <option value='03'>PAGOS COMPARTIDOS EN PLANES VOLUNTARIOS DE SALUD</option>
                                                    <option value='04'>ANTICIPO</option>
                                                    <option value='05'>NO APLICA</option>
                                                 </select>
                                            </div>
                                        </td>";
                                        break;
                                    case 'valorPagoModerador':
                                        echo "<td><input type='text' class='form-control' id='_valorPagoModeradorAP_{$numeroFactura}' name='valorPagoModeradorAP_{$numeroFactura}' ></td>";
                                        break;
                                    case 'numFEVPagoModerador':
                                        echo "<td><input type='text' class='form-control' id='_numFEVPagoModeradorAP_{$numeroFactura}' name='numFEVPagoModeradorAP_{$numeroFactura}' ></td>";
                                        break;
                                    case 'consecutivo':
                                        echo "<td><input type='text' class='form-control' id='_consecutivoAP_{$numeroFactura}' name='consecutivoAP_{$numeroFactura}' ></td>";
                                        break;
                                    default:
                                        echo "<td></td>"; // Si no coincide con ninguno, mostrar celda vacía
                                        break;
                                }
                            }
                            echo "</form>";
                        } elseif ($nombreArchivo === 'AH.txt') {
                            echo "<form id='formAH' method='POST'>";
                            foreach ($columnasAH as $index => $nombreColumna) {
                                switch ($nombreColumna) {
                                    case 'numeroFacturaAH':
                                        echo "<td><input type='text' class='form-control' id='_numeroFacturaAh_{$numeroFactura}' name='numeroFacturaAh_{$numeroFactura}' value='" . htmlspecialchars($fila[0]) . "'></td>";
                                        break;
                                    case 'codPrestador':
                                        echo "<td><input type='text' class='form-control' id='_codPrestadorAh_{$numeroFactura}' name='codPrestadorAh_{$numeroFactura}' value='" . htmlspecialchars($fila[1]) . "'></td>";
                                        break;
                                    case 'viaIngresoServicioSalud':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_viaIngresoServicioSaludAh_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_viaIngresoServicioSaludAh_{$numeroFactura}' name='viaIngresoServicioSaludAh_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione Via Ingreso Servicio Salud</option>
                                                            <option value='01'>DEMANDA ESPONTANEA</option>
                                                            <option value='02'>DERIVADO DE CONSULTA EXTERNA</option>
                                                            <option value='03'>DERIVADO DE URGENCIAS</option>
                                                            <option value='04'>DERIVADO DE HOSPITALZACION</option>
                                                            <option value='05'>DERIVADO DE SALA DE CIRUGIA</option>
                                                            <option value='06'>DERIVADO DE SALA DE PARTOS</option>
                                                            <option value='07'>RECIEN NACIDO EN LA INSTITUCION</option>
                                                            <option value='08'>RECIEN NACIDO EN OTRA INSTITUCION</option>
                                                            <option value='09'>DERIVADO O REFERIDO DE HOSPITALIZACION DOMICILIARIA</option>
                                                            <option value='10'>DERIVADO DE ATENCION DOMICILIARIA</option>
                                                            <option value='11'>DERIVADO DE TELEMEDICINA</option>
                                                            <option value='12'>DERIVADO DE JORNADA DE SALUD</option>
                                                            <option value='13'>REFERIDO DE OTRA INSTITUCION</option>
                                                            <option value='14'>CONTRAREFERIDO DE OTRA INSTITUCION</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'fechaInicioAtencion':
                                        echo "<td><input type='text' class='form-control' id='_fechaInicioAtencionAh_{$numeroFactura}' name='fechaInicioAtencionAh_{$numeroFactura}' value='" . htmlspecialchars($fila[5]) . "'></td>";
                                        break;
                                    case 'numAutorizacion':
                                        echo "<td><input type='text' class='form-control' id='_numAutorizacionAh_{$numeroFactura}' name='numAutorizacionAh_{$numeroFactura}' value='" . htmlspecialchars($fila[7]) . "'></td>";
                                        break;
                                    case 'causaMotivoAtencion':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_causaMotivoAtencionAh_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_causaMotivoAtencionAh_{$numeroFactura}' name='causaMotivoAtencionAh_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione Causa Motivo Atención</option>
                                                            <option value='21'>Accidente de trabajo</option>
                                                            <option value='22'>Accidente en el hogar</option>
                                                            <option value='23'>Accidente de tránsito de origen común</option>
                                                            <option value='24'>Accidente de tránsito de origen laboral</option>
                                                            <option value='25'>Accidente en el entorno educativo</option>
                                                            <option value='26'>Otro tipo de accidente</option>
                                                            <option value='27'>Evento catastrófico de origen natural</option>
                                                            <option value='28'>Lesión por agresión</option>
                                                            <option value='29'>Lesión auto infligida</option>
                                                            <option value='30'>Sospecha de violencia física</option>
                                                            <option value='31'>Sospecha de violencia psicológica</option>
                                                            <option value='32'>Sospecha de violencia sexual</option>
                                                            <option value='33'>Sospecha de negligencia y abandono</option>
                                                            <option value='34'>IVE relacionado con peligro a la salud o vida de la mujer</option>
                                                            <option value='35'>IVE por malformación congénita incompatible con la vida</option>
                                                            <option value='36'>IVE por violencia sexual, incesto o por inseminación artificial o transferencia de óvulo fecundado no consentida</option>
                                                            <option value='37'>Evento adverso en salud</option>
                                                            <option value='38'>Enfermedad general</option>
                                                            <option value='39'>Enfermedad laboral</option>
                                                            <option value='40'>Promoción y mantenimiento de la salud – intervenciones individuales</option>
                                                            <option value='41'>Intervención colectiva</option>
                                                            <option value='42'>Atención de población materno perinatal</option>
                                                            <option value='43'>Riesgo ambiental</option>
                                                            <option value='44'>Otros eventos catastróficos</option>
                                                            <option value='45'>Accidente de mina antipersonal – MAP</option>
                                                            <option value='46'>Accidente de artefacto explosivo improvisado – AEI</option>
                                                            <option value='47'>Accidente de munición sin explotar – MUSE</option>
                                                            <option value='48'>Otra víctima de conflicto armado colombiano</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'codDiagnosticoPrincipal':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoPrincipalAh_{$numeroFactura}' name='codDiagnosticoPrincipalAh_{$numeroFactura}' value='" . htmlspecialchars($fila[9]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoPrincipalE':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoPrincipalEAh_{$numeroFactura}' name='codDiagnosticoPrincipalEAh_{$numeroFactura}' value='" . htmlspecialchars($fila[10]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoRelacionadoE1':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionadoE1Ah_{$numeroFactura}' name='codDiagnosticoRelacionadoE1Ah_{$numeroFactura}' value='" . htmlspecialchars($fila[11]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoRelacionadoE2':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionadoE2Ah_{$numeroFactura}' name='codDiagnosticoRelacionadoE2Ah_{$numeroFactura}' value='" . htmlspecialchars($fila[12]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoRelacionadoE3':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionadoE3Ah_{$numeroFactura}' name='codDiagnosticoRelacionadoE3Ah_{$numeroFactura}' value='" . htmlspecialchars($fila[13]) . "'></td>";
                                        break;
                                    case 'codComplicacion':
                                        echo "<td><input type='text' class='form-control' id='_codComplicacionAh_{$numeroFactura}' name='codComplicacionAh_{$numeroFactura}'></td>";
                                        break;
                                    case 'condicionDestinoUsuarioEgreso':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_condicionDestinoUsuarioEgresoAh_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_condicionDestinoUsuarioEgresoAh_{$numeroFactura}' name='condicionDestinoUsuarioEgresoAh_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione Condición Destino Usuario Egreso</option>
                                                            <option value='01'>PACIENTE CON DESTINO A SU DOMICILIO</option>
                                                            <option value='02'>PACIENTE MUERTO</option>
                                                            <option value='03'>PACIENTE DERIVADO A OTRO SERVICIO</option>
                                                            <option value='04'>REFERIDO A OTRA INSTITUCION</option>
                                                            <option value='05'>CONTRAREFERIDO A OTRA INSTITUCION</option>
                                                            <option value='06'>DERIVADO O REFERIDO A HOSPITALIZACION DOMICILIARIA</option>
                                                            <option value='07'>DERIVADO A SERVICIO SOCIAL</option>
                                                            <option value='08'>PACIENTE CONTINUA EN EL SERVICIO (CORTE FACTURACION)</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'codDiagnosticoCausaMuerte':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoCausaMuerteAh_{$numeroFactura}' name='codDiagnosticoCausaMuerteAh_{$numeroFactura}' value='" . htmlspecialchars($fila[15]) . "'></td>";
                                        break;
                                    case 'fechaEgreso':
                                        echo "<td><input type='text' class='form-control' id='_fechaEgresoAh_{$numeroFactura}' name='fechaEgresoAh_{$numeroFactura}' value='" . htmlspecialchars($fila[16]) . "'></td>";
                                        break;
                                    case 'consecutivo':
                                        echo "<td><input type='text' class='form-control' id='_consecutivoAh_{$numeroFactura}' name='consecutivoAh_{$numeroFactura}' ></td>";
                                        break;
                                    default:
                                        echo "<td></td>"; // Si no coincide con ninguno, mostrar celda vacía
                                        break;
                                }
                            }
                            echo "</form>";
                        } elseif ($nombreArchivo === 'AN.txt') {
                            echo "<form id='formAN' method='POST'>";
                            foreach ($columnasAN as $index => $nombreColumna) {
                                switch ($nombreColumna) {
                                    case 'numeroFacturaAN':
                                        echo "<td><input type='text' class='form-control' id='_numeroFacturaAN_{$numeroFactura}' name='numeroFacturaAN_{$numeroFactura}' value='" . htmlspecialchars($fila[0]) . "'></td>";
                                        break;
                                    case 'codPrestador':
                                        echo "<td><input type='text' class='form-control' id='_codPrestadorAN_{$numeroFactura}' name='codPrestadorAN_{$numeroFactura}' value='" . htmlspecialchars($fila[1]) . "'></td>";
                                        break;
                                    case 'tipoDocumentoIdentificacion':
                                        echo "<td>
                                               <div class='col-md-4'>
                                                <label for='_tipoDocumentoIdentificacionAN_{$numeroFactura}'></label>
                                                <select class='form-control' id='_tipoDocumentoIdentificacionAN_{$numeroFactura}' name='tipoDocumentoIdentificacionAN_{$numeroFactura}'>
                                                    <option value='' disabled selected>Seleccione Tipo de Documento</option>
                                                    <option value='CC'>CC - Cédula de Ciudadanía</option>
                                                    <option value='CD'>CD - Carné Diplomático</option>
                                                    <option value='CE'>CE - Cédula de Extranjería</option>
                                                    <option value='CN'>CN - Certificado de Nacimiento</option>
                                                    <option value='DE'>DE - Documento Extranjero</option>
                                                    <option value='MS'>MS - Menor Sin Identificación</option>
                                                    <option value='NI'>NI - Número de Identificación Tributaria</option>
                                                    <option value='NV'>NV - Número de Identificación de la Dian</option>
                                                    <option value='PA'>PA - Pasaporte</option>
                                                </select>
                                               </div>
                                            </td>";
                                        break;
                                    case 'numDocumentoIdentificacion':
                                        echo "<td><input type='text' class='form-control' id='_numDocumentoIdentificacionAN_{$numeroFactura}' name='numDocumentoIdentificacionAN_{$numeroFactura}' value='" . htmlspecialchars($fila[3]) . "'></td>";
                                        break;
                                    case 'fechaNacimiento':
                                        echo "<td><input type='text' class='form-control' id='_fechaNacimientoAN_{$numeroFactura}' name='fechaNacimientoAN_{$numeroFactura}' value='" . htmlspecialchars($fila[4]) . "'></td>";
                                        break;
                                    case 'edadGestacional':
                                        echo "<td><input type='text' class='form-control' id='_edadGestacionalAN_{$numeroFactura}' name='edadGestacionalAN_{$numeroFactura}' value='" . htmlspecialchars($fila[6]) . "'></td>";
                                        break;
                                    case 'numConsultasCPrenatal':
                                        echo "<td><input type='text' class='form-control' id='_numConsultasCPrenatalAN_{$numeroFactura}' name='numConsultasCPrenatalAN_{$numeroFactura}''></td>";
                                        break;
                                    case 'codSexoBiologico':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_codSexoBiologicoAN_{$numeroFactura}'></label>
                                                        <select class='form-control' id='_codSexoBiologicoAN_{$numeroFactura}' name='codSexoBiologicoAN_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione Sexo Biologico</option>
                                                            <option value='H'>Hombre</option>
                                                            <option value='I'>Indeterminado o Intersexual</option>
                                                            <option value='M'>Mujer</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'peso':
                                        echo "<td><input type='text' class='form-control' id='_pesoAN_{$numeroFactura}' name='pesoAN_{$numeroFactura}' value='" . htmlspecialchars($fila[9]) . "'></td>";
                                        break;
                                    case 'codDiagnosticoPrincipal':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoPrincipalAN_{$numeroFactura}' name='codDiagnosticoPrincipalAN_{$numeroFactura}' value='" . htmlspecialchars($fila[10]) . "'></td>";
                                        break;
                                    case 'condicionDestinoUsuarioEgreso':
                                        echo "<td>
                                                        <div class='col-md-4'>
                                                            <label for='_condicionDestinoUsuarioEgresoAN_{$numeroFactura}'></label>
                                                            <select class='form-select form-select-lg' id='_condicionDestinoUsuarioEgresoAN_{$numeroFactura}' name='condicionDestinoUsuarioEgresoAN_{$numeroFactura}'>
                                                                <option value='' disabled selected>Seleccione Condición Destino Usuario Egreso</option>
                                                                <option value='01'>PACIENTE CON DESTINO A SU DOMICILIO</option>
                                                                <option value='02'>PACIENTE MUERTO</option>
                                                                <option value='03'>PACIENTE DERIVADO A OTRO SERVICIO</option>
                                                                <option value='04'>REFERIDO A OTRA INSTITUCION</option>
                                                                <option value='05'>CONTRAREFERIDO A OTRA INSTITUCION</option>
                                                                <option value='06'>DERIVADO O REFERIDO A HOSPITALIZACION DOMICILIARIA</option>
                                                                <option value='07'>DERIVADO A SERVICIO SOCIAL</option>
                                                                <option value='08'>PACIENTE CONTINUA EN EL SERVICIO (CORTE FACTURACION)</option>
                                                            </select>
                                                        </div>
                                                    </td>";
                                        break;
                                    case 'codDiagnosticoCausaMuerte':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoCausaMuerteAN_{$numeroFactura}' name='codDiagnosticoCausaMuerteAN_{$numeroFactura}' value='" . htmlspecialchars($fila[11]) . "'></td>";
                                        break;
                                    case 'fechaEgreso':
                                        echo "<td><input type='text' class='form-control' id='_fechaEgresoAN_{$numeroFactura}' name='fechaEgresoAN_{$numeroFactura}' ></td>";
                                        break;
                                    case 'consecutivo':
                                        echo "<td><input type='text' class='form-control' id='_consecutivoAN_{$numeroFactura}' name='consecutivoAN_{$numeroFactura}' ></td>";
                                        break;
                                    default:
                                        echo "<td></td>"; // Si no coincide con ninguno, mostrar celda vacía
                                        break;
                                }
                            }
                            echo "</form>";
                        } elseif ($nombreArchivo === 'AM.txt') {
                            echo "<form id='formAM' method='POST'>";
                            foreach ($columnasAM as $index => $nombreColumna) {
                                switch ($nombreColumna) {
                                    case 'numeroFacturaAM':
                                        echo "<td><input type='text' class='form-control' id='_numeroFacturaAM_{$numeroFactura}' name='numeroFacturaAM_{$numeroFactura}' value='" . htmlspecialchars($fila[0]) . "'></td>";
                                        break;
                                    case 'codPrestador':
                                        echo "<td><input type='text' class='form-control' id='_codPrestadorAM_{$numeroFactura}' name='codPrestadorAM_{$numeroFactura}' value='" . htmlspecialchars($fila[1]) . "'></td>";
                                        break;
                                    case 'numAutorizacion':
                                        echo "<td><input type='text' class='form-control' id='_numAutorizacionAM_{$numeroFactura}' name='numAutorizacionAM_{$numeroFactura}' value='" . htmlspecialchars($fila[4]) . "'></td>";
                                        break;
                                    case 'idMIPRES':
                                        echo "<td><input type='text' class='form-control' id='_idMIPRESAM_{$numeroFactura}' name='idMIPRESAM_{$numeroFactura}' ></td>";
                                        break;
                                    case 'fechaDispensAdmon':
                                        echo "<td><input type='text' class='form-control' id='_fechaDispensAdmonAM_{$numeroFactura}' name='fechaDispensAdmonAM_{$numeroFactura}'></td>";
                                        break;
                                    case 'codDiagnosticoPrincipal':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoPrincipalAM_{$numeroFactura}' name='codDiagnosticoPrincipalAM_{$numeroFactura}' ></td>";
                                        break;
                                    case 'codDiagnosticoRelacionado':
                                        echo "<td><input type='text' class='form-control' id='_codDiagnosticoRelacionadoAM_{$numeroFactura}' name='codDiagnosticoRelacionadoAM_{$numeroFactura}' ></td>";
                                        break;
                                    case 'tipoMedicamento':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_tipoMedicamentoAM_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg'id='_tipoMedicamentoAM_{$numeroFactura}' name='tipoMedicamentoAM_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione el tipo de medicamento</option>
                                                            <option value='01'>Medicamento con uso con registro sanitario</option>
                                                            <option value='02'>Medicamento con uso como vital no disponible definido por INVIMA</option>
                                                            <option value='03'>Preparación magistral</option>
                                                            <option value='04'>Medicamento con uso no incluido en el registro sanitario (Listado UNIRS)</option>
                                                            <option value='05'>Medicamento con autorización sanitaria de uso emergencia ASUE</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'codTecnologiaSalud':
                                        echo "<td><input type='text' class='form-control' id='_codTecnologiaSaludAM_{$numeroFactura}' name='codTecnologiaSaludAM_{$numeroFactura}' value='" . htmlspecialchars($fila[5]) . "'></td>";
                                        break;
                                    case 'nomTecnologiaSalud':
                                        echo "<td><input type='text' class='form-control' id='_nomTecnologiaSaludAM_{$numeroFactura}' name='nomTecnologiaSaludAM_{$numeroFactura}' value='" . htmlspecialchars($fila[7]) . "'></td>";
                                        break;
                                    case 'concentracionMedicamento':
                                        echo "<td><input type='text' class='form-control' id='_concentracionMedicamentoAM_{$numeroFactura}' name='concentracionMedicamentoAM_{$numeroFactura}' value='" . htmlspecialchars($fila[9]) . "'></td>";
                                        break;
                                    case 'unidadMedida':
                                        echo "<td>
                                                        <div class='col-md-4'>
                                                            <label for='_tunidadMedidaAM_{$numeroFactura}'></label>
                                                            <select class='form-select form-select-lg' id='_unidadMedidaAM_{$numeroFactura}' name='unidadMedidaAM_{$numeroFactura}'>
                                                                <option value='' disabled selected>Seleccione el tipo de medicamento</option>
                                                        <option value='' disabled selected>Seleccione la unidad de medida</option>
                                                        <option value='1'>EID50 dosis infecciosa de embrión 50</option>
                                                        <option value='10'>Bq bequerel(ios)</option>
                                                        <option value='100'>l litro(s)</option>
                                                        <option value='101'>log10 EID50 log 10 50% dosis infecciosa de embrión</option>
                                                        <option value='102'>log10 EID51/dosis log 10 50% dosis infecciosa de embrión/dosis
                                                        </option>
                                                        <option value='103'>log10 CCID50 log10 dosis infecciosa cultivo celular 50</option>
                                                        <option value='104'>log10 CCID50/dosis log10 dosis infecciosa de cultivo celular
                                                            50/dosis</option>
                                                        <option value='105'>log10 unidades ELISA log10 unidad de ensayo inmunoenzimático
                                                        </option>
                                                        <option value='106'>log10 unidades ELISA/dosis log10 unidad de ensayo
                                                            inmunoenzimático/dosis</option>
                                                        <option value='107'>log10 FAI50 log10 ensayo fluorescente dosis infecciosa del 50%
                                                        </option>
                                                        <option value='108'>log10 FAI50/dosis log10 ensayo fluorescente dosis infecciosa del
                                                            50%/dosis</option>
                                                        <option value='109'>log10 PFU log10 unidad(es) formadoras de placa</option>
                                                        <option value='11'>Bq/g bequerel(ios)/gramo</option>
                                                        <option value='110'>log10 PFU/dosis log10 unidad(es) formadoras de placa/dosis
                                                        </option>
                                                        <option value='111'>log10 TCID50 log10 dosis infecciosa de cultivo tisular 50%
                                                        </option>
                                                        <option value='112'>log10 TCID50/dosis log10 dosis infecciosa de cultivo tisular
                                                            50%/dosis</option>
                                                        <option value='113'>log10/ml log10/ml</option>
                                                        <option value='114'>LU unidades de loomis</option>
                                                        <option value='115'>LU/g unidades de loomis/gramo</option>
                                                        <option value='116'>LU/ml unidades de loomis/mililitro</option>
                                                        <option value='117'>lm lumen</option>
                                                        <option value='118'>lx lux</option>
                                                        <option value='119'>unidades MUSP '''mega; unidad de la Farmacopea de los Estados
                                                            Unidos'''</option>
                                                        <option value='12'>Bq/kg bequerel(ios)/kilogramo</option>
                                                        <option value='120'>MBq megabecquerel(ios)</option>
                                                        <option value='121'>MBq/g megabecquerel(ios)/gramo</option>
                                                        <option value='122'>MBq/kg megabecquerel(ios)/kilogramo</option>
                                                        <option value='123'>MBq/l megabecquerel(ios)/litro</option>
                                                        <option value='124'>MBq/µg megabecquerel(ios)/microgramo</option>
                                                        <option value='125'>MBq/µl megabecquerel(ios)/microlitro</option>
                                                        <option value='126'>MBq/mg megabecquerel(ios)/miligramo</option>
                                                        <option value='127'>MBq/ml megabecquerel(ios)/mililitro</option>
                                                        <option value='128'>m metro</option>
                                                        <option value='129'>µCi microcurio(s)</option>
                                                        <option value='13'>Bq/l bequerel(ios)/litro</option>
                                                        <option value='130'>µCi/g microcurio(s)/gramo</option>
                                                        <option value='131'>µCi/kg microcurio(s)/kilogramo</option>
                                                        <option value='132'>µCi/l microcurio(s)/litro</option>
                                                        <option value='133'>µCi/µg microcurio(s)/microgramo</option>
                                                        <option value='134'>µCi/µl microcurio(s)/microlitro</option>
                                                        <option value='135'>µCi/mg microcurio(s)/miligramo</option>
                                                        <option value='136'>µCi/ml microcurio(s)/mililitro</option>
                                                        <option value='137'>µg microgramo(s)</option>
                                                        <option value='138'>µg/m3 microgramo(s)/metro cúbico</option>
                                                        <option value='139'>µg/kg microgramo(s)/kilogramo</option>
                                                        <option value='14'>Bq/µg bequerel(ios)/microgramo</option>
                                                        <option value='140'>µg/l microgramo(s)/litro</option>
                                                        <option value='141'>µg/µl microgramo(s)/microlitro</option>
                                                        <option value='142'>µg/ml microgramo(s)/mililitro</option>
                                                        <option value='143'>µg/m2 microgramo(s)/metro cuadrado</option>
                                                        <option value='144'>µkat microkatal</option>
                                                        <option value='145'>µkat microkatales</option>
                                                        <option value='146'>µl microlitro(s)</option>
                                                        <option value='147'>µl/ml microlitro(s)/mililitro</option>
                                                        <option value='148'>µmol micromol(es)</option>
                                                        <option value='149'>µmol/l micromol(es)/litro</option>
                                                        <option value='15'>Bq/µl bequerel(ios)/microlitro</option>
                                                        <option value='150'>µmol/ml micromol(es)/mililitro</option>
                                                        <option value='151'>mCi milicurio(s)</option>
                                                        <option value='152'>mCi/g milicurio(s)/gramo</option>
                                                        <option value='153'>mCi/kg milicurio(s)/kilogramo</option>
                                                        <option value='154'>mCi/l milicurio(s)/litro</option>
                                                        <option value='155'>mCi/µg milicurio(s)/microgramo</option>
                                                        <option value='156'>mCi/µl milicurio(s)/microlitro</option>
                                                        <option value='157'>mCi/mg milicurio(s)/miligramo</option>
                                                        <option value='158'>mCi/ml milicurio(s)/mililitro</option>
                                                        <option value='159'>mEq miliequivalente(s)</option>
                                                        <option value='16'>Bq/mg bequerel(ios)/miligramo</option>
                                                        <option value='160'>mEq/g miliequivalente(s)/gramo</option>
                                                        <option value='161'>mEq/kg miliequivalente(s)/kilogramo</option>
                                                        <option value='162'>mEq/l miliequivalente(s)/litro</option>
                                                        <option value='163'>mEq/µg miliequivalente(s)/microgramo</option>
                                                        <option value='164'>mEq/µl miliequivalente(s)/microlitro</option>
                                                        <option value='165'>mEq/mg miliequivalente(s)/miligramo</option>
                                                        <option value='166'>mEq/ml miliequivalente(s)/mililitro</option>
                                                        <option value='167'>mg (titer) miligramo (titer)</option>
                                                        <option value='168'>mg miligramo(s)</option>
                                                        <option value='169'>mg/m3 miligramo(s)/metro cúbico</option>
                                                        <option value='17'>Bq/ml bequerel(ios)/mililitro</option>
                                                        <option value='170'>mg/g miligramo(s)/gramo</option>
                                                        <option value='171'>mg/kg miligramo(s)/kilogramo</option>
                                                        <option value='172'>mg/l miligramo(s)/litro</option>
                                                        <option value='173'>mg/ml miligramo(s)/mililitro</option>
                                                        <option value='174'>mg/m2 miligramo(s)/metro cuadrado</option>
                                                        <option value='175'>mkatal milikatal</option>
                                                        <option value='176'>ml mililitro(s)</option>
                                                        <option value='177'>ml/cm2 mililitro(s)/centímetro cuadrado</option>
                                                        <option value='178'>mm milimetro</option>
                                                        <option value='179'>mmol milimol(es)</option>
                                                        <option value='18'>billon CFU billon de unidades formadoras de colonia</option>
                                                        <option value='180'>mmol/g milimol(es)/gramo</option>
                                                        <option value='181'>mmol/kg milimol(es)/kilogramo</option>
                                                        <option value='182'>mmol/l milimol(es)/litro</option>
                                                        <option value='183'>mmol/ml milimol(es)/mililitro</option>
                                                        <option value='184'>millon UFC millones de unidades formadoras de colonias</option>
                                                        <option value='185'>millon UFC/g millones de unidades formadoras de colonias/gramo
                                                        </option>
                                                        <option value='186'>millon UFC/ml millones de unidades formadoras de
                                                            colonias/mililitro</option>
                                                        <option value='187'>millon UI millones de unidadades internacionales</option>
                                                        <option value='188'>millon de organismos millon de organismos</option>
                                                        <option value='189'>millon de organismos/g millon de organismos/gramo</option>
                                                        <option value='19'>billon CFU/g billon de unidades formadoras de colonia/gramo
                                                        </option>
                                                        <option value='190'>millon de organismos/mg millon de organismos/miligramo</option>
                                                        <option value='191'>millon de organismos/ml millon de organismos/mililitro</option>
                                                        <option value='192'>millon de unidades USP millon de unidades de la Farmacopea de
                                                            los Estados Unidos</option>
                                                        <option value='193'>millon de unidades millon de unidades</option>
                                                        <option value='194'>mOsm/kg miliosmol(es)/kilogramo</option>
                                                        <option value='195'>min minuto</option>
                                                        <option value='196'>mol mol(es)</option>
                                                        <option value='197'>mol/g mol(es)/gramo</option>
                                                        <option value='198'>mol/kg mol(es)/kilogramo</option>
                                                        <option value='199'>mol/l mol(es)/litro</option>
                                                        <option value='2'>EID50/dosis dosis infecciosa de embrión 50/dosis</option>
                                                        <option value='20'>billon CFU/ml billon de unidades formadoras de colonia/mililitro
                                                        </option>
                                                        <option value='200'>mol/mg mol(es)/miligramo</option>
                                                        <option value='201'>mol/ml mol(es)/mililitro</option>
                                                        <option value='202'>nCi nanocurio(s)</option>
                                                        <option value='203'>ng nanogramo(s)</option>
                                                        <option value='204'>nkat nanokatal</option>
                                                        <option value='205'>nl nanolitro(s)</option>
                                                        <option value='206'>nmol nanomol(es)</option>
                                                        <option value='207'>nmol/ml nanomol(es)/mililitro</option>
                                                        <option value='208'>N newton</option>
                                                        <option value='209'>unidades NIH/cm2 NIH unidades de trombina inactivada/centímetro
                                                            cuadrado</option>
                                                        <option value='21'>billon de organismos billon de organismos</option>
                                                        <option value='210'>? ohmio</option>
                                                        <option value='211'>OZ onza</option>
                                                        <option value='212'>PPM parte por millon</option>
                                                        <option value='213'>PPM pascal</option>
                                                        <option value='214'>% porcentaje</option>
                                                        <option value='215'>% (v/v) porcentaje volumen/volumen</option>
                                                        <option value='216'>% (p/v) porcentaje peso/volumen</option>
                                                        <option value='217'>% (p/p) porcentaje peso/peso</option>
                                                        <option value='218'>pg picogramo(s)</option>
                                                        <option value='219'>pkat picokatal</option>
                                                        <option value='22'>billon de organismos/g billon de organismos/gramo</option>
                                                        <option value='220'>PFU unidades formadoras de placa</option>
                                                        <option value='221'>PFU e. 1000 LD50 en ratón unidad formadora de placa equivalente
                                                            a 1000 DL50 en ratón</option>
                                                        <option value='222'>PFU/dosis unidades formadoras de placa/dosis</option>
                                                        <option value='223'>PFU/ml unidades formadoras de placa/mililitro</option>
                                                        <option value='224'>unidad formadora de viruela unidad(es) formadoras de viruela
                                                        </option>
                                                        <option value='225'>LB libra</option>
                                                        <option value='226'>unidades de presión/ml unidades de presión/mililitro</option>
                                                        <option value='227'>PNU/ml unidades de nitrogeno proteico/mililitro</option>
                                                        <option value='228'>QS cantidad suficiente</option>
                                                        <option value='229'>r/min revoluciones/minuto</option>
                                                        <option value='23'>billon de organismos/mg billon de organismos/miligramo</option>
                                                        <option value='230'>s segundos</option>
                                                        <option value='231'>S siemens</option>
                                                        <option value='232'>Sv sievert</option>
                                                        <option value='233'>cm2 centímetro cuadrado</option>
                                                        <option value='234'>m2 metro cuadrado</option>
                                                        <option value='235'>T tesla</option>
                                                        <option value='236'>miles CFU miles de unidades formadoras de colonia</option>
                                                        <option value='237'>miles CFU/g miles de unidades formadoras de colonia/gramo
                                                        </option>
                                                        <option value='238'>miles CFU/ml miles de unidades formadoras de colonia/mililitro
                                                        </option>
                                                        <option value='239'>miles de organismos miles de organismos</option>
                                                        <option value='24'>billon de organismos/ml billon de organismos/mililitro</option>
                                                        <option value='240'>miles de organismos/g miles de organismos/gramo</option>
                                                        <option value='241'>miles de organismos/ml miles de organismos/mililitro</option>
                                                        <option value='242'>TCID50/dosis dosis infecciosa de cultivo tisular 50/ dosis
                                                        </option>
                                                        <option value='243'>titre titre</option>
                                                        <option value='244'>t tonelada</option>
                                                        <option value='245'>unidad de tuberculina unidad(es) de tuberculina</option>
                                                        <option value='246'>unidad de tuberculina/ml unidad(es) de tuberculina/mililitro
                                                        </option>
                                                        <option value='247'>U unidades</option>
                                                        <option value='248'>U/g unidades/gramo</option>
                                                        <option value='249'>U/ml unidades/mililitro</option>
                                                        <option value='25'>cd candela</option>
                                                        <option value='250'>unidades USP unidades de la Farmacopea de los Estados Unidos
                                                        </option>
                                                        <option value='251'>V voltio</option>
                                                        <option value='252'>W vatio</option>
                                                        <option value='253'>Wb weber</option>
                                                        <option value='254'>vp Particulas Virales</option>
                                                        <option value='255'>DLmin Dosis letal minima</option>
                                                        <option value='256'>DMN Dosis minima necrotizante</option>
                                                        <option value='26'>CCID50 dosis infecciosa cultivo celular 50</option>
                                                        <option value='27'>CCID50/dosis dosis infecciosa cultivo celular 50/dosis</option>
                                                        <option value='28'>°C temperatura en Celsius</option>
                                                        <option value='29'>CFU/g unidades formadoras de colonias/gramo</option>
                                                        <option value='3'>AU/ml unidades de alergia/mililitro</option>
                                                        <option value='30'>CFU/ml nidades formadoras de colonias/mililitro</option>
                                                        <option value='31'>Co culombio</option>
                                                        <option value='32'>m3 metro cúbico</option>
                                                        <option value='33'>Ci curio(s)</option>
                                                        <option value='34'>Ci/g curie(s)/gramo</option>
                                                        <option value='35'>Ci/kg curie(s)/kilogramo</option>
                                                        <option value='36'>Ci/litro curie(s)/litro</option>
                                                        <option value='37'>Ci/µg curie(s)/microgramo</option>
                                                        <option value='38'>Ci/µl curie(s)/microlitro</option>
                                                        <option value='39'>Ci/mg curie(s)/miligramo</option>
                                                        <option value='4'>A amperio</option>
                                                        <option value='40'>Ci/ml curie(s)/mililitro</option>
                                                        <option value='41'>DAgU unidad(es) de Antigeno D</option>
                                                        <option value='42'>DAgU/ml unidad(es) de Antigeno D/mililitro</option>
                                                        <option value='43'>d dia</option>
                                                        <option value='44'>° grado</option>
                                                        <option value='45'>DF forma de dosificación</option>
                                                        <option value='46'>Gtt gota(s)</option>
                                                        <option value='47'>unidades ELISA unidad de ensayo inmunoenzimático</option>
                                                        <option value='48'>unidades ELISA/dosis unidad de ensayo inmunoenzimático/dosis
                                                        </option>
                                                        <option value='49'>unidades ELISA/ml unidad de ensayo inmunoenzimático/mililitro
                                                        </option>
                                                        <option value='5'>AgU unidad(es) de antígeno</option>
                                                        <option value='50'>F faradio</option>
                                                        <option value='51'>FAI50 ensayo fluorescente dosis infecciosa 50</option>
                                                        <option value='52'>FAI50/dosis ensayo fluorescente dosis infecciosa 50/dosis
                                                        </option>
                                                        <option value='53'>GBq gigabecquerel(ios)</option>
                                                        <option value='54'>GBq/g gigabecquerel/gramo</option>
                                                        <option value='55'>GBq/kg gigabecquerel/kilogramo</option>
                                                        <option value='56'>GBq/l gigabecquerel/litro</option>
                                                        <option value='57'>GBq/µg gigabecquerel/microgramo</option>
                                                        <option value='58'>GBq/µl gigabecquerel/microlitro</option>
                                                        <option value='59'>GBq/mg gigabecquerel/miligramo</option>
                                                        <option value='6'>AgU/ml unidad(es) de antígeno/mililitro</option>
                                                        <option value='60'>GBq/ml gigabecquerel/mililitro</option>
                                                        <option value='61'>g (titre) gramo (titre)</option>
                                                        <option value='62'>g gramo(s)</option>
                                                        <option value='63'>g/m3 gramo/metro cúbico</option>
                                                        <option value='64'>g/l gramo/litro</option>
                                                        <option value='65'>g/ml gramo/mililitro</option>
                                                        <option value='66'>g/m2 gramo/metro cuadrado</option>
                                                        <option value='67'>Gy gray</option>
                                                        <option value='68'>H henrio</option>
                                                        <option value='69'>Hz hertz</option>
                                                        <option value='7'>ATU unidades de antitrombina</option>
                                                        <option value='70'>h hora</option>
                                                        <option value='71'>IOU unidad(es) internacional(es) de opacidad</option>
                                                        <option value='72'>UI unidad(es) internacional(es)</option>
                                                        <option value='73'>UI/g unidad(es) internacional(es)/gramo</option>
                                                        <option value='74'>UI/kg unidad(es) internacional(es)/kilogramo</option>
                                                        <option value='75'>UI/l unidad(es) internacional(es)/litro</option>
                                                        <option value='76'>UI/mg unidad(es) internacional(es)/miligramo</option>
                                                        <option value='77'>UI/ml unidad(es) internacional(es)/mililitro</option>
                                                        <option value='78'>J julio</option>
                                                        <option value='79'>KIU/ml unidad calicreína inactivador/mililitro</option>
                                                        <option value='8'>anti-Xa IU unidades internacionales de actividad anti-Xa</option>
                                                        <option value='80'>kat katal</option>
                                                        <option value='81'>K kelvin</option>
                                                        <option value='82'>kUI unidad internacional de kilo</option>
                                                        <option value='83'>unidades Kusp unidad de la Farmacopea de los Estados Unidos de
                                                            kilo</option>
                                                        <option value='84'>unidades k unidades kilo</option>
                                                        <option value='85'>kBq kilobecquerel(ios)</option>
                                                        <option value='86'>kBq/g kilobecquerel(ios)/gramo</option>
                                                        <option value='87'>kBq/kg kilobecquerel(ios)/kilogramo</option>
                                                        <option value='88'>kBq/l kilobecquerel(ios)/litro</option>
                                                        <option value='89'>kBq/µg kilobecquerel(ios)/microgramo</option>
                                                        <option value='9'>anti-Xa IU/ml unidades internacionales de actividad
                                                            anti-Xa/mililitro</option>
                                                        <option value='90'>kBq/µl kilobecquerel(ios)/microlitro</option>
                                                        <option value='9000'>Dosis Dosis</option>
                                                        <option value='9001'>TPU TPU</option>
                                                        <option value='9002'>TSU TSU</option>
                                                        <option value='9003'>DBU DBU</option>
                                                        <option value='9004'>SU SU</option>
                                                        <option value='9005'>IR IR</option>
                                                        <option value='9006'>DPP DPP</option>
                                                        <option value='9007'>HEP HEP</option>
                                                        <option value='9008'>UT UT</option>
                                                        <option value='9009'>SQ SQ</option>
                                                        <option value='9010'>UB UB</option>
                                                        <option value='9011'>DL50 Dosis letal 50</option>
                                                        <option value='9012'>AU Unidades de Alergia</option>
                                                        <option value='9013'>BAU Bioequivalente Unidades de Alergia</option>
                                                        <option value='9014'>PNU Unidades de nitrogeno proteico</option>
                                                        <option value='9015'>DPU Unidades de diagnostico no estandarizadas biologicamente
                                                        </option>
                                                        <option value='91'>kBq/mg kilobecquerel(ios)/miligramo</option>
                                                        <option value='92'>kBq/ml kilobecquerel(ios)/mililitro</option>
                                                        <option value='93'>kg kilogramo(s)</option>
                                                        <option value='94'>kg/m3 kilogramo(s)/metro cúbico</option>
                                                        <option value='95'>kg/l kilogramo(s)/litro</option>
                                                        <option value='96'>kg/m2 kilogramo(s)/metro cuadrado</option>
                                                        <option value='97'>LacU unidades de lactasa</option>
                                                        <option value='98'>LfU unidades de floculación (lime flocculation unit(s))</option>
                                                        <option value='99'>LfU/ml unidades de floculación (lime flocculation
                                                            unit(s))/mililitro</option>
                                                        </select>
                                                        </div>
                                                    </td>";
                                        break;
                                    case 'formaFarmaceutica':
                                        echo "<td>
                                                   <div class='col-md-4'>
                                                    <label for='_formaFarmaceuticaAM_{$numeroFactura}'></label>
                                                    <select class='form-select form-select-lg' id='_formaFarmaceuticaAM_{$numeroFactura}' name='formaFarmaceuticaAM_{$numeroFactura}'>
                                                        <option value='' disabled selected>Seleccione forma Farmaceutica</option>
                                                        <option value='C28944'>CREMA</option>
                                                        <option value='C29167'>LOCION</option>
                                                        <option value='C29269'>ENJUAGUE</option>
                                                        <option value='C42887'>AEROSOL</option>
                                                        <option value='C42902'>CAPSULA DE LIBERACION RETARDADA</option>
                                                        <option value='C42905'>TABLETAS DE LIBERACION RETARDADA</option>
                                                        <option value='C42909'>GRANULOS EFERVESCENTES</option>
                                                        <option value='C42912'>ELIXIR</option>
                                                        <option value='C42914'>EMULSION INYECTABLE</option>
                                                        <option value='C42916'>CAPSULA DE LIBERACION PROLONGADA</option>
                                                        <option value='C42927'>TABLETAS DE LIBERACION PROLONGADA</option>
                                                        <option value='C42932'>CINTA ADHESIVA / PELICULA</option>
                                                        <option value='C42933'>GAS</option>
                                                        <option value='C42938'>GRANULOS CONVENCIONALES</option>
                                                        <option value='C42941'>GOMA</option>
                                                        <option value='C42942'>IMPLANTE</option>
                                                        <option value='C42948'>GELES y JALEAS</option>
                                                        <option value='C42953'>LIQUIDO (Diferentes a soluciones)</option>
                                                        <option value='C42966'>UNGÜENTO</option>
                                                        <option value='C42967'>PASTA</option>
                                                        <option value='C42968'>SISTEMAS TRANSDERMICOS</option>
                                                        <option value='C42969'>PELLETS</option>
                                                        <option value='C42983'>JABONES Y CHAMPU</option>
                                                        <option value='C42989'>ESPRAY</option>
                                                        <option value='C42993'>SUPOSITORIO / OVULO</option>
                                                        <option value='C42994'>SUSPENSION</option>
                                                        <option value='C42996'>JARABE</option>
                                                        <option value='C43000'>TINTURA</option>
                                                        <option value='C47913'>EMPLASTO</option>
                                                        <option value='C47914'>TIRA</option>
                                                        <option value='C47915'>SISTEMAS INTRAUTERINOS</option>
                                                        <option value='C64898'>ESPUMA</option>
                                                        <option value='C64904'>CAPSULA CUBIERTA DURA</option>
                                                        <option value='C64909'>CAPSULA BLANDA</option>
                                                        <option value='C69031'>SISTEMAS OCULARES</option>
                                                        <option value='C91199'>SISTEMAS DE ANILLOS VAGINALES</option>
                                                        <option value='C91200'>SISTEMAS</option>
                                                        <option value='COLFF001'>TABLETAS DE LIBERACION NO MODIFICADA</option>
                                                        <option value='COLFF002'>POLVOS PARA NO RECONSTITUIR</option>
                                                        <option value='COLFF003'>POLVOS PARA RECONSTITUIR</option>
                                                        <option value='COLFF004'>OTRAS SOLUCIONES</option>
                                                        <option value='COLFF005'>OTRAS EMULSIONES</option>
                                                        <option value='COLFF006'>CAPSULAS DE LIBERACION NO MODIFICADA</option>
                                                        <option value='COLFF007'>CAPSULAS DE LIBERACION MODIFICADA</option>
                                                        <option value='COLFF008'>TABLETAS DE LIBERACION MODIFICADA</option>
                                                        <option value='COLFF009'>GRANULOS DE LIBERACION NO MODIFICADA</option>
                                                        <option value='COLFF010'>GRANULOS DE LIBERACION MODIFICADA</option>
                                                    </select>
                                                   </div>
                                                </td>";
                                        break;
                                    case 'unidadMinDispensa':
                                        echo "<td>
                                                       <div class='col-md-4'>
                                                        <label for='_unidadMinDispensaAM_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_unidadMinDispensaAM_{$numeroFactura}' name='unidadMinDispensaAM_{$numeroFactura}'>
                                                        <option value='' disabled selected>Seleccione la unidad mínima de dispensa</option>
                                                        <option value='1'>AMPOLLA</option>
                                                        <option value='10'>ENVASE</option>
                                                        <option value='11'>CAJA</option>
                                                        <option value='12'>LATA</option>
                                                        <option value='13'>FRASCO</option>
                                                        <option value='14'>CAPSULA</option>
                                                        <option value='15'>CARTON</option>
                                                        <option value='16'>CARTUCHO</option>
                                                        <option value='17'>ESTUCHE</option>
                                                        <option value='18'>PELICULA DE PVC TRANSPARENTE DE COLORES</option>
                                                        <option value='19'>UNIDADES CLINICAS</option>
                                                        <option value='2'>APLICADOR</option>
                                                        <option value='20'>RECUBRIMIENTO</option>
                                                        <option value='21'>CONTENEDOR</option>
                                                        <option value='22'>RECUENTO</option>
                                                        <option value='23'>COPA</option>
                                                        <option value='24'>CILINDRO</option>
                                                        <option value='25'>VASOS DEWAR</option>
                                                        <option value='26'>DIAL PACK</option>
                                                        <option value='27'>DISCO</option>
                                                        <option value='28'>DOSIS EN ENVASE</option>
                                                        <option value='29'>GOTAS</option>
                                                        <option value='3'>BOLSA</option>
                                                        <option value='30'>TAMBOR - BOMBO</option>
                                                        <option value='31'>PELICULA</option>
                                                        <option value='32'>GENERADOR</option>
                                                        <option value='33'>GLOBULO</option>
                                                        <option value='34'>DILUCION HOMEOPATICA</option>
                                                        <option value='35'>IMPLANTE</option>
                                                        <option value='36'>INHALACION</option>
                                                        <option value='37'>INHALADOR</option>
                                                        <option value='38'>INHALADOR, RECARGA</option>
                                                        <option value='39'>INSERTO</option>
                                                        <option value='4'>BARRA</option>
                                                        <option value='40'>FRASCO</option>
                                                        <option value='41'>JARRA</option>
                                                        <option value='42'>UNIDAD INHIBIDORA DE CALICREINA</option>
                                                        <option value='43'>KIT</option>
                                                        <option value='44'>PASTILLA</option>
                                                        <option value='45'>EMBALAJE</option>
                                                        <option value='46'>PAQUETE</option>
                                                        <option value='47'>BALDE</option>
                                                        <option value='48'>PARTES</option>
                                                        <option value='49'>PARCHE</option>
                                                        <option value='5'>PERLA</option>
                                                        <option value='50'>PILDORA (PELLET)</option>
                                                        <option value='51'>PIEZA</option>
                                                        <option value='53'>UNIDADES DE PRESION</option>
                                                        <option value='54'>ANILLO</option>
                                                        <option value='55'>SATURADO</option>
                                                        <option value='56'>CUCHARA MEDIDORA</option>
                                                        <option value='57'>ESPONJA</option>
                                                        <option value='58'>ATOMIZADOR (SPRAY)</option>
                                                        <option value='59'>CENTIMETRO CUADRADO</option>
                                                        <option value='6'>BLISTER</option>
                                                        <option value='61'>TIRA</option>
                                                        <option value='63'>SUPOSITORIO</option>
                                                        <option value='64'>HISOPO</option>
                                                        <option value='65'>JERINGA</option>
                                                        <option value='66'>TABLETA</option>
                                                        <option value='67'>TABMINDER</option>
                                                        <option value='68'>TAMPON</option>
                                                        <option value='69'>TANQUE</option>
                                                        <option value='7'>ENVASE BLISTER</option>
                                                        <option value='70'>PRUEBA</option>
                                                        <option value='71'>BANDEJA</option>
                                                        <option value='72'>TROCHE</option>
                                                        <option value='73'>TUBO</option>
                                                        <option value='74'>UNIDADES</option>
                                                        <option value='75'>VIAL</option>
                                                        <option value='76'>OBLEA</option>
                                                        <option value='77'>TERMO</option>
                                                        <option value='78'>SOBRE</option>
                                                        <option value='79'>PLUMA</option>
                                                        <option value='8'>BLOQUE</option>
                                                        <option value='80'>LITRO</option>
                                                        <option value='81'>OVULO</option>
                                                        <option value='9'>BOLO</option>
                                                        </select>
                                                       </div>
                                                    </td>";
                                        break;
                                    case 'cantidadMedicamento':
                                        echo "<td><input type='text' class='form-control' id='_cantidadMedicamentoAM_{$numeroFactura}' name='cantidadMedicamentoAM_{$numeroFactura}' value='" . htmlspecialchars($fila[11]) . "'></td>";
                                        break;
                                    case 'diasTratamiento':
                                        echo "<td><input type='text' class='form-control' id='_diasTratamientoAM_{$numeroFactura}' name='diasTratamientoAM_{$numeroFactura}'></td>";
                                        break;
                                    case 'tipoDocumentoIdentificacion':
                                        echo "<td>
                                                   <div class='col-md-4'>
                                                    <label for='_tipoDocumentoIdentificacionAM_{$numeroFactura}'></label>
                                                    <select class='form-select form-select-lg' id='_tipoDocumentoIdentificacionAM_{$numeroFactura}' name='tipoDocumentoIdentificacionAM_{$numeroFactura}'>
                                                        <option value='' disabled selected>Seleccione Tipo de Documento</option>
                                                        <option value='CC'>CC - Cédula de Ciudadanía</option>
                                                        <option value='CD'>CD - Carné Diplomático</option>
                                                        <option value='CE'>CE - Cédula de Extranjería</option>
                                                        <option value='CN'>CN - Certificado de Nacimiento</option>
                                                        <option value='DE'>DE - Documento Extranjero</option>
                                                        <option value='MS'>MS - Menor Sin Identificación</option>
                                                        <option value='NI'>NI - Número de Identificación Tributaria</option>
                                                        <option value='NV'>NV - Número de Identificación de la Dian</option>
                                                        <option value='PA'>PA - Pasaporte</option>
                                                    </select>
                                                   </div>
                                                </td>";
                                        break;
                                    case 'numDocumentoIdentificacion':
                                        echo "<td><input type='text' class='form-control' id='_numDocumentoIdentificacionAM_{$numeroFactura}' name='numDocumentoIdentificacionAM_{$numeroFactura}'></td>";
                                        break;
                                    case 'vrUnitMedicamento':
                                        echo "<td><input type='text' class='form-control' id='_vrUnitMedicamentoAM_{$numeroFactura}' name='vrUnitMedicamentoAM_{$numeroFactura}' value='" . htmlspecialchars($fila[12]) . "'></td>";
                                        break;
                                    case 'vrServicio':
                                        echo "<td><input type='text' class='form-control' id='_vrServicioAM_{$numeroFactura}' name='vrServicioAM_{$numeroFactura}' value='" . htmlspecialchars($fila[13]) . "'></td>";
                                        break;
                                    case 'conceptoRecaudo':
                                        echo "<td>
                                                <div class='col-md-4'>
                                                    <label for='_conceptoRecaudoAM_{$numeroFactura}'></label>
                                                    <select class='form-select form-select-lg' id='_conceptoRecaudoAM_{$numeroFactura}' name='conceptoRecaudoAM_{$numeroFactura}'>
                                                        <option value=''disabled selected>Seleccione Concepto Recaudo</option>
                                                        <option value='01'>COPAGO</option>
                                                        <option value='02'>CUOTA MODERADORA</option>
                                                        <option value='03'>PAGOS COMPARTIDOS EN PLANES VOLUNTARIOS DE SALUD</option>
                                                        <option value='04'>ANTICIPO</option>
                                                        <option value='05'>NO APLICA</option>
                                                     </select>
                                                </div>
                                            </td>";
                                        break;
                                    case 'valorPagoModerador':
                                        echo "<td><input type='text' class='form-control' id='_valorPagoModeradorAM_{$numeroFactura}' name='valorPagoModeradorAM_{$numeroFactura}'></td>";
                                        break;
                                    case 'numFEVPagoModerador':
                                        echo "<td><input type='text' class='form-control' id='_numFEVPagoModeradorAM_{$numeroFactura}' name='numFEVPagoModeradorAM_{$numeroFactura}'></td>";
                                        break;
                                    case 'consecutivo':
                                        echo "<td><input type='text' class='form-control' id='_consecutivoAM_{$numeroFactura}' name='consecutivoAM_{$numeroFactura}'></td>";
                                        break;
                                    default:
                                        echo "<td></td>"; // Si no coincide con ninguno, mostrar celda vacía
                                        break;
                                }
                            }
                            echo "</form>";
                        } elseif ($nombreArchivo === 'AT.txt') {
                            echo "<form id='formAT' method='POST'>";
                            foreach ($columnasAT as $index => $nombreColumna) {
                                switch ($nombreColumna) {
                                    case 'numeroFacturaAT':
                                        echo "<td><input type='text' class='form-control' id='_numeroFacturaAT_{$numeroFactura}' name='numeroFacturaAT_{$numeroFactura}' value='" . htmlspecialchars($fila[0]) . "'></td>";
                                        break;
                                    case 'codPrestador':
                                        echo "<td><input type='text' class='form-control' id='_codPrestadorAT_{$numeroFactura}' name='codPrestadorAT_{$numeroFactura}' value='" . htmlspecialchars($fila[1]) . "'></td>";
                                        break;
                                    case 'numAutorizacion':
                                        echo "<td><input type='text' class='form-control' id='_numAutorizacionAT_{$numeroFactura}' name='numAutorizacionAT_{$numeroFactura}' value='" . htmlspecialchars($fila[4]) . "'></td>";
                                        break;
                                    case 'idMIPRES':
                                        echo "<td><input type='text' class='form-control' id='_idMIPRESAT_{$numeroFactura}' name='idMIPRESAT_{$numeroFactura}'></td>";
                                        break;
                                    case 'fechaSuministroTecnologia':
                                        echo "<td><input type='text' class='form-control' id='_fechaSuministroTecnologiaAT_{$numeroFactura}' name='fechaSuministroTecnologiaAT_{$numeroFactura}'></td>";
                                        break;
                                    case 'tipoOS':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_tipoOSAT_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_tipoOSAT_{$numeroFactura}' name='tipoOSAT_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione un tipo de OS</option>
                                                            <option value='01'>DISPOSITIVOS MÉDICOS E INSUMOS</option>
                                                            <option value='02'>TRASLADOS</option>
                                                            <option value='03'>ESTANCIAS</option>
                                                            <option value='04'>SERVICIOS COMPLEMENTARIOS</option>
                                                            <option value='05'>HONORARIOS</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'codTecnologiaSalud':
                                        echo "<td><input type='text' class='form-control' id='_codTecnologiaSaludAT_{$numeroFactura}' name='codTecnologiaSaludAT_{$numeroFactura}' value='" . htmlspecialchars($fila[6]) . "'></td>";
                                        break;
                                    case 'nomTecnologiaSalud':
                                        echo "<td><input type='text' class='form-control' id='_nomTecnologiaSaludAT_{$numeroFactura}' name='nomTecnologiaSaludAT_{$numeroFactura}' value='" . htmlspecialchars($fila[7]) . "'></td>";
                                        break;
                                    case 'cantidadOS':
                                        echo "<td><input type='text' class='form-control' id='_cantidadOSAT_{$numeroFactura}' name='cantidadOSAT_{$numeroFactura}' value='" . htmlspecialchars($fila[8]) . "'></td>";
                                        break;
                                    case 'tipoDocumentoIdentificacion':
                                        echo "<td>
                                                <div class='col-md-4'>
                                                    <label for='_tipoDocumentoIdentificacionAT_{$numeroFactura}'></label>
                                                    <select class='form-select form-select-lg' id='_tipoDocumentoIdentificacionAT_{$numeroFactura}' name='tipoDocumentoIdentificacionAT_{$numeroFactura}'>
                                                        <option value='' disabled selected>Seleccione Tipo de Documento</option>
                                                        <option value='CC'>CC - Cédula de Ciudadanía</option>
                                                        <option value='CD'>CD - Carné Diplomático</option>
                                                        <option value='CE'>CE - Cédula de Extranjería</option>
                                                        <option value='CN'>CN - Certificado de Nacimiento</option>
                                                        <option value='DE'>DE - Documento Extranjero</option>
                                                        <option value='MS'>MS - Menor Sin Identificación</option>
                                                        <option value='NI'>NI - Número de Identificación Tributaria</option>
                                                        <option value='NV'>NV - Número de Identificación de la Dian</option>
                                                        <option value='PA'>PA - Pasaporte</option>
                                                        </select>
                                                 </div>
                                            </td>";
                                        break;
                                    case 'numDocumentoIdentificacion':
                                        echo "<td><input type='text' class='form-control' id='_numDocumentoIdentificacionAT_{$numeroFactura}' name='numDocumentoIdentificacionAT_{$numeroFactura}'></td>";
                                        break;
                                    case 'vrUnitOS':
                                        echo "<td><input type='text' class='form-control' id='_vrUnitOSAT_{$numeroFactura}' name='vrUnitOSAT_{$numeroFactura}'></td>";
                                        break;
                                    case 'vrServicio':
                                        echo "<td><input type='text' class='form-control' id='_vrServicioAT_{$numeroFactura}' name='vrServicioAT_{$numeroFactura}'></td>";
                                        break;
                                    case 'conceptoRecaudo':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_conceptoRecaudoAT_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_conceptoRecaudoAT_{$numeroFactura}' name='conceptoRecaudoAT_{$numeroFactura}'>
                                                            <option value=''disabled selected>Seleccione Concepto Recaudo</option>
                                                            <option value='01'>COPAGO</option>
                                                            <option value='02'>CUOTA MODERADORA</option>
                                                            <option value='03'>PAGOS COMPARTIDOS EN PLANES VOLUNTARIOS DE SALUD</option>
                                                            <option value='04'>ANTICIPO</option>
                                                            <option value='05'>NO APLICA</option>
                                                         </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'valorPagoModerador':
                                        echo "<td><input type='text' class='form-control' id='_valorPagoModeradorAT_{$numeroFactura}' name='valorPagoModeradorAT_{$numeroFactura}'></td>";
                                        break;
                                    case 'numFEVPagoModerador':
                                        echo "<td><input type='text' class='form-control' id='_numFEVPagoModeradorAT_{$numeroFactura}' name='numFEVPagoModeradorAT_{$numeroFactura}'></td>";
                                        break;
                                    case 'consecutivo':
                                        echo "<td><input type='text' class='form-control' id='_consecutivoAT_{$numeroFactura}' name='consecutivoAT_{$numeroFactura}'></td>";
                                        break;
                                    default:
                                        echo "<td></td>"; // Si no coincide con ninguno, mostrar celda vacía
                                        break;
                                }
                            }
                            echo "</form>";
                        } elseif ($nombreArchivo === 'US.txt') {
                            echo "<form id='formUS' method='POST'>";
                            foreach ($columnasUS as $index => $nombreColumna) {
                                switch ($nombreColumna) {
                                    case 'tipoDocumentoIdentificacion':
                                        echo "<td><input type='text' class='form-control' id='_tipoDocumentoIdentificacionUS_{$numeroFactura}' name='_tipoDocumentoIdentificacionUS_{$numeroFactura}' value='" . htmlspecialchars($fila[0]) . "'></td>";
                                        break;
                                    case 'numDocumentoIdentificacion':
                                        echo "<td><input type='text' class='form-control' id='_numDocumentoIdentificacionUS_{$numeroFactura}' name='_numDocumentoIdentificacionUS_{$numeroFactura}' value='" . htmlspecialchars($fila[1]) . "'></td>";
                                        break;
                                    case 'num_DocumentoIdObligado':
                                        echo "<td><input type='text' class='form-control' id='_num_DocumentoIdObligadoUS_{$numeroFactura}' name='_num_DocumentoIdObligadoUS_{$numeroFactura}'></td>";
                                        break;
                                    case 'tipoUsuario':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_tipoUsuarioUS_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_tipoUsuarioUS_{$numeroFactura}' name='tipoUsuarioUS_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione un tipo de usuario</option> 
                                                            <option value='01'>Contributivo cotizante</option>
                                                            <option value='02'>Contributivo beneficiario</option>
                                                            <option value='03'>Contributivo adicional</option>
                                                            <option value='04'>Subsidiado</option>
                                                            <option value='05'>No afiliado</option>
                                                            <option value='06'>Especial o Excepcion cotizante</option>
                                                            <option value='07'>Especial o Excepcion beneficiario</option>
                                                            <option value='08'>Personas privadas de la libertad a cargo del Fondo Nacional de Salud</option>
                                                            <option value='09'>Tomador / Amparado ARL</option>
                                                            <option value='10'>Tomador / Amparado SOAT</option>
                                                            <option value='11'>Tomador / Amparado Planes voluntarios de salud</option>
                                                            <option value='12'>Particular</option>
                                                            <option value='13'>Especial o Excepcion no cotizante Ley 352 de 1997</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'fechaNacimiento':
                                        echo "<td><input type='date' class='form-control' id='_fechaNacimientoUS_{$numeroFactura}' name='fechaNacimientoUS_{$numeroFactura}'></td>";
                                        break;
                                    case 'codSexo':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_codSexoUS_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_codSexoUS_{$numeroFactura}' name='codSexoUS_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione sexo</option>
                                                            <option value='H'>Hombre</option>
                                                            <option value='I'>Indeterminado o Intersexual</option>
                                                            <option value='M'>Mujer</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'codPaisResidencia':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_codPaisResidenciaUS_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_codPaisResidenciaUS_{$numeroFactura}' name='codPaisResidenciaUS_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione un pais de residencia</option>
                                                                    <option value='004'>AFGANISTÁN</option>
                                                                    <option value='008'>ALBANIA</option>
                                                                    <option value='010'>ANTÁRTIDA</option>
                                                                    <option value='012'>ARGELIA</option>
                                                                    <option value='016'>SAMOA AMERICANA</option>
                                                                    <option value='020'>ANDORRA</option>
                                                                    <option value='024'>ANGOLA</option>
                                                                    <option value='028'>ANTIGUA Y BARBUDA</option>
                                                                    <option value='031'>AZERBAIYÁN</option>
                                                                    <option value='032'>ARGENTINA</option>
                                                                    <option value='036'>AUSTRALIA</option>
                                                                    <option value='040'>AUSTRIA</option>
                                                                    <option value='044'>BAHAMAS</option>
                                                                    <option value='048'>BARÉIN</option>
                                                                    <option value='050'>BANGLADÉS</option>
                                                                    <option value='051'>ARMENIA</option>
                                                                    <option value='052'>BARBADOS</option>
                                                                    <option value='056'>BÉLGICA</option>
                                                                    <option value='060'>BERMUDA</option>
                                                                    <option value='064'>BUTÁN</option>
                                                                    <option value='068'>BOLIVIA</option>
                                                                    <option value='070'>BOSNIA-HERZEGOVINA</option>
                                                                    <option value='072'>BOTSUANA</option>
                                                                    <option value='074'>ISLA BOUVET</option>
                                                                    <option value='076'>BRAZIL</option>
                                                                    <option value='084'>BELICE</option>
                                                                    <option value='086'>TERRITORIO BRITÁNICO DEL OCÉANO ÍNDICO</option>
                                                                    <option value='090'>ISLAS SOLOMON</option>
                                                                    <option value='092'>ISLAS VÍRGENES BRITÁNICAS</option>
                                                                    <option value='096'>BRUNÉI</option>
                                                                    <option value='100'>BULGARIA</option>
                                                                    <option value='104'>MYANMAR (FORMER BURMA)</option>
                                                                    <option value='108'>BURUNDI</option>
                                                                    <option value='112'>BIELORRUSIA</option>
                                                                    <option value='116'>CAMBOYA</option>
                                                                    <option value='120'>CAMERÚN</option>
                                                                    <option value='124'>CANADÁ</option>
                                                                    <option value='132'>CABO VERDE</option>
                                                                    <option value='136'>ISLAS CAIMÁN</option>
                                                                    <option value='140'>REPÚBLICA CENTROAFRICANA</option>
                                                                    <option value='144'>SRI LANKA</option>
                                                                    <option value='148'>CHAD</option>
                                                                    <option value='152'>CHILE</option>
                                                                    <option value='156'>CHINA</option>
                                                                    <option value='158'>TAIWAN</option>
                                                                    <option value='162'>ISLA DE NAVIDAD</option>
                                                                    <option value='166'>ISLAS COCOS</option>
                                                                    <option value='170'>COLOMBIA</option> 
                                                                    <option value='174'>COMORAS</option>
                                                                    <option value='175'>MAYOTTE</option>
                                                                    <option value='178'>CONGO</option>
                                                                    <option value='180'>REPÚBLICA DEMOCRÁTICA DEL CONGO</option>
                                                                    <option value='184'>ISLAS COOK</option>
                                                                    <option value='188'>COSTA RICA</option>
                                                                    <option value='191'>CROACIA</option>
                                                                    <option value='192'>CUBA</option>
                                                                    <option value='196'>CHIPRE</option>
                                                                    <option value='203'>REPÚBLICA CHECA</option>
                                                                    <option value='204'>BENIN</option>
                                                                    <option value='208'>DINAMARCA</option>
                                                                    <option value='212'>DOMINICA</option>
                                                                    <option value='214'>REPÚBLICA DOMINICANA</option>
                                                                    <option value='218'>ECUADOR</option>
                                                                    <option value='222'>EL SALVADOR</option>
                                                                    <option value='226'>GUINEA ECUATORIAL</option>
                                                                    <option value='231'>ETIOPIA</option>
                                                                    <option value='232'>ERITREA</option>
                                                                    <option value='233'>ESTONIA</option>
                                                                    <option value='234'>ISLAS FEROE</option>
                                                                    <option value='238'>ISLAS MALVINAS</option>
                                                                    <option value='239'>ISLAS GEORGIAS DEL SUR Y SANDWICH DEL SUR</option>
                                                                    <option value='242'>FIYI</option>
                                                                    <option value='246'>FINLANDIA</option>
                                                                    <option value='248'>ALAND</option>
                                                                    <option value='250'>FRANCIA</option>
                                                                    <option value='254'>GUAYANA FRANCESA</option>
                                                                    <option value='258'>POLINESIA FRANCESA</option>
                                                                    <option value='260'>TIERRAS AUSTRALES Y ANTÁRTICAS FRANCESAS</option>
                                                                    <option value='262'>YIBUTI</option>
                                                                    <option value='266'>GABON</option>
                                                                    <option value='268'>GEORGIA</option>
                                                                    <option value='270'>GAMBIA</option>
                                                                    <option value='275'>PALESTINA</option>
                                                                    <option value='276'>ALEMANIA</option>
                                                                    <option value='288'>GHANA</option>
                                                                    <option value='292'>GIBRALTAR</option>
                                                                    <option value='296'>KIRIBATI</option>
                                                                    <option value='300'>GRECIA</option>
                                                                    <option value='304'>GROENLANDIA</option>
                                                                    <option value='308'>GRANADA</option>
                                                                    <option value='312'>GUADALUOE</option>
                                                                    <option value='316'>GUAM</option>
                                                                    <option value='320'>GUATEMALA</option>
                                                                    <option value='324'>GUINEA</option>
                                                                    <option value='328'>GUYANA</option>
                                                                    <option value='332'>HAITI</option>
                                                                    <option value='334'>ISLA HEARD Y MCDONALD</option>
                                                                    <option value='336'>SANTA SEDE</option>
                                                                    <option value='340'>HONDURAS</option>
                                                                    <option value='344'>HONG KONG</option>
                                                                    <option value='348'>HUNGRÍA</option>
                                                                    <option value='352'>ISLANDIA</option>
                                                                    <option value='356'>INDIA</option>
                                                                    <option value='360'>INDONESIA</option>
                                                                    <option value='364'>IRÁN</option>
                                                                    <option value='368'>IRAQ</option>
                                                                    <option value='372'>IRLANDA</option>
                                                                    <option value='376'>ISRAEL</option>
                                                                    <option value='380'>ITALIA</option>
                                                                    <option value='384'>COSTA DE MARFIL</option>
                                                                    <option value='388'>JAMAICA</option>
                                                                    <option value='392'>JAPÓN</option>
                                                                    <option value='398'>KAZAJISTÁN</option>
                                                                    <option value='400'>JORDANIA</option>
                                                                    <option value='404'>KENYA</option>
                                                                    <option value='408'>COREA DEL NORTE</option>
                                                                    <option value='410'>COREA DEL SUR</option>
                                                                    <option value='414'>KUWAIT</option>
                                                                    <option value='417'>KIRGUISTÁN</option>
                                                                    <option value='418'>LAOS</option>
                                                                    <option value='422'>LÍBANO</option>
                                                                    <option value='426'>LESOTO</option>
                                                                    <option value='428'>LETONIA</option>
                                                                    <option value='430'>LIBERIA</option>
                                                                    <option value='434'>LIBIA</option>
                                                                    <option value='438'>LIECHTENSTEIN</option>
                                                                    <option value='440'>LITUANIA</option>
                                                                    <option value='442'>LUXEMBURGO</option>
                                                                    <option value='446'>MACAO</option>
                                                                    <option value='450'>MADAGASCAR</option>
                                                                    <option value='454'>MALAUI</option>
                                                                    <option value='458'>MALASIA</option>
                                                                    <option value='462'>MALDIVAS</option>
                                                                    <option value='466'>MALI</option>
                                                                    <option value='470'>MALTA</option>
                                                                    <option value='474'>MARTINICA</option>
                                                                    <option value='478'>MAURITANIA</option>
                                                                    <option value='480'>MAURICIO</option>
                                                                    <option value='484'>MÉXICO</option>
                                                                    <option value='492'>MÓNACO</option>
                                                                    <option value='496'>MONGOLIA</option>
                                                                    <option value='498'>MOLDAVIA</option>
                                                                    <option value='499'>MONTENEGRO</option>
                                                                    <option value='500'>MONTSERRAT</option>
                                                                    <option value='504'>MARRUECOS</option>
                                                                    <option value='508'>MOZAMBIQUE</option>
                                                                    <option value='512'>OMÁN</option>
                                                                    <option value='516'>NAMIBIA</option>
                                                                    <option value='520'>NAURU</option>
                                                                    <option value='524'>NEPAL</option>
                                                                    <option value='528'>PAÍSES BAJOS</option>
                                                                    <option value='540'>NUEVA CALEDONIA</option>
                                                                    <option value='548'>VANUATU</option>
                                                                    <option value='554'>NUEVA ZELANDA</option>
                                                                    <option value='558'>NICARAGUA</option>
                                                                    <option value='562'>NÍGER</option>
                                                                    <option value='566'>NIGERIA</option>
                                                                    <option value='570'>NIUE</option>
                                                                    <option value='574'>ISLA NORFOLK</option>
                                                                    <option value='578'>NORUEGA</option>
                                                                    <option value='580'>ISLAS MARIANAS DEL NORTE</option>
                                                                    <option value='581'>ISLAS MENORES ALEJADAS DE LOS ESTADOS UNIDOS</option>
                                                                    <option value='583'>MICRONESIA</option>
                                                                    <option value='584'>ISLAS MARSHALL</option>
                                                                    <option value='585'>PALAU</option>
                                                                    <option value='586'>PAKISTÁN</option>
                                                                    <option value='591'>PANAMÁ</option>
                                                                    <option value='598'>PAPÚA NUEVA GUINEA</option>
                                                                    <option value='600'>PARAGUAY</option>
                                                                    <option value='604'>PERÚ</option>
                                                                    <option value='608'>FILIPINAS</option>
                                                                    <option value='612'>PITCAIRN</option>
                                                                    <option value='616'>POLONIA</option>
                                                                    <option value='620'>PORTUGAL</option>
                                                                    <option value='624'>GUINEA-BISSAU</option>
                                                                    <option value='626'>TIMOR ORIENTAL</option>
                                                                    <option value='630'>PUERTO RICO</option>
                                                                    <option value='634'>QATAR</option>
                                                                    <option value='638'>REUNIÓN</option>
                                                                    <option value='642'>RUMANÍA</option>
                                                                    <option value='643'>RUSIA</option>
                                                                    <option value='646'>RUANDA</option>
                                                                    <option value='654'>SAN HELENA</option>
                                                                    <option value='659'>SAN CRISTÓBAL Y NIEVES</option>
                                                                    <option value='660'>ANGUILLA</option>
                                                                    <option value='662'>SANTA LUCÍA</option>
                                                                    <option value='663'>SAN MARTÍN</option>
                                                                    <option value='670'>SAN VICENTE Y LAS GRANADINAS</option>
                                                                    <option value='672'>ISLAS SVALBARD Y JAN MAYEN</option>
                                                                    <option value='674'>SAN MARINO</option>
                                                                    <option value='678'>SANTO TOMÉ Y PRÍNCIPE</option>
                                                                    <option value='682'>ARABIA SAUDITA</option>
                                                                    <option value='686'>SENEGAL</option>
                                                                    <option value='688'>SERBIA</option>
                                                                    <option value='690'>SEYCHELLES</option>
                                                                    <option value='694'>SIERRA LEONA</option>
                                                                    <option value='702'>SINGAPUR</option>
                                                                    <option value='703'>ESLOVAQUIA</option>
                                                                    <option value='704'>VIETNAM</option>
                                                                    <option value='705'>ESLOVENIA</option>
                                                                    <option value='706'>SOMALIA</option>
                                                                    <option value='710'>SUDÁFRICA</option>
                                                                    <option value='716'>ZIMBABUE</option>
                                                                    <option value='724'>ESPAÑA</option>
                                                                    <option value='728'>SUDÁN DEL SUR</option>
                                                                    <option value='729'>SUDÁN</option>
                                                                    <option value='740'>SURINAM</option>
                                                                    <option value='748'>ESWATINI</option>
                                                                    <option value='752'>SUECIA</option>
                                                                    <option value='756'>SUIZA</option>
                                                                    <option value='760'>SIRIA</option>
                                                                    <option value='762'>TAYIKISTÁN</option>
                                                                    <option value='764'>TAILANDIA</option>
                                                                    <option value='768'>TOGO</option>
                                                                    <option value='772'>TOKELAU</option>
                                                                    <option value='776'>TONGA</option>
                                                                    <option value='780'>TRINIDAD Y TOBAGO</option>
                                                                    <option value='784'>EMIRATOS ÁRABES UNIDOS</option>
                                                                    <option value='788'>TÚNEZ</option>
                                                                    <option value='792'>TURQUÍA</option>
                                                                    <option value='795'>TURKMENISTÁN</option>
                                                                    <option value='796'>ISLAS TURCAS Y CAICOS</option>
                                                                    <option value='798'>TUVALU</option>
                                                                    <option value='800'>UGANDA</option>
                                                                    <option value='804'>UCRANIA</option>
                                                                    <option value='807'>MACEDONIA</option>
                                                                    <option value='818'>EGIPTO</option>
                                                                    <option value='826'>REINO UNIDO</option>
                                                                    <option value='834'>TANZANIA</option>
                                                                    <option value='840'>ESTADOS UNIDOS</option>
                                                                    <option value='850'>ISLAS VÍRGENES</option>
                                                                    <option value='854'>BURKINA FASO</option>
                                                                    <option value='858'>URUGUAY</option>
                                                                    <option value='860'>UZBEKISTÁN</option>
                                                                    <option value='862'>VENEZUELA</option>
                                                                    <option value='876'>WALLIS Y FUTUNA</option>
                                                                    <option value='882'>SAMOA</option>
                                                                    <option value='887'>YEMEN</option>
                                                                    <option value='894'>ZAMBIA</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'codMunicipioResidencia':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_codMunicipioResidenciaUS_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_codMunicipioResidenciaUS_{$numeroFactura}' name='codMunicipioResidenciaUS_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione municipio</option>
                                                            <option value='05001'>MEDELLÍN</option>
                                                                    <option value='05002'>ABEJORRAL</option>
                                                                    <option value='05004'>ABRIAQUÍ</option>
                                                                    <option value='05021'>ALEJANDRÍA</option>
                                                                    <option value='05030'>AMAGÁ</option>
                                                                    <option value='05031'>AMALFI</option>
                                                                    <option value='05034'>ANDES</option>
                                                                    <option value='05036'>ANGELÓPOLIS</option>
                                                                    <option value='05038'>ANGOSTURA</option>
                                                                    <option value='05040'>ANORÍ</option>
                                                                    <option value='05042'>SANTA FÉ DE ANTIOQUIA</option>
                                                                    <option value='05044'>ANZÁ</option>
                                                                    <option value='05045'>APARTADÓ</option>
                                                                    <option value='05051'>ARBOLETES</option>
                                                                    <option value='05055'>ARGELIA</option>
                                                                    <option value='05059'>ARMENIA</option>
                                                                    <option value='05079'>BARBOSA</option>
                                                                    <option value='05086'>BELMIRA</option>
                                                                    <option value='05088'>BELLO</option>
                                                                    <option value='05091'>BETANIA</option>
                                                                    <option value='05093'>BETULIA</option>
                                                                    <option value='05101'>CIUDAD BOLÍVAR</option>
                                                                    <option value='05107'>BRICEÑO</option>
                                                                    <option value='05113'>BURITICÁ</option>
                                                                    <option value='05120'>CÁCERES</option>
                                                                    <option value='05125'>CAICEDO</option>
                                                                    <option value='05129'>CALDAS</option>
                                                                    <option value='05134'>CAMPAMENTO</option>
                                                                    <option value='05138'>CAÑASGORDAS</option>
                                                                    <option value='05142'>CARACOLÍ</option>
                                                                    <option value='05145'>CARAMANTA</option>
                                                                    <option value='05147'>CAREPA</option>
                                                                    <option value='05148'>EL CARMEN DE VIBORAL</option>
                                                                    <option value='05150'>CAROLINA</option>
                                                                    <option value='05154'>CAUCASIA</option>
                                                                    <option value='05172'>CHIGORODÓ</option>
                                                                    <option value='05190'>CISNEROS</option>
                                                                    <option value='05197'>COCORNÁ</option>
                                                                    <option value='05206'>CONCEPCIÓN</option>
                                                                    <option value='05209'>CONCORDIA</option>
                                                                    <option value='05212'>COPACABANA</option>
                                                                    <option value='05234'>DABEIBA</option>
                                                                    <option value='05237'>DONMATÍAS</option>
                                                                    <option value='05240'>EBÉJICO</option>
                                                                    <option value='05250'>EL BAGRE</option>
                                                                    <option value='05264'>ENTRERRÍOS</option>
                                                                    <option value='05266'>ENVIGADO</option>
                                                                    <option value='05282'>FREDONIA</option>
                                                                    <option value='05284'>FRONTINO</option>
                                                                    <option value='05306'>GIRALDO</option>
                                                                    <option value='05308'>GIRARDOTA</option>
                                                                    <option value='05310'>GÓMEZ PLATA</option>
                                                                    <option value='05313'>GRANADA</option>
                                                                    <option value='05315'>GUADALUPE</option>
                                                                    <option value='05318'>GUARNE</option>
                                                                    <option value='05321'>GUATAPÉ</option>
                                                                    <option value='05347'>HELICONIA</option>
                                                                    <option value='05353'>HISPANIA</option>
                                                                    <option value='05360'>ITAGÜÍ</option>
                                                                    <option value='05361'>ITUANGO</option>
                                                                    <option value='05364'>JARDÍN</option>
                                                                    <option value='05368'>JERICÓ</option>
                                                                    <option value='05376'>LA CEJA</option>
                                                                    <option value='05380'>LA ESTRELLA</option>
                                                                    <option value='05390'>LA PINTADA</option>
                                                                    <option value='05400'>LA UNIÓN</option>
                                                                    <option value='05411'>LIBORINA</option>
                                                                    <option value='05425'>MACEO</option>
                                                                    <option value='05440'>MARINILLA</option>
                                                                    <option value='05467'>MONTEBELLO</option>
                                                                    <option value='05475'>MURINDÓ</option>
                                                                    <option value='05480'>MUTATÁ</option>
                                                                    <option value='05483'>NARIÑO</option>
                                                                    <option value='05490'>NECOCLÍ</option>
                                                                    <option value='05495'>NECHÍ</option>
                                                                    <option value='05501'>OLAYA</option>
                                                                    <option value='05541'>PEÑOL</option>
                                                                    <option value='05543'>PEQUE</option>
                                                                    <option value='05576'>PUEBLORRICO</option>
                                                                    <option value='05579'>PUERTO BERRÍO</option>
                                                                    <option value='05585'>PUERTO NARE</option>
                                                                    <option value='05591'>PUERTO TRIUNFO</option>
                                                                    <option value='05604'>REMEDIOS</option>
                                                                    <option value='05607'>RETIRO</option>
                                                                    <option value='05615'>RIONEGRO</option>
                                                                    <option value='05628'>SABANALARGA</option>
                                                                    <option value='05631'>SABANETA</option>
                                                                    <option value='05642'>SALGAR</option>
                                                                    <option value='05647'>SAN ANDRÉS DE CUERQUÍA</option>
                                                                    <option value='05649'>SAN CARLOS</option>
                                                                    <option value='05652'>SAN FRANCISCO</option>
                                                                    <option value='05656'>SAN JERÓNIMO</option>
                                                                    <option value='05658'>SAN JOSÉ DE LA MONTAÑA</option>
                                                                    <option value='05659'>SAN JUAN DE URABÁ</option>
                                                                    <option value='05660'>SAN LUIS</option>
                                                                    <option value='05664'>SAN PEDRO DE LOS MILAGROS</option>
                                                                    <option value='05665'>SAN PEDRO DE URABÁ</option>
                                                                    <option value='05667'>SAN RAFAEL</option>
                                                                    <option value='05670'>SAN ROQUE</option>
                                                                    <option value='05674'>SAN VICENTE FERRER</option>
                                                                    <option value='05679'>SANTA BÁRBARA</option>
                                                                    <option value='05686'>SANTA ROSA DE OSOS</option>
                                                                    <option value='05690'>SANTO DOMINGO</option>
                                                                    <option value='05697'>EL SANTUARIO</option>
                                                                    <option value='05736'>SEGOVIA</option>
                                                                    <option value='05756'>SONSÓN</option>
                                                                    <option value='05761'>SOPETRÁN</option>
                                                                    <option value='05789'>TÁMESIS</option>
                                                                    <option value='05790'>TARAZÁ</option>
                                                                    <option value='05792'>TARSO</option>
                                                                    <option value='05809'>TITIRIBÍ</option>
                                                                    <option value='05819'>TOLEDO</option>
                                                                    <option value='05837'>TURBO</option>
                                                                    <option value='05842'>URAMITA</option>
                                                                    <option value='05847'>URRAO</option>
                                                                    <option value='05854'>VALDIVIA</option>
                                                                    <option value='05856'>VALPARAÍSO</option>
                                                                    <option value='05858'>VEGACHÍ</option>
                                                                    <option value='05861'>VENECIA</option>
                                                                    <option value='05873'>VIGÍA DEL FUERTE</option>
                                                                    <option value='05885'>YALÍ</option>
                                                                    <option value='05887'>YARUMAL</option>
                                                                    <option value='05890'>YOLOMBÓ</option>
                                                                    <option value='05893'>YONDÓ</option>
                                                                    <option value='05895'>ZARAGOZA</option>
                                                                    <option value='08001'>BARRANQUILLA</option>
                                                                    <option value='08078'>BARANOA</option>
                                                                    <option value='08137'>CAMPO DE LA CRUZ</option>
                                                                    <option value='08141'>CANDELARIA</option>
                                                                    <option value='08296'>GALAPA</option>
                                                                    <option value='08372'>JUAN DE ACOSTA</option>
                                                                    <option value='08421'>LURUACO</option>
                                                                    <option value='08433'>MALAMBO</option>
                                                                    <option value='08436'>MANATÍ</option>
                                                                    <option value='08520'>PALMAR DE VARELA</option>
                                                                    <option value='08549'>PIOJÓ</option>
                                                                    <option value='08558'>POLONUEVO</option>
                                                                    <option value='08560'>PONEDERA</option>
                                                                    <option value='08573'>PUERTO COLOMBIA</option>
                                                                    <option value='08606'>REPELÓN</option>
                                                                    <option value='08634'>SABANAGRANDE</option>
                                                                    <option value='08638'>SABANALARGA</option>
                                                                    <option value='08675'>SANTA LUCÍA</option>
                                                                    <option value='08685'>SANTO TOMÁS</option>
                                                                    <option value='08758'>SOLEDAD</option>
                                                                    <option value='08770'>SUAN</option>
                                                                    <option value='08832'>TUBARÁ</option>
                                                                    <option value='08849'>USIACURÍ</option>
                                                                    <option value='11001'>BOGOTÁ, D.C.</option>
                                                                    <option value='13001'>CARTAGENA DE INDIAS</option>
                                                                    <option value='13006'>ACHÍ</option>
                                                                    <option value='13030'>ALTOS DEL ROSARIO</option>
                                                                    <option value='13042'>ARENAL</option>
                                                                    <option value='13052'>ARJONA</option>
                                                                    <option value='13062'>ARROYOHONDO</option>
                                                                    <option value='13074'>BARRANCO DE LOBA</option>
                                                                    <option value='13140'>CALAMAR</option>
                                                                    <option value='13160'>CANTAGALLO</option>
                                                                    <option value='13188'>CICUCO</option>
                                                                    <option value='13212'>CÓRDOBA</option>
                                                                    <option value='13222'>CLEMENCIA</option>
                                                                    <option value='13244'>EL CARMEN DE BOLÍVAR</option>
                                                                    <option value='13248'>EL GUAMO</option>
                                                                    <option value='13268'>EL PEÑÓN</option>
                                                                    <option value='13300'>HATILLO DE LOBA</option>
                                                                    <option value='13430'>MAGANGUÉ</option>
                                                                    <option value='13433'>MAHATES</option>
                                                                    <option value='13440'>MARGARITA</option>
                                                                    <option value='13442'>MARÍA LA BAJA</option>
                                                                    <option value='13458'>MONTECRISTO</option>
                                                                    <option value='13468'>MOMPÓS</option>
                                                                    <option value='13473'>MORALES</option>
                                                                    <option value='13490'>NOROSÍ</option>
                                                                    <option value='13549'>PINILLOS</option>
                                                                    <option value='13580'>REGIDOR</option>
                                                                    <option value='13600'>RÍO VIEJO</option>
                                                                    <option value='13620'>SAN CRISTÓBAL</option>
                                                                    <option value='13647'>SAN ESTANISLAO</option>
                                                                    <option value='13650'>SAN FERNANDO</option>
                                                                    <option value='13654'>SAN JACINTO</option>
                                                                    <option value='13655'>SAN JACINTO DEL CAUCA</option>
                                                                    <option value='13657'>SAN JUAN NEPOMUCENO</option>
                                                                    <option value='13667'>SAN MARTÍN DE LOBA</option>
                                                                    <option value='13670'>SAN PABLO</option>
                                                                    <option value='13673'>SANTA CATALINA</option>
                                                                    <option value='13683'>SANTA ROSA</option>
                                                                    <option value='13688'>SANTA ROSA DEL SUR</option>
                                                                    <option value='13744'>SIMITÍ</option>
                                                                    <option value='13760'>SOPLAVIENTO</option>
                                                                    <option value='13780'>TALAIGUA NUEVO</option>
                                                                    <option value='13810'>TIQUISIO</option>
                                                                    <option value='13836'>TURBACO</option>
                                                                    <option value='13838'>TURBANÁ</option>
                                                                    <option value='13873'>VILLANUEVA</option>
                                                                    <option value='13894'>ZAMBRANO</option>
                                                                    <option value='15001'>TUNJA</option>
                                                                    <option value='15022'>ALMEIDA</option>
                                                                    <option value='15047'>AQUITANIA</option>
                                                                    <option value='15051'>ARCABUCO</option>
                                                                    <option value='15087'>BELÉN</option>
                                                                    <option value='15090'>BERBEO</option>
                                                                    <option value='15092'>BETÉITIVA</option>
                                                                    <option value='15097'>BOAVITA</option>
                                                                    <option value='15104'>BOYACÁ</option>
                                                                    <option value='15106'>BRICEÑO</option>
                                                                    <option value='15109'>BUENAVISTA</option>
                                                                    <option value='15114'>BUSBANZÁ</option>
                                                                    <option value='15131'>CALDAS</option>
                                                                    <option value='15135'>CAMPOHERMOSO</option>
                                                                    <option value='15162'>CERINZA</option>
                                                                    <option value='15172'>CHINAVITA</option>
                                                                    <option value='15176'>CHIQUINQUIRÁ</option>
                                                                    <option value='15180'>CHISCAS</option>
                                                                    <option value='15183'>CHITA</option>
                                                                    <option value='15185'>CHITARAQUE</option>
                                                                    <option value='15187'>CHIVATÁ</option>
                                                                    <option value='15189'>CIÉNEGA</option>
                                                                    <option value='15204'>CÓMBITA</option>
                                                                    <option value='15212'>COPER</option>
                                                                    <option value='15215'>CORRALES</option>
                                                                    <option value='15218'>COVARACHÍA</option>
                                                                    <option value='15223'>CUBARÁ</option>
                                                                    <option value='15224'>CUCAITA</option>
                                                                    <option value='15226'>CUÍTIVA</option>
                                                                    <option value='15232'>CHÍQUIZA</option>
                                                                    <option value='15236'>CHIVOR</option>
                                                                    <option value='15238'>DUITAMA</option>
                                                                    <option value='15244'>EL COCUY</option>
                                                                    <option value='15248'>EL ESPINO</option>
                                                                    <option value='15272'>FIRAVITOBA</option>
                                                                    <option value='15276'>FLORESTA</option>
                                                                    <option value='15293'>GACHANTIVÁ</option>
                                                                    <option value='15296'>GÁMEZA</option>
                                                                    <option value='15299'>GARAGOA</option>
                                                                    <option value='15317'>GUACAMAYAS</option>
                                                                    <option value='15322'>GUATEQUE</option>
                                                                    <option value='15325'>GUAYATÁ</option>
                                                                    <option value='15332'>GÜICÁN DE LA SIERRA</option>
                                                                    <option value='15362'>IZA</option>
                                                                    <option value='15367'>JENESANO</option>
                                                                    <option value='15368'>JERICÓ</option>
                                                                    <option value='15377'>LABRANZAGRANDE</option>
                                                                    <option value='15380'>LA CAPILLA</option>
                                                                    <option value='15401'>LA VICTORIA</option>
                                                                    <option value='15403'>LA UVITA</option>
                                                                    <option value='15407'>VILLA DE LEYVA</option>
                                                                    <option value='15425'>MACANAL</option>
                                                                    <option value='15442'>MARIPÍ</option>
                                                                    <option value='15455'>MIRAFLORES</option>
                                                                    <option value='15464'>MONGUA</option>
                                                                    <option value='15466'>MONGUÍ</option>
                                                                    <option value='15469'>MONIQUIRÁ</option>
                                                                    <option value='15476'>MOTAVITA</option>
                                                                    <option value='15480'>MUZO</option>
                                                                    <option value='15491'>NOBSA</option>
                                                                    <option value='15494'>NUEVO COLÓN</option>
                                                                    <option value='15500'>OICATÁ</option>
                                                                    <option value='15507'>OTANCHE</option>
                                                                    <option value='15511'>PACHAVITA</option>
                                                                    <option value='15514'>PÁEZ</option>
                                                                    <option value='15516'>PAIPA</option>
                                                                    <option value='15518'>PAJARITO</option>
                                                                    <option value='15522'>PANQUEBA</option>
                                                                    <option value='15531'>PAUNA</option>
                                                                    <option value='15533'>PAYA</option>
                                                                    <option value='15537'>PAZ DE RÍO</option>
                                                                    <option value='15542'>PESCA</option>
                                                                    <option value='15550'>PISBA</option>
                                                                    <option value='15572'>PUERTO BOYACÁ</option>
                                                                    <option value='15580'>QUÍPAMA</option>
                                                                    <option value='15599'>RAMIRIQUÍ</option>
                                                                    <option value='15600'>RÁQUIRA</option>
                                                                    <option value='15621'>RONDÓN</option>
                                                                    <option value='15632'>SABOYÁ</option>
                                                                    <option value='15638'>SÁCHICA</option>
                                                                    <option value='15646'>SAMACÁ</option>
                                                                    <option value='15660'>SAN EDUARDO</option>
                                                                    <option value='15664'>SAN JOSÉ DE PARE</option>
                                                                    <option value='15667'>SAN LUIS DE GACENO</option>
                                                                    <option value='15673'>SAN MATEO</option>
                                                                    <option value='15676'>SAN MIGUEL DE SEMA</option>
                                                                    <option value='15681'>SAN PABLO DE BORBUR</option>
                                                                    <option value='15686'>SANTANA</option>
                                                                    <option value='15690'>SANTA MARÍA</option>
                                                                    <option value='15693'>SANTA ROSA DE VITERBO</option>
                                                                    <option value='15696'>SANTA SOFÍA</option>
                                                                    <option value='15720'>SATIVANORTE</option>
                                                                    <option value='15723'>SATIVASUR</option>
                                                                    <option value='15740'>SIACHOQUE</option>
                                                                    <option value='15753'>SOATÁ</option>
                                                                    <option value='15755'>SOCOTÁ</option>
                                                                    <option value='15757'>SOCHA</option>
                                                                    <option value='15759'>SOGAMOSO</option>
                                                                    <option value='15761'>SOMONDOCO</option>
                                                                    <option value='15762'>SORA</option>
                                                                    <option value='15763'>SOTAQUIRÁ</option>
                                                                    <option value='15764'>SORACÁ</option>
                                                                    <option value='15774'>SUSACÓN</option>
                                                                    <option value='15776'>SUTAMARCHÁN</option>
                                                                    <option value='15778'>SUTATENZA</option>
                                                                    <option value='15790'>TASCO</option>
                                                                    <option value='15798'>TENZA</option>
                                                                    <option value='15804'>TIBANÁ</option>
                                                                    <option value='15806'>TIBASOSA</option>
                                                                    <option value='15808'>TINJACÁ</option>
                                                                    <option value='15810'>TIPACOQUE</option>
                                                                    <option value='15814'>TOCA</option>
                                                                    <option value='15816'>TOGÜÍ</option>
                                                                    <option value='15820'>TÓPAGA</option>
                                                                    <option value='15822'>TOTA</option>
                                                                    <option value='15832'>TUNUNGUÁ</option>
                                                                    <option value='15835'>TURMEQUÉ</option>
                                                                    <option value='15837'>TUTA</option>
                                                                    <option value='15839'>TUTAZÁ</option>
                                                                    <option value='15842'>ÚMBITA</option>
                                                                    <option value='15861'>VENTAQUEMADA</option>
                                                                    <option value='15879'>VIRACACHÁ</option>
                                                                    <option value='15897'>ZETAQUIRA</option>
                                                                    <option value='17001'>MANIZALES</option>
                                                                    <option value='17013'>AGUADAS</option>
                                                                    <option value='17042'>ANSERMA</option>
                                                                    <option value='17050'>ARANZAZU</option>
                                                                    <option value='17088'>BELALCÁZAR</option>
                                                                    <option value='17174'>CHINCHINÁ</option>
                                                                    <option value='17272'>FILADELFIA</option>
                                                                    <option value='17380'>LA DORADA</option>
                                                                    <option value='17388'>LA MERCED</option>
                                                                    <option value='17433'>MANZANARES</option>
                                                                    <option value='17442'>MARMATO</option>
                                                                    <option value='17444'>MARQUETALIA</option>
                                                                    <option value='17446'>MARULANDA</option>
                                                                    <option value='17486'>NEIRA</option>
                                                                    <option value='17495'>NORCASIA</option>
                                                                    <option value='17513'>PÁCORA</option>
                                                                    <option value='17524'>PALESTINA</option>
                                                                    <option value='17541'>PENSILVANIA</option>
                                                                    <option value='17614'>RIOSUCIO</option>
                                                                    <option value='17616'>RISARALDA</option>
                                                                    <option value='17653'>SALAMINA</option>
                                                                    <option value='17662'>SAMANÁ</option>
                                                                    <option value='17665'>SAN JOSÉ</option>
                                                                    <option value='17777'>SUPÍA</option>
                                                                    <option value='17867'>VICTORIA</option>
                                                                    <option value='17873'>VILLAMARÍA</option>
                                                                    <option value='17877'>VITERBO</option>
                                                                    <option value='18001'>FLORENCIA</option>
                                                                    <option value='18029'>ALBANIA</option>
                                                                    <option value='18094'>BELÉN DE LOS ANDAQUÍES</option>
                                                                    <option value='18150'>CARTAGENA DEL CHAIRÁ</option>
                                                                    <option value='18205'>CURILLO</option>
                                                                    <option value='18247'>EL DONCELLO</option>
                                                                    <option value='18256'>EL PAUJÍL</option>
                                                                    <option value='18410'>LA MONTAÑITA</option>
                                                                    <option value='18460'>MILÁN</option>
                                                                    <option value='18479'>MORELIA</option>
                                                                    <option value='18592'>PUERTO RICO</option>
                                                                    <option value='18610'>SAN JOSÉ DEL FRAGUA</option>
                                                                    <option value='18753'>SAN VICENTE DEL CAGUÁN</option>
                                                                    <option value='18756'>SOLANO</option>
                                                                    <option value='18785'>SOLITA</option>
                                                                    <option value='18860'>VALPARAÍSO</option>
                                                                    <option value='19001'>POPAYÁN</option>
                                                                    <option value='19022'>ALMAGUER</option>
                                                                    <option value='19050'>ARGELIA</option>
                                                                    <option value='19075'>BALBOA</option>
                                                                    <option value='19100'>BOLÍVAR</option>
                                                                    <option value='19110'>BUENOS AIRES</option>
                                                                    <option value='19130'>CAJIBÍO</option>
                                                                    <option value='19137'>CALDONO</option>
                                                                    <option value='19142'>CALOTO</option>
                                                                    <option value='19212'>CORINTO</option>
                                                                    <option value='19256'>EL TAMBO</option>
                                                                    <option value='19290'>FLORENCIA</option>
                                                                    <option value='19300'>GUACHENÉ</option>
                                                                    <option value='19318'>GUAPÍ</option>
                                                                    <option value='19355'>INZÁ</option>
                                                                    <option value='19364'>JAMBALÓ</option>
                                                                    <option value='19392'>LA SIERRA</option>
                                                                    <option value='19397'>LA VEGA</option>
                                                                    <option value='19418'>LÓPEZ DE MICAY</option>
                                                                    <option value='19450'>MERCADERES</option>
                                                                    <option value='19455'>MIRANDA</option>
                                                                    <option value='19473'>MORALES</option>
                                                                    <option value='19513'>PADILLA</option>
                                                                    <option value='19517'>PÁEZ</option>
                                                                    <option value='19532'>PATÍA</option>
                                                                    <option value='19533'>PIAMONTE</option>
                                                                    <option value='19548'>PIENDAMÓ - TUNÍA</option>
                                                                    <option value='19573'>PUERTO TEJADA</option>
                                                                    <option value='19585'>PURACÉ</option>
                                                                    <option value='19622'>ROSAS</option>
                                                                    <option value='19693'>SAN SEBASTIÁN</option>
                                                                    <option value='19698'>SANTANDER DE QUILICHAO</option>
                                                                    <option value='19701'>SANTA ROSA</option>
                                                                    <option value='19743'>SILVIA</option>
                                                                    <option value='19760'>SOTARA</option>
                                                                    <option value='19780'>SUÁREZ</option>
                                                                    <option value='19785'>SUCRE</option>
                                                                    <option value='19807'>TIMBÍO</option>
                                                                    <option value='19809'>TIMBIQUÍ</option>
                                                                    <option value='19821'>TORIBÍO</option>
                                                                    <option value='19824'>TOTORÓ</option>
                                                                    <option value='19845'>VILLA RICA</option>
                                                                    <option value='20001'>VALLEDUPAR</option>
                                                                    <option value='20011'>AGUACHICA</option>
                                                                    <option value='20013'>AGUSTÍN CODAZZI</option>
                                                                    <option value='20032'>ASTREA</option>
                                                                    <option value='20045'>BECERRIL</option>
                                                                    <option value='20060'>BOSCONIA</option>
                                                                    <option value='20175'>CHIMICHAGUA</option>
                                                                    <option value='20178'>CHIRIGUANÁ</option>
                                                                    <option value='20228'>CURUMANÍ</option>
                                                                    <option value='20238'>EL COPEY</option>
                                                                    <option value='20250'>EL PASO</option>
                                                                    <option value='20295'>GAMARRA</option>
                                                                    <option value='20310'>GONZÁLEZ</option>
                                                                    <option value='20383'>LA GLORIA</option>
                                                                    <option value='20400'>LA JAGUA DE IBIRICO</option>
                                                                    <option value='20443'>MANAURE BALCÓN DEL CESAR</option>
                                                                    <option value='20517'>PAILITAS</option>
                                                                    <option value='20550'>PELAYA</option>
                                                                    <option value='20570'>PUEBLO BELLO</option>
                                                                    <option value='20614'>RÍO DE ORO</option>
                                                                    <option value='20621'>LA PAZ</option>
                                                                    <option value='20710'>SAN ALBERTO</option>
                                                                    <option value='20750'>SAN DIEGO</option>
                                                                    <option value='20770'>SAN MARTÍN</option>
                                                                    <option value='20787'>TAMALAMEQUE</option>
                                                                    <option value='23001'>MONTERÍA</option>
                                                                    <option value='23068'>AYAPEL</option>
                                                                    <option value='23079'>BUENAVISTA</option>
                                                                    <option value='23090'>CANALETE</option>
                                                                    <option value='23162'>CERETÉ</option>
                                                                    <option value='23168'>CHIMÁ</option>
                                                                    <option value='23182'>CHINÚ</option>
                                                                    <option value='23189'>CIÉNAGA DE ORO</option>
                                                                    <option value='23300'>COTORRA</option>
                                                                    <option value='23350'>LA APARTADA</option>
                                                                    <option value='23417'>LORICA</option>
                                                                    <option value='23419'>LOS CÓRDOBAS</option>
                                                                    <option value='23464'>MOMIL</option>
                                                                    <option value='23466'>MONTELÍBANO</option>
                                                                    <option value='23500'>MOÑITOS</option>
                                                                    <option value='23555'>PLANETA RICA</option>
                                                                    <option value='23570'>PUEBLO NUEVO</option>
                                                                    <option value='23574'>PUERTO ESCONDIDO</option>
                                                                    <option value='23580'>PUERTO LIBERTADOR</option>
                                                                    <option value='23586'>PURÍSIMA DE LA CONCEPCIÓN</option>
                                                                    <option value='23660'>SAHAGÚN</option>
                                                                    <option value='23670'>SAN ANDRÉS DE SOTAVENTO</option>
                                                                    <option value='23672'>SAN ANTERO</option>
                                                                    <option value='23675'>SAN BERNARDO DEL VIENTO</option>
                                                                    <option value='23678'>SAN CARLOS</option>
                                                                    <option value='23682'>SAN JOSÉ DE URÉ</option>
                                                                    <option value='23686'>SAN PELAYO</option>
                                                                    <option value='23807'>TIERRALTA</option>
                                                                    <option value='23815'>TUCHÍN</option>
                                                                    <option value='23855'>VALENCIA</option>
                                                                    <option value='25001'>AGUA DE DIOS</option>
                                                                    <option value='25019'>ALBÁN</option>
                                                                    <option value='25035'>ANAPOIMA</option>
                                                                    <option value='25040'>ANOLAIMA</option>
                                                                    <option value='25053'>ARBELÁEZ</option>
                                                                    <option value='25086'>BELTRÁN</option>
                                                                    <option value='25095'>BITUIMA</option>
                                                                    <option value='25099'>BOJACÁ</option>
                                                                    <option value='25120'>CABRERA</option>
                                                                    <option value='25123'>CACHIPAY</option>
                                                                    <option value='25126'>CAJICÁ</option>
                                                                    <option value='25148'>CAPARRAPÍ</option>
                                                                    <option value='25151'>CÁQUEZA</option>
                                                                    <option value='25154'>CARMEN DE CARUPA</option>
                                                                    <option value='25168'>CHAGUANÍ</option>
                                                                    <option value='25175'>CHÍA</option>
                                                                    <option value='25178'>CHIPAQUE</option>
                                                                    <option value='25181'>CHOACHÍ</option>
                                                                    <option value='25183'>CHOCONTÁ</option>
                                                                    <option value='25200'>COGUA</option>
                                                                    <option value='25214'>COTA</option>
                                                                    <option value='25224'>CUCUNUBÁ</option>
                                                                    <option value='25245'>EL COLEGIO</option>
                                                                    <option value='25258'>EL PEÑÓN</option>
                                                                    <option value='25260'>EL ROSAL</option>
                                                                    <option value='25269'>FACATATIVÁ</option>
                                                                    <option value='25279'>FÓMEQUE</option>
                                                                    <option value='25281'>FOSCA</option>
                                                                    <option value='25286'>FUNZA</option>
                                                                    <option value='25288'>FÚQUENE</option>
                                                                    <option value='25290'>FUSAGASUGÁ</option>
                                                                    <option value='25293'>GACHALÁ</option>
                                                                    <option value='25295'>GACHANCIPÁ</option>
                                                                    <option value='25297'>GACHETÁ</option>
                                                                    <option value='25299'>GAMA</option>
                                                                    <option value='25307'>GIRARDOT</option>
                                                                    <option value='25312'>GRANADA</option>
                                                                    <option value='25317'>GUACHETÁ</option>
                                                                    <option value='25320'>GUADUAS</option>
                                                                    <option value='25322'>GUASCA</option>
                                                                    <option value='25324'>GUATAQUÍ</option>
                                                                    <option value='25326'>GUATAVITA</option>
                                                                    <option value='25328'>GUAYABAL DE SÍQUIMA</option>
                                                                    <option value='25335'>GUAYABETAL</option>
                                                                    <option value='25339'>GUTIÉRREZ</option>
                                                                    <option value='25368'>JERUSALÉN</option>
                                                                    <option value='25372'>JUNÍN</option>
                                                                    <option value='25377'>LA CALERA</option>
                                                                    <option value='25386'>LA MESA</option>
                                                                    <option value='25394'>LA PALMA</option>
                                                                    <option value='25398'>LA PEÑA</option>
                                                                    <option value='25402'>LA VEGA</option>
                                                                    <option value='25407'>LENGUAZAQUE</option>
                                                                    <option value='25426'>MACHETÁ</option>
                                                                    <option value='25430'>MADRID</option>
                                                                    <option value='25436'>MANTA</option>
                                                                    <option value='25438'>MEDINA</option>
                                                                    <option value='25473'>MOSQUERA</option>
                                                                    <option value='25483'>NARIÑO</option>
                                                                    <option value='25486'>NEMOCÓN</option>
                                                                    <option value='25488'>NILO</option>
                                                                    <option value='25489'>NIMAIMA</option>
                                                                    <option value='25491'>NOCAIMA</option>
                                                                    <option value='25506'>VENECIA</option>
                                                                    <option value='25513'>PACHO</option>
                                                                    <option value='25518'>PAIME</option>
                                                                    <option value='25524'>PANDI</option>
                                                                    <option value='25530'>PARATEBUENO</option>
                                                                    <option value='25535'>PASCA</option>
                                                                    <option value='25572'>PUERTO SALGAR</option>
                                                                    <option value='25580'>PULÍ</option>
                                                                    <option value='25592'>QUEBRADANEGRA</option>
                                                                    <option value='25594'>QUETAME</option>
                                                                    <option value='25596'>QUIPILE</option>
                                                                    <option value='25599'>APULO</option>
                                                                    <option value='25612'>RICAURTE</option>
                                                                    <option value='25645'>SAN ANTONIO DEL TEQUENDAMA</option>
                                                                    <option value='25649'>SAN BERNARDO</option>
                                                                    <option value='25653'>SAN CAYETANO</option>
                                                                    <option value='25658'>SAN FRANCISCO</option>
                                                                    <option value='25662'>SAN JUAN DE RIOSECO</option>
                                                                    <option value='25718'>SASAIMA</option>
                                                                    <option value='25736'>SESQUILÉ</option>
                                                                    <option value='25740'>SIBATÉ</option>
                                                                    <option value='25743'>SILVANIA</option>
                                                                    <option value='25745'>SIMIJACA</option>
                                                                    <option value='25754'>SOACHA</option>
                                                                    <option value='25758'>SOPÓ</option>
                                                                    <option value='25769'>SUBACHOQUE</option>
                                                                    <option value='25772'>SUESCA</option>
                                                                    <option value='25777'>SUPATÁ</option>
                                                                    <option value='25779'>SUSA</option>
                                                                    <option value='25781'>SUTATAUSA</option>
                                                                    <option value='25785'>TABIO</option>
                                                                    <option value='25793'>TAUSA</option>
                                                                    <option value='25797'>TENA</option>
                                                                    <option value='25799'>TENJO</option>
                                                                    <option value='25805'>TIBACUY</option>
                                                                    <option value='25807'>TIBIRITA</option>
                                                                    <option value='25815'>TOCAIMA</option>
                                                                    <option value='25817'>TOCANCIPÁ</option>
                                                                    <option value='25823'>TOPAIPÍ</option>
                                                                    <option value='25839'>UBALÁ</option>
                                                                    <option value='25841'>UBAQUE</option>
                                                                    <option value='25843'>VILLA DE SAN DIEGO DE UBATÉ</option>
                                                                    <option value='25845'>UNE</option>
                                                                    <option value='25851'>ÚTICA</option>
                                                                    <option value='25862'>VERGARA</option>
                                                                    <option value='25867'>VIANÍ</option>
                                                                    <option value='25871'>VILLAGÓMEZ</option>
                                                                    <option value='25873'>VILLAPINZÓN</option>
                                                                    <option value='25875'>VILLETA</option>
                                                                    <option value='25878'>VIOTÁ</option>
                                                                    <option value='25885'>YACOPÍ</option>
                                                                    <option value='25898'>ZIPACÓN</option>
                                                                    <option value='25899'>ZIPAQUIRÁ</option>
                                                                    <option value='27001'>QUIBDÓ</option>
                                                                    <option value='27006'>ACANDÍ</option>
                                                                    <option value='27025'>ALTO BAUDÓ</option>
                                                                    <option value='27050'>ATRATO</option>
                                                                    <option value='27073'>BAGADÓ</option>
                                                                    <option value='27075'>BAHÍA SOLANO</option>
                                                                    <option value='27077'>BAJO BAUDÓ</option>
                                                                    <option value='27086'>Belén De Bajira</option>
                                                                    <option value='27099'>BOJAYÁ</option>
                                                                    <option value='27135'>EL CANTÓN DEL SAN PABLO</option>
                                                                    <option value='27150'>CARMEN DEL DARIÉN</option>
                                                                    <option value='27160'>CÉRTEGUI</option>
                                                                    <option value='27205'>CONDOTO</option>
                                                                    <option value='27245'>EL CARMEN DE ATRATO</option>
                                                                    <option value='27250'>EL LITORAL DEL SAN JUAN</option>
                                                                    <option value='27361'>ISTMINA</option>
                                                                    <option value='27372'>JURADÓ</option>
                                                                    <option value='27413'>LLORÓ</option>
                                                                    <option value='27425'>MEDIO ATRATO</option>
                                                                    <option value='27430'>MEDIO BAUDÓ</option>
                                                                    <option value='27450'>MEDIO SAN JUAN</option>
                                                                    <option value='27491'>NÓVITA</option>
                                                                    <option value='27495'>NUQUÍ</option>
                                                                    <option value='27580'>RÍO IRÓ</option>
                                                                    <option value='27600'>RÍO QUITO</option>
                                                                    <option value='27615'>RIOSUCIO</option>
                                                                    <option value='27660'>SAN JOSÉ DEL PALMAR</option>
                                                                    <option value='27745'>SIPÍ</option>
                                                                    <option value='27787'>TADÓ</option>
                                                                    <option value='27800'>UNGUÍA</option>
                                                                    <option value='27810'>UNIÓN PANAMERICANA</option>
                                                                    <option value='41001'>NEIVA</option>
                                                                    <option value='41006'>ACEVEDO</option>
                                                                    <option value='41013'>AGRADO</option>
                                                                    <option value='41016'>AIPE</option>
                                                                    <option value='41020'>ALGECIRAS</option>
                                                                    <option value='41026'>ALTAMIRA</option>
                                                                    <option value='41078'>BARAYA</option>
                                                                    <option value='41132'>CAMPOALEGRE</option>
                                                                    <option value='41206'>COLOMBIA</option>
                                                                    <option value='41244'>ELÍAS</option>
                                                                    <option value='41298'>GARZÓN</option>
                                                                    <option value='41306'>GIGANTE</option>
                                                                    <option value='41319'>GUADALUPE</option>
                                                                    <option value='41349'>HOBO</option>
                                                                    <option value='41357'>ÍQUIRA</option>
                                                                    <option value='41359'>ISNOS</option>
                                                                    <option value='41378'>LA ARGENTINA</option>
                                                                    <option value='41396'>LA PLATA</option>
                                                                    <option value='41483'>NÁTAGA</option>
                                                                    <option value='41503'>OPORAPA</option>
                                                                    <option value='41518'>PAICOL</option>
                                                                    <option value='41524'>PALERMO</option>
                                                                    <option value='41530'>PALESTINA</option>
                                                                    <option value='41548'>PITAL</option>
                                                                    <option value='41551'>PITALITO</option>
                                                                    <option value='41615'>RIVERA</option>
                                                                    <option value='41660'>SALADOBLANCO</option>
                                                                    <option value='41668'>SAN AGUSTÍN</option>
                                                                    <option value='41676'>SANTA MARÍA</option>
                                                                    <option value='41770'>SUAZA</option>
                                                                    <option value='41791'>TARQUI</option>
                                                                    <option value='41797'>TESALIA</option>
                                                                    <option value='41799'>TELLO</option>
                                                                    <option value='41801'>TERUEL</option>
                                                                    <option value='41807'>TIMANÁ</option>
                                                                    <option value='41872'>VILLAVIEJA</option>
                                                                    <option value='41885'>YAGUARÁ</option>
                                                                    <option value='44001'>RIOHACHA</option>
                                                                    <option value='44035'>ALBANIA</option>
                                                                    <option value='44078'>BARRANCAS</option>
                                                                    <option value='44090'>DIBULLA</option>
                                                                    <option value='44098'>DISTRACCIÓN</option>
                                                                    <option value='44110'>EL MOLINO</option>
                                                                    <option value='44279'>FONSECA</option>
                                                                    <option value='44378'>HATONUEVO</option>
                                                                    <option value='44420'>LA JAGUA DEL PILAR</option>
                                                                    <option value='44430'>MAICAO</option>
                                                                    <option value='44560'>MANAURE</option>
                                                                    <option value='44650'>SAN JUAN DEL CESAR</option>
                                                                    <option value='44847'>URIBIA</option>
                                                                    <option value='44855'>URUMITA</option>
                                                                    <option value='44874'>VILLANUEVA</option>
                                                                    <option value='47001'>SANTA MARTA</option>
                                                                    <option value='47030'>ALGARROBO</option>
                                                                    <option value='47053'>ARACATACA</option>
                                                                    <option value='47058'>ARIGUANÍ</option>
                                                                    <option value='47161'>CERRO DE SAN ANTONIO</option>
                                                                    <option value='47170'>CHIVOLO</option>
                                                                    <option value='47189'>CIÉNAGA</option>
                                                                    <option value='47205'>CONCORDIA</option>
                                                                    <option value='47245'>EL BANCO</option>
                                                                    <option value='47258'>EL PIÑÓN</option>
                                                                    <option value='47268'>EL RETÉN</option>
                                                                    <option value='47288'>FUNDACIÓN</option>
                                                                    <option value='47318'>GUAMAL</option>
                                                                    <option value='47460'>NUEVA GRANADA</option>
                                                                    <option value='47541'>PEDRAZA</option>
                                                                    <option value='47545'>PIJIÑO DEL CARMEN</option>
                                                                    <option value='47551'>PIVIJAY</option>
                                                                    <option value='47555'>PLATO</option>
                                                                    <option value='47570'>PUEBLOVIEJO</option>
                                                                    <option value='47605'>REMOLINO</option>
                                                                    <option value='47660'>SABANAS DE SAN ÁNGEL</option>
                                                                    <option value='47675'>SALAMINA</option>
                                                                    <option value='47692'>SAN SEBASTIÁN DE BUENAVISTA</option>
                                                                    <option value='47703'>SAN ZENÓN</option>
                                                                    <option value='47707'>SANTA ANA</option>
                                                                    <option value='47720'>SANTA BÁRBARA DE PINTO</option>
                                                                    <option value='47745'>SITIONUEVO</option>
                                                                    <option value='47798'>TENERIFE</option>
                                                                    <option value='47960'>ZAPAYÁN</option>
                                                                    <option value='47980'>ZONA BANANERA</option>
                                                                    <option value='50001'>VILLAVICENCIO</option>
                                                                    <option value='50006'>ACACÍAS</option>
                                                                    <option value='50110'>BARRANCA DE UPÍA</option>
                                                                    <option value='50124'>CABUYARO</option>
                                                                    <option value='50150'>CASTILLA LA NUEVA</option>
                                                                    <option value='50223'>CUBARRAL</option>
                                                                    <option value='50226'>CUMARAL</option>
                                                                    <option value='50245'>EL CALVARIO</option>
                                                                    <option value='50251'>EL CASTILLO</option>
                                                                    <option value='50270'>EL DORADO</option>
                                                                    <option value='50287'>FUENTE DE ORO</option>
                                                                    <option value='50313'>GRANADA</option>
                                                                    <option value='50318'>GUAMAL</option>
                                                                    <option value='50325'>MAPIRIPÁN</option>
                                                                    <option value='50330'>MESETAS</option>
                                                                    <option value='50350'>LA MACARENA</option>
                                                                    <option value='50370'>URIBE</option>
                                                                    <option value='50400'>LEJANÍAS</option>
                                                                    <option value='50450'>PUERTO CONCORDIA</option>
                                                                    <option value='50568'>PUERTO GAITÁN</option>
                                                                    <option value='50573'>PUERTO LÓPEZ</option>
                                                                    <option value='50577'>PUERTO LLERAS</option>
                                                                    <option value='50590'>PUERTO RICO</option>
                                                                    <option value='50606'>RESTREPO</option>
                                                                    <option value='50680'>SAN CARLOS DE GUAROA</option>
                                                                    <option value='50683'>SAN JUAN DE ARAMA</option>
                                                                    <option value='50686'>SAN JUANITO</option>
                                                                    <option value='50689'>SAN MARTÍN</option>
                                                                    <option value='50711'>VISTAHERMOSA</option>
                                                                    <option value='52001'>PASTO</option>
                                                                    <option value='52019'>ALBÁN</option>
                                                                    <option value='52022'>ALDANA</option>
                                                                    <option value='52036'>ANCUYÁ</option>
                                                                    <option value='52051'>ARBOLEDA</option>
                                                                    <option value='52079'>BARBACOAS</option>
                                                                    <option value='52083'>BELÉN</option>
                                                                    <option value='52110'>BUESACO</option>
                                                                    <option value='52203'>COLÓN</option>
                                                                    <option value='52207'>CONSACÁ</option>
                                                                    <option value='52210'>CONTADERO</option>
                                                                    <option value='52215'>CÓRDOBA</option>
                                                                    <option value='52224'>CUASPÚD</option>
                                                                    <option value='52227'>CUMBAL</option>
                                                                    <option value='52233'>CUMBITARA</option>
                                                                    <option value='52240'>CHACHAGÜÍ</option>
                                                                    <option value='52250'>EL CHARCO</option>
                                                                    <option value='52254'>EL PEÑOL</option>
                                                                    <option value='52256'>EL ROSARIO</option>
                                                                    <option value='52258'>EL TABLÓN DE GÓMEZ</option>
                                                                    <option value='52260'>EL TAMBO</option>
                                                                    <option value='52287'>FUNES</option>
                                                                    <option value='52317'>GUACHUCAL</option>
                                                                    <option value='52320'>GUAITARILLA</option>
                                                                    <option value='52323'>GUALMATÁN</option>
                                                                    <option value='52352'>ILES</option>
                                                                    <option value='52354'>IMUÉS</option>
                                                                    <option value='52356'>IPIALES</option>
                                                                    <option value='52378'>LA CRUZ</option>
                                                                    <option value='52381'>LA FLORIDA</option>
                                                                    <option value='52385'>LA LLANADA</option>
                                                                    <option value='52390'>LA TOLA</option>
                                                                    <option value='52399'>LA UNIÓN</option>
                                                                    <option value='52405'>LEIVA</option>
                                                                    <option value='52411'>LINARES</option>
                                                                    <option value='52418'>LOS ANDES</option>
                                                                    <option value='52427'>MAGÜÍ</option>
                                                                    <option value='52435'>MALLAMA</option>
                                                                    <option value='52473'>MOSQUERA</option>
                                                                    <option value='52480'>NARIÑO</option>
                                                                    <option value='52490'>OLAYA HERRERA</option>
                                                                    <option value='52506'>OSPINA</option>
                                                                    <option value='52520'>FRANCISCO PIZARRO</option>
                                                                    <option value='52540'>POLICARPA</option>
                                                                    <option value='52560'>POTOSÍ</option>
                                                                    <option value='52565'>PROVIDENCIA</option>
                                                                    <option value='52573'>PUERRES</option>
                                                                    <option value='52585'>PUPIALES</option>
                                                                    <option value='52612'>RICAURTE</option>
                                                                    <option value='52621'>ROBERTO PAYÁN</option>
                                                                    <option value='52678'>SAMANIEGO</option>
                                                                    <option value='52683'>SANDONÁ</option>
                                                                    <option value='52685'>SAN BERNARDO</option>
                                                                    <option value='52687'>SAN LORENZO</option>
                                                                    <option value='52693'>SAN PABLO</option>
                                                                    <option value='52694'>SAN PEDRO DE CARTAGO</option>
                                                                    <option value='52696'>SANTA BÁRBARA</option>
                                                                    <option value='52699'>SANTACRUZ</option>
                                                                    <option value='52720'>SAPUYES</option>
                                                                    <option value='52786'>TAMINANGO</option>
                                                                    <option value='52788'>TANGUA</option>
                                                                    <option value='52835'>SAN ANDRÉS DE TUMACO</option>
                                                                    <option value='52838'>TÚQUERRES</option>
                                                                    <option value='52885'>YACUANQUER</option>
                                                                    <option value='54001'>SAN JOSÉ DE CÚCUTA</option>
                                                                    <option value='54003'>ÁBREGO</option>
                                                                    <option value='54051'>ARBOLEDAS</option>
                                                                    <option value='54099'>BOCHALEMA</option>
                                                                    <option value='54109'>BUCARASICA</option>
                                                                    <option value='54125'>CÁCOTA</option>
                                                                    <option value='54128'>CÁCHIRA</option>
                                                                    <option value='54172'>CHINÁCOTA</option>
                                                                    <option value='54174'>CHITAGÁ</option>
                                                                    <option value='54206'>CONVENCIÓN</option>
                                                                    <option value='54223'>CUCUTILLA</option>
                                                                    <option value='54239'>DURANIA</option>
                                                                    <option value='54245'>EL CARMEN</option>
                                                                    <option value='54250'>EL TARRA</option>
                                                                    <option value='54261'>EL ZULIA</option>
                                                                    <option value='54313'>GRAMALOTE</option>
                                                                    <option value='54344'>HACARÍ</option>
                                                                    <option value='54347'>HERRÁN</option>
                                                                    <option value='54377'>LABATECA</option>
                                                                    <option value='54385'>LA ESPERANZA</option>
                                                                    <option value='54398'>LA PLAYA</option>
                                                                    <option value='54405'>LOS PATIOS</option>
                                                                    <option value='54418'>LOURDES</option>
                                                                    <option value='54480'>MUTISCUA</option>
                                                                    <option value='54498'>OCAÑA</option>
                                                                    <option value='54518'>PAMPLONA</option>
                                                                    <option value='54520'>PAMPLONITA</option>
                                                                    <option value='54553'>PUERTO SANTANDER</option>
                                                                    <option value='54599'>RAGONVALIA</option>
                                                                    <option value='54660'>SALAZAR</option>
                                                                    <option value='54670'>SAN CALIXTO</option>
                                                                    <option value='54673'>SAN CAYETANO</option>
                                                                    <option value='54680'>SANTIAGO</option>
                                                                    <option value='54720'>SARDINATA</option>
                                                                    <option value='54743'>SILOS</option>
                                                                    <option value='54800'>TEORAMA</option>
                                                                    <option value='54810'>TIBÚ</option>
                                                                    <option value='54820'>TOLEDO</option>
                                                                    <option value='54871'>VILLA CARO</option>
                                                                    <option value='54874'>VILLA DEL ROSARIO</option>
                                                                    <option value='63001'>ARMENIA</option>
                                                                    <option value='63111'>BUENAVISTA</option>
                                                                    <option value='63130'>CALARCÁ</option>
                                                                    <option value='63190'>CIRCASIA</option>
                                                                    <option value='63212'>CÓRDOBA</option>
                                                                    <option value='63272'>FILANDIA</option>
                                                                    <option value='63302'>GÉNOVA</option>
                                                                    <option value='63401'>LA TEBAIDA</option>
                                                                    <option value='63470'>MONTENEGRO</option>
                                                                    <option value='63548'>PIJAO</option>
                                                                    <option value='63594'>QUIMBAYA</option>
                                                                    <option value='63690'>SALENTO</option>
                                                                    <option value='66001'>PEREIRA</option>
                                                                    <option value='66045'>APÍA</option>
                                                                    <option value='66075'>BALBOA</option>
                                                                    <option value='66088'>BELÉN DE UMBRÍA</option>
                                                                    <option value='66170'>DOSQUEBRADAS</option>
                                                                    <option value='66318'>GUÁTICA</option>
                                                                    <option value='66383'>LA CELIA</option>
                                                                    <option value='66400'>LA VIRGINIA</option>
                                                                    <option value='66440'>MARSELLA</option>
                                                                    <option value='66456'>MISTRATÓ</option>
                                                                    <option value='66572'>PUEBLO RICO</option>
                                                                    <option value='66594'>QUINCHÍA</option>
                                                                    <option value='66682'>SANTA ROSA DE CABAL</option>
                                                                    <option value='66687'>SANTUARIO</option>
                                                                    <option value='68001'>BUCARAMANGA</option>
                                                                    <option value='68013'>AGUADA</option>
                                                                    <option value='68020'>ALBANIA</option>
                                                                    <option value='68051'>ARATOCA</option>
                                                                    <option value='68077'>BARBOSA</option>
                                                                    <option value='68079'>BARICHARA</option>
                                                                    <option value='68081'>BARRANCABERMEJA</option>
                                                                    <option value='68092'>BETULIA</option>
                                                                    <option value='68101'>BOLÍVAR</option>
                                                                    <option value='68121'>CABRERA</option>
                                                                    <option value='68132'>CALIFORNIA</option>
                                                                    <option value='68147'>CAPITANEJO</option>
                                                                    <option value='68152'>CARCASÍ</option>
                                                                    <option value='68160'>CEPITÁ</option>
                                                                    <option value='68162'>CERRITO</option>
                                                                    <option value='68167'>CHARALÁ</option>
                                                                    <option value='68169'>CHARTA</option>
                                                                    <option value='68176'>CHIMA</option>
                                                                    <option value='68179'>CHIPATÁ</option>
                                                                    <option value='68190'>CIMITARRA</option>
                                                                    <option value='68207'>CONCEPCIÓN</option>
                                                                    <option value='68209'>CONFINES</option>
                                                                    <option value='68211'>CONTRATACIÓN</option>
                                                                    <option value='68217'>COROMORO</option>
                                                                    <option value='68229'>CURITÍ</option>
                                                                    <option value='68235'>EL CARMEN DE CHUCURÍ</option>
                                                                    <option value='68245'>EL GUACAMAYO</option>
                                                                    <option value='68250'>EL PEÑÓN</option>
                                                                    <option value='68255'>EL PLAYÓN</option>
                                                                    <option value='68264'>ENCINO</option>
                                                                    <option value='68266'>ENCISO</option>
                                                                    <option value='68271'>FLORIÁN</option>
                                                                    <option value='68276'>FLORIDABLANCA</option>
                                                                    <option value='68296'>GALÁN</option>
                                                                    <option value='68298'>GÁMBITA</option>
                                                                    <option value='68307'>GIRÓN</option>
                                                                    <option value='68318'>GUACA</option>
                                                                    <option value='68320'>GUADALUPE</option>
                                                                    <option value='68322'>GUAPOTÁ</option>
                                                                    <option value='68324'>GUAVATÁ</option>
                                                                    <option value='68327'>GÜEPSA</option>
                                                                    <option value='68344'>HATO</option>
                                                                    <option value='68368'>JESÚS MARÍA</option>
                                                                    <option value='68370'>JORDÁN</option>
                                                                    <option value='68377'>LA BELLEZA</option>
                                                                    <option value='68385'>LANDÁZURI</option>
                                                                    <option value='68397'>LA PAZ</option>
                                                                    <option value='68406'>LEBRIJA</option>
                                                                    <option value='68418'>LOS SANTOS</option>
                                                                    <option value='68425'>MACARAVITA</option>
                                                                    <option value='68432'>MÁLAGA</option>
                                                                    <option value='68444'>MATANZA</option>
                                                                    <option value='68464'>MOGOTES</option>
                                                                    <option value='68468'>MOLAGAVITA</option>
                                                                    <option value='68498'>OCAMONTE</option>
                                                                    <option value='68500'>OIBA</option>
                                                                    <option value='68502'>ONZAGA</option>
                                                                    <option value='68522'>PALMAR</option>
                                                                    <option value='68524'>PALMAS DEL SOCORRO</option>
                                                                    <option value='68533'>PÁRAMO</option>
                                                                    <option value='68547'>PIEDECUESTA</option>
                                                                    <option value='68549'>PINCHOTE</option>
                                                                    <option value='68572'>PUENTE NACIONAL</option>
                                                                    <option value='68573'>PUERTO PARRA</option>
                                                                    <option value='68575'>PUERTO WILCHES</option>
                                                                    <option value='68615'>RIONEGRO</option>
                                                                    <option value='68655'>SABANA DE TORRES</option>
                                                                    <option value='68669'>SAN ANDRÉS</option>
                                                                    <option value='68673'>SAN BENITO</option>
                                                                    <option value='68679'>SAN GIL</option>
                                                                    <option value='68682'>SAN JOAQUÍN</option>
                                                                    <option value='68684'>SAN JOSÉ DE MIRANDA</option>
                                                                    <option value='68686'>SAN MIGUEL</option>
                                                                    <option value='68689'>SAN VICENTE DE CHUCURÍ</option>
                                                                    <option value='68705'>SANTA BÁRBARA</option>
                                                                    <option value='68720'>SANTA HELENA DEL OPÓN</option>
                                                                    <option value='68745'>SIMACOTA</option>
                                                                    <option value='68755'>SOCORRO</option>
                                                                    <option value='68770'>SUAITA</option>
                                                                    <option value='68773'>SUCRE</option>
                                                                    <option value='68780'>SURATÁ</option>
                                                                    <option value='68820'>TONA</option>
                                                                    <option value='68855'>VALLE DE SAN JOSÉ</option>
                                                                    <option value='68861'>VÉLEZ</option>
                                                                    <option value='68867'>VETAS</option>
                                                                    <option value='68872'>VILLANUEVA</option>
                                                                    <option value='68895'>ZAPATOCA</option>
                                                                    <option value='70001'>SINCELEJO</option>
                                                                    <option value='70110'>BUENAVISTA</option>
                                                                    <option value='70124'>CAIMITO</option>
                                                                    <option value='70204'>COLOSÓ</option>
                                                                    <option value='70215'>COROZAL</option>
                                                                    <option value='70221'>COVEÑAS</option>
                                                                    <option value='70230'>CHALÁN</option>
                                                                    <option value='70233'>EL ROBLE</option>
                                                                    <option value='70235'>GALERAS</option>
                                                                    <option value='70265'>GUARANDA</option>
                                                                    <option value='70400'>LA UNIÓN</option>
                                                                    <option value='70418'>LOS PALMITOS</option>
                                                                    <option value='70429'>MAJAGUAL</option>
                                                                    <option value='70473'>MORROA</option>
                                                                    <option value='70508'>OVEJAS</option>
                                                                    <option value='70523'>PALMITO</option>
                                                                    <option value='70670'>SAMPUÉS</option>
                                                                    <option value='70678'>SAN BENITO ABAD</option>
                                                                    <option value='70702'>SAN JUAN DE BETULIA</option>
                                                                    <option value='70708'>SAN MARCOS</option>
                                                                    <option value='70713'>SAN ONOFRE</option>
                                                                    <option value='70717'>SAN PEDRO</option>
                                                                    <option value='70742'>SAN LUIS DE SINCÉ</option>
                                                                    <option value='70771'>SUCRE</option>
                                                                    <option value='70820'>SANTIAGO DE TOLÚ</option>
                                                                    <option value='70823'>TOLÚ VIEJO</option>
                                                                    <option value='73001'>IBAGUÉ</option>
                                                                    <option value='73024'>ALPUJARRA</option>
                                                                    <option value='73026'>ALVARADO</option>
                                                                    <option value='73030'>AMBALEMA</option>
                                                                    <option value='73043'>ANZOÁTEGUI</option>
                                                                    <option value='73055'>ARMERO</option>
                                                                    <option value='73067'>ATACO</option>
                                                                    <option value='73124'>CAJAMARCA</option>
                                                                    <option value='73148'>CARMEN DE APICALÁ</option>
                                                                    <option value='73152'>CASABIANCA</option>
                                                                    <option value='73168'>CHAPARRAL</option>
                                                                    <option value='73200'>COELLO</option>
                                                                    <option value='73217'>COYAIMA</option>
                                                                    <option value='73226'>CUNDAY</option>
                                                                    <option value='73236'>DOLORES</option>
                                                                    <option value='73268'>ESPINAL</option>
                                                                    <option value='73270'>FALAN</option>
                                                                    <option value='73275'>FLANDES</option>
                                                                    <option value='73283'>FRESNO</option>
                                                                    <option value='73319'>GUAMO</option>
                                                                    <option value='73347'>HERVEO</option>
                                                                    <option value='73349'>HONDA</option>
                                                                    <option value='73352'>ICONONZO</option>
                                                                    <option value='73408'>LÉRIDA</option>
                                                                    <option value='73411'>LÍBANO</option>
                                                                    <option value='73443'>SAN SEBASTIÁN DE MARIQUITA</option>
                                                                    <option value='73449'>MELGAR</option>
                                                                    <option value='73461'>MURILLO</option>
                                                                    <option value='73483'>NATAGAIMA</option>
                                                                    <option value='73504'>ORTEGA</option>
                                                                    <option value='73520'>PALOCABILDO</option>
                                                                    <option value='73547'>PIEDRAS</option>
                                                                    <option value='73555'>PLANADAS</option>
                                                                    <option value='73563'>PRADO</option>
                                                                    <option value='73585'>PURIFICACIÓN</option>
                                                                    <option value='73616'>RIOBLANCO</option>
                                                                    <option value='73622'>RONCESVALLES</option>
                                                                    <option value='73624'>ROVIRA</option>
                                                                    <option value='73671'>SALDAÑA</option>
                                                                    <option value='73675'>SAN ANTONIO</option>
                                                                    <option value='73678'>SAN LUIS</option>
                                                                    <option value='73686'>SANTA ISABEL</option>
                                                                    <option value='73770'>SUÁREZ</option>
                                                                    <option value='73854'>VALLE DE SAN JUAN</option>
                                                                    <option value='73861'>VENADILLO</option>
                                                                    <option value='73870'>VILLAHERMOSA</option>
                                                                    <option value='73873'>VILLARRICA</option>
                                                                    <option value='76001'>CALI</option>
                                                                    <option value='76020'>ALCALÁ</option>
                                                                    <option value='76036'>ANDALUCÍA</option>
                                                                    <option value='76041'>ANSERMANUEVO</option>
                                                                    <option value='76054'>ARGELIA</option>
                                                                    <option value='76100'>BOLÍVAR</option>
                                                                    <option value='76109'>BUENAVENTURA</option>
                                                                    <option value='76111'>GUADALAJARA DE BUGA</option>
                                                                    <option value='76113'>BUGALAGRANDE</option>
                                                                    <option value='76122'>CAICEDONIA</option>
                                                                    <option value='76126'>CALIMA</option>
                                                                    <option value='76130'>CANDELARIA</option>
                                                                    <option value='76147'>CARTAGO</option>
                                                                    <option value='76233'>DAGUA</option>
                                                                    <option value='76243'>EL ÁGUILA</option>
                                                                    <option value='76246'>EL CAIRO</option>
                                                                    <option value='76248'>EL CERRITO</option>
                                                                    <option value='76250'>EL DOVIO</option>
                                                                    <option value='76275'>FLORIDA</option>
                                                                    <option value='76306'>GINEBRA</option>
                                                                    <option value='76318'>GUACARÍ</option>
                                                                    <option value='76364'>JAMUNDÍ</option>
                                                                    <option value='76377'>LA CUMBRE</option>
                                                                    <option value='76400'>LA UNIÓN</option>
                                                                    <option value='76403'>LA VICTORIA</option>
                                                                    <option value='76497'>OBANDO</option>
                                                                    <option value='76520'>PALMIRA</option>
                                                                    <option value='76563'>PRADERA</option>
                                                                    <option value='76606'>RESTREPO</option>
                                                                    <option value='76616'>RIOFRÍO</option>
                                                                    <option value='76622'>ROLDANILLO</option>
                                                                    <option value='76670'>SAN PEDRO</option>
                                                                    <option value='76736'>SEVILLA</option>
                                                                    <option value='76823'>TORO</option>
                                                                    <option value='76828'>TRUJILLO</option>
                                                                    <option value='76834'>TULUÁ</option>
                                                                    <option value='76845'>ULLOA</option>
                                                                    <option value='76863'>VERSALLES</option>
                                                                    <option value='76869'>VIJES</option>
                                                                    <option value='76890'>YOTOCO</option>
                                                                    <option value='76892'>YUMBO</option>
                                                                    <option value='76895'>ZARZAL</option>
                                                                    <option value='81001'>ARAUCA</option>
                                                                    <option value='81065'>ARAUQUITA</option>
                                                                    <option value='81220'>CRAVO NORTE</option>
                                                                    <option value='81300'>FORTUL</option>
                                                                    <option value='81591'>PUERTO RONDÓN</option>
                                                                    <option value='81736'>SARAVENA</option>
                                                                    <option value='81794'>TAME</option>
                                                                    <option value='85001'>YOPAL</option>
                                                                    <option value='85010'>AGUAZUL</option>
                                                                    <option value='85015'>CHÁMEZA</option>
                                                                    <option value='85125'>HATO COROZAL</option>
                                                                    <option value='85136'>LA SALINA</option>
                                                                    <option value='85139'>MANÍ</option>
                                                                    <option value='85162'>MONTERREY</option>
                                                                    <option value='85225'>NUNCHÍA</option>
                                                                    <option value='85230'>OROCUÉ</option>
                                                                    <option value='85250'>PAZ DE ARIPORO</option>
                                                                    <option value='85263'>PORE</option>
                                                                    <option value='85279'>RECETOR</option>
                                                                    <option value='85300'>SABANALARGA</option>
                                                                    <option value='85315'>SÁCAMA</option>
                                                                    <option value='85325'>SAN LUIS DE PALENQUE</option>
                                                                    <option value='85400'>TÁMARA</option>
                                                                    <option value='85410'>TAURAMENA</option>
                                                                    <option value='85430'>TRINIDAD</option>
                                                                    <option value='85440'>VILLANUEVA</option>
                                                                    <option value='86001'>MOCOA</option>
                                                                    <option value='86219'>COLÓN</option>
                                                                    <option value='86320'>ORITO</option>
                                                                    <option value='86568'>PUERTO ASÍS</option>
                                                                    <option value='86569'>PUERTO CAICEDO</option>
                                                                    <option value='86571'>PUERTO GUZMÁN</option>
                                                                    <option value='86573'>PUERTO LEGUÍZAMO</option>
                                                                    <option value='86749'>SIBUNDOY</option>
                                                                    <option value='86755'>SAN FRANCISCO</option>
                                                                    <option value='86757'>SAN MIGUEL</option>
                                                                    <option value='86760'>SANTIAGO</option>
                                                                    <option value='86865'>VALLE DEL GUAMUEZ</option>
                                                                    <option value='86885'>VILLAGARZÓN</option>
                                                                    <option value='88001'>SAN ANDRÉS</option>
                                                                    <option value='88564'>PROVIDENCIA</option>
                                                                    <option value='91001'>LETICIA</option>
                                                                    <option value='91263'>EL ENCANTO</option>
                                                                    <option value='91405'>LA CHORRERA</option>
                                                                    <option value='91407'>LA PEDRERA</option>
                                                                    <option value='91430'>LA VICTORIA</option>
                                                                    <option value='91460'>MIRITÍ - PARANÁ</option>
                                                                    <option value='91530'>PUERTO ALEGRÍA</option>
                                                                    <option value='91536'>PUERTO ARICA</option>
                                                                    <option value='91540'>PUERTO NARIÑO</option>
                                                                    <option value='91669'>PUERTO SANTANDER</option>
                                                                    <option value='91798'>TARAPACÁ</option>
                                                                    <option value='94001'>INÍRIDA</option>
                                                                    <option value='94343'>BARRANCO MINAS</option>
                                                                    <option value='94663'>MAPIRIPANA</option>
                                                                    <option value='94883'>SAN FELIPE</option>
                                                                    <option value='94884'>PUERTO COLOMBIA</option>
                                                                    <option value='94885'>LA GUADALUPE</option>
                                                                    <option value='94886'>CACAHUAL</option>
                                                                    <option value='94887'>PANA PANA</option>
                                                                    <option value='94888'>MORICHAL</option>
                                                                    <option value='95001'>SAN JOSÉ DEL GUAVIARE</option>
                                                                    <option value='95015'>CALAMAR</option>
                                                                    <option value='95025'>EL RETORNO</option>
                                                                    <option value='95200'>MIRAFLORES</option>
                                                                    <option value='97001'>MITÚ</option>
                                                                    <option value='97161'>CARURÚ</option>
                                                                    <option value='97511'>PACOA</option>
                                                                    <option value='97666'>TARAIRA</option>
                                                                    <option value='97777'>PAPUNAHUA</option>
                                                                    <option value='97889'>YAVARATÉ</option>
                                                                    <option value='99001'>PUERTO CARREÑO</option>
                                                                    <option value='99524'>LA PRIMAVERA</option>
                                                                    <option value='99624'>SANTA ROSALÍA</option>
                                                                    <option value='99773'>CUMARIBO</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'codZonaTerritorialResidencia':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_codZonaTerritorialResidenciaUS_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_codZonaTerritorialResidenciaUS_{$numeroFactura}' name='codZonaTerritorialResidenciaUS_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione zona territorial</option>
                                                            <option value='01'>Rural</option>
                                                            <option value='02'>Urbana</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'incapacidad':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_incapacidadUS_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_incapacidadUS_{$numeroFactura}' name='incapacidadUS_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione incapacidad</option>
                                                            <option value='SI'>SI</option>
                                                            <option value='NO'>NO</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'codPaisOrigen':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_codPaisOrigenUS_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_codPaisOrigenUS_{$numeroFactura}' name='codPaisOrigenUS_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione pais de origen</option>
                                                            <option value='004'>AFGANISTÁN</option>
                                                            <option value='008'>ALBANIA</option>
                                                            <option value='010'>ANTÁRTIDA</option>
                                                            <option value='012'>ARGELIA</option>
                                                            <option value='016'>SAMOA AMERICANA</option>
                                                             <option value='012'>ARGELIA</option>
                                                             <option value='020'>ANDORRA</option>
                                                             <option value='024'>ANGOLA</option>
                                                             <option value='028'>ANTIGUA Y BARBUDA</option>
                                                             <option value='031'>AZERBAIYÁN</option>
                                                             <option value='032'>ARGENTINA</option>
                                                             <option value='036'>AUSTRALIA</option>
                                                             <option value='040'>AUSTRIA</option>
                                                             <option value='044'>BAHAMAS</option>
                                                             <option value='048'>BARÉIN</option>
                                                             <option value='050'>BANGLADÉS</option>
                                                             <option value='051'>ARMENIA</option>
                                                             <option value='052'>BARBADOS</option>
                                                             <option value='056'>BÉLGICA</option>
                                                             <option value='060'>BERMUDA</option>
                                                             <option value='064'>BUTÁN</option>
                                                             <option value='068'>BOLIVIA</option>
                                                             <option value='070'>BOSNIA-HERZEGOVINA</option>
                                                             <option value='072'>BOTSUANA</option>
                                                             <option value='074'>ISLA BOUVET</option>
                                                             <option value='076'>BRAZIL</option>
                                                             <option value='084'>BELICE</option>
                                                             <option value='086'>TERRITORIO BRITÁNICO DEL OCÉANO ÍNDICO</option>
                                                             <option value='090'>ISLAS SOLOMON</option>
                                                             <option value='092'>ISLAS VÍRGENES BRITÁNICAS</option>
                                                             <option value='096'>BRUNÉI</option>
                                                             <option value='100'>BULGARIA</option>
                                                             <option value='104'>MYANMAR (FORMER BURMA)</option>
                                                             <option value='108'>BURUNDI</option>
                                                             <option value='112'>BIELORRUSIA</option>
                                                             <option value='116'>CAMBOYA</option>
                                                             <option value='120'>CAMERÚN</option>
                                                             <option value='124'>CANADÁ</option>
                                                             <option value='132'>CABO VERDE</option>
                                                             <option value='136'>ISLAS CAIMÁN</option>
                                                             <option value='140'>REPÚBLICA CENTROAFRICANA</option>
                                                             <option value='144'>SRI LANKA</option>
                                                             <option value='148'>CHAD</option>
                                                             <option value='152'>CHILE</option>
                                                             <option value='156'>CHINA</option>
                                                             <option value='158'>TAIWAN</option>
                                                             <option value='162'>ISLA DE NAVIDAD</option>
                                                             <option value='166'>ISLAS COCOS</option>
                                                             <option value='170'>COLOMBIA</option> 
                                                             <option value='174'>COMORAS</option>
                                                             <option value='175'>MAYOTTE</option>
                                                             <option value='178'>CONGO</option>
                                                             <option value='180'>REPÚBLICA DEMOCRÁTICA DEL CONGO</option>
                                                             <option value='184'>ISLAS COOK</option>
                                                             <option value='188'>COSTA RICA</option>
                                                             <option value='191'>CROACIA</option>
                                                             <option value='192'>CUBA</option>
                                                             <option value='196'>CHIPRE</option>
                                                             <option value='203'>REPÚBLICA CHECA</option>
                                                             <option value='204'>BENIN</option>
                                                             <option value='208'>DINAMARCA</option>
                                                             <option value='212'>DOMINICA</option>
                                                             <option value='214'>REPÚBLICA DOMINICANA</option>
                                                             <option value='218'>ECUADOR</option>
                                                             <option value='222'>EL SALVADOR</option>
                                                             <option value='226'>GUINEA ECUATORIAL</option>
                                                             <option value='231'>ETIOPIA</option>
                                                             <option value='232'>ERITREA</option>
                                                             <option value='233'>ESTONIA</option>
                                                             <option value='234'>ISLAS FEROE</option>
                                                             <option value='238'>ISLAS MALVINAS</option>
                                                             <option value='239'>ISLAS GEORGIAS DEL SUR Y SANDWICH DEL SUR</option>
                                                             <option value='242'>FIYI</option>
                                                             <option value='246'>FINLANDIA</option>
                                                             <option value='248'>ALAND</option>
                                                             <option value='250'>FRANCIA</option>
                                                             <option value='254'>GUAYANA FRANCESA</option>
                                                             <option value='258'>POLINESIA FRANCESA</option>
                                                             <option value='260'>TIERRAS AUSTRALES Y ANTÁRTICAS FRANCESAS</option>
                                                             <option value='262'>YIBUTI</option>
                                                             <option value='266'>GABON</option>
                                                             <option value='268'>GEORGIA</option>
                                                             <option value='275'>PALESTINA</option>
                                                             <option value='276'>ALEMANIA</option>
                                                             <option value='288'>GHANA</option>
                                                             <option value='292'>GIBRALTAR</option>
                                                             <option value='016'>SAMOA AMERICANA</option>
                                                             <option value='296'>KIRIBATI</option>
                                                             <option value='300'>GRECIA</option>
                                                             <option value='304'>GROENLANDIA</option>
                                                             <option value='308'>GRANADA</option>
                                                             <option value='312'>GUADALUOE</option>
                                                             <option value='316'>GUAM</option>
                                                             <option value='320'>GUATEMALA</option>
                                                             <option value='324'>GUINEA</option>
                                                             <option value='328'>GUYANA</option>
                                                             <option value='332'>HAITI</option>
                                                             <option value='334'>ISLA HEARD Y MCDONALD</option>
                                                             <option value='336'>SANTA SEDE</option>
                                                             <option value='340'>HONDURAS</option>
                                                             <option value='344'>HONG KONG</option>
                                                             <option value='348'>HUNGRÍA</option>
                                                             <option value='352'>ISLANDIA</option>
                                                             <option value='356'>INDIA</option>
                                                             <option value='360'>INDONESIA</option>
                                                             <option value='364'>IRÁN</option>
                                                             <option value='368'>IRAQ</option>
                                                             <option value='372'>IRLANDA</option>
                                                             <option value='376'>ISRAEL</option>
                                                             <option value='380'>ITALIA</option>
                                                             <option value='384'>COSTA DE MARFIL</option>
                                                             <option value='388'>JAMAICA</option>
                                                             <option value='392'>JAPÓN</option>
                                                             <option value='398'>KAZAJISTÁN</option>
                                                             <option value='400'>JORDANIA</option>
                                                             <option value='404'>KENYA</option>
                                                             <option value='408'>COREA DEL NORTE</option>
                                                             <option value='410'>COREA DEL SUR</option>
                                                             <option value='414'>KUWAIT</option>
                                                             <option value='417'>KIRGUISTÁN</option>
                                                             <option value='418'>LAOS</option>
                                                             <option value='422'>LÍBANO</option>
                                                             <option value='426'>LESOTO</option>
                                                             <option value='428'>LETONIA</option>
                                                             <option value='430'>LIBERIA</option>
                                                             <option value='434'>LIBIA</option>
                                                             <option value='438'>LIECHTENSTEIN</option>
                                                             <option value='446'>MACAO</option>
                                                             <option value='450'>MADAGASCAR</option>
                                                             <option value='454'>MALAUI</option>
                                                             <option value='458'>MALASIA</option>
                                                             <option value='462'>MALDIVAS</option>
                                                             <option value='466'>MALI</option>
                                                             <option value='474'>MARTINICA</option>
                                                             <option value='478'>MAURITANIA</option>
                                                             <option value='480'>MAURICIO</option>
                                                             <option value='484'>MÉXICO</option>
                                                             <option value='270'>GAMBIA</option>
                                                             <option value='492'>MÓNACO</option>
                                                             <option value='498'>MOLDAVIA</option>
                                                             <option value='499'>MONTENEGRO</option>
                                                             <option value='500'>MONTSERRAT</option>
                                                             <option value='504'>MARRUECOS</option>
                                                             <option value='508'>MOZAMBIQUE</option>
                                                             <option value='512'>OMÁN</option>
                                                             <option value='516'>NAMIBIA</option>
                                                             <option value='520'>NAURU</option>
                                                             <option value='524'>NEPAL</option>
                                                             <option value='528'>PAÍSES BAJOS</option>
                                                             <option value='540'>NUEVA CALEDONIA</option>
                                                             <option value='440'>LITUANIA</option>
                                                             <option value='442'>LUXEMBURGO</option>
                                                             <option value='548'>VANUATU</option>
                                                             <option value='554'>NUEVA ZELANDA</option>
                                                             <option value='496'>MONGOLIA</option>
                                                             <option value='562'>NÍGER</option>
                                                             <option value='566'>NIGERIA</option>
                                                             <option value='470'>MALTA</option>
                                                             <option value='570'>NIUE</option>
                                                             <option value='574'>ISLA NORFOLK</option>
                                                             <option value='578'>NORUEGA</option>
                                                             <option value='580'>ISLAS MARIANAS DEL NORTE</option>
                                                             <option value='581'>ISLAS MENORES ALEJADAS DE LOS ESTADOS UNIDOS</option>
                                                             <option value='583'>MICRONESIA</option>
                                                             <option value='584'>ISLAS MARSHALL</option>
                                                             <option value='585'>PALAU</option>
                                                             <option value='586'>PAKISTÁN</option>
                                                             <option value='591'>PANAMÁ</option>
                                                             <option value='598'>PAPÚA NUEVA GUINEA</option>
                                                             <option value='600'>PARAGUAY</option>
                                                             <option value='604'>PERÚ</option>
                                                             <option value='608'>FILIPINAS</option>
                                                             <option value='612'>PITCAIRN</option>
                                                             <option value='616'>POLONIA</option>
                                                             <option value='620'>PORTUGAL</option>
                                                             <option value='624'>GUINEA-BISSAU</option>
                                                             <option value='626'>TIMOR ORIENTAL</option>
                                                             <option value='630'>PUERTO RICO</option>
                                                             <option value='634'>QATAR</option>
                                                             <option value='638'>REUNIÓN</option>
                                                             <option value='642'>RUMANÍA</option>
                                                             <option value='643'>RUSIA</option>
                                                             <option value='646'>RUANDA</option>
                                                             <option value='654'>SAN HELENA</option>
                                                             <option value='659'>SAN CRISTÓBAL Y NIEVES</option>
                                                             <option value='660'>ANGUILLA</option>
                                                             <option value='662'>SANTA LUCÍA</option>
                                                             <option value='663'>SAN MARTÍN</option>
                                                             <option value='670'>SAN VICENTE Y LAS GRANADINAS</option>
                                                             <option value='672'>ISLAS SVALBARD Y JAN MAYEN</option>
                                                             <option value='674'>SAN MARINO</option>
                                                             <option value='678'>SANTO TOMÉ Y PRÍNCIPE</option>
                                                             <option value='682'>ARABIA SAUDITA</option>
                                                             <option value='686'>SENEGAL</option>
                                                             <option value='688'>SERBIA</option>
                                                             <option value='690'>SEYCHELLES</option>
                                                             <option value='694'>SIERRA LEONA</option>
                                                             <option value='702'>SINGAPUR</option>
                                                             <option value='704'>VIETNAM</option>
                                                             <option value='705'>ESLOVENIA</option>
                                                             <option value='706'>SOMALIA</option>
                                                             <option value='710'>SUDÁFRICA</option>
                                                             <option value='716'>ZIMBABUE</option>
                                                             <option value='724'>ESPAÑA</option>
                                                             <option value='728'>SUDÁN DEL SUR</option>
                                                             <option value='729'>SUDÁN</option>
                                                             <option value='740'>SURINAM</option>
                                                             <option value='748'>ESWATINI</option>
                                                             <option value='752'>SUECIA</option>
                                                             <option value='756'>SUIZA</option>
                                                             <option value='760'>SIRIA</option>
                                                             <option value='762'>TAYIKISTÁN</option>
                                                             <option value='764'>TAILANDIA</option>
                                                             <option value='768'>TOGO</option>
                                                             <option value='772'>TOKELAU</option>
                                                             <option value='558'>NICARAGUA</option>
                                                             <option value='776'>TONGA</option>
                                                             <option value='780'>TRINIDAD Y TOBAGO</option>
                                                             <option value='784'>EMIRATOS ÁRABES UNIDOS</option>
                                                             <option value='788'>TÚNEZ</option>
                                                             <option value='792'>TURQUÍA</option>
                                                             <option value='795'>TURKMENISTÁN</option>
                                                             <option value='796'>ISLAS TURCAS Y CAICOS</option>
                                                             <option value='798'>TUVALU</option>
                                                             <option value='800'>UGANDA</option>
                                                             <option value='804'>UCRANIA</option>
                                                             <option value='807'>MACEDONIA</option>
                                                             <option value='818'>EGIPTO</option>
                                                             <option value='826'>REINO UNIDO</option>
                                                             <option value='834'>TANZANIA</option>
                                                             <option value='840'>ESTADOS UNIDOS</option>
                                                             <option value='850'>ISLAS VÍRGENES</option>
                                                             <option value='854'>BURKINA FASO</option>
                                                             <option value='858'>URUGUAY</option>
                                                             <option value='860'>UZBEKISTÁN</option>
                                                             <option value='862'>VENEZUELA</option>
                                                             <option value='876'>WALLIS Y FUTUNA</option>
                                                             <option value='882'>SAMOA</option>
                                                             <option value='887'>YEMEN</option>
                                                             <option value='894'>ZAMBIA</option>               
                                                             <option value='703'>ESLOVAQUIA</option>
                                                             </select>
                                                             </div>
                                                             </td>";
                                        break;
                                    case 'consecutivo':
                                        echo "<td><input type='text' class='form-control' id='_consecutivoUS_{$numeroFactura}' name='consecutivoUS_{$numeroFactura}'></td>";
                                        break;
                                    default:
                                        echo "<td></td>";
                                        break;
                                }
                            }
                            echo "</form>";
                        } elseif ($nombreArchivo === 'AF.txt') {
                            echo "<script src='/json/js.js'></script>";
                            echo "<form id='formAF' method='POST'>";
                            foreach ($columnasAF as $index => $nombreColumna) {
                                switch ($nombreColumna) {
                                    case 'numDocumentoIdObligado':
                                        echo "<td><input type='text' class='form-control' id='_numDocumentoIdObligadoAF_{'$numeroFactura'}' name='numDocumentoIdObligadoAF_{$numeroFactura}' value='" . htmlspecialchars($fila[0]) . "'></td>";
                                        break;
                                    case 'numFactura':
                                        echo "<td><input type='text' class='form-control' id='_numFacturaAF_{$numeroFactura}' name='numFacturaAF_{$numeroFactura}' value='" . htmlspecialchars($fila[4]) . "'></td>";
                                        break;
                                    case 'tipoNota':
                                        echo "<td>
                                                    <div class='col-md-4'>
                                                        <label for='_tipoNotaAF_{$numeroFactura}'></label>
                                                        <select class='form-select form-select-lg' id='_tipoNotaAF_{$numeroFactura}' name='tipoNotaAF_{$numeroFactura}'>
                                                            <option value='' disabled selected>Seleccione tipo de nota</option>
                                                            <option value='NA'>Nota ajuste RIPS</option>
                                                            <option value='NC'>Nota crédito</option>
                                                            <option value='ND'>Nota débito</option>
                                                        </select>
                                                    </div>
                                                </td>";
                                        break;
                                    case 'numNota':
                                        echo "<td><input type='text' class='form-control' id='_numNotaAF_{$numeroFactura}' name='numNotaAF_{$numeroFactura}'></td>";
                                        break;
                                    default:
                                        echo "<td></td>"; // Si no coincide con ninguno, mostrar celda vacía
                                        break;
                                }
                            }
                            echo "<tr><td colspan='5'><button type='button' class='btn btn-primary' onclick='enviarFormularioAF(event, {$numeroFactura})'>Guardar</button></td></tr>";
                            echo "</form>";
                        } else {
                            foreach ($fila as $campo) {
                                echo "<td>" . htmlspecialchars($campo) . "</td>";
                            }
                        }
                        $contadorFactura++;
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo no valido',
                            text: 'Uno de los archivos no es un .txt valido.'
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
                        text: 'Ocurrio un error al intentar subir uno de los archivos.'
                    }).then(function() {
                        window.location.href = 'subir_archivo.php';
                    });
                </script>";
                exit;
            }
        }


        // Inicializar la respuesta
        $respuesta = [];

        //Asignar datos de los archivos a variables, seg�n el nombre del archivo
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

        // echo "\n" . '<pre> $acCampos:' . "\n";
        // print_r($acCampos);
        // echo "\n<br></pre>(" . date('Y-m-d h:i:s A') . ")<br>\n";

        $zip = new ZipArchive();
        $zipFileName = 'archivos_json.zip';

        // Abrir el archivo ZIP para escribir
        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            // Agrupar las l�neas por n�mero de factura para el archivo AC (consultas)
            if (!empty($acCampos)) {
                $facturasAc = [];
                foreach ($acCampos as $acFila) {
                    $numFactura = isset($acFila[0]) ? str_replace('-', '', $acFila[0]) : 'sin_factura';
                    $facturasAc[$numFactura][] = $acFila;
                }

                // Agrupar las l�neas por n�mero de factura para el archivo AP (procedimientos)
                $facturasAp = [];
                foreach ($apCampos as $apFila) {
                    $numFactura = isset($apFila[0]) ? str_replace('-', '', $apFila[0]) : 'sin_factura';
                    $facturasAp[$numFactura][] = $apFila;
                }

                // Generar archivos JSON para el archivo AC (consultas) agrupadas por n�mero de factura
                foreach ($facturasAc as $numFactura => $consultasFacturas) {
                    $consultas = [];
                    foreach ($consultasFacturas as $acIndex => $consulta) {
                        $consultas = [
                            [
                                'codPrestador' => isset($_POST['codPrestadorAC_{$numFactura}']) ? $_POST['codPrestadorAC_{$numFactura}'] : null,
                                'fechaInicioAtencion' => isset($_POST['fechaInicioAtencionAC_{$numFactura}']) ? $_POST['fechaInicioAtencionAC_{$numFactura}'] : null,
                                'numAutorizacion' => isset($_POST['numAutorizacionAC_{$numFactura}']) ? $_POST['numAutorizacionAC_{$numFactura}'] : null,
                                'codConsulta' => isset($_POST['codConsultaAC_{$numFactura}']) ? $_POST['codConsultaAC_{$numFactura}'] : null,
                                'modalidadGrupoServicioTecSal' => isset($_POST['modalidadGrupoServicioTecSalConsultas']) ? $_POST['modalidadGrupoServicioTecSalConsultas'] : null,
                                'grupoServicios' => isset($_POST['grupoServiciosConsultas']) ? $_POST['grupoServiciosConsultas'] : null,
                                'codServicio' => isset($_POST['codServicioConsultas']) ? $_POST['codServicioConsultas'] : null,
                                'finalidadTecnologiaSalud' => isset($_POST['finalidadTecnologiaSaludConsultas']) ? $_POST['finalidadTecnologiaSaludConsultas'] : null,
                                'causaMotivoAtencion' => isset($_POST['causaMotivoAtencionConsultas']) ? $_POST['causaMotivoAtencionConsultas'] : null,
                                'codDiagnosticoPrincipal' => isset($_POST['codDiagnosticoPrincipalConsultas']) ? $_POST['codDiagnosticoPrincipalConsultas'] : null,
                                'codDiagnosticoRelacionado1' => isset($_POST['codDiagnosticoRelacionado1']) ? $_POST['codDiagnosticoRelacionado1'] : null,
                                'codDiagnosticoRelacionado2' => isset($_POST['codDiagnosticoRelacionado2']) ? $_POST['codDiagnosticoRelacionado2'] : null,
                                'codDiagnosticoRelacionado3' => isset($_POST['codDiagnosticoRelacionado3']) ? $_POST['codDiagnosticoRelacionado3'] : null,
                                'tipoDiagnosticoPrincipal' => isset($_POST['tipoDiagnosticoPrincipalConsultas']) ? $_POST['tipoDiagnosticoPrincipalConsultas'] : null,
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

                    // Crear el JSON con los datos agrupados de las consultas
                    $jsonData = [
                        "numDocumentoIdObligado" => isset($afCampos[0][3]) ? $afCampos[0][3] : null, // nit
                        "numFactura" => $numFactura, // N�mero de factura Dian
                        "tipoNota" => null,
                        "numNota" => null,
                        "usuarios" => [
                            [
                                "tipoDocumentoIdentificacion" => isset($usCampos[0][0]) ? $usCampos[0][0] : null,
                                "numDocumentoIdentificacion" => isset($usCampos[0][1]) ? $usCampos[0][1] : null,
                                "tipoUsuario" => "01", // tabla RIPSTipoUsuarioVersion2
                                "fechaNacimiento" => isset($consultasFacturas[0][4]) ? DateTime::createFromFormat('d/m/Y', $consultasFacturas[0][4])->format('Y-m-d') : null,
                                "codSexo" => isset($usCampos[0][10]) ? $usCampos[0][10] : null, // campo 11 del us
                                "codPaisResidencia" => "169", // Colombia
                                "codMunicipioResidencia" => "76001", // Cali
                                "codZonaTerritorialResidencia" => "02", // Urbana
                                "incapacidad" => "NO",
                                "consecutivo" => 1,
                                "codPaisOrigen" => "169", // Colombia
                                "servicios" => [
                                    "consultas" => $consultas // M�ltiples consultas
                                ]
                            ]
                        ]
                    ];

                    // Generar el archivo JSON
                    $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    // Definir el nombre del archivo usando el n�mero de la factura
                    $nombreArchivo = $numFactura . '.json';

                    // Agregar el archivo JSON al ZIP
                    $zip->addFromString($nombreArchivo, $json);
                }
            }


            // Generar archivos JSON para el archivo AP (procedimientos)
            if (!empty($apCampos)) {
                $facturasAp = [];
                foreach ($apCampos as $apFila) {
                    $numFactura = isset($apFila[0]) ? str_replace('-', '', $apFila[0]) : 'sin_factura';
                    if (!isset($facturasAp[$numFactura])) {
                        $facturasAp[$numFactura] = [];
                    }
                    $facturasAp[$numFactura][] = $apFila;
                }

                // Generar archivos JSON para el archivo AP (procedimientos) agrupados por n�mero de factura
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
                            "numFactura" => $numFactura, // N�mero de factura Dian
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
                                        "procedimientos" => $procedimientos // M�ltiples procedimientos
                                    ]
                                ]
                            ]
                        ];

                        // Generar el archivo JSON
                        $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                        // Definir el nombre del archivo usando el n�mero de la factura
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
                        "numFactura" => $numFactura, // N�mero de factura Dian
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
                                    "urgencias" => $urgencias // M�ltiples urgencias
                                ]
                            ]
                        ]
                    ];

                    // Generar el archivo JSON
                    $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    // Definir el nombre del archivo usando el n�mero de la factura
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

            // Procesar cada grupo de hospitalizaci�n
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

                // Crear el JSON con los datos agrupados de hospitalizaci�n
                $jsonData = [
                    "numDocumentoIdObligado" => isset($afCampos[0][3]) ? $afCampos[0][3] : null, // nit
                    "numFactura" => $numFactura, // N�mero de factura Dian
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
                                "hospitalizacion" => $hospitalizaciones // M�ltiples hospitalizaciones
                            ]
                        ]
                    ]
                ];

                // Generar el archivo JSON
                $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                // Definir el nombre del archivo usando el n�mero de la factura
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

                // Procesar cada grupo de reci�n nacidos
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

                    // Crear el JSON con los datos agrupados de reci�n nacidos
                    $jsonData = [
                        "numDocumentoIdObligado" => isset($afCampos[0][3]) ? $afCampos[0][3] : null, // nit
                        "numFactura" => $numFactura, // N�mero de factura Dian
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
                                    "recienNacidos" => $recienNacidos // M�ltiples reci�n nacidos
                                ]
                            ]
                        ]
                    ];

                    // Generar el archivo JSON
                    $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    // Definir el nombre del archivo usando el n�mero de la factura
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
                        "numFactura" => $numFactura, // N�mero de factura Dian
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
                                    "medicamentos" => $medicamentos // M�ltiples medicamentos
                                ]
                            ]
                        ]
                    ];

                    // Generar el archivo JSON
                    $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    // Definir el nombre del archivo usando el n�mero de la factura
                    $nombreArchivo = $numFactura . '_am.json';

                    // Agregar el archivo JSON al ZIP
                    $zip->addFromString($nombreArchivo, $json);
                }
            }

            if (!empty($atCampos)) {
                $facturasAt = [];
                foreach ($atCampos as $atFila) {
                    $numFactura = isset($atFila[0]) ? str_replace('-', '', $atFila[0]) : 'sin_factura';
                    $facturasAt[$numFactura][] = $atFila;
                }

                // Generar archivos JSON para el archivo AT (otros servicios) agrupados por n�mero de factura
                foreach ($facturasAt as $numFactura => $otrosServiciosFacturas) {
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
                        "numFactura" => $numFactura, // N�mero de factura
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
                                    "otrosServicios" => $otrosServicios // M�ltiples otrosServicios
                                ]
                            ]
                        ]
                    ];

                    // Generar el archivo JSON
                    $json = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    // Definir el nombre del archivo usando el n�mero de la factura
                    $nombreArchivo = $numFactura . '_at.json';

                    // Agregar el archivo JSON al ZIP
                    $zip->addFromString($nombreArchivo, $json);
                }
            }

            // Cerrar el archivo ZIP
            $zip->close();

            // Mostrar el mensaje de �xito y enlace de descarga
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
            title: 'Solicitud no v�lida',
            text: 'M�todo de solicitud no v�lido.'
        }).then(function() {
            window.location.href = 'subir_archivo.php';
        });
    </script>";
}

?>
<!-- Boton "Volver" -->
<div style="text-align: center; margin-top: 20px;">
    <a href="http://localhost/json/html">
        <button style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Volver
        </button>
    </a>
</div>