<?php
include('class.consultas.php');

if (isset($_GET['Busqueda_Marcas'])):

$filtro = $_GET["term"];
$Json = new Json;
$marca = $Json->BuscaMarcas($filtro);
echo json_encode($marca);

endif;

if (isset($_GET['Busqueda_Medidas'])):

$filtro = $_GET["term"];
$Json = new Json;
$medida = $Json->BuscaMedida($filtro);
echo json_encode($medida);

endif;

if (isset($_GET['Busqueda_Cie10'])):

$filtro = $_GET["term"];
$Json = new Json;
$cie10 = $Json->BuscaCie10($filtro);
echo json_encode($cie10);

endif;

if (isset($_GET['Busqueda_Kardex_Producto']) or isset($_GET['Busqueda_Producto_Venta'])):

$filtro = $_GET["term"];
$Json = new Json;
$producto = $Json->BuscaProductoV($filtro);
echo json_encode($producto);

endif;

if (isset($_GET['Busqueda_Producto_Compra'])):

$filtro = $_GET["term"];
$Json = new Json;
$producto = $Json->BuscaProductoC($filtro);
echo json_encode($producto);

endif;


if (isset($_GET['Busqueda_Kardex_Servicio'])):

$filtro = $_GET["term"];
$Json = new Json;
$servicio = $Json->BuscaServicio($filtro);
echo json_encode($servicio);

endif;

if (isset($_GET['Busqueda_Pacientes'])):

$filtro = $_GET["term"];
$Json = new Json;
$paciente = $Json->BuscaPacientes($filtro);
echo json_encode($paciente);

endif;

if (isset($_GET['Busqueda_Especialistas'])):

$filtro = $_GET["term"];
$Json = new Json;
$especialista = $Json->BuscaEspecialistas($filtro);
echo json_encode($especialista);

endif;

?>  