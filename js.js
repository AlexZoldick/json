document.addEventListener("DOMContentLoaded", function () {
    const enviarDatosBtn = document.getElementById('enviarDatos');

    if (enviarDatosBtn) {
        enviarDatosBtn.addEventListener('click', function (event) {
            event.preventDefault(); // Prevenir el comportamiento por defecto del botón

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
    } else {
        console.error("El botón de enviar no se encontró en el DOM.");
    }
});
