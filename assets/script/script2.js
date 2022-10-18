//SELECCIONAR/DESELECCIONAR TODOS LOS CHECKBOX
$("#checkTodos").change(function () {
      $("input:checkbox").prop('checked', $(this).prop("checked"));
      //$("input[type='checkbox']:checked:enabled").prop('checked', $(this).prop("checked"));
  });

// FUNCION PARA LIMPIAR CHECKBOX ACTIVOS
function LimpiarCheckbox(){
$("input[type='checkbox']:checked:enabled").attr('checked',false); 
}

//BUSQUEDA EN CONSULTAS
$(document).ready(function () {
   (function($) {
       $('#FiltrarContenido').keyup(function () {
            var ValorBusqueda = new RegExp($(this).val(), 'i');
            $('.BusquedaRapida tr').hide();
             $('.BusquedaRapida tr').filter(function () {
                return ValorBusqueda.test($(this).text());
              }).show();
                })
      }(jQuery));
});

//FUNCIONES PARA VERIFICAR TIPO INGRESO
function VerificaIngreso(tipo){

    if (tipo == '' || tipo == true) {
         
      //deshabilitamos
      $("#codsucursal").attr('disabled', true);

    } else if (tipo == 'A' || tipo == 'E' || tipo == true) {
         
      //deshabilitamos
      $("#codsucursal").attr('disabled', false);

    } else {

      // habilitamos
      $("#codsucursal").attr('disabled', true);

    }
}








/////////////////////////////////// FUNCIONES DE USUARIOS //////////////////////////////////////

// FUNCION PARA MOSTRAR USUARIOS EN VENTANA MODAL
function VerUsuario(codigo){

$('#muestrausuariomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaUsuarioModal=si&codigo='+codigo;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrausuariomodal').empty();
                $('#muestrausuariomodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR USUARIOS
function UpdateUsuario(codigo,dni,nombres,sexo,direccion,telefono,email,usuario,nivel,status,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveuser #codigo").val(codigo);
  $("#saveuser #dni").val(dni);
  $("#saveuser #nombres").val(nombres);
  $("#saveuser #sexo").val(sexo);
  $("#saveuser #direccion").val(direccion);
  $("#saveuser #telefono").val(telefono);
  $("#saveuser #email").val(email);
  $("#saveuser #usuario").val(usuario);
  $("#saveuser #nivel").val(nivel);
  $("#saveuser #status").val(status);
  $("#saveuser #proceso").val(proceso);
}


/////FUNCION PARA ELIMINAR USUARIOS 
function EliminarUsuario(codigo,dni,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Usuario?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codigo="+codigo+"&dni="+dni+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $("#usuarios").load("consultas.php?CargaUsuarios=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Usuario no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Usuarios, no tienes los privilegios dentro del Sistema!", "error"); 

                }

            }
        })
    });
}

// FUNCION PARA BUSCAR LOGS DE ACCESO
$(document).ready(function(){
//Ejecuto Busqueda  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#blogs").focus();
    //comprobamos si se pulsa una tecla
    $("#blogs").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#blogs").val();

      if (consulta.trim() === '') {  

      $("#logs").html("<center><div class='alert alert-danger'><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BUSQUEDA CORRECTAMENTE</div></center>");
      return false;

      } else {
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaLogs=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#logs").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#logs").empty();
            $("#logs").append(data);
          }
      });
     }
   });                                                               
});

// FUNCION PARA MOSTRAR USUARIOS POR SUCURSAL
function CargaUsuarios(codsucursal){

$('#codigo').html('<center><i class="fa fa-spin fa-spinner"></i></center>');
                
var dataString = 'BuscaUsuariosxSucursal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codigo').empty();
                $('#codigo').append(''+response+'').fadeIn("slow");
                
           }
      });
}

////FUNCION PARA MOSTRAR USUARIO POR CODIGO
function SelectUsuario(codigo,codsucursal){

  $("#codigo").load("funciones.php?MuestraUsuario=si&codigo="+codigo+"&codsucursal="+codsucursal);

}

//FUNCIONES PARA ACTIVAR-DESACTIVAR NIVEL DE USUARIO
function NivelUsuario(nivel){

  $("#nivel").on("change", function() {

    var valor = $("#nivel").val();

    if (valor == "ADMINISTRADOR(A) SUCURSAL" || valor == "SECRETARIA" || valor == "CAJERO(A)" || valor === true) {
         
      $("#codsucursal").attr('disabled', false);

    } else {

      $("#codsucursal").attr('disabled', true);
     }
  });
}

// FUNCION PARA MOSTRAR DIV DE SUCURSALES
function CargarSucursalesUsuarios(nivel){
                
var dataString = 'MuestraSucursalesUsuarios=si&nivel='+nivel;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrasucursales').empty();
                $('#muestrasucursales').append(''+response+'').fadeIn("slow");
           }
      });
}

// FUNCION PARA MOSTRA SUCURSALES ASIGNADAS AL USUARIO
function CargarSucursalesAsignadasxUsuarios(codigo,nivel,gruposid){
                                        
var dataString = 'MuestraSucursalesAsignadasxUsuarios=si&codigo='+codigo+"&nivel="+nivel+"&gruposid="+gruposid;

$.ajax({
            type: "GET",
            url: "funciones.php",
            async : false,
            data: dataString,
            success: function(response) {            
                $('#muestrasucursales').empty();
                $('#muestrasucursales').append(''+response+'').fadeIn("slow");
             }
      });
}


// FUNCION PARA MOSTRAR MENSAJE DE CONTACTO EN VENTANA MODAL
function VerMensaje(codmensaje){

$('#muestramensajemodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaMensajeModal=si&codmensaje='+codmensaje;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestramensajemodal').empty();
                $('#muestramensajemodal').append(''+response+'').fadeIn("slow");
            }
      });
}

/////FUNCION PARA ELIMINAR MENSAJE DE CONTACTO 
function EliminarMensaje(codmensaje,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Mensaje de Contacto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmensaje="+codmensaje+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#mensajes').load("consultas.php?CargaMensajes=si");

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Mensaje de Contacto, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}










/////////////////////////////////// FUNCIONES DE HORARIO DE USUARIOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR HORARIO DE USUARIOS
function UpdateHorarioUsuario(codhorario,codigo,hora_desde,hora_hasta,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savehorariosusuario #codhorario").val(codhorario);
  $("#savehorariosusuario #codigo").val(codigo);
  $("#savehorariosusuario #hora_desde").val(hora_desde);
  $("#savehorariosusuario #hora_hasta").val(hora_hasta);
  $("#savehorariosusuario #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR HORARIO DE USUARIOS 
function EliminarHorarioUsuario(codhorario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Horario de Acceso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codhorario="+codhorario+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#horarios').load("consultas?CargaHorariosUsuarios=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Horario de Acceso, no tienes los privilegios dentro del Sistema!", "error"); 

            }
        }
      })
  });
}










/////////////////////////////////// FUNCIONES DE HORARIO DE ESPECIALISTAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR HORARIO DE ESPECIALISTAS
function UpdateHorarioEspecialista(codhorario,codespecialista,hora_desde,hora_hasta,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savehorariosespecialista #codhorario").val(codhorario);
  $("#savehorariosespecialista #codespecialista").val(codespecialista);
  $("#savehorariosespecialista #hora_desde").val(hora_desde);
  $("#savehorariosespecialista #hora_hasta").val(hora_hasta);
  $("#savehorariosespecialista #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR HORARIO DE ESPECIALISTAS 
function EliminarHorarioEspecialista(codhorario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Horario de Acceso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codhorario="+codhorario+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#horarios').load("consultas?CargaHorariosEspecialistas=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Horario de Acceso, no tienes los privilegios dentro del Sistema!", "error"); 

            }
        }
      })
  });
}












/////////////////////////////////// FUNCIONES DE DEPARTAMENTOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR DEPARTAMENTOS
function UpdateDepartamento(id_departamento,departamento,proceso) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savedepartamentos #id_departamento").val(id_departamento);
  $("#savedepartamentos #departamento").val(departamento);
  $("#savedepartamentos #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR DEPARTAMENTOS 
function EliminarDepartamento(id_departamento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Departamento?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "id_departamento="+id_departamento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#departamentos').load("consultas?CargaDepartamentos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Departamento no puede ser Eliminada, tiene Provincias relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Departamentos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}












/////////////////////////////////// FUNCIONES DE PROVINCIAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR PROVINCIAS
function UpdateProvincia(id_provincia,provincia,id_departamento,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveprovincias #id_provincia").val(id_provincia);
  $("#saveprovincias #provincia").val(provincia);
  $("#saveprovincias #id_departamento").val(id_departamento);
  $("#saveprovincias #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR DEPARTAMENTOS 
function EliminarProvincia(id_provincia,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Provincia del Departamento?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "id_provincia="+id_provincia+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#provincias').load("consultas?CargaProvincias=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Provincia no puede ser Eliminada, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Provincias, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

////FUNCION PARA MOSTRAR DEPARTAMENTOS POR PROVINCIAS
function CargaProvincias(id_departamento){

$('#id_provincia').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaProvincias=si&id_departamento='+id_departamento;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#id_provincia').empty();
                $('#id_provincia').append(''+response+'').fadeIn("slow");
           }
      });
}


////FUNCION PARA MOSTRAR DEPARTAMENTOS POR PROVINCIAS #2
function CargaProvincias2(id_departamento2){

$('#id_provincia2').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaProvincias2=si&id_departamento2='+id_departamento2;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#id_provincia2').empty();
                $('#id_provincia2').append(''+response+'').fadeIn("slow");
           }
      });
}

////FUNCION PARA MOSTRAR MUNICIPIO POR DEPARTAMENTO
function SelectProvincia(id_departamento,id_provincia){

  if(id_provincia != 0)
    {
      $("#id_provincia").load("funciones.php?SeleccionaProvincia=si&id_departamento="+id_departamento+"&id_provincia="+id_provincia);
    }
}
















/////////////////////////////////// FUNCIONES DE TIPOS DE DOCUMENTOS  //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE DOCUMENTOS
function UpdateDocumento(coddocumento,documento,descripcion,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savedocumentos #coddocumento").val(coddocumento);
  $("#savedocumentos #documento").val(documento);
  $("#savedocumentos #descripcion").val(descripcion);
  $("#savedocumentos #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE DOCUMENTOS 
function EliminarDocumento(coddocumento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Documento?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddocumento="+coddocumento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#documentos').load("consultas?CargaDocumentos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Documento no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Documentos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}












/////////////////////////////////// FUNCIONES DE TIPOS DE MONEDA //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE MONEDA
function UpdateTipoMoneda(codmoneda,moneda,siglas,simbolo,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemonedas #codmoneda").val(codmoneda);
  $("#savemonedas #moneda").val(moneda);
  $("#savemonedas #siglas").val(siglas);
  $("#savemonedas #simbolo").val(simbolo);
  $("#savemonedas #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE MONEDA 
function EliminarTipoMoneda(codmoneda,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Moneda?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmoneda="+codmoneda+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#monedas').load("consultas?CargaMonedas=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Tipo de Moneda no puede ser Eliminado, tiene Tipos de Cambio relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Tipos de Moneda, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE TIPOS DE CAMBIO  //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE CAMBIO
function UpdateTipoCambio(codcambio,descripcioncambio,montocambio,codmoneda,fechacambio,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savecambios #codcambio").val(codcambio);
  $("#savecambios #descripcioncambio").val(descripcioncambio);
  $("#savecambios #montocambio").val(montocambio);
  $("#savecambios #codmoneda").val(codmoneda);
  $("#savecambios #fechacambio").val(fechacambio);
  $("#savecambios #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE CAMBIO 
function EliminarTipoCambio(codcambio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Cambio?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcambio="+codcambio+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#cambios').load("consultas?CargaCambios=si");
                  
           } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Tipos de Cambio, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE MEDIOS DE PAGOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR MEDIOS DE PAGOS
function UpdateMedio(codmediopago,mediopago,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemedios #codmediopago").val(codmediopago);
  $("#savemedios #mediopago").val(mediopago);
  $("#savemedios #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MEDIOS DE PAGOS 
function EliminarMedio(codmediopago,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Medio de Pago?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmediopago="+codmediopago+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#mediospagos').load("consultas?CargaMediosPagos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Medio de Pago no puede ser Eliminado, tiene Ventas relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Medios de Pagos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}












/////////////////////////////////// FUNCIONES DE IMPUESTOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR IMPUESTOS
function UpdateImpuesto(codimpuesto,nomimpuesto,valorimpuesto,statusimpuesto,fechaimpuesto,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveimpuestos #codimpuesto").val(codimpuesto);
  $("#saveimpuestos #nomimpuesto").val(nomimpuesto);
  $("#saveimpuestos #valorimpuesto").val(valorimpuesto);
  $("#saveimpuestos #statusimpuesto").val(statusimpuesto);
  $("#saveimpuestos #fechaimpuesto").val(fechaimpuesto);
  $("#saveimpuestos #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR IMPUESTOS
function EliminarImpuesto(codimpuesto,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Impuesto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codimpuesto="+codimpuesto+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#impuestos').load("consultas?CargaImpuestos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Impuesto no puede ser Eliminado, se encuentra activo para Ventas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Impuestos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}














/////////////////////////////////// FUNCIONES DE SUCURSALES //////////////////////////////////////

// FUNCION PARA MOSTRAR SUCURSALES EN VENTANA MODAL
function VerSucursal(codsucursal){

$('#muestrasucursalmodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaSucursalModal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrasucursalmodal').empty();
                $('#muestrasucursalmodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR SUCURSALES
function UpdateSucursal(codsucursal,nrosucursal,documsucursal,cuitsucursal,nomsucursal,
id_departamento,direcsucursal,correosucursal,tlfsucursal,nroactividadsucursal,inicioticket,inicionotaventa,iniciofactura,fechaautorsucursal,
llevacontabilidad,documencargado,dniencargado,nomencargado,tlfencargado,descsucursal,codmoneda,codmoneda2,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savesucursal #codsucursal").val(codsucursal);
  $("#savesucursal #nrosucursal").val(nrosucursal);
  $("#savesucursal #documsucursal").val(documsucursal);
  $("#savesucursal #cuitsucursal").val(cuitsucursal);
  $("#savesucursal #nomsucursal").val(nomsucursal);
  $("#savesucursal #id_departamento").val(id_departamento);
  $("#savesucursal #direcsucursal").val(direcsucursal);
  $("#savesucursal #correosucursal").val(correosucursal);
  $("#savesucursal #tlfsucursal").val(tlfsucursal);
  $("#savesucursal #nroactividadsucursal").val(nroactividadsucursal);
  $("#savesucursal #inicioticket").val(inicioticket);
  $("#savesucursal #inicionotaventa").val(inicionotaventa);
  $("#savesucursal #iniciofactura").val(iniciofactura);
  $("#savesucursal #fechaautorsucursal").val(fechaautorsucursal);
  $("#savesucursal #llevacontabilidad").val(llevacontabilidad);
  $("#savesucursal #documencargado").val(documencargado);
  $("#savesucursal #dniencargado").val(dniencargado);
  $("#savesucursal #nomencargado").val(nomencargado);
  $("#savesucursal #tlfencargado").val(tlfencargado);
  $("#savesucursal #descsucursal").val(descsucursal);
  $("#savesucursal #codmoneda").val(codmoneda);
  $("#savesucursal #codmoneda2").val(codmoneda2);
  $("#savesucursal #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR SUCURSALES 
function EliminarSucursal(codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Sucursal?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

         if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#sucursales').load("consultas?CargaSucursales=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Sucursal no puede ser Eliminada, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Sucursales, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE TRATAMIENTOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TRATAMIENTOS
function UpdateTratamiento(codtratamiento,nomtratamiento,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savetratamiento #codtratamiento").val(codtratamiento);
  $("#savetratamiento #nomtratamiento").val(nomtratamiento);
  $("#savetratamiento #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TRATAMIENTOS 
function EliminarTratamiento(codtratamiento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Tratamiento?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codtratamiento="+codtratamiento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#tratamientos').load("consultas?CargaTratamientos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Tratamiento no puede ser Eliminado, tiene Consultas Odontologicas relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Tratamientos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}










/////////////////////////////////// FUNCIONES DE MARCAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR MARCAS
function UpdateMarca(codmarca,nommarca,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemarcas #codmarca").val(codmarca);
  $("#savemarcas #nommarca").val(nommarca);
  $("#savemarcas #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MARCAS 
function EliminarMarca(codmarca,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Marca de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmarca="+codmarca+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#marcas').load("consultas?CargaMarcas=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Marca no puede ser Eliminada, tiene Modelos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Marcas, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}















/////////////////////////////////// FUNCIONES DE PRESENTACIONES //////////////////////////////////////

// FUNCION PARA ACTUALIZAR PRESENTACIONES
function UpdatePresentacion(codpresentacion,nompresentacion,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savepresentaciones #codpresentacion").val(codpresentacion);
  $("#savepresentaciones #nompresentacion").val(nompresentacion);
  $("#savepresentaciones #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR PRESENTACIONES 
function EliminarPresentacion(codpresentacion,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Presentaci&oacute;n de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codpresentacion="+codpresentacion+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#presentaciones').load("consultas?CargaPresentaciones=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Presentaci&oacute;n no puede ser Eliminada, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Presentaciones, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}














/////////////////////////////////// FUNCIONES DE MEDIDAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR MEDIDAS
function UpdateMedida(codmedida,nommedida,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemedidas #codmedida").val(codmedida);
  $("#savemedidas #nommedida").val(nommedida);
  $("#savemedidas #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR UNIDADES 
function EliminarMedida(codmedida,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Medida?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmedida="+codmedida+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#medidas').load("consultas.php?CargaMedidas=si");
            $("#savemedidas")[0].reset();

          } else if(data==2) { 

             swal("Oops", "Esta Medida no puede ser Eliminada, tiene registros relacionados!", "error"); 

           } else {  

             swal("Oops", "Usted no tiene Acceso para Eliminar Medidas, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}












/////////////////////////////////// FUNCIONES DE ESPECIALISTAS //////////////////////////////////////

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE ESPECIALISTAS
function CargaDivEspecialista(){

$('#divespecialista').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivEspecialista=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divespecialista').empty();
                $('#divespecialista').append(''+response+'').fadeIn("slow");
           }
      });
}


// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE ESPECIALISTAS
function ModalEspecialista(){
  $("#divespecialista").html("");
}

// FUNCION PARA MOSTRAR ESPECIALISTA EN VENTANA MODAL
function VerEspecialista(codespecialista){

$('#muestraespecialistamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaEspecialistaModal=si&codespecialista='+codespecialista;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraespecialistamodal').empty();
                $('#muestraespecialistamodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR ESPECIALISTAS
function UpdateEspecialista(codespecialista,tpespecialista,documespecialista,cedespecialista,nomespecialista,tlfespecialista,
  sexoespecialista,id_departamento,direcespecialista,correoespecialista,especialidad,fnacespecialista,twitter,facebook,instagram,google,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveespecialista #codespecialista").val(codespecialista);
  $("#saveespecialista #documespecialista").val(documespecialista);
  $("#saveespecialista #tpespecialista").val(tpespecialista);
  $("#saveespecialista #cedespecialista").val(cedespecialista);
  $("#saveespecialista #nomespecialista").val(nomespecialista);
  $("#saveespecialista #tlfespecialista").val(tlfespecialista);
  $("#saveespecialista #sexoespecialista").val(sexoespecialista);
  $("#saveespecialista #id_departamento").val(id_departamento);
  $("#saveespecialista #direcespecialista").val(direcespecialista);
  $("#saveespecialista #correoespecialista").val(correoespecialista);
  $("#saveespecialista #especialidad").val(especialidad);
  $("#saveespecialista #fnacespecialista").val(fnacespecialista);
  $("#saveespecialista #twitter").val(twitter);
  $("#saveespecialista #facebook").val(facebook);
  $("#saveespecialista #instagram").val(instagram);
  $("#saveespecialista #google").val(google);
  $("#saveespecialista #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR ESPECIALISTAS 
function EliminarEspecialista(codespecialista,cedespecialista,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Especialista?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codespecialista="+codespecialista+"&cedespecialista="+cedespecialista+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#especialistas').load("consultas.php?CargaEspecialistas=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Especialista no puede ser Eliminado, tiene Registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Especialistas, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA REINICIAR CLAVE ESPECIALISTA 
function ReiniciarClaveEspecialista(codespecialista,cedespecialista,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Reiniciar la Clave de Acceso de este Especialista?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Reiniciar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  async : false,
                  data: "codespecialista="+codespecialista+"&cedespecialista="+cedespecialista+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Reiniciada!", "Su Clave de Acceso fue reiniciada con éxito al Nº de Documento de Identidad", "success");
            $('#especialistas').load("consultas.php?CargaEspecialistas=si"); 
                  
          } else { 

             swal("Oops", "No puedes Reiniciar Claves, No tienes Privilegios para ese Procedimiento !", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA ACTIVAR SUCURSALES ASIGNADAS AL ESPECIALISTA
function CargaSucursales(codespecialista,gruposid){
                        
$('#muestrasucursales').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');
                
var dataString = 'MuestraSucursalesAsignadas=si&codespecialista='+codespecialista+"&gruposid="+gruposid;

$.ajax({
            type: "GET",
            url: "funciones.php",
            async : false,
            data: dataString,
            success: function(response) {            
                $('#muestrasucursales').empty();
                $('#muestrasucursales').append(''+response+'').fadeIn("slow");
             }
      });
}



// FUNCION PARA MOSTRAR USUARIOS POR SUCURSAL
function CargaEspecialistas(codsucursal){

$('#codespecialista').html('<center><i class="fa fa-spin fa-spinner"></i></center>');
                
var dataString = 'BuscaEspecialistasxSucursal=si&codsucursal='+codsucursal;

$.ajax({
        type: "GET",
        url: "funciones.php",
        data: dataString,
        success: function(response) {            
            $('#codespecialista').empty();
            $('#codespecialista').append(''+response+'').fadeIn("slow");
            
       }
  });
}

// FUNCION PARA BUSQUEDA DE ESPECIALISTA POR SUCURSALES
function BuscarEspecialistasxSucursales(){
                        
$('#muestraespecialistasxsucursales').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, verificando información ......</center>');
                
var codsucursal = $("#codsucursal").val();
var dataString = $("#especialistasxsucursales").serialize();
var url = 'funciones.php?BuscaEspecialistasxSucursales=si';

$.ajax({
        type: "GET",
        url: url,
        async : false,
        data: dataString,
        success: function(response) {            
            $('#muestraespecialistasxsucursales').empty();
            $('#muestraespecialistasxsucursales').append(''+response+'').fadeIn("slow");
         }
  });
}


















/////////////////////////////////// FUNCIONES DE PACIENTES //////////////////////////////////////

// FUNCION PARA BUSCAR PACIENTES
$(document).ready(function(){
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bpacientes").focus();
    //comprobamos si se pulsa una tecla
    $("#bpacientes").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bpacientes").val();

      if (consulta.trim() === '') {  

      $("#pacientes").html("<center><div class='alert alert-danger'><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BUSQUEDA CORRECTAMENTE</div></center>");
      return false;

      } else {
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaPacientes=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#pacientes").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#pacientes").empty();
            $("#pacientes").append(data);
          }
      });
     }
   });                                                               
});

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PACIENTES
function CargaDivPaciente(){

$('#divpaciente').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivPaciente=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divpaciente').empty();
                $('#divpaciente').append(''+response+'').fadeIn("slow");
           }
      });
}


// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE PACIENTES
function ModalPaciente(){
  $("#divpaciente").html("");
}

// FUNCION PARA MOSTRAR PACIENTES EN VENTANA MODAL
function VerPaciente(codpaciente){

$('#muestrapacientemodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaPacienteModal=si&codpaciente='+codpaciente;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrapacientemodal').empty();
                $('#muestrapacientemodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR PACIENTES
function UpdatePaciente(codpaciente) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar los Datos de este Paciente?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forpaciente?codpaciente="+codpaciente;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

/////FUNCION PARA ELIMINAR PACIENTES 
function EliminarPaciente(codpaciente,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Paciente?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codpaciente="+codpaciente+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#pacientes').load("consultas.php?CargaPacientes=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Paciente no puede ser Eliminado, tiene Registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Pacientes, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}












/////////////////////////////////// FUNCIONES DE PROVEEDORES //////////////////////////////////////

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PROVEEDORES
function CargaDivProveedores(){

$('#divproveedor').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivProveedor=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divproveedor').empty();
                $('#divproveedor').append(''+response+'').fadeIn("slow");
           }
      });
}


// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE PROVEEDORES
function ModalProveedor(){
  $("#divproveedor").html("");
}

// FUNCION PARA MOSTRAR PROVEEDORES EN VENTANA MODAL
function VerProveedor(codproveedor){

$('#muestraproveedormodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaProveedorModal=si&codproveedor='+codproveedor;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraproveedormodal').empty();
                $('#muestraproveedormodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR PROVEEDORES
function UpdateProveedor(codproveedor,documproveedor,cuitproveedor,nomproveedor,tlfproveedor,id_departamento,
  direcproveedor,emailproveedor,vendedor,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveproveedor #codproveedor").val(codproveedor);
  $("#saveproveedor #documproveedor").val(documproveedor);
  $("#saveproveedor #cuitproveedor").val(cuitproveedor);
  $("#saveproveedor #nomproveedor").val(nomproveedor);
  $("#saveproveedor #tlfproveedor").val(tlfproveedor);
  $("#saveproveedor #id_departamento").val(id_departamento);
  $("#saveproveedor #direcproveedor").val(direcproveedor);
  $("#saveproveedor #emailproveedor").val(emailproveedor);
  $("#saveproveedor #vendedor").val(vendedor);
  $("#saveproveedor #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR PROVEEDORES 
function EliminarProveedor(codproveedor,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Proveedor?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codproveedor="+codproveedor+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#proveedores').load("consultas.php?CargaProveedores=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Proveedor no puede ser Eliminado, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Proveedores, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}













/////////////////////////////////// FUNCIONES DE SERVICIOS //////////////////////////////////////

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE SERVICIOS
function CargaDivServicio(){

$('#divservicio').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivServicio=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divservicio').empty();
                $('#divservicio').append(''+response+'').fadeIn("slow");
           }
      });
}


// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE SERVICIOS
function ModalServicio(){
  $("#divservicio").html("");
}

// FUNCION PARA MOSTRAR SERVICIOS EN VENTANA MODAL
function VerServicio(codservicio,codsucursal){

$('#muestraserviciomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaServicioModal=si&codservicio='+codservicio+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraserviciomodal').empty();
                $('#muestraserviciomodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR SERVICIOS
function UpdateServicio(codservicio,servicio,preciocompra,precioventa,ivaservicio,descservicio,status,
  codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveservicio #codservicio").val(codservicio);
  $("#saveservicio #servicio").val(servicio);
  $("#saveservicio #preciocompra").val(preciocompra);
  $("#saveservicio #precioventa").val(precioventa);
  $("#saveservicio #ivaservicio").val(ivaservicio);
  $("#saveservicio #descservicio").val(descservicio);
  $("#saveservicio #status").val(status);
  $("#saveservicio #codsucursal").val(codsucursal);
  $("#saveservicio #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR SERVICIOS 
function EliminarServicio(codservicio,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Servicio?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codservicio="+codservicio+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#servicios').load("consultas.php?CargaServicios=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Servicio no puede ser Eliminado, tiene Registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Servicios, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA BUSQUEDA DE SERVICIOS POR SUCURSAL
function BuscaServiciosxSucursal(){

$('#muestraservicios').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#serviciosxsucursal").serialize();
var url = 'funciones.php?BuscaServiciosxSucursal=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraservicios').empty();
                $('#muestraservicios').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE SERVICIOS VENDIDOS
function BuscaServiciosVendidos(){
    
$('#muestraserviciosvendidos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#serviciosvendidos").serialize();
var url = 'funciones.php?BuscaServiciosVendidos=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraserviciosvendidos').empty();
                $('#muestraserviciosvendidos').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE SERVICIOS VENDIDOS POR VENDEDOR
function BuscaServiciosxVendedor(){
    
$('#muestraserviciosxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#serviciosxvendedor").serialize();
var url = 'funciones.php?BuscaServiciosxVendedor=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraserviciosxvendedor').empty();
                $('#muestraserviciosxvendedor').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE SERVICIOS POR MONEDA
function BuscaServiciosxMoneda(){
    
$('#muestraserviciosxmoneda').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codmoneda = $("#codmoneda").val();
var dataString = $("#serviciosxmoneda").serialize();
var url = 'funciones.php?BuscaServiciosxMoneda=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraserviciosxmoneda').empty();
                $('#muestraserviciosxmoneda').append(''+response+'').fadeIn("slow");
            }
      }); 
}


// FUNCION PARA BUSQUEDA DE KARDEX POR SERVICIOS
function BuscaKardexServicio(){

$('#muestrakardexservicio').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codservicio = $("input#codservicio").val();
var dataString = $("#buscakardexservicio").serialize();
var url = 'funciones.php?BuscaKardexServicio=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexservicio').empty();
                $('#muestrakardexservicio').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE KARDEX SERVICIOS VALORIZADO
function BuscaKardexServiciosValorizadoxSucursal(){
    
$('#muestrakardexserviciosvalorizado').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#buscakardexserviciosvalorizado").serialize();
var url = 'funciones.php?BuscaKardexServiciosValorizado=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexserviciosvalorizado').empty();
                $('#muestrakardexserviciosvalorizado').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA KARDEX SERVICIOS VALORIZADO POR FECHAS Y VENDEDOR
function BuscaKardexServiciosValorizadoFechas(){
    
$('#muestrakardexserviciosfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#kardexserviciosvalorizadoxfechas").serialize();
var url = 'funciones.php?BuscaKardexServiciosValorizadoxFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexserviciosfechas').empty();
                $('#muestrakardexserviciosfechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}


















/////////////////////////////////// FUNCIONES DE PRODUCTOS //////////////////////////////////////


// FUNCION PARA BUSCAR PRODUCTOS
$(document).ready(function(){
//function BuscarPacientes() {  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bproductos").focus();
    //comprobamos si se pulsa una tecla
    $("#bproductos").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bproductos").val();
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaProductos=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#productos").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#productos").empty();
            $("#productos").append(data);
          }
      });
   });                                                               
});


// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PRODUCTOS
function CargaDivProductos(){

$('#divproducto').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivProducto=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divproducto').empty();
                $('#divproducto').append(''+response+'').fadeIn("slow");
           }
      });
}

// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE PRODUCTOS
function ModalProducto(){
  $("#divproducto").html("");
}

// FUNCION PARA MOSTRAR PRODUCTOS EN VENTANA MODAL
function VerProducto(codproducto,codsucursal){

$('#muestraproductomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaProductoModal=si&codproducto='+codproducto+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraproductomodal').empty();
                $('#muestraproductomodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR PRODUCTOS
function UpdateProducto(codproducto,codsucursal) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forproducto?codproducto="+codproducto+"&codsucursal="+codsucursal;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

/////FUNCION PARA ELIMINAR PRODUCTOS 
function EliminarProducto(codproducto,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codproducto="+codproducto+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#productos').load("consultas.php?CargaProductos=si");
               
          } else if(data==2){ 

             swal("Oops", "Este Producto no puede ser Eliminado, tiene Ventas relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Productos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS POR SUCURSAL
function BuscaProductosxSucursal(){

$('#muestraproductos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#productosxsucursal").serialize();
var url = 'funciones.php?BuscaProductosxSucursal=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductos').empty();
                $('#muestraproductos').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS VENDIDOS
function BuscaProductosVendidos(){
    
$('#muestraproductosvendidos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#productosvendidos").serialize();
var url = 'funciones.php?BuscaProductosVendidos=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductosvendidos').empty();
                $('#muestraproductosvendidos').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS VENDIDOS POR VENDEDOR
function BuscaProductosxVendedor(){
    
$('#muestraproductosxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#productosxvendedor").serialize();
var url = 'funciones.php?BuscaProductosxVendedor=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductosxvendedor').empty();
                $('#muestraproductosxvendedor').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS POR MONEDA
function BuscaProductosxMoneda(){
    
$('#muestraproductosxmoneda').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codmoneda = $("#codmoneda").val();
var dataString = $("#productosxmoneda").serialize();
var url = 'funciones.php?BuscaProductosxMoneda=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductosxmoneda').empty();
                $('#muestraproductosxmoneda').append(''+response+'').fadeIn("slow");
            }
      }); 
}


// FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS
function BuscaKardexProducto(){

$('#muestrakardexproducto').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codproducto = $("input#codproducto").val();
var dataString = $("#buscakardexproducto").serialize();
var url = 'funciones.php?BuscaKardexProducto=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexproducto').empty();
                $('#muestrakardexproducto').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE KARDEX PRODUCTOS VALORIZADO
function BuscaKardexProductosValorizadoxSucursal(){
    
$('#muestrakardexproductosvalorizado').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#buscakardexproductosvalorizado").serialize();
var url = 'funciones.php?BuscaKardexProductosValorizado=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexproductosvalorizado').empty();
                $('#muestrakardexproductosvalorizado').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE KARDEX PRODUCTOS POR FECHAS Y VENDEDOR
function BuscaKardexProductosValorizadoFechas(){
    
$('#muestrakardexproductosvalorizadofechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#kardexproductosvalorizadoxfechas").serialize();
var url = 'funciones.php?BuscaKardexProductosValorizadoxFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexproductosvalorizadofechas').empty();
                $('#muestrakardexproductosvalorizadofechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}


// FUNCION PARA CARGAR PRODUCTOS POR MARCAS EN VENTANA MODAL
function CargaProductos(){

$('#loadproductos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var dataString = "ProductosxMarcas=si&url=modal";

$.ajax({
            type: "GET",
            url: "marcas_productos.php",
            data: dataString,
            success: function(response) {            
                $('#loadproductos').empty();
                $('#loadproductos').append(''+response+'').fadeIn("slow");
            }
      });
}

























/////////////////////////////////// FUNCIONES DE TRASPASOS //////////////////////////////////////

// FUNCION PARA BUSCAR TRASPASOS
$(document).ready(function(){
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#btraspasos").focus();
    //comprobamos si se pulsa una tecla
    $("#btraspasos").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#btraspasos").val();

      if (consulta.trim() === '') {  

      $("#traspasos").html("<center><div class='alert alert-danger'><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BUSQUEDA CORRECTAMENTE</div></center>");
      return false;

      } else {
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaTrapasos=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#traspasos").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#traspasos").empty();
            $("#traspasos").append(data);
          }
      });
     }
   });                                                               
});

// FUNCION PARA MOSTRAR TRASPASOS EN VENTANA MODAL
function VerTraspaso(codtraspaso,codsucursal){

$('#muestratraspasomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaTraspasoModal=si&codtraspaso='+codtraspaso+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestratraspasomodal').empty();
                $('#muestratraspasomodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR TRASPASOS
function UpdateTraspaso(codtraspaso,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "fortraspaso?codtraspaso="+codtraspaso+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES COTIZACIONES EN ACTUALIZAR
function ProcesarCalculoTraspaso(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantidad_"+indice).focus();
        $("#cantidad").css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO DEL TOTAL PARA COMPRA

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00");

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    NetoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });  

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtgravado').val(BaseImpIva1.toFixed(2));
    $('#lblgravado').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtexento').val(BaseImpIva2.toFixed(2));
    $('#lblexento').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#lblsubtotal').text(SubTotal.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}

/////FUNCION PARA ELIMINAR DETALLES DE TRASPASOS EN VENTANA MODAL
function EliminarDetalleTraspasoModal(coddetalletraspaso,codtraspaso,recibe,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalletraspaso="+coddetalletraspaso+"&codtraspaso="+codtraspaso+"&recibe="+recibe+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestratraspasomodal').load("funciones.php?BuscaTraspasoModal=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal); 
            $('#traspasos').load("consultas.php?CargaTraspasos=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Traspasos en este Módulo, realice la Eliminación completa del Traspaso!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Traspasos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE TRASPASOS EN ACTUALIZAR
function EliminarDetalleTraspasoUpdate(coddetalletraspaso,codtraspaso,recibe,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalletraspaso="+coddetalletraspaso+"&codtraspaso="+codtraspaso+"&recibe="+recibe+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallestraspasoupdate').load("funciones.php?MuestraDetallesTraspasoUpdate=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Traspasos en este Módulo, realice la Eliminación completa del Traspaso!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Traspasos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR TRASPASOS 
function EliminarTraspaso(codtraspaso,recibe,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codtraspaso="+codtraspaso+"&recibe="+recibe+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#traspasos').load("consultas.php?CargaTraspasos=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Traspasos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSQUEDA DE TRASPASOS POR SUCURSAL
function BuscarTraspasosxSucursal(){
                        
$('#muestratraspasosxsucursal').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

codsucursal = $("#codsucursal").val();
var dataString = $("#traspasosxsucursal").serialize();
var url = 'funciones.php?BuscaTraspasosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestratraspasosxsucursal').empty();
      $('#muestratraspasosxsucursal').append(''+response+'').fadeIn("slow");
      }
  });
}


// FUNCION PARA BUSQUEDA DE TRASPASOS POR FECHAS
function BuscarTraspasosxFechas(){
                        
$('#muestratraspasosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#traspasosxfechas").serialize();
var url = 'funciones.php?BuscaTraspasosxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestratraspasosxfechas').empty();
      $('#muestratraspasosxfechas').append(''+response+'').fadeIn("slow");    
    }
  });
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS TRASPASOS
function BuscaProductosTraspasos(){
    
$('#muestraproductostraspasos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#productostraspasos").serialize();
var url = 'funciones.php?BuscaProductoTraspasos=si';

    $.ajax({
        type: "GET",
        url: url,
        data: dataString,
        success: function(response) {
            $('#muestraproductostraspasos').empty();
            $('#muestraproductostraspasos').append(''+response+'').fadeIn("slow");
        }
  }); 
}

























/////////////////////////////////// FUNCIONES DE COMPRAS //////////////////////////////////////

// FUNCION PARA BUSCAR COMPRAS PAGADAS
$(document).ready(function(){
//function BuscarPacientes() {  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bcompras").focus();
    //comprobamos si se pulsa una tecla
    $("#bcompras").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bcompras").val();
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaCompras=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#compras").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#compras").empty();
            $("#compras").append(data);
          }
      });
   });                                                               
});


// FUNCION PARA BUSCAR COMPRAS PENDIENTES
$(document).ready(function(){
//function BuscarPacientes() {  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bcomprasp").focus();
    //comprobamos si se pulsa una tecla
    $("#bcomprasp").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bcomprasp").val();
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaCuentasxPagar=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#cuentasxpagar").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#cuentasxpagar").empty();
            $("#cuentasxpagar").append(data);
          }
      });
   });                                                               
});

// FUNCION PARA MOSTRAR FORMA DE PAGO EN COMPRAS
function CargaFormaPagosCompras(){

  var valor = $("#tipocompra").val();

      if (valor === "" || valor === true) {
         
          $("#formacompra").attr('disabled', true);
          $("#fechavencecredito").attr('disabled', true);

      } else if (valor === "CONTADO" || valor === true) {
         
          $("#formacompra").attr('disabled', false);
          $("#fechavencecredito").attr('disabled', true);

      } else {

          $("#formacompra").attr('disabled', true);
          $("#fechavencecredito").attr('disabled', false);
      }
}

// FUNCION PARA MOSTRAR COMPRA PAGADA EN VENTANA MODAL
function VerCompraPagada(codcompra,codsucursal){

$('#muestracompramodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCompraPagadaModal=si&codcompra='+codcompra+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracompramodal').empty();
                $('#muestracompramodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL
function VerCompraPendiente(codcompra,codsucursal){

$('#muestracompramodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCompraPendienteModal=si&codcompra='+codcompra+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracompramodal').empty();
                $('#muestracompramodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ABONAR PAGO DE CREDITOS DE COMPRAS
function AbonoCreditoCompra(codsucursal,codproveedor,codcompra,totaldebe,cuitproveedor,nomproveedor,nrocompra,totalfactura,fechaemision,totalabono,debe) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savepagocompra #codsucursal").val(codsucursal);
  $("#savepagocompra #codproveedor").val(codproveedor);
  $("#savepagocompra #codcompra").val(codcompra);
  $("#savepagocompra #totaldebe").val(totaldebe);
  $("#savepagocompra #cuitproveedor").val(cuitproveedor);
  $("#savepagocompra #nomproveedor").val(nomproveedor);
  $("#savepagocompra #nrocompra").val(nrocompra);
  $("#savepagocompra #totalfactura").val(totalfactura);
  $("#savepagocompra #fechaemision").val(fechaemision);
  $("#savepagocompra #totalabono").val(totalabono);
  $("#savepagocompra #abono").val(totalabono);
  $("#savepagocompra #debe").val(debe);
}

// FUNCION PARA ABONAR PAGO DE CREDITOS DE COMPRAS
function AbonoCreditoProveedor(codsucursal,codproveedor,codcompra,totaldebe,cuitproveedor,nomproveedor,nrocompra,totalfactura,fechaemision,totalabono,debe) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveabonosproveedor #codsucursal").val(codsucursal);
  $("#saveabonosproveedor #codproveedor").val(codproveedor);
  $("#saveabonosproveedor #codcompra").val(codcompra);
  $("#saveabonosproveedor #totaldebe").val(totaldebe);
  $("#saveabonosproveedor #cuitproveedor").val(cuitproveedor);
  $("#saveabonosproveedor #nomproveedor").val(nomproveedor);
  $("#saveabonosproveedor #nrocompra").val(nrocompra);
  $("#saveabonosproveedor #totalfactura").val(totalfactura);
  $("#saveabonosproveedor #fechaemision").val(fechaemision);
  $("#saveabonosproveedor #totalabono").val(totalabono);
  $("#saveabonosproveedor #abono").val(totalabono);
  $("#saveabonosproveedor #debe").val(debe);
}

// FUNCION PARA ACTUALIZAR COMPRAS
function UpdateCompra(codcompra,codsucursal,proceso,status) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcompra?codcompra="+codcompra+"&codsucursal="+codsucursal+"&proceso="+proceso+"&status="+status;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


// FUNCION PARA CALCULAR DETALLES VENTAS EN ACTUALIZAR
function ProcesarCalculoCompra(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descfactura_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantidad_"+indice).focus();
        $("#cantidad").css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);
    
    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentoc_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00"); 

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtgravado').val(BaseImpIva1.toFixed(2));
    $('#lblgravado').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtexento').val(BaseImpIva2.toFixed(2));
    $('#lblexento').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentoc').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#lblsubtotal').text(SubTotal.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}


// FUNCION PARA AGREGAR DETALLES A COMPRAS
function AgregaDetalleCompra(codcompra,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles a esta Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcompra?codcompra="+codcompra+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS PAGADAS EN VENTANA MODAL
function EliminarDetalleCompraPagadaModal(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracompramodal').load("funciones.php?BuscaCompraPagadaModal=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
            $('#compras').load("consultas.php?CargaCompras=si");

          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS PENDIENTES EN VENTANA MODAL
function EliminarDetalleCompraPendienteModal(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracompramodal').load("funciones.php?BuscaCompraPendienteModal=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
            $('#cuentasxpagar').load("consultas?CargaCuentasxPagar=si");

          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS EN ACTUALIZAR
function EliminarDetalleCompraUpdate(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallescompraupdate').load("funciones.php?MuestraDetallesCompraUpdate=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS EN AGREGAR
function EliminarDetalleCompraAgregar(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallescompraagregar').load("funciones.php?MuestraDetallesCompraAgregar=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR COMPRAS 
function EliminarCompra(codcompra,codproveedor,codsucursal,status,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            if (status=="P") {
            $('#compras').load("consultas.php?CargaCompras=si");
            } else {
            $('#cuentasxpagar').load("consultas?CargaCuentasxPagar=si");
            }
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Compras de Productos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA BUSQUEDA DE COMPRAS POR PROVEEDORES
function BuscarComprasxProveedores(){
                        
$('#muestracomprasxproveedores').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var codproveedor = $("select#codproveedor").val();
var dataString = $("#comprasxproveedores").serialize();
var url = 'funciones.php?BuscaComprasxProvedores=si';


$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracomprasxproveedores').empty();
                $('#muestracomprasxproveedores').append(''+response+'').fadeIn("slow");
             }
      });
}


// FUNCION PARA BUSQUEDA DE COMPRAS POR FECHAS
function BuscarComprasxFechas(){
                        
$('#muestracomprasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#comprasxfechas").serialize();
var url = 'funciones.php?BuscaComprasxFechas=si';


$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracomprasxfechas').empty();
                $('#muestracomprasxfechas').append(''+response+'').fadeIn("slow");
             }
      });
}


//FUNCION PARA BUSQUEDA DE CREDITOS DE COMPRAS POR PROVEEDOR Y FECHAS
function BuscarCreditosxProveedor(){
                  
$('#muestracreditosxproveedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codproveedor = $("#codproveedor").val();
var dataString = $("#creditosxproveedor").serialize();
var url = 'funciones.php?BuscaCreditosxProveedor=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracreditosxproveedor').empty();
                $('#muestracreditosxproveedor').append(''+response+'').fadeIn("slow");
               }
      }); 
}

// FUNCION PARA BUSQUEDA DE CREDITOS DE COMPRAS POR FECHAS
function BuscarCreditosComprasxFechas(){
                        
$('#muestracreditoscomprasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#creditoscomprasxfechas").serialize();
var url = 'funciones.php?BuscaCreditosComprasxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracreditoscomprasxfechas').empty();
                $('#muestracreditoscomprasxfechas').append(''+response+'').fadeIn("slow");
             }
      });
}






















/////////////////////////////////// FUNCIONES DE COTIZACIONES //////////////////////////////////////

// FUNCION PARA BUSCAR COTIZACIONES
$(document).ready(function(){
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bcotizaciones").focus();
    //comprobamos si se pulsa una tecla
    $("#bcotizaciones").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bcotizaciones").val();

      if (consulta.trim() === '') {  

      $("#cotizaciones").html("<center><div class='alert alert-danger'><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BUSQUEDA CORRECTAMENTE</div></center>");
      return false;

      } else {
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaCotizaciones=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#cotizaciones").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#cotizaciones").empty();
            $("#cotizaciones").append(data);
          }
      });
     }
   });                                                               
});

// FUNCION PARA MOSTRAR COTIZACION EN VENTANA MODAL
function VerCotizacion(codcotizacion,codsucursal){

$('#muestracotizacionmodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCotizacionModal=si&codcotizacion='+codcotizacion+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracotizacionmodal').empty();
                $('#muestracotizacionmodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA CARGAR DATOS DE COTIZACION
function ProcesaCotizacion(codcotizacion,codsucursal,codpaciente,busqueda,totalpago) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#procesacotizacion #codcotizacion").val(codcotizacion);
  $("#procesacotizacion #codsucursal").val(codsucursal);
  $("#procesacotizacion #codpaciente").val(codpaciente);
  $("#procesacotizacion #search_paciente").val(busqueda);
  $("#procesacotizacion #txtTotal").val(totalpago);
  $("#procesacotizacion #TextImporte").text(totalpago);
  $("#procesacotizacion #montopagado").val(totalpago);
}

// FUNCION PARA MOSTRAR CONDICIONES DE PAGO
function CargaCondicionesPagosCotizacion(){

var tipopago = $('input:radio[name=tipopago]:checked').val();

    if (tipopago === "CONTADO" || tipopago === true) {
    
    $("#muestra_metodo").html('<div class="row"><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Método de Pago: <span class="symbol required"></span></label><i class="fa fa-bars form-control-feedback"></i><select name="formapago" id="formapago" class="form-control" required="" aria-required="true"><option value=""> -- SELECCIONE -- </option><option value="EFECTIVO">EFECTIVO</option><option value="CHEQUE">CHEQUE</option><option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option><option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option><option value="TARJETA PREPAGO">TARJETA PREPAGO</option><option value="TRANSFERENCIA">TRANSFERENCIA</option><option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option><option value="CUPON">CUPÓN</option><option value="OTROS">OTROS</option></select></div></div><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Monto Recibido: <span class="symbol required"></span></label><input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00"><input class="form-control" type="text" name="montopagado" id="montopagado" autocomplete="off" placeholder="Monto Recibido" onKeyUp="CalculoDevolucionCotizacion();" value="0" required="" aria-required="true"><i class="fa fa-tint form-control-feedback"></i></div></div></div>');

    } else {

    $("#muestra_metodo").html('<div class="row"><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Método de Abono: </label><i class="fa fa-bars form-control-feedback"></i><select name="medioabono" id="medioabono" class="form-control" required="" aria-required="true"><option value=""> -- SELECCIONE -- </option><option value="EFECTIVO">EFECTIVO</option><option value="CHEQUE">CHEQUE</option><option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option><option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option><option value="TARJETA PREPAGO">TARJETA PREPAGO</option><option value="TRANSFERENCIA">TRANSFERENCIA</option><option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option><option value="CUPON">CUPÓN</option><option value="OTROS">OTROS</option></select></div></div><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Monto de Abono: <span class="symbol required"></span></label><input class="form-control number" type="text" name="montoabono" id="montoabono" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText("%f", this);" onBlur="this.value = NumberFormat(this.value, "2", ".", "")" autocomplete="off" placeholder="Ingrese Monto de Abono" value="0" required="" aria-required="true"><i class="fa fa-tint form-control-feedback"></i></div></div></div><div class="row"><div class="col-md-12"><div class="form-group has-feedback"><label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label><input type="text" class="form-control expira" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Vencimiento" aria-required="true"><i class="fa fa-calendar form-control-feedback"></i></div></div></div>');

    } 
}

//FUNCION PARA CALCULADR MONTO DEVOLUCION EN DELIVERY
function CalculoDevolucionCotizacion(){

  alert("fgfwefwefwe");
      
    if ($('input#txtTotal').val()==0.00 || $('input#txtTotal').val()==0) {
              
        $("#montopagado").val("");
        swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA FACTURACIÓN!", "error");
        return false;
   
    } else {
      
      var montototal = $('input#txtTotal').val();
      var montopagado = $('input#montopagado').val();
      var montodevuelto = $('input#montodevuelto').val();
            
      //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
      total=montopagado - montototal;
      var original=parseFloat(total.toFixed(2));

      $("#TextPagado").text(montopagado);
      $("#TextCambio").text((montopagado == "" || montopagado == "0") ? "0.00" : original.toFixed(2));
      $("#montodevuelto").val((montopagado == "" || montopagado == "0") ? "0.00" : original.toFixed(2));
   }
}

// FUNCION PARA ACTUALIZAR COTIZACIONES
function UpdateCotizacion(codcotizacion,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcotizacion?codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES COTIZACIONES EN ACTUALIZAR
function ProcesarCalculoCotizacion(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantidad_"+indice).focus();
        $("#cantidad").css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO DEL TOTAL PARA COMPRA

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00");

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    NetoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });  

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtgravado').val(BaseImpIva1.toFixed(2));
    $('#lblgravado').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtexento').val(BaseImpIva2.toFixed(2));
    $('#lblexento').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#lblsubtotal').text(SubTotal.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}

/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN VENTANA MODAL
function EliminarDetalleCotizacionModal(coddetallecotizacion,codcotizacion,codpaciente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracotizacionmodal').load("funciones.php?BuscaCotizacionModal=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal); 
            $('#cotizaciones').load("consultas.php?CargaCotizaciones=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotización en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotización, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN ACTUALIZAR
function EliminarDetalleCotizacionUpdate(coddetallecotizacion,codcotizacion,codpaciente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallescotizacionupdate').load("funciones.php?MuestraDetallesCotizacionUpdate=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotización en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotización, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR COTIZACIONES 
function EliminarCotizacion(codcotizacion,codpaciente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcotizacion="+codcotizacion+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#cotizaciones').load("consultas.php?CargaCotizaciones=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Cotizaciones, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSQUEDA DE COTIZACIONES POR FECHAS
function BuscarCotizacionesxFechas(){
                        
$('#muestracotizacionesxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#cotizacionesxfechas").serialize();
var url = 'funciones.php?BuscaCotizacionesxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestracotizacionesxfechas').empty();
        $('#muestracotizacionesxfechas').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA BUSCAR COTIZACIONES POR ESPECIALISTA
function BuscarCotizacionesxEspecialista() {
                        
$('#muestracotizacionesxespecialista').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var codsucursal = $("#codsucursal").val();
var codespecialista = $("#codespecialista").val();
var dataString = $("#cotizacionesxespecialista").serialize();
var url = 'funciones.php?BusquedaCotizacionesxEspecialista=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestracotizacionesxespecialista').empty();
          $('#muestracotizacionesxespecialista').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA BUSCAR COTIZACIONES POR PACIENTE
function BuscarCotizacionesxPaciente() {
                        
$('#muestracotizacionesxpaciente').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var codsucursal = $("#codsucursal").val();
var codpaciente = $("#codpaciente").val();
var dataString = $("#cotizacionesxpaciente").serialize();
var url = 'funciones.php?BusquedaCotizacionesxPaciente=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestracotizacionesxpaciente').empty();
          $('#muestracotizacionesxpaciente').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS COTIZADOS
function BuscaProductosCotizados(){
    
$('#muestraproductoscotizados').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#productoscotizados").serialize();
var url = 'funciones.php?BuscaProductoCotizados=si';

    $.ajax({
        type: "GET",
        url: url,
        data: dataString,
        success: function(response) {
            $('#muestraproductoscotizados').empty();
            $('#muestraproductoscotizados').append(''+response+'').fadeIn("slow");
        }
  }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS COTIZADOS POR VENDEDOR
function BuscaCotizacionesxVendedor(){
    
$('#muestracotizacionesxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#cotizacionesxvendedor").serialize();
var url = 'funciones.php?BuscaCotizacionesxVendedor=si';

    $.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {
        $('#muestracotizacionesxvendedor').empty();
        $('#muestracotizacionesxvendedor').append(''+response+'').fadeIn("slow");
      }
  }); 
}
























/////////////////////////////////// FUNCIONES DE CITAS //////////////////////////////////////

// FUNCION PARA BUSCAR CITAS
$(document).ready(function(){
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bcitas").focus();
    //comprobamos si se pulsa una tecla
    $("#bcitas").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bcitas").val();
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaCitas=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#citas").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#citas").empty();
            $("#citas").append(data);
          }
      });
   });                                                               
});

// FUNCION MUESTRA CITAS EN VENTANA MODAL
function VerCita(codcita) {

$('#muestracitasmodal').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var dataString = 'BuscaCitaModal=si&codcita='+codcita;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracitasmodal').empty();
                $('#muestracitasmodal').append(''+response+'').fadeIn("slow");

            }
      });
} 

/////FUNCION PARA CANCELAR CITA 
function CancelarCita(codcita,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Cancelar esta Cita para Odontológia?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  async : false,
                  data: "codcita="+codcita+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "El Registro ha sido Cancelado Exitosamente!", "success");
            $('#ModalAdd').modal('hide');
            $("#deletevento").attr('disabled', true);
            $("#cancelaevento").attr('disabled', true);
            $("#savecitas")[0].reset();
            $("#proceso").val("save");
            $("#cargacalendario").html("");
            $('html, body').animate({scrollTop:800}, 1000); 
            $('#cargacalendario').append('<center><i class="fa fa-spin fa-spinner"></i> Por Favor Espere, Cargando Calendario ......</center>').fadeIn("slow");
            setTimeout(function() {
          $('#cargacalendario').load("calendario?Calendario_Secundario=si");
            }, 100); 
            Cerrar();
                              
          } else if(data==2){ 

            swal("Oops", "Esta Cita no puede ser Cancelada, ya se encuentra Verificada!", "error"); 

          } else {

            swal("Oops", "Usted no tiene Acceso para Cancelar Citas, no tienes este privilegio!", "error"); 
             
            }
          }
      })
  });
}

/////FUNCION PARA ELIMINAR CITA EN CALENDARIO 
function EliminarCita(codcita,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Cita para Odontológia?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  async : false,
                  data: "codcita="+codcita+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "El Registro ha sido Eliminado Exitosamente!", "success");
            $('#ModalAdd').modal('hide');
            $("#deletevento").attr('disabled', true);
            $("#cancelaevento").attr('disabled', true);
            $("#savecitas")[0].reset();
            $("#proceso").val("save");
            $("#cargacalendario").html("");
            $('html, body').animate({scrollTop:800}, 1000); 
            $('#cargacalendario').append('<center><i class="fa fa-spin fa-spinner"></i> Por Favor Espere, Cargando Calendario ......</center>').fadeIn("slow");
            setTimeout(function() {
          $('#cargacalendario').load("calendario?Calendario_Secundario=si");
            }, 100); 
            Cerrar();

          } else if(data==2){ 

              swal("Oops", "Esta Cita no puede ser Eliminada, ya se encentra Verificada!", "error"); 

          } else {

             swal("Oops", "Usted no tiene Acceso para Eliminar Citas, no tienes este privilegio!", "error"); 
             
            }
          }
      })
  });
}

/////FUNCION PARA ELIMINAR CITA EN CONSULTA
function EliminarCitaGeneral(codcita,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Cita para Odontológia?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  async : false,
                  data: "codcita="+codcita+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#citas').load("consultas.php?CargaCitas=si");

          } else if(data==2){ 

              swal("Oops", "Esta Cita no puede ser Eliminada, ya se encentra Verificada!", "error"); 

          } else {

             swal("Oops", "Usted no tiene Acceso para Eliminar Citas, no tienes este privilegio!", "error"); 
             
            }
          }
      })
  });
}


//FUNCION LIMPIAR MODAL DE CITAS 
function Cerrar(){

$("#savecitas")[0].reset();
$("#savecitas #proceso").val("save");
$("#savecitas #codcita").val("");
$("#savecitas #codsucursal").val("");
$("#savecitas #codpaciente").val("");
$("#savecitas #delete").val("");
$("#savecitas #cancelar").val("");
$("#savecitas #codespecialista").val("");
$("#savecitas #search_paciente").val("");
$("#savecitas #descripcion").val("");
$("#savecitas #fechacita").val("");
$("#savecitas #horacita").val("");
$("#savecitas #color").val("");
$("#deletevento").attr('disabled', true);
$("#cancelaevento").attr('disabled', true);

}

//FUNCION LIMPIAR MODAL DE CITAS 
function Limpiar(){

$("#savecitas")[0].reset();
$("#savecitas #proceso").val("save");
$("#savecitas #codcita").val("");
$("#savecitas #codsucursal").val("");
$("#savecitas #delete").val("");
$("#savecitas #cancelar").val("");
$("#savecitas #codespecialista").val("");
$("#savecitas #descripcion").val("");
$("#savecitas #fechacita").val("");
$("#savecitas #horacita").val("");
$("#savecitas #color").val("");
$("#deletevento").attr('disabled', true);
$("#cancelaevento").attr('disabled', true);

}


// FUNCION PARA BUSCAR CITAS POR FECHAS
function BuscarCitasxFechas() {
                        
$('#muestracitasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#citasxfechas").serialize();
var url = 'funciones.php?BusquedaCitasxFechas=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestracitasxfechas').empty();
          $('#muestracitasxfechas').append(''+response+'').fadeIn("slow");

      }
   });
}


// FUNCION PARA BUSCAR CITAS POR ESPECIALISTA
function BuscarCitasxEspecialista() {
                        
$('#muestracitasxespecialista').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var codsucursal = $("#codsucursal").val();
var codespecialista = $("#codespecialista").val();
var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#citasxespecialista").serialize();
var url = 'funciones.php?BusquedaCitasxEspecialista=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestracitasxespecialista').empty();
          $('#muestracitasxespecialista').append(''+response+'').fadeIn("slow");

      }
   });
}

// FUNCION PARA BUSCAR CITAS POR PACIENTE
function BuscarCitasxPaciente() {
                        
$('#muestracitasxpaciente').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var codsucursal = $("#codsucursal").val();
var codpaciente = $("#codpaciente").val();
var dataString = $("#citasxpaciente").serialize();
var url = 'funciones.php?BusquedaCitasxPaciente=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestracitasxpaciente').empty();
          $('#muestracitasxpaciente').append(''+response+'').fadeIn("slow");
      }
  });
}

















/////////////////////////////////// FUNCIONES DE CAJAS DE VENTAS //////////////////////////////////////

// FUNCION PARA MOSTRAR CAJAS DE VENTAS EN VENTANA MODAL
function VerCaja(codcaja){

$('#muestracajamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCajaModal=si&codcaja='+codcaja;

$.ajax({
        type: "GET",
        url: "funciones.php",
        data: dataString,
        success: function(response) {            
          $('#muestracajamodal').empty();
          $('#muestracajamodal').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA ACTUALIZAR CAJAS DE VENTAS
function UpdateCaja(codcaja,nrocaja,nomcaja,codsucursal,codigo,proceso) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savecaja #codcaja").val(codcaja);
  $("#savecaja #nrocaja").val(nrocaja);
  $("#savecaja #nomcaja").val(nomcaja);
  $("#savecaja #codsucursal").val(codsucursal);
  $("#savecaja #codigo").val(codigo);
  $("#savecaja #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR CAJAS DE VENTAS 
function EliminarCaja(codcaja,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Caja para Ventas?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcaja="+codcaja+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#cajas').load("consultas?CargaCajas=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Caja para Venta no puede ser Eliminada, tiene Ventas relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Cajas para Ventas, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA MOSTRAR CAJAS POR SUCURSAL
function CargaCajas(codsucursal){

$('#codcaja').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var dataString = 'BuscaCajasxSucursal=si&codsucursal='+codsucursal;

$.ajax({
        type: "GET",
        url: "funciones.php",
        data: dataString,
        success: function(response) {            
          $('#codcaja').empty();
          $('#codcaja').append(''+response+'').fadeIn("slow");
      }
  });
}


// FUNCION PARA MOSTRAR CAJAS POR SUCURSAL
function CargaCajasAbiertas(codsucursal){

$('#codcaja').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var dataString = 'BuscaCajasAbiertasxSucursal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codcaja').empty();
                $('#codcaja').append(''+response+'').fadeIn("slow");
           }
      });
}





















/////////////////////////////////// FUNCIONES DE ARQUEOS DE CAJAS PARA VENTAS //////////////////////////////////////

// FUNCION PARA MOSTRAR DATOS DE CAJERO PARA COBRAR VENTA
function CargarDatosCajero(){

$('#datos_cajero_cobro').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'MuestraDatosCajeroVenta=si';

$.ajax({
      type: "GET",
      url: "funciones.php",
      data: dataString,
      success: function(response) {            
        $('#datos_cajero_cobro').empty();
        $('#datos_cajero_cobro').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR DATOS DE CAJERO PARA COBRAR VENTA
function CargarDatosCajeroCancelar(){

$('#datos_cajero_cancela').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'MuestraDatosCajeroVenta=si';

$.ajax({
      type: "GET",
      url: "funciones.php",
      data: dataString,
      success: function(response) {            
        $('#datos_cajero_cancela').empty();
        $('#datos_cajero_cancela').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR ARQUEOS DE CAJAS PARA VENTAS EN VENTANA MODAL
function VerArqueo(codarqueo){

$('#muestraarqueomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaArqueoModal=si&codarqueo='+codarqueo;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraarqueomodal').empty();
                $('#muestraarqueomodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA CERRAR ARQUEO DE CAJA
function CerrarCaja(codarqueo) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Realizar el Cierre de Caja?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcierre?codarqueo="+codarqueo;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CERRAR ARQUEO DE CAJA
function CerrarArqueo(codarqueo,nrocaja,responsable,montoinicial,fechaapertura
  ,efectivo,cheque,tcredito,tdebito,tprepago,transferencia,electronico,cupon,otros,creditos,abonosefectivo,abonosotros,ingresosefectivo,ingresosotros,egresos,estimado) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#cerrararqueo #codarqueo").val(codarqueo);
  $("#cerrararqueo #txtcaja").text(nrocaja);
  $("#cerrararqueo #txtnombre").text(responsable);
  $("#cerrararqueo #txtmonto").text(montoinicial);
  $("#cerrararqueo #txtapertura").text(fechaapertura);
  $("#cerrararqueo #efectivo").text(efectivo);
  $("#cerrararqueo #cheque").text(cheque);
  $("#cerrararqueo #tcredito").text(tcredito);
  $("#cerrararqueo #tdebito").text(tdebito);
  $("#cerrararqueo #tprepago").text(tprepago);
  $("#cerrararqueo #transferencia").text(transferencia);
  $("#cerrararqueo #electronico").text(electronico);
  $("#cerrararqueo #cupon").text(cupon);
  $("#cerrararqueo #otros").text(otros);
  $("#cerrararqueo #creditos").text(creditos);
  $("#cerrararqueo #abonosefectivo").text(abonosefectivo);
  $("#cerrararqueo #abonosotros").text(abonosotros);
  $("#cerrararqueo #ingresosefectivo").text(ingresosefectivo);
  $("#cerrararqueo #ingresosotros").text(ingresosotros);
  $("#cerrararqueo #egresos").text(egresos);
  $("#cerrararqueo #estimado").text(estimado);
  $("#cerrararqueo #estimado").val(estimado);
}

//FUNCION PARA CALCULAR LA DIFERENCIA EN CIERRE DE CAJA
$(document).ready(function (){
  $('.cierrecaja').keyup(function (){
      
    var efectivo = $('input#dineroefectivo').val();
    var estimado = $('input#estimado').val();
            
    //REALIZO EL CALCULO DE DIFERENCIA EN CAJA
    total=efectivo - estimado;
    var original=parseFloat(total.toFixed(2));
    $("#diferencia").val((efectivo == "" || efectivo == "0" || efectivo == "0.00") ? "0.00" : original.toFixed(2));
      
  });
});


//FUNCION PARA BUSQUEDA DE ARQUEOS DE CAJAS POR FECHAS
function BuscarArqueosxFechas(){
                  
$('#muestraarqueosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#arqueosxfechas").serialize();
var url = 'funciones.php?BuscaArqueosxFechas=si';

$.ajax({
          type: "GET",
          url: url,
          data: dataString,
          success: function(response) {            
              $('#muestraarqueosxfechas').empty();
              $('#muestraarqueosxfechas').append(''+response+'').fadeIn("slow");
             }
    }); 
}





















/////////////////////////////////// FUNCIONES DE MOVIMIENTOS EN CAJAS DE VENTAS //////////////////////////////////////

// FUNCION PARA MOSTRAR MOVIMIENTO EN CAJAS DE VENTAS EN VENTANA MODAL
function VerMovimiento(codmovimiento){

$('#muestramovimientomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaMovimientoModal=si&codmovimiento='+codmovimiento;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
      success: function(response) {            
        $('#muestramovimientomodal').empty();
        $('#muestramovimientomodal').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA ACTUALIZAR MOVIMIENTOS EN CAJAS DE VENTAS
function UpdateMovimiento(codmovimiento,codcaja,tipomovimiento,descripcionmovimiento,montomovimiento,mediomovimiento,fechamovimiento,codarqueo,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemovimiento #codmovimiento").val(codmovimiento);
  $("#savemovimiento #codcaja").val(codcaja);
  $("#savemovimiento #tipomovimiento").val(tipomovimiento);
  $("#savemovimiento #tipomovimientobd").val(tipomovimiento);
  $("#savemovimiento #descripcionmovimiento").val(descripcionmovimiento);
  $("#savemovimiento #montomovimiento").val(montomovimiento);
  $("#savemovimiento #montomovimientobd").val(montomovimiento);
  $("#savemovimiento #mediomovimiento").val(mediomovimiento);
  $("#savemovimiento #mediomovimientobd").val(mediomovimiento);
  $("#savemovimiento #fecharegistro").val(fechamovimiento);
  $("#savemovimiento #codarqueo").val(codarqueo);
  $("#savemovimiento #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MOVIMIENTOS EN CAJAS DE VENTAS 
function EliminarMovimiento(codmovimiento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Movimiento en Caja para Ventas?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmovimiento="+codmovimiento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#movimientos').load("consultas?CargaMovimientos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Movimiento en Caja para Venta no puede ser Eliminado, se encuentra Desactivado!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Movimiento en Cajas para Ventas, no tienes los privilegios dentro del Sistema o Cajero del Sistema!", "error"); 

                }
            }
        })
    });
}

//FUNCION PARA BUSQUEDA DE MOVIMIENTOS DE CAJAS POR FECHAS
function BuscarMovimientosxFechas(){
                  
$('#muestramovimientosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#movimientosxfechas").serialize();
var url = 'funciones.php?BuscaMovimientosxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestramovimientosxfechas').empty();
                $('#muestramovimientosxfechas').append(''+response+'').fadeIn("slow");
               }
      }); 
}


























/////////////////////////////////// FUNCIONES DE ODONTOLOGIA //////////////////////////////////////

// FUNCION PARA BUSQUEDA DE CITAS POR DIA
function BuscarCitasxDia(){
                        
$('#muestracitasxdia').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var codespecialista = $("#codespecialista").val();
var fecha = $("#fecha").val();
var dataString = $("#buscar").serialize();
var url = 'funciones.php?BuscaCitasxDia=si';


$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracitasxdia').empty();
                $('#muestracitasxdia').append(''+response+'').fadeIn("slow");
             }
      });
}


// FUNCION PARA ASIGNAR CITA EN ODONTOLOGIA
function AsignaCita(codsucursal,codcita,cita,codespecialista,codpaciente,paciente,cedpaciente,nompaciente,apepaciente,sexopaciente,
  gruposapaciente,ocupacionpaciente,estadopaciente,fnacpaciente,tlfpaciente,direcpaciente,nomacompana,parentescoacompana) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveodontologia #codcita").val(codcita);
  $("#saveodontologia #cita").val(cita);
  $("#saveodontologia #codespecialista").val(codespecialista);
  $("#saveodontologia #codpaciente").val(codpaciente);
  $("#saveodontologia #paciente").val(paciente);
  $("#saveodontologia #cedpaciente").val(cedpaciente);
  $("#saveodontologia #nompaciente").val(nompaciente);
  $("#saveodontologia #apepaciente").val(apepaciente);
  $("#saveodontologia #sexopaciente").val(sexopaciente);
  $("#saveodontologia #gruposapaciente").val(gruposapaciente);
  $("#saveodontologia #ocupacionpaciente").val(ocupacionpaciente);
  $("#saveodontologia #estadopaciente").val(estadopaciente);
  $("#saveodontologia #fnacpaciente").val(fnacpaciente);
  $("#saveodontologia #tlfpaciente").val(tlfpaciente);
  $("#saveodontologia #direcpaciente").val(direcpaciente);
  $("#saveodontologia #nomacompana").val(nomacompana);
  $("#saveodontologia #parentescoacompana").val(parentescoacompana);
  $("#guarda").attr('disabled', false);
  $("#agrega").attr('disabled', false);
  $("#btn-submit").attr('disabled', false);
  $("#buttonpago").attr('disabled', false);
  $("#muestrahistorial").load("funciones.php?BuscaHistorialPaciente=si&codpaciente="+codpaciente+"&codsucursal="+codsucursal);
  $("#divTratamiento").load("funciones.php?BuscaTablaTratamiento=si&codcita="+codcita+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal);
  cargarDientes('seccionDientes', 'dientes.php', '', codcita, codpaciente, codsucursal); 
}

//FUNCIONES PARA CARGAR FOTO
function CargaFoto(){

  $("#foto").attr("src","fotos/img.png");
}


//FUNCIONES PARA ACTIVAR-DESACTIVAR TRATAMIENTO MEDICO
function ActivaTratamiento(tratamiento){

  if (tratamiento != "SI" || tratamiento === true) {
         
    // habilitamos
    $("#cualestratamiento").attr('disabled', true);

    } else {

    // deshabilitamos
    $("#cualestratamiento").attr('disabled', false);
  } 
}

//FUNCIONES PARA ACTIVAR-DESACTIVAR CUALES MEDICAMENTOS
function ActivaMedicamento(medicamento){

  if (medicamento != "SI" || medicamento === true) {
         
    // habilitamos
    $("#cualesingesta").attr('disabled', true);

    } else {

    // deshabilitamos
    $("#cualesingesta").attr('disabled', false);
  } 
}


//FUNCIONES PARA ACTIVAR-DESACTIVAR CUALES ALERGIAS
function ActivaAlergias(alergia){

  if (alergia != "SI" || alergia === true) {
         
    // habilitamos
    $("#cualesalergias").attr('disabled', true);

    } else {

    // deshabilitamos
    $("#cualesalergias").attr('disabled', false);
  } 
}


//FUNCIONES PARA ACTIVAR-DESACTIVAR CUALES HEMORRAGIAS
function ActivaHemorragia(hemorragia){

  if (hemorragia != "SI" || hemorragia === true) {
         
    // habilitamos
    $("#cualeshemorragias").attr('disabled', true);

    } else {

    // deshabilitamos
    $("#cualeshemorragias").attr('disabled', false);
  } 
}


//FUNCIONES PARA ACTIVAR-DESACTIVAR ASISTENCIA ODONTOLOGO
function ActivaAsistencia(asistencia){

  if (asistencia != "SI" || asistencia === true) {
         
    // habilitamos
    $("#ultimavisitaodontologia").attr('disabled', true);

    } else {

    // deshabilitamos
    $("#ultimavisitaodontologia").attr('disabled', false);
  } 
}


//FUNCIONES PARA ACTIVAR-DESACTIVAR CEPILLADO DIARIO
function ActivaCepillado(cepillado){

  if (cepillado != "SI" || cepillado === true) {
         
    // habilitamos
    $("#cuantoscepillados").attr('disabled', true);

    } else {

    // deshabilitamos
    $("#cuantoscepillados").attr('disabled', false);
  } 
}


//FUNCIONES PARA ACTIVAR-DESACTIVAR SEDA DENTAL
function ActivaSeda(seda){

  if (seda != "SI" || seda === true) {
         
    // habilitamos
    $("#cuantascedasdental").attr('disabled', true);

    } else {

    // deshabilitamos
    $("#cuantascedasdental").attr('disabled', false);
  } 
}


/////FUNCION PARA ELIMINAR REFERENCIA EN ODONTOGRAMA 
function EliminarReferencia(codreferencia,codcita,codpaciente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Referencia del Odontograma?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codreferencia="+codreferencia+"&codcita="+codcita+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $("#divTratamiento").load("funciones.php?BuscaTablaTratamiento=si&codcita="+codcita+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal);
            cargarDientes('seccionDientes', 'dientes.php', '', codcita, codpaciente, codsucursal);
            //$("#seccionDientes").load("funciones.php?BuscaOdontograma=si&codpaciente="+codpaciente);
            //$("#divTratamiento").load("funciones.php?BuscaTablaTratamiento=si&codpaciente="+codpaciente);
            //$('#tablaTratamiento').load("funciones?BuscaTablaTratamiento=si&codpaciente="+codpaciente);

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Referencias, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR ODONTOLOGIA EN VENTANA MODAL
function VerOdontologia(cododontologia,codsucursal){

$('#muestraodontologiamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaOdontologiaModal=si&cododontologia='+cododontologia+"&codsucursal="+codsucursal;

$.ajax({
        type: "GET",
        url: "funciones.php",
        data: dataString,
          success: function(response) {            
            $('#muestraodontologiamodal').empty();
            $('#muestraodontologiamodal').append(''+response+'').fadeIn("slow");   
      }
  });
}

// FUNCION PARA BUSCAR ODONTOLOGIA
$(document).ready(function(){
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bodontologias").focus();
    //comprobamos si se pulsa una tecla
    $("#bodontologias").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bodontologias").val();

      if (consulta.trim() === '') {  

      $("#odontologias").html("<center><div class='alert alert-danger'><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BUSQUEDA CORRECTAMENTE</div></center>");
      return false;

      } else {
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaOdontologias=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#odontologias").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#odontologias").empty();
            $("#odontologias").append(data);
          }
      });
     }
   });                                                               
});

// FUNCION PARA ACTUALIZAR ODONTOLOGIA
function UpdateOdontologia(codcita,cododontologia,codpaciente,codsucursal) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Consulta Odontologica?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forodontologia?cododontologia="+cododontologia+"&codsucursal="+codsucursal;
      $("#muestrahistorial").load("funciones.php?BuscaHistorialPaciente=si&codpaciente="+codpaciente+"&codsucursal="+codsucursal);
      $("#divTratamiento").load("funciones.php?BuscaTablaTratamiento=si&codcita="+codcita+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal);
      cargarDientes('seccionDientes', 'dientes.php', '', codcita, codpaciente,codsucursal);
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

/////FUNCION PARA ELIMINAR ODONTOLOGIA 
function EliminarOdontologia(codcita,cododontologia,codpaciente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Consulta Odontologica?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcita="+codcita+"&cododontologia="+cododontologia+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

         if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#odontologias').load("consultas?CargaOdontologias=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Consulta Odontologica no puede ser Eliminada, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Consulta Odontologicas, no tienes Privilegios para ejecutar esta Acción!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSCAR ODONTOLOGIA POR FECHAS
function BuscarOdontologiaxFechas() {
                        
$('#muestraodontologiaxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#odontologiaxfechas").serialize();
var url = 'funciones.php?BusquedaOdontologiaxFechas=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestraodontologiaxfechas').empty();
          $('#muestraodontologiaxfechas').append(''+response+'').fadeIn("slow");
    }
  });
}


// FUNCION PARA BUSCAR ODONTOLOGIA POR ESPECIALISTA
function BuscarOdontologiaxEspecialista() {
                        
$('#muestraodontologiaxespecialista').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var codsucursal = $("#codsucursal").val();
var codespecialista = $("#codespecialista").val();
var desde = $("#desde").val();
var hasta = $("#hasta").val();
var dataString = $("#odontologiaxespecialista").serialize();
var url = 'funciones.php?BusquedaOdontologiaxEspecialista=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestraodontologiaxespecialista').empty();
          $('#muestraodontologiaxespecialista').append(''+response+'').fadeIn("slow");
      }
  });
}


// FUNCION PARA BUSCAR ODONTOLOGIA POR PACIENTE
function BuscarOdontologiaxPaciente() {
                        
$('#muestraodontologiaxpaciente').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var codsucursal = $("#codsucursal").val();
var codpaciente = $("#codpaciente").val();
var dataString = $("#odontologiaxpaciente").serialize();
var url = 'funciones.php?BusquedaOdontologiaxPaciente=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestraodontologiaxpaciente').empty();
          $('#muestraodontologiaxpaciente').append(''+response+'').fadeIn("slow");
      }
  });
}























/////////////////////////////////// FUNCIONES DE CONSENTIMIENTO INFORMADO //////////////////////////////////////

// FUNCION PARA BUSQUEDA PACIENTE PARA CONSENTIMIENTO
function BuscarPacienteConsentimiento(){
                        
$('#muestraconsentimiento').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var codpaciente = $("#codpaciente").val();
var codespecialista = $("#codespecialista").val();
var dataString = $("#saveconsentimiento").serialize();
var url = 'funciones.php?BuscaConsentimientoInformado=si';


$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraconsentimiento').empty();
                $('#muestraconsentimiento').append(''+response+'').fadeIn("slow");
             }
      });
}

// FUNCION PARA BUSCAR CONSENTIMIENTO INFORMADO
$(document).ready(function(){
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bconsentimientos").focus();
    //comprobamos si se pulsa una tecla
    $("#bconsentimientos").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bconsentimientos").val();

      if (consulta.trim() === '') {  

      $("#consentimientos").html("<center><div class='alert alert-danger'><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BUSQUEDA CORRECTAMENTE</div></center>");
      return false;

      } else {
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaConsentimientos=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#consentimientos").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#consentimientos").empty();
            $("#consentimientos").append(data);
          }
      });
     }
   });                                                               
});

// FUNCION PARA ACTUALIZAR CONSENTIMIENTO INFORMADO
function UpdateConsentimiento(codconsentimiento,codsucursal) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Consentimiento Informado?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forconsentimiento?codconsentimiento="+codconsentimiento+"&codsucursal="+codsucursal;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

/////FUNCION PARA ELIMINAR CONSENTIMIENTO INFORMADO 
function EliminarConsentimiento(codconsentimiento,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Consentimiento Informado?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#2f323e',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codconsentimiento="+codconsentimiento+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#consentimientos').load("consultas?CargaConsentimientos=si");
                  
           } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Consentimiento Informado, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}



















/////////////////////////////////// FUNCIONES DE VENTAS //////////////////////////////////////

// FUNCION PARA COBRAR VENTAS EN VENTANA MODAL
function CobrarVenta(idventa,codventa,codsucursal,totalpago,codpaciente,cedpaciente,nompaciente,observaciones){

$("#cobrarventa #idventa").val(idventa);
$("#cobrarventa #codventa").val(codventa);
$("#cobrarventa #codsucursal").val(codsucursal);
$("#cobrarventa #txtTotal").val(totalpago);
$("#cobrarventa #txtTotal").text(totalpago);
$("#cobrarventa #codpaciente").val(codpaciente);
$("#cobrarventa #txtdocumento").text(cedpaciente);
$("#cobrarventa #txtpaciente").text(nompaciente);
$("#cobrarventa #observaciones").val(observaciones);

}

// FUNCION PARA CERRAR MODAL DE COBRAR VENTAS
function CerrarCobro(){

  $("#cobrarventa")[0].reset();
  $("#idventa").val("");
  $("#codventa").val("1");
  $("#codsucursal").val("");
  $("#txtTotal").val("");
  $("#muestra_metodo").html('<div class="row"><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Método de Pago: <span class="symbol required"></span></label><i class="fa fa-bars form-control-feedback"></i><select name="formapago" id="formapago" class="form-control" required="" aria-required="true"><option value=""> -- SELECCIONE -- </option><option value="EFECTIVO">EFECTIVO</option><option value="CHEQUE">CHEQUE</option><option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option><option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option><option value="TARJETA PREPAGO">TARJETA PREPAGO</option><option value="TRANSFERENCIA">TRANSFERENCIA</option><option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option><option value="CUPON">CUPÓN</option><option value="OTROS">OTROS</option></select></div></div><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Monto Recibido: <span class="symbol required"></span></label><input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00"><input class="form-control" type="text" name="montopagado" id="montopagado" autocomplete="off" placeholder="Monto Recibido" onKeyUp="CalculoDevolucion();" value="0" required="" aria-required="true"><i class="fa fa-tint form-control-feedback"></i></div></div></div>');    

}

// FUNCION PARA BUSCAR VENTAS
$(document).ready(function(){
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bventas").focus();
    //comprobamos si se pulsa una tecla
    $("#bventas").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bventas").val();

      if (consulta.trim() === '') {  

      $("#ventas").html("<center><div class='alert alert-danger'><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BUSQUEDA CORRECTAMENTE</div></center>");
      return false;

      } else {
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaVentas=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#ventas").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#ventas").empty();
            $("#ventas").append(data);
          }
      });
     }
   });                                                               
});

// FUNCION PARA MOSTRAR VENTA EN VENTANA MODAL
function VerVenta(codventa,codsucursal){

$('#muestraventamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaVentaModal=si&codventa='+codventa+"&codsucursal="+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraventamodal').empty();
                $('#muestraventamodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR VENTAS
function UpdateVenta(codventa,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Factura?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forfacturacion?codventa="+codventa+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES VENTAS EN ACTUALIZAR
function ProcesarCalculoVenta(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantidad_"+indice).focus();
        $("#cantidad").css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO DEL TOTAL PARA COMPRA

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00");

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    NetoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });  

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtgravado').val(BaseImpIva1.toFixed(2));
    $('#lblgravado').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtexento').val(BaseImpIva2.toFixed(2));
    $('#lblexento').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#lblsubtotal').text(SubTotal.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}

/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN VENTANA MODAL
function EliminarDetalleVentaModal(coddetalleventa,codventa,codpaciente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Factura?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestraventamodal').load("funciones.php?BuscaVentaModal=si&codventa="+codventa+"&codsucursal="+codsucursal); 
            $('#ventas').load("consultas.php?CargaVentas=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Factura en este Módulo, realice la Eliminación completa de la Factura!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Factura, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN ACTUALIZAR
function EliminarDetalleVentaUpdate(coddetalleventa,codventa,codpaciente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Factura?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallesventaupdate').load("funciones.php?MuestraDetallesVentaUpdate=si&codventa="+codventa+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Factura en este Módulo, realice la Eliminación completa de la Factura!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Factura, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR VENTAS 
function EliminarVenta(codventa,codpaciente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codventa="+codventa+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#ventas').load("consultas.php?CargaVentas=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Factura, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

//FUNCION PARA BUSQUEDA DE VENTAS POR CAJAS Y FECHAS
function BuscarVentasxCajas(){
                  
$('#muestraventasxcajas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxcajas").serialize();
var url = 'funciones.php?BuscaVentasxCajas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestraventasxcajas').empty();
        $('#muestraventasxcajas').append(''+response+'').fadeIn("slow");
      }
  }); 
}

// FUNCION PARA BUSQUEDA DE VENTAS POR FECHAS
function BuscarVentasxFechas(){
                        
$('#muestraventasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxfechas").serialize();
var url = 'funciones.php?BuscaVentasxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestraventasxfechas').empty();
        $('#muestraventasxfechas').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA BUSCAR VENTAS POR ESPECIALISTA
function BuscarVentasxEspecialista() {
                        
$('#muestraventasxespecialista').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var codsucursal = $("#codsucursal").val();
var codespecialista = $("#codespecialista").val();
var dataString = $("#ventasxespecialista").serialize();
var url = 'funciones.php?BusquedaVentasxEspecialista=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestraventasxespecialista').empty();
          $('#muestraventasxespecialista').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA BUSCAR VENTAS POR PACIENTE
function BuscarVentasxPaciente() {
                        
$('#muestraventasxpaciente').html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando información ......</center>');

var codsucursal = $("#codsucursal").val();
var codpaciente = $("#codpaciente").val();
var dataString = $("#ventasxpaciente").serialize();
var url = 'funciones.php?BusquedaVentasxPaciente=si';

$.ajax({
      type: "GET",
      url: url,
      data: dataString,
      success: function(response) {            
          $('#muestraventasxpaciente').empty();
          $('#muestraventasxpaciente').append(''+response+'').fadeIn("slow");
      }
  });
}
















/////////////////////////////////// FUNCIONES DE CREDITOS //////////////////////////////////////

// FUNCION PARA MOSTRAR VENTA DE CREDITO EN VENTANA MODAL
function VerCredito(codventa,codsucursal){

$('#muestracreditomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCreditoModal=si&codventa='+codventa+"&codsucursal="+codsucursal;

$.ajax({
        type: "GET",
        url: "funciones.php",
        data: dataString,
        success: function(response) {            
          $('#muestracreditomodal').empty();
          $('#muestracreditomodal').append(''+response+'').fadeIn("slow");
        }
  });
}

// FUNCION PARA ABONAR PAGO A CREDITOS
function AbonoCredito(codsucursal,codpaciente,codventa,totaldebe,cedpaciente,paciente,codfactura,totalfactura,fechaventa,totalabono,debe) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savepago #codsucursal").val(codsucursal);
  $("#savepago #codpaciente").val(codpaciente);
  $("#savepago #codventa").val(codventa);
  $("#savepago #totaldebe").val(totaldebe);
  $("#savepago #cedpaciente").val(cedpaciente);
  $("#savepago #paciente").val(paciente);
  $("#savepago #codfactura").val(codfactura);
  $("#savepago #totalfactura").val(totalfactura);
  $("#savepago #fechaventa").val(fechaventa);
  $("#savepago #abono").val(totalabono);
  $("#savepago #totalabono").val(totalabono);
  $("#savepago #debe").val(debe);
}

// FUNCION PARA BUSQUEDA DE CREDITOS POR FECHAS
function BuscarCreditosxFechas(){
                        
$('#muestracreditosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#creditosxfechas").serialize();
var url = 'funciones.php?BuscaCreditosxFechas=si';

$.ajax({
        type: "GET",
        url: url,
        data: dataString,
        success: function(response) {            
          $('#muestracreditosxfechas').empty();
          $('#muestracreditosxfechas').append(''+response+'').fadeIn("slow");
      }
  });
}

//FUNCION PARA BUSQUEDA DE CREDITOS POR PACIENTES Y FECHAS
function BuscarCreditosxPacientes(){
                  
$('#muestracreditosxpacientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codpaciente = $("#codpaciente").val();
var dataString = $("#creditosxpacientes").serialize();
var url = 'funciones.php?BuscaCreditosxPacientes=si';

$.ajax({
        type: "GET",
        url: url,
        data: dataString,
        success: function(response) {            
          $('#muestracreditosxpacientes').empty();
          $('#muestracreditosxpacientes').append(''+response+'').fadeIn("slow");
      }
  }); 
}

//FUNCION PARA BUSQUEDA DE CREDITOS POR PACIENTES Y FECHAS
function BuscarDetallesCreditosxPacientes(){
                  
$('#muestradetallescreditosxpacientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codpaciente = $("#codpaciente").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallescreditosxpacientes").serialize();
var url = 'funciones.php?BuscaDetallesCreditosxPacientes=si';

$.ajax({
        type: "GET",
        url: url,
        data: dataString,
        success: function(response) {            
          $('#muestradetallescreditosxpacientes').empty();
          $('#muestradetallescreditosxpacientes').append(''+response+'').fadeIn("slow");
      }
  }); 
}
