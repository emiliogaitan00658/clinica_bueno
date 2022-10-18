<?php
//CARRITO DE ENTRADAS DE PRODUCTOS
session_start();
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo=="vaciar") {
    unset($_SESSION["CarritoCotizacion"]);
} else {
    if (isset($_SESSION['CarritoCotizacion'])) {
        $carrito=$_SESSION['CarritoCotizacion'];
        if (isset($ObjetoCarrito->Codigo)) {
            $busqueda = $ObjetoCarrito->Busqueda;
            $id = $ObjetoCarrito->Id;
            $txtCodigo = $ObjetoCarrito->Codigo;
            $producto= $ObjetoCarrito->Producto;
            $codmarca = $ObjetoCarrito->CodMarca;
            $marca = $ObjetoCarrito->Marca;
            $codpresentacion = $ObjetoCarrito->CodPresentacion;
            $presentacion = $ObjetoCarrito->Presentacion;
            $codmedida = $ObjetoCarrito->CodMedida;
            $medida = $ObjetoCarrito->Medida;
            $precio = $ObjetoCarrito->Precio;
            $precio2 = $ObjetoCarrito->Precio2;
            $descproducto = $ObjetoCarrito->Descproducto;
            $ivaproducto = $ObjetoCarrito->Ivaproducto;
            $precioconiva = $ObjetoCarrito->Precioconiva;
            $cantidad = $ObjetoCarrito->Cantidad;
            $opCantidad = $ObjetoCarrito->opCantidad;

            $donde  = array_search($txtCodigo, array_column($carrito, 'txtCodigo'));

            if ($donde !== FALSE) {
                if ($opCantidad === '=') {
                    $cuanto = $cantidad;
                } else {
                    $cuanto = $carrito[$donde]['cantidad'] + $cantidad;
                }
                $carrito[$donde] = array(
                    "busqueda"=>$busqueda,
                    "id"=>$id,
                    "txtCodigo"=>$txtCodigo,
                    "producto"=>$producto,
                    "codmarca"=>$codmarca,
                    "marca"=>$marca,
                    "codpresentacion"=>$codpresentacion,
                    "presentacion"=>$presentacion,
                    "codmedida"=>$codmedida,
                    "medida"=>$medida,
                    "precio"=>$precio,
                    "precio2"=>$precio2,
                    "descproducto"=>$descproducto,
                    "ivaproducto"=>$ivaproducto,
                    "precioconiva"=>$precioconiva,
                    "cantidad"=>$cuanto
                );
            } else {
                $carrito[]=array(
                    "busqueda"=>$busqueda,
                    "id"=>$id,
                    "txtCodigo"=>$txtCodigo,
                    "producto"=>$producto,
                    "codmarca"=>$codmarca,
                    "marca"=>$marca,
                    "codpresentacion"=>$codpresentacion,
                    "presentacion"=>$presentacion,
                    "codmedida"=>$codmedida,
                    "medida"=>$medida,
                    "precio"=>$precio,
                    "precio2"=>$precio2,
                    "descproducto"=>$descproducto,
                    "ivaproducto"=>$ivaproducto,
                    "precioconiva"=>$precioconiva,
                    "cantidad"=>$cantidad
                );
            }
        }
    } else {
        $busqueda = $ObjetoCarrito->Busqueda;
        $id = $ObjetoCarrito->Id;
        $txtCodigo = $ObjetoCarrito->Codigo;
        $producto = $ObjetoCarrito->Producto;
        $codmarca = $ObjetoCarrito->CodMarca;
        $marca = $ObjetoCarrito->Marca;
        $codpresentacion = $ObjetoCarrito->CodPresentacion;
        $presentacion = $ObjetoCarrito->Presentacion;
        $codmedida = $ObjetoCarrito->CodMedida;
        $medida = $ObjetoCarrito->Medida;
        $precio = $ObjetoCarrito->Precio;
        $precio2 = $ObjetoCarrito->Precio2;
        $descproducto = $ObjetoCarrito->Descproducto;
        $ivaproducto = $ObjetoCarrito->Ivaproducto;
        $precioconiva = $ObjetoCarrito->Precioconiva;
        $cantidad = $ObjetoCarrito->Cantidad;
        $carrito[] = array(
            "busqueda"=>$busqueda,
            "id"=>$id,
            "txtCodigo"=>$txtCodigo,
            "producto"=>$producto,
            "codmarca"=>$codmarca,
            "marca"=>$marca,
            "codpresentacion"=>$codpresentacion,
            "presentacion"=>$presentacion,
            "codmedida"=>$codmedida,
            "medida"=>$medida,
            "precio"=>$precio,
            "precio2"=>$precio2,
            "descproducto"=>$descproducto,
            "ivaproducto"=>$ivaproducto,
            "precioconiva"=>$precioconiva,
            "cantidad"=>$cantidad
        );
    }
    $carrito = array_values(
        array_filter($carrito, function($v) {
            return $v['cantidad'] > 0;
        })
    );
    $_SESSION['CarritoCotizacion'] = $carrito;
    echo json_encode($_SESSION['CarritoCotizacion']);
}
