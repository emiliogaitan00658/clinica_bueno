$(document).ready(function() {
  

$("#dni").validarCedulaEC({
    onValid: function () {
        $("#dni").focus();
        $('#dni').css('border-color','#f0ad4e');
        return true;
    },
    onInvalid: function () {
        $("#dni").val("");
        $("#dni").focus();
        $('#dni').css('border-color','#f0ad4e');
        swal("Oops", "El Nº de Identificación del Usuario es invalido, verifique e intente nuevamente por favor!", "error"); 
        return false;
    }
});


$("#cuit").validarCedulaEC({
    onValid: function () {
        $("#cuit").focus();
        $('#cuit').css('border-color','#f0ad4e');
        return true;
    },
    onInvalid: function () {
        $("#cuit").val("");
        $("#cuit").focus();
        $('#cuit').css('border-color','#f0ad4e');
        swal("Oops", "El Nº de Registro ingresado es invalido, verifique e intente nuevamente por favor!", "error");
        return false;
    }
});


$("#cuitsucursal").validarCedulaEC({
    onValid: function () {
        $("#cuitsucursal").focus();
        $('#cuitsucursal').css('border-color','#f0ad4e');
        return true;
    },
    onInvalid: function () {
        $("#cuitsucursal").val("");
        $("#cuitsucursal").focus();
        $('#cuitsucursal').css('border-color','#f0ad4e');
        swal("Oops", "El Nº de Registro ingresado es invalido, verifique e intente nuevamente por favor!", "error");
        return false;
    }
});


$("#dniencargado").validarCedulaEC({
    onValid: function () {
        $("#dniencargado").focus();
        $('#dniencargado').css('border-color','#f0ad4e');
        return true;
    },
    onInvalid: function () {
        $("#dniencargado").val("");
        $("#dniencargado").focus();
        $('#dniencargado').css('border-color','#f0ad4e');
        swal("Oops", "El Nº de Identificación del Encargado es invalido, verifique e intente nuevamente por favor!", "error");
        return false;
    }
 });


$("#dnicliente").validarCedulaEC({

    onValid: function () {
        $("#dnicliente").focus();
        $('#dnicliente').css('border-color','#f0ad4e');
        return true;
    },
    onInvalid: function () {

        var optradio = $("input[name='validaruc']:checked").val();

        if(optradio == "SI"){

        $("#dnicliente").val("");
        $("#dnicliente").focus();
        $('#dnicliente').css('border-color','#f0ad4e');
        swal("Oops", "El Nº de Identificación del Cliente es invalido, verifique e intente nuevamente por favor!", "error");
        return false;
        }
    }
  });



});
