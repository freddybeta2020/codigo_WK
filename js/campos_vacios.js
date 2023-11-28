

if (!validarVacio('import_file', 'El archivo excel ')) {
    return; // Si algún campo está vacío, detener el envío del formulario
} 


//Funcion para validar los campos vacios 
function validarVacio(campo, nombre = campo) {
    if ($(`#${campo}`).val() == "") {
        $(`#${campo}`).focus();
        setTimeout(() => {
            if ($(`#${campo}`).val() == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `${nombre} es requerid@`
                });
            }
        }, 100);
        return false;
    }
    return true;
}