<?php
require_once("class/class.php"); 

$tra = new Login();
$events = $tra->BuscarCitas();
?> 

<?php if (isset($_GET['Calendario_Principal'])): ?>   
               

<div id="calendar"></div>

<script>
$(document).ready(function() {

    var date = new Date();
    var yyyy = date.getFullYear().toString();
    var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
    var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
    
    $('#calendar').fullCalendar({
        header: {
            language: 'es',
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay',
        },
        defaultDate: yyyy+"-"+mm+"-"+dd,
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,
        <?php if ($_SESSION['acceso'] != "administradorG"){ ?>
        select: function(start) {
            
        },
        eventRender: function(event, element) {
            element.bind('dblclick', function() {
                $("#ModalAdd #sucursal").text(event.sucursal);
                $('#ModalAdd #nompaciente').text(event.paciente);
                $("#ModalAdd #nomespecialista").text(event.especialista);
                $('#ModalAdd #movitocita').text(event.descripcion);
                $('#ModalAdd #fechacita').text(moment(event.start).format('DD-MM-YYYY'));
                $('#ModalAdd #horacita').text(event.hora);
                $('#ModalAdd #descripcion').val(event.descripcion);
                $('#ModalAdd #color').val(event.color);
                $('#ModalAdd').modal('show');
            });
        },<?php } ?>
        events: [
        <?php if($events==""){ echo ""; } else {  

                foreach($events as $event): 
        ?>
            {
                sucursal: '<?php echo $event['nomsucursal']; ?>',
                paciente: '<?php echo $event['pacientes']; ?>',
                especialista: '<?php echo $event['cedespecialista']." ".$event['nomespecialista']; ?>',
                descripcion: '<?php echo $event['descripcion']; ?>',
                start: '<?php echo $event['fechacita']; ?>',
                hora: '<?php echo date("H:i",strtotime($event['fechacita'])); ?>',
                title: '<?php echo $event['nompaciente']; ?>',
                color: '<?php echo $event['color']; ?>',
            },
        <?php endforeach; } ?>
        ]
    });  
});
</script>

<?php endif; ?> 






<?php if (isset($_GET['Calendario_Secundario'])): ?>                        

<div id="calendar"></div>

<script>
$(document).ready(function() {

    var date = new Date();
    var yyyy = date.getFullYear().toString();
    var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
    var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
    
    $('#calendar').fullCalendar({
        header: {
            language: 'es',
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay',
        },
        defaultDate: yyyy+"-"+mm+"-"+dd,

        <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){ ?>
        editable: false,
        <?php } else { ?> 
        editable: true,	
        <?php } ?>
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,
        <?php if ($_SESSION['acceso'] != "administradorG"){ ?>
        select: function(start) {
            
            $('#ModalAdd #fechacita').val(moment(start).format('DD-MM-YYYY'));
            $('#ModalAdd').modal('show');
        },
        <?php } else if ($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "secretaria" || $_SESSION['acceso'] == "cajero" || $_SESSION['acceso'] == "especialista"){ ?>
        eventRender: function(event, element) {
            element.bind('dblclick', function() {
                $('#ModalAdd #proceso').val("update");
                $('#ModalAdd #delete').val(event.idelim);
                $('#ModalAdd #cancelar').val(event.idcanc);
                $('#ModalAdd #codcita').val(event.codcita);
                $("#ModalAdd #codsucursal").val(event.codsucursal);
                $("#ModalAdd #codespecialista").val(event.codespecialista);
                $("#ModalAdd #codpaciente").val(event.codpaciente);
                $('#ModalAdd #search_paciente').val(event.valor);
                $('#ModalAdd #descripcion').val(event.descripcion);
                $('#ModalAdd #color').val(event.color);
                $('#ModalAdd #fechacita').val(moment(event.start).format('DD-MM-YYYY'));
                $('#ModalAdd #horacita').val(event.hora);
                (event.status == "VERIFICADA" ? $("#btn-submit").attr('disabled', true) : $("#btn-submit").attr('disabled', false));
                (event.status == "VERIFICADA" ? $("#deletevento").attr('disabled', true) : $("#deletevento").attr('disabled', false));
                (event.status == "VERIFICADA" ? $("#cancelaevento").attr('disabled', true) : $("#cancelaevento").attr('disabled', false));
                //$("#deletevento").attr('disabled', false);
                //$("#cancelaevento").attr('disabled', false);
                $('#ModalAdd').modal('show');
            });
        },<?php } ?>
        eventDrop: function(event, delta, revertFunc) { // si changement de position

            edit(event);
        },
        eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

            edit(event);
        },
        events: [
        <?php if($events==""){ echo ""; } else {  

                foreach($events as $event): 
        ?>
            {
                idelim: '<?php echo encrypt($event['codcita']); ?>',
                idcanc: '<?php echo encrypt($event['codcita']); ?>',
                codcita: '<?php echo encrypt($event['codcita']); ?>',
                codsucursal: '<?php echo encrypt($event['codsucursal']); ?>',
                codespecialista: '<?php echo encrypt($event['codespecialista']); ?>',
                codpaciente: '<?php echo $event['codpaciente']; ?>',
                valor: '<?php echo $event['pacientes']; ?>',
                title: '<?php echo $event['nompaciente']; ?>',
                descripcion: '<?php echo $event['descripcion']; ?>',
                status: '<?php echo $event['statuscita']; ?>',
                start: '<?php echo $event['fechacita']; ?>',
                hora: '<?php echo date("H:i",strtotime($event['fechacita'])); ?>',
                color: '<?php echo $event['color']; ?>',
            },
        <?php endforeach; } ?>
        ]
    }); 
    
    function edit(event){
        start = event.start.format('YYYY-MM-DD HH:mm:ss');
        codcita =  event.codcita;
        Event = [];
        Event[0] = codcita;
        Event[1] = start;
        Event[2] = "editdate";
        
        $.ajax({
         url: 'forcita.php',
         type: "POST",
         data: {Event:Event},
         success: function(rep) {
                if(rep==1){
                                    
                    swal("Exitoso!", "La Fecha de Cita ha sido Actualizada con éxito!", "success");

                } else if(rep==3){
                                    
                    swal("Oops", "Esta Cita para Odontologia no puede ser Actualizada a una Fecha Anterior, verifique por favor!", "error");
                    $('#cargacalendario').html("");
                    $('#cargacalendario').append('<center><i class="fa fa-spin fa-spinner"></i> Por Favor Espere, Cargando Calendario ......</center>').fadeIn("slow");
                    setTimeout(function() {
                        $('#cargacalendario').load("calendario?Calendario_Secundario=si");
                    }, 100);                

                } else {

                    swal("Error!", "No se pudo Actualizar esta Cita para Odontologia. Inténtelo de nuevo!", "error");
                    $('#cargacalendario').html("");
                    $('#cargacalendario').append('<center><i class="fa fa-spin fa-spinner"></i> Por Favor Espere, Cargando Calendario ......</center>').fadeIn("slow");
                    setTimeout(function() {
                        $('#cargacalendario').load("calendario?Calendario_Secundario=si");
                    }, 100);               

                }
            }
        });
    }     
});
</script>

<?php endif; ?>