<?php

$accion = $_GET["accion"];
$img = (isset($_POST["img_val"]))? $_POST["img_val"]: "";
$codcita = (isset($_POST["codcita"]))? $_POST["codcita"]: "";
$codpaciente = (isset($_POST["codpaciente"]))? $_POST["codpaciente"]: "";
$codsucursal = (isset($_POST["codsucursal"]))? $_POST["codsucursal"]: "";

switch($accion):
    case "1":
        //save.php code
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        //Get the base-64 string from data
        //$filteredData=substr($img, strpos($img, ",")+1);

        //Decode the string
        $unencodedData = base64_decode($img);
        $nombre = "O_".$codcita."_".$codpaciente."_".$codsucursal.".png";
        
        //Save the image
        file_put_contents('fotos/odontograma/'.$nombre, $unencodedData);
    break;

endswitch;
?>