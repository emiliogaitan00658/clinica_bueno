function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

    $('#Agregar').click(function() {
        AgregaCarrito();
    });

    $('.agregar').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
          AgregaCarrito();
          e.preventDefault();
          return false;
      }
  });

    function AgregaCarrito() {

            var code = $('input#codproducto').val();
            var prod = $('input#producto').val();
            var cantp = $('input#cantidad').val();
            var exist = $('input#existencia').val();
            var prec = $('input#preciocompra').val();
            var prec2 = $('input#precioventa').val();
            var descuen = $('input#descproducto').val();
            var er_num = /^([0-9])*[.]?[0-9]*$/;
            cantp = parseInt(cantp);
            exist = parseInt(exist);
            cantp = cantp;

            if (code == "") {
                $("#search_busqueda").focus();
                $("#search_busqueda").css('border-color', '#ff7676');
                swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA CORRECTAMENTE!", "error");
                return false;

            } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#ff7676');
                swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
                return false;

            } else if (isNaN($('#cantidad').val())) {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#ff7676');
                swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD!", "error");
                return false;
                
            } else if(prec2=="" || prec2=="0.00"){
                $("#precioventa").focus();
                $('#precioventa').css('border-color','#ff7676');
                swal("Oops", "POR FAVOR INGRESE PRECIO DE VENTA VALIDO!", "error");
                return false;
                
            } else if(!er_num.test($('#precioventa').val())){
                $("#precioventa").focus();
                $('#precioventa').css('border-color','#ff7676');
                $("#precioventa").val("");
                swal("Oops", "POR FAVOR INGRESE SOLO NUMEROS POSITIVOS EN PRECIO!", "error");
                return false;

            } else {

                var Carrito = new Object();
                Carrito.Id = $('input#idproducto').val();
                Carrito.Codigo = $('input#codproducto').val();
                Carrito.Producto = $('input#producto').val();
                Carrito.CodMarca = $('input#codmarca').val();
                Carrito.Marca = $('input#marca').val();
                Carrito.CodPresentacion = $('input#codpresentacion').val();
                Carrito.Presentacion = $('input#presentacion').val();
                Carrito.CodMedida = $('input#codmedida').val();
                Carrito.Medida = $('input#medida').val();
                Carrito.Precio      = $('input#preciocompra').val();
                Carrito.Precio2      = $('input#precioventa').val();
                Carrito.Descproducto      = $('input#descproducto').val();
                Carrito.Ivaproducto = $('input#ivaproducto').val();
                Carrito.Precioconiva = $('input#precioconiva').val();
                Carrito.Fechaexpiracion = $('input#fechaexpiracion').val();
                Carrito.Cantidad = $('input#cantidad').val();
                Carrito.opCantidad = '+=';
                var DatosJson = JSON.stringify(Carrito);
                $.post('carritotraspaso.php', {
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

                //CALCULO DEL VALOR TOTAL DE COMPRA
                var OperacionCompra= parseFloat(item.precio) * parseFloat(item.cantidad);
                TotalCompra = parseFloat(TotalCompra) + parseFloat(OperacionCompra);

                //CALCULO DEL VALOR TOTAL
                var ValorTotal= parseFloat(item.precio2) * parseFloat(item.cantidad);

                //CALCULO DEL TOTAL DEL DESCUENTO %
                var Descuento = ValorTotal * item.descproducto / 100;
                TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);
                
                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio2 * item.descproducto / 100;
                var descconiva = item.precioconiva * item.descproducto / 100;

                //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
                var Operac= parseFloat(item.precio2) - parseFloat(descsiniva);
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
                        "'" + item.id + "'," +
                        "'" + item.txtCodigo + "'," +
                        "'-1'," +
                        "'" + item.producto + "'," +
                        "'" + item.codmarca + "'," +
                        "'" + item.marca + "'," +
                        "'" + item.codpresentacion + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.codmedida + "'," +
                        "'" + item.medida + "'," +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.precioconiva + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'-'" +
                        ')"' +
                        " type='button'><span class='fa fa-minus'></span></button>" +
                        "<input type='text' id='" + item.cantidad + "' class='bold' style='width:26px;height:34px;' value='" + item.cantidad + "'>" +
                        '<button class="btn btn-info btn-xs" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
                        "'" + item.id + "'," +
                        "'" + item.txtCodigo + "'," +
                        "'+1'," +
                        "'" + item.producto + "'," +
                        "'" + item.codmarca + "'," +
                        "'" + item.marca + "'," +
                        "'" + item.codpresentacion + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.codmedida + "'," +
                        "'" + item.medida + "'," +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.precioconiva + "', " +
                        "'" + item.fechaexpiracion + "', " +
                        "'+'" +
                        ')"' +
                        " type='button'><span class='fa fa-plus'></span></button></td>" +
                        "<td class='text-left'><h5><strong>" + item.producto + "</strong></h5><small>MARCA (" + (item.marca == '' || item.marca == '0' ? '******' : item.marca) + ") : MEDIDA (" + (item.medida == '' || item.medida == '0' ? '******' : item.medida) + ")</small></td>" +
                        "<td><strong>" + item.precio2 + "</strong></td>" +
                        "<td><strong>" + ValorTotal.toFixed(2) + "</strong></td>" +
                        "<td><strong>" + Descuento.toFixed(2) + "<sup>" + item.descproducto + "%</sup></strong></td>" +
                        "<td><strong>" + item.ivaproducto + "</strong></td>" +
                        "<td><strong>" + Operacion.toFixed(2) + "</strong></td>" +
                        "<td>" +
                        '<button type="button" class="btn btn-outline-dark btn-rounded" style="cursor:pointer;" ' +
                        'onclick="addItem(' +
                        "'" + item.id + "'," +
                        "'" + item.txtCodigo + "'," +
                        "'0'," +
                        "'" + item.producto + "'," +
                        "'" + item.codmarca + "'," +
                        "'" + item.marca + "'," +
                        "'" + item.codpresentacion + "'," +
                        "'" + item.presentacion + "'," +
                        "'" + item.codmedida + "'," +
                        "'" + item.medida + "'," +
                        "'" + item.precio + "', " +
                        "'" + item.precio2 + "', " +
                        "'" + item.descproducto + "', " +
                        "'" + item.ivaproducto + "', " +
                        "'" + item.precioconiva + "', " +
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
                            $("#txtTotalCompra").val(TotalCompra.toFixed(2));
                            $("#btn-submit").attr('disabled', false);

                            }

                        });

                        $("#search_traspaso").focus();
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
        Carrito.Id = "vaciar";
        Carrito.Codigo = "vaciar";
        Carrito.Producto = "vaciar";
        Carrito.CodMarca = "vaciar";
        Carrito.Marca = "vaciar";
        Carrito.CodPresentacion = "vaciar";
        Carrito.Presentacion = "vaciar";
        Carrito.CodMedida = "vaciar";
        Carrito.Medida = "vaciar";
        Carrito.Precio      = "vaciar";
        Carrito.Precio2      = "0.00";
        Carrito.Descproducto      = "0";
        Carrito.Ivaproducto = "vaciar";
        Carrito.Precioconiva      = "0.00";
        Carrito.Fechaexpiracion = "vaciar";
        Carrito.Cantidad = "0";
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritotraspaso.php', {
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
        $("#savetraspaso")[0].reset();
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
        $("#btn-submit").attr('disabled', true);
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
        if (code !== 15 && /[^\d]/ig.test(avalue)) {
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
                    params[1],
                    value,
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
                    params[15],
                    '='
                );
                element.attr('data-proc', '0');
            }
        }, 300);
    });
});


function LimpiarTexto() {
    $("#search_traspaso").val("");
    $("#idproducto").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#existencia").val("");
    $("#codmarca").val("");
    $("#marca").val("");
    $("#codpresentacion").val("");
    $("#presentacion").val("");
    $("#codmedida").val("");
    $("#medida").val("");
    $("#preciocompra").val("");
    $("#precioventa").val("");
    $("#descproducto").val("");
    $("#ivaproducto").val("");
    $("#precioconiva").val("0.00");
    $("#fechaexpiracion").val("");
    $("#cantidad").val("");
}


function addItem(id, codigo, cantidad, producto, codmarca, marca, codpresentacion, presentacion, codmedida, medida, precio, precio2,  descproducto, ivaproducto, precioconiva, fechaexpiracion, opCantidad) {
    var Carrito = new Object();
    Carrito.Id = id;
    Carrito.Codigo = codigo;
    Carrito.Producto = producto;
    Carrito.CodMarca = codmarca;
    Carrito.Marca = marca;
    Carrito.CodPresentacion = codpresentacion;
    Carrito.Presentacion = presentacion;
    Carrito.CodMedida = codmedida;
    Carrito.Medida = medida;
    Carrito.Precio = precio;
    Carrito.Precio2 = precio2;
    Carrito.Descproducto = descproducto;
    Carrito.Ivaproducto = ivaproducto;
    Carrito.Precioconiva      = precioconiva;
    Carrito.Fechaexpiracion = fechaexpiracion;
    Carrito.Cantidad = cantidad;
    Carrito.opCantidad = opCantidad;
    var DatosJson = JSON.stringify(Carrito);
    $.post('carritotraspaso.php', {
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

                //CALCULO DEL VALOR TOTAL DE COMPRA
                var OperacionCompra= parseFloat(item.precio) * parseFloat(item.cantidad);
                TotalCompra = parseFloat(TotalCompra) + parseFloat(OperacionCompra);

                //CALCULO DEL VALOR TOTAL
                var ValorTotal= parseFloat(item.precio2) * parseFloat(item.cantidad);

                //CALCULO DEL TOTAL DEL DESCUENTO %
                var Descuento = ValorTotal * item.descproducto / 100;
                TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);
                
                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio * item.descproducto / 100;
                var descconiva = item.precioconiva * item.descproducto / 100;

                //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
                var Operac= parseFloat(item.precio2) - parseFloat(descsiniva);
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
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'-1'," +
                    "'" + item.producto + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marca + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.codmedida + "'," +
                    "'" + item.medida + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.fechaexpiracion + "', " +
                    "'-'" +
                    ')"' +
                    " type='button'><span class='fa fa-minus'></span></button>" +
                    "<input type='text' id='" + item.cantidad + "' class='bold' style='width:26px;height:34px;' value='" + item.cantidad + "'>" +
                    '<button class="btn btn-info btn-xs" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'+1'," +
                    "'" + item.producto + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marca + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.codmedida + "'," +
                    "'" + item.medida + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.fechaexpiracion + "', " +
                    "'+'" +
                    ')"' +
                    " type='button'><span class='fa fa-plus'></span></button></td>" +
                    "<td class='text-left'><h5><strong>" + item.producto + "</strong></h5><small>MARCA (" + (item.marca == '' || item.marca == '0' ? '******' : item.marca) + ") : MEDIDA (" + (item.medida == '' || item.medida == '0' ? '******' : item.medida) + ")</small></td>" +
                    "<td><strong>" + item.precio2 + "</strong></td>" +
                    "<td><strong>" + ValorTotal.toFixed(2) + "</strong></td>" +
                    "<td><strong>" + Descuento.toFixed(2) + "<sup>" + item.descproducto + "%</sup></strong></td>" +
                    "<td><strong>" + item.ivaproducto + "</strong></td>" +
                    "<td><strong>" + Operacion.toFixed(2) + "</strong></td>" +
                    "<td>" +
                    '<button type="button" class="btn btn-outline-dark btn-rounded" style="cursor:pointer;" ' +
                    'onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'0'," +
                    "'" + item.producto + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marca + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.codmedida + "'," +
                    "'" + item.medida + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.precioconiva + "', " +
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
                    $("#txtTotalCompra").val(TotalCompra.toFixed(2));
                    $("#btn-submit").attr('disabled', false);

                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila =
                "<tr>"+"<td class='text-center' colspan=8><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#savetraspaso")[0].reset();
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