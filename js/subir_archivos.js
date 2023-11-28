
$("#btnAgregarAdjuntos").on("click", function () {
	let file = $("#Adjunto").prop("files")[0];
	let Id_proceso = $("#Id_proceso").text();

	if (!file || !Id_proceso) {
		message("warning", "Campos Vacios");
		return;
	}
	let formData = new FormData();

	formData.append("File", file);
	formData.append("Id_proceso", Id_proceso);

	// $.post("../php/buscarAdjuntosProceso.php", formData, function (response) {
	//     console.log(response);
	// })
	$.ajax({
		url: "./php/adjuntosJuridico/guardar_adjunto.php",
		type: "post",
		contentType: false,
		processData: false,
		data: formData,
		success: function (response) {
			console.log(response);
			if (response.trim() == "Subido correctamente") {
				Swal.fire({
					icon: "success",
					title: "Adjunto subido correctamente",
					showConfirmButton: true,
					timer: 1500,
				});
				$("#Adjunto").val("");
				pintarAdjuntos();
			} else if (response.includes("Error al subir adjunto")) {
				message("error", "Error al subir adjunto");
			} else if (response.includes("Extensión no permitida")) {
				message("error", "Extensión no permitida");
			} else if (
				response.includes("El archivo tiene que ser menor de 5Mb")
			) {
				message("error", "El archivo tiene que ser menor de 5Mb");
			} else if (response.includes("duplicado")) {
				message(
					"error",
					"El archivo ya se encuentra en la base de datos"
				);
			}
		},
	});
});


function validarVacio(campo, nombre = campo){
    if ($(`#${campo}`).val() =="") {
        message("error", `${nombre} es requerid@` );
        $(`#${campo}`).focus();
        return false;
      }
      return true;
}