function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

    $('#AgregaCompra').click(function() {
        AgregaCompras();
    });

    $('.agregacompra').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
          AgregaCompras();
          e.preventDefault();
          return false;
      }
  });

    function AgregaCompras() {

            var code = $('input#codproducto').val();
            var prod = $('input#producto').val();
            var cantp = $('input#cantidad').val();
            var exist = $('input#existencia').val();
            var prec = $('input#preciocompra').val();
            var prec2 = $('input#precioventa').val();
            var descuenfact = $('input#descfactura').val();
            var descuen = $('input#descproducto').val();
            var ivgprod = $('input#ivaproducto').val();
            var lote = $('input#lote').val();
            var er_num = /^([0-9])*[.]?[0-9]*$/;
            cantp = parseInt(cantp);
            exist = parseInt(exist);
            cantp = cantp;

            if (code == "") {
                $("#busquedaproductoc").focus();
                $("#busquedaproductoc").css('border-color', '#ff7676');
                swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE!", "error");
                return false;
            

            } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#ff7676');
                swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA EN COMPRAS!", "error");
                return false;

            } else if (isNaN($('#cantidad').val())) {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#ff7676');
                swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD DE COMPRAS!", "error");
                return false;
                
            } else if(prec=="" || prec=="0.00"){
                $("#preciocompra").focus();
                $('#preciocompra').css('border-color','#ff7676');
                swal("Oops", "POR FAVOR INGRESE PRECIO DE COMPRA VALIDO PARA PRODUCTO!", "error");  
                return false;
                
            } else if(!er_num.test($('#preciocompra').val())){
                $("#preciocompra").focus();
                $('#preciocompra').css('border-color','#ff7676');
                $("#preciocompra").val("");
                swal("Oops", "POR FAVOR INGRESE SOLO NUMEROS POSITIVOS EN PRECIO COMPRA!", "error");  
                return false;
                
            } else if(prec2=="" || prec2=="0.00"){
                $("#precioventa").focus();
                $('#precioventa').css('border-color','#ff7676');
                swal("Oops", "POR FAVOR INGRESE PRECIO DE VENTA VALIDO PARA PRODUCTO!", "error");
                return false;
                
            } else if(!er_num.test($('#precioventa').val())){
                $("#precioventa").focus();
                $('#precioventa').css('border-color','#ff7676');
                $("#precioventa").val("");
                swal("Oops", "POR FAVOR INGRESE SOLO NUMEROS POSITIVOS EN PRECIO VENTA!", "error");
                return false;

            } else if (parseFloat(prec) > parseFloat(prec2)) {
                
                $("#precioventa").focus();
                $("#preciocompra").focus();
                $('#precioventa').css('border-color','#ff7676');
                $('#preciocompra').css('border-color','#ff7676');
                swal("Oops", "POR FAVOR EL PRECIO DE COMPRA NO PUEDE SER MAYOR AL PRECIO VENTA!", "error");
                return false;

            } else if(descuenfact==""){
                $("#descfactura").focus();
                $('#descfactura').css('border-color','#ff7676');
                alert("INGRESE DESCUENTO EN FACTURA DE COMPRA");
                return false;
                
            } else if(!er_num.test($('#descfactura').val())){
                $("#descfactura").focus();
                $('#descfactura').css('border-color','#ff7676');
                $("#descfactura").val("");
                swal("Oops", "POR FAVOR INGRESE SOLO NUMEROS POSITIVOS PARA DESCUENTO EN FACTURA DE COMPRA!", "error");
                return false;
                
            } else if(descuen==""){
                $("#descproducto").focus();
                $('#descproducto').css('border-color','#ff7676');
                swal("Oops", "POR FAVOR INGRESE DESCUENTO EN PRODUCTO PARA VENTA!", "error");
                return false;
                
            } else if(!er_num.test($('#descproducto').val())){
                $("#descproducto").focus();
                $('#descproducto').css('border-color','#ff7676');
                $("#descproducto").val("");
                swal("Oops", "POR FAVOR INGRESE SOLO NUMEROS POSITIVOS EN DESCUENTO DE PRODUCTO PARA VENTA!", "error");
                return false;
                
            } else if(ivgprod==""){
                $("#ivaproducto").focus();
                $('#ivaproducto').css('border-color','#ff7676');
                swal("Oops", "POR FAVOR SELECCIONE SI TIENE IVA EL PRODUCTO!", "error");
                return false;

            } else if (lote == "") {
                $("#lote").focus();
                $("#lote").css('border-color', '#ff7676');
                swal("Oops", "POR FAVOR INGRESE LOTE DE PRODUCTO!", "error");                
                return false;

            } else {

                var Carrito = new Object();
                Carrito.Codigo = $('input#codproducto').val();
                Carrito.Producto = $('input#producto').val();
                Carrito.Marca = $('input#marca').val();
                Carrito.Presentacion = $('input#presentacion').val();
                Carrito.Medida = $('input#medida').val();
                Carrito.Precio      = $('input#preciocompra').val();
                Carrito.Precio2      = $('input#precioventa').val();
                Carrito.DescproductoFact      = $('input#descfactura').val();
                Carrito.Descproducto      = $('input#descproducto').val();
                Carrito.Ivaproducto = $('select#ivaproducto').val();
                Carrito.Precioconiva = $('input#precioconiva').val();
                Carrito.Lote = $('input#lote').val();
                Carrito.Fechaelaboracion = $('input#fechaelaboracion').val();
                Carrito.Fechaexpiracion = $('input#fechaexpiracion').val();
                Carrito.Cantidad = $('input#cantidad').val();
                Carrito.opCantidad = '+=';
                var DatosJson = JSON.stringify(Carrito);
                $.post('carritocompra.php', {
                        MiCarrito: DatosJson
                    },
                    function(data, textStatus) {
                        $("#carrito tbody").html("");
                        var TotalDescuento = 0;
                        var SubtotalFact = 0;
                        var BaseImpIva1 = 0;
                        var contador = 0;
                        var iva = 0;
                        var total = 0;
                        var TotalCompra = 0;

                        $.each(data, function(i, item) {
                            var cantsincero = item.cantidad;
                            cantsincero = parseInt(cantsincero);
                            if (cantsincero != 0) {
                                contador = contador + 1;

                //CALCULO DEL VALOR TOTAL
                var ValorTotal= parseFloat(item.precio) * parseFloat(item.cantidad);

                //CALCULO DEL TOTAL DEL DESCUENTO %
                var Descuento = ValorTotal * item.descproductofact / 100;
                TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);
                
                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio * item.descproductofact / 100;
                var descconiva = item.precioconiva * item.descproductofact / 100;

                //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
                var Operac= parseFloat(item.precio) - parseFloat(descsiniva);
                var Operacion= parseFloat(Operac) * parseFloat(item.cantidad);
                var Subtotal = Operacion.toFixed(2);

                //CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
                var Operac3 = parseFloat(item.precioconiva) - parseFloat(descconiva);
                var Operacion3 = parseFloat(Operac3) * parseFloat(item.cantidad);
                var Subbaseimponiva = Operacion3.toFixed(2);

                //BASE IMPONIBLE IVA CON PORCENTAJE
                BaseImpIva1 = parseFloat(BaseImpIva1) + parseFloat(Subbaseimponiva);
                
                //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                var ivg = $('input#iva').val();
                ivg2  = ivg/100;
                TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
                
                //SUBTOTAL GENERAL DE FACTURA
                SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);
                //BASE IMPONIBLE IVA SIN PORCENTAJE
                BaseImpIva2 = parseFloat(SubtotalFact) - parseFloat(BaseImpIva1);
                
                //CALCULAMOS DESCUENTO POR PRODUCTO
                var desc = $('input#descuento').val();
                desc2  = desc/100;
                
                //CALCULO DEL TOTAL DE FACTURA
                Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
                TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
                TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));


                var nuevaFila =
                    "<tr class='text-center'>" +
                        "<td>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'-1'," +
                        "'" + item.producto + "'," +
                        "'" + item.marca + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.medida + "'," +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.descproductofact + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.precioconiva + "', " +
                        "'" + item.lote + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'-'" +
                        ')"' +
                        " type='button'><span class='fa fa-minus'></span></button>" +
                        "<input type='text' id='" + item.cantidad + "' class='bold' style='width:26px;height:34px;' value='" + item.cantidad + "'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'+1'," +
                        "'" + item.producto + "'," +
                        "'" + item.marca + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.medida + "'," +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.descproductofact + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.precioconiva + "', " +
                        "'" + item.lote + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'+'" +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></td>" +
                        "<td class='text-left'><h5><strong>" + item.producto + "</strong></h5><small>MARCA (" + item.marca + ") : MEDIDA (" + (item.medida == '' || item.medida == '0' ? '******' : item.medida) + ")</small></td>" +
                        "<td><strong>" + item.precio + "</strong></td>" +
                        "<td><strong>" + ValorTotal.toFixed(2) + "</strong></td>" +
                        "<td><strong>" + Descuento.toFixed(2) + "<sup>" + item.descproductofact + "%</sup></strong></td>" +
                        "<td><strong>" + item.ivaproducto + "</strong></td>" +
                        "<td><strong>" + Operacion.toFixed(2) + "</strong></td>" +
                        "<td>" +
                        '<button type="button" class="btn btn-outline-dark btn-rounded" style="cursor:pointer;" ' +
                        'onclick="addItem(' +
                        "'" + item.txtCodigo + "'," +
                        "'0'," +
                        "'" + item.producto + "'," +
                        "'" + item.marca + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.medida + "'," +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.descproductofact + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.precioconiva + "', " +
                        "'" + item.lote + "', " +
                        "'" + item.fechaelaboracion + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'='" +
                        ')"' +
                        '><span class="fa fa-trash-o"></span></button>' +
                                    "</td>" +
                                    "</tr>";
                                $(nuevaFila).appendTo("#carrito tbody");
                                    
                            $("#lblsubtotal").text(SubtotalFact.toFixed(2));
                            $("#lblgravado").text(BaseImpIva1.toFixed(2));
                            $("#lblexento").text(BaseImpIva2.toFixed(2));
                            $("#lbliva").text(TotalIvaGeneral.toFixed(2));
                            $("#lbldescontado").text(TotalDescuento.toFixed(2));
                            $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
                            $("#lbltotal").text(TotalFactura.toFixed(2));
                            
                            $("#txtsubtotal").val(SubtotalFact.toFixed(2));
                            $("#txtgravado").val(BaseImpIva1.toFixed(2));
                            $("#txtexento").val(BaseImpIva2.toFixed(2));
                            $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                            $("#txtdescontado").val(TotalDescuento.toFixed(2));
                            $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                            $("#txtTotal").val(TotalFactura.toFixed(2));
                            $("#btn-submit").attr('disabled', false);

                            }

                        });

                        $("#busquedaproductoc").focus();
                        LimpiarTexto();
                    },
                    "json"
                );
                return false;
            }
        }

/* CANCELAR LOS ITEM AGREGADOS EN REGISTRO */
$("#vaciar").click(function() {
        var Carrito = new Object();
        Carrito.Codigo = "vaciar";
        Carrito.Producto = "vaciar";
        Carrito.Marca = "vaciar";
        Carrito.Presentacion = "vaciar";
        Carrito.Medida = "vaciar";
        Carrito.Precio      = "vaciar";
        Carrito.Precio2      = "0.00";
        Carrito.DescproductoFact      = "0";
        Carrito.Descproducto      = "0";
        Carrito.Ivaproducto = "vaciar";
        Carrito.Precioconiva      = "0.00";
        Carrito.Lote = "0";
        Carrito.Fechaelaboracion = "vaciar";
        Carrito.Fechaexpiracion = "vaciar";
        Carrito.Cantidad = "0";
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritocompra.php', {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
         "<tr>"+"<td class='text-center' colspan=8><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                LimpiarTexto();
            },
            "json"
        );
        return false;
    });


$(document).ready(function() {
    $('#vaciar').click(function() {
        $("#carrito tbody").html("");
        var nuevaFila =
        "<tr>"+"<td class='text-center' colspan=8><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#savecompra")[0].reset();
        $("#lblsubtotal").text("0.00");
        $("#lblgravado").text("0.00");
        $("#lblexento").text("0.00");
        $("#lbliva").text("0.00");
        $("#lbldescontado").text("0.00");
        $("#lbldescuento").text("0.00");
        $("#lbltotal").text("0.00");

        $("#txtsubtotal").val("0.00");
        $("#txtgravado").val("0.00");
        $("#txtexento").val("0.00");
        $("#txtIva").val("0.00");
        $("#txtdescontado").val("0.00");
        $("#txtDescuento").val("0.00");
        $("#txtTotal").val("0.00");
        $("#formacompra").attr('disabled', false);
        $("#muestra_metodo").html('');
        $("#btn-submit").attr('disabled', true);
    });
});


 //FUNCION PARA CALCULAR PRECIO VENTA
$(document).ready(function (){
    $('#preciocompra').keyup(function (){
    
        var iva = $('select#ivaproducto').val();
        var precio = $('input#preciocompra').val();

        //REALIZO LA ASIGNACION
        $("#precioconiva").val((iva != "" && iva == "NO") ? "0.00" : precio);

  });
});

//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON DESCUENTO
$(document).ready(function (){
      $('#descuento').keyup(function (){
    
        var txtgravado = $('input#txtgravado').val();
        var txtexento = $('input#txtexento').val();
        var txtIva = $('input#txtIva').val();
        var desc = $('input#descuento').val();
        descuento  = desc/100;
                    
        //REALIZO EL CALCULO CON EL DESCUENTO INDICADO
        Subtotal = parseFloat(txtgravado) + parseFloat(txtexento) + parseFloat(txtIva); 
        TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
        TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));        
    
        $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
        $("#lbltotal").text(TotalFactura.toFixed(2));
        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
        $("#txtTotal").val(TotalFactura.toFixed(2));
    });
});


//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON IVA
$(document).ready(function (){
      $('#iva').keyup(function (){
    
        var txtgravado = $('input#txtgravado').val();
        var txtexento = $('input#txtexento').val();
        var txtIva = $('input#txtIva').val();
        var iva = $('input#iva').val();
        var desc = $('input#descuento').val();
        ivg2  = iva/100;
        descuento  = desc/100;
                    
        //REALIZO EL CALCULO CON EL IVA INDICADO
        TotalIvaGeneral = parseFloat(txtgravado) * parseFloat(ivg2.toFixed(2));

        Subtotal = parseFloat(txtgravado) + parseFloat(txtexento) + parseFloat(TotalIvaGeneral); 
        TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
        TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));        
    
        $("#lbliva").text(TotalIvaGeneral.toFixed(2));
        $("#txtIva").text(TotalIvaGeneral.toFixed(2));
        
        $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
        
        $("#lbltotal").text(TotalFactura.toFixed(2));
        $("#txtTotal").val(TotalFactura.toFixed(2));
    });
});



    $("#carrito tbody").on('keydown', 'input', function(e) {
        var element = $(this);
        var pvalue = element.val();
        var code = e.charCode || e.keyCode;
        var avalue = String.fromCharCode(code);
        var action = element.siblings('button').first().attr('onclick');
        var params;
        if (code !== 14 && /[^\d]/ig.test(avalue)) {
            e.preventDefault();
            return;
        }
        if (element.attr('data-proc') == '1') {
            return true;
        }
        element.attr('data-proc', '1');
        params = action.match(/\'([^\']+)\'/g).map(function(v) {
            return v.replace(/\'/g, '');
        });
        setTimeout(function() {
            if (element.attr('data-proc') == '1') {
                var value = element.val() || 0;
                addItem(
                    params[0],
                    value,
                    params[2],
                    params[3],
                    params[4],
                    params[5],
                    params[6],
                    params[7],
                    params[8],
                    params[9],
                    params[10],
                    params[11],
                    params[12],
                    params[13],
                    params[14],
                    '='
                    );
                    element.attr('data-proc', '0');
                }
            }, 300);
        });
    });

// FUNCION PARA MOSTRAR CONDICIONES DE PAGO
function CargaCondicionesPagos(){

var tipocompra = $('input:radio[name=tipocompra]:checked').val();

    if (tipocompra === "CONTADO" || tipocompra === true) {
    
    $("#formacompra").attr('disabled', false);
    $("#muestra_metodo").html('');

    } else {

    $("#formacompra").attr('disabled', true);
    $("#muestra_metodo").html('<div class="row"><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Método de Abono: </label><i class="fa fa-bars form-control-feedback"></i><select name="medioabono" id="medioabono" class="form-control" required="" aria-required="true"><option value=""> -- SELECCIONE -- </option><option value="EFECTIVO">EFECTIVO</option><option value="CHEQUE">CHEQUE</option><option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option><option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option><option value="TARJETA PREPAGO">TARJETA PREPAGO</option><option value="TRANSFERENCIA">TRANSFERENCIA</option><option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option><option value="CUPON">CUPÓN</option><option value="OTROS">OTROS</option></select></div></div><div class="col-md-6"><div class="form-group has-feedback"><label class="control-label">Monto de Abono: <span class="symbol required"></span></label><input class="form-control number" type="text" name="montoabono" id="montoabono" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText("%f", this);" onBlur="this.value = NumberFormat(this.value, "2", ".", "")" autocomplete="off" placeholder="Ingrese Monto de Abono" value="0" required="" aria-required="true"><i class="fa fa-tint form-control-feedback"></i></div></div></div><div class="row"><div class="col-md-12"><div class="form-group has-feedback"><label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label><input type="text" class="form-control expira" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Vencimiento" aria-required="true"><i class="fa fa-calendar form-control-feedback"></i></div></div></div>');

    } 
}

function LimpiarTexto() {
    $("#busquedaproductoc").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#existencia").val("");
    $("#marca").val("");
    $("#medida").val("");
    $("#presentacion").val("");
    $("#preciocompra").val("");
    $("#precioventa").val("0.00");
    $("#descfactura").val("0.00");
    $("#descproducto").val("0.00");
    $("#ivaproducto").val("");
    $("#precioconiva").val("0.00");
    $("#lote").val("0");
    $("#fechaelaboracion").val("");
    $("#fechaexpiracion").val("");
    $("#cantidad").val("");
}


function addItem(codigo, cantidad, producto, marca, presentacion, medida, precio, precio2, descproductofact, descproducto, ivaproducto, precioconiva, lote, fechaelaboracion, fechaexpiracion, opCantidad) {
    var Carrito = new Object();
    Carrito.Codigo = codigo;
    Carrito.Producto = producto;
    Carrito.Marca = marca;
    Carrito.Presentacion = presentacion;
    Carrito.Medida = medida;
    Carrito.Precio = precio;
    Carrito.Precio2 = precio2;
    Carrito.DescproductoFact = descproductofact;
    Carrito.Descproducto = descproducto;
    Carrito.Ivaproducto = ivaproducto;
    Carrito.Precioconiva = precioconiva;
    Carrito.Lote = lote;
    Carrito.Fechaelaboracion = fechaelaboracion;
    Carrito.Fechaexpiracion = fechaexpiracion;
    Carrito.Cantidad = cantidad;
    Carrito.opCantidad = opCantidad;
    var DatosJson = JSON.stringify(Carrito);
    $.post('carritocompra.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var TotalDescuento = 0;
            var SubtotalFact = 0;
            var BaseImpIva1 = 0;
            var contador = 0;
            var iva = 0;
            var total = 0;
            var TotalCompra = 0;

            $.each(data, function(i, item) {
                var cantsincero = item.cantidad;
                cantsincero = parseInt(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;


                //CALCULO DEL VALOR TOTAL
                var ValorTotal= parseFloat(item.precio) * parseFloat(item.cantidad);

                //CALCULO DEL TOTAL DEL DESCUENTO %
                var Descuento = ValorTotal * item.descproductofact / 100;
                TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);
                
                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio * item.descproductofact / 100;
                var descconiva = item.precioconiva * item.descproductofact / 100;

                //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
                var Operac= parseFloat(item.precio) - parseFloat(descsiniva);
                var Operacion= parseFloat(Operac) * parseFloat(item.cantidad);
                var Subtotal = Operacion.toFixed(2);

                //CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
                var Operac3 = parseFloat(item.precioconiva) - parseFloat(descconiva);
                var Operacion3 = parseFloat(Operac3) * parseFloat(item.cantidad);
                var Subbaseimponiva = Operacion3.toFixed(2);

                //BASE IMPONIBLE IVA CON PORCENTAJE
                BaseImpIva1 = parseFloat(BaseImpIva1) + parseFloat(Subbaseimponiva);
                
                //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                var ivg = $('input#iva').val();
                ivg2  = ivg/100;
                TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
                
                //SUBTOTAL GENERAL DE FACTURA
                SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);
                //BASE IMPONIBLE IVA SIN PORCENTAJE
                BaseImpIva2 = parseFloat(SubtotalFact) - parseFloat(BaseImpIva1);
                
                //CALCULAMOS DESCUENTO POR PRODUCTO
                var desc = $('input#descuento').val();
                desc2  = desc/100;
                
                //CALCULO DEL TOTAL DE FACTURA
                Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
                TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
                TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));


               var nuevaFila =
                "<tr class='text-center'>" +
                    "<td>" +
                    '<button class="btn btn-info btn-xs" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' +
                    "'" + item.txtCodigo + "'," +
                    "'-1'," +
                    "'" + item.producto + "'," +
                    "'" + item.marca + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.medida + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproductofact + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.lote + "', " +
                    "'" + item.fechaelaboracion + "', " +
                    "'" + item.fechaexpiracion + "', " +
                    "'-'" +
                    ')"' +
                    " type='button'><span class='fa fa-minus'></span></button>" +
                    "<input type='text' id='" + item.cantidad + "' class='bold' style='width:26px;height:34px;' value='" + item.cantidad + "'>" +
                    '<button class="btn btn-info btn-xs" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
                    "'" + item.txtCodigo + "'," +
                    "'+1'," +
                    "'" + item.producto + "'," +
                    "'" + item.marca + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.medida + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproductofact + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.lote + "', " +
                    "'" + item.fechaelaboracion + "', " +
                    "'" + item.fechaexpiracion + "', " +
                    "'+'" +
                    ')"' +
                    " type='button'><span class='fa fa-plus'></span></button></td>" +
                    "<td class='text-left'><h5><strong>" + item.producto + "</strong></h5><small>MARCA (" + item.marca + ") : MEDIDA (" + (item.medida == '' || item.medida == '0' ? '******' : item.medida) + ")</small></td>" +
                    "<td><strong>" + item.precio + "</strong></td>" +
                    "<td><strong>" + ValorTotal.toFixed(2) + "</strong></td>" +
                    "<td><strong>" + Descuento.toFixed(2) + "<sup>" + item.descproductofact + "%</sup></strong></td>" +
                    "<td><strong>" + item.ivaproducto + "</strong></td>" +
                    "<td><strong>" + Operacion.toFixed(2) + "</strong></td>" +
                    "<td>" +
                    '<button type="button" class="btn btn-outline-dark btn-rounded" style="cursor:pointer;" ' +
                    'onclick="addItem(' +
                    "'" + item.txtCodigo + "'," +
                    "'0'," +
                    "'" + item.producto + "'," +
                    "'" + item.marca + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.medida + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproductofact + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.lote + "', " +
                    "'" + item.fechaelaboracion + "', " +
                    "'" + item.fechaexpiracion + "', " +
                    "'='" +
                    ')"' +
                    '><span class="fa fa-trash-o"></span></button>' +
                                "</td>" +
                                "</tr>";
                    $(nuevaFila).appendTo("#carrito tbody");
                                    
                    $("#lblsubtotal").text(SubtotalFact.toFixed(2));
                    $("#lblgravado").text(BaseImpIva1.toFixed(2));
                    $("#lblexento").text(BaseImpIva2.toFixed(2));
                    $("#lbliva").text(TotalIvaGeneral.toFixed(2));
                    $("#txtdescontado").val(TotalDescuento.toFixed(2));
                    $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
                    $("#lbltotal").text(TotalFactura.toFixed(2));

                    $("#txtsubtotal").val(SubtotalFact.toFixed(2));
                    $("#txtgravado").val(BaseImpIva1.toFixed(2));
                    $("#txtexento").val(BaseImpIva2.toFixed(2));
                    $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                    $("#lbldescontado").text(TotalDescuento.toFixed(2));
                    $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                    $("#txtTotal").val(TotalFactura.toFixed(2));
                    $("#btn-submit").attr('disabled', false);

                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila =
                "<tr>"+"<td class='text-center' colspan=8><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#savecompra")[0].reset();
                $("#lblsubtotal").text("0.00");
                $("#lblgravado").text("0.00");
                $("#lblexento").text("0.00");
                $("#lbliva").text("0.00");
                $("#lbldescontado").text("0.00");
                $("#lbldescuento").text("0.00");
                $("#lbltotal").text("0.00");
                
                $("#txtsubtotal").val("0.00");
                $("#txtgravado").val("0.00");
                $("#txtexento").val("0.00");
                $("#txtIva").val("0.00");
                $("#txtdescontado").val("0.00");
                $("#txtDescuento").val("0.00");
                $("#txtTotal").val("0.00");
                $("#txtTotalCompra").val("0.00");
                $("#btn-submit").attr('disabled', true);
            }

        },
        "json"
    );
    return false;
}