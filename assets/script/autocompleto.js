// FUNCION AUTOCOMPLETE 
$(function() {  
    var animales = ["Ardilla roja", "Gato", "Gorila occidental",  
      "Leon", "Oso pardo", "Perro", "Tigre de Bengala"];  
      
    $("#prueba").autocomplete({  
      source: animales  
    });  
});

$(function() {
  $("#marcas").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Marcas=si",
    minLength: 1,
      select: function(event, ui) { 
      $('#codmarca').val(ui.item.codmarca);
    }  
  });
});

$(function() {
  $("#medida").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Medidas=si",
    minLength: 1,
    select: function(event, ui) { 
      $('#codmedida').val(ui.item.codmedida);
      }  
  });
});


//AUTOCOMPLETO PRESUNTIVO
$(function() {
  $("#presuntivo").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Cie10=si",
    minLength: 1,
      select: function(event, ui) {  
      $('#idciepresuntivo').val(ui.item.idcie);
    }  
  });
});

function autocompletar(contador){
  contador = contador.replace("presuntivo[]", "");
  $("#presuntivo"+contador).autocomplete({
  source: "class/busqueda_autocompleto.php?Busqueda_Cie10=si",
    minLength: 1,
    select: function(event, ui) {  
      $('#idciepresuntivo'+contador).val(ui.item.idcie);
    }  
  });
}
    


//AUTOCOMPLETO DEFINITIVO
$(function() {
  $("#definitivo").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Cie10=si",
    minLength: 1,
      select: function(event, ui) {  
        $('#idciedefinitivo').val(ui.item.idcie);
    }  
  });
});

function autocompletar2(contador){
  contador = contador.replace("definitivo[]", "");
  $("#definitivo"+contador).autocomplete({
  source: "class/busqueda_autocompleto.php?Busqueda_Cie10=si",
    minLength: 1,
    select: function(event, ui) {  
      $('#idciedefinitivo'+contador).val(ui.item.idcie);
    }  
  });
}


$(function() {
  $("#search_kardex_producto").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Kardex_Producto=si",
    minLength: 1,
    select: function(event, ui) {
      $('#codproducto').val(ui.item.codproducto);
    }
  });
});


$(function() {
  $("#busquedaproductoc").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Producto_Compra=si",
    minLength: 1,
    select: function(event, ui) {
      $('#codproducto').val(ui.item.codproducto);
      $('#producto').val(ui.item.producto);
      $('#marca').val(ui.item.nommarca);
      $('#presentacion').val(ui.item.nompresentacion);
      $('#medida').val(ui.item.nommedida);
      $('#preciocompra').val(ui.item.preciocompra);
      $('#precioventa').val(ui.item.precioventa);
      $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.preciocompra : "0.00");
      $('#existencia').val(ui.item.existencia);
      $('#ivaproducto').val(ui.item.ivaproducto);
      $('#descproducto').val(ui.item.descproducto);
      $("#cantidad").focus();
    }
  });
});

$(function() {
  $("#search_traspaso").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Producto_Venta=si",
    minLength: 1,
    select: function(event, ui) {
      $('#idproducto').val(ui.item.idproducto);
      $('#codproducto').val(ui.item.codproducto);
      $('#producto').val(ui.item.producto);
      $('#codmarca').val(ui.item.codmarca);
      $('#marca').val(ui.item.nommarca);
      $('#codpresentacion').val(ui.item.codpresentacion);
      $('#presentacion').val(ui.item.nompresentacion);
      $('#codmedida').val(ui.item.codmedida);
      $('#medida').val(ui.item.nommedida);
      $('#preciocompra').val(ui.item.preciocompra);
      $('#precioventa').val(ui.item.precioventa);
      $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioventa : "0.00");
      $('#ivaproducto').val(ui.item.ivaproducto);
      $('#descproducto').val(ui.item.descproducto);
      $('#existencia').val(ui.item.existencia);
      $('#fechaexpiracion').val(ui.item.fechaexpiracion);
      $("#cantidad").focus();
    }
  });
});


$(function() {
  $("#search_kardex_servicio").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Kardex_Servicio=si",
    minLength: 1,
      select: function(event, ui) {
      $('#codservicio').val(ui.item.codservicio);
    }
  });
});

// FUNCION AUTOCOMPLETE SEGUN TIPO BUSQUEDA
$(function() {

    $("#search_busqueda").keyup(function() {

        var tipo = $('input:radio[name=busqueda]:checked').val(); 

        if (tipo == 1) {

            $("#search_busqueda").autocomplete({
            source: "class/busqueda_autocompleto.php?Busqueda_Kardex_Servicio=si",
            minLength: 1,
            select: function(event, ui) {
                $('#idproducto').val(ui.item.idservicio);
                $('#codproducto').val(ui.item.codservicio);
                $('#producto').val(ui.item.servicio);
                $('#marca').val("");
                $('#presentacion').val("");
                $('#medida').val("");
                $('#preciocompra').val(ui.item.preciocompra);
                $('#precioventa').val(ui.item.precioventa);
                $('#precioconiva').val((ui.item.ivaservicio == "SI") ? ui.item.precioventa : "0.00");
                $('#ivaproducto').val(ui.item.ivaservicio);
                $('#descproducto').val(ui.item.descproducto);
                $('#existencia').val("******");
                $("#cantidad").focus();
            }
          });

          return false;

        } else if (tipo == 2) {

            $("#search_busqueda").autocomplete({
            source: "class/busqueda_autocompleto.php?Busqueda_Producto_Venta=si",
            minLength: 1,
            select: function(event, ui) {
                $('#idproducto').val(ui.item.idproducto);
                $('#codproducto').val(ui.item.codproducto);
                $('#producto').val(ui.item.producto);
                $('#codmarca').val(ui.item.codmarca);
                $('#marca').val(ui.item.nommarca);
                $('#codpresentacion').val(ui.item.codpresentacion);
                $('#presentacion').val(ui.item.nompresentacion);
                $('#codmedida').val(ui.item.codmedida);
                $('#medida').val(ui.item.nommedida);
                $('#preciocompra').val(ui.item.preciocompra);
                $('#precioventa').val(ui.item.precioventa);
                $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioventa : "0.00");
                $('#ivaproducto').val(ui.item.ivaproducto);
                $('#descproducto').val(ui.item.descproducto);
                $('#existencia').val(ui.item.existencia);
                $("#cantidad").focus();
            }
          });

        } else {

            $("#search_busqueda").val("");
            swal("Oops", "POR FAVOR SELECCIONE EL TIPO DE BUSQUEDA!", "error");
            return false;
        }
    });
}); 


$(function() {
  $("#search_paciente").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Pacientes=si",
    minLength: 1,
    select: function(event, ui) { 
      $('#codpaciente').val(ui.item.codpaciente);
    }  
  });
});


$(function() {
  $("#search_especialista").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Especialistas=si",
    minLength: 1,
    select: function(event, ui) { 
      $('#codespecialista').val(ui.item.codespecialista);
    }  
  });
});