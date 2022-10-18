function eliminateDuplicates(arr) {
 var i,
     len=arr.length,
     out=[],
     obj={};

 for (i=0;i<len;i++) {
    obj[arr[i]]=0;
 }
 for (i in obj) {
    out.push(i);
 }
 return out;
}

function hoverTxtDiente(idTxtDiente)
{
	var idDiente=idTxtDiente.substring(3, 6);
	var css=
	{
		"box-shadow": "0px 0px 10px blue"
	}
	$("#"+idDiente).css(css);
}

function outTxtDiente(idTxtDiente)
{
	var idDiente=idTxtDiente.substring(3, 6);
	var css=
	{
		"box-shadow": "none"
	}
	$("#"+idDiente).css(css);
}

function seleccionarCara(idCaraDiente)
{
	
	$("#txtCaraTratada").val(idCaraDiente);

}

function seleccionarDiente(idDiente)
{
	$("#txtIdentificadorDienteGeneral").val(idDiente);
	$("#txtDienteTratado").val(idDiente);
}

function agregarTratamiento(diente, cara, estado)
{
	if(diente=="")
	{
		swal("Oops", "POR FAVOR DEBE DE SELECCIONAR EL DIENTE A TRATAR!", "error");
		return false;
	} 
	else if(cara=="")
	{
		swal("Oops", "POR FAVOR DEBE DE SELECCIONAR LA CARA DEL DIENTE A TRATAR!", "error");
		return false;
	} 
	
	else if(estado=="")
	{
		swal("Oops", "POR FAVOR DEBE DE SELECCIONAR UNA REFERENCIA PARA AGREGAR!", "error");
		return false;
	} 

	var agregarFila=true;

	$("#tablaTratamiento").find("tr").each(function(index, elemento) 
    {
    	var dienteAsignado;

    	if(!agregarFila)
    	{
    		return false;
    	}

        $(elemento).find("td").each(function(index2, elemento2)
        {
        	if(index2==0)
        	{
        		dienteAsignado=$(elemento2).text();
        	}
        	switch(index2)
        	{
					
				case 2:
        			var partesEstado=$(elemento2).text().split("-");
        			if(partesEstado[0]!="15" && partesEstado[0]!="16" && partesEstado[0]!="17" && partesEstado[0]!="18")
        			//if((partesEstado[1]==estado.split("-")[1]) && dienteAsignado==diente && cara!=cara)
        			{
        				if((partesEstado[1]==estado.split("-")[1]) && dienteAsignado==diente)
        				{
        					swal("Oops", "EL TRATAMIENTO YA FUE ASIGNADO !", "error");
        					agregarFila=false;
        				}
        			}
        		break;
        	}
        });
    });


	if(agregarFila)
	{
		var filaHtml="<tr class='text-center font-12'><td>"+diente+"</td><td>"+cara+"</td><td>"+estado+"</td><td><span style='cursor: pointer;' onclick='quitarTratamiento(this);'><i class='mdi mdi-delete font-22 text-danger'></i></span></td></tr>";
        document.getElementById('txtDienteTratado').value = '';
        document.getElementById('txtCaraTratada').value = '';
        document.getElementById('cbxEstado').value = '';
        $("#tablaTratamiento > tbody").append(filaHtml);
		$("#divTratamiento").scrollTop($("#tablaTratamiento").height());
	}
}

function quitarTratamiento(elemento)
{
	$(elemento).parent().parent().remove();
}

function recuperarDatosTratamiento(callback)
{
	var codcita;
	var codpaciente;
    var codsucursal;
	var estados="";

	codcita=$("#codcita").val();
	codpaciente=$("#codpaciente").val();
    codsucursal=$("#codsucursal").val();

	$("#tablaTratamiento").find("tr").each(function(index, elemento) 
    {
        $(elemento).find("td").each(function(index2, elemento2)
        {
        	estados+=$(elemento2).text()+"_";
        });
    });

    //descripcion=$("#txtDescripcion").val();
    estados=estados.substring(0, estados.length-2);

    callback(codcita, codpaciente, codsucursal, estados);
}

var urlBase = function () {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
		return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search).length - pathName.length));
        //return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    };


function guardarTratamiento()
{
	
	recuperarDatosTratamiento(function(codcita, codpaciente, codsucursal, estados)
	{
		var s = estados.split("__");
		var d = eliminateDuplicates(s);
		
		if(estados=="")
		{
			swal("Oops", "POR FAVOR DEBE DE AGREGAR REFERENCIAS DE ODONTOGRAMA AL PACIENTE!", "error");
			return false;
		}

		$.post("registrareferencias.php",
	    {
	    	
			codcita: codcita,
			codpaciente: codpaciente,
            codsucursal: codsucursal,
	    	estados: d
	    }, 
														  
														  
	    function(pagina)
	    {
			limpiarDatosTratamiento();
	    	var n = noty({
        		text: "<span class='fa fa-check-square-o'></span> REFERENCIAS AGREGADA EXITOSAMENTE",
        		theme: 'defaultTheme',
        		layout: 'center',
        		type: 'success',
        		timeout: 5000 });
        		//$("#seccionPaginaAjax").html(pagina);

	    	setTimeout(function()
	    	{
	    		$("#seccionPaginaAjax").html("");
	    	}, 7000);
			
	    }).done(function(){
        $("#divTratamiento").load("funciones.php?BuscaTablaTratamiento=si&codcita="+codcita+"&codpaciente="+codpaciente+"&codsucursal="+codsucursal);
	    cargarDientes('seccionDientes', 'dientes.php', '', codcita, codpaciente, codsucursal);
	    });

	    setTimeout(function() { 
  
            //INICIO PARA REGISTRO DE IMAGEN  
            html2canvas($("#seccionDientes"), {
    
                onrendered: function(canvas) {
                theCanvas = canvas;
                // document.body.appendChild(canvas);
                var codcita = $('#cita').val();
                var codpaciente = $('#paciente').val();
                var codsucursal = $('#sucursal').val();
                var dataString = $("#odontograma").serialize();
                var imagen = canvas.toDataURL();
                var url = urlBase() + "operacionesOdontograma.php?accion=1";
                var post = "codcita=" + codcita +"&codpaciente=" + codpaciente +"&codsucursal=" + codsucursal +"&img_val=" + imagen;
        
            $.ajax({
                    type: 'POST',
                    url: url,
                    data: post,
                    success: function (msg) {
                    // alert('Imagen guardada correctamente...');
                    //$("#seccionDientes").load("dientes.php"); 
                    }
                }); 
              }
            }); 
            //FIN PARA REGISTRO DE IMAGEN
    
        }, 2000);
	});
}

		
function limpiarDatosTratamiento()
{
	$("#txtIdentificadorDienteGeneral").val("DXX");
	$("#txtDienteTratado").val("");
	$("#txtCaraTratada").val("");
	$("#cbxEstado").val("");
}


function cargarDientes(idSeccion, url, estados, codcita, codpaciente, codsucursal)
{
	$.ajax(
    {
        url: url,
        type: "POST",
        data: {codcita: codcita, codpaciente: codpaciente, codsucursal: codsucursal, estados: estados},
        cache: true
    }).done(function(pagina) 
    {
        $("#"+idSeccion).html(pagina);
    });
}


function cargarTratamientos(idSeccion, url, codcita, codpaciente, codsucursal)
{
	$.ajax(
    {
        url: url,
        type: "POST",
        data: {codcita: codcita, codpaciente: codpaciente, codsucursal: codsucursal},
        cache: true
    }).done(function(pagina) 
    {
        $("#"+idSeccion).html(pagina);
    });
}

function prepararImpresion()
{
	$("body #seccionTablaTratamientos").css({"display": "none"});
	$("body #seccionRegistrarTratamiento").css({"display": "none"});
}

function terminarImpresion()
{
	$("body #seccionTablaTratamientos").css({"display": "inline-block"});
	$("body #seccionRegistrarTratamiento").css({"display": "inline-block"});
}