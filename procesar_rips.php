<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['archivos_txt'])) {
    $archivos = $_FILES['archivos_txt']['tmp_name'];
    $nombresArchivos = $_FILES['archivos_txt']['name'];

    $informacionArchivos = []; // Para almacenar información de cada archivo

    for ($i = 0; $i < count($archivos); $i++) {
        $nombreArchivo = $nombresArchivos[$i];
        $contenidoArchivo = file_get_contents($archivos[$i]); // Leer el contenido del archivo

        // Almacena el contenido usando el nombre del archivo como clave
        $informacionArchivos[$nombreArchivo] = $contenidoArchivo;
    }

    // Imprimir la información recibida
    // echo "\n" . '<pre> $informacionArchivos/*:' . "\n";
    // print_r($informacionArchivos);
    // echo "\n<br></pre>(" . date('Y-m-d h:i:s A') . ")<br>\n"; 

    $tablas = [];

    // Definir las columnas personalizadas para cada archivo
    $configColumnas = [
        'AC.txt' => [
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
        ],

        'AF.txt' => [
            'numDocumentoIdObligado',
            'numFactura',
            'tipoNota',
            'numNota'
        ],

        'US.txt' => [
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
        ],

        'AP.txt' => [
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
        ],


    ];

    // Procesar cada archivo
    foreach ($archivos as $key => $archivo) {
        $nombreArchivo = $nombresArchivos[$key];
        $contenido = file($archivo); // Leer el archivo como un array de líneas
        $filas = [];

        // Procesar el contenido del archivo
        foreach ($contenido as $linea) {
            $columnas = explode(',', trim($linea)); // Separar por comas
            $filas[] = $columnas; // Agregar todas las columnas
        }
        $tablas[$nombreArchivo] = $filas;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar RIPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container mt-5">
        <h1>Resultados de la Conversión</h1>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <?php foreach ($tablas as $nombreArchivo => $filas): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $nombreArchivo == array_key_first($tablas) ? 'active' : ''; ?>" id="tab-<?php echo $nombreArchivo; ?>" data-bs-toggle="tab" data-bs-target="#<?php echo $nombreArchivo; ?>" type="button" role="tab" aria-controls="<?php echo $nombreArchivo; ?>" aria-selected="true">
                        <?php echo strtoupper($nombreArchivo); ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- Tab panes con formularios separados -->
        <div class="tab-content mt-4">
            <?php foreach ($tablas as $nombreArchivo => $filas): ?>
                <div class="tab-pane fade <?php echo $nombreArchivo == array_key_first($tablas) ? 'show active' : ''; ?>" id="<?php echo $nombreArchivo; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $nombreArchivo; ?>">
                    <h3>Archivo: <?php echo strtoupper($nombreArchivo); ?></h3>
                    <form data-formulario="<?php echo $nombreArchivo; ?>">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <?php foreach ($configColumnas[$nombreArchivo] as $columna): ?>
                                        <th><?php echo $columna; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($filas as $i => $fila): ?>
                                    <tr>
                                        <!-- Personalización de cada campo según el archivo -->
                                        <?php if ($nombreArchivo === 'AC.txt'): ?>

                                            <input type="hidden" name="AC" id="AC" value="<?php echo htmlspecialchars($fila[0]); ?>" class="form-control">
                                            <input type="hidden" name="<?php echo $fila[0]; ?>_tipoDoc_" id="<?php echo $fila[0]; ?>_tipoDoc_" value="<?php echo htmlspecialchars($fila[2]); ?>" class="form-control">
                                            <input type="hidden" name="<?php echo $fila[0]; ?>_Doc_" id="<?php echo $fila[0]; ?>_Doc_" value="<?php echo htmlspecialchars($fila[3]); ?>" class="form-control">
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_numeroFacturaAC_" id="<?php echo $fila[0]; ?>_numeroFacturaAC_" value="<?php echo htmlspecialchars($fila[0]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_codPrestador_" id="<?php echo $fila[0]; ?>_codPrestador_" value="<?php echo htmlspecialchars($fila[1]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_fechaInicioAtencion_" id="<?php echo $fila[0]; ?>_fechaInicioAtencion_" value="<?php echo htmlspecialchars($fila[4]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_numAutorizacion_" id="<?php echo $fila[0]; ?>_numAutorizacion_" value="<?php echo htmlspecialchars($fila[5]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_codConsulta_" id="<?php echo $fila[0]; ?>_codConsulta_" value="<?php echo htmlspecialchars($fila[6]); ?>" class="form-control">
                                            </td>
                                        <?php elseif ($nombreArchivo === 'AF.txt'): ?>

                                            <input type="hidden" name="AF" id="AF" value="<?php echo htmlspecialchars($fila[4]); ?>" class="form-control">
                                            <td>
                                                <input type="text" name="<?php echo $fila[4]; ?>_numDocumentoIdObligado_" id="<?php echo $fila[4]; ?>_numDocumentoIdObligado_" value="<?php echo htmlspecialchars($fila[0]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[4]; ?>_numFactura_" id="<?php echo $fila[4]; ?>_numFactura_" value="<?php echo htmlspecialchars($fila[4]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <div class='col-md-4'>
                                                    <label for="<?php echo $fila[4]; ?>_tipoNota_"></label>
                                                    <select name="<?php echo $fila[4]; ?>_tipoNota_" id="<?php echo $fila[4]; ?>_tipoNota_" class="form-control" style="width: 300px;">
                                                        <option value='' disabled selected>Seleccione tipo de nota</option>
                                                        <option value='NA'>Nota ajuste RIPS</option>
                                                        <option value='NC'>Nota crédito</option>
                                                        <option value='ND'>Nota débito</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[4]; ?>_numNota_" id="<?php echo $fila[4]; ?>_numNota_" class="form-control">
                                            </td>
                                        <?php elseif ($nombreArchivo === 'US.txt'): ?>

                                            <input type="hidden" name="US" id="US" value="<?php echo htmlspecialchars($fila[1]); ?>" class="form-control">
                                            <td>
                                                <input type="text" name="<?php echo $fila[1]; ?>_tipoDocumentoIdentificacion" id="<?php echo $fila[1]; ?>_tipoDocumentoIdentificacion" value="<?php echo htmlspecialchars($fila[0]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[1]; ?>_numDocumentoIdentificacion" id="<?php echo $fila[1]; ?>_numDocumentoIdentificacion" value="<?php echo htmlspecialchars($fila[1]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[1]; ?>_numDocumentoIdObligado" id="<?php echo $fila[1]; ?>_numDocumentoIdObligado" class="form-control">
                                            </td>

                                            
                                        <?php elseif ($nombreArchivo === 'AP.txt'): ?>

                                            <input type="hidden" name="AP" id="AP" value="<?php echo htmlspecialchars($fila[0]); ?>" class="form-control">
                                            <input type="hidden" name="<?php echo $fila[0]; ?>_tipoDoc_" id="<?php echo $fila[0]; ?>_tipoDoc_" value="<?php echo htmlspecialchars($fila[2]); ?>" class="form-control">
                                            <input type="hidden" name="<?php echo $fila[0]; ?>_Doc_" id="<?php echo $fila[0]; ?>_Doc_" value="<?php echo htmlspecialchars($fila[3]); ?>" class="form-control">
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_numeroFacturaAP" id="<?php echo $fila[0]; ?>_numeroFacturaAP" value="<?php echo htmlspecialchars($fila[0]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_codPrestadorAP" id="<?php echo $fila[0]; ?>_codPrestadorAP" value="<?php echo htmlspecialchars($fila[1]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_fechaInicioAtencionAP" id="<?php echo $fila[0]; ?>_fechaInicioAtencionAP" value="<?php echo htmlspecialchars($fila[4]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_idMIPRESAP" id="<?php echo $fila[0]; ?>_idMIPRESAP" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_numAutorizacionAP" id="<?php echo $fila[0]; ?>_numAutorizacionAP" value="<?php echo htmlspecialchars($fila[5]); ?>" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="<?php echo $fila[0]; ?>_codProcedimientoAP" id="<?php echo $fila[0]; ?>_codProcedimientoAP" value="<?php echo htmlspecialchars($fila[5]); ?>" class="form-control">
                                            </td>















                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Botón de envío específico para cada formulario -->
                        <button type="button" class="btn btn-primary" onclick="enviarFormulario('<?php echo $nombreArchivo; ?>')">Enviar <?php echo strtoupper($nombreArchivo); ?></button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function enviarFormulario(nombreArchivo) {
            const formulario = document.querySelector(`form[data-formulario="${nombreArchivo}"]`);
            const formData = new FormData(formulario);

            // formData.forEach((value, key) => {
            //     console.log(`${key}: ${value}`);
            // });

            fetch('descargar_rips.php', {
                method: 'POST',
                body: formData
            })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
            //         alert(`Formulario ${nombreArchivo} guardado exitosamente.`);
            //     } else {
            //         alert(`Error al guardar el formulario ${nombreArchivo}.`);
            //     }
            // })
        }
    </script>
</body>

</html>