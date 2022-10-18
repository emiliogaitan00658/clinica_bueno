<?php
//CARRITO DE ENTRADAS DE PRODUCTOS
session_start();
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo=="vaciar") {
    unset($_SESSION["CarritoTraspaso"]);
} else {
    if (isset($_SESSION['CarritoTraspaso'])) {
        $carrito=$_SESSION['CarritoTraspaso'];
        if (isset($ObjetoCarrito->Codigo)) {
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
            $fechaexpiracion = $ObjetoCarrito->Fechaexpiracion;
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
                    "fechaexpiracion"=>$fechaexpiracion,
                    "cantidad"=>$cuanto
                );
            } else {
                $carrito[]=array(
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
                    "fechaexpiracion"=>$fechaexpiracion,
                    "cantidad"=>$cantidad
                );
            }
        }
    } else {
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
        $fechaexpiracion = $ObjetoCarrito->Fechaexpiracion;
        $cantidad = $ObjetoCarrito->Cantidad;
        $carrito[] = array(
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
            "fechaexpiracion"=>$fechaexpiracion,
            "cantidad"=>$cantidad
        );
    }
    $carrito = array_values(
        array_filter($carrito, function($v) {
            return $v['cantidad'] > 0;
        })
    );
    $_SESSION['CarritoTraspaso'] = $carrito;
    echo json_encode($_SESSION['CarritoTraspaso']);
}
