/*Author: Ing. Ruben D. Chirinos R. Tlf: +58 0414-7225970, email: elsaiya@gmail.com

/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/
$('document').ready(function() {
						   
	 $("#formlogin").validate({
      rules:
	  {
			usuario: { required: true },
			password: { required: true },
			tipo: { required: true },
	   },
       messages:
	   {
		    usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Clave de Acceso" },
			tipo:{ required: "Seleccione Tipo Ingreso" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#formlogin").serialize();
				
			$.ajax({
			type : 'POST',
			url  : 'index.php',
			async : false,
			data : data,
			beforeSend: function()
			{	
				$("#login").fadeOut();
				$("#btn-login").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
			   {						
				if(data==1){ 
								 
				    $("#login").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				    
					        });
			   
	            } else if(data==2){
									 
					$("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL USUARIO INGRESADO NO FUE ENCONTRADO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				            }); 
			   
				} else if(data==3){
									 
				    $("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE USUARIO SE ENCUENTRA ACTUALMENTE INACTIVO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				            }); 
			   
				} else if(data==4){
									 
				    $("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO TIENE UN HORARIO DE INGRESO ASIGNADO POR LOS ADMINISTRADORES, DIRIJASE AL ADMINISTRADOR DEL SISTEMA PARA QUE LE ASIGNE...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				            });
			   
				} else if(data==5){
									 
				    $("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO PUEDE INGRESAR AL SISTEMA FUERA DEL HORARIO ASIGNADO POR LOS ADMINISTRADORES, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				            }); 
			   
				} else if(data==6){
									 
					$("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL PASSWORD INGRESADO NO FUE ENCONTRADO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				           }); 
			   
				} else if(data==7){
									 
					$("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> HA OCURRIDO UN ERROR EN EL PROCESAMIENTO DE LA INFORMACION, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				    });
				
				} else {
									
                $("#login").fadeIn(1000, function(){
                $('#myModal').modal('hide');
				$("#formlogin")[0].reset();
				setTimeout(' window.location.href = "panel"; ',100);
				$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				         });  
					}
			   }
		 });
				return false;
		}
	   /* login submit */
    }); 
});
/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/


/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/
$('document').ready(function()
{ 
						   
	 $("#lockscreen").validate({
      rules:
	  {
			usuario: { required: true },
			password: { required: true },
	   },
       messages:
	   {
		    usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Clave de Acceso" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#lockscreen").serialize();
				
			$.ajax({
			type : 'POST',
			url  : 'lockscreen.php',
			async : false,
			data : data,
			beforeSend: function()
			{	
				$("#login").fadeOut();
				$("#btn-login").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(response)
			   {						
				if(response==1){ 
								 
					$("#login").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				    
					        });
			   
	            } else if(response==2){
									 
					$("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LOS DATOS INGRESADOS NO EXISTEN, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				            });
			   
				} else if(response==3){
									 
					$("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE USUARIO SE ENCUENTRA ACTUALMENTE INACTIVO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				            }); 
			   
				} else if(data==4){
									 
				    $("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO TIENE UN HORARIO DE INGRESO ASIGNADO POR LOS ADMINISTRADORES, DIRIJASE AL ADMINISTRADOR DEL SISTEMA PARA QUE LE ASIGNE...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				            });
			   
				} else if(data==5){
									 
				    $("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO PUEDE INGRESAR AL SISTEMA FUERA DEL HORARIO ASIGNADO POR LOS ADMINISTRADORES, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				            }); 
			   
				} else if(data==6){
									 
					$("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL PASSWORD INGRESADO NO FUE ENCONTRADO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				           }); 
			   
				} else if(data==7){
									 
					$("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> HA OCURRIDO UN ERROR EN EL PROCESAMIENTO DE LA INFORMACION, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 
				    });
				
				} else {
									  
					$("#login").fadeIn(1000, function(){
				
				 $("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				 setTimeout(' window.location.href = "panel"; ',500);
				 
				            });  
					}
			   }
		 });
				return false;
	 }
	   /* login submit */
    }); 
});
/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/



/* FUNCION JQUERY PARA RECUPERAR CONTRASEÑA DE USUARIOS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#formrecover").validate({
      rules:
	  {
			email: { required: true,  email: true  },
			tipo: { required: true },
	   },
       messages:
 	   {
			email:{ required: "Ingrese su Correo Electronico", email: "Ingrese un Correo Electronico Valido" },
			tipo:{ required: "Seleccione Tipo Ingreso" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#formrecover").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'index.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#recover").fadeOut();
					$("#btn-recuperar").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#recover").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Password');
				    
					                                                 });																			
								}
								else if(data==2)
								{
									
					$("#recover").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL CORREO INGRESADO NO FUE ENCONTRADO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Password');
				    
					                                                 });
					
								}
								else if(data==3)
								{
									
					$("#recover").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LA NUEVA CLAVE DE ACCESO NO PUDO SER ENVIADA A SU CORREO, INTENTE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Password');
				    
					                                                 });
					
								} else {
										
									$("#recover").fadeIn(1000, function(){
										
				$("#formrecover")[0].reset();
				 var n = noty({
				 text: '<center> &nbsp; '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
				 $("#btn-recuperar").html('<span class="fa fa-check-square-o"></span> Recuperar Password');	
				                                
												                      });
								       }
						   }
				});
			 return false;
		}
	   /* form submit */
    }); 
});
/*  FUNCION PARA RECUPERAR CONTRASEÑA DE USUARIOS */
 
 
/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASEÑA */	 
$('document').ready(function()
{ 						
     /* validation */
	 $("#updatepassword").validate({
      rules:
	  {
			usuario: {required: true },
			password: {required: true, minlength: 8},  
            password2:   {required: true, minlength: 8, equalTo: "#txtPassword"}, 
	   },
       messages:
	   {
            usuario:{ required: "Ingrese Usuario de Acceso" },
            password:{ required: "Ingrese su Nuevo Password", minlength: "Ingrese 8 caracteres como minimo" },
		    password2:{ required: "Repita su Nuevo Password", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#updatepassword").serialize();
				var id= $("#updatepassword").attr("data-id");
		        var codigo = id;
				
				$.ajax({
				type : 'POST',
				url  : 'password.php?codigo='+codigo,
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
						$("#save").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
				    
					                                                 });									
																				
								}
								else if(data==2)
								{
									
					    $("#save").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO PUEDE USAR LA CLAVE ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
			     $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
				    
					                                                 });
					
								} else {
										
						$("#save").fadeIn(1000, function(){
										
				 
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
				 $("#updatepassword")[0].reset();
				 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');	
				 setTimeout(' window.location.href = "logout"; ',5000);
				 
												                      });									
								             }
						    }
				});
				return false;
		}
	   /* form submit */
    }); 
});
 /*  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASEÑA */

/*  FUNCION PARA ENVIAR MENSAJE EN FORMULARIO DE CONTACTO */	 
$('document').ready(function()
{ 
     /* validation */
	$("#formcontact").validate({
      rules:
	  {
			name: { required: true },
			phone: { required: true },
			email: { required: true,  email: true  },
			subject: { required: true },
			message: { required: true },
	   },
       messages:
 	   {
			name:{ required: "Ingrese su Nombre" },
			phone: { required: "Ingrese N&deg; de Tel&eacute;fono" },
			email:{ required: "Ingrese su Email", email: "Ingrese un Email Valido" },
			subject:{ required: "Ingrese Asunto" },
			message:{ required: "Ingrese Mensaje" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#formcontact").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'index.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#msj_contact").fadeOut();
				$("#btn-contact").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#msj_contact").fadeIn(1000, function(){ 
		
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'error',
             timeout: 5000 });
		     $("#btn-contact").html('<span class="fa fa-send"></span> Enviar Mensaje');
			    
				         });																			
					}
					else if(data==2)
					{
								
				$("#msj_contact").fadeIn(1000, function(){ 
		
			 var n = noty({
             text: "<span class='fa fa-warning'></span> EL MENSAJE NO HA PODIDO SER ENVIADO, VERIFIQUE E INTENTE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'error',
             timeout: 5000 });
		     $("#btn-contact").html('<span class="fa fa-send"></span> Enviar Mensaje');
			    
				        });
				
					}
				else {
									
				$("#msj_contact").fadeIn(1000, function(){
									
			$("#formcontact")[0].reset();
			 var n = noty({
			 text: '<center> &nbsp; '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
			 $("#btn-contact").html('<span class="fa fa-send"></span> Enviar Mensaje');	
			                                
								});
							}
					   }
				});
			 return false;
		}
	   /* form submit */
    }); 
});
/*  FUNCION PARA ENVIAR MENSAJE EN FORMULARIO DE CONTACTO */
















/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION GENERAL */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#configuracion").validate({
      rules:
	  {
			documsucursal: { required: false },
			cuitsucursal: { required: true },
			nomsucursal: { required: true },
			tlfsucursal: { required: true,  digits : false },
			correosucursal: { required: true,  email : true },
			id_departamento: { required: true },
			id_provincia: { required: true },
			direcsucursal: { required: true },
			documencargado: { required: true },
			dniencargado: { required: true },
			nomencargado: { required: true, lettersonly: true },
			tlfencargado: { required: true,  digits : false },
			pagina_web: { required: false, url: true },
	    },
        messages:
	    {
            documsucursal:{ required: "Seleccione Tipo de Documento" },
            cuitsucursal:{ required: "Ingrese N&deg; de Empresa" },
			nomsucursal:{ required: "Ingrese Raz&oacute;n Social" },
			tlfsucursal: { required: "Ingrese N&deg; de Tel&eacute;fono de Empresa", digits: "Ingrese solo digitos para Tel&eacute;fono" },
			correosucursal: { required: "Ingrese Email de Empresa", email: "Ingrese un Correo v&aacute;lido" },
			id_departamento:{ required: "Seleccione Departamento" },
			id_provincia:{ required: "Seleccione Provincia" },
			direcsucursal: { required: "Ingrese Direcci&oacute;n de Empresa" },
			documencargado:{ required: "Seleccione Tipo de Documento" },
            dniencargado: { required: "Ingrese N&deg; de Documento de Encargado" },
			nomencargado:{ required: "Ingrese Nombre de Encargado", lettersonly: "Ingrese solo letras para Nombres" },
			tlfencargado: { required: "Ingrese N&deg; de Tel&eacute;fono de Encargado", digits: "Ingrese solo digitos para Tel&eacute;fono" },
			pagina_web:{ required: "Ingrese Url de Pagina Web", url: "Ingrese un Dirección de Url V&aacute;lida" },
	    },
	   submitHandler: function(form) {
                     		
				var data = $("#configuracion").serialize();
				var formData = new FormData($("#configuracion")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'configuracion.php',
			    async : false,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
				contentType: false,
				processData: false,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
						$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000 });
				 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
				 
				                                                      }); 
																				
								} else { 
								     
						$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'success',
                 timeout: 5000 });
				 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');	
				                                
												                      });
							    }
					    }
			    });
		  return false;
	  }
	  /* form submit */	 
    });   
});
/*  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION GENERAL */
 
















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE USUARIOS */	 
$('document').ready(function()
{ 
        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

     /* validation */
	 $("#saveuser").validate({
      rules:
	  {
			dni: { required: true,  digits : true, minlength: 7 },
			nombres: { required: true, lettersonly: true },
			sexo: { required: true },
			direccion: { required: true },
			telefono: { required: true },
			email: { required: true, email: true },
			cargo: { required: true },
			usuario: { required: true },
			password: {required: true, minlength: 8},  
            password2:   {required: true, minlength: 8, equalTo: "#password"}, 
			nivel: { required: true },
			status: { required: true },
			codsucursal: { required: true },
	   },
       messages:
	   {
            dni:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos para N&deg; de Documento", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
			nombres:{ required: "Ingrese Nombre de Usuario", lettersonly: "Ingrese solo letras para Nombres" },
            sexo:{ required: "Seleccione Sexo de Usuario" },
            direccion:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
            telefono:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			email:{ required: "Ingrese Email de Usuario", email: "Ingrese un Email V&aacute;lido" },
			cargo:{ required: "Ingrese Cargo de Usuario" },
			usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Password de Acceso", minlength: "Ingrese 8 caracteres como m&iacute;nimo" },
		    password2:{ required: "Repita Password de Acceso", minlength: "Ingrese 8 caracteres como m&iacute;nimo", equalTo: "Este Password no coincide" },
			nivel:{ required: "Seleccione Nivel de Acceso" },
			status:{ required: "Seleccione Status de Acceso" },
			codsucursal:{ required: "Seleccione Sucursal" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#saveuser").serialize();
				var formData = new FormData($("#saveuser")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'usuarios.php',
			    async : false,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}    
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> DEBE DE ASIGNARLE UNA SUCURSAL A ESTE USUARIO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}  
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE UN USUARIO CON ESTE N&deg; DE DNI, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else if(data==4){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE CORREO ELECTR&Oacute;NICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
											
									});
								}
								else if(data==5)
								{
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE USUARIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
                 $('#myModalUser').modal('hide');
				 $("#saveuser")[0].reset();
                 $("#proceso").val("save");	
                 $("#codigo").val("");
                 $("#muestrasucursales").html("");	
				 $('#usuarios').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#usuarios').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#usuarios').load("consultas?CargaUsuarios=si");
				 }, 200);

									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE USUARIOS */














/* FUNCION JQUERY PARA VALIDAR REGISTRO DE HORARIO DE USUARIOS */	 
$('document').ready(function()
{ 
        /* validation */
	    $("#savehorariosusuario").validate({
        rules:
	    {
			codigo: { required: true },
			hora_desde: { required: true },
			hora_hasta: { required: true },
	    },
        messages:
	    {
            codigo:{ required: "Seleccione Usuario" },
            hora_desde:{ required: "Ingrese Hora Desde" },
            hora_hasta:{ required: "Ingrese Hora Hasta" },
        },
	    submitHandler: function(form) {
	   			
			var data = $("#savehorariosusuario").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'horarios_usuarios.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}   
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA ESTE USUARIO TIENE UN HORARIO ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
			 $("#savehorariosusuario")[0].reset();
             $("#proceso").val("save");	
			 $('#codhorario').val("");
			 $('#horarios').html("");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
			 $('#horarios').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#horarios').load("consultas?CargaHorariosUsuarios=si");
			 }, 200);
									
							});
						}
				   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE HORARIO DE USUARIOS */














/* FUNCION JQUERY PARA VALIDAR REGISTRO DE HORARIO DE ESPECIALISTAS */	 
$('document').ready(function()
{ 
        /* validation */
	    $("#savehorariosespecialista").validate({
        rules:
	    {
			codespecialista: { required: true },
			hora_desde: { required: true },
			hora_hasta: { required: true },
	    },
        messages:
	    {
            codespecialista:{ required: "Seleccione Especialista" },
            hora_desde:{ required: "Ingrese Hora Desde" },
            hora_hasta:{ required: "Ingrese Hora Hasta" },
        },
	    submitHandler: function(form) {
	   			
			var data = $("#savehorariosespecialista").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'horarios_especialistas.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}   
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA ESTE ESPECIALISTA TIENE UN HORARIO ASIGNADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
			 $("#savehorariosespecialista")[0].reset();
             $("#proceso").val("save");	
			 $('#codhorario').val("");
			 $('#horarios').html("");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
			 $('#horarios').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#horarios').load("consultas?CargaHorariosEspecialistas=si");
			 }, 200);
									
							});
						}
				   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE HORARIO DE ESPECIALISTAS */















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE DEPARTAMENTOS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savedepartamentos").validate({
      rules:
	  {
			departamento: { required: true },
	   },
       messages:
	   {
			departamento:{ required: "Ingrese Nombre de Departamento" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savedepartamentos").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'departamentos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE DEPARTAMENTO YA EXISTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
				 $("#savedepartamentos")[0].reset();
                 $("#proceso").val("save");
				 $('#id_departamento').val("");
				 $('#departamentos').html("");	
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#departamentos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#departamentos').load("consultas?CargaDepartamentos=si");
                 }, 200);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR REGISTRO DE DEPARTAMENTOS */


























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PROVINCIAS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#saveprovincias").validate({
      rules:
	  {
			provincia: { required: true },
			id_departamento: { required: true },
	   },
       messages:
	   {
            provincia:{ required: "Ingrese Nombre de Provincia" },
            id_departamento:{ required: "Seleccione Departamento" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#saveprovincias").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'provincias.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE PROVINCIA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
				 $("#saveprovincias")[0].reset();
                 $("#proceso").val("save");			
				 $('#id_provincia').val("");	
				 $('#provincias').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#provincias').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#provincias').load("consultas?CargaProvincias=si");
				 }, 200);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE PROVINCIAS */






















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TIPOS DE DOCUMENTOS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savedocumentos").validate({
      rules:
	  {
			documento: { required: true },
			descripcion: { required: true },
	   },
       messages:
	   {
			documento:{ required: "Ingrese Nombre de Documento" },
            descripcion:{ required: "Ingrese Descripci&oacute;n de Documento" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savedocumentos").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'documentos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE DOCUMENTO YA EXISTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
				 $("#savedocumentos")[0].reset();
                 $("#proceso").val("save");
				 $('#coddocumento').val("");
				 $('#documentos').html("");	
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#documentos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#documentos').load("consultas?CargaDocumentos=si");
                 }, 200);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR REGISTRO DE TIPOS DE DOCUMENTOS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TIPOS DE MONEDA */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savemonedas").validate({
      rules:
	  {
			moneda: { required: true },
			siglas: { required: true },
			simbolo: { required: true },
	   },
       messages:
	   {
			moneda:{ required: "Ingrese Nombre de Moneda" },
            siglas:{ required: "Ingrese Siglas de Moneda" },
            simbolo:{ required: "Ingrese Simbolo de Moneda" },
       },
	   submitHandler: function(form) {
	   			
				var data = $("#savemonedas").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'monedas.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE MONEDA YA EXISTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
				 $("#savemonedas")[0].reset();
                 $("#proceso").val("save");
				 $('#codmoneda').val("");
				 $('#monedas').html("");	
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#monedas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#monedas').load("consultas?CargaMonedas=si");
                 }, 200);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE TIPOS DE MONEDA */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TIPOS DE CAMBIO */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savecambios").validate({
      rules:
	  {
			descripcioncambio: { required: true },
			montocambio:{ required: true, number : true},
			montocambio: { required: true },
			codmoneda: { required: true },
			fechacambio: { required: true },
	   },
       messages:
	   {
			descripcioncambio:{ required: "Ingrese Descripci&oacute;n de Cambio" },
			montocambio:{ required: "Ingrese Monto de Cambio", number: "Ingrese solo digitos con 2 decimales" },
			codmoneda:{ required: "Seleccione Tipo de Moneda" },
			fechacambio:{ required: "Ingrese Fecha de Registro" },
       },
	   submitHandler: function(form) {
	   			
				var data = $("#savecambios").serialize();
				var montocambio = $('#montocambio').val();
	
	        if (montocambio==0.00 || montocambio==0) {
	            
				$("#montocambio").focus();
				$('#montocambio').css('border-color','#ff7676');
				swal("Oops", "POR FAVOR INGRESE UN MONTO DE CAMBIO VALIDO!", "error");

	        } else {


				$.ajax({
				type : 'POST',
				url  : 'cambios.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE UN TIPO DE CAMBIO EN LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
				 $("#savecambios")[0].reset();
                 $("#proceso").val("save");
				 $('#codcambio').val("");
				 $('#cambios').html("");	
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#cambios').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#cambios').load("consultas?CargaCambios=si");
                 }, 200);
										
									});
								}
						   }
				});
				return false;
			   }
		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR REGISTRO DE TIPOS DE CAMBIO */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MEDIOS DE PAGOS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savemedios").validate({
      rules:
	  {
			mediopago: { required: true },
	   },
       messages:
	   {
			mediopago:{ required: "Ingrese Nombre de Medio de Pago" },
       },
	   submitHandler: function(form) {
	   			
				var data = $("#savemedios").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'medios.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE ESTE MEDIO DE PAGO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}  
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
				 $("#savemedios")[0].reset();
                 $("#proceso").val("save");
				 $('#codmediopago').val("");	
				 $('#mediospagos').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#mediospagos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#mediospagos').load("consultas?CargaMediosPagos=si");
				 }, 200);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR REGISTRO DE MEDIOS DE PAGOS */



















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE IMPUESTOS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#saveimpuestos").validate({
      rules:
	  {
			nomimpuesto: { required: true },
			valorimpuesto: { required: true, number : true},
			statusimpuesto: { required: true },
			fechaimpuesto: { required: true },
	   },
       messages:
	   {
			nomimpuesto:{ required: "Ingrese Nombre de Impuesto" },
			valorimpuesto:{ required: "Ingrese Valor de Impuesto", number: "Ingrese solo digitos con 2 decimales" },
			statusimpuesto: { required: "Seleccione Status de Impuesto" },
			fechaimpuesto:{ required: "Ingrese Fecha de Registro" },
       },
	   submitHandler: function(form) {
	   			
				var data = $("#saveimpuestos").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'impuestos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE UN IMPUESTO ACTIVO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}  
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE UN IMPUESTO CON ESTE NOMBRE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
				 $("#saveimpuestos")[0].reset();
                 $("#proceso").val("save");
				 $('#codimpuesto').val("");
				 $('#impuestos').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#impuestos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#impuestos').load("consultas?CargaImpuestos=si");
				 }, 200);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE IMPUESTOS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE SUCURSALES */	 
$('document').ready(function()
{ 
        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

        /* validation */
	    $("#savesucursal").validate({
        rules:
	    {
			nrosucursal: { required: true },
			documsucursal: { required: true },
			cuitsucursal: { required: true, digits: false },
			nomsucursal: { required: true },
			id_departamento: { required: true },
			id_provincia: { required: true },
			direcsucursal: { required: true },
			correosucursal: { required: true,  email : true },
			tlfsucursal: { required: true,  digits : false },
			nroactividadsucursal: { required: true },
			inicioticket: { required: true, digits : true },
			inicionotaventa: { required: true, digits : true },
            iniciofactura: {required: true, digits : true },
			fechaautorsucursal: { required: true },
			llevacontabilidad: { required: true },
			documencargado: { required: true },
			dniencargado: { required: true, number: true },
			nomencargado: { required: true, lettersonly: true },
			tlfencargado: { required: false,  digits : false },
			descsucursal: { required: true,  number : true },
			codmoneda: { required: true },
			codmoneda2: { required: false },
	    },
        messages:
	    {
			nrosucursal:{ required: "Ingrese N&deg; de Sucursal" },
			documsucursal:{ required: "Seleccione Tipo de Documento" },
            cuitsucursal:{ required: "Ingrese N&deg; de Registro", digits: "Ingrese solo digitos para N&deg; de Cuit/Ruc" },
			nomsucursal:{ required: "Ingrese Raz&oacute;n Social" },
			id_departamento:{ required: "Seleccione Departamento" },
			id_provincia:{ required: "Seleccione Provincia" },
			direcsucursal: { required: "Ingrese Direcci&oacute;n de Sucursal" },
			correosucursal: { required: "Ingrese Correo Electr&oacute;nico", email: "Ingrese un Correo v&aacute;lido" },
			tlfsucursal: { required: "Ingrese N&deg; de Tel&eacute;fono", digits: "Ingrese solo digitos para Tel&eacute;fono" },
			nroactividadsucursal:{ required: "Ingrese N&deg; de Actividad", digits: "Ingrese solo digitos para N&deg; de Actividad" },
			inicioticket:{ required: "Ingrese N&deg; de Inicio de Ticket", digits: "Ingrese solo digitos para N&deg; de Inicio de Ticket" },
			inicionotaventa:{ required: "Ingrese N&deg; de Inicio Nota de Venta", digits: "Ingrese solo digitos para N&deg; de Inicio Nota de Venta" },
			iniciofactura:{ required: "Ingrese N&deg; de Inicio de Factura", digits: "Ingrese solo digitos para N&deg; de Inicio de Factura" },
			fechaautorsucursal:{ required: "Ingrese Fecha de Autorizaci&oacute;n de Sucursal" },
			llevacontabilidad:{ required: "Seleccione si lleva Contabilidad" },
			documencargado:{ required: "Seleccione Tipo de Documento" },
			dniencargado: { required: "Ingrese N&deg; de Documento", number: "Ingrese solo numeros para N&deg de Documento" },
			nomencargado:{ required: "Ingrese Nombre de Encargado", lettersonly: "Ingrese solo letras para Nombres" },
			tlfencargado: { required: "Ingrese N&deg; de Tel&eacute;fono", digits: "Ingrese solo digitos para Tel&eacute;fono" },
			descsucursal:{ required: "Ingrese Descuento General en Ventas", number: "Ingrese solo numeros con dos decimales para Desc. General en Ventas" },
			codmoneda:{ required: "Seleccione Moneda Nacional" },
			codmoneda2:{ required: "Seleccione Moneda para Cambio" },
       },
	   submitHandler: function(form) {
	   			
		var data = $("#savesucursal").serialize();
		var formData = new FormData($("#savesucursal")[0]);
		
		$.ajax({
		type : 'POST',
		url  : 'sucursales.php',
	    async : false,
		data : formData,
		//necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success :  function(data)
				   {						
						if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000 });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
							});
						} 
						else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> ESTE CORREO ELECTR&Oacute;NICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000 });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
							});
						}
						else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> YA EXISTE UNA SUCURSAL CON ESTE N&deg; DE CUIT/RUC, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000 });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
							});
						}
						else{
								
			$("#save").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'information',
         timeout: 5000 });
         $('#myModalSucursal').modal('hide');
		 $("#savesucursal")[0].reset();
         $("#proceso").val("save");
         $("#codsucursal").val("");
		 $('#id_provincia').html("<option value=''>-- SIN RESULTADOS --</option>");	
		 $('#sucursales').html("");
		 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
		 $('#sucursales').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		 setTimeout(function() {
		 	$('#sucursales').load("consultas?CargaSucursales=si");
		 }, 200);
								
							});
						}
				   }
			});
			return false;
		}
	   /* form submit */	   
    }); 
});
/*  FUNCION PARA VALIDAR REGISTRO DE SUCURSALES */



















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TRATAMIENTOS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savetratamiento").validate({
      rules:
	  {
			nomtratamiento: { required: true },
	   },
       messages:
	   {
            nomtratamiento:{ required: "Ingrese Nombre de Tratamiento" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#savetratamiento").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'tratamientos.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}   
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE TRATAMIENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
			 $("#savetratamiento")[0].reset();
             $("#proceso").val("save");	
			 $('#codtratamiento').val("");
			 $('#tratamientos').html("");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
			 $('#tratamientos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#tratamientos').load("consultas?CargaTratamientos=si");
			 }, 200);
									
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE TRATAMIENTOS */














/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MARCAS */	 
$('document').ready(function()
{ 
        /* validation */
	    $("#savemarcas").validate({
        rules:
	    {
			nommarca: { required: true },
	    },
        messages:
	    {
            nommarca:{ required: "Ingrese Nombre de Marca" },
        },
	    submitHandler: function(form) {
	   			
			var data = $("#savemarcas").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'marcas.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}   
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE MARCA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
			 $("#savemarcas")[0].reset();
             $("#proceso").val("save");	
			 $('#codmarca').val("");
			 $('#marcas').html("");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
			 $('#marcas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#marcas').load("consultas?CargaMarcas=si");
			 }, 200);
									
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE MARCAS */



















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRESENTACIONES */	 
$('document').ready(function()
{ 
       /* validation */
	   $("#savepresentaciones").validate({
       rules:
	   {
			nompresentacion: { required: true },
	   },
       messages:
	   {
            nompresentacion:{ required: "Ingrese Nombre de Presentaci&oacute;n" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#savepresentaciones").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'presentaciones.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}   
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE PRESENTACI&Oacute;N, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
			 $("#savepresentaciones")[0].reset();
             $("#proceso").val("save");	
			 $('#codpresentacion').val("");
			 $('#presentaciones').html("");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
			 $('#presentaciones').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#presentaciones').load("consultas?CargaPresentaciones=si");
			 }, 200);
									
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE PRESENTACIONES */















/* FUNCION JQUERY PARA VALIDAR UNIDAD DE MEDIDAS */	 
$(document).ready(function()
{ 
     
       /* validation */
	   $("#savemedidas").validate({
       rules:
	   {
			nommedida: { required: true },
	   },
       messages:
	   {
            nommedida:{ required: "Ingrese Unidad de Medida" },
       },
	   submitHandler: function(form) {
                     
           var data = $("#savemedidas").serialize();

			$.ajax({
			type : 'POST',
			url  : 'medidas.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTA MEDIDA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
																			
								});
							} 
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
			 $("#savemedidas")[0].reset();
             $("#proceso").val("save");
			 $('#codmedida').val("");
			 $('#medidas').html("");		
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
			 $('#medidas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
             setTimeout(function() {
             $('#medidas').load("consultas?CargaMedidas=si");
             }, 200);										
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    });
});
/*  FUNCION PARA VALIDAR UNIDAD DE MEDIDAS */
























/* FUNCION JQUERY PARA CARGA MASIVA DE ESPECIALISTA */	 
$('document').ready(function()
{ 						
     /* validation */
	 $("#cargaespecialistas").validate({
      rules:
	  {
			sel_file: { required: true },
	   },
       messages:
	   {
            sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#cargaespecialistas").serialize();
			var formData = new FormData($("#cargaespecialistas")[0]);
			
			$.ajax({
			type : 'POST',
			url  : 'especialistas.php',
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-especialista").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
			},
			success :  function(data)
					   {						
			if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-especialista").html('<span class="fa fa-cloud-upload"></span> Cargar');
									
						});
				}  
			else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE ESPECIALISTAS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-especialista").html('<span class="fa fa-cloud-upload"></span> Cargar');
																			
						});
					}
						else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
             $('#myModalCargaMasiva').modal('hide');
			 $("#cargaespecialistas")[0].reset();
			 $('#especialistas').html("");
			 $('#divespecialista').html("");
			 $("#btn-especialista").html('<span class="fa fa-cloud-upload"></span> Cargar');
			 $('#especialistas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#especialistas').load("consultas?CargaEspecialistas=si");
			 }, 200);
									
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 
});
/*  FUNCION PARA CARGA MASIVA DE ESPECIALISTA */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ESPECIALISTA */	  
$('document').ready(function()
{ 
        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

     /* validation */
	 $("#saveespecialista").validate({
        rules:
	    {
			tpespecialista: { required: true },
			documespecialista: { required: true },
			cedespecialista: { required: true,  digits : false, minlength: 7 },
			nomespecialista: { required: true, lettersonly: false },
			tlfespecialista: { required: true },
			sexoespecialista: { required: true },
			id_departamento: { required: false },
			id_provincia: { required: false },
			direcespecialista: { required: true },
			correoespecialista: { required: true, email: true },
			especialidad: { required: true },
			fnacespecialista: { required: false },
			twitter: { required: false, url: false },
			facebook: { required: false, url: false },
			instagram: { required: false, url: false },
			google: { required: false, url: false },
	    },
        messages:
	    {
			tpespecialista:{ required: "Ingrese Tarjeta Profesional" },
			documespecialista:{ required: "Seleccione Tipo de Documento" },
			cedespecialista:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos para N&deg; de Documento", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
            nomespecialista:{ required: "Ingrese Nombre y Apellidos", lettersonly: "Ingrese solo letras" },
			tlfespecialista: { required: "Ingrese N&deg; de Tel&eacute;fono" },
            sexoespecialista:{ required: "Seleccione Sexo" },
			id_departamento: { required: "Seleccione Departamento" },
			id_provincia:{ required: "Seleccione Provincia" },
			direcespecialista: { required: "Ingrese Direcci&oacute;n Domiciliaria" },
			correoespecialista:{ required: "Ingrese Correo Electronico", email: "Ingrese un Email V&aacute;lido" },
            especialidad: { required: "Ingrese Especialidad" },
            fnacespecialista: { required: "Ingrese Fecha de Nacimiento" },
			twitter:{ required: "Ingrese Url de Twitter", url: "Ingrese un Dirección de Url V&aacute;lida" },
			facebook:{ required: "Ingrese Url de Facebook", url: "Ingrese un Dirección de Url V&aacute;lida" },
			instagram:{ required: "Ingrese Url de Instagram", url: "Ingrese un Dirección de Url V&aacute;lida" },
			google:{ required: "Ingrese Url de Google-Plus", url: "Ingrese un Dirección de Url V&aacute;lida" },
        },
	    submitHandler: function(form) {
	   			
			var data = $("#saveespecialista").serialize();
			var formData = new FormData($("#saveespecialista")[0]);

			$.ajax({
			type : 'POST',
			url  : 'especialistas.php',
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE SELECCIONAR UNA SUCURSAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}  
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTE CORREO ELECTRONICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							} 
							else if(data==4){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE UN ESPECIALISTA CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
             $('#myModalEspecialista').modal('hide');
			 $("#saveespecialista")[0].reset();
             $("#proceso").val("save");		
             $("#codespecialista").val("");	
			 $('#id_provincia').html("<option value=''>-- SIN RESULTADOS --</option>");	
			 $('#especialistas').html("");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
			 $('#especialistas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#especialistas').load("consultas?CargaEspecialistas=si");
			 }, 200);
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR REGISTRO DE ESPECIALISTA */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZAR ESPECIALISTA */	  
$('document').ready(function()
{ 
        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

     /* validation */
	 $("#updatedatos").validate({
        rules:
	    {
			tpespecialista: { required: true },
			documespecialista: { required: true },
			cedespecialista: { required: true,  digits : false, minlength: 7 },
			nomespecialista: { required: true, lettersonly: false },
			tlfespecialista: { required: true },
			sexoespecialista: { required: true },
			id_departamento: { required: false },
			id_provincia: { required: false },
			direcespecialista: { required: true },
			correoespecialista: { required: true, email: true },
			especialidad: { required: true },
			fnacespecialista: { required: false },
			twitter: { required: false, url: false },
			facebook: { required: false, url: false },
			instagram: { required: false, url: false },
			google: { required: false, url: false },
	    },
        messages:
	    {
			tpespecialista:{ required: "Ingrese Tarjeta Profesional" },
			documespecialista:{ required: "Seleccione Tipo de Documento" },
			cedespecialista:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos para N&deg; de Documento", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
            nomespecialista:{ required: "Ingrese Nombre y Apellidos", lettersonly: "Ingrese solo letras" },
			tlfespecialista: { required: "Ingrese N&deg; de Tel&eacute;fono" },
            sexoespecialista:{ required: "Seleccione Sexo" },
			id_departamento: { required: "Seleccione Departamento" },
			id_provincia:{ required: "Seleccione Provincia" },
			direcespecialista: { required: "Ingrese Direcci&oacute;n Domiciliaria" },
			correoespecialista:{ required: "Ingrese Correo Electronico", email: "Ingrese un Email V&aacute;lido" },
            especialidad: { required: "Ingrese Especialidad" },
            fnacespecialista: { required: "Ingrese Fecha de Nacimiento" },
			twitter:{ required: "Ingrese Url de Twitter", url: "Ingrese un Dirección de Url V&aacute;lida" },
			facebook:{ required: "Ingrese Url de Facebook", url: "Ingrese un Dirección de Url V&aacute;lida" },
			instagram:{ required: "Ingrese Url de Instagram", url: "Ingrese un Dirección de Url V&aacute;lida" },
			google:{ required: "Ingrese Url de Google-Plus", url: "Ingrese un Dirección de Url V&aacute;lida" },
        },
	    submitHandler: function(form) {
	   			
			var data = $("#updatedatos").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'datos.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-edit"></span> Actualizar');
									
								});
							} 
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTE CORREO ELECTRONICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-edit"></span> Actualizar');
																			
								});
							} 
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE UN ESPECIALISTA CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-edit"></span> Actualizar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
			 $("#btn-submit").html('<span class="fa fa-edit"></span> Actualizar');
							});
					    }
				    }
				});
				return false;
		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR ACTUALIZAR ESPECIALISTA */



















/* FUNCION JQUERY PARA CARGA MASIVA DE PACIENTES */	 
$('document').ready(function()
{ 						
     /* validation */
	 $("#cargapacientes").validate({
      rules:
	  {
			sel_file: { required: true },
	   },
       messages:
	   {
            sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#cargapacientes").serialize();
			var formData = new FormData($("#cargapacientes")[0]);
			
			$.ajax({
			type : 'POST',
			url  : 'pacientes.php',
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-paciente").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
			},
			success :  function(data)
					   {						
			if(data==1){
								
					$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-paciente").html('<span class="fa fa-cloud-upload"></span> Cargar');
									
								});
							}  
			else if(data==2){
								
					$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE PACIENTES, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-paciente").html('<span class="fa fa-cloud-upload"></span> Cargar');
																			
								});
					}
				else{
									
			$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
             $('#myModalCargaMasiva').modal('hide');
			 $("#cargapacientes")[0].reset();
			 $('#divpaciente').html("");
			 $("#btn-paciente").html('<span class="fa fa-cloud-upload"></span> Cargar');
									
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 
});
/*  FUNCION PARA CARGA MASIVA DE PACIENTES */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PACIENTE */	  
$('document').ready(function()
{ 
        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

	    $("#savepaciente").validate({
        rules:
	    {
			documpaciente: { required: true },
			cedpaciente: { required: true, digits : true  },
			pnompaciente: { required: true, lettersonly: false },
			snompaciente : { required: false, lettersonly: false },
			papepaciente: { required: true, lettersonly: false },
			sapepaciente: { required: false, lettersonly: false },
			fnacpaciente: { required: false },
			tlfpaciente: { required: true },
			emailpaciente: { required: false, email: true },
			gruposapaciente: { required: true },
			estadopaciente: { required: true },
			ocupacionpaciente: { required: true },
			sexopaciente: { required: true },
			enfoquepaciente: { required: true },
			id_departamento: { required: false },
			id_provincia: { required: false },
			direcpaciente: { required: true },
			nomacompana: { required: false, lettersonly: false },
			direcacompana: { required: false },
			tlfacompana: { required: false },
			parentescoacompana: { required: false },
			nomresponsable: { required: false, lettersonly: false },
			direcresponsable: { required: false },
			tlfresponsable: { required: false },
			parentescoresponsable: { required: false },
	    },
        messages:
	    {
            documpaciente:{ required: "Seleccione Tipo de Documento" },
			cedpaciente:{  required: "Ingrese N&deg; de Documento", digits: "Ingrese solo digitos"  },
			pnompaciente:{ required: "Ingrese Primer Nombre", lettersonly: "Ingrese solo letras" },
			snompaciente : { required : "Ingrese Segundo Nombre", lettersonly: "Ingrese solo letras" },
			papepaciente:{  required: "Ingrese Primer Apellido", lettersonly: "Ingrese solo letras" },
			sapepaciente:{ required: "Ingrese Segundo Apellido", lettersonly: "Ingrese solo letras" },
			fnacpaciente:{ required: "Ingrese Fecha Nacimiento" },
			tlfpaciente:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			emailpaciente:{ required: "Ingrese Correo Electronico", email: "Ingrese un Email V&aacute;lido" },
			gruposapaciente:{ required: "Seleccione Grupo Sanguineo" },
			estadopaciente:{ required: "Seleccione Estado Civil"  },
			ocupacionpaciente:{ required: "Ingrese Ocupaci&oacute;n Laboral" },
			sexopaciente:{  required: "Seleccione Sexo" },
			enfoquepaciente:{ required: "Seleccione Enfoque Diferencial" },
			id_departamento: { required: "Seleccione Departamento" },
			id_provincia:{ required: "Seleccione Provincia" },
			direcpaciente:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
			nomacompana:{ required: "Ingrese Nombre Completo", lettersonly: "Ingrese solo letras" },
		    direcacompana:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
			tlfacompana:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			parentescoacompana:{ required: "Ingrese Parentesco" },
			nomresponsable:{ required: "Ingrese Nombre Completo", lettersonly: "Ingrese solo letras" },
		    direcresponsable:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
			tlfresponsable:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			parentescoresponsable:{ required: "Ingrese Parentesco" },
        },
	    submitHandler: function(form) {
	   			
			var data = $("#savepaciente").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'forpaciente.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE UN PACIENTE CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
			 $("#savepaciente")[0].reset();
             $("#proceso").val("save");		
             $("#codpaciente").val("");	
			 $('#id_provincia').html("<option value=''>-- SIN RESULTADOS --</option>");	
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR REGISTRO DE PACIENTE */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PACIENTE */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#updatepaciente").validate({
	    rules:
	    {
			documpaciente: { required: true },
			cedpaciente: { required: true, digits : true  },
			pnompaciente: { required: true, lettersonly: false },
			snompaciente : { required: false, lettersonly: false },
			papepaciente: { required: true, lettersonly: false },
			sapepaciente: { required: false, lettersonly: false },
			fnacpaciente: { required: false },
			tlfpaciente: { required: true },
			emailpaciente: { required: false, email: true },
			gruposapaciente: { required: true },
			estadopaciente: { required: true },
			ocupacionpaciente: { required: true },
			sexopaciente: { required: true },
			enfoquepaciente: { required: true },
			id_departamento: { required: false },
			id_provincia: { required: false },
			direcpaciente: { required: true },
			nomacompana: { required: false, lettersonly: false },
			direcacompana: { required: false },
			tlfacompana: { required: false },
			parentescoacompana: { required: false },
			nomresponsable: { required: false, lettersonly: false },
			direcresponsable: { required: false },
			tlfresponsable: { required: false },
			parentescoresponsable: { required: false },
	    },
        messages:
	    {
            documpaciente:{ required: "Seleccione Tipo de Documento" },
			cedpaciente:{  required: "Ingrese N&deg; de Documento", digits: "Ingrese solo digitos"  },
			pnompaciente:{ required: "Ingrese Primer Nombre", lettersonly: "Ingrese solo letras" },
			snompaciente : { required : "Ingrese Segundo Nombre", lettersonly: "Ingrese solo letras" },
			papepaciente:{  required: "Ingrese Primer Apellido", lettersonly: "Ingrese solo letras" },
			sapepaciente:{ required: "Ingrese Segundo Apellido", lettersonly: "Ingrese solo letras" },
			fnacpaciente:{ required: "Ingrese Fecha Nacimiento" },
			tlfpaciente:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			emailpaciente:{ required: "Ingrese Correo Electronico", email: "Ingrese un Email V&aacute;lido" },
			gruposapaciente:{ required: "Seleccione Grupo Sanguineo" },
			estadopaciente:{ required: "Seleccione Estado Civil"  },
			ocupacionpaciente:{ required: "Ingrese Ocupaci&oacute;n Laboral" },
			sexopaciente:{  required: "Seleccione Sexo" },
			enfoquepaciente:{ required: "Seleccione Enfoque Diferencial" },
			id_departamento: { required: "Seleccione Departamento" },
			id_provincia:{ required: "Seleccione Provincia" },
			direcpaciente:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
			nomacompana:{ required: "Ingrese Nombre Completo", lettersonly: "Ingrese solo letras" },
		    direcacompana:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
			tlfacompana:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			parentescoacompana:{ required: "Ingrese Parentesco" },
			nomresponsable:{ required: "Ingrese Nombre Completo", lettersonly: "Ingrese solo letras" },
		    direcresponsable:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
			tlfresponsable:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			parentescoresponsable:{ required: "Ingrese Parentesco" },
        }, 
	    submitHandler: function(form) {
	   			
   	        var data = $("#updatepaciente").serialize();
			var formData = new FormData($("#updatepaciente")[0]);
			var id= $("#updatepaciente").attr("data-id");
	        var codpaciente = id;
			
			$.ajax({
			type : 'POST',
			url  : 'forpaciente.php',
			//url  : 'forpaciente.php?codpaciente='+codpaciente,
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE UN PACIENTE CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'success',
             timeout: 5000 });
			 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
			 setTimeout("location.href='pacientes'", 5000);	
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR ACTUALIZACION DE PACIENTE */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PACIENTE EN SESSION */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#updatepacientesession").validate({
	    rules:
	    {
			documpaciente: { required: true },
			cedpaciente: { required: true, digits : true  },
			pnompaciente: { required: true, lettersonly: false },
			snompaciente : { required: false, lettersonly: false },
			papepaciente: { required: true, lettersonly: false },
			sapepaciente: { required: false, lettersonly: false },
			fnacpaciente: { required: false },
			tlfpaciente: { required: true },
			emailpaciente: { required: false, email: true },
			gruposapaciente: { required: true },
			estadopaciente: { required: true },
			ocupacionpaciente: { required: true },
			sexopaciente: { required: true },
			enfoquepaciente: { required: true },
			id_departamento: { required: false },
			id_provincia: { required: false },
			direcpaciente: { required: true },
			nomacompana: { required: false, lettersonly: false },
			direcacompana: { required: false },
			tlfacompana: { required: false },
			parentescoacompana: { required: false },
			nomresponsable: { required: false, lettersonly: false },
			direcresponsable: { required: false },
			tlfresponsable: { required: false },
			parentescoresponsable: { required: false },
	    },
        messages:
	    {
            documpaciente:{ required: "Seleccione Tipo de Documento" },
			cedpaciente:{  required: "Ingrese N&deg; de Documento", digits: "Ingrese solo digitos"  },
			pnompaciente:{ required: "Ingrese Primer Nombre", lettersonly: "Ingrese solo letras" },
			snompaciente : { required : "Ingrese Segundo Nombre", lettersonly: "Ingrese solo letras" },
			papepaciente:{  required: "Ingrese Primer Apellido", lettersonly: "Ingrese solo letras" },
			sapepaciente:{ required: "Ingrese Segundo Apellido", lettersonly: "Ingrese solo letras" },
			fnacpaciente:{ required: "Ingrese Fecha Nacimiento" },
			tlfpaciente:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			emailpaciente:{ required: "Ingrese Correo Electronico", email: "Ingrese un Email V&aacute;lido" },
			gruposapaciente:{ required: "Seleccione Grupo Sanguineo" },
			estadopaciente:{ required: "Seleccione Estado Civil"  },
			ocupacionpaciente:{ required: "Ingrese Ocupaci&oacute;n Laboral" },
			sexopaciente:{  required: "Seleccione Sexo" },
			enfoquepaciente:{ required: "Seleccione Enfoque Diferencial" },
			id_departamento: { required: "Seleccione Departamento" },
			id_provincia:{ required: "Seleccione Provincia" },
			direcpaciente:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
			nomacompana:{ required: "Ingrese Nombre Completo", lettersonly: "Ingrese solo letras" },
		    direcacompana:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
			tlfacompana:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			parentescoacompana:{ required: "Ingrese Parentesco" },
			nomresponsable:{ required: "Ingrese Nombre Completo", lettersonly: "Ingrese solo letras" },
		    direcresponsable:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
			tlfresponsable:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			parentescoresponsable:{ required: "Ingrese Parentesco" },
        }, 
	    submitHandler: function(form) {
	   			
   	        var data = $("#updatepacientesession").serialize();
			var formData = new FormData($("#updatepacientesession")[0]);
			var id= $("#updatepacientesession").attr("data-id");
	        var codpaciente = id;
			
			$.ajax({
			type : 'POST',
			url  : 'forpaciente.php',
			//url  : 'forpaciente.php?codpaciente='+codpaciente,
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE UN PACIENTE CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'success',
             timeout: 5000 });
			 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR ACTUALIZACION DE PACIENTE EN SESSION */


















/* FUNCION JQUERY PARA CARGA MASIVA DE PROVEEDORES */	 
$('document').ready(function()
{ 						
     /* validation */
	 $("#cargaproveedores").validate({
      rules:
	  {
			sel_file: { required: true },
	   },
       messages:
	   {
            sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#cargaproveedores").serialize();
			var formData = new FormData($("#cargaproveedores")[0]);
			
			$.ajax({
			type : 'POST',
			url  : 'proveedores.php',
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-proveedor").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
			},
			success :  function(data)
					   {						
			if(data==1){
								
					$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-proveedor").html('<span class="fa fa-cloud-upload"></span> Cargar');
									
								});
							}  
			else if(data==2){
								
					$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE PROVEEDORES, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-proveedor").html('<span class="fa fa-cloud-upload"></span> Cargar');
																			
								});
							}
					else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
              $('#myModalCargaMasiva').modal('hide');
			 $("#cargaproveedores")[0].reset();
			 $('#proveedores').html("");
			 $('#divproveedor').html("");
			 $("#btn-proveedor").html('<span class="fa fa-cloud-upload"></span> Cargar');
			 $('#proveedores').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#proveedores').load("consultas?CargaProveedores=si");
			 }, 200);
									
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 
});
/*  FUNCION PARA CARGA MASIVA DE PROVEEDORES */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PROVEEDORES */	  
$('document').ready(function()
{ 
        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

     /* validation */
	 $("#saveproveedor").validate({
        rules:
	    {
			documproveedor: { required: false },
			cuitproveedor: { required: true,  digits : false, minlength: 7 },
			nomproveedor: { required: true, lettersonly: false },
			tlfproveedor: { required: true },
			id_departamento: { required: false },
			id_provincia: { required: false },
			direcproveedor: { required: true },
			emailproveedor: { required: true, email: true },
			vendedor: { required: true, lettersonly: true },
	    },
        messages:
	    {
			documproveedor:{ required: "Seleccione Tipo de Documento" },
			cuitproveedor:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos para N&deg; de Documento", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
            nomproveedor:{ required: "Ingrese Nombre de Proveedor", lettersonly: "Ingrese solo letras para Nombres" },
			tlfproveedor: { required: "Ingrese N&deg; de Tel&eacute;fono" },
			id_departamento: { required: "Seleccione Departamento" },
			id_provincia:{ required: "Seleccione Provincia" },
			direcproveedor: { required: "Ingrese Direcci&oacute;n de Proveedor" },
			emailproveedor:{ required: "Ingrese Email de Proveedor", email: "Ingrese un Email V&aacute;lido" },
            vendedor:{ required: "Ingrese Nombre de Encargado", lettersonly: "Ingrese solo letras para Nombres" },
        },
	   submitHandler: function(form) {
	   			
			var data = $("#saveproveedor").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'proveedores.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE UN PROVEEDOR CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
             $('#myModalProveedor').modal('hide');
			 $("#saveproveedor")[0].reset();
             $("#proceso").val("save");	
             $("#codproveedor").val("");	
			 $('#id_provincia').html("<option value=''>-- SIN RESULTADOS --</option>");	
			 $('#proveedores').html("");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
			 $('#proveedores').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#proveedores').load("consultas?CargaProveedores=si");
			 }, 200);
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR REGISTRO DE PROVEEDORES */




















/* FUNCION JQUERY PARA CARGA MASIVA DE SERVICIOS */	 
$('document').ready(function()
{ 						
     /* validation */
	 $("#cargaservicios").validate({
      rules:
	  {
			sel_file: { required: true },
	   },
       messages:
	   {
            sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#cargaservicios").serialize();
			var formData = new FormData($("#cargaservicios")[0]);
			
			$.ajax({
			type : 'POST',
			url  : 'servicios.php',
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-servicio").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
			},
			success :  function(data)
					   {						
			if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-servicio").html('<span class="fa fa-cloud-upload"></span> Cargar');
									
						});
				}  
			else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE SERVICIOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-servicio").html('<span class="fa fa-cloud-upload"></span> Cargar');
																			
						});
					}
						else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
             $('#myModalCargaMasiva').modal('hide');
			 $("#cargaservicios")[0].reset();
			 $('#servicios').html("");
			 $('#divservicio').html("");
			 $("#btn-servicio").html('<span class="fa fa-cloud-upload"></span> Cargar');
			 $('#servicios').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#servicios').load("consultas?CargaServicios=si");
			 }, 200);
									
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 
});
/*  FUNCION PARA CARGA MASIVA DE SERVICIOS */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE SERVICIOS */	  
$('document').ready(function()
{ 
        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

     /* validation */
	 $("#saveservicio").validate({
        rules:
	  {
			servicio: { required: true },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			ivaservicio: { required: true },
			descservicio: { required: true, number : true },
			status: { required: true },
			codsucursal: { required: true },
	   },
       messages:
	   {
			servicio:{ required: "Ingrese Nombre de Servicio" },
			preciocompra:{ required: "Ingrese Precio de Compra de Servicio", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta de Servicio", number: "Ingrese solo digitos con 2 decimales" },
			precioservicio:{ required: "Ingrese Precio de Servicio", number: "Ingrese solo digitos con 2 decimales" },
			ivaservicio:{ required: "Seleccione Impuesto de Servicio" },
			descservicio:{ required: "Ingrese Descuento de Servicio", number: "Ingrese solo digitos con 2 decimales" },
			status: { required: "Seleccione Status" },
			codsucursal: { required: "Seleccione Sucursal" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#saveservicio").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'servicios.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							} 
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE SERVICIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
             $('#myModalServicio').modal('hide');
			 $("#saveservicio")[0].reset();
             $("#proceso").val("save");		
             $("#codservicio").val("");	
			 $('#servicios').html("");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
			 $('#servicios').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#servicios').load("consultas?CargaServicios=si");
			 }, 200);
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR REGISTRO DE SERVICIOS */




















/* FUNCION JQUERY PARA CARGA MASIVA DE PRODUCTOS */	 
$('document').ready(function()
{ 						
     /* validation */
	 $("#cargaproductos").validate({
      rules:
	  {
			sel_file: { required: true },
	   },
       messages:
	   {
            sel_file:{ required: "Por favor Seleccione Archivo para Cargar" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#cargaproductos").serialize();
			var formData = new FormData($("#cargaproductos")[0]);
			
			$.ajax({
			type : 'POST',
			url  : 'productos.php',
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-producto").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
			},
			success :  function(data)
					   {						
				if(data==1){
								
					$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-producto").html('<span class="fa fa-cloud-upload"></span> Cargar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-producto").html('<span class="fa fa-cloud-upload"></span> Cargar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
             $('#myModalCargaMasiva').modal('hide');
			 $("#cargaproductos")[0].reset();
             $('#productos').html("");
			 $('#divproducto').html("");
			 $("#btn-producto").html('<span class="fa fa-cloud-upload"></span> Cargar');
			 $('#productos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#productos').load("consultas?CargaProductos=si");
			 }, 200);
									
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 
});
/*  FUNCION PARA CARGA MASIVA DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRODUCTOS */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#saveproductos").validate({
	    rules:
	    {
			codproducto: { required: true },
			producto: { required: true,},
			codmarca: { required: true },
			codpresentacion: { required: true },
			medida: { required: false,},
			lote: { required: false },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			existencia: { required: true, digits : true },
			stockminimo: { required: false, digits : true },
			stockmaximo: { required: false, digits : true },
			ivaproducto: { required: true },
			descproducto: { required: true, number : true },
			fechaelaboracion: { required: false },
			fechaexpiracion: { required: false },
			codproveedor: { required: true },
			codsucursal: { required: true },
	    },
        messages:
	    {
			codproducto: { required: "Ingrese C&oacute;digo de Producto" },
			producto:{ required: "Ingrese Nombre o Descripci&oacute;n" },
			codmarca:{ required: "Seleccione Marca de Producto" },
			codpresentacion:{ required: "Seleccione Presentaci&oacute;n" },
			medida:{ required: "Ingrese Unidad de Medida" },
			lote:{ required: "Ingrese N&deg; de Lote" },
			preciocompra:{ required: "Ingrese Precio de Compra de Producto", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta de Producto", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Cantidad o Existencia de Producto", digits: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", digits: "Ingrese solo digitos" },
            stockmaximo:{ required: "Ingrese Stock Maximo", digits: "Ingrese solo digitos" },
			ivaproducto:{ required: "Seleccione Impuesto de Producto" },
			descproducto:{ required: "Ingrese Descuento de Producto", number: "Ingrese solo digitos con 2 decimales" },
			fechaelaboracion: { required: "Ingrese Fecha de Elaboraci&oacute;n" },
			fechaexpiracion: { required: "Ingrese Fecha de Expiraci&oacute;n" },
			codproveedor: { required: "Seleccione Proveedor" },
			codsucursal: { required: "Seleccione Sucursal" },
        },
	   submitHandler: function(form) {
	   			
				var data = $("#saveproductos").serialize();
				var formData = new FormData($("#saveproductos")[0]);

				var cant = $('#existencia').val();
				var compra = $('#preciocompra').val();
				var venta = $('#precioventa').val();
				cantidad    = parseInt(cant);
	
	        if (venta==0.00 || venta==0) {
	            
				$("#precioventa").focus();
				$('#precioventa').val("");
				$('#precioventa').css('border-color','#ff7676');
				swal("Oops", "INGRESE UN COSTO VALIDO PARA EL PRECIO DE VENTA DE PRODUCTO!", "error");
         
                return false;

            } else if (parseFloat(compra) > parseFloat(venta)) {
	            
				$("#precioventa").focus();
				$("#preciocompra").focus();
				$('#precioventa').css('border-color','#ff7676');
				$('#preciocompra').css('border-color','#ff7676');
				swal("Oops", "EL PRECIO DE COMPRA NO PUEDE SER MAYOR QUE EL PRECIO DE VENTA DEL PRODUCTO!", "error");
         
                return false;
	 
	        } else {
				
				$.ajax({
				type : 'POST',
				url  : 'forproducto.php',
			    async : false,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE PRODUCTO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
				 $("#saveproductos")[0].reset();
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
									});
								}
						   }
				});
				return false;
			}
		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR REGISTRO DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRODUCTOS */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#updateproductos").validate({
	    rules:
	    {
			codproducto: { required: true },
			producto: { required: true,},
			codmarca: { required: true },
			codpresentacion: { required: true },
			medida: { required: false,},
			lote: { required: false },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			existencia: { required: true, digits : true },
			stockminimo: { required: false, digits : true },
			stockmaximo: { required: false, digits : true },
			ivaproducto: { required: true },
			descproducto: { required: true, number : true },
			fechaelaboracion: { required: false },
			fechaexpiracion: { required: false },
			codproveedor: { required: true },
			codsucursal: { required: true },
	    },
        messages:
	    {
			codproducto: { required: "Ingrese C&oacute;digo de Producto" },
			producto:{ required: "Ingrese Nombre o Descripci&oacute;n" },
			codmarca:{ required: "Seleccione Marca de Producto" },
			codpresentacion:{ required: "Seleccione Presentaci&oacute;n" },
			medida:{ required: "Ingrese Unidad de Medida" },
			lote:{ required: "Ingrese N&deg; de Lote" },
			preciocompra:{ required: "Ingrese Precio de Compra de Producto", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta de Producto", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Cantidad o Existencia de Producto", digits: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", digits: "Ingrese solo digitos" },
            stockmaximo:{ required: "Ingrese Stock Maximo", digits: "Ingrese solo digitos" },
			ivaproducto:{ required: "Seleccione Impuesto de Producto" },
			descproducto:{ required: "Ingrese Descuento de Producto", number: "Ingrese solo digitos con 2 decimales" },
			fechaelaboracion: { required: "Ingrese Fecha de Elaboraci&oacute;n" },
			fechaexpiracion: { required: "Ingrese Fecha de Expiraci&oacute;n" },
			codproveedor: { required: "Seleccione Proveedor" },
			codsucursal: { required: "Seleccione Sucursal" },
        },
	    submitHandler: function(form) {
	   			
   	        var data = $("#updateproductos").serialize();
			var formData = new FormData($("#updateproductos")[0]);
			var id= $("#updateproductos").attr("data-id");
	        var codproducto = id;

			var cant = $('#existencia').val();
			var compra = $('#preciocompra').val();
			var venta = $('#precioventa').val();
			cantidad    = parseInt(cant);

        if (venta==0.00 || venta==0) {
            
			$("#precioventa").focus();
			$('#precioventa').val("");
			$('#precioventa').css('border-color','#ff7676');
			swal("Oops", "INGRESE UN COSTO VALIDO PARA EL PRECIO DE VENTA DE PRODUCTO!", "error");

            return false;

        } else if (parseFloat(compra) > parseFloat(venta)) {
            
			$("#precioventa").focus();
			$("#preciocompra").focus();
			$('#precioventa').css('border-color','#ff7676');
			$('#preciocompra').css('border-color','#ff7676');
			swal("Oops", "EL PRECIO DE COMPRA NO PUEDE SER MAYOR QUE EL PRECIO DE VENTA DEL PRODUCTO!", "error");
     
            return false;
 
        } else {
			
			$.ajax({
			type : 'POST',
			url  : 'forproducto.php?codproducto='+codproducto,
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTE PRODUCTO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'success',
             timeout: 5000 });
			 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
			 setTimeout("location.href='productos'", 5000);	
									});
								}
						   }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR ACTUALIZACION DE PRODUCTOS */



























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TRASPASOS */	 	 
$('document').ready(function()
{ 
	/* validation */
	$("#savetraspaso").validate({
		rules:
	    {
			recibe: { required: true },
			fechatraspaso: { required: true },
			observaciones: { required: false },
	    },
        messages:
	    {
            recibe:{ required: "Seleccione Sucursal Recibe" },
			fechatraspaso:{ required: "Ingrese Fecha de Traspaso" },
			observaciones:{ required: "Ingrese Observaciones" },
        },
		submitHandler: function(form) {

		var data = $("#savetraspaso").serialize();
		var nuevaFila ="<tr>"+"<td class='text-center' colspan=8><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var TotalPago = $('#txtTotal').val();
	
	    if (TotalPago==0.00) {
	            
	        $("#search_busqueda").focus();
            $('#search_busqueda').css('border-color','#ff7676');
	        swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA COTIZACIÓN!", "error");
            return false;
	
	    } else {

		$.ajax({

		type : 'POST',
		url  : 'fortraspaso.php',
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success :  function(data)
		{						
			if(data==1){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});
			}  
			else if(data==2){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA EL TRASPASO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});

        	} 
			else if(data==3){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> LA CANTIDAD DE DETALLES DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});

        	} else {

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: '<center> '+data+' </center>',
				theme: 'defaultTheme',
				layout: 'center',
				type: 'information',
				timeout: 5000 });
				$("#savetraspaso")[0].reset();
				$("#btn-submit").attr('disabled', true);
				$("#carrito tbody").html("");
				$(nuevaFila).appendTo("#carrito tbody");
				$("#lblsubtotal").text("0.00");
				$("#lblgravado").text("0.00");
				$("#lblexento").text("0.00");
				$("#lbliva").text("0.00");
				$("#lbldescuento").text("0.00");
				$("#lbltotal").text("0.00");
				$("#txtsubtotal").val("0.00");
				$("#txtgravado").val("0.00");
				$("#txtexento").val("0.00");
				$("#txtIva").val("0.00");
				$("#txtDescuento").val("0.00");
				$("#txtTotal").val("0.00");
				$("#txtTotalCompra").val("0.00");
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" disabled="" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});
			  }
			}
		});
		return false;
	    }
	}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE TRASPASOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE TRASPASOS */	 
$('document').ready(function()
{ 
     /* validation */
$("#updatetraspaso").validate({
        rules:
	    {
			recibe: { required: true },
			fechatraspaso: { required: true },
			observaciones: { required: false },
	    },
        messages:
	    {
            recibe:{ required: "Seleccione Sucursal Recibe" },
			fechatraspaso:{ required: "Ingrese Fecha de Traspaso" },
			observaciones:{ required: "Ingrese Observaciones" },
        },
	    submitHandler: function(form) {
	   			
		var data = $("#updatetraspaso").serialize();
        var id= $("#updatetraspaso").attr("data-id");
        var codtraspaso = $('#traspaso').val();
        var codsucursal = $('#sucursal').val();

			$.ajax({
			type : 'POST',
			url  : 'fortraspaso.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE TRASPASOS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																						
								});
							}  
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LA CANTIDAD DE DETALLES DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																						
								});
							}
							else {
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000 });
			 $('#detallestraspasoupdate').load("funciones.php?MuestraDetallesTraspasoUpdate=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal); 
			 $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
			 setTimeout("location.href='traspasos'", 5000);
			    
						
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR ACTUALIZACION DE TRASPASOS */ 




















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COMPRAS */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savecompra").validate({
        rules:
	    {
			codsucursal: { required: true },
			codcompra: { required: true },
			fechaemision: { required: true },
			fecharecepcion: { required: true },
			codproveedor: { required: true },
			tipocompra: { required: true },
			formacompra: { required: true },
			fechavencecredito: { required: true },
			medioabono: { required: false },
			montoabono: { required: false },
			observaciones: { required: false },
	    },
        messages:
	    {
			codsucursal:{ required: "Seleccione Sucursal" },
            codcompra:{ required: "Ingrese N&deg; de Compra" },
			fechaemision:{ required: "Ingrese Fecha de Emisi&oacute;n" },
			fecharecepcion:{ required: "Ingrese Fecha de Recepci&oacute;n" },
			codproveedor:{ required: "Seleccione Proveedor" },
			tipocompra:{ required: "Seleccione Tipo Compra" },
			formacompra:{ required: "Seleccione Método de Pago" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			medioabono:{ required: "Seleccione Método de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono" },
			observaciones:{ required: "Ingrese Observaciones" },
        },
	    submitHandler: function(form) {
	   			
		var data = $("#savecompra").serialize();
	    var nuevaFila ="<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
	    var total = $('#txtTotal').val();

        if (total==0.00) {
            
           $("#busquedaproductoc").focus();
           $('#busquedaproductoc').css('border-color','#ff7676');
           swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA COMPRA DE PRODUCTOS!", "error");
   
           return false;
 
        } else {
			
			$.ajax({
			type : 'POST',
			url  : 'forcompra.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
			},
			success :  function(data)
					   {						
			if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
									
								});
							}
			else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA COMPRAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																							
								});
							}  
			else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE COMPRA A CREDITO, NO PUEDE SER MENOR QUE LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																							
								});
							}
			else if(data==4){

			    $("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
												
				});
			}  
			else if(data==5){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTE CODIGO DE COMPRA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
																							
								});
							}
			else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000 });
			 $("#savecompra")[0].reset();
			 $("#carrito tbody").html("");
			 $(nuevaFila).appendTo("#carrito tbody");
			 $("#lblsubtotal").text("0.00");
			 $("#lblgravado").text("0.00");
			 $("#lblexento").text("0.00");
			 $("#lbliva").text("0.00");
			 $("#lbldescuento").text("0.00");
			 $("#lbltotal").text("0.00");
			 $("#txtsubtotal").val("0.00");
			 $("#txtgravado").val("0.00");
			 $("#txtexento").val("0.00");
			 $("#txtIva").val("0.00");
			 $("#txtDescuento").val("0.00");
			 $("#txtTotal").val("0.00");
			 $("#formacompra").attr('disabled', false);
			 $("#muestra_metodo").html('');
			 $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" disabled="" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
													
								});
							}
					   }
				});
				return false;
			 }
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE COMPRAS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COMPRAS */	 
$('document').ready(function()
{ 
     /* validation */
$("#updatecompra").validate({
         rules:
	    {
			codsucursal: { required: true },
			codcompra: { required: true },
			fechaemision: { required: true },
			fecharecepcion: { required: true },
			codproveedor: { required: true },
			tipocompra: { required: true },
			formacompra: { required: true },
			fechavencecredito: { required: true },
			medioabono: { required: false },
			montoabono: { required: false },
			observaciones: { required: false },
	    },
        messages:
	    {
			codsucursal:{ required: "Seleccione Sucursal" },
            codcompra:{ required: "Ingrese N&deg; de Compra" },
			fechaemision:{ required: "Ingrese Fecha de Emisi&oacute;n" },
			fecharecepcion:{ required: "Ingrese Fecha de Recepci&oacute;n" },
			codproveedor:{ required: "Seleccione Proveedor" },
			tipocompra:{ required: "Seleccione Tipo Compra" },
			formacompra:{ required: "Seleccione Método de Pago" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			medioabono:{ required: "Seleccione Método de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono" },
			observaciones:{ required: "Ingrese Observaciones" },
        },
	    submitHandler: function(form) {
	   			
		var data = $("#updatecompra").serialize();
        var id= $("#updatecompra").attr("data-id");
        var codcompra = $('#compra').val();
        var codsucursal = $('#sucursal').val();
        var status = $('#status').val();

			$.ajax({
			type : 'POST',
			url  : 'forcompra.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE COMPRA A CREDITO, NO PUEDE SER MENOR QUE LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																						
								});
							} 
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE COMPRAS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																						
								});
							} 
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000 });
			 $('#detallescompraupdate').load("funciones.php?MuestraDetallesCompraUpdate=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
			 $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
				if (status=="P") {
			 	setTimeout("location.href='compras'", 5000);
			    } else {
			 	setTimeout("location.href='cuentasxpagar'", 5000);
			    }
						
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR ACTUALIZACION DE COMPRAS */ 

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PAGOS A CREDITOS DE COMPRAS */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savepagocompra").validate({
      rules:
	  {
			codproveedor: { required: false },
			medioabono: { required: true },
			montoabono: { required: true, number : true},
	   },
       messages:
	   {
            codproveedor:{ required: "Por favor seleccione al Proveedor correctamente" },
			medioabono:{ required: "Seleccione Metodo de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono", number: "Ingrese solo digitos con 2 decimales" },
       },
	   submitHandler: function(form) {
	   			
		var data = $("#savepagocompra").serialize();
	    var codproveedor = $('#codproveedor').val();
	    var montoabono = $('#montoabono').val();

	    if (codcompra=='') {
            
        swal("Oops", "POR FAVOR SELECCIONE LA FACTURA ABONAR CORRECTAMENTE!", "error");

        return false;
 
        } else if (montoabono==0.00 || montoabono=="") {
            
        $("#montoabono").focus();
        $('#montoabono').css('border-color','#ff7676');
        swal("Oops", "POR FAVOR INGRESE UN MONTO DE ABONO VALIDO!", "error");

        return false;
 
        } else {
			
			$.ajax({
			type : 'POST',
			url  : 'cuentasxpagar.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
								});
							}    
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> EL MONTO ABONADO NO PUEDE SER MAYOR AL TOTAL DE FACTURA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																											
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000, });
             $('#ModalAbonosCompra').modal('hide');
			 $("#savepagocompra")[0].reset();
			 $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
			 $('#cuentasxpagar').html("");
			 $('#cuentasxpagar').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 $('#cuentasxpagar').load("consultas?CargaCuentasxPagar=si");
			 }, 200);
									
								});
							}
					   }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE PAGOS A CREDITOS DE COMPRAS */



























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COTIZACIONES */	 	 
$('document').ready(function()
{ 
	/* validation */
	$("#savecotizacion").validate({
		rules:
		{
			search_paciente: { required: true },
			search_especialista: { required: true },
			observaciones: { required: false },
		},
		messages:
		{
			search_paciente:{ required: "Realice la Búsqueda de Paciente" },
			search_especialista:{ required: "Realice la Búsqueda de Especialista" },
			observaciones:{ required: "Ingrese Observaciones" },
		},
		submitHandler: function(form) {

		var data = $("#savecotizacion").serialize();
		var nuevaFila ="<tr>"+"<td class='text-center' colspan=8><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var TotalPago = $('#txtTotal').val();
	
	    if (TotalPago==0.00) {
	            
	        $("#search_busqueda").focus();
            $('#search_busqueda').css('border-color','#ff7676');
	        swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA COTIZACIÓN!", "error");
            return false;
	
	    } else {

		$.ajax({

		type : 'POST',
		url  : 'forcotizacion.php',
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success :  function(data)
		{						
			if(data==1){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});
			}  
			else if(data==2){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA LA COTIZACIÓN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});

        	} else {

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: '<center> '+data+' </center>',
				theme: 'defaultTheme',
				layout: 'center',
				type: 'information',
				timeout: 5000 });
				$("#savecotizacion")[0].reset();
				$("#codpaciente").val("");
				//$("#codespecialista").val("");
				$("#btn-submit").attr('disabled', true);
				$("#carrito tbody").html("");
				$(nuevaFila).appendTo("#carrito tbody");
				$("#lblsubtotal").text("0.00");
				$("#lblgravado").text("0.00");
				$("#lblexento").text("0.00");
				$("#lbliva").text("0.00");
				$("#lbldescuento").text("0.00");
				$("#lbltotal").text("0.00");
				$("#txtsubtotal").val("0.00");
				$("#txtgravado").val("0.00");
				$("#txtexento").val("0.00");
				$("#txtIva").val("0.00");
				$("#txtDescuento").val("0.00");
				$("#txtTotal").val("0.00");
				$("#txtTotalCompra").val("0.00");
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" disabled="" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});
			  }
			}
		});
		return false;
	    }
	}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE COTIZACIONES */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COTIZACIONES */	 
$('document').ready(function()
{ 
     /* validation */
$("#updatecotizacion").validate({
        rules:
		{
			search_paciente: { required: true },
			search_especialista: { required: true },
			observaciones: { required: false },
		},
		messages:
		{
			search_paciente:{ required: "Realice la Búsqueda de Paciente" },
			search_especialista:{ required: "Realice la Búsqueda de Especialista" },
			observaciones:{ required: "Ingrese Observaciones" },
		},
	    submitHandler: function(form) {
	   			
		var data = $("#updatecotizacion").serialize();
        var id= $("#updatecotizacion").attr("data-id");
        var codcotizacion = $('#cotizacion').val();
        var codsucursal = $('#sucursal').val();

		$.ajax({
		type : 'POST',
		url  : 'forcotizacion.php',
	    async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success :  function(data)
				   {						
						if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000 });
		$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
							});
						}  
						else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE COTIZACIONES CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000 });
		$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
																					
							});
						} 
						else {
								
			$("#save").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'information',
         timeout: 8000 });
		 $('#detallescotizacionupdate').load("funciones.php?MuestraDetallesCotizacionUpdate=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal); 
		 $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
		 setTimeout("location.href='cotizaciones'", 5000);
		    
					
							});
						}
				   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR ACTUALIZACION DE COTIZACIONES */ 

/* FUNCION JQUERY PARA PROCESAR COTIZACION A FACTURA */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#procesacotizacion").validate({
        rules:
		{
			search_paciente: { required: true },
			search_especialista: { required: true },
			formapago: { required: true },
			montopagado: { required: true },
			fechavencecredito: { required: true },
			medioabono: { required: false },
			montoabono: { required: false },
			observaciones: { required: false },
		},
		messages:
		{
			search_paciente:{ required: "Realice la Búsqueda de Paciente" },
			search_especialista:{ required: "Realice la Búsqueda de Especialista" },
			formapago:{ required: "Seleccione Método de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			medioabono:{ required: "Seleccione Método de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono" },
			observaciones:{ required: "Ingrese Observaciones" },
		},
	    submitHandler: function(form) {
	   			
		var data = $("#procesacotizacion").serialize();
		var TotalPago = $('#txtTotal').val();
		var TotalAbono = $('#montoabono').val();
		var TipoPago = $('input:radio[name=tipopago]:checked').val();

		if (TotalPago==0.00) {
	            
	        $("#search_busqueda").focus();
            $('#search_busqueda').css('border-color','#ff7676');
	        swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA FACTURACIÓN!", "error");
            return false;
	 
	    } else if (TipoPago=="CREDITO" && parseFloat(TotalAbono) >= parseFloat(TotalPago)) {
	            
	        $("#montoabono").focus();
            $('#montoabono').css('border-color','#ff7676');
            swal("Oops", "EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");
            return false;
	
	    } else {
	 				
		$.ajax({
		type : 'POST',
		url  : 'cotizaciones.php',
	    async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success :  function(data)
				   {						
						if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA CONTINUAR CON FACTURACIÓN, VERIFIQUE NUEVAMENTE POR FAVOR...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
								
							});
						}   
						else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						} 
						else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA LA FACTURACIÓN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}
						else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}  
						else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}  
						else if(data==6){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA NO EXISTE EN ALMACEN, VERIFIQUE SU CREDITO DISPONIBLE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}  
						else{
								
			$("#save").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'information',
         timeout: 8000, });
		 $("#procesacotizacion")[0].reset();
         $("#codpaciente").val("0");
         $("#TextImporte").text("0.00");
         $("#TextPagado").text("0.00");
         $("#TextCambio").text("0.00");
         $('#myModal').modal('hide');
         $("#muestra_metodo").html('<div class="row"><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Método de Pago: <span class="symbol required"></span></label><i class="fa fa-bars form-control-feedback"></i><select name="formapago" id="formapago" class="form-control" required="" aria-required="true"><option value=""> -- SELECCIONE -- </option><option value="EFECTIVO">EFECTIVO</option><option value="CHEQUE">CHEQUE</option><option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option><option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option><option value="TARJETA PREPAGO">TARJETA PREPAGO</option><option value="TRANSFERENCIA">TRANSFERENCIA</option><option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option><option value="CUPON">CUPÓN</option><option value="OTROS">OTROS</option></select></div></div><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Monto Recibido: <span class="symbol required"></span></label><input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00"><input class="form-control" type="text" name="montopagado" id="montopagado" autocomplete="off" placeholder="Monto Recibido" onKeyUp="CalculoDevolucion();" value="0" required="" aria-required="true"><i class="fa fa-tint form-control-feedback"></i></div></div></div>');
		 $('#cotizaciones').load("consultas.php?CargaCotizaciones=si");
		 $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
								
									});
								}
						   }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA PROCESAR COTIZACION A FACTURA */



















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CITAS */	 	 
$('document').ready(function()
{ 
	/* validation */
	$("#savecitas").validate({
		rules:
		{
			search_paciente: { required: true },
			codespecialista: { required: true },
			descripcion: { required: true },
			color: { required: true },
			fechacita: { required: true, date : false },
			horacita: { required: true },
		},
		messages:
		{
			search_paciente:{ required: "Ingrese Criterio para tu Busqueda" },
			codespecialista:{ required: "Seleccione Especialista" },
			descripcion:{ required: "Ingrese Descripción de Cita" },
			color : { required : "Seleccione Color" },
			fechacita:{ required: "Ingrese Fecha de Cita", date: "Ingrese Fecha Valida"  },
			horacita:{ required: "Ingrese Hora de Cita" },
		},
		submitHandler: function(form) {

		var data = $("#savecitas").serialize();
		//var codsucursal = $('#codsucursal').val();
		//var codsede = $('#codsede2').val();
		//var codmedico = $('#codmedico').val();

		$.ajax({

		type : 'POST',
		url  : 'forcita.php',
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success :  function(data)
		{						
			if(data==1){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> REALICE LA BUSQUEDA DEL PACIENTE CORRECTAMENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				});
			}  
			else if(data==2){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> LA FECHA DE CITA PARA ODONTOLOGIA NO PUEDE SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

				});
			}
			else if(data==3){

			    $("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> LA HORA DE CITA PARA ODONTOLOGIA NO PUEDE SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

				});
			}
			else if(data==4){
									
				$("#save").fadeIn(1000, function(){
									
			    var n = noty({
                text: "<span class='fa fa-warning'></span> YA EXISTE UNA CITA PARA ODONTOLOGIA EN LA FECHA Y HORA INGRESADA, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                theme: 'defaultTheme',
                layout: 'center',
                type: 'error',
                timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 
				  }); 															
			}
        	else if(data==5)
        	{

        		$("#save").fadeIn(1000, function(){

        		var n = noty({
        		text: "<span class='fa fa-warning'></span> ESTA CITA PARA ODONTOLOGIA NO PUEDE SER ACTUALIZADA, YA FUE ATENDIDA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
        		theme: 'defaultTheme',
        		layut: 'center',
        		type: 'warning',
        		timeout: 5000 });
        		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

        		});

        	} else {

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: '<center> '+data+' </center>',
				theme: 'defaultTheme',
				layout: 'center',
				type: 'information',
				timeout: 5000 });
				$('#ModalAdd').modal('hide');
				$("#deletevento").attr('disabled', true);
				$("#cancelaevento").attr('disabled', true);
				$("#savecitas")[0].reset();
				$("#proceso").val("save");
				$("#error").html("");
				$('#cargacalendario').html("");
				$('html, body').animate({scrollTop:800}, 1000);
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				$('#cargacalendario').append('<center><i class="fa fa-spin fa-spinner"></i> Por Favor Espere, Cargando Calendario ......</center>').fadeIn("slow");
				setTimeout(function() {
				 	$('#cargacalendario').load("calendario?Calendario_Secundario=si");
				}, 1000);	

				});
			  }
			}
		});
		return false;
	}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE CITAS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CITAS */	 	 
$('document').ready(function()
{ 
	/* validation */
	$("#updatecita").validate({
		rules:
		{
			search_paciente: { required: true },
			codespecialista: { required: true },
			descripcion: { required: true },
			color: { required: true },
			fechacita: { required: true, date : false },
			horacita: { required: true },
		},
		messages:
		{
			search_paciente:{ required: "Ingrese Criterio para tu Busqueda" },
			codespecialista:{ required: "Seleccione Especialista" },
			descripcion:{ required: "Ingrese Descripción de Cita" },
			color : { required : "Seleccione Color" },
			fechacita:{ required: "Ingrese Fecha de Cita", date: "Ingrese Fecha Valida"  },
			horacita:{ required: "Ingrese Hora de Cita" },
		},
	    submitHandler: function(form) {	

		var data = $("#updatecita").serialize();
		var codcita = $('input#codcita').val();

        $.ajax({

        type : 'POST',
        url  : 'citasmedicas.php?codcita='+codcita,
        data : data,
        beforeSend: function()
        {	
        	$("#save").fadeOut();
        	$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
        },
        success :  function(data)
        {						
        	if(data==1){

        		$("#save").fadeIn(1000, function(){

        		var n = noty({
        		text: "<span class='fa fa-warning'></span> REALICE LA BUSQUEDA DEL BENEFICIARIO O FAMILIAR CORRECTAMENTE, VERIFIQUE NUEVAMENTE POR FAVOR...!",
        		theme: 'defaultTheme',
        		layout: 'center',
        		type: 'warning',
        		timeout: 5000 });
        		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
        		});

        	}  
        	else if(data==2){

        		$("#save").fadeIn(1000, function(){

        		var n = noty({
        		text: "<span class='fa fa-warning'></span> LA FECHA DE CITA PARA ODONTOLOGIA NO PUEDE SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
        		theme: 'defaultTheme',
        		layout: 'center',
        		type: 'warning',
        		timeout: 5000 });
        		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
        		});

        	}
        	else if(data==3){

        		$("#save").fadeIn(1000, function(){

        			var n = noty({
        			text: "<span class='fa fa-warning'></span> LA HORA DE CITA PARA ODONTOLOGIA NO PUEDE SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
        			theme: 'defaultTheme',
        			layout: 'center',
        			type: 'warning',
        			timeout: 5000 });
        			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
        			});
        	}
        	else if(data==4)
        	{

        		$("#save").fadeIn(1000, function(){

        			var n = noty({
        			text: "<span class='fa fa-warning'></span> YA EXISTE UNA CITA PARA ODONTOLOGIA EN LA FECHA Y HORA INGRESADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
        			theme: 'defaultTheme',
        			layout: 'center',
        			type: 'warning',
        			timeout: 5000 });
        			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
        			});

        	}
        	else if(data==5)
        	{

        		$("#save").fadeIn(1000, function(){

        			var n = noty({
        			text: "<span class='fa fa-warning'></span> ESTA CITA PARA ODONTOLOGIA NO PUEDE SER ACTUALIZADA, YA FUE ATENDIDA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
        			theme: 'defaultTheme',
        			layout: 'center',
        			type: 'warning',
        			timeout: 5000 });
        			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
        			});
        	} else {

        		$("#save").fadeIn(1000, function(){

        			var n = noty({
        			text: '<center> '+data+' </center>',
        			theme: 'defaultTheme',
        			layout: 'center',
        			type: 'information',
        			timeout: 5000 });
                    $('#cargacalendario').html("");
        			$("html, body").animate({ scrollTop: $('html, body').prop("scrollHeight")}, "fast");
        			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
                    $('#cargacalendario').append('<center><i class="fa fa-spin fa-spinner"></i> Por Favor Espere, Cargando Calendario ......</center>').fadeIn("slow");
                    setTimeout(function() {
                    $('#cargacalendario').load("calendario?Calendario_Secundario=si");
                        }, 100);  
        			});
        		}
        	}
        });
        return false;
        }
	   /* form submit */
    }); 	   
});
/*  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CITAS */





















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CAJAS PARA VENTAS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savecaja").validate({
      rules:
	  {
			nrocaja: { required: true },
			nomcaja: { required: true },
			codsucursal: { required: true },
			codigo: { required: true },
	   },
       messages:
	   {
            nrocaja:{ required: "Ingrese N&deg; de Caja" },
            nomcaja:{ required: "Ingrese Nombre de Caja" },
			codsucursal:{ required: "Seleccione Sucursal" },
			codigo:{ required: "Seleccione Responsable de Caja" },
       },
	   submitHandler: function(form) {
	   			
				var data = $("#savecaja").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'cajas.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								} 
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE N&deg; DE CAJA YA SE ENCUENTRA ASIGNADA EN ESTA SUCURSAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								} 
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE CAJA YA SE ENCUENTRA ASIGNADA EN ESTA SUCURSAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else if(data==4){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE USUARIO YA TIENE UNA CAJA ASIGNADA EN ESTA SUCURSAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
                 $('#myModalCaja').modal('hide');
				 $("#savecaja")[0].reset();
                 $("#proceso").val("save");
                 $("#codcaja").val("");
				 $('#cajas').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#cajas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#cajas').load("consultas?CargaCajas=si");
				 }, 200);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE CAJAS PARA VENTAS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ARQUEO DE CAJAS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savearqueo").validate({
      rules:
	  {
			codsucursal: { required: true },
			codcaja: { required: true },
			fecharegistro: { required: true },
			montoinicial: { required: true, number : true},
	   },
       messages:
	   {
			codsucursal:{ required: "Seleccione Sucursal" },
			codcaja: { required: "Seleccione Caja para Arqueo" },
			fecharegistro:{ required: "Ingrese Hora de Apertura", number: "Ingrese solo digitos con 2 decimales" },
			montoinicial:{ required: "Ingrese Monto Inicial", number: "Ingrese solo digitos con 2 decimales" },
       },
	   submitHandler: function(form) {
	   			
				var data = $("#savearqueo").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'arqueos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE UN ARQUEO DE ESTA CAJA DE COBRO ACTUALMENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
                 $('#myModalArqueo').modal('hide');
				 $("#savearqueo")[0].reset();
				 $('#arqueos').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#arqueos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#arqueos').load("consultas?CargaArqueos=si");
				 }, 200);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE ARQUEO DE CAJAS */

/* FUNCION JQUERY PARA VALIDAR CERRAR ARQUEO DE CAJAS  */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#cerrararqueo").validate({
      rules:
	  {
			fecharegistro: { required: true },
			montoinicial: { required: true, number : true},
			dineroefectivo: { required: true, number : true},
			comentarios: { required: false },
	   },
       messages:
	   {
			fecharegistro:{ required: "Ingrese Hora de Apertura", number: "Ingrese solo digitos con 2 decimales" },
			montoinicial:{ required: "Ingrese Monto Inicial", number: "Ingrese solo digitos con 2 decimales" },
			dineroefectivo:{ required: "Ingrese Monto en Efectivo", number: "Ingrese solo digitos con 2 decimales" },
			comentarios: { required: "Ingrese Observaci&oacute;n de Cierre" },
       },
	   submitHandler: function(form) {
                     		
		var data = $("#cerrararqueo").serialize();
		var dineroefectivo = $('#dineroefectivo').val();

        if (dineroefectivo==0.00 || dineroefectivo==0) {
        
		$("#dineroefectivo").focus();
		$('#dineroefectivo').val("");
		$('#dineroefectivo').css('border-color','#f0ad4e');
		swal("Oops", "POR FAVOR INGRESE UN MONTO VALIDO PARA EFECTIVO DISPONIBLE EN CAJA!", "error");
 
        return false;

        } else {
			
			$.ajax({
			type : 'POST',
			url  : 'arqueos.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-update").html('<span class="fa fa-archive"></span> Cerrar Caja');
									
								});
							}   
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR INGRESE UN MONTO VALIDO PARA EFECTIVO DISPONIBLE EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#btn-update").html('<span class="fa fa-archive"></span> Cerrar Caja');
																			
								});
							}
							 else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000 });
             $('#myModalCierre').modal('hide');
		     $("#cerrararqueo")[0].reset();
			 $('#arqueos').html("");
			 $("#btn-update").html('<span class="fa fa-archive"></span> Cerrar Caja');
			 $('#arqueos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#arqueos').load("consultas?CargaArqueos=si");
			 }, 200);
									
								});
							}
					   }
			});
			return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR CERRAR ARQUEO DE CAJAS */



















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MOVIMIENTOS EN CAJAS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savemovimiento").validate({
      rules:
	  {
			codcaja: { required: true },
			tipomovimiento: { required: true },
			descripcionmovimiento: { required: true },
			montomovimiento: { required: true, number : true },
			mediomovimiento: { required: true },
	   },
       messages:
	   {
			codcaja:{ required: "Seleccione Caja" },
            tipomovimiento:{ required: "Seleccione Tipo de Movimiento" },
			descripcionmovimiento:{ required: "Ingrese Descripci&oacute;n de Movimiento" },
			montomovimiento:{ required: "Ingrese Monto de Movimiento", number: "Ingrese solo digitos con 2 decimales" },
			mediomovimiento:{ required: "Seleccione Método de Movimiento" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savemovimiento").serialize();
				var monto = $('#montomovimiento').val();
	
	        if (monto==0.00 || monto==0) {
	            
				$("#montomovimiento").focus();
				$('#montomovimiento').val("");
				$('#montomovimiento').css('border-color','#f0ad4e');
				swal("Oops", "POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO EN CAJA!", "error");

                return false;

            } else {
				
				$.ajax({
				type : 'POST',
				url  : 'movimientos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
													
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																				
									});
								}     
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO PUEDE REALIZAR CAMBIO EN EL TIPO Y MEDIO DE MOVIMIENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																							
									});
								}  
								else if(data==4){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTA CAJA NO SE ENCUENTRA ABIERTA PARA REALIZAR MOVIMIENTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																							
									});
								}  
								else if(data==5){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL MOVIMIENTO DE EGRESO DEBE DE SER SOLO EFECTIVO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																							
									});
								}  
								else if(data==6){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL MONTO A RETIRAR EN EFECTIVO NO EXISTE EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																							
									});
								}  
								else if(data==7){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE MOVIMIENTO NO PUEDE SER ACTUALIZADO, EL ARQUEO DE CAJA ASOCIADO SE ENCUENTRA CERRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																							
									});
								}  
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
                 $('#myModalMovimiento').modal('hide');
				 $("#savemovimiento")[0].reset();
                 $("#proceso").val("save");	
                 $("#codmovimiento").val("");
				 $('#movimientos').html("");
				 $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
				 $('#movimientos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#movimientos').load("consultas?CargaMovimientos=si");
				 }, 200);
										
									});
								}
						   }
				});
				return false;
			}		}
	   /* form submit */	
    });    
});
/*  FUNCION PARA VALIDAR REGISTRO DE MOVIMIENTOS EN CAJAS */


























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ODONTOLOGIA */	 	 
$('document').ready(function()
{ 
	/* validation */
	$("#saveodontologia").validate({
		rules:
		{
			formapago: { required: true },
			montopagado: { required: true },
			fechavencecredito: { required: true },
			montoabono: { required: true },
			cualestratamiento: { required: false },
			cualesingesta: { required: false },
			cualesalergias: { required: false },
			cualeshemorragias: { required: false },
			ultimavisitaodontologia: { required: false },
			cuantoscepillados: { required: false },
			cuantascedasdental: { required: false },
			ultimavisitaodontologia: { required: false, date: false },
			observacionperiodontal: { required: false },
			otrosdental: { required: false },
			observacionexamendental: { required: false },
			presuntivo: { required: false },
			definitivo: { required: false },
			pronostico: { required: false },
		},
		messages:
		{
			formapago:{ required: "Seleccione Método de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			montoabono:{ required: "Ingrese Monto de Abono" },
			cualestratamiento: { required: "Ingrese Tratamiento Médico" },
			cualesingesta: { required: "Ingrese Cuales Medicamentos" },
			cualesalergias: { required: "Ingrese Cuales Alérgicas" },
			cualeshemorragias: { required: "Ingrese Cuales Hemorragias" },
			ultimavisitaodontologia: { required: "Ingrese Ultima Visita" },
			cuantoscepillados: { required: "Ingrese Cuantos Cepilados" },
			cuantascedasdental: { required: "Ingrese Cuantas Seda" },
			ultimavisitaodontologia:{ required: "Ingrese Fecha Ultima Odontologia", date: "Ingrese fecha Valida"  },
			observacionperiodontal: { required: "Ingrese Observaciones de Estado Periodontal" },
			otrosdental: { required: "Ingrese Otros Examen Dental" },
			observacionexamendental: { required: "Ingrese Observaciones de Examen Dental" },
			presuntivo: { required: "Ingrese Dx Presuntivo" },
			definitivo: { required: "Ingrese Dx Definitivo" },
			pronostico: { required: "Ingrese Pron&oacute;stico de Paciente" },
		},
		submitHandler: function(form) {

		var data = $("#saveodontologia").serialize();
		var formData = new FormData($("#saveodontologia")[0]);
		var nuevaFila ="<tr>"+"<td class='text-center' colspan=8><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var codcita = $('#cita').val();
		var codpaciente = $('#paciente').val();
		var estados = $('#estados').val();
		var TotalPago = $('#txtTotal').val();
		var TotalAbono = $('#montoabono').val();
		var TipoPago = $('input:radio[name=tipopago]:checked').val();
	
	    if (estados=="") {
				
			swal("Oops", "POR FAVOR DEBE DE AGREGAR REFERENCIAS DE ODONTOGRAMA AL PACIENTE!", "error");
			return false;
	 
	    } else {

		$.ajax({
		type : 'POST',
		url  : 'forodontologia.php',
	    async : false,
		data : formData,
		//necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success :  function(data)
		{						
			if(data==1){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});
			}  
			else if(data==2){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA LA FACTURACIÓN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});
			} 
			else if(data==3){
									
				$("#save").fadeIn(1000, function(){
									
			    var n = noty({
                text: "<span class='fa fa-warning'></span> POR FAVOR SELECCIONE UN PLAN DE TRATAMIENTO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                theme: 'defaultTheme',
                layout: 'center',
                type: 'warning',
                timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
								 
				}); 															
			}
			else if(data==4){

			    $("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> DEBE DE REGISTRAR LAS REFERENCIAS DEL ODONTOGRAMA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});
			}
			else if(data==5){
									
				$("#save").fadeIn(1000, function(){
									
			    var n = noty({
                text: "<span class='fa fa-warning'></span> NO DEBE DE EXISTIR DX PRESUNTIVOS REPETIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                theme: 'defaultTheme',
                layout: 'center',
                type: 'warning',
                timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
								 
				}); 															
			}
        	else if(data==6){
									
				$("#save").fadeIn(1000, function(){
									
			    var n = noty({
                text: "<span class='fa fa-warning'></span> NO DEBE DE EXISTIR DX DEFINITIVOS REPETIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                theme: 'defaultTheme',
                layout: 'center',
                type: 'warning',
                timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
								 
				}); 															
			}
        	else if(data==7){

			    $("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});
			}
        	else if(data==8){

			    $("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> ESTE PACIENTE YA TIENE UNA CONSULTA ODONTOLOGICA EN LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'error',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				
				});
			} else {

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: '<center> '+data+' </center>',
				theme: 'defaultTheme',
				layout: 'center',
				type: 'information',
				timeout: 5000 });
				/*$("#save").html('<center> '+data+' </center>');*/
                $('#myModalFacturacion').modal('hide');
				$("#saveodontologia")[0].reset();
				$("#codcita").val("");
				$("#codespecialista").val("");
				$("#codpaciente").val("");
				$("#carrito tbody").html("");
				$(nuevaFila).appendTo("#carrito tbody");
				$("#lblsubtotal").text("0.00");
				$("#lblgravado").text("0.00");
				$("#lblexento").text("0.00");
				$("#lbliva").text("0.00");
				$("#lbldescuento").text("0.00");
				$("#lbltotal").text("0.00");
				$("#txtsubtotal").val("0.00");
				$("#txtgravado").val("0.00");
				$("#txtexento").val("0.00");
				$("#txtIva").val("0.00");
				$("#txtDescuento").val("0.00");
				$("#txtTotal").val("0.00");
				$("#muestrahistorial").html("");
				$("#tabla").html('<div class="col-md-12"><div class="form-group has-feedback"><label class="control-label">Dx Presuntivo: <span class="symbol required"></span></label><input type="hidden" name="idciepresuntivo[]" id="idciepresuntivo"/><input type="text" class="form-control" name="presuntivo[]" id="presuntivo" onKeyUp="this.value=this.value.toUpperCase(); autocompletar(this.name);" placeholder="Ingrese Nombre de Dx para tu Búsqueda" title="Ingrese Dx Presuntivo" autocomplete="off"><i class="fa fa-pencil form-control-feedback"></i></div></div>');
                $("#tabla2").html('<div class="col-md-12"><div class="form-group has-feedback"><label class="control-label">Dx Definitivo: <span class="symbol required"></span></label><input type="hidden" name="idciedefinitivo[]" id="idciedefinitivo"/><input type="text" class="form-control" name="definitivo[]" id="definitivo" onKeyUp="this.value=this.value.toUpperCase(); autocompletar2(this.name);" placeholder="Ingrese Nombre de Dx para tu Búsqueda" title="Ingrese Dx Definitivo" autocomplete="off"><i class="fa fa-pencil form-control-feedback"></i></div></div>');
				$("#foto").attr("src","fotos/img.png");
				$("#muestracitasxdia").text("");
				$("#guarda").attr('disabled', true);
				$("#agrega").attr('disabled', true);
				$("#btn-submit").attr('disabled', true);
				$("#tablaTratamiento").html("");
				cargarDientes("seccionDientes", "dientes.php", '', '0', '0');
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" disabled="" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');
				setTimeout("location.href='forcita'", 200);
				});
			  }
			}
		});
		return false;
	    }
	}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE ODONTOLOGIA */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ODONTOLOGIA */	 	 
$('document').ready(function()
{ 
	/* validation */
	$("#updateodontologia").validate({
		rules:
		{
			cualestratamiento: { required: false },
			cualesingesta: { required: false },
			cualesalergias: { required: false },
			cualeshemorragias: { required: false },
			ultimavisitaodontologia: { required: false },
			cuantoscepillados: { required: false },
			cuantascedasdental: { required: false },
			ultimavisitaodontologia: { required: false, date: false },
			observacionperiodontal: { required: false },
			otrosdental: { required: false },
			observacionexamendental: { required: false },
			presuntivo: { required: false },
			definitivo: { required: false },
			pronostico: { required: false },
		},
		messages:
		{
			cualestratamiento: { required: "Ingrese Tratamiento Médico" },
			cualesingesta: { required: "Ingrese Cuales Medicamentos" },
			cualesalergias: { required: "Ingrese Cuales Alérgicas" },
			cualeshemorragias: { required: "Ingrese Cuales Hemorragias" },
			ultimavisitaodontologia: { required: "Ingrese Ultima Visita" },
			cuantoscepillados: { required: "Ingrese Cuantos Cepilados" },
			cuantascedasdental: { required: "Ingrese Cuantas Seda" },
			ultimavisitaodontologia:{ required: "Ingrese Fecha Ultima Odontologia", date: "Ingrese fecha Valida"  },
			observacionperiodontal: { required: "Ingrese Observaciones de Estado Periodontal" },
			otrosdental: { required: "Ingrese Otros Examen Dental" },
			observacionexamendental: { required: "Ingrese Observaciones de Examen Dental" },
			presuntivo: { required: "Ingrese Dx Presuntivo" },
			definitivo: { required: "Ingrese Dx Definitivo" },
			pronostico: { required: "Ingrese Pron&oacute;stico de Paciente" },
		},
	    submitHandler: function(form) {	

		var data = $("#updateodontologia").serialize();
		var formData = new FormData($("#updateodontologia")[0]);
		var cododontologia = $('input#cododontologia').val();
		var codcita = $('#cita').val();
		var codpaciente = $('#paciente').val();
		var estados = $('#estados').val();
	
	    if (estados=="") {
				
			swal("Oops", "POR FAVOR DEBE DE AGREGAR REFERENCIAS DE ODONTOGRAMA AL PACIENTE!", "error");
			return false;
	 
	    } else {

        $.ajax({
		type : 'POST',
		url  : 'forodontologia.php',
	    async : false,
		data : formData,
		//necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
		beforeSend: function()
        {	
        	$("#save").fadeOut();
			$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
        },
        success :  function(data)
        {						
        	if(data==1){

        		$("#save").fadeIn(1000, function(){

        		var n = noty({
        		text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
        		theme: 'defaultTheme',
        		layout: 'center',
        		type: 'warning',
        		timeout: 5000 });
				$("#submit_update").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');																			
			    });

        	}  
        	else if(data==2){
									
				$("#save").fadeIn(1000, function(){
									
			    var n = noty({
                text: "<span class='fa fa-warning'></span> POR FAVOR SELECCIONE UN PLAN DE TRATAMIENTO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                theme: 'defaultTheme',
                layout: 'center',
                type: 'warning',
                timeout: 5000 });
				$("#submit_update").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-EDIT"></span> Actualizar</button>');
								 
				}); 															
			}
        	else if(data==3){

			    $("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> DEBE DE REGISTRAR LAS REFERENCIAS DEL ODONTOGRAMA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_update").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
				
				});
			}
        	else if(data==5){
									
				$("#save").fadeIn(1000, function(){
									
			    var n = noty({
                text: "<span class='fa fa-warning'></span> NO DEBE DE EXISTIR DX PRESUNTIVOS REPETIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                theme: 'defaultTheme',
                layout: 'center',
                type: 'warning',
                timeout: 5000 });
				$("#submit_update").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
								 
				}); 															
			}
        	else if(data==6){
									
				$("#save").fadeIn(1000, function(){
									
			    var n = noty({
                text: "<span class='fa fa-warning'></span> NO DEBE DE EXISTIR DX DEFINITIVOS REPETIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                theme: 'defaultTheme',
                layout: 'center',
                type: 'warning',
                timeout: 5000 });
				$("#submit_update").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
								 
				}); 															
			} else {

        		$("#save").fadeIn(1000, function(){

        			var n = noty({
        			text: '<center> '+data+' </center>',
        			theme: 'defaultTheme',
        			layout: 'center',
        			type: 'information',
        			timeout: 5000 });
				   $("#submit_update").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>');
				    setTimeout("location.href='odontologia'", 5000);	
                      
        			});
        		}
        	}
        });
        return false;
           }
        }
	   /* form submit */
    }); 	   
});
/*  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE ODONTOLOGIA */

















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CONSENTIMIENTO */	 	 
$('document').ready(function()
{ 
	/* validation */
	$("#saveconsentimiento").validate({
		rules:
		{
			search_paciente: { required: true },
			codespecialista: { required: true },
			procedimiento: { required: true },
			observaciones: { required: true },
			doctestigo: { required: true },
			nombretestigo: { required: true },
			nofirmapaciente: { required: false },
		},
		messages:
		{
			search_paciente: { required: "Realice la Búsqueda del Paciente" },
			codespecialista: { required: "Seleccione Especialista" },
			procedimiento: { required: "Ingrese Procedimiento" },
			observaciones: { required: "Ingrese Observaciones" },
			doctestigo: { required: "Ingrese Nº de Documento" },
			nombretestigo: { required: "Ingrese Nombre de Testigo" },
			nofirmapaciente: { required: "Ingrese Motivo No Firma" },
		},
		submitHandler: function(form) {

		var data = $("#saveconsentimiento").serialize();

		$.ajax({

		type : 'POST',
		url  : 'forconsentimiento.php',
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success :  function(data)
		{						
			if(data==1){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> REALICE LA BUSQUEDA DEL PACIENTE CORRECTAMENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				});
			}  
			else if(data==2){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> ESTE PACIENTE YA TIENE UN CONSENTIMIENTO EN LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

				});

        	} else {

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: '<center> '+data+' </center>',
				theme: 'defaultTheme',
				layout: 'center',
				type: 'information',
				timeout: 5000 });
				$("#saveconsentimiento")[0].reset();
				$("#muestraconsentimiento").html("");
				$("#codpaciente").val("");
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				});
			  }
			}
		});
		return false;
	}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE CONSENTIMIENTO */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONSENTIMIENTO */	 	 
$('document').ready(function()
{ 
	/* validation */
	$("#updateconsentimiento").validate({
		rules:
		{
			procedimiento: { required: true },
			observaciones: { required: true },
			doctestigo: { required: true },
			nombretestigo: { required: true },
			nofirmapaciente: { required: false },
		},
		messages:
		{
			procedimiento: { required: "Ingrese Procedimiento" },
			observaciones: { required: "Ingrese Observaciones" },
			doctestigo: { required: "Ingrese Nº de Documento" },
			nombretestigo: { required: "Ingrese Nombre de Testigo" },
			nofirmapaciente: { required: "Ingrese Motivo No Firma" },
		},
	    submitHandler: function(form) {	

		var data = $("#updateconsentimiento").serialize();
		var codconsentimiento = $('input#codconsentimiento').val();

        $.ajax({

        type : 'POST',
        url  : 'forconsentimiento.php?codconsentimiento='+codconsentimiento,
        data : data,
        beforeSend: function()
        {	
        	$("#save").fadeOut();
        	$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
        },
        success :  function(data)
        {						
        	if(data==1){

        		$("#save").fadeIn(1000, function(){

        		var n = noty({
        		text: "<span class='fa fa-warning'></span> REALICE LA BUSQUEDA DEL PACIENTE CORRECTAMENTE, VERIFIQUE NUEVAMENTE POR FAVOR...!",
        		theme: 'defaultTheme',
        		layout: 'center',
        		type: 'warning',
        		timeout: 5000 });
        		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
        		});

        	}  
        	else if(data==2){

        		$("#save").fadeIn(1000, function(){

        		var n = noty({
        		text: "<span class='fa fa-warning'></span> ESTE PACIENTE YA TIENE UN CONSENTIMIENTO EN LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
        		theme: 'defaultTheme',
        		layout: 'center',
        		type: 'warning',
        		timeout: 5000 });
        		$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
        		});

        	} else {

        		$("#save").fadeIn(1000, function(){

        			var n = noty({
        			text: '<center> '+data+' </center>',
        			theme: 'defaultTheme',
        			layout: 'center',
        			type: 'information',
        			timeout: 5000 });
        			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
				    setTimeout("location.href='consentimientos'", 5000);	
        			});
        		}
        	}
        });
        return false;
        }
	   /* form submit */
    }); 	   
});
/*  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONSENTIMIENTO */
























/* FUNCION JQUERY PARA VALIDAR COBRAR VENTA */
$('document').ready(function()
{	
    /* validation */
	$("#cobrarventa").validate({
        rules:
		{
			formapago: { required: true },
			montopagado: { required: true },
			fechavencecredito: { required: true },
			medioabono: { required: false },
			montoabono: { required: false },
			observaciones: { required: false },
		},
		messages:
		{
			formapago:{ required: "Seleccione Método de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			medioabono:{ required: "Seleccione Método de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono" },
			observaciones:{ required: "Ingrese Observaciones" },
		},
	    submitHandler: function(form) {
                     		
		var data = $("#cobrarventa").serialize();
	
		$.ajax({
		type : 'POST',
		url  : 'facturaspendientes.php',
	    async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_cierre").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');

		},
		success :  function(data)
				   {						
						if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
         $("#submit_cierre").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');

							});
						}  
						else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE CAJA ASIGNADA PARA PROCESAR FACTURAS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
         $("#submit_cierre").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}
			else if(data==3){

			$("#save").fadeIn(1000, function(){

		var n = noty({
		text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
		theme: 'defaultTheme',
		layout: 'center',
		type: 'warning',
		timeout: 5000 });
		$("#submit_cierre").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
				
				});
			}
			else if(data==4){

			    $("#save").fadeIn(1000, function(){

		var n = noty({
		text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
		theme: 'defaultTheme',
		layout: 'center',
		type: 'warning',
		timeout: 5000 });
		$("#submit_cierre").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
				
				});
			}  
			else{
								
			$("#save").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'information',
         timeout: 8000, });
		 $("#cobrarventa")[0].reset();
		 $('#datos_cajero_cobro').html("");
		 $("#txtimporte").text("0.00");
         $("#txtpagado").text("0.00");
         $("#textcambio").text("0.00");
         $("#txtdocumento").text("");
         $("#txtpaciente").text("");
         $('#myModalPago').modal('hide');
		 $('#ventas_pendientes').html("");
		 $("#submit_cierre").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
		 $('#ventas_pendientes').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		 setTimeout(function() {
		 	$('#ventas_pendientes').load("consultas?CargaVentasPendientes=si");
		 }, 200);
									
								});
							}
					   }
			   });
			return false;
			}
	   /* form submit */
      }); 
 });  
 /* FUNCION PARA VALIDAR COBRAR VENTA */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE VENTAS */	 	 
$('document').ready(function()
{ 
	/* validation */
	$("#saveventa").validate({
		rules:
		{
			search_paciente: { required: true },
			search_especialista: { required: true },
			formapago: { required: true },
			montopagado: { required: true },
			fechavencecredito: { required: true },
			medioabono: { required: false },
			montoabono: { required: false },
			observaciones: { required: false },
		},
		messages:
		{
			search_paciente:{ required: "Realice la Búsqueda de Paciente" },
			search_especialista:{ required: "Realice la Búsqueda de Especialista" },
			formapago:{ required: "Seleccione Método de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			medioabono:{ required: "Seleccione Método de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono" },
			observaciones:{ required: "Ingrese Observaciones" },
		},
		submitHandler: function(form) {

		var data = $("#saveventa").serialize();
		var nuevaFila ="<tr>"+"<td class='text-center' colspan=8><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var TotalPago = $('#txtTotal').val();
		var TotalAbono = $('#montoabono').val();
		var TipoPago = $('input:radio[name=tipopago]:checked').val();
	
	    if (TotalPago==0.00) {
	            
	        $("#search_busqueda").focus();
            $('#search_busqueda').css('border-color','#ff7676');
	        swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA FACTURACIÓN!", "error");
            return false;
	 
	    } else if (TipoPago=="CREDITO" && parseFloat(TotalAbono) >= parseFloat(TotalPago)) {
	            
	        $("#montoabono").focus();
            $('#montoabono').css('border-color','#ff7676');
            swal("Oops", "EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");
            return false;
	
	    } else {

		$.ajax({

		type : 'POST',
		url  : 'forfacturacion.php',
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success :  function(data)
		{						
			if(data==1){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA CONTINUAR CON FACTURACIÓN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
				
				});
			}  
			else if(data==2){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
				
				});
			}  
			else if(data==3){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA LA FACTURACIÓN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
				
				});
			} 
			else if(data==4){

			    $("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
				
				});
			}
			else if(data==5){

			    $("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
				
				});
			}
        	else if(data==6)
        	{

        		$("#save").fadeIn(1000, function(){

        		var n = noty({
        		text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
        		theme: 'defaultTheme',
        		layut: 'center',
        		type: 'warning',
        		timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');

        		});

        	} else {

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: '<center> '+data+' </center>',
				theme: 'defaultTheme',
				layout: 'center',
				type: 'information',
				timeout: 5000 });
				$("#saveventa")[0].reset();
				$("#codpaciente").val("");
				$("#codespecialista").val("");
				$("#btn-submit").attr('disabled', true);
				$("#carrito tbody").html("");
				$(nuevaFila).appendTo("#carrito tbody");
				$("#lblsubtotal").text("0.00");
				$("#lblgravado").text("0.00");
				$("#lblexento").text("0.00");
				$("#lbliva").text("0.00");
				$("#lbldescuento").text("0.00");
				$("#lbltotal").text("0.00");
				$("#txtsubtotal").val("0.00");
				$("#txtgravado").val("0.00");
				$("#txtexento").val("0.00");
				$("#txtIva").val("0.00");
				$("#txtDescuento").val("0.00");
				$("#txtTotal").val("0.00");
				$("#txtTotalCompra").val("0.00");
				$("#muestra_metodo").html('<div class="row"><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Método de Pago: <span class="symbol required"></span></label><i class="fa fa-bars form-control-feedback"></i><select name="formapago" id="formapago" class="form-control" required="" aria-required="true"><option value=""> -- SELECCIONE -- </option><option value="EFECTIVO">EFECTIVO</option><option value="CHEQUE">CHEQUE</option><option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option><option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option><option value="TARJETA PREPAGO">TARJETA PREPAGO</option><option value="TRANSFERENCIA">TRANSFERENCIA</option><option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option><option value="CUPON">CUPÓN</option><option value="OTROS">OTROS</option></select></div></div><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Monto Recibido: <span class="symbol required"></span></label><input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00"><input class="form-control" type="text" name="montopagado" id="montopagado" autocomplete="off" placeholder="Monto Recibido" onKeyUp="CalculoDevolucion();" value="0" required="" aria-required="true"><i class="fa fa-tint form-control-feedback"></i></div></div></div>');
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" disabled="" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
				
				});
			  }
			}
		});
		return false;
	    }
	}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE VENTAS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE VENTAS */	 
$('document').ready(function()
{ 
     /* validation */
$("#updateventa").validate({
        rules:
		{
			search_paciente: { required: true },
			search_especialista: { required: true },
			formapago: { required: true },
			montopagado: { required: true },
			fechavencecredito: { required: true },
			medioabono: { required: false },
			montoabono: { required: false },
			observaciones: { required: false },
		},
		messages:
		{
			search_paciente:{ required: "Realice la Búsqueda de Paciente" },
			search_especialista:{ required: "Realice la Búsqueda de Especialista" },
			formapago:{ required: "Seleccione Método de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			medioabono:{ required: "Seleccione Método de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono" },
			observaciones:{ required: "Ingrese Observaciones" },
		},
	   submitHandler: function(form) {
	   			
		var data = $("#updateventa").serialize();
        var id= $("#updateventa").attr("data-id");
        var codventa = $('#venta').val();
        var codsucursal = $('#sucursal').val();
        var status = $('#status').val();

			$.ajax({
			type : 'POST',
			url  : 'forfacturacion.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#submit_update").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
			},
			success :  function(data)
					   {						
					if(data==1){

				$("#save").fadeIn(1000, function(){

				var n = noty({
				text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA CONTINUAR CON FACTURACIÓN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
				theme: 'defaultTheme',
				layout: 'center',
				type: 'warning',
				timeout: 5000 });
				$("#submit_update").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
				
				         });
			        }  
			    else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_update").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
						});
					} 
				else if(data==3){

		    $("#save").fadeIn(1000, function(){

			var n = noty({
			text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
			theme: 'defaultTheme',
			layout: 'center',
			type: 'warning',
			timeout: 5000 });
			$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
			
			            });
		            }  
				else if(data==4){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE FACTURAS CON CANTIDAD IGUAL A CERO, NO PUEDE SER MENOR QUE LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																						
						});
					}
				else if(data==5){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA EN DETALLES NO EXISTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000 });
			$("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																						
						});
					} 
				else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000 });
			 $('#detallesventaupdate').load("funciones.php?MuestraDetallesVentaUpdate=si&codventa="+codventa+"&codsucursal="+codsucursal); 
			 $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
			 setTimeout("location.href='facturaciones'", 5000);
			    
						
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR ACTUALIZACION DE VENTAS */ 



















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PAGOS A CREDITOS */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savepago").validate({
      rules:
	  {
			codpaciente: { required: false },
			medioabono: { required: true },
			montoabono: { required: true, number : true},
	   },
       messages:
	   {
            codpaciente:{ required: "Seleccione al Paciente correctamente" },
			medioabono:{ required: "Seleccione Metodo de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono", number: "Ingrese solo digitos con 2 decimales" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#savepago").serialize();
		    var codcaja = $('#codcaja').val();
		    var codpaciente = $('#codpaciente').val();
		    var montoabono = $('#montoabono').val();

		if (codcaja == '' || codcaja == 0) {
	            
            swal("Oops", "POR FAVOR DEBE DE REALIZAR EL ARQUEO DE SU CAJA PARA PROCESAR ABONOS DE CREDITOS!", "error");
            return false;
	 
	    } else if (codpaciente == '') {
	            
            swal("Oops", "SELECCIONE LA FACTURA ABONAR CORRECTAMENTE!", "error");
            return false;
	 
	    } else if (montoabono == 0.00) {
	            
	        $("#montoabono").focus();
            $('#montoabono').css('border-color','#f0ad4e');
            swal("Oops", "POR FAVOR INGRESE UN MONTO DE ABONO VALIDO!", "error");
            return false;
	 
	    } else {
				
				$.ajax({
				type : 'POST',
				url  : 'creditos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#submit_guardar").html('<button type="button" class="btn btn-danger"><i class="fa fa-refresh"></i> Verificando...</button>');
        		},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA REALIZAR VENTAS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
													
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																							
									});
								}    
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL MONTO ABONADO NO PUEDE SER MAYOR AL TOTAL DE FACTURA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000 });
				$("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
																							
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000 });
                 $('#myModalPago').modal('hide');
				 $("#savepago")[0].reset();
				 $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>');																			
				 $('#creditos').html("");
				 $('#creditos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 $('#creditos').load("consultas?CargaCreditos=si");
				 }, 200);
										
									});
								}
						   }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FUNCION PARA VALIDAR REGISTRO DE PAGOS A CREDITOS */

