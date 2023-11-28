<?php

$('#enviar').click(function () {
   
   if(!validarVacio("Documento")) return;
   if(!validarVacio("Nombre")) return;
   if(!validarVacio("Correo")) return;
   if(!validarCorreo()) return;
   if(!validarVacio("Telefono")) return;
   if(!validarVacio("Id_interaccion")) return;
   if(!validarVacio("Asesor")) return;
   if(!validarVacio("Detalle")) return;
   if(!validarVacio("Motivo_noatiende")) return;

   let postData = {
       Documento:$('#Documento').val(),
       Nombre:$('#Nombre').val(),
       Correo:$('#Correo').val(),
       Telefono:$('#Telefono').val(),
       Id_interaccion:$('#Id_interaccion').val(),
       Asesor:$('#Asesor').val(),
       Detalle:$('#Detalle').val(),
       Motivo_noatiende:$('#Motivo_noatiende').val()
       }
 console.log(postData)

   $.post('./php/insertar.php', postData, function (response) {
     console.log(response)
       if(response.includes("ERROR")) {
           message('warning', 'Error insertando formulario')
       }else{
           message('success', 'Formulario enviado')
           borrarCampos()
       }
   })
})

$('#limpiar').click(function () {
 borrarCampos()
})

function borrarCampos(){
 $('#Documento').val(""),
$('#Nombre').val(""),
$('#Correo').val(""),
$('#Telefono').val(""),
$('#Id_interaccion').val(""),
$('#Detalle').val(""),
$('#Motivo_noatiende').val("")
}
// FUNCIONES COMUNES

function message(tipo, dato) {
   const Toast = Swal.mixin({
       toast: true,
       position: "bottom-end",
       showConfirmButton: false,
       timer: 3000,
       didOpen: (toast) => {
           toast.addEventListener("mouseenter", Swal.stopTimer);
           toast.addEventListener("mouseleave", Swal.resumeTimer);
       },
   });

   if (tipo == "error") {
       Toast.fire({
           icon: "error",
           title: dato,
       });
   } else if (tipo == "success") {
       Toast.fire({
           icon: "success",
           title: dato,
       });
   } else if (tipo == "done") {
       Swal.fire({
           title: dato,
           icon: "success",
           text: "Datos enviados",
       });
   } else {
       Toast.fire({
           icon: "warning",
           title: dato,
       });
   }
}

function validarVacio(campo){
   if ($(`#${campo}`).val() =="") {
       message("error", `${campo} es requerid@` );
       $(`#${campo}`).focus();
       return false;
     }
     return true;
}
// VALIDACIONES DE INPUT
function soloLetras(key) {
   let valor = key.keyCode || key.which,
     tecla = String.fromCharCode(valor).toLowerCase(),
     letras = "áéíóúabcdefghijklmnñopqrstuvwxyz ",
     especiales = [8, 37, 39, 46],
     tecla_especial = false;
 
   for (let i in especiales) {
     if (valor == especiales[i]) {
       tecla_especial = true;
       break;
     }
   }
 
   if (letras.indexOf(tecla) == -1 && !tecla_especial) {
     return false;
   }
 }
function valideKey(evt) {
   var code = (evt.which) ? evt.which : evt.keyCode;
   if (code == 8) {
       //backspace
       return true;
   }
   else if (code >= 48 && code <= 57) {
       //is a number
       return true;
   }
   else {
       return false;
   }
}
function validarCorreoElectronico(correo) {
   var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
   return regex.test(correo);
 }
 function validarCorreo() {
   if (!validarCorreoElectronico($("#Correo").val())) {
     message("error", "Ingrese un correo válido");
     $("#Correo").focus();
     return false;
   }
   return true;
 }
 function formatearFecha(Fecha) {
   let Fecha_formato = Fecha.split(/[\s-]+/);
   if (Fecha_formato[3] != undefined) {
   return	Fecha_formato[2] + "/" +Fecha_formato[1] + "/" + Fecha_formato[0] + " " + Fecha_formato[3];
   }else{

       return Fecha_formato[2] + "/" + Fecha_formato[1] + "/" + Fecha_formato[0];
   }
}
function formatearDinero(Cifra) {
   let pesos = Intl.NumberFormat('es-CO', {
       style: 'currency',
       currency: 'COP',
       minimumFractionDigits: 0,
       maximumFractionDigits: 0
     }); 
   return pesos.format(Cifra)
}