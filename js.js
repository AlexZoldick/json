document.addEventListener("DOMContentLoaded", function () {
    const enviarDatosBtn = document.getElementById('enviarDatos');
    const alertaValidacion = document.getElementById('alerta-validacion'); // Alerta de validación

    if (enviarDatosBtn) {
        enviarDatosBtn.addEventListener('click', function (event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del botón

            // bloque de validaciones del usuario
            const tipoDocumentoIdentificacionUsuario = document.getElementById('tipoDocumentoIdentificacionUsuario');
            const numDocumentoIdentificacionUsuario = document.getElementById('numDocumentoIdentificacionUsuario');
            const tipoUsuario = document.getElementById('tipoUsuario');
            const fechaNacimientoUsuario = document.getElementById('fechaNacimientoUsuario');
            const codSexoUsuario = document.getElementById('codSexoUsuario');
            const codPaisResidencia = document.getElementById('codPaisResidencia');
            const codMunicipioResidenciaUsuarios = document.getElementById('codMunicipioResidenciaUsuarios');
            const consecutivoUsuarios = document.getElementById('consecutivoUsuarios');

            // Validar si el campo existe y si tiene un valor
            if (!tipoDocumentoIdentificacionUsuario || tipoDocumentoIdentificacionUsuario.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor seleccione el tipo de documento de identificación.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                tipoDocumentoIdentificacionUsuario.focus(); // Hacer foco en el campo
                return;
            }

            // Validar el número de documento de identificación
            if (!numDocumentoIdentificacionUsuario || numDocumentoIdentificacionUsuario.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor complete el número de documento de identificación.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                numDocumentoIdentificacionUsuario.focus(); // Hacer foco en el campo
                return;
            }

            // Validar el número tipoUsuario
            if (!tipoUsuario || tipoUsuario.value.trim() === "") {
                alertaValidacion.textContent = 'Por seleccione el tipo de usuario.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                tipoUsuario.focus(); // Hacer foco en el campo
                return;
            }

            if (!fechaNacimientoUsuario || fechaNacimientoUsuario.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor seleccione la fecha de nacimiento.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                fechaNacimientoUsuario.focus(); // Hacer foco en el campo
                return;
            }

            if (!codSexoUsuario || codSexoUsuario.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor seleccione tipo de sexo.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                codSexoUsuario.focus(); // Hacer foco en el campo
                return;
            }

            if (!codPaisResidencia || codPaisResidencia.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor seleccione pais de residencia.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                codPaisResidencia.focus(); // Hacer foco en el campo
                return;
            }

            if (!codMunicipioResidenciaUsuarios || codMunicipioResidenciaUsuarios.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor seleccione municipio de residencia.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                codMunicipioResidenciaUsuarios.focus(); // Hacer foco en el campo
                return;
            }

            if (!codZonaTerritorialResidencia || codZonaTerritorialResidencia.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor seleccione zona territorial.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                codZonaTerritorialResidencia.focus(); // Hacer foco en el campo
                return;
            }

            if (!incapacidad || incapacidad.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor seleccione incapacidad.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                incapacidad.focus(); // Hacer foco en el campo
                return;
            }

            if (!codPaisOrigen || codPaisOrigen.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor seleccione pais de origen.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                codPaisOrigen.focus(); // Hacer foco en el campo
                return;
            }

            if (!consecutivoUsuarios || consecutivoUsuarios.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor ingrese consecutivo.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                consecutivoUsuarios.focus(); // Hacer foco en el campo
                return;
            }

            // bloque de validaciones de transacciones
            const num_DocumentoIdObligado = document.getElementById('num_DocumentoIdObligado');
            const codPrestador = document.getElementById('codPrestador');
            const numFactura = document.getElementById('numFactura');

            if (!num_DocumentoIdObligado || num_DocumentoIdObligado.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor ingrese Nit (Pestaña Datos Transaccion).';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                num_DocumentoIdObligado.focus(); // Hacer foco en el campo
                return;
            }

            if (!codPrestador || codPrestador.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor ingrese codigo del prestador.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                codPrestador.focus(); // Hacer foco en el campo
                return;
            }

            if (!numFactura || numFactura.value.trim() === "") {
                alertaValidacion.textContent = 'Por favor ingrese numero de factura.';
                alertaValidacion.classList.remove('d-none'); // Mostrar alerta
                alertaValidacion.classList.add('show'); // Asegurarse que la alerta se vea
                numFactura.focus(); // Hacer foco en el campo
                return;
            }

            alertaValidacion.classList.add('d-none');

            // Crear un objeto FormData para almacenar los datos
            const formData = new FormData();

            const formularios = [
                'datosUsuarioForm',
                'datosTransaccionForm',
                'datosConsultasForm',
                'datosUrgenciasForm',
                'datosProcedimientosForm',
                'datosHospitalizacionForm',
                'datosRecienNacidosForm',
                'datosMedicamentosForm',
                'datosOtrosServiciosForm'
            ];

            formularios.forEach(formId => {
                const form = document.getElementById(formId);
                if (form) {
                    const formDataInstance = new FormData(form);
                    formDataInstance.forEach((value, key) => {
                        if (value) { // Solo añadir si el valor no está vacío
                            formData.append(key, value);
                        }
                    });
                }
            });

            // Enviar los datos al servidor y manejar la respuesta como un archivo (ZIP)
            fetch('procesar_archivos_formulario.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.blob(); // Procesar la respuesta como un Blob (para archivos binarios)
                })
                .then(blob => {
                    // Crear una URL para el blob y forzar la descarga
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = 'archivos_json.zip';  // Nombre del archivo descargado
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Error al descargar el archivo:', error);
                });
        });
    }
});
