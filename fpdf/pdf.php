<?php
define('FPDF_FONTPATH','fpdf/font/');
define('EURO', chr(128));
require 'pdf_js.php';

############## VARIABLE PARA TAMAÑO DE LOGO ##############
$GLOBALS['logo1_horizontal'] = 78;
$GLOBALS['logo2_horizontal'] = 78;

$GLOBALS['logo1_vertical'] = 50;
$GLOBALS['logo2_vertical'] = 50;
############## VARIABLE PARA TAMAÑO DE LOGO ##############
 

class PDF extends PDF_JavaScript
{
var $widths;
var $aligns;
var $flowingBlockAttr;
//$Tamhoriz = 88;


########################### FUNCION PARA MOSTRAR EL FOOTER ###########################
function Footer() 
{
  if($this->PageNo() != 1){
  //footer code
  $this->Ln();
  $this->SetY(-12);
  //Courier B 10
  $this->SetFont('courier','B',10);
  //Titulo de Footer
  $this->Cell(190,5,'SOFTWARE ODONTOLOGICO','T',0,'L');
  //$this->AliasNbPages();
  //Numero de Pagina
  $this->Cell(0,5,'Pagina '.$this->PageNo(),'T',1,'R'); 

  }
}
########################## FUNCION PARA MOSTRAR EL FOOTER ############################
    
######################## FUNCION PARA CARGAR AUTOPRINTF ########################
function AutoPrint($dialog=false)
{
    //Open the print dialog or start printing immediately on the standard printer
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}

function AutoPrintToPrinter($server, $printer, $dialog=false)
{
    //Print on a shared printer (requires at least Acrobat 6)
    $script = "var pp = getPrintParams();";
    if($dialog)
        $script .= "pp.interactive = pp.constants.interactionLevel.full;";
    else
        $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
    $script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
    $script .= "print(pp);";
    $this->IncludeJS($script);
}
######################## FUNCION PARA CARGAR AUTOPRINT ########################

 





############################################ REPORTES DE USUARIOS ############################################

########################## FUNCION LISTAR USUARIOS ##############################
function TablaListarUsuarios()
   {
    
    $tra = new Login();
    $reg = $tra->ListarUsuarios();
    
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE USUARIOS',0,0,'C');
    

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DOCUMENTO',1,0,'C', True);
    $this->Cell(65,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
    $this->Cell(30,8,'Nº TELÉFONO',1,0,'C', True);
    $this->Cell(60,8,'EMAIL',1,0,'C', True);
    $this->Cell(40,8,'USUARIO',1,0,'C', True);
    $this->Cell(40,8,'NIVEL',1,0,'C', True);
    $this->Cell(50,8,'SUCURSAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,65,30,60,40,40,50));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["dni"]),utf8_decode($reg[$i]["nombres"]),utf8_decode($reg[$i]["telefono"]),utf8_decode($reg[$i]["email"]),utf8_decode($reg[$i]["usuario"]),utf8_decode($reg[$i]["nivel"]),utf8_decode($reg[$i]['nivel'] == 'ADMINISTRADOR(A) GENERAL' ? "*********" : $reg[$i]['gruposnombres'])));
        }
      }
    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº DOCUMENTO',1,0,'C', True);
    $this->Cell(75,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
    $this->Cell(25,8,'SEXO',1,0,'C', True);
    $this->Cell(40,8,'Nº DE TELÉFONO',1,0,'C', True);
    $this->Cell(55,8,'EMAIL',1,0,'C', True);
    $this->Cell(40,8,'USUARIO',1,0,'C', True);
    $this->Cell(55,8,'NIVEL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,75,25,40,55,40,55));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){  

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["dni"]),utf8_decode($reg[$i]["nombres"]),utf8_decode($reg[$i]["sexo"]),utf8_decode($reg[$i]["telefono"]),utf8_decode($reg[$i]["email"]),utf8_decode($reg[$i]["usuario"]),utf8_decode($reg[$i]["nivel"])));
        }
      }
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
     }
########################## FUNCION LISTAR USUARIOS ##############################

########################## FUNCION LISTAR HORARIOS DE USUARIOS ##############################
function TablaListarHorariosUsuarios()
   {
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE HORARIOS DE USUARIOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE Y APELLIDOS',1,0,'C', True);
    $this->Cell(40,8,'NIVEL',1,0,'C', True);
    $this->Cell(25,8,'HORA DESDE',1,0,'C', True);
    $this->Cell(25,8,'HORA HASTA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarHorariosUsuarios();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,60,40,25,25));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["dni"]),utf8_decode($reg[$i]["nombres"]),utf8_decode($reg[$i]["nivel"]),utf8_decode($reg[$i]["hora_desde"]),utf8_decode($reg[$i]["hora_hasta"])));

       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR HORARIOS DE USUARIOS ##############################

########################## FUNCION LISTAR HORARIOS DE ESPECIALISTAS ##############################
function TablaListarHorariosEspecialistas()
   {
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE HORARIOS DE ESPECIALISTAS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE Y APELLIDOS',1,0,'C', True);
    $this->Cell(40,8,'ESPECIALIDAD',1,0,'C', True);
    $this->Cell(25,8,'HORA DESDE',1,0,'C', True);
    $this->Cell(25,8,'HORA HASTA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarHorariosEspecialistas();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,60,40,25,25));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["cedespecialista"]),utf8_decode($reg[$i]["nomespecialista"]),utf8_decode($reg[$i]["especialidad"]),utf8_decode($reg[$i]["hora_desde"]),utf8_decode($reg[$i]["hora_hasta"])));

       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR HORARIOS DE ESPECIALISTAS ##############################

########################## FUNCION LISTAR LOGS DE USUARIOS ##############################
 function TablaListarLogs()
   {
    
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE LOGS DE ACCESO DE USUARIOS',0,0,'C');
    
    $this->Ln();
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(35,8,'IP EQUIPO',1,0,'C', True);
    $this->Cell(45,8,'TIEMPO ENTRADA',1,0,'C', True);
    $this->Cell(145,8,'NAVEGADOR DE ACCESO',1,0,'C', True);
    $this->Cell(60,8,'PÁGINAS DE ACCESO',1,0,'C', True);
    $this->Cell(35,8,'USUARIO',1,1,'C', True);
    

    $tra = new Login();
    $reg = $tra->ListarLogs();

    if($reg==""){
    echo "";      
    } else {
    
    /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,45,145,60,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["ip"]),utf8_decode($reg[$i]["tiempo"]),utf8_decode($reg[$i]["detalles"]),utf8_decode($reg[$i]["paginas"]),utf8_decode($reg[$i]["usuario"])));
       }
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
   }
########################## FUNCION LISTAR LOGS DE USUARIOS ##############################

############################################ REPORTES DE USUARIOS ############################################
















############################################ REPORTES DE CONFIGURACION ############################################

########################## FUNCION LISTAR DEPARTAMENTOS ##############################
function TablaListarDepartamentos()
   {
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE DEPARTAMENTOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE DEPARTAMENTO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarDepartamentos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["departamento"]))));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
     }
########################## FUNCION LISTAR DEPARTAMENTOS ##############################

########################## FUNCION LISTAR PROVINCIAS ##############################
function TablaListarProvincias()
   {
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################


    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE PROVINCIAS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(80,8,'NOMBRE DE PROVINCIA',1,0,'C', True);
    $this->Cell(95,8,'NOMBRE DE DEPARTAMENTO',1,1,'C', True);  

    $tra = new Login();
    $reg = $tra->ListarProvincias();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,80,95));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["provincia"])),portales(utf8_decode($reg[$i]["departamento"]))));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
     }
########################## FUNCION LISTAR PROVINCIAS ##############################


########################## FUNCION LISTAR TIPOS DE DOCUMENTOS ##########################
function TablaListarDocumentos()
   {
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE DOCUMENTOS TRIBUTARIOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE DOCUMENTO',1,0,'C', True);
    $this->Cell(125,8,'DESCRIPCIÓN DE DOCUMENTO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarDocumentos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,50,125));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["documento"]),utf8_decode($reg[$i]["descripcion"])));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TIPOS DE DOCUMENTOS ##########################


########################## FUNCION LISTAR TIPOS DE MONEDA ##############################
function TablaListarTiposMonedas()
   {
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################


    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE TIPOS DE MONEDA',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(85,8,'NOMBRE DE MONEDA',1,0,'C', True);
    $this->Cell(45,8,'SIGLAS',1,0,'C', True);
    $this->Cell(45,8,'SIMBOLO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarTipoMoneda();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,85,45,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["moneda"]),utf8_decode($reg[$i]["siglas"]),utf8_decode($reg[$i]["simbolo"])));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
 }
########################## FUNCION LISTAR TIPOS DE MONEDA ##############################


########################## FUNCION LISTAR TIPOS DE CAMBIO ##############################
function TablaListarTiposCambio()
   {
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE TIPOS DE CAMBIO',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE CAMBIO',1,0,'C', True);
    $this->Cell(35,8,'MONTO DE CAMBIO',1,0,'C', True);
    $this->Cell(35,8,'TIPO DE MONEDA',1,0,'C', True);
    $this->Cell(35,8,'FECHA DE INGRESO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarTipoCambio();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,70,35,35,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["descripcioncambio"])),utf8_decode($reg[$i]["montocambio"]),utf8_decode($reg[$i]['moneda']."/".$reg[$i]['siglas']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacambio'])))));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TIPOS DE CAMBIO ##############################


########################## FUNCION LISTAR IMPUESTOS ##############################
function TablaListarImpuestos()
   {
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE IMPUESTOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE IMPUESTO',1,0,'C', True);
    $this->Cell(35,8,'VALOR(%)',1,0,'C', True);
    $this->Cell(35,8,'STATUS',1,0,'C', True);
    $this->Cell(35,8,'FECHA DE INGRESO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarImpuestos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,70,35,35,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nomimpuesto"]),utf8_decode($reg[$i]["valorimpuesto"]),utf8_decode($reg[$i]['statusimpuesto']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])))));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR IMPUESTOS ##############################

########################## FUNCION LISTAR MARCAS ##############################
function TablaListarMarcas()
   {
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE MARCAS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE MARCA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarMarcas();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nommarca"]))));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR MARCAS ##############################


########################## FUNCION LISTAR PRESENTACIONES ##############################
function TablaListarPresentaciones()
   {
    
  ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE PRESENTACIONES',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE PRESENTACIÓN',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarPresentaciones();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nompresentacion"]))));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRESENTACIONES ##############################


########################## FUNCION LISTAR UNIDAD MEDIDA ##############################
function TablaListarMedidas()
   {
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE UNIDAD MEDIDA',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE UNIDAD MEDIDA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarMedidas();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nommedida"])));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR UNIDAD MEDIDA ##############################


########################## FUNCION LISTAR SUCURSALES ##############################
function TablaListarSucursales()
   {

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE SUCURSALES',0,0,'C');
    
    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE REGISTRO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE SUCURSAL',1,0,'C', True);
    $this->Cell(25,8,'PROVINCIA',1,0,'C', True);
    $this->Cell(30,8,'DEPARTAMENTO',1,0,'C', True);
    $this->Cell(55,8,'DIRECCIÓN',1,0,'C', True);
    $this->Cell(35,8,'CORREO ELECT',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TELÉFONO',1,0,'C', True);
    $this->Cell(45,8,'ENCARGADO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarSucursales();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,60,25,30,55,35,35,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["cuitsucursal"]),portales(utf8_decode($reg[$i]["nomsucursal"])),portales(utf8_decode($reg[$i]['id_provincia'] == '0' ? "********" : $reg[$i]['provincia'])),portales(utf8_decode($reg[$i]['id_departamento'] == '0' ? "********" : $reg[$i]['departamento'])),portales(utf8_decode($reg[$i]["direcsucursal"])),portales(utf8_decode($reg[$i]["correosucursal"])),utf8_decode($reg[$i]["tlfsucursal"]),portales(utf8_decode($reg[$i]["nomencargado"]))));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SUCURSALES ##############################

########################## FUNCION LISTAR TRATAMIENTOS ##############################
function TablaListarTratamientos()
   {
    
  ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE TRATAMIENTOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(175,8,'NOMBRE DE TRATAMIENTO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarTratamientos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,175));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomtratamiento"]))));
       }
   }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TRATAMIENTOS ##############################

########################## FUNCION LISTAR MENSAJES DE CONTACTO ##############################
function TablaListarMensajes()
   {
    
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE MENSAJES DE CONTACTO',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(60,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TELEFONO',1,0,'C', True);
    $this->Cell(40,8,'EMAIL',1,0,'C', True);
    $this->Cell(40,8,'ASUNTO',1,0,'C', True);
    $this->Cell(90,8,'MENSAJE',1,0,'C', True);
    $this->Cell(50,8,'FECHA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarMensajes();

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,60,35,40,40,90,50));

    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["name"])),utf8_decode($reg[$i]['phone'] == '' ? "******" : $reg[$i]['phone']),utf8_decode($reg[$i]['email']),portales(utf8_decode($reg[$i]['subject'])),portales(utf8_decode($reg[$i]['message'])),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]["fecha"])))));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR MENSAJES DE CONTACTO ##############################

############################################ REPORTES DE CONFIGURACION ############################################







































############################### REPORTES DE MANTENIMIENTO ##############################

########################## FUNCION LISTAR ESPECIALISTAS ##############################
function TablaListarEspecialistas()
   {
    
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE ESPECIALISTAS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TELEFONO',1,0,'C', True);
    $this->Cell(25,8,'SEXO',1,0,'C', True);
    $this->Cell(60,8,'DIRECCIÓN DOMICILIARIA',1,0,'C', True);
    $this->Cell(55,8,'CORREO ELECTRÓNICO',1,0,'C', True);
    $this->Cell(40,8,'ESPECIALIDAD',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarEspecialistas();

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,40,60,35,25,60,55,40));

    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($documento = ($reg[$i]['documespecialista'] == '0' ? "****" : $reg[$i]['documento'])." ".$reg[$i]["cedespecialista"]),portales(utf8_decode($reg[$i]["nomespecialista"])),utf8_decode($reg[$i]['tlfespecialista'] == '' ? "******" : $reg[$i]['tlfespecialista']),utf8_decode($reg[$i]['sexoespecialista']),
        utf8_decode($departamento = ($reg[$i]['id_departamento'] == '0' ? "*" : $reg[$i]['departamento']." ")."".$provincia = ($reg[$i]['id_provincia'] == '0' ? "*" : $reg[$i]['provincia']." ")."".$reg[$i]["direcespecialista"]),utf8_decode($reg[$i]['correoespecialista'] == '' ? "*********" : $reg[$i]['correoespecialista']),utf8_decode($reg[$i]['especialidad'])));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ESPECIALISTAS ##############################

########################## FUNCION LISTAR ESPECIALISTAS ##############################
function TablaListarPacientes()
   {
    
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE PACIENTES',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(50,8,'NOMBRES',1,0,'C', True);
    $this->Cell(50,8,'APELLIDOS',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TELEFONO',1,0,'C', True);
    $this->Cell(40,8,'GRUPO SANGUINEO',1,0,'C', True);
    $this->Cell(60,8,'DIRECCIÓN DOMICILIARIA',1,0,'C', True);
    $this->Cell(40,8,'FECHA NAC.',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarPacientes();

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,40,50,50,35,40,60,40));

    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($documento = ($reg[$i]['documpaciente'] == '0' ? "*********" : $reg[$i]['documento'])." ".$reg[$i]["cedpaciente"]),portales(utf8_decode($reg[$i]["pnompaciente"]." ".$reg[$i]['snompaciente'])),portales(utf8_decode($reg[$i]["papepaciente"]." ".$reg[$i]['sapepaciente'])),utf8_decode($reg[$i]['tlfpaciente'] == '' ? "*********" : $reg[$i]['tlfpaciente']),utf8_decode($reg[$i]['gruposapaciente']),
        utf8_decode($departamento = ($reg[$i]['id_departamento'] == '0' ? "*" : $reg[$i]['departamento']." ")."".$provincia = ($reg[$i]['id_provincia'] == '0' ? "*" : $reg[$i]['provincia']." ")."".$reg[$i]["direcpaciente"]),utf8_decode($reg[$i]['fnacpaciente'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fnacpaciente'])))));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
     }
########################## FUNCION LISTAR PACIENTES ##############################

########################## FUNCION LISTAR PROVEEDORES ##############################
function TablaListarProveedores()
   {
    
    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE PROVEEDORES',0,0,'C');
    
    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE PROVEEDOR',1,0,'C', True);
    $this->Cell(40,8,'Nº DE TELÉFONO',1,0,'C', True);
    $this->Cell(60,8,'DIRECCIÓN DOMICILIARIA',1,0,'C', True);
    $this->Cell(60,8,'EMAIL',1,0,'C', True);
    $this->Cell(55,8,'VENDEDOR',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarProveedores();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,40,60,60,55));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["documento"]." ".$reg[$i]["cuitproveedor"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode($reg[$i]["tlfproveedor"]),utf8_decode($provincia = ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]["provincia"]." ")."".$departamento = ($reg[$i]['id_departamento'] == '0' ? "" : $reg[$i]["departamento"]." ")."".$reg[$i]["direcproveedor"]),utf8_decode($reg[$i]['emailproveedor']),utf8_decode($reg[$i]["vendedor"])));
       }
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
     }
########################## FUNCION LISTAR PROVEEDORES ##############################

############################### REPORTES DE MANTENIMIENTO ##############################






















############################### REPORTES DE SERVICIOS ##############################

########################## FUNCION LISTAR SERVICIOS ##############################
function TablaListarServicios()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarServicios();

    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE SERVICIOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(190,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,1,'L'); 

    }

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(15,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN DE SERVICIO',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(30,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,15,55,15,15,20,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalCompra=0;
    $TotalVenta=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $TotalCompra+=$reg[$i]['preciocompra'];
    $TotalVenta+=$reg[$i]['precioventa']-$reg[$i]['descservicio']/100;
    $simbolo = $reg[$i]['simbolo']." ";

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codservicio"]),portales(utf8_decode($reg[$i]["servicio"])),utf8_decode($reg[$i]['ivaservicio'] == 'SI' ? $valor."%" : "(E)"),utf8_decode($reg[$i]['descservicio']),utf8_decode($reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"),utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********")),utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','))));
       }

    $this->Cell(130,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "**********")),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SERVICIOS ##############################

########################## FUNCION LISTAR SERVICIOS VENDIDOS POR FECHAS ##############################
function TablaListarServiciosVendidos()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarServiciosVendidos();

    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE SERVICIOS VENDIDOS ',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(190,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,1,'L'); 

    } 

    $this->Ln();
    $this->Cell(190,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(15,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN DE SERVICIO',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(20,8,'VENDIDO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL ',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,15,55,15,15,30,20,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $PrecioTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $PrecioTotal+=$reg[$i]['precioventa'];
    $VendidosTotal+=$reg[$i]['cantidad']; 
    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad']; 
    $simbolo = $reg[$i]['simbolo']." "; 
    
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codservicio"]),portales(utf8_decode($reg[$i]["servicio"])),utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"),utf8_decode($reg[$i]['descproducto']),utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),utf8_decode($reg[$i]['cantidad']),utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
       }

    $this->Cell(110,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SERVICIOS VENDIDOS POR FECHAS ##############################

########################## FUNCION LISTAR SERVICIOS VENDIDOS POR VENDEDOR Y FECHAS ##############################
function TablaListarServiciosVendidosxVendedor()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarServiciosxVendedor();

    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE SERVICIOS VENDIDOS POR VENDEDOR',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(190,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,1,'L'); 

    } 

    $this->Ln();
    $this->Cell(190,6,"VENDEDOR: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(15,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN DE SERVICIO',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(20,8,'VENDIDO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL ',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,15,55,15,15,30,20,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $PrecioTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $PrecioTotal+=$reg[$i]['precioventa'];
    $VendidosTotal+=$reg[$i]['cantidad']; 
    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
    $simbolo = $reg[$i]['simbolo']." "; 
    
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codservicio"]),portales(utf8_decode($reg[$i]["servicio"])),utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"),utf8_decode($reg[$i]['descproducto']),utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),utf8_decode($reg[$i]['cantidad']),utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
       }

    $this->Cell(110,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SERVICIOS VENDIDOS POR VENDEDOR Y FECHAS ##############################

########################## FUNCION LISTAR SERVICIOS POR MONEDA ##############################
function TablaListarServiciosxMoneda()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $cambio = new Login();
    $cambio = $cambio->BuscarTiposCambios();

    $tra = new Login();
    $reg = $tra->ListarServicios();

    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE SERVICIOS POR MONEDA ('.$cambio[0]["moneda"].")",0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(190,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,1,'L'); 

    } 

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(15,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN DE SERVICIO',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(30,8,'PRECIO '.$cambio[0]['siglas'],1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,15,55,15,15,20,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalCompra=0;
    $TotalVenta=0;
    $TotalMoneda=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $TotalCompra+=$reg[$i]['preciocompra'];

    $Descuento = $reg[$i]['descservicio']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

    $TotalVenta+=$reg[$i]['precioventa'];
    $TotalMoneda+=(empty($reg[$i]['montocambio']) ? "0.00" : number_format($PrecioFinal / $reg[$i]['montocambio'], 2, '.', ','));
    $moneda = (empty($cambio[0]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $cambio[0]['montocambio'], 2, '.', ',')); 

    $simbolo = $reg[$i]['simbolo']." ";
    $simbolo2 = ($cambio[0]['simbolo'] == "" ? "" : $cambio[0]['simbolo']." "); 
    
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codservicio"]),portales(utf8_decode($reg[$i]["servicio"])),utf8_decode($reg[$i]['ivaservicio'] == 'SI' ? $valor."%" : "(E)"),utf8_decode($reg[$i]['descservicio']),utf8_decode($reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"),utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),utf8_decode($simbolo2.$moneda)));
       }

    $this->Cell(130,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo2.number_format($TotalMoneda, 2, '.', ',')),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SERVICIOS POR MONEDA ##############################

########################## FUNCION LISTAR KARDEX POR SERVICIO ##############################
 function TablaListarKardexServicios()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $detalle = new Login();
    $detalle = $detalle->DetalleKardexServicio();

    $kardex = new Login();
    $kardex = $kardex->BuscarKardexServicio();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE KARDEX POR SERVICIO ',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($detalle[0]['documento']).": ".utf8_decode($detalle[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($detalle[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO: ".portales(utf8_decode($detalle[0]["nomencargado"])),0,0,'L'); 

    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'MOVIMIENTO',1,0,'C', True);
    $this->Cell(30,8,'ENTRADAS',1,0,'C', True);
    $this->Cell(30,8,'SALIDAS',1,0,'C', True);
    $this->Cell(30,8,'DEVOLUCIÓN',1,0,'C', True);
    $this->Cell(20,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESCUENTO',1,0,'C', True);
    $this->Cell(30,8,'PRECIO',1,0,'C', True);
    $this->Cell(35,8,'COSTO',1,0,'C', True);
    $this->Cell(45,8,'DOCUMENTO',1,0,'C', True);
    $this->Cell(30,8,'FECHA KARDEX',1,1,'C', True);

    if($kardex==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,40,30,30,30,20,30,30,35,45,30));

    $TotalEntradas=0;
    $TotalSalidas=0;
    $TotalDevolucion=0;
    $a=1;
    for($i=0;$i<sizeof($kardex);$i++){ 
    $TotalEntradas+=$kardex[$i]['entradas'];
    $TotalSalidas+=$kardex[$i]['salidas'];
    $TotalDevolucion+=$kardex[$i]['devolucion'];
    $Descuento = $kardex[$i]['descproducto']/100;
    $PrecioDescuento = $kardex[$i]['precio']*$Descuento;
    $PrecioFinal = $kardex[$i]['precio']-$PrecioDescuento;
    $simbolo = $detalle[0]['simbolo']." ";

    if($kardex[$i]["movimiento"]=="ENTRADAS"){
        $costo = $PrecioFinal*$kardex[$i]['entradas'];
    } elseif($kardex[$i]["movimiento"]=="SALIDAS"){
        $costo = $PrecioFinal*$kardex[$i]['salidas'];
    } else {
        $costo = $PrecioFinal*$kardex[$i]['devolucion'];
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($kardex[$i]["movimiento"]),
        utf8_decode($kardex[$i]["entradas"]),
        utf8_decode($kardex[$i]["salidas"]),
        utf8_decode($kardex[$i]["devolucion"]),
        utf8_decode($kardex[$i]['ivaproducto']),
        utf8_decode($kardex[$i]['descproducto']),
        utf8_decode($simbolo.number_format($kardex[$i]['precio'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($costo, 2, '.', ',')),
        portales(utf8_decode($kardex[$i]['documento'])),
        utf8_decode(date("d-m-Y",strtotime($kardex[$i]['fechakardex'])))));
       }
   }

    $this->Cell(325,5,'',0,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(120,5,'DETALLES DEL SERVICIO',1,0,'C', True);
    $this->Ln();
    
    $this->Cell(35,5,'CÓDIGO',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($detalle[0]['codservicio']),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'DESCRIPCIÓN',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,portales(utf8_decode($detalle[0]['servicio'])),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'ENTRADAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($TotalEntradas),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'SALIDAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($TotalSalidas),1,0,'C');
    $this->Ln();

    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'DEVOLUCIÓN',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($TotalDevolucion),1,0,'C');
    $this->Ln();

    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'PRECIO COMPRA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "**********")),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'PRECIO VENTA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioventa'], 2, '.', ',')),1,0,'C');
    $this->Ln();


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR KARDEX POR SERVICIO ##############################

########################## FUNCION LISTAR SERVICIOS VALORIZADO POR FECHAS ##############################
 function TablaListarKardexServiciosValorizadoxFechas()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarKardexServiciosValorizadoxFechas(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO KARDEX SERVICIOS VALORIZADO POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"VENDEDOR: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(20,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(30,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(20,8,'VENDIDO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(40,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,70,15,15,30,30,20,40,40,40));

    $PrecioCompraTotal=0;
    $PrecioVentaTotal=0;
    $VendidosTotal=0;
    $CompraTotal=0;
    $VentaTotal=0;
    $TotalGanancia=0;
    $simbolo="";
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $PrecioCompraTotal+=$reg[$i]['preciocompra'];
    $PrecioVentaTotal+=$reg[$i]['precioventa'];
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $CompraTotal+=$reg[$i]['preciocompra']*$reg[$i]['cantidad'];

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $VentaTotal+=$PrecioFinal*$reg[$i]['cantidad'];

    $SumVenta = $PrecioFinal*$reg[$i]['cantidad']; 
    $SumCompra = $reg[$i]['preciocompra']*$reg[$i]['cantidad'];
    $simbolo = $reg[$i]['simbolo']." ";
    $TotalGanancia+=$SumVenta-$SumCompra; 

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codservicio']),
        portales(utf8_decode($reg[$i]["servicio"])),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"),
        utf8_decode($reg[$i]['descproducto']),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********")),        
        utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ',') : "**********")),
        utf8_decode($simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','))));
       }
   
    $this->Cell(135,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($PrecioCompraTotal, 2, '.', ',') : "**********")),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioVentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($VentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "**********")),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalGanancia, 2, '.', ',')),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR KARDEX SERVICIOS VALORIZADO POR FECHAS ##############################

############################### REPORTES DE MANTENIMIENTO ##############################






























############################### REPORTES DE PRODUCTOS ##############################

########################## FUNCION LISTAR PRODUCTOS ##############################
 function TablaListarProductos()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarProductos(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(25,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(35,8,'MARCA',1,0,'C', True);
    $this->Cell(35,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(25,8,'MEDIDA',1,0,'C', True);
    $this->Cell(40,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(40,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,60,35,35,25,40,40,25,15,15));

    $a=1;
    $TotalCompra=0;
    $TotalVenta=0;
    $TotalArticulos=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $TotalCompra+=$reg[$i]['preciocompra'];
    $TotalVenta+=$reg[$i]['precioventa']-$reg[$i]['descproducto']/100;
    $TotalArticulos+=$reg[$i]['existencia'];
    $simbolo = $reg[$i]['simbolo']." ";

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]['codmedida'] == '0' ? "*********" : $reg[$i]['nommedida']),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********")),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"),
        utf8_decode($reg[$i]['descproducto'])));
       }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "**********")),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS ##############################

########################## FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ##############################
 function TablaListarProductosMinimo()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarProductosMinimo(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS EN STOCK MINIMO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg!=""){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(20,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(35,8,'MARCA',1,0,'C', True);
    $this->Cell(35,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(25,8,'MEDIDA',1,0,'C', True);
    $this->Cell(35,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(35,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(25,8,'EXIST',1,0,'C', True);
    $this->Cell(25,8,'STOCK MIN.',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,50,35,35,25,35,35,25,25,15,15));

    $a=1;
    $TotalCompra=0;
    $TotalVenta=0;
    $TotalArticulos=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $TotalCompra+=$reg[$i]['preciocompra'];
    $TotalVenta+=$reg[$i]['precioventa']-$reg[$i]['descproducto']/100;
    $TotalArticulos+=$reg[$i]['existencia'];
    $simbolo = $reg[$i]['simbolo']." ";

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]['codmedida'] == '0' ? "*********" : $reg[$i]['nommedida']),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********")),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($reg[$i]['stockminimo']),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"),
        utf8_decode($reg[$i]['descproducto'])));
       }
   
    $this->Cell(180,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "**********")),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ##############################

########################## FUNCION LISTAR PRODUCTOS EN STOCK MAXIMO ##############################
 function TablaListarProductosMaximo()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarProductosMaximo(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS EN STOCK MAXIMO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg!=""){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(20,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(35,8,'MARCA',1,0,'C', True);
    $this->Cell(35,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(25,8,'MEDIDA',1,0,'C', True);
    $this->Cell(35,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(35,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(25,8,'EXIST',1,0,'C', True);
    $this->Cell(25,8,'STOCK MAX.',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,50,35,35,25,35,35,25,25,15,15));

    $a=1;
    $TotalCompra=0;
    $TotalVenta=0;
    $TotalArticulos=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $TotalCompra+=$reg[$i]['preciocompra'];
    $TotalVenta+=$reg[$i]['precioventa']-$reg[$i]['descproducto']/100;
    $TotalArticulos+=$reg[$i]['existencia'];
    $simbolo = $reg[$i]['simbolo']." ";

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]['codmedida'] == '0' ? "*********" : $reg[$i]['nommedida']),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********")),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($reg[$i]['stockmaximo']),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"),
        utf8_decode($reg[$i]['descproducto'])));
       }
   
    $this->Cell(180,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "**********")),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MAXIMO ##############################

########################## FUNCION LISTAR PRODUCTOS VENDIDOS POR FECHAS ##############################
function TablaListarProductosVendidos()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarProductosVendidos();

    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE PRODUCTOS VENDIDOS POR FECHAS ',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(190,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,1,'L'); 

    } 

    $this->Ln();
    $this->Cell(190,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(15,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(20,8,'VENDIDO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL ',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,15,55,15,15,30,20,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $PrecioTotal+=$reg[$i]['precioventa'];
    $ExisteTotal+=$reg[$i]['existencia'];
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad']; 

    $simbolo = $reg[$i]['simbolo']." ";
    
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codproducto"]),portales(utf8_decode($reg[$i]["producto"])),utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"),utf8_decode($reg[$i]['descproducto']),utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),utf8_decode($reg[$i]['cantidad']),utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
       }

    $this->Cell(110,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS VENDIDOS POR FECHAS ##############################

########################## FUNCION LISTAR PRODUCTOS VENDIDOS POR VENDEDOR Y FECHAS ##############################
function TablaListarProductosVendidosxVendedor()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarProductosxVendedor();

    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE PRODUCTOS VENDIDOS POR VENDEDOR',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(190,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,1,'L'); 

    } 

    $this->Ln();
    $this->Cell(190,6,"VENDEDOR: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(15,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(20,8,'VENDIDO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL ',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,15,55,15,15,30,20,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $PrecioTotal+=$reg[$i]['precioventa'];
    $ExisteTotal+=$reg[$i]['existencia'];
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal+=$PrecioFinal*$reg[$i]['cantidad']; 

    $simbolo = $reg[$i]['simbolo']." ";
    
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codproducto"]),portales(utf8_decode($reg[$i]["producto"])),utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"),utf8_decode($reg[$i]['descproducto']),utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),utf8_decode($reg[$i]['cantidad']),utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
       }

    $this->Cell(110,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS VENDIDOS POR VENDEDOR Y FECHAS ##############################

########################## FUNCION LISTAR PRODUCTOS POR MONEDA ##############################
 function TablaListarProductosxMoneda()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarProductos(); 

    $cambio = new Login();
    $cambio = $cambio->BuscarTiposCambios();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS POR MONEDA ('.$cambio[0]["moneda"].")",0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg!=""){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(20,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(40,8,'MARCA',1,0,'C', True);
    $this->Cell(35,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(25,8,'MEDIDA',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(25,8,'EXIST',1,0,'C', True);
    $this->Cell(30,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(30,8,'PRECIO '.$cambio[0]['siglas'],1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,55,40,35,25,15,15,25,30,30,30));

    $a=1;
    $TotalCompra=0;
    $TotalVenta=0;
    $TotalMoneda=0;
    $TotalArticulos=0;

    for($i=0;$i<sizeof($reg);$i++){

    $TotalCompra+=$reg[$i]['preciocompra'];

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

    $TotalVenta+=$reg[$i]['precioventa'];
    $TotalMoneda+=(empty($reg[$i]['montocambio']) ? "0.00" : number_format($PrecioFinal / $reg[$i]['montocambio'], 2, '.', ','));
    $moneda = (empty($cambio[0]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $cambio[0]['montocambio'], 2, '.', ',')); 
    $TotalArticulos+=$reg[$i]['existencia'];
    $simbolo = $reg[$i]['simbolo']." ";
    $simbolo2 = ($cambio[0]['simbolo'] == "" ? "" : $cambio[0]['simbolo']." ");

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]['codmedida'] == '0' ? "*********" : $reg[$i]['nommedida']),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"),
        utf8_decode($reg[$i]['descproducto']),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********")),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo2.$moneda)));
       }
   
    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "**********")),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo2.number_format($TotalMoneda, 2, '.', ',')),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS POR MONEDA ##############################

########################## FUNCION LISTAR KARDEX POR PRODUCTO ##############################
 function TablaListarKardexProductos()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $detalle = new Login();
    $detalle = $detalle->DetalleKardexProducto();

    $kardex = new Login();
    $kardex = $kardex->BuscarKardexProducto();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE KARDEX POR PRODUCTO ',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($detalle[0]['documento']).": ".utf8_decode($detalle[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($detalle[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO: ".portales(utf8_decode($detalle[0]["nomencargado"])),0,0,'L'); 

    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'MOVIMIENTO',1,0,'C', True);
    $this->Cell(25,8,'ENTRADAS',1,0,'C', True);
    $this->Cell(25,8,'SALIDAS',1,0,'C', True);
    $this->Cell(25,8,'DEVOLUCIÓN',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(20,8,$impuesto,1,0,'C', True);
    $this->Cell(20,8,'DESC%',1,0,'C', True);
    $this->Cell(30,8,'PRECIO',1,0,'C', True);
    $this->Cell(40,8,'COSTO',1,0,'C', True);
    $this->Cell(50,8,'DOCUMENTO',1,0,'C', True);
    $this->Cell(30,8,'FECHA KARDEX',1,1,'C', True);

    if($kardex==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,25,25,25,25,20,20,30,40,50,30));

    $TotalEntradas=0;
    $TotalSalidas=0;
    $TotalDevolucion=0;
    $a=1;
    for($i=0;$i<sizeof($kardex);$i++){ 
    $TotalEntradas+=$kardex[$i]['entradas'];
    $TotalSalidas+=$kardex[$i]['salidas'];
    $TotalDevolucion+=$kardex[$i]['devolucion'];
    $Descuento = $kardex[$i]['descproducto']/100;
    $PrecioDescuento = $kardex[$i]['precio']*$Descuento;
    $PrecioFinal = $kardex[$i]['precio']-$PrecioDescuento;
    $simbolo = $detalle[0]['simbolo']." ";

    if($kardex[$i]["movimiento"]=="ENTRADAS"){
        $costo = $PrecioFinal*$kardex[$i]['entradas'];
    } elseif($kardex[$i]["movimiento"]=="SALIDAS"){
        $costo = $PrecioFinal*$kardex[$i]['salidas'];
    } else {
        $costo = $PrecioFinal*$kardex[$i]['devolucion'];
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($kardex[$i]["movimiento"]),
        utf8_decode($kardex[$i]["entradas"]),
        utf8_decode($kardex[$i]["salidas"]),
        utf8_decode($kardex[$i]["devolucion"]),
        utf8_decode($kardex[$i]['stockactual']),
        utf8_decode($kardex[$i]['ivaproducto']),
        utf8_decode($kardex[$i]['descproducto']),
        utf8_decode($simbolo.number_format($kardex[$i]['precio'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($costo, 2, '.', ',')),
        portales(utf8_decode($kardex[$i]['documento'])),
        utf8_decode(date("d-m-Y",strtotime($kardex[$i]['fechakardex'])))));
       }
   }

    $this->Cell(325,5,'',0,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(120,5,'DETALLES DEL PRODUCTO',1,0,'C', True);
    $this->Ln();
    
    $this->Cell(35,5,'CÓDIGO',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($detalle[0]['codproducto']),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'DESCRIPCIÓN',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,portales(utf8_decode($detalle[0]['producto'])),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'ENTRADAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($TotalEntradas),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'SALIDAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($TotalSalidas),1,0,'C');
    $this->Ln();

    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'DEVOLUCIÓN',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($TotalDevolucion),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'EXISTENCIA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($detalle[0]['existencia']),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'PRECIO COMPRA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "**********")),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'PRECIO VENTA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioventa'], 2, '.', ',')),1,0,'C');
    $this->Ln();


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR KARDEX POR PRODUCTO ##############################

########################## FUNCION LISTAR KARDEX VALORIZADO ##############################
 function TablaListarKardexProductosValorizado()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarKardexProductosValorizado(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO KARDEX PRODUCTOS VALORIZADO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(20,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(40,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(25,8,'MEDIDA',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(20,8,'EXIST',1,0,'C', True);
    $this->Cell(30,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(30,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(30,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,40,30,30,25,30,15,15,20,30,30,30));

    $PrecioCompraTotal=0;
    $PrecioVentaTotal=0;
    $ExisteTotal=0;
    $CompraTotal=0;
    $VentaTotal=0;
    $TotalGanancia=0;
    $simbolo="";
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $PrecioCompraTotal+=$reg[$i]['preciocompra'];
    $PrecioVentaTotal+=$reg[$i]['precioventa'];
    $ExisteTotal+=$reg[$i]['existencia']; 

    $CompraTotal+=$reg[$i]['preciocompra']*$reg[$i]['existencia'];

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $VentaTotal+=$PrecioFinal*$reg[$i]['existencia'];

    $SumVenta = $PrecioFinal*$reg[$i]['existencia']; 
    $SumCompra = $reg[$i]['preciocompra']*$reg[$i]['existencia'];
    $simbolo = $reg[$i]['simbolo']." ";
    $TotalGanancia+=$SumVenta-$SumCompra;

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]['codmedida'] == '0' ? "*********" : $reg[$i]['nommedida']),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"),
        utf8_decode($reg[$i]['descproducto']),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ',') : "**********")),
        utf8_decode($simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','))));
       }
   
    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($VentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "**********")),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalGanancia, 2, '.', ',')),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR KARDEX VALORIZADO ##############################

########################## FUNCION LISTAR KARDEX VALORIZADO POR FECHAS ##############################
 function TablaListarKardexProductosValorizadoxFechas()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarKardexProductosValorizadoxFechas(); 

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO KARDEX PRODUCTOS VALORIZADO POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(20,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(40,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(25,8,'MEDIDA',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(20,8,'VENDIDO',1,0,'C', True);
    $this->Cell(30,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(30,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(30,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,40,30,30,25,30,15,15,20,30,30,30));

    $PrecioCompraTotal=0;
    $PrecioVentaTotal=0;
    $VendidosTotal=0;
    $CompraTotal=0;
    $VentaTotal=0;
    $TotalGanancia=0;
    $simbolo="";
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $PrecioCompraTotal+=$reg[$i]['preciocompra'];
    $PrecioVentaTotal+=$reg[$i]['precioventa'];
    $VendidosTotal+=$reg[$i]['cantidad']; 

    $CompraTotal+=$reg[$i]['preciocompra']*$reg[$i]['cantidad'];

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
    $VentaTotal+=$PrecioFinal*$reg[$i]['cantidad'];

    $SumVenta = $PrecioFinal*$reg[$i]['cantidad']; 
    $SumCompra = $reg[$i]['preciocompra']*$reg[$i]['cantidad'];
    $simbolo = $reg[$i]['simbolo']." ";
    $TotalGanancia+=$SumVenta-$SumCompra;

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]["nommarca"]),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]['codmedida'] == '0' ? "*********" : $reg[$i]['nommedida']),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"),
        utf8_decode($reg[$i]['descproducto']),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ',') : "**********")),
        utf8_decode($simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','))));
       }
   
    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($VentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "**********")),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalGanancia, 2, '.', ',')),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR KARDEX VALORIZADO POR FECHAS ##############################

############################### REPORTES DE PRODUCTOS ###########################



































############################### REPORTES DE TRASPASOS ################################

########################## FUNCION FACTURA TRASPASOS ##############################
function FacturaTraspaso()
    {
        
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $con = new Login();
    $con = $con->ConfiguracionPorId();

    $tra = new Login();
    $reg = $tra->TraspasosPorId();

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
             
        if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 15, 10, 60, 20, "PNG");

        } elseif (file_exists("./fotos/logo_principal.png")) {

        $logo = "./fotos/logo_principal.png";
        $this->Image($logo, 15, 10, 60, 20, "PNG");

        } else {

        $logo = "./assets/images/null.png";                         
        $this->Image($logo, 15, 10, 60, 20, "PNG");  

        }                                      
    }

    ######################### BLOQUE N° 1 ######################### 
   //BLOQUE DE DATOS DE PRINCIPAL
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 335, 20, '1.5', '');
    
    //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(161, 13, 13, 13, '1.5', 'F');

    //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(161, 13, 13, 13, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(164.5, 14);
    $this->Cell(20, 5, 'T', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(161, 19);
    $this->Cell(20, 5, 'Trasp.', 0, 0);
    
    $this->SetFont('courier','B',14);
    $this->SetXY(260, 12);
    $this->Cell(46, 6, 'N° DE TRASPASO ', 0, 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(306, 12);
    $this->CellFitSpace(36, 6,utf8_decode($reg[0]['codtraspaso']), 0, 0, "R");
    
    $this->SetFont('courier','B',11);
    $this->SetXY(260, 18);
    $this->Cell(46, 5, 'FECHA DE EMISIÓN ', 0, 0);
    $this->SetFont('courier','',11);
    $this->SetXY(306, 18);
    $this->CellFitSpace(36, 5,utf8_decode(date("d-m-Y H:i:s",strtotime($reg[0]['fechatraspaso']))), 0, 0, "R");
    
    $this->SetFont('courier','B',11);
    $this->SetXY(260, 23);
    $this->Cell(46, 5, 'FECHA DE RECEPCIÓN ', 0, 0);
    $this->SetFont('courier','',11);
    $this->SetXY(306, 23);
    $this->CellFitSpace(36, 5,utf8_decode(date("d-m-Y H:i:s")), 0, 0, "R");
    ######################### BLOQUE N° 1 ######################### 

    ############################## BLOQUE N° 2 #####################################   
    //BLOQUE DE DATOS DE SUCURSAL QUE ENVIA
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 32, 335, 32, '1.5', '');

    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 33);
    $this->Cell(330, 5, 'DATOS DE SUCURSAL QUE ENVIA', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 38);
    $this->CellFitSpace(28, 5, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 38);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(70, 38);
    $this->Cell(30, 5, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(100, 38);
    $this->CellFitSpace(60, 5,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(160, 38);
    $this->Cell(24, 5, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(184, 38);
    $this->CellFitSpace(106, 5,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 38);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 38);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 43);
    $this->Cell(18, 5, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(30, 43);
    $this->CellFitSpace(80, 5,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',10);
    $this->SetXY(110, 43);
    $this->Cell(30, 5, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(140, 43);
    $this->CellFitSpace(90, 5,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(230, 43);
    $this->CellFitSpace(26, 5,'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(256, 43);
    $this->CellFitSpace(34, 5,utf8_decode($reg[0]['dniencargado']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 43);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 43);
    $this->CellFitSpace(30, 5,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ################################# BLOQUE N° 2 #######################################  

    ################################# BLOQUE N° 3 #######################################   
    //BLOQUE DE DATOS DE SUCURSAL QUE RECIBE

    //DATOS DE SUCURSAL LINEA 5
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 50);
    $this->Cell(330, 4, 'DATOS DE SUCURSAL QUE RECIBE', 0, 0);
    //DATOS DE SUCURSAL LINEA 5

    //DATOS DE SUCURSAL LINEA 6
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 54);
    $this->CellFitSpace(28, 5, 'Nº DE '.$documento = ($reg[0]['documsucursal2'] == '0' ? "REG.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 54);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['cuitsucursal2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(70, 54);
    $this->Cell(30, 5, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(100, 54);
    $this->CellFitSpace(50, 5,utf8_decode($reg[0]['nomsucursal2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(150, 54);
    $this->Cell(24, 5, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(174, 54);
    $this->CellFitSpace(116, 5,utf8_decode($provincia = ($reg[0]['provincia2'] == '' ? "" : $reg[0]['provincia2'])." ".$departamento = ($reg[0]['departamento2'] == '' ? "" : $reg[0]['departamento2'])." ".$reg[0]['direcsucursal2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 54);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 54);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['tlfsucursal2']), 0, 0);
    //DATOS DE SUCURSAL LINEA 6

    //DATOS DE SUCURSAL LINEA 7
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 59);
    $this->Cell(28, 5, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(30, 59);
    $this->CellFitSpace(80, 5,utf8_decode($reg[0]['correosucursal2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(110, 59);
    $this->Cell(30, 5, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(140, 59);
    $this->CellFitSpace(90, 5,utf8_decode($reg[0]['nomencargado2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(230, 59);
    $this->CellFitSpace(26, 5,'Nº DE '.$documento = ($reg[0]['documencargado2'] == '0' ? "DOC.:" : $reg[0]['documento4'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(256, 59);
    $this->CellFitSpace(34, 5,utf8_decode($reg[0]['dniencargado2']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 59);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 59);
    $this->CellFitSpace(30, 5,utf8_decode($tlf = ($reg[0]['tlfencargado2'] == '' ? "*********" : $reg[0]['tlfencargado2'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 7
    ################################# BLOQUE N° 3 #######################################   

    ################################# BLOQUE N° 4 #######################################   
    //Bloque Cuadro de Detalles de Productos
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 68, 335, 93, '0', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(10, 66);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(30,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(18,8,'F.VCTO',1,0,'C', True);
    $this->Cell(76,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(28,8,'MARCA',1,0,'C', True);
    $this->Cell(26,8,'MODELO',1,0,'C', True);
    $this->Cell(15,8,'CANT',1,0,'C', True);
    $this->Cell(15,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'PRECIO UNIT',1,0,'C', True);
    $this->Cell(34,8,'VALOR TOTAL',1,0,'C', True);
    $this->Cell(18,8,'% DCTO',1,0,'C', True);
    $this->Cell(35,8,'VALOR NETO',1,1,'C', True);
    $this->Ln(1);
    ################################# BLOQUE N° 4 ####################################### 

    ################################# BLOQUE N° 5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesTraspasos();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(9,30,18,76,28,26,15,15,30,34,18,34));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantidad'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantidad"];
    $SubTotal += $detalle[$i]['valorneto'];
    $simbolo = $reg[0]['simbolo']." ";

    $this->SetX(11);
    $this->SetFont('Courier','',9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->RowFacture(array($a++,
        utf8_decode($detalle[$i]["codproducto"]),
        utf8_decode($detalle[$i]["fechaexpiracion"] == '0000-00-00' ? "******" : $detalle[$i]["fechaexpiracion"]),
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["nommedida"] == '' ? "*********" : $detalle[$i]["nommedida"]),
        utf8_decode($detalle[$i]["cantidad"]),
        utf8_decode($detalle[$i]["ivaproducto"] == 'SI' ? $reg[0]["iva"]."%" : "(E)"),
        utf8_decode($simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }
    ################################# BLOQUE N° 5 ####################################### 

    ########################### BLOQUE N° 5 DE TOTALES #############################    
    //Bloque de Informacion adicional
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 162, 240, 38, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',14);
    $this->SetXY(115, 164);
    $this->Cell(20, 5, 'INFORMACIÓN ADICIONAL', 0 , 0);
       
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 172);
    $this->Cell(20, 5, 'CANTIDAD DE PRODUCTOS:', 0 , 0);
    $this->SetXY(64, 172);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($cantidad), 0 , 0);
       
    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 178);
    $this->Cell(20, 5, 'TIPO DE DOCUMENTO:', 0 , 0);
    $this->SetXY(64, 178);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode("FACTURA"), 0 , 0);
       
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 184);
    $this->Cell(20, 5, 'OBSERVACIONES:', 0 , 0);
    $this->SetXY(64, 184);
    $this->MultiCell(236,4,$this->SetFont('Courier','',10).utf8_decode($reg[0]['observaciones'] == '' ? "**********" : $reg[0]['observaciones']),0,'J');
    
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(253, 162, 91, 38, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 164);
    $this->CellFitSpace(44, 5, 'SUBTOTAL:', 0, 0);
    $this->SetXY(298, 164);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 168);
    $this->CellFitSpace(44, 5, 'GRAVADO ('.$reg[0]["iva"].'%):', 0, 0);
    $this->SetXY(298, 168);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 172);
    $this->CellFitSpace(44, 5, 'EXENTO (0%):', 0, 0);
    $this->SetXY(298, 172);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 176);
    $this->CellFitSpace(44, 5, 'DESCONTADO %:', 0, 0);
    $this->SetXY(298, 176);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 180);
    $this->CellFitSpace(44, 5, $impuesto == '' ? "TOTAL IMP." : "TOTAL ".$imp[0]['nomimpuesto']." (".$reg[0]["iva"]."%):", 0, 0);
    $this->SetXY(298, 180);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 184);
    $this->CellFitSpace(44, 5, "DESC. GLOBAL (".$reg[0]["descuento"].'%):', 0, 0);
    $this->SetXY(298, 184);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',11);
    $this->SetXY(254, 189);
    $this->CellFitSpace(44, 5, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(298, 189);
    $this->SetFont('courier','B',11);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')), 0, 0, "R"); 
    
}
########################## FUNCION FACTURA TRASPASOS ##############################

########################## FUNCION LISTAR TRASPASOS ##############################
function TablaListarTraspasos()
   {
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarTraspasos();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE TRASPASOS',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TRASPASO',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL ENVIA',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL RECIBE',1,0,'C', True);
    $this->Cell(40,8,'FECHA DE EMISIÓN',1,0,'C', True);
    $this->Cell(30,8,'Nº ARTICULOS',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,45,45,40,30,35,25,25,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;


    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['sumarticulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codtraspaso"]),portales(utf8_decode($reg[$i]["nomsucursal"])),portales(utf8_decode($reg[$i]["nomsucursal2"])),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso']))),utf8_decode($reg[$i]["sumarticulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(180,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TRASPASOS ##############################

########################## FUNCION LISTAR TRASPASOS POR SUCURSAL ##############################
function TablaListarTraspasosxSucursal()
   {
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarTraspasosxSucursal();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE TRASPASOS POR SUCURSAL',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TRASPASO',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL RECIBE',1,0,'C', True);
    $this->Cell(45,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(40,8,'FECHA DE EMISIÓN',1,0,'C', True);
    $this->Cell(30,8,'Nº ARTICULOS',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,45,45,40,30,35,25,25,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;


    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['sumarticulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codtraspaso"]),portales(utf8_decode($reg[$i]["nomsucursal2"])),portales(utf8_decode($reg[$i]['observaciones'] == "" ? "**********" : $reg[$i]['observaciones'])),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso']))),utf8_decode($reg[$i]["sumarticulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(180,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TRASPASOS POR SUCURSAL ##############################

########################## FUNCION LISTAR TRASPASOS POR FECHAS ##############################
function TablaListarTraspasosxFechas()
   {
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarTraspasosxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE TRASPASOS POR FECHAS',0,0,'C');

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE TRASPASO',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL ENVIA',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL RECIBE',1,0,'C', True);
    $this->Cell(40,8,'FECHA DE EMISIÓN',1,0,'C', True);
    $this->Cell(30,8,'Nº ARTICULOS',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,45,45,40,30,35,25,25,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalImpuesto=0;
    $TotalDescuento=0;
    $TotalImporte=0;


    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['sumarticulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalImpuesto+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codtraspaso"]),portales(utf8_decode($reg[$i]["nomsucursal"])),portales(utf8_decode($reg[$i]["nomsucursal2"])),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso']))),utf8_decode($reg[$i]["sumarticulos"]),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(180,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($TotalArticulos),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TRASPASOS POR FECHAS ##############################

####################### FUNCION LISTAR PRODUCTOS TRASPASOS ###########################
function TablaListarProductosTraspasos()
   {

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "Impuesto" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarProductosTraspasos();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL ################################# 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE PRODUCTOS TRASPASADOS POR FECHAS',0,0,'C'); 

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    } 

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(25,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(30,8,'MEDIDA',1,0,'C', True);
    $this->Cell(20,8,'DESC%',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'TRASPASADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,65,30,30,30,20,30,30,25,30));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $PrecioTotal += $reg[$i]['precioventa'];
    $ExisteTotal += $reg[$i]['existencia'];
    $VendidosTotal += $reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

    $PagoTotal += $PrecioFinal*$reg[$i]['cantidad']; 
    $simbolo = $reg[$i]['simbolo']." "; 

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']),
        utf8_decode($reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']),
        utf8_decode($reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']),
        utf8_decode($reg[$i]['descproducto']),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['existencia']),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','))));
       }
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR PRODUCTOS TRASPASOS ##########################

############################### REPORTES DE TRASPASOS ##################################


























############################# REPORTES DE COMPRAS ##################################

########################## FUNCION FACTURA COMPRA ##############################
function FacturaCompra()
    {
        
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ComprasPorId();

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
             
        if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 15, 10, 60, 20, "PNG");

        } elseif (file_exists("./fotos/logo_principal.png")) {

        $logo = "./fotos/logo_principal.png";
        $this->Image($logo, 15, 10, 60, 20, "PNG");

        } else {

        $logo = "./assets/images/null.png";                         
        $this->Image($logo, 15, 10, 60, 20, "PNG");  

        }                                      
    }

    ######################### BLOQUE N° 1 ######################### 
    //BLOQUE DE DATOS DE PRINCIPAL
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 335, 20, '1.5', '');
    
    //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(161, 13, 13, 13, '1.5', 'F');

    //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(161, 13, 13, 13, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(164.5, 14);
    $this->Cell(20, 5, 'C', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(161, 19);
    $this->Cell(20, 5, 'Compra', 0, 0);
    
    $this->SetFont('courier','B',12);
    $this->SetXY(270, 11);
    $this->Cell(42, 5, 'N° DE COMPRA ', 0, 0);
    $this->SetFont('courier','B',12);
    $this->SetXY(312, 11);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['codcompra']), 0, 0, "R");
    
    $this->SetFont('courier','B',10);
    $this->SetXY(270, 15.5);
    $this->Cell(42, 5, 'FECHA DE EMISIÓN ', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 15.5);
    $this->CellFitSpace(30, 5,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechaemision']))), 0, 0, "R");
    
    $this->SetFont('courier','B',10);
    $this->SetXY(270, 19.5);
    $this->Cell(42, 5, 'FECHA DE RECEPCIÓN ', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 19.5);
    $this->CellFitSpace(30, 5,utf8_decode(date("d-m-Y",strtotime($reg[0]['fecharecepcion']))), 0, 0, "R");
    
    $this->SetFont('courier','B',10);
    $this->SetXY(270, 23.5);
    $this->Cell(42, 5, 'ESTADO DE COMPRA', 0, 0);
    $this->SetFont('courier','B',10);
    $this->SetXY(312, 23.5);
    
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
    $this->Cell(30, 5,utf8_decode($reg[0]['statuscompra']), 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->Cell(30, 5,utf8_decode($reg[0]['statuscompra']), 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->Cell(30, 5,utf8_decode("VENCIDA"), 0, 0, "R");
    }
    ######################### BLOQUE N° 1 ######################### 

    ############################## BLOQUE N° 2 #####################################   
    //BLOQUE DE DATOS DE PROVEEDOR
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 32, 335, 32, '1.5', '');

    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 33);
    $this->Cell(330, 5, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 38);
    $this->CellFitSpace(28, 5, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 38);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(70, 38);
    $this->Cell(30, 5, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(100, 38);
    $this->CellFitSpace(60, 5,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(160, 38);
    $this->Cell(24, 5, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(184, 38);
    $this->CellFitSpace(106, 5,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 38);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 38);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 43);
    $this->Cell(18, 5, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(30, 43);
    $this->CellFitSpace(80, 5,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',10);
    $this->SetXY(110, 43);
    $this->Cell(30, 5, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(140, 43);
    $this->CellFitSpace(90, 5,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(230, 43);
    $this->CellFitSpace(26, 5,'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(256, 43);
    $this->CellFitSpace(34, 5,utf8_decode($reg[0]['dniencargado']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(290, 43);
    $this->Cell(22, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 43);
    $this->CellFitSpace(30, 5,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ################################# BLOQUE N° 2 #######################################   

    ################################# BLOQUE N° 3 #######################################   
    //DATOS DE SUCURSAL LINEA 5
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 48);
    $this->Cell(330, 4, 'DATOS DE PROVEEDOR', 0, 0);
    //DATOS DE SUCURSAL LINEA 5

    //DATOS DE SUCURSAL LINEA 6
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 53);
    $this->CellFitSpace(28, 5, 'Nº DE '.$documento = ($reg[0]['documproveedor'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(40, 53);
    $this->CellFitSpace(30, 5,utf8_decode($reg[0]['cuitproveedor']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(70, 53);
    $this->Cell(30, 5, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(100, 53);
    $this->CellFitSpace(84, 5,utf8_decode($reg[0]['nomproveedor']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(184, 53);
    $this->Cell(24, 5, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(208, 53);
    $this->CellFitSpace(134, 5,utf8_decode($departamento = ($reg[0]['departamento2'] == '' ? "" : $reg[0]['departamento2'])." ".$provincia = ($reg[0]['provincia2'] == '' ? "" : $reg[0]['provincia2'])." ".$reg[0]['direcproveedor']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(12, 58);
    $this->Cell(18, 5, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(30, 58);
    $this->CellFitSpace(130, 5,utf8_decode($reg[0]['emailproveedor']), 0, 0);
    //DATOS DE SUCURSAL LINEA 6

    //DATOS DE SUCURSAL LINEA 7
    $this->SetFont('courier','B',10);
    $this->SetXY(160, 58);
    $this->Cell(24, 5, 'N° DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(184, 58);
    $this->CellFitSpace(38, 5,utf8_decode($reg[0]['tlfproveedor']), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(222, 58);
    $this->Cell(28, 5, 'VENDEDOR:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(250, 58);
    $this->CellFitSpace(92, 5,utf8_decode($reg[0]['vendedor']), 0, 0);
    //DATOS DE SUCURSAL LINEA 7
    ################################# BLOQUE N° 3 #######################################   

    ################################# BLOQUE N° 4 #######################################   
    //Bloque Cuadro de Detalles de Productos
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 74, 335, 86, '0', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(10, 66);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(20,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(16,8,'LOTE',1,0,'C', True);
    $this->Cell(23,8,'F.VCTO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MEDIDA',1,0,'C', True);
    $this->Cell(15,8,'CANT',1,0,'C', True);
    $this->Cell(15,8,$impuesto == '' ? "IMPUESTO" : $imp[0]['nomimpuesto'],1,0,'C', True);
    $this->Cell(25,8,'PRECIO UNIT',1,0,'C', True);
    $this->Cell(28,8,'VALOR TOTAL',1,0,'C', True);
    $this->Cell(18,8,'% DCTO',1,0,'C', True);
    $this->Cell(35,8,'VALOR NETO',1,1,'C', True);
    $this->Ln(1);
    ################################# BLOQUE N° 4 ####################################### 

    ################################# BLOQUE N° 5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesCompras();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(9,20,16,23,70,30,30,15,15,25,28,18,34));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantcompra'];
    $valortotal = $detalle[$i]["preciocomprac"]*$detalle[$i]["cantcompra"];
    $SubTotal += $detalle[$i]['valorneto'];
    $simbolo = $reg[0]['simbolo']." ";

    $this->SetX(11);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es BLANCO)
    $this->RowFacture(array($a++,
        utf8_decode($detalle[$i]["codproducto"]),
        utf8_decode($detalle[$i]["lotec"]),
        utf8_decode($detalle[$i]["fechaexpiracionc"] == '0000-00-00' ? "******" : $detalle[$i]["fechaexpiracionc"]),
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["nommedida"] == '' ? "*********" : $detalle[$i]["nommedida"]),
        utf8_decode($detalle[$i]["cantcompra"]),
        utf8_decode($detalle[$i]["ivaproductoc"] == 'SI' ? $reg[0]["ivac"]."%" : "(E)"),
        utf8_decode($simbolo.number_format($detalle[$i]['preciocomprac'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descfactura'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }
    ################################# BLOQUE N° 5 ####################################### 

    ########################### BLOQUE N° 5 DE TOTALES #############################    
    //Bloque de Informacion adicional
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 162, 240, 38, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',14);
    $this->SetXY(115, 163);
    $this->Cell(20, 5, 'INFORMACIÓN ADICIONAL', 0 , 0);
       
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 169);
    $this->Cell(20, 5, 'CANTIDAD DE PRODUCTOS:', 0 , 0);
    $this->SetXY(64, 169);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($cantidad), 0 , 0);
       
    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(120, 169);
    $this->Cell(20, 5, 'TIPO DE DOCUMENTO:', 0 , 0);
    $this->SetXY(168, 169);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode("FACTURA"), 0 , 0);
       
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 174);
    $this->Cell(20, 5, 'TIPO DE PAGO:', 0 , 0);
    $this->SetXY(64, 174);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($reg[0]['tipocompra']), 0 , 0);
       
    if($reg[0]['tipocompra']=="CREDITO"){

   //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(120, 174);
    $this->Cell(20, 5, 'FECHA DE VENCIMIENTO:', 0 , 0);
    $this->SetXY(168, 174);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($vence = ( $reg[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($reg[0]['fechavencecredito'])))), 0 , 0);
        
    //Linea de membrete Nro 6
    $this->SetFont('courier','B',10);
    $this->SetXY(200, 174);
    $this->Cell(20, 5, 'DIAS VENCIDOS:', 0 , 0);
    $this->SetXY(234, 174);
    $this->SetFont('courier','',10);
        
      if($reg[0]['fechavencecredito']== '0000-00-00') { 
        $this->Cell(20, 5,utf8_decode("0"), 0 , 0);
      } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
        $this->Cell(20, 5,utf8_decode("0"), 0 , 0);
      } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
        $this->Cell(20, 5,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])), 0 , 0);
      }
    }
    
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 179);
    $this->Cell(20, 5, 'MÉTODO DE PAGO:', 0 , 0);
    $this->SetXY(64, 179);
    $this->SetFont('courier','',10);
    $this->Cell(20, 5,utf8_decode($reg[0]['formacompra']), 0 , 0);
    
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 184);
    $this->MultiCell(236,4,$this->SetFont('Courier','',10).utf8_decode(numtoletras($reg[0]["totalpagoc"])),0,'J');

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 188);
    $this->MultiCell(236,5,$this->SetFont('Courier','',10).utf8_decode($reg[0]["observaciones"]=="" ? "" : "OBSERVACIONES: ".$reg[0]["observaciones"]),0,'J');

    
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(253, 162, 91, 38, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 164);
    $this->CellFitSpace(44, 5, 'SUBTOTAL:', 0, 0);
    $this->SetXY(298, 164);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 168);
    $this->CellFitSpace(44, 5, 'GRAVADO ('.$reg[0]["ivac"].'%):', 0, 0);
    $this->SetXY(298, 168);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivasic"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 172);
    $this->CellFitSpace(44, 5, 'EXENTO (0%):', 0, 0);
    $this->SetXY(298, 172);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["subtotalivanoc"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 176);
    $this->CellFitSpace(44, 5, $impuesto == '' ? "TOTAL IMP." : "TOTAL ".$imp[0]['nomimpuesto']." (".$reg[0]["ivac"]."%):", 0, 0);
    $this->SetXY(298, 176);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totalivac"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 180);
    $this->CellFitSpace(44, 5, 'DESCONTADO %:', 0, 0);
    $this->SetXY(298, 180);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["descontadoc"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',10);
    $this->SetXY(254, 184);
    $this->CellFitSpace(44, 5, "DESC. GLOBAL (".$reg[0]["descuentoc"].'%):', 0, 0);
    $this->SetXY(298, 184);
    $this->SetFont('courier','',10);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totaldescuentoc"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',11);
    $this->SetXY(254, 189);
    $this->CellFitSpace(44, 5, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(298, 189);
    $this->SetFont('courier','B',11);
    $this->CellFitSpace(46, 5,utf8_decode($simbolo.number_format($reg[0]["totalpagoc"], 2, '.', ',')), 0, 0, "R");   
}
########################## FUNCION FACTURA COMPRA ##############################

########################## FUNCION TICKET COMPRA ##############################
function TicketCreditoCompra()
    {  
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ComprasPorId();
    $simbolo = $reg[0]['simbolo']." ";
  
    $this->SetXY(2,4);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(70,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"TLF Nº: ".utf8_decode($reg[0]['tlfsucursal']), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento'].": ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['departamento']!=''){

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,portales(utf8_decode($departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia']))),0,1,'C');

    }

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,portales(utf8_decode($reg[0]['direcsucursal'])),0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"AMBIENTE: PRODUCCIÓN",0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"EMISIÓN: NORMAL",0,1,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(24,3,"Nº COMPRA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(46,3,portales(utf8_decode($reg[0]['codcompra'])),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(24,3,"FECHA EMISIÓN:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(46,3,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechaemision']))),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(24,3,"FECHA RECEPCIÓN:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(46,3,utf8_decode(date("d-m-Y",strtotime($reg[0]['fecharecepcion']))),0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'----------- PROVEEDOR -----------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15, 3,utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOC.:" : $reg[0]['documento3'].": ")),0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(55, 3,utf8_decode($reg[0]['cuitproveedor']),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"NOMBRE:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(55,3,portales(utf8_decode($reg[0]['nomproveedor'])),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"DIREC.:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(55,3,portales(utf8_decode($reg[0]['direcproveedor'] == '' ? "**********" : $reg[0]['direcproveedor'])),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"Nº TLF:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(55,3,portales(utf8_decode($reg[0]['tlfproveedor'] == '' ? "**********" : $reg[0]['tlfproveedor'])),0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);
  
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es BLANCO 255 GRIS 255)
    $this->Cell(10, 5,"Nº", 0, 0, 'L', True);
    $this->Cell(24, 5,"MÉTODO", 0, 0, 'L', True);
    $this->Cell(19, 5,"MONTO", 0, 0, 'L', True);
    $this->Cell(18, 5,"FECHA", 0, 1, 'L', True);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $tra = new Login();
    $detalle = $tra->VerDetallesAbonosCompras();
    if($detalle==""){

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'NO SE ENCONTRARON ABONOS',0,0,'C');
    $this->Ln(3);

    } else {
    $cantidad=0;

    $this->SetWidths(array(10,24,19,18));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){
    
    $this->SetX(2);
    $this->SetFont('Courier','',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array(
        utf8_decode($a++),
        utf8_decode($detalle[$i]['medioabono']),
        utf8_decode($simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ',')),
        utf8_decode(date("d-m-Y H:i:s",strtotime($detalle[$i]['fechaabono']))))); 
       }
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"IMPORTE TOTAL:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(38,3,utf8_decode($simbolo.number_format($reg[0]["totalpagoc"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"TOTAL ABONADO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(38,3,utf8_decode($simbolo.number_format($reg[0]["creditopagado"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"TOTAL DEBE:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(38,3,utf8_decode($simbolo.number_format($reg[0]["totalpagoc"]-$reg[0]["creditopagado"], 2, '.', ',')),0,1,'R');


    $this->SetFont('Courier','B',10);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"STATUS PAGO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(38,3,utf8_decode($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statuscompra'] == "PENDIENTE" ? "VENCIDA" : $reg[0]["statuscompra"]),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"VENCE CRÉDITO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(38,3,utf8_decode(date("d-m-Y",strtotime($reg[0]["fechavencecredito"]))),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"DIAS VENCIDOS:",0,0,'L');
    $this->SetFont('Courier','',8);

    if($reg[0]['fechavencecredito']== '0000-00-00') { 
        $this->CellFitSpace(38,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
        $this->CellFitSpace(38,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
        $this->CellFitSpace(38,3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])),0,1,'R');
    }

    $this->SetFont('Courier','B',10);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3); 
}
########################## FUNCION TICKET CREDITO COMPRA ##############################

########################## FUNCION LISTAR COMPRAS ##############################
function TablaListarCompras()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarCompras();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE COMPRAS',0,0,'C');

   if($_SESSION['acceso'] == "administradorS"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(30,8,'Nº COMPRA',1,0,'C', True);
    $this->Cell(45,8,'NOMBRE DE PROVEEDOR',1,0,'C', True);
    $this->Cell(30,8,'MÉTODO',1,0,'C', True);
    $this->Cell(25,8,'FECHA EM.',1,0,'C', True);
    $this->Cell(25,8,'FECHA REC.',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,30,45,30,25,25,35,30,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
    $TotalIva+=$reg[$i]['totalivac'];
    $TotalDescuento+=$reg[$i]['totaldescuentoc'];
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomsucursal"])),utf8_decode($reg[$i]["codcompra"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode($reg[$i]["formacompra"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fecharecepcion']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','))));

    }
   
    $this->Cell(210,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº COMPRA',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE PROVEEDOR',1,0,'C', True);
    $this->Cell(40,8,'MÉTODO',1,0,'C', True);
    $this->Cell(25,8,'FECHA EM.',1,0,'C', True);
    $this->Cell(25,8,'FECHA REC.',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,60,40,25,25,40,35,25,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
    $TotalIva+=$reg[$i]['totalivac'];
    $TotalDescuento+=$reg[$i]['totaldescuentoc'];
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode($reg[$i]["formacompra"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fecharecepcion']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','))));
        }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMPRAS ##############################

########################## FUNCION LISTAR CUENTAS POR PAGAR ##############################
function TablaListarCuentasxPagar()
   {
    
    $tra = new Login();
    $reg = $tra->ListarCuentasxPagar();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE CUENTAS POR PAGAR',0,0,'C');

    
   if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(55,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(35,8,'Nº COMPRA',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE PROVEEDOR',1,0,'C', True);
    $this->Cell(30,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'Nº ART.',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,55,35,60,30,20,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){

    $TotalArticulos+=$reg[$i]['articulos']; 
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['creditopagado'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomsucursal"])),utf8_decode($reg[$i]["codcompra"]),utf8_decode($reg[$i]['nomproveedor']),utf8_decode($reg[$i]["statuscompra"]),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ','))));

        }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),1,0,'L');
    $this->Ln();

      }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº COMPRA',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE PROVEEDOR',1,0,'C', True);
    $this->Cell(25,8,'FECHA EM.',1,0,'C', True);
    $this->Cell(25,8,'FECHA REC.',1,0,'C', True);
    $this->Cell(30,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'Nº ART.',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,25,25,30,20,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){

    $TotalArticulos+=$reg[$i]['articulos']; 
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['creditopagado'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),utf8_decode($reg[$i]['nomproveedor']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fecharecepcion']))),utf8_decode($reg[$i]["statuscompra"]),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ','))));

        }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),1,0,'L');
    $this->Ln();
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CUENTAS POR PAGAR ##############################

########################## FUNCION LISTAR COMPRAS POR PROVEEDORES ##############################
function TablaListarComprasxProveedor()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarComprasxProveedor();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE COMPRAS POR PROVEEDOR',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PROVEEDOR: ".utf8_decode($reg[0]["cuitproveedor"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".portales(utf8_decode($reg[0]["nomproveedor"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"Nº TELÉFONO: ".portales(utf8_decode($reg[0]['tlfproveedor'] == '' ? "******" : $reg[0]["tlfproveedor"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº COMPRA',1,0,'C', True);
    $this->Cell(50,8,'MÉTODO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EM.',1,0,'C', True);
    $this->Cell(30,8,'FECHA REC.',1,0,'C', True);
    $this->Cell(45,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(45,8,$impuesto,1,0,'C', True);
    $this->Cell(40,8,'DESC%',1,0,'C', True);
    $this->Cell(45,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,50,30,30,45,45,40,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
    $TotalIva+=$reg[$i]['totalivac'];
    $TotalDescuento+=$reg[$i]['totaldescuentoc'];
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),utf8_decode($reg[$i]["formacompra"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fecharecepcion']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','))));
        }
   
    $this->Cell(160,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMPRAS POR PROVEEDORES ##############################

########################## FUNCION LISTAR COMPRAS POR FECHAS ##############################
function TablaListarComprasxFechas()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarComprasxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE COMPRAS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº COMPRA',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE PROVEEDOR',1,0,'C', True);
    $this->Cell(40,8,'MÉTODO',1,0,'C', True);
    $this->Cell(25,8,'FECHA EM.',1,0,'C', True);
    $this->Cell(25,8,'FECHA REC.',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,60,40,25,25,40,35,25,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
    $TotalIva+=$reg[$i]['totalivac'];
    $TotalDescuento+=$reg[$i]['totaldescuentoc'];
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode($reg[$i]["formacompra"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fecharecepcion']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalivac'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','))));
        }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMPRAS POR FECHAS ##############################

########################## FUNCION LISTAR CREDITOS COMPRAS POR PROVEEDOR ##############################
function TablaListarCreditosxProveedor()
   {
    
    $tra = new Login();
    $reg = $tra->BuscarCreditosxProveedor();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE CRÉDITOS DE COMPRAS POR PROVEEDOR',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PROVEEDOR: ".utf8_decode($reg[0]["cuitproveedor"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".portales(utf8_decode($reg[0]["nomproveedor"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº COMPRA',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE PROVEEDOR',1,0,'C', True);
    $this->Cell(25,8,'FECHA EM.',1,0,'C', True);
    $this->Cell(25,8,'FECHA REC.',1,0,'C', True);
    $this->Cell(30,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'Nº ART.',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,25,25,30,20,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){

    $TotalArticulos+=$reg[$i]['articulos']; 
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['creditopagado'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),utf8_decode($reg[$i]['nomproveedor']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fecharecepcion']))),utf8_decode($reg[$i]["statuscompra"]),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ','))));

        }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),1,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS COMPRAS POR PROVEEDOR ##############################

########################## FUNCION LISTAR CREDITOS COMPRAS POR FECHAS ##############################
function TablaListarCreditosComprasxFechas()
   {
    
    $tra = new Login();
    $reg = $tra->BuscarCreditosComprasxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE CRÉDITOS DE COMPRAS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº COMPRA',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE PROVEEDOR',1,0,'C', True);
    $this->Cell(25,8,'FECHA EM.',1,0,'C', True);
    $this->Cell(25,8,'FECHA REC.',1,0,'C', True);
    $this->Cell(30,8,'STATUS',1,0,'C', True);
    $this->Cell(20,8,'Nº ART.',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,25,25,30,20,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){

    $TotalArticulos+=$reg[$i]['articulos']; 
    $TotalImporte+=$reg[$i]['totalpagoc'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['creditopagado'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcompra"]),utf8_decode($reg[$i]['nomproveedor']),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fecharecepcion']))),utf8_decode($reg[$i]["statuscompra"]),utf8_decode($reg[$i]["articulos"]),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ','))));

        }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode($TotalArticulos),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),1,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),1,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS COMPRAS POR FECHAS ##############################

############################# REPORTES DE COMPRAS ##################################
































################################### REPORTES DE COTIZACIONES ##################################

########################## FUNCION FACTURA COTIZACION ##############################
function FacturaCotizacion()
    {  
   
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->CotizacionesPorId();
  
    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
             
        if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 12, 11, 55, 15, "PNG");

        } elseif (file_exists("./fotos/logo_principal.png")) {

        $logo = "./fotos/logo_principal.png";
        $this->Image($logo, 12, 11, 55, 15, "PNG");

        } else {

        $logo = "./assets/images/null.png";                         
        $this->Image($logo, 12, 11, 55, 15, "PNG");  

        }                                      
    }

    ############################ BLOQUE N° 1 FACTURA ###################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
    
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', 'F');

    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'C', 0 , 0);
    $this->SetFont('courier','B',8);
    $this->SetXY(98, 19);
    $this->Cell(20, 5, 'Cotiz.', 0, 0);
    
    $this->SetFont('courier','B',11);
    $this->SetXY(124, 12);
    $this->Cell(34, 5, 'N° DE COTIZACIÓN', 0, 0);
    $this->SetFont('courier','B',11);
    $this->SetXY(158, 12);
    $this->CellFitSpace(40, 5,utf8_decode($reg[0]['codcotizacion']), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 17);
    $this->Cell(34, 4, 'FECHA DE COTIZACIÓN ', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(158, 17);
    $this->Cell(40, 4,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechacotizacion']))), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 21);
    $this->Cell(34, 4, 'FECHA DE EMISIÓN', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(158, 21);
    $this->Cell(40, 4,utf8_decode(date("d-m-Y H:i:s")), 0, 0, "R");
    ############################## BLOQUE N° 1 FACTURA ###############################

    ############################### BLOQUE N° 2 SUCURSAL ##############################   
   //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 28, 190, 18, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',9);
    $this->SetXY(11, 29);
    $this->Cell(186, 4, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 33);
    $this->Cell(25, 4, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 33);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 33);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 33);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 33);
    $this->Cell(18, 4, 'TELÉFONO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 33);
    $this->Cell(28, 4,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 37);
    $this->Cell(25, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 37);
    $this->CellFitSpace(82, 4,utf8_decode($departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(118, 37);
    $this->Cell(34, 4, 'CORREO ELECTRÓNICO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(152, 37);
    $this->Cell(46, 4,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 41);
    $this->Cell(25, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 41);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 41);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 41);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['dniencargado']), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ############################### BLOQUE N° 2 SUCURSAL ###############################

    ################################# BLOQUE N° 3 PACIENTE ################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 47, 190, 14, '1.5', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(11, 48);
    $this->Cell(186, 4, 'DATOS DE PACIENTE ', 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 52);
    $this->Cell(21, 4, 'SEÑOR(A):', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 52);
    $this->CellFitSpace(70, 4,utf8_decode($nombre = ($reg[0]['nompaciente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nompaciente']." ".$reg[0]['apepaciente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 52);
    $this->CellFitSpace(20, 4, 'Nº DE '.$documento = ($reg[0]['documpaciente'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(122, 52);
    $this->CellFitSpace(22, 4,utf8_decode($nombre = ($reg[0]['cedpaciente'] == '' ? "*********" : $reg[0]['cedpaciente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 52);
    $this->Cell(24, 4, 'TELÉFONO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 52);
    $this->CellFitSpace(30, 4,utf8_decode($email = ($reg[0]['tlfpaciente'] == '' ? "*********" : $reg[0]['tlfpaciente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 56);
    $this->Cell(21, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 56);
    $this->CellFitSpace(112, 4,getSubString(utf8_decode($departamento = ($reg[0]['departamento2'] == '' ? "" : $reg[0]['departamento2'])." ".$provincia = ($reg[0]['provincia2'] == '' ? "" : $reg[0]['provincia2'])." ".$reg[0]['direcpaciente']), 70), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 56);
    $this->Cell(24, 4, 'ESTADO CIVIL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 56);
    $this->CellFitSpace(30, 4,utf8_decode($tlf = ($reg[0]['estadopaciente'] == '' ? "*********" : $reg[0]['estadopaciente'])), 0, 0); 
    ################################# BLOQUE N° 3 PACIENTE ################################  

    ################################# BLOQUE N° 4 ESPECIALISTA ################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 62, 190, 14, '1.5', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(11, 63);
    $this->Cell(186, 4, 'DATOS DE ESPECIALISTA ', 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 67);
    $this->Cell(21, 4, 'SEÑOR(A):', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 67);
    $this->CellFitSpace(70, 4,utf8_decode($nombre = ($reg[0]['nomespecialista'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomespecialista'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 67);
    $this->CellFitSpace(20, 4, 'Nº DE '.$documento = ($reg[0]['documespecialista'] == '0' ? "DOC.:" : $reg[0]['documento4'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(122, 67);
    $this->CellFitSpace(22, 4,utf8_decode($nombre = ($reg[0]['cedespecialista'] == '' ? "*********" : $reg[0]['cedespecialista'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 67);
    $this->Cell(24, 4, 'TELÉFONO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 67);
    $this->CellFitSpace(30, 4,utf8_decode($email = ($reg[0]['tlfespecialista'] == '' ? "*********" : $reg[0]['tlfespecialista'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 71);
    $this->Cell(21, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 71);
    $this->CellFitSpace(112, 4,getSubString(utf8_decode($departamento = ($reg[0]['departamento3'] == '' ? "" : $reg[0]['departamento3'])." ".$provincia = ($reg[0]['provincia3'] == '' ? "" : $reg[0]['provincia3'])." ".$reg[0]['direcespecialista']), 70), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 71);
    $this->Cell(24, 4, 'ESPECIALIDAD:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 71);
    $this->CellFitSpace(30, 4,utf8_decode($tlf = ($reg[0]['especialidad'] == '' ? "*********" : $reg[0]['especialidad'])), 0, 0);
    ################################# BLOQUE N° 3 ESPECIALISTA ################################   

    ################################# BLOQUE N° 4 #######################################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 78, 190, 170, '0', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(10, 77);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(8, 6,"Nº", 1, 0, 'C', True);
    $this->Cell(40, 6,"DETALLE", 1, 0, 'C', True);
    $this->Cell(22, 6,"MARCA", 1, 0, 'C', True);
    $this->Cell(22, 6,"U/MEDIDA", 1, 0, 'C', True);
    $this->Cell(10, 6,"CANT", 1, 0, 'C', True);
    $this->Cell(23, 6,"P/UNIT", 1, 0, 'C', True);
    $this->Cell(24, 6,"V/TOTAL", 1, 0, 'C', True);
    $this->Cell(15, 6,"% DCTO", 1, 0, 'C', True);
    $this->Cell(26, 6,"V/NETO", 1, 1, 'C', True);
    $this->Ln(1);
    ################################# BLOQUE N° 4 ####################################### 

    ################################# BLOQUE N° 5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesCotizaciones();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(7,40,22,22,10,23,24,15,25));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];
    $simbolo = $reg[0]['simbolo']." ";

    $this->SetX(11);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es BLANCO)
    $this->RowFacture(array($a++,
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["nommarca"] == '' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["nommedida"] == '' ? "******" : $detalle[$i]["nommedida"]),
        utf8_decode($detalle[$i]["cantventa"]),
        utf8_decode($simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }
    ################################# BLOQUE N° 5 ####################################### 

    ########################### BLOQUE N° 7 #############################    
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 250, 108, 26, '1.5', '');

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 250);
    $this->Cell(105, 4, 'INFORMACIÓN ADICIONAL', 0, 0, 'C');
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 254);
    $this->Cell(33, 3, 'CANTIDAD PRODUCTOS:', 0, 0);
    $this->SetXY(44, 254);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(15, 3,utf8_decode($cantidad), 0, 0);
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(59, 254);
    $this->Cell(28, 3, 'TIPO DOCUMENTO:', 0, 0);
    $this->SetXY(87, 254);
    $this->SetFont('courier','',7.5);
    $this->Cell(30, 3,"FACTURA", 0, 0);

    if($_SESSION['acceso'] == "especialista") {

    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 257);
    $this->Cell(33, 3, 'ESPECIALISTA:', 0, 0);
    $this->SetXY(44, 257);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(73, 3,utf8_decode($reg[0]['nomespecialista']." (".$reg[0]['especialidad'].")"), 0, 0); 

    } else { 

    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 257);
    $this->Cell(33, 3, 'NOMBRE DE CAJERO:', 0, 0);
    $this->SetXY(44, 257);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(73, 3,utf8_decode($reg[0]['nombres']), 0, 0);
    
    }

    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 260);
    $this->MultiCell(106,4,$this->SetFont('Courier','',7).utf8_decode(numtoletras($reg[0]['totalpago'])), 0,'J');

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 264);
    $this->MultiCell(106,3,$this->SetFont('Courier','',7.5).utf8_decode($reg[0]["observaciones"]=="" ? "" : "OBSERVACIONES: ".$reg[0]["observaciones"]), 0,'J');


    ########################### BLOQUE N° 7 #############################  

    ################################# BLOQUE N° 8 #######################################  
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(120, 250, 80, 26, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 252);
    $this->CellFitSpace(38, 3, 'SUBTOTAL:', 0, 0);
    $this->SetXY(158, 252);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 255);
    $this->CellFitSpace(38, 3, 'GRAVADO ('.$reg[0]["iva"].'%):', 0, 0);
    $this->SetXY(158, 255);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 258);
    $this->CellFitSpace(38, 3, 'EXENTO (0%):', 0, 0);
    $this->SetXY(158, 258);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 261);
    $this->CellFitSpace(38, 3,$impuesto == '' ? "TOTAL IMP." : "TOTAL ".$imp[0]['nomimpuesto']." (".$reg[0]["iva"]."%):", 0, 0);
    $this->SetXY(158, 261);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 264);
    $this->CellFitSpace(38, 3, 'DESCONTADO %:', 0, 0);
    $this->SetXY(158, 264);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 267);
    $this->CellFitSpace(38, 3, "DESC. GLOBAL (".$reg[0]["descuento"].'%):', 0, 0);
    $this->SetXY(158, 267);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',10);
    $this->SetXY(120, 271);
    $this->CellFitSpace(38, 3, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(158, 271);
    $this->SetFont('courier','B',9);
    $this->CellFitSpace(42, 4,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')), 0, 0, "R");
    ################################# BLOQUE N° 8 #######################################  

}
########################## FUNCION FACTURA COTIZACION ##############################

########################## FUNCION LISTAR COTIZACIONES ##############################
function TablaListarCotizaciones()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarCotizaciones();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE COTIZACIONES',0,0,'C');

   if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(35,8,'Nº COTIZACIÓN',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(25,8,'FECHA EM.',1,0,'C', True);
    $this->Cell(30,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(20,8,'DESC%',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,45,35,50,50,25,30,30,20,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomsucursal"])),utf8_decode($reg[$i]["codcotizacion"]),portales(utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")")),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº COTIZACIÓN',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(65,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,65,30,35,35,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcotizacion"]),portales(utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")")),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(205,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COTIZACIONES ##############################

########################## FUNCION LISTAR COTIZACIONES POR FECHAS ##############################
function TablaListarCotizacionesxFechas()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarCotizacionesxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE COTIZACIONES POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº COTIZACIÓN',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(65,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,65,30,35,35,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcotizacion"]),portales(utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")")),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(205,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COTIZACIONES POR FECHAS ##############################

########################## FUNCION LISTAR COTIZACIONES POR ESPECIALISTA ##############################
function TablaListarCotizacionesxEspecialista()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarCotizacionesxEspecialista();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE COTIZACIONES POR ESPECIALISTA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[0]['documento4']))." ESPECIALISTA: ".utf8_decode($reg[0]["cedespecialista"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESPECIALISTA: ".portales(utf8_decode($reg[0]['nomespecialista'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESPECIALIDAD: ".portales(utf8_decode($reg[0]['especialidad'])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE COTIZACIÓN',1,0,'C', True);
    $this->Cell(80,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(40,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(40,8,$impuesto,1,0,'C', True);
    $this->Cell(40,8,'DESC%',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,80,40,40,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcotizacion"]),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(175,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COTIZACIONES POR ESPECIALISTA ##############################

########################## FUNCION LISTAR COTIZACIONES POR PACIENTE ##############################
function TablaListarCotizacionesxPaciente()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarCotizacionesxPaciente();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE COTIZACIONES POR PACIENTE',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PACIENTE: ".utf8_decode($reg[0]["cedpaciente"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PACIENTE: ".portales(utf8_decode($reg[0]['nompaciente']." ".$reg[0]['apepaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"GRUPO SANG: ".portales(utf8_decode($reg[0]['gruposapaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"Nº DE TELÉFONO: ".portales(utf8_decode($reg[0]['tlfpaciente'] == '' ? "********" : $reg[0]['tlfpaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"FECHA NACIMIENTO: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : date("d-m-Y",strtotime($reg[0]['fnacpaciente'])))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"EDAD: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : edad($reg[0]['fnacpaciente']))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESTADO CIVIL: ".portales(utf8_decode($reg[0]['estadopaciente'] == '' ? "********" : $reg[0]['estadopaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"OCUPACIÓN: ".portales(utf8_decode($reg[0]['ocupacionpaciente'] == '' ? "********" : $reg[0]['ocupacionpaciente'])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'Nº DE COTIZACIÓN',1,0,'C', True);
    $this->Cell(80,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(40,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(40,8,$impuesto,1,0,'C', True);
    $this->Cell(40,8,'DESC%',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,80,40,40,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcotizacion"]),portales(utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")")),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(175,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COTIZACIONES POR PACIENTE ##############################

####################### FUNCION LISTAR PRODUCTOS COTIZADOS ###########################
function TablaListarProductosCotizados()
   {

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarProductosCotizados();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL ################################# 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE PRODUCTOS COTIZADOS POR FECHAS',0,0,'C'); 

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    } 

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(25,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(30,8,'MEDIDA',1,0,'C', True);
    $this->Cell(20,8,'DESC%',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'COTIZADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,65,30,30,30,20,30,30,25,30));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $PrecioTotal += $reg[$i]['precioventa'];
    $ExisteTotal += $reg[$i]['existencia'];
    $VendidosTotal += $reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

    $PagoTotal += $PrecioFinal*$reg[$i]['cantidad']; 
    $simbolo = $reg[$i]['simbolo']." "; 

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']),
        utf8_decode($reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']),
        utf8_decode($reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']),
        utf8_decode($reg[$i]['descproducto']),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['tipodetalle'] == '1' ? "**********" : $reg[$i]['existencia']),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','))));
       }
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR PRODUCTOS COTIZADOS ##########################

####################### FUNCION LISTAR PRODUCTOS COTIZADOS POR VENDEDOR ###########################
function TablaListarCotizadosxVendedor()
   {

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarCotizacionesxVendedor();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL ################################# 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE PRODUCTOS COTIZADOS POR VENDEDOR',0,0,'C'); 

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    } 

    $this->Ln();
    $this->Cell(190,6,"VENDEDOR: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(25,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACIÓN',1,0,'C', True);
    $this->Cell(30,8,'MEDIDA',1,0,'C', True);
    $this->Cell(20,8,'DESC%',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'COTIZADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,65,30,30,30,20,30,30,25,30));

    $PrecioTotal=0;
    $ExisteTotal=0;
    $VendidosTotal=0;
    $PagoTotal=0;
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $PrecioTotal += $reg[$i]['precioventa'];
    $ExisteTotal += $reg[$i]['existencia'];
    $VendidosTotal += $reg[$i]['cantidad']; 

    $Descuento = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

    $PagoTotal += $PrecioFinal*$reg[$i]['cantidad']; 
    $simbolo = $reg[$i]['simbolo']." "; 

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']),
        utf8_decode($reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']),
        utf8_decode($reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']),
        utf8_decode($reg[$i]['descproducto']),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode($reg[$i]['tipodetalle'] == '1' ? "**********" : $reg[$i]['existencia']),
        utf8_decode($reg[$i]['cantidad']),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','))));
       }
   }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($ExisteTotal),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($VendidosTotal),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
   

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR PRODUCTOS COTIZADOS POR VENDEDOR ##########################

################################### REPORTES DE COTIZACIONES ##################################




























############################# REPORTES DE CITAS ##################################

########################## FUNCION LISTAR CITAS ##############################
function TablaListarCitas()
   {
    
    $tra = new Login();
    $reg = $tra->ListarCitas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE CITAS ODONTOLOGICAS',0,0,'C');

    
if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(40,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCIÓN DE CITA',1,0,'C', True);
    $this->Cell(25,8,'FECHA CITA',1,0,'C', True);
    $this->Cell(25,8,'HORA CITA.',1,0,'C', True);
    $this->Cell(30,8,'FECHA INGRESO',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(50,8,'REGISTRADO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,50,40,50,25,25,30,20,50));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomsucursal"])),portales(utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")")),portales(utf8_decode($reg[$i]['cedpaciente']." : ".$reg[$i]['pacientes'])),portales(utf8_decode($reg[$i]['descripcion'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacita']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechacita']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['ingresocita']))),utf8_decode($reg[$i]['statuscita']),utf8_decode($nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']))));

        }
    }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CITA',1,0,'C', True);
    $this->Cell(25,8,'FECHA CITA',1,0,'C', True);
    $this->Cell(25,8,'HORA CITA.',1,0,'C', True);
    $this->Cell(30,8,'FECHA INGRESO',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(50,8,'REGISTRADO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,55,55,60,25,25,30,20,50));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")")),portales(utf8_decode($reg[$i]['cedpaciente']." : ".$reg[$i]['pacientes'])),portales(utf8_decode($reg[$i]['descripcion'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacita']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechacita']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['ingresocita']))),utf8_decode($reg[$i]['statuscita']),utf8_decode($nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']))));
    }

      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CITAS ##############################

########################## FUNCION LISTAR CITAS POR FECHAS ##############################
function TablaListarCitasxFechas()
   {
    
    $tra = new Login();
    $reg = $tra->BusquedaCitasxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE CITAS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CITA',1,0,'C', True);
    $this->Cell(25,8,'FECHA CITA',1,0,'C', True);
    $this->Cell(25,8,'HORA CITA.',1,0,'C', True);
    $this->Cell(30,8,'FECHA INGRESO',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(50,8,'REGISTRADO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,55,55,60,25,25,30,20,50));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")")),portales(utf8_decode($reg[$i]['cedpaciente']." : ".$reg[$i]['pacientes'])),portales(utf8_decode($reg[$i]['descripcion'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacita']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechacita']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['ingresocita']))),utf8_decode($reg[$i]['statuscita']),utf8_decode($nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']))));
        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CITAS POR FECHAS ##############################

########################## FUNCION LISTAR CITAS POR ESPECIALISTA ##############################
function TablaListarCitasxEspecialista()
   {
    
    $tra = new Login();
    $reg = $tra->BusquedaCitasxEspecialistas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE CITAS POR ESPECIALISTA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento3'])." ESPECIALISTA: ".utf8_decode($reg[0]["cedespecialista"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESPECIALISTA: ".portales(utf8_decode($reg[0]["nomespecialista"]." (".$reg[0]['especialidad'].")")),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DOCUMENTO',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCIÓN DE CITA',1,0,'C', True);
    $this->Cell(25,8,'FECHA CITA',1,0,'C', True);
    $this->Cell(25,8,'HORA CITA.',1,0,'C', True);
    $this->Cell(30,8,'FECHA INGRESO',1,0,'C', True);
    $this->Cell(20,8,'STATUS',1,0,'C', True);
    $this->Cell(50,8,'REGISTRADO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,70,65,25,25,30,20,50));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]['cedpaciente'])),portales(utf8_decode($reg[$i]['pacientes'])),portales(utf8_decode($reg[$i]['descripcion'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacita']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechacita']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['ingresocita']))),utf8_decode($reg[$i]['statuscita']),utf8_decode($nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']))));
        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CITAS POR ESPECIALISTA ##############################

########################## FUNCION LISTAR CITAS POR PACIENTE ##############################
function TablaListarCitasxPaciente()
   {
    
    $tra = new Login();
    $reg = $tra->BuscarCitasxPaciente();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'CITAS ODONTOLÓGICAS DEL PACIENTE',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento4']))." PACIENTE: ".utf8_decode($reg[0]["cedpaciente"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PACIENTE: ".portales(utf8_decode($reg[0]['pacientes'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"GRUPO SANG: ".portales(utf8_decode($reg[0]['gruposapaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"Nº DE TELÉFONO: ".portales(utf8_decode($reg[0]['tlfpaciente'] == '' ? "********" : $reg[0]['tlfpaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"FECHA NACIMIENTO: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : date("d-m-Y",strtotime($reg[0]['fnacpaciente'])))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"EDAD: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : edad($reg[0]['fnacpaciente']))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESTADO CIVIL: ".portales(utf8_decode($reg[0]['estadopaciente'] == '' ? "********" : $reg[0]['estadopaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"OCUPACIÓN: ".portales(utf8_decode($reg[0]['ocupacionpaciente'] == '' ? "********" : $reg[0]['ocupacionpaciente'])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(80,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN DE CITA',1,0,'C', True);
    $this->Cell(25,8,'FECHA CITA',1,0,'C', True);
    $this->Cell(25,8,'HORA CITA.',1,0,'C', True);
    $this->Cell(30,8,'FECHA INGRESO',1,0,'C', True);
    $this->Cell(30,8,'STATUS',1,0,'C', True);
    $this->Cell(70,8,'REGISTRADO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,80,60,25,25,30,30,70));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")")),portales(utf8_decode($reg[$i]['descripcion'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechacita']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechacita']))),utf8_decode(date("d-m-Y",strtotime($reg[$i]['ingresocita']))),utf8_decode($reg[$i]['statuscita']),utf8_decode($nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']))));
        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CITAS POR PACIENTE ##############################

############################# REPORTES DE CITAS ##################################



























########################### REPORTES DE CAJAS DE VENTAS ##############################

########################## FUNCION LISTAR CAJAS ##############################
function TablaListarCajas()
   {

    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE CAJAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE CAJA',1,0,'C', True);
    $this->Cell(55,8,'RESPONSABLE DE CAJA',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarCajas();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,50,55,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"]),utf8_decode($reg[$i]['nomcaja']),utf8_decode($reg[$i]["nombres"]),portales(utf8_decode($reg[$i]["nomsucursal"]))));
       }
      }
    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(35,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE CAJA',1,0,'C', True);
    $this->Cell(90,8,'RESPONSABLE DE CAJA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarCajas();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,55,90));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"]),utf8_decode($reg[$i]['nomcaja']),utf8_decode($reg[$i]["nombres"])));
        }
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
     }
########################## FUNCION LISTAR CAJAS ##############################

########################## FUNCION TICKET CIERRE ARQUEO (TICKET) ##############################
function TicketCierre()
{  
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ArqueoCajaPorId();
    $simbolo = $reg[0]['simbolo']." ";
  
    $this->SetXY(2,5);
    $this->SetFont('Courier','B',12);
    $this->SetFillColor(2,157,116);
    $this->Cell(68, 5, "CIERRE DE CAJA", 0, 0, 'C');
    $this->Ln(6);
  
    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(68,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(68,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento']." ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['departamento']!=''){

    $this->SetX(2);
    $this->CellFitSpace(68,3,portales(utf8_decode($departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia']))),0,1,'C');

    }

    $this->SetX(2);
    $this->CellFitSpace(68,3,portales(utf8_decode($reg[0]['direcsucursal'])),0,1,'C');

    $this->SetX(2);
    $this->CellFitSpace(68,3,"OBLIGADO A LLEVAR CONTABILIDAD: ".utf8_decode($reg[0]['llevacontabilidad']),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(68,3,"AMBIENTE: PRODUCCIÓN",0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(68,3,"EMISIÓN: NORMAL",0,1,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(24,3.5,"CAJA Nº:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(46,3.5,utf8_decode($reg[0]['nrocaja']."-".$reg[0]['nomcaja']),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(24,3.5,"CAJERO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(46,3.5,utf8_decode($reg[0]['nombres']),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(24,3.5,"FECHA EMISIÓN:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(46,3.5,date("d-m-Y H:i:s"),0,1,'L');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3.5,"HORA APERTURA:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(44,3.5,utf8_decode(date("d-m-Y H:i:s",strtotime($reg[0]['fechaapertura']))),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3.5,"HORA CIERRE:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(44,3.5,utf8_decode(date("d-m-Y H:i:s",strtotime($reg[0]['fechacierre']))),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(26,3.5,"MONTO APERTURA:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(44,3.5,utf8_decode($simbolo.number_format($reg[0]["montoinicial"], 2, '.', ',')),0,1,'L');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"EFECTIVO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["efectivo"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"CHEQUE:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["cheque"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"TARJ. CRÉDITO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["tcredito"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"TARJ. DÉBITO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["tdebito"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"TARJ. PREPAGO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["tprepago"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"TRANSFERENCIA:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["transferencia"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"DINERO ELECTRÓNICO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["electronico"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"CUPÓN:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["cupon"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"OTROS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["otros"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"CRÉDITOS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["creditos"], 2, '.', ',')),0,1,'R');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"ABONOS EFECTIVO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["abonosefectivo"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3.5,"ABONOS OTROS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3.5,utf8_decode($simbolo.number_format($reg[0]["abonosotros"], 2, '.', ',')),0,1,'R');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"INGRESO EFECTIVO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode($simbolo.number_format($reg[0]["ingresosefectivo"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"INGRESOS OTROS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode($simbolo.number_format($reg[0]["ingresosotros"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"EGRESOS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["egresos"], 2, '.', ',')),0,1,'R');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $TotalVentas = $reg[0]['efectivo']+$reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros'];

    $VentaOtros = $reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros'];

    $TotalEfectivo = $reg[0]['montoinicial']+$reg[0]['efectivo']+$reg[0]['ingresosefectivo']+$reg[0]['abonosefectivo']-$reg[0]['egresos'];

    $TotalOtros = $reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros']+$reg[0]['abonosotros']+$reg[0]['ingresosotros'];


    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"TOTAL EN VENTAS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode($simbolo.number_format($TotalVentas, 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"VENTAS EN EFECTIVO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode($simbolo.number_format($reg[0]['efectivo'], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"VENTAS OTROS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode($simbolo.number_format($VentaOtros, 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"TOTAL EN EFECTIVO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode($simbolo.number_format($TotalEfectivo, 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"TOTAL OTROS:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode($simbolo.number_format($TotalOtros, 2, '.', ',')),0,1,'R');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"EFECTIVO EN CAJA:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode($simbolo.number_format($reg[0]["dineroefectivo"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(30,3,"DIF. EFECTIVO:",0,0,'L');
    $this->SetFont('Courier',"",8);
    $this->CellFitSpace(40,3,utf8_decode($simbolo.number_format($reg[0]["diferencia"], 2, '.', ',')),0,1,'R');
    $this->Ln(1);

    if($reg[0]["comentarios"]==""){

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

   } else { 

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->MultiCell(70,4,$this->SetFont('Courier',"",7).utf8_decode($reg[0]["comentarios"]),0,'L');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

    }
 
    $this->SetFont('Courier','BI',9);
    $this->SetX(4);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(66,3,"GRACIAS POR SU ATENCIÓN",0,1,'C');
    $this->Ln(3);

}
########################## FUNCION TICKET CIERRE ARQUEO (TICKET) ##############################

########################## FUNCION TICKET CIERRE ARQUEO (A5) ##############################
function TicketCierre2()
   {
    //Bloque de membrete principal
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(7, 6, 196, 27, '1.5', '');

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ArqueoCajaPorId();

    $this->SetXY(8,8);
    $this->SetFont('Courier','B',14);
    $this->CellFitSpace(190,4,portales(utf8_decode($reg[0]['nomsucursal'])), 0, 1, 'J');

    $this->SetX(8);
    $this->SetFont('Courier','',12);
    $this->CellFitSpace(190,4,portales(utf8_decode($reg[0]['nomencargado'])), 0, 1, 'J');

    $this->SetX(8);
    $this->SetFont('Courier','',12);
    $this->CellFitSpace(190,4,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento'].": ".utf8_decode($reg[0]['cuitsucursal']),0,1,'J');

    $this->SetX(8);
    $this->SetFont('Courier','',12);
    $this->CellFitSpace(190,4,"Nº TLF: ".utf8_decode($reg[0]['tlfsucursal']),0,1,'J');

    if($reg[0]['departamento']!=''){

    $this->SetX(8);
    $this->CellFitSpace(190,4,portales(utf8_decode($departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia']))),0,1,'J');

    }

    $this->SetX(8);
    $this->SetFont('Courier','',12);
    $this->CellFitSpace(190,4,portales(utf8_decode($reg[0]['direcsucursal'])),0,1,'J');
    $this->Ln(3);

    ####################### DATOS DE CAJERO #######################

    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(7, 34, 196, 18, '1.5', '');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(190,4,"DATOS DE CAJERO",0,1,'L');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"CAJA Nº:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode($reg[0]['nrocaja']."-".$reg[0]['nomcaja']),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"HORA APERTURA:",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->CellFitSpace(60,4,utf8_decode(date("d-m-Y H:i:s",strtotime($reg[0]['fechaapertura']))),0,1,'L');
    
    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"CAJERO:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode($reg[0]['nombres']),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"HORA CIERRE:",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->CellFitSpace(60,4,utf8_decode(date("d-m-Y H:i:s",strtotime($reg[0]['fechacierre']))),0,1,'L');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"FECHA EMISIÓN:",0,0,'L');
    $this->SetFont('Courier','',12);
    $this->CellFitSpace(60,4,date("d-m-Y H:i:s"),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"MONTO APERTURA:",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["montoinicial"], 2, '.', ',')),0,1,'L');
    $this->Ln(2);

    ####################### DATOS DE CAJERO #######################


    ####################### DATOS DE VENTAS #######################

    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(7, 53, 196, 25, '1.5', '');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(190,4,"DETALLE DE FACTURACIONES",0,1,'L');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"EFECTIVO:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["efectivo"], 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"CHEQUE:",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["cheque"], 2, '.', ',')),0,1,'L');
    
    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"TARJ. CRÉDITO:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["tcredito"], 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"TARJ. DÉBITO:",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["tdebito"], 2, '.', ',')),0,1,'L');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"TARJ. PREPAGO:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["tprepago"], 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->Cell(35,4,"TRANSFERENCIA",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->Cell(60,4,utf8_decode(number_format($reg[0]["tprepago"], 2, '.', ',')),0,1,'L');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"DIN ELECTRÓNICO:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["electronico"], 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->Cell(35,4,"CUPÓN",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->Cell(60,4,utf8_decode(number_format($reg[0]["cupon"], 2, '.', ',')),0,1,'L');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"OTROS:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["otros"], 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->Cell(35,4,"CRÉDITOS",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->Cell(60,4,utf8_decode(number_format($reg[0]["creditos"], 2, '.', ',')),0,1,'L');
    $this->Ln(2);

    ####################### DATOS DE VENTAS #######################

    ####################### DATOS DE VENTAS #######################

    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(7, 79, 196, 17, '1.5', '');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(190,4,"MOVIMIENTOS Y ABONOS",0,1,'L');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"ABONOS EFECTIVO:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["abonosefectivo"], 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"ABONOS OTROS:",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["abonosotros"], 2, '.', ',')),0,1,'L');
    
    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"INGRESOS EFECTIVO:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["ingresosefectivo"], 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"INGRESOS OTROS:",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["ingresosotros"], 2, '.', ',')),0,1,'L');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"EGRESOS:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["egresos"], 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->Cell(35,4,"",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->Cell(60,4,"",0,1,'L');
    $this->Ln(2);

    ####################### DATOS DE VENTAS #######################


    ####################### DATOS DE CIERRE #######################

    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(7, 97, 196, 40, '1.5', '');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(190,4,"BALANCE EN CAJA",0,1,'L');

    $TotalVentas = $reg[0]['efectivo']+$reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros'];

    $VentaOtros = $reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros'];

    $TotalEfectivo = $reg[0]['montoinicial']+$reg[0]['efectivo']+$reg[0]['ingresosefectivo']+$reg[0]['abonosefectivo']-$reg[0]['egresos'];

    $TotalOtros = $reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros']+$reg[0]['abonosotros']+$reg[0]['ingresosotros'];

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"TOTAL VENTAS:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($TotalVentas, 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"VENTAS EFECTIVO:",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]['efectivo'], 2, '.', ',')),0,1,'L');
    
    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"VENTAS OTROS:",0,0,'L');
    $this->SetFont('Courier','',11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($VentaOtros, 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"TOTAL EFECTIVO:",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->CellFitSpace(60,4,utf8_decode(number_format($TotalEfectivo, 2, '.', ',')),0,1,'L');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"TOTAL OTROS:",0,0,'L');
    $this->SetFont('Courier','',12);
    $this->CellFitSpace(60,4,utf8_decode(number_format($TotalOtros, 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->Cell(35,4,"EFECT EN CAJA",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->Cell(60,4,utf8_decode(number_format($reg[0]["dineroefectivo"], 2, '.', ',')),0,1,'L');

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(35,4,"DIF. EFECTIVO:",0,0,'L');
    $this->SetFont('Courier','',12);
    $this->CellFitSpace(60,4,utf8_decode(number_format($reg[0]["diferencia"], 2, '.', ',')),0,0,'L');

    $this->SetX(103);
    $this->SetFont('Courier','B',11);
    $this->Cell(35,4,"",0,0,'L');
    $this->SetFont('Courier',"",11);
    $this->Cell(60,4,"",0,1,'L');
    $this->Ln(2);

    $this->SetX(8);
    $this->SetFont('Courier','B',11);
    $this->CellFitSpace(190,4,"OBSERVACIONES",0,1,'L');

    if($reg[0]["comentarios"] != ""){

    $this->SetX(8);
    $this->MultiCell(190,4,$this->SetFont('Courier',"",10).utf8_decode($reg[0]["comentarios"]),0,'L');

    }

    ####################### DATOS DE CIERRE #######################

}
########################## FUNCION TICKET CIERRE ARQUEO (A5) ##############################

########################## FUNCION LISTAR ARQUEOS DE CAJAS ##############################
function TablaListarArqueos()
   {

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE ARQUEOS DE CAJAS',0,0,'C');

   if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(40,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(45,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(35,8,'APERTURA',1,0,'C', True);
    $this->Cell(35,8,'CIERRE',1,0,'C', True);
    $this->Cell(25,8,'INICIAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL EN EFECTIVO',1,0,'C', True);
    $this->Cell(35,8,'EFECTIVO CAJA',1,0,'C', True);
    $this->Cell(30,8,'DIFERENCIA',1,1,'C', True);

    $tra = new Login();
    $reg = $tra->ListarArqueos();
    
    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(10,40,45,35,35,25,40,40,35,30));

    $TotalVenta = 0;
    $TotalEfectivo = 0;
    $TotalCaja = 0;
    $TotalDiferencia = 0;

    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $TotalVenta += $reg[$i]['efectivo']+$reg[$i]['tdebito']+$reg[$i]['tcredito']+$reg[$i]['otros'];
    $TotalEfectivo += $reg[$i]['efectivo'];
    $TotalCaja += $reg[$i]['dineroefectivo'];
    $TotalDiferencia += $reg[$i]['diferencia'];
    $simbolo = $reg[$i]['simbolo']." ";

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['nomsucursal']),
        utf8_decode($reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']),
        utf8_decode( date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura']))),
        utf8_decode($reg[$i]['statusarqueo'] == 1 ? "*********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre']))),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['efectivo']+$reg[$i]['tdebito']+$reg[$i]['tcredito']+$reg[$i]['otros'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']-$reg[$i]['egresos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','))));
        }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalEfectivo, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalCaja, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDiferencia, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(50,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(45,8,'APERTURA',1,0,'C', True);
    $this->Cell(45,8,'CIERRE',1,0,'C', True);
    $this->Cell(30,8,'INICIAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL EN EFECTIVO',1,0,'C', True);
    $this->Cell(45,8,'EFECTIVO CAJA',1,0,'C', True);
    $this->Cell(30,8,'DIFERENCIA',1,1,'C', True);

    $tra = new Login();
    $reg = $tra->ListarArqueos();
    
    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(10,50,45,45,30,40,40,45,30));

    $TotalVenta = 0;
    $TotalEfectivo = 0;
    $TotalCaja = 0;
    $TotalDiferencia = 0;

    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $TotalVenta += $reg[$i]['efectivo']+$reg[$i]['tdebito']+$reg[$i]['tcredito']+$reg[$i]['otros'];
    $TotalEfectivo += $reg[$i]['efectivo'];
    $TotalCaja += $reg[$i]['dineroefectivo'];
    $TotalDiferencia += $reg[$i]['diferencia'];
    $simbolo = $reg[$i]['simbolo']." ";

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']),
        utf8_decode( date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura']))),
        utf8_decode($reg[$i]['statusarqueo'] == 1 ? "*********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre']))),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['efectivo']+$reg[$i]['tdebito']+$reg[$i]['tcredito']+$reg[$i]['otros'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']-$reg[$i]['egresos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','))));
        }
   
    $this->Cell(180,5,'',0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalEfectivo, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalCaja, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDiferencia, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ARQUEOS DE CAJAS ##############################

####################### FUNCION LISTAR ARQUEOS DE CAJAS POR FECHAS ######################
function TablaListarArqueosxFechas()
   {

    $tra = new Login();
    $reg = $tra->BuscarArqueosxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE ARQUEOS DE CAJAS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(330,6,"Nº".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(330,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(330,6,"Nº DE CAJA: ".utf8_decode($reg[0]['nrocaja'].": ".$reg[0]['nomcaja']),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"RESPONSABLE: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(50,8,'APERTURA',1,0,'C', True);
    $this->Cell(50,8,'CIERRE',1,0,'C', True);
    $this->Cell(40,8,'INICIAL',1,0,'C', True);
    $this->Cell(50,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(50,8,'TOTAL EN EFECTIVO',1,0,'C', True);
    $this->Cell(50,8,'EFECTIVO CAJA',1,0,'C', True);
    $this->Cell(35,8,'DIFERENCIA',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(10,50,50,40,50,50,50,35));

    $TotalVenta = 0;
    $TotalEfectivo = 0;
    $TotalCaja = 0;
    $TotalDiferencia = 0;

    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    $TotalVenta += $reg[$i]['efectivo']+$reg[$i]['tdebito']+$reg[$i]['tcredito']+$reg[$i]['otros'];
    $TotalEfectivo += $reg[$i]['efectivo'];
    $TotalCaja += $reg[$i]['dineroefectivo'];
    $TotalDiferencia += $reg[$i]['diferencia'];
    $simbolo = $reg[$i]['simbolo']." ";

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode( date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura']))),
        utf8_decode($reg[$i]['statusarqueo'] == 1 ? "*********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre']))),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['efectivo']+$reg[$i]['tdebito']+$reg[$i]['tcredito']+$reg[$i]['otros'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']-$reg[$i]['egresos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','))));
        }
   
    $this->Cell(150,5,'',0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(50,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(50,5,utf8_decode($simbolo.number_format($TotalEfectivo, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(50,5,utf8_decode($simbolo.number_format($TotalCaja, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDiferencia, 2, '.', ',')),0,0,'L');
    $this->Ln();
      
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR ARQUEOS DE CAJAS POR FECHAS ######################

####################### FUNCION LISTAR MOVIMIENTOS EN CAJA ##########################
function TablaListarMovimientos()
   {

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE MOVIMIENTOS EN CAJA',0,0,'C');

   
   if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(55,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(50,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(25,8,'TIPO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN DE MOVIMIENTO',1,0,'C', True);
    $this->Cell(40,8,'MÉTODO MOVIMIENTO',1,0,'C', True);
    $this->Cell(45,8,'FECHA',1,0,'C', True);
    $this->Cell(40,8,'MONTO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarMovimientos();

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(10,55,50,25,70,40,45,40));

    $a=1;
    $TotalIngresos=0;
    $TotalEgresos=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $TotalIngresos+= ($reg[$i]['tipomovimiento'] == 'INGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
    $TotalEgresos+= ($reg[$i]['tipomovimiento'] == 'EGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
    $simbolo = $reg[$i]['simbolo']." ";

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomsucursal"])),utf8_decode($reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']),utf8_decode($reg[$i]['tipomovimiento']),portales(utf8_decode($reg[$i]['descripcionmovimiento'])),utf8_decode($reg[$i]['mediomovimiento']),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento']))),utf8_decode($simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','))));
        }
   
    $this->Cell(250,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(45,5,'TOTAL INGRESOS',0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalIngresos, 2, '.', ',')),0,1,'L');

    $this->Cell(250,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
     $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(45,5,'TOTAL EGRESOS',0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalEgresos, 2, '.', ',')),0,1,'L');
    $this->Ln();

      }
    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(55,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(30,8,'TIPO',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCIÓN DE MOVIMIENTO',1,0,'C', True);
    $this->Cell(60,8,'MÉTODO MOVIMIENTO',1,0,'C', True);
    $this->Cell(50,8,'FECHA',1,0,'C', True);
    $this->Cell(50,8,'MONTO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarMovimientos();

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(10,55,30,80,60,50,50));

    $a=1;
    $TotalIngresos=0;
    $TotalEgresos=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $TotalIngresos+= ($reg[$i]['tipomovimiento'] == 'INGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
    $TotalEgresos+= ($reg[$i]['tipomovimiento'] == 'EGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
    $simbolo = $reg[$i]['simbolo']." ";

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']),utf8_decode($reg[$i]['tipomovimiento']),portales(utf8_decode($reg[$i]['descripcionmovimiento'])),utf8_decode($reg[$i]['mediomovimiento']),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento']))),utf8_decode($simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','))));
        }
   
    $this->Cell(235,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(50,5,'TOTAL INGRESOS',0,0,'L');
    $this->CellFitSpace(50,5,utf8_decode($simbolo.number_format($TotalIngresos, 2, '.', ',')),0,1,'L');

    $this->Cell(235,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
     $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(50,5,'TOTAL EGRESOS',0,0,'L');
    $this->CellFitSpace(50,5,utf8_decode($simbolo.number_format($TotalEgresos, 2, '.', ',')),0,1,'L');
    $this->Ln();

      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
######################## FUNCION LISTAR MOVIMIENTOS EN CAJAS #########################

##################### FUNCION LISTAR MOVIMIENTOS EN CAJA POR FECHAS #####################
function TablaListarMovimientosxFechas()
   {
    
    $tra = new Login();
    $reg = $tra->BuscarMovimientosxFechas();
    
    ################################# MEMBRETE A4 #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    } 

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');


    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE A4 #################################

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO DE MOVIMIENTOS EN CAJA POR FECHAS',0,0,'C');


    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(190,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(190,6,"Nº DE CAJA: ".utf8_decode($reg[0]['nrocaja'].": ".$reg[0]['nomcaja']),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"RESPONSABLE: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'Nº',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCIÓN MOVIMIENTO',1,0,'C', True);
    $this->Cell(40,8,'MÉTODO MOVIMIENTO',1,0,'C', True);
    $this->Cell(30,8,'FECHA',1,0,'C', True);
    $this->Cell(30,8,'MONTO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(10,20,60,40,30,30));

    $a=1;
    $TotalIngresos=0;
    $TotalEgresos=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $TotalIngresos+= ($reg[$i]['tipomovimiento'] == 'INGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
    $TotalEgresos+= ($reg[$i]['tipomovimiento'] == 'EGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
    $simbolo = $reg[$i]['simbolo']." ";

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['tipomovimiento']),portales(utf8_decode($reg[$i]['descripcionmovimiento'])),utf8_decode($reg[$i]['mediomovimiento']),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento']))),utf8_decode($simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','))));
        }
   
    $this->Cell(130,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,'INGRESOS',0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIngresos, 2, '.', ',')),0,1,'L');

    $this->Cell(130,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
     $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,'EGRESOS',0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalEgresos, 2, '.', ',')),0,1,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
##################### FUNCION LISTAR MOVIMIENTOS EN CAJAS POR FECHAS ###################

############################## REPORTES DE CAJAS DE VENTAS ##############################



























################################### REPORTES DE ODONTOLOGIA ##################################

############################### FUNCION PARA MOSTRAR ODONTOLOGIA ################################# 
function FichaOdontologica()
  {
    $tra = new Login();
    $reg = $tra->OdontologiaPorId();

    ################################# MEMBRETE A4 #################################
    $logo = (file_exists("./fotos/sucursales/".$reg[0]['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png");
    
    $foto = (file_exists("./fotos/odontograma/F_".$reg[0]['codcita']."_".$reg[0]['codpaciente']."_".$reg[0]['codsucursal'].".jpg") == "" ? "" : $this->Image("./fotos/odontograma/F_".$reg[0]['codcita']."_".$reg[0]['codpaciente']."_".$reg[0]['codsucursal'].".jpg", 150, 14, 50, 34, "JPG"));

    /*$odontograma = "./fotos/odontograma/O_".$reg[0]['codcita']."_".$reg[0]['codpaciente']."_".$reg[0]['codsucursal'].".png";
    $odontograma2 = "./fotos/odontograma/F_".$reg[0]['codcita']."_".$reg[0]['codpaciente']."_".$reg[0]['codsucursal'].".jpg";
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(140,62,$this->Image($odontograma, $this->GetX()+0, $this->GetY()+0.5, 140), 1, 0, "PNG" );
    $this->Cell(50,62,$this->Image($odontograma2, $this->GetX()+0, $this->GetY()+0, 49.7), 1, 0, "PNG" );
    $this->Ln();*/

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['nomsucursal'])),0,0,'C');
    //$this->Cell(55,5,$this->Image($foto, $this->GetX()+8, $this->GetY()+2, 26),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($reg[0]['documsucursal'] == '0' ? "" : $reg[0]['documento'])." ".utf8_decode($reg[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($reg[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($reg[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($reg[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(4);
    ################################# MEMBRETE A4 #################################

    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'FICHA ODONTOLÓGICA',0,0,'C');
    
    $this->Ln();
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(190,6,'DATOS DE IDENTIFICACIÓN',1,1,'C', True);
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(95,5,'FECHA DE ELABORACIÓN: '.date("d-m-Y", strtotime($reg[0]['fechaodontologia'])),1,0,'L');
    $this->CellFitSpace(95,5,'HORA DE ELABORACIÓN: '.date("Hi:s", strtotime($reg[0]['fechaodontologia'])),1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(190,6,'I. DATOS PERSONALES',1,0,'C', True);
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(63,5,'Nº IDENTIFICACIÓN: '.$reg[0]['cedpaciente'],1,0,'L');
    $this->CellFitSpace(64,5,'TIPO IDENTIFICACIÓN: '.$reg[0]['documento4'],1,0,'L');
    $this->CellFitSpace(63,5,'APELLIDOS: '.portales(utf8_decode($reg[0]['apepaciente'])),1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(63,5,'NOMBRES: '.portales(utf8_decode($reg[0]['nompaciente'])),1,0,'L');
    $this->CellFitSpace(64,5,'FECHA NACIMIENTO: '.date("d-m-Y", strtotime($reg[0]['fnacpaciente'])),1,0,'L');
    $this->CellFitSpace(63,5,'EDAD: '.edad($reg[0]['fnacpaciente']).' AÑOS',1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(63,5,'ESTADO CIVIL: '.utf8_decode($reg[0]['estadopaciente']),1,0,'L');
    $this->CellFitSpace(64,5,'PERTENENCIA ÉTNICA: '.utf8_decode($reg[0]['enfoquepaciente']),1,0,'L');
    $this->CellFitSpace(63,5,'SEXO: '.utf8_decode($reg[0]['sexopaciente']),1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(63,5,'Nº DE TELEFONO: '.utf8_decode($reg[0]['tlfpaciente']),1,0,'L');
    $this->CellFitSpace(64,5,'DIREC. DOM.: '.portales(utf8_decode($reg[0]['direcpaciente'])),1,0,'L');
    $this->CellFitSpace(63,5,'OCUPACIÓN: '.portales(utf8_decode($reg[0]['ocupacionpaciente'])),1,0,'L');
    $this->Ln();

    
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(190,6,'II. ANTECEDENTES MÉDICOS',1,0,'C', True);
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(60,5,' ',1,0,'L');
    $this->CellFitSpace(15,5,'SI',1,0,'C');
    $this->CellFitSpace(15,5,'NO',1,0,'C');
    $this->CellFitSpace(20,5,'NO SABE',1,0,'C');
    $this->CellFitSpace(80,5,'CUALES: ',1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'TRATAMIENTO MÉDICO: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['tratamientomedico'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['tratamientomedico'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['tratamientomedico'] == 'NO SABE' ? "X" : "*****"),1,0,'C');
    $this->Cell(80,5,$reg[0]['cualestratamiento'] == '' ? "*****" : $reg[0]['cualestratamiento'],1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'INGESTA DE MEDICAMENTOS: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['ingestamedicamentos'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['ingestamedicamentos'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['ingestamedicamentos'] == 'NO SABE' ? "X" : "*****"),1,0,'C');
    $this->Cell(80,5,$reg[0]['cualesingesta'] == '' ? "*****" : $reg[0]['cualesingesta'],1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'REACCIONES ALÉRGICAS: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['alergias'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['alergias'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['alergias'] == 'NO SABE' ? "X" : "*****"),1,0,'C');
    $this->Cell(80,5,$reg[0]['cualesalergias'] == '' ? "*****" : $reg[0]['cualesalergias'],1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'HEMORRAGIAS: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['hemorragias'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['hemorragias'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['hemorragias'] == 'NO SABE' ? "X" : "*****"),1,0,'C');
    $this->Cell(80,5,$reg[0]['cualeshemorragias'] == '' ? "*****" : $reg[0]['cualeshemorragias'],1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'SINOSITIS: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['sinositis'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['sinositis'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['sinositis'] == 'NO SABE' ? "X" : "*****"),1,0,'C');
    $this->Cell(80,5,'*****',1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'ENFERMEDAD RESPIRATORIA: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['enfermedadrespiratoria'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['enfermedadrespiratoria'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['enfermedadrespiratoria'] == 'NO SABE' ? "X" : "*****"),1,0,'C');
    $this->Cell(80,5,'*****',1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'DIABETES: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['diabetes'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['diabetes'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['diabetes'] == 'NO SABE' ? "X" : "*****"),1,0,'C');
    $this->Cell(80,5,'*****',1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'CARDIOPATIA: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['cardiopatia'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['cardiopatia'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['cardiopatia'] == 'NO SABE' ? "X" : "*****"),1,0,'C');
    $this->Cell(80,5,'*****',1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'HEPATITIS: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['hepatitis'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['hepatitis'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['hepatitis'] == 'NO SABE' ? "X" : "*****"),1,0,'C');
    $this->Cell(80,5,'*****',1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'HIPERTENSIÓN ARTERIAL: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['hepertension'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['hepertension'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['hepertension'] == 'NO SABE' ? "X" : "*****"),1,0,'C');
    $this->Cell(80,5,'*****',1,0,'L');
    $this->Ln();
    
    
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(190,6,'III. HÁBITOS DE SALUD ORAL',1,0,'C', True);
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,' ',1,0,'L');
    $this->Cell(15,5,'SI',1,0,'C');
    $this->Cell(15,5,'NO',1,0,'C');
    $this->Cell(100,5,'',1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'ASISTENCIA A ODONTOLOGÍA: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['asistenciaodontologica'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['asistenciaodontologica'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(40,5,'FECHA ÚLTIMA VISITA: ',1,0,'C');
    $this->Cell(60,5,$reg[0]['ultimavisitaodontologia'] == '0000-00-00' ? "*****" : $reg[0]['ultimavisitaodontologia'],1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'CEPILLADO: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['cepillado'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['cepillado'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(40,5,'CUANTAS VECES AL DÍA: ',1,0,'C');
    $this->Cell(60,5,$reg[0]['cuantoscepillados'] == '' ? "*****" : $reg[0]['cuantoscepillados'],1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'SEDA DENTAL: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['sedadental'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['sedadental'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(40,5,'CUANTAS VECES AL DÍA: ',1,0,'C');
    $this->Cell(60,5,$reg[0]['cuantascedasdental'] == '' ? "*****" : $reg[0]['cuantascedasdental'],1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'CREMA DENTAL: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['cremadental'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['cremadental'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(40,5,'*****',1,0,'C');
    $this->Cell(60,5,'*****',1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'ENJUAGUE: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['enjuague'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['enjuague'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(40,5,'*****',1,0,'C');
    $this->Cell(60,5,"*****",1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(190,6,'IV. ESTADO PERIODONTAL',1,0,'C', True);
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,' ',1,0,'L');
    $this->Cell(15,5,'SI',1,0,'C');
    $this->Cell(15,5,'NO',1,0,'C');
    $this->Cell(100,5,'',1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'SANGRAN ENCIAS AL CEPILLAR: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['sangranencias'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['sangranencias'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(100,5,'',1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'TOMA AGUA DE LA LLAVE: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['tomaaguallave'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['tomaaguallave'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(100,5,'',1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'ELEMENTOS QUE CONTIENEN FLUOR: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['elementosconfluor'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['elementosconfluor'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(100,5,'',1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'APARATOS DE ORTODONCIA: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['aparatosortodoncia'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['aparatosortodoncia'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(100,5,'',1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'PRÓTESIS: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['protesis'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['protesis'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(30,5,'FIJA: ',1,0,'C');
    $this->Cell(20,5,$reg[0]['protesisfija'] == '' ? "*****" : $reg[0]['protesisfija'],1,0,'L');
    $this->Cell(30,5,'REMOVIBLE: ',1,0,'L');
    $this->Cell(20,5,$reg[0]['protesisremovible'] == '' ? "*****" : $reg[0]['protesisremovible'],1,0,'L');
    $this->Ln();
    
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'ARTICULACIÓN TEMPORO - MANDIBULAR',1,0,'L');
    $this->Cell(15,5,'NORMAL',1,0,'C');
    $this->Cell(15,5,'ANORMAL',1,0,'C');
    $this->Cell(60,5,'',1,0,'L');
    $this->Cell(20,5,'NORMAL',1,0,'C');
    $this->Cell(20,5,'ANORMAL',1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'LABIOS: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['labios'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['labios'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(60,5,'SENOS MAXILARES: ',1,0,'L');
    $this->Cell(20,5,$variable = ( $reg[0]['senosmaxilares'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['senosmaxilares'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'LENGUA: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['lengua'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['lengua'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(60,5,'MUSCULOS MASTICADORES: ',1,0,'L');
    $this->Cell(20,5,$variable = ( $reg[0]['musculosmasticadores'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['musculosmasticadores'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'PALADAR: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['paladar'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['paladar'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(60,5,'SISTEMA NERVIOSO: ',1,0,'L');
    $this->Cell(20,5,$variable = ( $reg[0]['sistemanervioso'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['sistemanervioso'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'PISO DE LA BOCA: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['pisoboca'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['pisoboca'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(60,5,'SISTEMA VASCULAR: ',1,0,'L');
    $this->Cell(20,5,$variable = ( $reg[0]['sistemavascular'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['sistemavascular'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'CARRILLOS: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['carrillos'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['carrillos'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(60,5,'LINFÁTICO REGIONAL: ',1,0,'L');
    $this->Cell(20,5,$variable = ( $reg[0]['sistemalinfatico'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['sistemalinfatico'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'GLÁNDULAS SALIVALES: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['glandulasalivales'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['glandulasalivales'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(60,5,'FUNCIÓN OCLUSAL: ',1,0,'L');
    $this->Cell(20,5,$variable = ( $reg[0]['funcionoclusal'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['funcionoclusal'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'MAXILAR: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['maxilar'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['maxilar'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(60,5,'MUSCULOS MASTICADORES: ',1,0,'L');
    $this->Cell(20,5,$variable = ( $reg[0]['musculosmasticadores'] == 'NORMAL' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['musculosmasticadores'] == 'ANORMAL' ? "X" : "*****"),1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->MultiCell(190,8,"OBSERVACIONES: ".utf8_decode($reg[0]['observacionperiodontal'] == '' ? "*****" : $reg[0]['observacionperiodontal']),1,'J');
    
    $this->AddPage();

    ################################# MEMBRETE A4 #################################
    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($reg[0]['documsucursal'] == '0' ? "" : $reg[0]['documento'])." ".utf8_decode($reg[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($reg[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($reg[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(3);
    ################################# MEMBRETE A4 #################################

    $this->Ln();
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(190,6,'V. EXAMÉN DENTAL',1,0,'C', True);
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,' ',1,0,'L');
    $this->Cell(15,5,'SI',1,0,'C');
    $this->Cell(15,5,'NO',1,0,'C');
    $this->Cell(60,5,' ',1,0,'L');
    $this->Cell(20,5,'SI',1,0,'C');
    $this->Cell(20,5,'NO',1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'SUPERNUMERARIOS: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['supernumerarios'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['supernumerarios'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(60,5,'PLACA BLANDA: ',1,0,'L');
    $this->Cell(20,5,$variable = ( $reg[0]['placablanda'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['placablanda'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'ADRACIÓN: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['adracion'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['adracion'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(60,5,'PLACA CALIFICADA: ',1,0,'L');
    $this->Cell(20,5,$variable = ( $reg[0]['placacalificada'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['placacalificada'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Ln();

    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'MANCHAS: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['manchas'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['manchas'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(60,5,'OTROS: ',1,0,'L');
    $this->Cell(20,5,$variable = ( $reg[0]['otrosdental'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(20,5,$variable = ( $reg[0]['otrosdental'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(60,5,'PATOLOGÍA PULPAR: ',1,0,'L');
    $this->Cell(15,5,$variable = ( $reg[0]['patologiapulpar'] == 'SI' ? "X" : "*****"),1,0,'C');
    $this->Cell(15,5,$variable = ( $reg[0]['patologiapulpar'] == 'NO' ? "X" : "*****"),1,0,'C');
    $this->Cell(100,5,'',1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->MultiCell(190,8,"OBSERVACIONES: ".portales(utf8_decode($reg[0]['observacionexamendental'] == '' ? "*****" : $reg[0]['observacionexamendental'])),1,'J');
    
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(190,6,'VI. ODONTOGRAMA',1,0,'C', True);
    $this->Ln();
    
    $odontograma = "./fotos/odontograma/O_".$reg[0]['codcita']."_".$reg[0]['codpaciente']."_".$reg[0]['codsucursal'].".png";
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,62,$this->Image($odontograma, $this->GetX()+20, $this->GetY()+0.5, 140), 1, 0, "PNG" );
    $this->Ln();
    
    $this->SetFont('Courier','B',7);  
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,4,'N°',1,0,'C', True);
    $this->CellFitSpace(40,4,'DIENTE',1,0,'C', True);
    $this->CellFitSpace(50,4,'CARA DIENTE',1,0,'C', True);
    $this->CellFitSpace(80,4,'REFERENCIAS',1,0,'C', True);
    $this->Ln();
    
     $explode = explode("__",$reg[0]['estados']);
     $listaSimple = array_values(array_unique($explode));
     # Recorremos el array para despues separar en 3 epa espera aqui hay un errro ya jejejjevariables lo que se requiere.
     for($cont=0; $cont<COUNT($listaSimple); $cont++):
     # Listo 3 variables donde guardare lo que me retorne el explode de cada posicion del array.
     list($diente,$caradiente,$referencias) = explode("_",$listaSimple[$cont]);
     
     if($caradiente=="C1") { $cara = "VESTIBULAR"; } elseif($caradiente=="C2") { $cara = "DISTAL"; } elseif($caradiente=="C3") { $cara = "PALATINO"; } elseif($caradiente=="C4") { $cara = "MESIAL"; } elseif($caradiente=="C5") { $cara = "OCLUSAL"; }
     
    $this->SetFont('Courier','',6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(20,3,$cont+1,1,0,'C');
    $this->CellFitSpace(40,3,utf8_decode($diente),1,0,'C');
    $this->CellFitSpace(50,3,utf8_decode($cara),1,0,'C');
    $this->CellFitSpace(80,3,utf8_decode(substr($referencias, 2)),1,0,'C');
    $this->Ln();
    endfor;/**/
    
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(190,6,'VII. DIAGNÓSTICO Y PRONÓSTICO',1,0,'C', True);
    $this->Ln();
    
    $explode = explode(",,",utf8_decode(strtoupper($reg[0]['presuntivo'])));
    $a=1;
    for($cont=0; $cont<COUNT($explode); $cont++):
    list($idciepresuntivo,$presuntivo) = explode("/",$explode[$cont]);

    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->MultiCell(190,6,$idciepresuntivo == '' ? "PRESUNTIVO: *****" : "PRESUNTIVO: " .$a++. ". ".$presuntivo,1,'J');
    
    endfor;
    
    $explode = explode(",,",utf8_decode(strtoupper($reg[0]['definitivo'])));
    $a=1;
    for($cont=0; $cont<COUNT($explode); $cont++):
    list($idciedefinitivo,$definitivo) = explode("/",$explode[$cont]);
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->MultiCell(190,6,$idciedefinitivo == '' ? "DEFINITIVO: *****" : "DEFINITIVO: " .$a++. ". ".$definitivo,1,'J');
    
    endfor;

    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->MultiCell(190,6,"PRONÓSTICO: ".portales(utf8_decode($reg[0]['pronostico'] == '' ? "*****" : $reg[0]['pronostico'])),1,'J');
    
    
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(190,6,'VIII. PLAN DE TRATAMIENTO',1,0,'C', True);
    $this->Ln();
        
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,8,portales(utf8_decode($reg[0]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[0]['plantratamiento']))),1,0,'L');
    $this->Ln();
        
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,8,portales(utf8_decode($reg[0]['observacionestratamiento'] == "" ? "**********" : utf8_decode($reg[0]['observacionestratamiento']))),1,0,'L');
    $this->Ln();

    $this->Ln(6); 
    $this->SetFont('Courier','B',8);
    $this->Cell(5, 0,'', 0, 0, "JPG" );
    $this->Cell(110, 3,'FIRMA DEL PROFESIONAL: ', 0, 0);
    $this->Cell(90, 3,'FIRMA DEL PACIENTE: ', 0, 1);

    $this->Ln(2);
    $this->Cell(30,3,"",0,0,'C');
    $this->Cell(60,3,portales(utf8_decode($reg[0]['nomespecialista'])),0,0,'C');
    $this->Cell(35,3,"",0,0,'C');
    $this->Cell(70,3,portales(utf8_decode($reg[0]['documento4']." ".$reg[0]['cedpaciente'])),0,1,'C');

    $this->Cell(30,3,"",0,0,'C');
    $this->Cell(60,3,portales(utf8_decode($reg[0]['especialidad'])),0,0,'C');
    $this->Cell(35,3,"",0,0,'C');
    $this->Cell(70,3,portales(utf8_decode($reg[0]['nompaciente']." ".$reg[0]['apepaciente'])),0,1,'C');

    $this->Cell(30,3,"",0,0,'C');
    $this->Cell(60,3,'T.P. '.utf8_decode($reg[0]['tpespecialista']),0,0,'C');
    $this->Cell(35,3,"",0,1,'C');
    $this->Ln(3);
    
}
############################### FUNCION PARA MOSTRAR ODONTOLOGIA #################################

########################## FUNCION LISTAR ODONTOLOGIA ##############################
function TablaListarOdontologia()
   {
    
    $tra = new Login();
    $reg = $tra->ListarOdontologia();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE CONSULTAS ODONTOLÓGICAS',0,0,'C');

   if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(30,8,'Nº CONSULTA',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(45,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(35,8,'PRONOSTICO',1,0,'C', True);
    $this->Cell(35,8,'TRATAMIENTO.',1,0,'C', True);
    $this->Cell(35,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(30,8,'FECHA',1,0,'C', True);
    $this->Cell(30,8,'HORA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,30,50,45,35,35,35,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;

    for($i=0;$i<sizeof($reg);$i++){ 
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomsucursal"])),utf8_decode($reg[$i]["cododontologia"]),utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"),portales(utf8_decode($reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente'])),portales(utf8_decode($reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico'])),portales(utf8_decode($reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']))),portales(utf8_decode($reg[$i]['observacionestratamiento'] == "" ? "**********" : $reg[$i]['observacionestratamiento'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaodontologia']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechaodontologia'])))
        ));
        }
      }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº CONSULTA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(40,8,'PRONOSTICO',1,0,'C', True);
    $this->Cell(40,8,'TRATAMIENTO.',1,0,'C', True);
    $this->Cell(40,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(30,8,'FECHA',1,0,'C', True);
    $this->Cell(30,8,'HORA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,55,55,40,40,40,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;

    for($i=0;$i<sizeof($reg);$i++){ 
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["cododontologia"]),utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"),portales(utf8_decode($reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente'])),portales(utf8_decode($reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico'])),portales(utf8_decode($reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']))),portales(utf8_decode($reg[$i]['observacionestratamiento'] == "" ? "**********" : $reg[$i]['observacionestratamiento'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaodontologia']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechaodontologia'])))
        ));

        }
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ODONTOLOGIA ##############################

########################## FUNCION LISTAR ODONTOLOGIA POR FECHAS ##############################
function TablaListarOdontologiaxFechas()
   {
    
    $tra = new Login();
    $reg = $tra->BuscarOdontologiaxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE CONSULTAS ODONTOLÓGICAS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº CONSULTA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(40,8,'PRONOSTICO',1,0,'C', True);
    $this->Cell(40,8,'TRATAMIENTO.',1,0,'C', True);
    $this->Cell(40,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(30,8,'FECHA',1,0,'C', True);
    $this->Cell(30,8,'HORA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,55,55,40,40,40,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;

    for($i=0;$i<sizeof($reg);$i++){ 
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["cododontologia"]),utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"),portales(utf8_decode($reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente'])),portales(utf8_decode($reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico'])),portales(utf8_decode($reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']))),portales(utf8_decode($reg[$i]['observacionestratamiento'] == "" ? "**********" : $reg[$i]['observacionestratamiento'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaodontologia']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechaodontologia'])))
        ));

        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ODONTOILOGIA POR FECHAS ##############################

########################## FUNCION LISTAR ODONTOLOGIA POR ESPECIALISTA ##############################
function TablaListarOdontologiaxEspecialista()
   {
    
    $tra = new Login();
    $reg = $tra->BuscarOdontologiaxEspecialista();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE CONSULTAS ODONTOLÓGICAS POR ESPECIALISTA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." ESPECIALISTA: ".utf8_decode($reg[0]["cedespecialista"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESPECIALISTA: ".portales(utf8_decode($reg[0]["nomespecialista"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº CONSULTA',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(50,8,'PRONOSTICO',1,0,'C', True);
    $this->Cell(50,8,'TRATAMIENTO.',1,0,'C', True);
    $this->Cell(60,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(30,8,'FECHA',1,0,'C', True);
    $this->Cell(30,8,'HORA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,50,50,60,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;

    for($i=0;$i<sizeof($reg);$i++){ 
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["cododontologia"]),portales(utf8_decode($reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente'])),portales(utf8_decode($reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico'])),portales(utf8_decode($reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']))),portales(utf8_decode($reg[$i]['observacionestratamiento'] == "" ? "**********" : $reg[$i]['observacionestratamiento'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaodontologia']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechaodontologia'])))
        ));

        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ODONTOILOGIA POR ESPECIALISTA ##############################

########################## FUNCION LISTAR ODONTOLOGIA POR PACIENTE ##############################
function TablaListarOdontologiaxPaciente()
   {
    
    $tra = new Login();
    $reg = $tra->BuscarOdontologiaxPaciente();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'HISTORIA ODONTOLÓGICA DEL PACIENTE',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento4']))." PACIENTE: ".utf8_decode($reg[0]["cedpaciente"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PACIENTE: ".portales(utf8_decode($reg[0]['nompaciente']." ".$reg[0]['apepaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"GRUPO SANG: ".portales(utf8_decode($reg[0]['gruposapaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"Nº DE TELÉFONO: ".portales(utf8_decode($reg[0]['tlfpaciente'] == '' ? "********" : $reg[0]['tlfpaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"FECHA NACIMIENTO: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : date("d-m-Y",strtotime($reg[0]['fnacpaciente'])))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"EDAD: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : edad($reg[0]['fnacpaciente']))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESTADO CIVIL: ".portales(utf8_decode($reg[0]['estadopaciente'] == '' ? "********" : $reg[0]['estadopaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"OCUPACIÓN: ".portales(utf8_decode($reg[0]['ocupacionpaciente'] == '' ? "********" : $reg[0]['ocupacionpaciente'])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº CONSULTA',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(50,8,'PRONOSTICO',1,0,'C', True);
    $this->Cell(50,8,'TRATAMIENTO.',1,0,'C', True);
    $this->Cell(60,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(30,8,'FECHA',1,0,'C', True);
    $this->Cell(30,8,'HORA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,50,50,60,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;

    for($i=0;$i<sizeof($reg);$i++){ 
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["cododontologia"]),utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"),portales(utf8_decode($reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico'])),portales(utf8_decode($reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']))),portales(utf8_decode($reg[$i]['observacionestratamiento'] == "" ? "**********" : $reg[$i]['observacionestratamiento'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaodontologia']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechaodontologia'])))
        ));

        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ODONTOLOGIA POR PACIENTE ##############################

############################# FUNCION CONSENTIMIENTO INFORMADO #############################
 function TablaConsentimientoInformado()
   {
    
    $tra = new Login();
    $reg = $tra->ConsentimientosPorId();
    
    ################################# MEMBRETE A4 #################################
    $logo = ( file_exists("./fotos/sucursales/".$reg[0]['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+3, $this->GetY()+8, $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($reg[0]['documsucursal'] == '0' ? "" : $reg[0]['documento'])." ".utf8_decode($reg[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($reg[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($reg[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($reg[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);
    ################################# MEMBRETE A4 #################################
    
    $this->Ln();
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(5, 130, 275); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(190,6,utf8_decode($reg[0]['procedimiento']),1,1,'C', True);
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(95,5,'FECHA DE ELABORACIÓN: '.date("d-m-Y", strtotime($reg[0]['fechaconsentimiento'])),1,0,'L');
    $this->CellFitSpace(95,5,'HORA DE ELABORACIÓN: '.date("H:i:s", strtotime($reg[0]['fechaconsentimiento'])),1,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->MultiCell(190,5,'SERVICIO EN EL QUE SE REALIZA EL PROCEDIMIENTO: '.portales(utf8_decode($reg[0]['procedimiento'])),1,'J');
    $this->Ln();

    $this->newFlowingBlock(190, 5, 0, 'J');
    $this->SetFont('Courier','',9); 
    $this->WriteFlowingBlock('YO: ');
    $this->SetFont('Courier', 'B', 9);
    $this->WriteFlowingBlock(portales(utf8_decode($reg[0]['apepaciente'].' '.$reg[0]['nompaciente'])));
    $this->SetFont('Courier', '', 9);
    $this->WriteFlowingBlock($variable = (edad($reg[0]['fnacpaciente']) >= '18' ? " MAYOR DE EDAD " : " MENOR DE EDAD "). ', IDENTIFICADO CON ' );
    $this->SetFont('Courier', 'B', 9);
    $this->WriteFlowingBlock($reg[0]['documento4'].' N° '.$reg[0]['cedpaciente']);
    $this->SetFont('Courier', '', 9);
    $this->WriteFlowingBlock(' DE ');
    $this->SetFont('Courier', 'B', 9);
    $this->WriteFlowingBlock(portales(utf8_decode($departamento = ($reg[0]['departamento3'] == '' ? "" : $reg[0]['departamento3'])." ".$provincia = ($reg[0]['provincia3'] == '' ? "" : $reg[0]['provincia3'])." ".$reg[0]['direcpaciente'])));
    $this->SetFont('Courier', '', 9 );
    $this->WriteFlowingBlock(' Y COMO PACIENTE O COMO RESPONSABLE DEL PACIENTE AUTORIZO AL DR.(A) ');
    $this->SetFont('Courier', 'B', 9);
    $this->WriteFlowingBlock(portales(utf8_decode($reg[0]['nomespecialista'])));
    $this->SetFont('Courier', '', 9);
    $this->WriteFlowingBlock(' CON PROFESIÓN O ESPECIALIDAD ');
    $this->SetFont('Courier', 'B', 9);
    $this->WriteFlowingBlock(utf8_decode($reg[0]['especialidad']));
        
        
    $this->SetFont('Courier', '', 9);
    $this->WriteFlowingBlock(', PARA LA REALIZACIÓN DEL PROCEDIMIENTO ');   
    $this->SetFont('Courier', 'B', 9);
    $this->WriteFlowingBlock(portales(utf8_decode($reg[0]['procedimiento'])));
    $this->SetFont('Courier', '', 9);
    $this->WriteFlowingBlock(', TENIENDO EN CUENTA QUE HE SIDO INFORMADO CLARAMENTE SOBRE LOS RIESGOS QUE SE PUEDEN PRESENTAR, SIENDO ESTOS:');
    $this->finishFlowingBlock();
    $this->Ln(5);
    $this->SetFont('Courier', 'B', 9);
    $this->MultiCell(190,5,portales(utf8_decode($reg[0]['observaciones'])),0,'J'); 
    $this->Ln(5);   
        
    $this->newFlowingBlock(190, 5, 0, 'J');
    $this->SetFont('Courier', '', 9);
    $this->WriteFlowingBlock('COMPRENDO Y ACEPTO QUE DURANTE EL PROCEDIMIENTO PUEDEN APARECER CIRCUNSTANCIAS IMPREVISIBLES O INESPERADAS, QUE PUEDAN REQUERIR UNA EXTENSIÓN DEL PROCEDIMIENTO ORIGINAL O LA REALIZACIÓN DE OTRO PROCEDIMIENTO NO MENCIONADO ARRIBA.');  
    $this->finishFlowingBlock();
    $this->Ln(5);
    $this->newFlowingBlock(190, 5, 0, 'J');
    $this->SetFont('Courier', '', 9);
    $this->WriteFlowingBlock('AL FIRMAR ESTE DOCUMENTO RECONOZCO QUE LOS HE LEIDO O QUE ME HAN SIDO LEIDO Y EXPLICADO Y QUE COMPRENDO PERFECTAMENTE SU CONTENIDO.');    
    $this->finishFlowingBlock();
    $this->Ln(5);
    $this->newFlowingBlock(190, 5, 0, 'J');
    $this->SetFont('Courier', '', 9);
    $this->WriteFlowingBlock('SE ME HAN DADO AMPLIAS OPORTUNIDADES DE FORMULAR PREGUNTAS Y QUE TODAS LAS PREGUNTAS QUE HE FORMULADO HAN SIDO RESPONDIDAS O EXPLICADAS EN FORMA SATISFACTORIA.');    
    $this->finishFlowingBlock();
    $this->Ln(5);
    $this->newFlowingBlock(188, 5, 0, 'J');
    $this->SetFont('Courier', '', 9);
    $this->WriteFlowingBlock('ACEPTO QUE LA MEDICINA NO ES UNA CIENCIA EXACTA Y QUE NO SE ME HAN GARANTIZADO LOS RESULTADOS QUE SE ESPERAN DE LA INTERVENCIÓN QUIRÚRGICA O PROCEDIMIENTOS DIAGNÓSTICOS, TERAPÉUTICOS U ODONTOLÓGICOS, EN EL SENTIDO DE QUE LA PRÁCTICA DE LA INTERVENCIÓN O PROCEDIMIENTOS QUE REQUIERO COMPROMETE UNA ACTIVIDAD DE MEDIO, PERO NO DE RESULTADOS.');    
    $this->finishFlowingBlock();
    $this->Ln(5);
    $this->newFlowingBlock(190, 5, 0, 'J');
    $this->SetFont('Courier', '', 9);
    $this->WriteFlowingBlock('COMPRENDIENDO ESTAS LIMITACIONES, DOY MI CONSENTIMIENTO PARA LA REALIZACIÓN DEL PROCEDIMIENTO Y FIRMO A CONTINUACIÓN:');  
    $this->finishFlowingBlock();
    $this->Ln(20);
    
    
    $this->SetFont('Courier','',9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(80,5,'FIRMA DEL PACIENTE: ___________________________',0,0,'L');
    $this->Cell(30,5,'',0,0,'L');
    $this->CellFitSpace(80,5,'FIRMA DEL PROFESIONAL: ___________________________',0,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['nompaciente'].' '.$reg[0]['apepaciente'])),0,0,'L');
    $this->Cell(30,5,'',0,0,'L');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['nomespecialista'])),0,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(80,5,utf8_decode($reg[0]['documento4']).' N° '.$reg[0]['cedpaciente'],0,0,'L');
    $this->Cell(30,5,'',0,0,'L');
    $this->CellFitSpace(80,5,utf8_decode('TP. '.$reg[0]['tpespecialista']),0,0,'L');
    $this->Ln();
    
    
    if ($reg[0]['doctestigo']!='') { 
    
    $this->Ln(5);
    $this->SetFont('Courier','',9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(190,5,'FIRMA DEL TESTIGO O RESPONSABLE: ___________________________',0,0,'L');
    $this->Ln();
    
    $this->SetFont('Courier','',9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(100,5,portales(utf8_decode($reg[0]['nombretestigo'])).'. N° DOC. '.$reg[0]['doctestigo'],0,0,'L');
    $this->Ln();
    
    }
    
    if ($reg[0]['nofirmapaciente']!='') { 

    $this->Ln();
    $this->SetFont( 'Courier','B', 9 );
    $this->Cell(190,5,utf8_decode('EL PACIENTE NO PUEDE FIRMAR POR:'),0,0); 
    $this->Ln(5);
    $this->SetFont( 'Courier','', 9 );
    $this->MultiCell(190,5,utf8_decode($reg[0]['nofirmapaciente']),0,'J');
        
    }
}
############################# FUNCION CONSENTIMIENTO INFORMADO #############################

########################## FUNCION LISTAR CONSENTIMIENTO INFORMADO ##############################
function TablaListarConsentimientos()
   {
    
    $tra = new Login();
    $reg = $tra->ListarConsentimientos();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($con[0]['id_provincia']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia'])." ".$departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['direcsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_provincia']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia'])." ".$departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE CONSENTIMIENTO INFORMADO',0,0,'C');

   if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE TESTIGO',1,0,'C', True);
    $this->Cell(40,8,'PROCEDIMIENTO',1,0,'C', True);
    $this->Cell(40,8,'OBSERVACIONES.',1,0,'C', True);
    $this->Cell(25,8,'FECHA',1,0,'C', True);
    $this->Cell(25,8,'HORA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,55,55,50,40,40,25,25));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;

    for($i=0;$i<sizeof($reg);$i++){ 
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomsucursal"])),utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"),portales(utf8_decode($reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente'])),portales(utf8_decode($reg[$i]['doctestigo'] == "" ? "**********" : $reg[$i]['doctestigo'].": ".$reg[$i]['nombretestigo'])),portales(utf8_decode($reg[$i]['procedimiento'])),portales(utf8_decode($reg[$i]['observaciones'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaconsentimiento']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechaconsentimiento'])))
        ));

        }
      }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE TESTIGO',1,0,'C', True);
    $this->Cell(40,8,'PROCEDIMIENTO',1,0,'C', True);
    $this->Cell(60,8,'OBSERVACIONES.',1,0,'C', True);
    $this->Cell(30,8,'FECHA',1,0,'C', True);
    $this->Cell(30,8,'HORA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,55,55,50,40,60,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;

    for($i=0;$i<sizeof($reg);$i++){ 
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"),portales(utf8_decode($reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente'])),portales(utf8_decode($reg[$i]['doctestigo'] == "" ? "**********" : $reg[$i]['doctestigo'].": ".$reg[$i]['nombretestigo'])),portales(utf8_decode($reg[$i]['procedimiento'])),portales(utf8_decode($reg[$i]['observaciones'])),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaconsentimiento']))),utf8_decode(date("H:i:s",strtotime($reg[$i]['fechaconsentimiento'])))
        ));

        }
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CONSENTIMIENTO INFORMADO ##############################

################################### REPORTES DE ODONTOLOGIA ##################################





























################################### REPORTES DE VENTAS ##################################

########################## FUNCION TICKET VENTA ##############################
function TicketVenta()
    {  
   
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
  
    $this->SetXY(2,4);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(70,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"TLF Nº: ".utf8_decode($reg[0]['tlfsucursal']), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento'].": ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['provincia']!=''){

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])),0,1,'C');

    }

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,utf8_decode($reg[0]['direcsucursal']),0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"TICKET Nº: ".utf8_decode($reg[0]['codfactura']),0,1,'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"OBLIGADO A LLEVAR CONTABILIDAD: ".utf8_decode($reg[0]['llevacontabilidad']),0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"AMBIENTE: PRODUCCIÓN",0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"EMISIÓN: NORMAL",0,1,'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'----------- PACIENTE -----------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,$documento = ($reg[0]['documpaciente'] == '0' ? "Nº DOC:" : "Nº ".$reg[0]['documento3'].": "),0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['cedpaciente']),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"SEÑOR(A):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nompaciente']." ".$reg[0]['apepaciente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"Nº TLF:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['tlfpaciente'] == '' ? "0" : $reg[0]['tlfpaciente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------- ESPECIALISTA ---------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,$documento = ($reg[0]['documespecialista'] == '0' ? "Nº DOC:" : "Nº ".$reg[0]['documento4'].": "),0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['cedespecialista']),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"SEÑOR(A):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nomespecialista']),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"ESPECIALIDAD:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['especialidad'] == '' ? "0" : $reg[0]['especialidad']),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"Nº TLF:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['tlfespecialista'] == '' ? "0" : $reg[0]['tlfespecialista']),0,1,'L');

    $this->SetFont('Courier','B',10);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es BLANCO 255 GRIS 255)
    $this->Cell(8, 5,"CANT", 0, 0, 'C', True);
    $this->Cell(30, 5,"DETALLE", 0, 0, 'C', True);
    $this->Cell(16, 5,"P/U", 0, 0, 'C', True);
    $this->Cell(16, 5,"TOTAL", 0, 1, 'C', True);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetWidths(array(8,30,16,16));
    $simbolo = $reg[0]["simbolo"]." ";

    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){
    $SubTotal += $detalle[$i]['valortotal'];

    $this->SetX(2);
    $this->SetFont('Courier','',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array(
        utf8_decode($detalle[$i]["cantventa"]),
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode(number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(15,3,"PAGO",0,0,'L');
    $this->CellFitSpace(55,3,utf8_decode($reg[0]['tipopago']),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(15,3,"MÉTODO",0,0,'L');
    $this->CellFitSpace(55,3,utf8_decode($reg[0]['formapago']),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(34,3,"SUBTOTAL:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(34,3,"GRAVADO (".$reg[0]["iva"]."%):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(34,3,"EXENTO (0%):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(34,3,"TOTAL ".$impuesto." (".$reg[0]["iva"]."%):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(34,3,"DESC % (".$reg[0]["descuento"]."%):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(30,3,"TOTAL",0,0,'L');
    $this->CellFitSpace(40,3,$simbolo.utf8_decode(number_format($reg[0]['totalpago'], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(30,3,"SUMA DE SUS PAGOS",0,0,'L');
    $this->CellFitSpace(40,3,$simbolo.utf8_decode(number_format($reg[0]['montopagado'], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(30,3,"SU VUELTO",0,0,'L');
    $this->CellFitSpace(40,3,$simbolo.utf8_decode(number_format($reg[0]['montodevuelto'], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    if($reg[0]['tipopago']=="CREDITO"){

    $this->SetX(2);
    $this->SetFont('Courier','B',9);
    $this->CellFitSpace(15,3,"STATUS",0,0,'L');
    $this->CellFitSpace(55,3,utf8_decode($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[0]["statusventa"]),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',9);
    $this->CellFitSpace(15,3,"VENCE",0,0,'L');
    $this->CellFitSpace(55,3,utf8_decode(date("d-m-Y",strtotime($reg[0]["fechavencecredito"]))),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',9);
    $this->CellFitSpace(15,3,"DIAS",0,0,'L');
    if($reg[0]['fechavencecredito']== '0000-00-00') {
    $this->CellFitSpace(55,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->CellFitSpace(55,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->CellFitSpace(55,3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])),0,1,'R');
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',9);
    $this->CellFitSpace(15,3,"DEBE",0,0,'L');
    $this->CellFitSpace(55,3,utf8_decode($simbolo.number_format($reg[0]["totalpago"]-$reg[0]["creditopagado"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    }

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"CAJERO: ",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(55,3,utf8_decode($reg[0]['nombres']),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"FECHA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(55,3,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechaventa']))),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"HORA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(55,3,utf8_decode(date("H:i:s",strtotime($reg[0]['fechaventa']))),0,1,'L');

    if($reg[0]['observaciones']!=""){
    $this->SetX(2);
    $this->SetFont('courier','B',8);
    $this->MultiCell(70,3,"OBSERVACIONES: ".utf8_decode($reg[0]['observaciones'] == '' ? "" : $reg[0]['observaciones']),0,1,'');
    }

    $this->SetFont('Courier','B',10);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','BI',10);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(70,3,"CREANDO SONRISAS JUNTOS",0,1,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET VENTA ##############################

########################## FUNCION FACTURA VENTA (TICKET) ##############################
function FacturaVenta()
{  
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
  
    $this->SetXY(2,4);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(70,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"TLF Nº: ".utf8_decode($reg[0]['tlfsucursal']), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento'].": ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['provincia']!=''){

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])),0,1,'C');

    }

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,utf8_decode($reg[0]['direcsucursal']),0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"FACTURA Nº: ".utf8_decode($reg[0]['codfactura']),0,1,'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"OBLIGADO A LLEVAR CONTABILIDAD: ".utf8_decode($reg[0]['llevacontabilidad']),0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"AMBIENTE: PRODUCCIÓN",0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"EMISIÓN: NORMAL",0,1,'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'----------- PACIENTE -----------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,$documento = ($reg[0]['documpaciente'] == '0' ? "Nº DOC:" : "Nº ".$reg[0]['documento3'].": "),0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['cedpaciente']),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"SEÑOR(A):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nompaciente']." ".$reg[0]['apepaciente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"Nº TLF:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['tlfpaciente'] == '' ? "0" : $reg[0]['tlfpaciente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------- ESPECIALISTA ---------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,$documento = ($reg[0]['documespecialista'] == '0' ? "Nº DOC:" : "Nº ".$reg[0]['documento4'].": "),0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['cedespecialista']),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"SEÑOR(A):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nomespecialista']),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"ESPECIALIDAD:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['especialidad'] == '' ? "0" : $reg[0]['especialidad']),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"Nº TLF:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['tlfespecialista'] == '' ? "0" : $reg[0]['tlfespecialista']),0,1,'L');

    $this->SetFont('Courier','B',10);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es BLANCO 255 GRIS 255)
    $this->Cell(8, 5,"CANT", 0, 0, 'C', True);
    $this->Cell(30, 5,"DETALLE", 0, 0, 'C', True);
    $this->Cell(16, 5,"P/U", 0, 0, 'C', True);
    $this->Cell(16, 5,"TOTAL", 0, 1, 'C', True);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetWidths(array(8,30,16,16));
    $simbolo = $reg[0]["simbolo"]." ";

    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){
    $SubTotal += $detalle[$i]['valortotal'];

    $this->SetX(2);
    $this->SetFont('Courier','',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array(
        utf8_decode($detalle[$i]["cantventa"]),
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode(number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(15,3,"PAGO",0,0,'L');
    $this->CellFitSpace(55,3,utf8_decode($reg[0]['tipopago']),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(15,3,"MÉTODO",0,0,'L');
    $this->CellFitSpace(55,3,utf8_decode($reg[0]['formapago']),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(34,3,"SUBTOTAL:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(34,3,"GRAVADO (".$reg[0]["iva"]."%):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(34,3,"EXENTO (0%):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(34,3,"TOTAL ".$impuesto." (".$reg[0]["iva"]."%):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(34,3,"DESC % (".$reg[0]["descuento"]."%):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(36,3,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(30,3,"TOTAL",0,0,'L');
    $this->CellFitSpace(40,3,$simbolo.utf8_decode(number_format($reg[0]['totalpago'], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(30,3,"SUMA DE SUS PAGOS",0,0,'L');
    $this->CellFitSpace(40,3,$simbolo.utf8_decode(number_format($reg[0]['montopagado'], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(30,3,"SU VUELTO",0,0,'L');
    $this->CellFitSpace(40,3,$simbolo.utf8_decode(number_format($reg[0]['montodevuelto'], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    if($reg[0]['tipopago']=="CREDITO"){

    $this->SetX(2);
    $this->SetFont('Courier','B',9);
    $this->CellFitSpace(15,3,"STATUS",0,0,'L');
    $this->CellFitSpace(55,3,utf8_decode($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[0]["statusventa"]),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',9);
    $this->CellFitSpace(15,3,"VENCE",0,0,'L');
    $this->CellFitSpace(55,3,utf8_decode(date("d-m-Y",strtotime($reg[0]["fechavencecredito"]))),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',9);
    $this->CellFitSpace(15,3,"DIAS",0,0,'L');
    if($reg[0]['fechavencecredito']== '0000-00-00') {
    $this->CellFitSpace(55,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->CellFitSpace(55,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->CellFitSpace(55,3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])),0,1,'R');
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',9);
    $this->CellFitSpace(15,3,"DEBE",0,0,'L');
    $this->CellFitSpace(55,3,utf8_decode($simbolo.number_format($reg[0]["totalpago"]-$reg[0]["creditopagado"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    }

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"CAJERO: ",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(55,3,utf8_decode($reg[0]['nombres']),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"FECHA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(55,3,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechaventa']))),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(15,3,"HORA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(55,3,utf8_decode(date("H:i:s",strtotime($reg[0]['fechaventa']))),0,1,'L');

    if($reg[0]['observaciones']!=""){
    $this->SetX(2);
    $this->SetFont('courier','B',8);
    $this->MultiCell(70,3,"OBSERVACIONES: ".utf8_decode($reg[0]['observaciones'] == '' ? "" : $reg[0]['observaciones']),0,1,'');
    }

    $this->SetFont('Courier','B',10);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','BI',10);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(70,3,"CREANDO SONRISAS JUNTOS",0,1,'C');
    $this->Ln(3);
}
########################## FUNCION FACTURA VENTA (TICKET) ##############################

########################## FUNCION FACTURA VENTA (MITAD) #############################
function FacturaVenta2()
   {
   
    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");

    $this->Image($logo, 10, 4.5, 34, 10, "PNG");

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
        
    //Bloque datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(5, 15, 42, 25, '1.5', "");
    
    $this->SetFont('Courier','BI',8);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(5, 15);
    $this->CellFitSpace(42, 5,utf8_decode($reg[0]['nomsucursal']), 0, 1); //Membrete Nro 1

    $this->SetFont('Courier','B',6);
    if($reg[0]['provincia']!='0'){

    $this->SetX(5);
    $this->CellFitSpace(42,3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])),0,1);

    }

    $this->SetX(5);
    $this->CellFitSpace(42, 3,$reg[0]['direcsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº DE ACTIVIDAD: '.$reg[0]['nroactividadsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº TLF: '.utf8_decode($reg[0]['tlfsucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($reg[0]['correosucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'OBLIGADO A LLEVAR CONTABILIDAD: '.utf8_decode($reg[0]['llevacontabilidad']), 0 , 0); 
      
    //Bloque datos de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(48, 5, 57, 35, '1.5', "");

    $this->SetFont('Courier','B',10);
    $this->SetXY(48, 4);
    $this->Cell(5, 7, 'FACTURA DE VENTA', 0 , 0);

    $this->SetFont('Courier','B',7);
    $this->SetXY(48, 7);
    $this->Cell(5, 7, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetXY(78, 7);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetXY(48, 10);
    $this->SetFont('Courier','B',8);
    $this->Cell(5, 7, 'Nº DE FACTURA', 0 , 0);
    $this->SetXY(78, 10);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['codventa']), 0, 0);

    $this->SetXY(48, 13);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'NÚMERO DE AUTORIZACIÓN:', 0, 0);
    $this->SetXY(48, 16);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['codautorizacion']), 0, 0);

    $this->SetXY(48, 19);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'NÚMERO DE SERIE:', 0, 0);
    $this->SetXY(48, 22);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['codserie']), 0, 0);

    $this->SetXY(48, 25);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE AUTORIZACIÓN:", 0, 0);
    $this->SetXY(78, 25);
    $this->Cell(28, 7,$fecha = ($reg[0]['fechaautorsucursal'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal']))), 0, 0);

    $this->SetXY(48, 28);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE VENTA:", 0, 0);
    $this->SetXY(78, 28);
    $this->Cell(28, 7,date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])), 0, 0);


    $this->SetXY(48, 31);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'AMBIENTE: ', 0 , 0);
    $this->SetXY(78, 31);
    $this->Cell(28, 7,'PRODUCCIÓN', 0 , 0);

    $this->SetXY(48, 34);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'EMISIÓN: ', 0 , 0);
    $this->SetXY(78, 34);
    $this->Cell(28, 7,'NORMAL', 0 , 0);
     
    //Bloque datos de cliente
    $this->SetLineWidth(0.3);
    $this->SetFillColor(192);
    $this->RoundedRect(5, 41, 100, 10, '1.5', "");
    $this->SetFont('Courier','B',6);

    $this->SetXY(6, 40.2);
    $this->CellFitSpace(66, 5,'RAZÓN SOCIAL: '.utf8_decode($reg[0]['codpaciente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nompaciente']." ".$reg[0]['apepaciente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE '.$documento = ($reg[0]['documpaciente'] == '0' ? "Nº DOC:" : "Nº ".$reg[0]['documento3'].": ").$dni = ($reg[0]['cedpaciente'] == '' ? "**********" : $reg[0]['cedpaciente']), 0, 0);

    $this->SetXY(6, 43.2);
    $this->CellFitSpace(66, 5,'DIRECCIÓN: '.utf8_decode($reg[0]['direcpaciente'] == '' ? "**********" : $reg[0]['direcpaciente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE TLF: '.($reg[0]['tlfpaciente'] == '' ? "**********" : $reg[0]['tlfpaciente']), 0, 0);

    $this->SetXY(6, 46.2);
    $this->CellFitSpace(92, 5,'EMAIL: '.utf8_decode($reg[0]['emailpaciente'] == '' ? "**********" : $reg[0]['emailpaciente']), 0, 0);

    $this->Ln(6);
    $this->SetX(5);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(5,3,'N°',1,0,'C', True);
    $this->Cell(50,3,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(12,3,'CANTIDAD',1,0,'C', True);
    $this->Cell(14,3,'PRECIO',1,0,'C', True);
    $this->Cell(19,3,'IMPORTE',1,1,'C', True);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(5,50,12,14,19));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];
    $simbolo = $reg[0]["simbolo"]." ";

    $this->SetX(5);
    $this->SetDrawColor(3,3,3);
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->SetLineWidth(.2);
    $this->SetFont('Courier',"",6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture2(array($a++,portales(utf8_decode($detalle[$i]["producto"])),utf8_decode($detalle[$i]['cantventa']),utf8_decode(number_format($detalle[$i]["precioventa"], 2, '.', ',')),utf8_decode(number_format($detalle[$i]['valorneto'], 2, '.', ','))));
       
    }
     
    $this->Ln(1);
    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3,'INFORMACIÓN ADICIONAL',1,0,'C');
    $this->Cell(2,3,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,'SUBTOTAL ',1,0,'L', True);
    $this->CellFitSpace(19,3,$simbolo.number_format($SubTotal, 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3,'Nº DE CAJA: '.utf8_decode($reg[0]['nrocaja']."-".$reg[0]['nomcaja']),1,0,'L');
    $this->Cell(2,3,"",0,0,'C');
    $this->CellFitSpace(20,3,'GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3,$simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3,'CAJERO(A): '.utf8_decode($reg[0]['nombres']),1,0,'L');
    $this->Cell(2,3,"",0,0,'C');
    $this->CellFitSpace(20,3,'EXENTO (0%):',1,0,'L', True);
    $this->CellFitSpace(19,3,$simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3,'FECHA DE EMISIÓN: '.date("d-m-Y H:i:s"),1,0,'L');

    $this->Cell(2,3,"",0,0,'C');
    $this->CellFitSpace(20,3,$impuesto == '' ? "IMPUESTO" : "".$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(19,3,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3,'CONDICIÓN DE PAGO: '.utf8_decode($reg[0]['tipopago'])."          ".utf8_decode($reg[0]['tipopago'] == 'CONTADO' ? "" : "VENCIMIENTO: ".date("d-m-Y",strtotime($reg[0]['fechavencecredito']))),1,0,'L');
    $this->Cell(2,3,"",0,0,'C');
    $this->CellFitSpace(20,3,'DESCONTADO %:',1,0,'L', True);
    $this->CellFitSpace(19,3,$simbolo.number_format($reg[0]["descontado"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3,'MEDIO DE PAGO: '.utf8_decode($medio = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['formapago'] : $reg[0]['formapago'])),1,0,'L');
    $this->Cell(2,3,"",0,0,'C');
    $this->CellFitSpace(20,3,'DESC % ('.number_format($reg[0]["descuento"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3,$simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(59,3,'',0,0,'L');
    $this->Cell(2,3,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->Cell(20,3,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(19,3,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetX(5);
    $this->SetDrawColor(3,3,3);
    $this->SetFont('Courier','BI',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(100,2,'MONTO EN LETRAS: '.utf8_decode(numtoletras($reg[0]['totalpago'])),0,0,'L');
    $this->Ln();
}  
########################## FUNCION FACTURA VENTA (MITAD) ##############################

########################## FUNCION FACTURA VENTA (A4) ##############################
function FacturaVenta3()
    {  
   
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
  
    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
             
        if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 12, 11, 55, 15, "PNG");

        } elseif (file_exists("./fotos/logo_principal.png")) {

        $logo = "./fotos/logo_principal.png";
        $this->Image($logo, 12, 11, 55, 15, "PNG");

        } else {

        $logo = "./assets/images/null.png";                         
        $this->Image($logo, 12, 11, 55, 15, "PNG");  

        }                                      
    }

    ############################ BLOQUE N° 1 FACTURA ###################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
    
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', 'F');

    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'V', 0 , 0);
    $this->SetFont('courier','B',8);
    $this->SetXY(99, 19);
    $this->Cell(20, 5, 'Venta', 0, 0);
    
    $this->SetFont('courier','B',11);
    $this->SetXY(124, 10);
    $this->Cell(34, 5, 'N° DE FACTURA ', 0, 0);
    $this->SetFont('courier','B',11);
    $this->SetXY(158, 10);
    $this->CellFitSpace(40, 5,utf8_decode($reg[0]['codventa']), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 14);
    $this->Cell(34, 4, 'FECHA DE VENTA ', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(158, 14);
    $this->Cell(40, 4,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechaventa']))), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 18);
    $this->Cell(34, 4, 'FECHA DE EMISIÓN', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(158, 18);
    $this->Cell(40, 4,utf8_decode(date("d-m-Y h:i:s")), 0, 0, "R");
    
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 22);
    $this->Cell(34, 4, 'ESTADO DE PAGO', 0, 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(158, 22);
    
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
    $this->Cell(40, 4,utf8_decode($reg[0]['statusventa']), 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->Cell(40, 4,utf8_decode($reg[0]['statusventa']), 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->Cell(40, 4,utf8_decode("VENCIDA"), 0, 0, "R");
    }
    ############################## BLOQUE N° 1 FACTURA ###############################

    ############################### BLOQUE N° 2 SUCURSAL ##############################   
    //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 28, 190, 18, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',9);
    $this->SetXY(11, 29);
    $this->Cell(186, 4, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 33);
    $this->Cell(25, 4, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 33);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 33);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 33);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 33);
    $this->Cell(18, 4, 'TELÉFONO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 33);
    $this->Cell(28, 4,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 37);
    $this->Cell(25, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 37);
    $this->CellFitSpace(82, 4,utf8_decode($departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(118, 37);
    $this->Cell(34, 4, 'CORREO ELECTRÓNICO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(152, 37);
    $this->Cell(46, 4,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 41);
    $this->Cell(25, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 41);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 41);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 41);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['dniencargado']), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ############################### BLOQUE N° 2 SUCURSAL ###############################

    ################################# BLOQUE N° 3 PACIENTE ################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 47, 190, 14, '1.5', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(11, 48);
    $this->Cell(186, 4, 'DATOS DE PACIENTE ', 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 52);
    $this->Cell(21, 4, 'SEÑOR(A):', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 52);
    $this->CellFitSpace(70, 4,utf8_decode($nombre = ($reg[0]['nompaciente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nompaciente']." ".$reg[0]['apepaciente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 52);
    $this->CellFitSpace(20, 4, 'Nº DE '.$documento = ($reg[0]['documpaciente'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(122, 52);
    $this->CellFitSpace(22, 4,utf8_decode($nombre = ($reg[0]['cedpaciente'] == '' ? "*********" : $reg[0]['cedpaciente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 52);
    $this->Cell(24, 4, 'TELÉFONO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 52);
    $this->CellFitSpace(30, 4,utf8_decode($email = ($reg[0]['tlfpaciente'] == '' ? "*********" : $reg[0]['tlfpaciente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 56);
    $this->Cell(21, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 56);
    $this->CellFitSpace(112, 4,getSubString(utf8_decode($departamento = ($reg[0]['departamento2'] == '' ? "" : $reg[0]['departamento2'])." ".$provincia = ($reg[0]['provincia2'] == '' ? "" : $reg[0]['provincia2'])." ".$reg[0]['direcpaciente']), 70), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 56);
    $this->Cell(24, 4, 'ESTADO CIVIL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 56);
    $this->CellFitSpace(30, 4,utf8_decode($tlf = ($reg[0]['estadopaciente'] == '' ? "*********" : $reg[0]['estadopaciente'])), 0, 0); 
    ################################# BLOQUE N° 3 PACIENTE ################################  

    ################################# BLOQUE N° 4 ESPECIALISTA ################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 62, 190, 14, '1.5', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(11, 63);
    $this->Cell(186, 4, 'DATOS DE ESPECIALISTA ', 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 67);
    $this->Cell(21, 4, 'SEÑOR(A):', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 67);
    $this->CellFitSpace(70, 4,utf8_decode($nombre = ($reg[0]['nomespecialista'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomespecialista'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 67);
    $this->CellFitSpace(20, 4, 'Nº DE '.$documento = ($reg[0]['documespecialista'] == '0' ? "DOC.:" : $reg[0]['documento4'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(122, 67);
    $this->CellFitSpace(22, 4,utf8_decode($nombre = ($reg[0]['cedespecialista'] == '' ? "*********" : $reg[0]['cedespecialista'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 67);
    $this->Cell(24, 4, 'TELÉFONO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 67);
    $this->CellFitSpace(30, 4,utf8_decode($email = ($reg[0]['tlfespecialista'] == '' ? "*********" : $reg[0]['tlfespecialista'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 71);
    $this->Cell(21, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 71);
    $this->CellFitSpace(112, 4,getSubString(utf8_decode($departamento = ($reg[0]['departamento3'] == '' ? "" : $reg[0]['departamento3'])." ".$provincia = ($reg[0]['provincia3'] == '' ? "" : $reg[0]['provincia3'])." ".$reg[0]['direcespecialista']), 70), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 71);
    $this->Cell(24, 4, 'ESPECIALIDAD:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 71);
    $this->CellFitSpace(30, 4,utf8_decode($tlf = ($reg[0]['especialidad'] == '' ? "*********" : $reg[0]['especialidad'])), 0, 0);
    ################################# BLOQUE N° 3 ESPECIALISTA ################################   

    ################################# BLOQUE N° 4 #######################################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 78, 190, 170, '0', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(10, 77);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(8, 6,"Nº", 1, 0, 'C', True);
    $this->Cell(40, 6,"DETALLE", 1, 0, 'C', True);
    $this->Cell(22, 6,"MARCA", 1, 0, 'C', True);
    $this->Cell(22, 6,"U/MEDIDA", 1, 0, 'C', True);
    $this->Cell(10, 6,"CANT", 1, 0, 'C', True);
    $this->Cell(23, 6,"P/UNIT", 1, 0, 'C', True);
    $this->Cell(24, 6,"V/TOTAL", 1, 0, 'C', True);
    $this->Cell(15, 6,"% DCTO", 1, 0, 'C', True);
    $this->Cell(26, 6,"V/NETO", 1, 1, 'C', True);
    $this->Ln(1);
    ################################# BLOQUE N° 4 ####################################### 

    ################################# BLOQUE N° 5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(7,40,22,22,10,23,24,15,25));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];
    $simbolo = $reg[0]['simbolo']." ";

    $this->SetX(11);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es BLANCO)
    $this->RowFacture(array($a++,
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["nommarca"] == '' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["nommedida"] == '' ? "******" : $detalle[$i]["nommedida"]),
        utf8_decode($detalle[$i]["cantventa"]),
        utf8_decode($simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }
    ################################# BLOQUE N° 5 ####################################### 

    ########################### BLOQUE N° 7 #############################    
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 250, 108, 26, '1.5', '');

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 250);
    $this->Cell(105, 4, 'INFORMACIÓN ADICIONAL', 0, 0, 'C');
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 254);
    $this->Cell(33, 3, 'CANTIDAD PRODUCTOS:', 0, 0);
    $this->SetXY(44, 254);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(15, 3,utf8_decode($cantidad), 0, 0);
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(59, 254);
    $this->Cell(28, 3, 'TIPO DOCUMENTO:', 0, 0);
    $this->SetXY(87, 254);
    $this->SetFont('courier','',7.5);
    $this->Cell(30, 3,"FACTURA", 0, 0);

    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 257);
    $this->Cell(33, 3, 'NOMBRE DE CAJERO:', 0, 0);
    $this->SetXY(44, 257);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(73, 3,utf8_decode($reg[0]['nombres']), 0, 0);
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 260);
    $this->Cell(33, 3, 'TIPO DE PAGO:', 0, 0);
    $this->SetXY(44, 260);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(18, 3,utf8_decode($reg[0]['tipopago']), 0, 0);
    
if($reg[0]['tipopago']=="CREDITO"){

   //Linea de membrete Nro 5
    $this->SetFont('courier','B',7.5);
    $this->SetXY(62, 260);
    $this->Cell(16, 3, 'F. VENC:', 0, 0);
    $this->SetXY(78, 260);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(20, 3,utf8_decode($vence = ( $reg[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($reg[0]['fechavencecredito'])))), 0, 0);
    
    //Linea de membrete Nro 6
    $this->SetFont('courier','B',7.5);
    $this->SetXY(98, 260);
    $this->Cell(10, 3, 'DIAS:', 0, 0);
    $this->SetXY(108, 260);
    $this->SetFont('courier','',7.5);
    
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
    $this->CellFitSpace(9, 3,utf8_decode("0"), 0, 0);
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->CellFitSpace(9, 3,utf8_decode("0"), 0, 0);
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->CellFitSpace(9, 3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])), 0, 0);
    }
}
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 263);
    $this->Cell(33, 3, 'MEDIO DE PAGO:', 0, 0);
    $this->SetXY(44, 263);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(38, 3,utf8_decode($variable = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['formapago']."(".$simbolo.$reg[0]["montopagado"].")" : $reg[0]['formapago'])), 0, 0);

    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 266);
    $this->MultiCell(106,4,$this->SetFont('Courier','',7).utf8_decode(numtoletras($reg[0]['totalpago'])), 0,'J');

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 269);
    $this->MultiCell(106,3,$this->SetFont('Courier','',7.5).utf8_decode($reg[0]["observaciones"]=="" ? "" : "OBSERVACIONES: ".$reg[0]["observaciones"]), 0,'J');


    ########################### BLOQUE N° 7 #############################  

    ################################# BLOQUE N° 8 #######################################  
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(120, 250, 80, 26, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 252);
    $this->CellFitSpace(38, 3, 'SUBTOTAL:', 0, 0);
    $this->SetXY(158, 252);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 255);
    $this->CellFitSpace(38, 3, 'GRAVADO ('.$reg[0]["iva"].'%):', 0, 0);
    $this->SetXY(158, 255);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 258);
    $this->CellFitSpace(38, 3, 'EXENTO (0%):', 0, 0);
    $this->SetXY(158, 258);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 261);
    $this->CellFitSpace(38, 3,$impuesto == '' ? "TOTAL IMP." : "TOTAL ".$imp[0]['nomimpuesto']." (".$reg[0]["iva"]."%):", 0, 0);
    $this->SetXY(158, 261);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 264);
    $this->CellFitSpace(38, 3, 'DESCONTADO %:', 0, 0);
    $this->SetXY(158, 264);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 267);
    $this->CellFitSpace(38, 3, "DESC. GLOBAL (".$reg[0]["descuento"].'%):', 0, 0);
    $this->SetXY(158, 267);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',10);
    $this->SetXY(120, 271);
    $this->CellFitSpace(38, 3, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(158, 271);
    $this->SetFont('courier','B',9);
    $this->CellFitSpace(42, 4,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')), 0, 0, "R");
    ################################# BLOQUE N° 8 #######################################
}
########################## FUNCION FACTURA VENTA (A4) ##############################

########################## FUNCION NOTA VENTA A4 ##############################
function NotaVenta()
    {  
   
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
  
    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
             
        if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "./fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 12, 11, 55, 15, "PNG");

        } elseif (file_exists("./fotos/logo_principal.png")) {

        $logo = "./fotos/logo_principal.png";
        $this->Image($logo, 12, 11, 55, 15, "PNG");

        } else {

        $logo = "./assets/images/null.png";                         
        $this->Image($logo, 12, 11, 55, 15, "PNG");  

        }                                      
    }

    ############################ BLOQUE N° 1 FACTURA ###################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
    
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', 'F');

    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', '');

    $this->SetFont('courier','B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'N', 0 , 0);
    $this->SetFont('courier','B',8);
    $this->SetXY(99.5, 19);
    $this->Cell(20, 5, 'Nota', 0, 0);
    
    $this->SetFont('courier','B',11);
    $this->SetXY(124, 10);
    $this->Cell(34, 5, 'N° NOTA DE VENTA', 0, 0);
    $this->SetFont('courier','B',11);
    $this->SetXY(158, 10);
    $this->CellFitSpace(40, 5,utf8_decode($reg[0]['codventa']), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 14);
    $this->Cell(34, 4, 'FECHA DE VENTA ', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(158, 14);
    $this->Cell(40, 4,utf8_decode(date("d-m-Y",strtotime($reg[0]['fechaventa']))), 0, 0, "R");

    $this->SetFont('courier','B',9);
    $this->SetXY(124, 18);
    $this->Cell(34, 4, 'FECHA DE EMISIÓN', 0, 0);
    $this->SetFont('courier','',9);
    $this->SetXY(158, 18);
    $this->Cell(40, 4,utf8_decode(date("d-m-Y H:i:s")), 0, 0, "R");
    
    $this->SetFont('courier','B',9);
    $this->SetXY(124, 22);
    $this->Cell(34, 4, 'ESTADO DE PAGO', 0, 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(158, 22);
    
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
    $this->Cell(40, 4,utf8_decode($reg[0]['statusventa']), 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->Cell(40, 4,utf8_decode($reg[0]['statusventa']), 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->Cell(40, 4,utf8_decode("VENCIDA"), 0, 0, "R");
    }
    ############################## BLOQUE N° 1 FACTURA ###############################

    ############################### BLOQUE N° 2 SUCURSAL ##############################   
   //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 28, 190, 18, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',9);
    $this->SetXY(11, 29);
    $this->Cell(186, 4, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 33);
    $this->Cell(25, 4, 'RAZÓN SOCIAL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 33);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 33);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 33);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(152, 33);
    $this->Cell(18, 4, 'TELÉFONO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(170, 33);
    $this->Cell(28, 4,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 37);
    $this->Cell(25, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 37);
    $this->CellFitSpace(82, 4,utf8_decode($departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(118, 37);
    $this->Cell(34, 4, 'CORREO ELECTRÓNICO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(152, 37);
    $this->Cell(46, 4,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',8);
    $this->SetXY(11, 41);
    $this->Cell(25, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(36, 41);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 41);
    $this->CellFitSpace(22, 4, 'Nº DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(124, 41);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['dniencargado']), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ############################### BLOQUE N° 2 SUCURSAL ###############################

    ################################# BLOQUE N° 3 PACIENTE ################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 47, 190, 14, '1.5', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(11, 48);
    $this->Cell(186, 4, 'DATOS DE PACIENTE ', 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 52);
    $this->Cell(21, 4, 'SEÑOR(A):', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 52);
    $this->CellFitSpace(70, 4,utf8_decode($nombre = ($reg[0]['nompaciente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nompaciente']." ".$reg[0]['apepaciente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 52);
    $this->CellFitSpace(20, 4, 'Nº DE '.$documento = ($reg[0]['documpaciente'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(122, 52);
    $this->CellFitSpace(22, 4,utf8_decode($nombre = ($reg[0]['cedpaciente'] == '' ? "*********" : $reg[0]['cedpaciente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 52);
    $this->Cell(24, 4, 'TELÉFONO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 52);
    $this->CellFitSpace(30, 4,utf8_decode($email = ($reg[0]['tlfpaciente'] == '' ? "*********" : $reg[0]['tlfpaciente'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 56);
    $this->Cell(21, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 56);
    $this->CellFitSpace(112, 4,getSubString(utf8_decode($departamento = ($reg[0]['departamento2'] == '' ? "" : $reg[0]['departamento2'])." ".$provincia = ($reg[0]['provincia2'] == '' ? "" : $reg[0]['provincia2'])." ".$reg[0]['direcpaciente']), 70), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 56);
    $this->Cell(24, 4, 'ESTADO CIVIL:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 56);
    $this->CellFitSpace(30, 4,utf8_decode($tlf = ($reg[0]['estadopaciente'] == '' ? "*********" : $reg[0]['estadopaciente'])), 0, 0); 
    ################################# BLOQUE N° 3 PACIENTE ################################  

    ################################# BLOQUE N° 4 ESPECIALISTA ################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 62, 190, 14, '1.5', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(11, 63);
    $this->Cell(186, 4, 'DATOS DE ESPECIALISTA ', 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 67);
    $this->Cell(21, 4, 'SEÑOR(A):', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 67);
    $this->CellFitSpace(70, 4,utf8_decode($nombre = ($reg[0]['nomespecialista'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomespecialista'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(102, 67);
    $this->CellFitSpace(20, 4, 'Nº DE '.$documento = ($reg[0]['documespecialista'] == '0' ? "DOC.:" : $reg[0]['documento4'].":"), 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(122, 67);
    $this->CellFitSpace(22, 4,utf8_decode($nombre = ($reg[0]['cedespecialista'] == '' ? "*********" : $reg[0]['cedespecialista'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 67);
    $this->Cell(24, 4, 'TELÉFONO:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 67);
    $this->CellFitSpace(30, 4,utf8_decode($email = ($reg[0]['tlfespecialista'] == '' ? "*********" : $reg[0]['tlfespecialista'])), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 71);
    $this->Cell(21, 4, 'DIRECCIÓN:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(32, 71);
    $this->CellFitSpace(112, 4,getSubString(utf8_decode($departamento = ($reg[0]['departamento3'] == '' ? "" : $reg[0]['departamento3'])." ".$provincia = ($reg[0]['provincia3'] == '' ? "" : $reg[0]['provincia3'])." ".$reg[0]['direcespecialista']), 70), 0, 0);

    $this->SetFont('courier','B',8);
    $this->SetXY(144, 71);
    $this->Cell(24, 4, 'ESPECIALIDAD:', 0, 0);
    $this->SetFont('courier','',8);
    $this->SetXY(168, 71);
    $this->CellFitSpace(30, 4,utf8_decode($tlf = ($reg[0]['especialidad'] == '' ? "*********" : $reg[0]['especialidad'])), 0, 0);
    ################################# BLOQUE N° 3 ESPECIALISTA ################################   

    ################################# BLOQUE N° 4 #######################################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 78, 190, 170, '0', '');

    $this->SetFont('courier','B',9);
    $this->SetXY(10, 77);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(8, 6,"Nº", 1, 0, 'C', True);
    $this->Cell(40, 6,"DETALLE", 1, 0, 'C', True);
    $this->Cell(22, 6,"MARCA", 1, 0, 'C', True);
    $this->Cell(22, 6,"U/MEDIDA", 1, 0, 'C', True);
    $this->Cell(10, 6,"CANT", 1, 0, 'C', True);
    $this->Cell(23, 6,"P/UNIT", 1, 0, 'C', True);
    $this->Cell(24, 6,"V/TOTAL", 1, 0, 'C', True);
    $this->Cell(15, 6,"% DCTO", 1, 0, 'C', True);
    $this->Cell(26, 6,"V/NETO", 1, 1, 'C', True);
    $this->Ln(1);
    ################################# BLOQUE N° 4 ####################################### 

    ################################# BLOQUE N° 5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(7,40,22,22,10,23,24,15,25));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];
    $simbolo = $reg[0]['simbolo']." ";

    $this->SetX(11);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es BLANCO)
    $this->RowFacture(array($a++,
        portales(utf8_decode($detalle[$i]["producto"])),
        utf8_decode($detalle[$i]["nommarca"] == '' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["nommedida"] == '' ? "******" : $detalle[$i]["nommedida"]),
        utf8_decode($detalle[$i]["cantventa"]),
        utf8_decode($simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }
    ################################# BLOQUE N° 5 ####################################### 

    ########################### BLOQUE N° 7 #############################    
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 250, 108, 26, '1.5', '');

    $this->SetFont('courier','B',8);
    $this->SetXY(11, 250);
    $this->Cell(105, 4, 'INFORMACIÓN ADICIONAL', 0, 0, 'C');
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 254);
    $this->Cell(33, 3, 'CANTIDAD PRODUCTOS:', 0, 0);
    $this->SetXY(44, 254);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(15, 3,utf8_decode($cantidad), 0, 0);
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(59, 254);
    $this->Cell(28, 3, 'TIPO DOCUMENTO:', 0, 0);
    $this->SetXY(87, 254);
    $this->SetFont('courier','',7.5);
    $this->Cell(30, 3,"NOTA DE VENTA", 0, 0);

    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 257);
    $this->Cell(33, 3, 'NOMBRE DE CAJERO:', 0, 0);
    $this->SetXY(44, 257);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(73, 3,utf8_decode($reg[0]['nombres']), 0, 0);
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 260);
    $this->Cell(33, 3, 'TIPO DE PAGO:', 0, 0);
    $this->SetXY(44, 260);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(18, 3,utf8_decode($reg[0]['tipopago']), 0, 0);
    
   if($reg[0]['tipopago']=="CREDITO"){

   //Linea de membrete Nro 5
    $this->SetFont('courier','B',7.5);
    $this->SetXY(62, 260);
    $this->Cell(16, 3, 'F. VENC:', 0, 0);
    $this->SetXY(78, 260);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(20, 3,utf8_decode($vence = ( $reg[0]['fechavencecredito'] == '0000-00-00' ? "0" : date("d-m-Y",strtotime($reg[0]['fechavencecredito'])))), 0, 0);
    
    //Linea de membrete Nro 6
    $this->SetFont('courier','B',7.5);
    $this->SetXY(98, 260);
    $this->Cell(10, 3, 'DIAS:', 0, 0);
    $this->SetXY(108, 260);
    $this->SetFont('courier','',7.5);
    
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
    $this->CellFitSpace(9, 3,utf8_decode("0"), 0, 0);
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->CellFitSpace(9, 3,utf8_decode("0"), 0, 0);
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->CellFitSpace(9, 3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])), 0, 0);
    }
    }
    
    $this->SetFont('courier','B',7.5);
    $this->SetXY(11, 263);
    $this->Cell(33, 3, 'MEDIO DE PAGO:', 0, 0);
    $this->SetXY(44, 263);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(38, 3,utf8_decode($reg[0]['formapago']), 0, 0);

    if($reg[0]["tipopago"]=="CREDITO"){

    $this->SetFont('courier','B',7.5);
    $this->SetXY(82, 263);
    $this->Cell(18, 3, 'D. ABONAR:', 0, 0);
    $this->SetXY(100, 263);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(17, 3,utf8_decode($simbolo.number_format($reg[0]["totalpago"] - $reg[0]["montopagado"], 2, '.', ',')), 0, 0);

    } else {

    $this->SetFont('courier','B',7.5);
    $this->SetXY(82, 263);
    $this->Cell(18, 3, 'CAMBIO:', 0, 0);
    $this->SetXY(100, 263);
    $this->SetFont('courier','',7.5);
    $this->CellFitSpace(17, 3,utf8_decode($simbolo.$reg[0]['montodevuelto']), 0, 0);
    
    }

    $this->SetFont('courier','B',7);
    $this->SetXY(11, 266);
    $this->MultiCell(105,3,$this->SetFont('Courier','',7).utf8_decode(numtoletras($reg[0]['totalpago'])),0,'L');

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',7);
    $this->SetXY(11, 269);
    $this->MultiCell(106,3,$this->SetFont('Courier','',7).utf8_decode($reg[0]["observaciones"]=="" ? "" : "OBSERVACIONES: ".$reg[0]["observaciones"]), 0,'J');
    ########################### BLOQUE N° 7 #############################  

    ################################# BLOQUE N° 8 #######################################  
    //Bloque de Totales de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(120, 250, 80, 26, '1.5', '');

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 252);
    $this->CellFitSpace(38, 3, 'SUBTOTAL:', 0, 0);
    $this->SetXY(158, 252);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($SubTotal, 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 255);
    $this->CellFitSpace(38, 3, 'GRAVADO ('.$reg[0]["iva"].'%):', 0, 0);
    $this->SetXY(158, 255);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 258);
    $this->CellFitSpace(38, 3, 'EXENTO (0%):', 0, 0);
    $this->SetXY(158, 258);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 261);
    $this->CellFitSpace(38, 3,$impuesto == '' ? "TOTAL IMP." : "TOTAL ".$imp[0]['nomimpuesto']." (".$reg[0]["iva"]."%):", 0, 0);
    $this->SetXY(158, 261);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["totaliva"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 264);
    $this->CellFitSpace(38, 3, 'DESCONTADO %:', 0, 0);
    $this->SetXY(158, 264);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["descontado"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',8.5);
    $this->SetXY(120, 267);
    $this->CellFitSpace(38, 3, "DESC. GLOBAL (".$reg[0]["descuento"].'%):', 0, 0);
    $this->SetXY(158, 267);
    $this->SetFont('courier','',8.5);
    $this->CellFitSpace(42, 3,utf8_decode($simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ',')), 0, 0, "R");

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',10);
    $this->SetXY(120, 271);
    $this->CellFitSpace(38, 3, 'IMPORTE TOTAL:', 0, 0);
    $this->SetXY(158, 271);
    $this->SetFont('courier','B',9);
    $this->CellFitSpace(42, 4,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')), 0, 0, "R");
    ################################# BLOQUE N° 8 #######################################  

}
########################## FUNCION NOTA VENTA A4 ##############################

########################## FUNCION NOTA VENTA A5 ##############################
function NotaVenta2()
    {  
   
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
  
    
}
########################## FUNCION NOTA VENTA A5 ##############################

########################## FUNCION LISTAR VENTAS ##############################
function TablaListarVentas()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->ListarVentas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE FACTURACIONES',0,0,'C');

   if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(45,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(30,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(30,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(25,8,'MÉTODO',1,0,'C', True);
    $this->Cell(25,8,'FECHA EM.',1,0,'C', True);
    $this->Cell(30,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,$impuesto,1,0,'C', True);
    $this->Cell(20,8,'DESC%',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,45,30,30,50,25,25,30,30,20,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomsucursal"])),utf8_decode($reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]),utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode($reg[$i]["formapago"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(20,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(30,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(65,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(35,8,'MÉTODO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,30,65,35,30,35,35,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]),utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode($reg[$i]["formapago"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(205,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS ##############################

########################## FUNCION LISTAR VENTAS POR CAJAS ##############################
function TablaListarVentasxCajas()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarVentasxCajas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE FACTURACIONES POR CAJAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº CAJA: ".utf8_decode($reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"RESPONSABLE DE CAJA: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(85,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(35,8,'MÉTODO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESC%',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,85,35,30,35,35,30,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode($reg[$i]["formapago"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(195,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR CAJAS ##############################

########################## FUNCION LISTAR VENTAS POR FECHAS ##############################
function TablaListarVentasxFechas()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarVentasxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE FACTURACIONES POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(30,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(65,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(35,8,'MÉTODO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,30,65,35,30,35,35,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]),utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode($reg[$i]["formapago"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(205,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR FECHAS ##############################

########################## FUNCION LISTAR VENTAS POR ESPECIALISTA ##############################
function TablaListarVentasxEspecialista()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarVentasxEspecialista();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE FACTURACIONES POR ESPECIALISTA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[0]['documento4']))." ESPECIALISTA: ".utf8_decode($reg[0]["cedespecialista"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESPECIALISTA: ".portales(utf8_decode($reg[0]['nomespecialista'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESPECIALIDAD: ".portales(utf8_decode($reg[0]['especialidad'])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(45,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(35,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(30,8,'MÉTODO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(25,8,$impuesto,1,0,'C', True);
    $this->Cell(25,8,'DESC%',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,45,35,55,30,35,35,25,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]),utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode($reg[$i]["formapago"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR ESPECIALISTA ##############################

########################## FUNCION LISTAR VENTAS POR PACIENTE ##############################
function TablaListarVentasxPaciente()
   {
    
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == '' ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->BuscarVentasxPaciente();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE FACTURACIONES POR PACIENTE',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PACIENTE: ".utf8_decode($reg[0]["cedpaciente"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PACIENTE: ".portales(utf8_decode($reg[0]['nompaciente']." ".$reg[0]['apepaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"GRUPO SANG: ".portales(utf8_decode($reg[0]['gruposapaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"Nº DE TELÉFONO: ".portales(utf8_decode($reg[0]['tlfpaciente'] == '' ? "********" : $reg[0]['tlfpaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"FECHA NACIMIENTO: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : date("d-m-Y",strtotime($reg[0]['fnacpaciente'])))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"EDAD: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : edad($reg[0]['fnacpaciente']))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESTADO CIVIL: ".portales(utf8_decode($reg[0]['estadopaciente'] == '' ? "********" : $reg[0]['estadopaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"OCUPACIÓN: ".portales(utf8_decode($reg[0]['ocupacionpaciente'] == '' ? "********" : $reg[0]['ocupacionpaciente'])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(50,8,'Nº DE CAJA',1,0,'C', True);
    $this->Cell(35,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(50,8,'MÉTODO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(40,8,$impuesto,1,0,'C', True);
    $this->Cell(30,8,'DESC%',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,50,35,50,35,40,40,30,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos=0;
    $TotalSubtotal=0;
    $TotalIva=0;
    $TotalDescuento=0;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    
    $TotalArticulos+=$reg[$i]['articulos'];
    $TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
    $TotalIva+=$reg[$i]['totaliva'];
    $TotalDescuento+=$reg[$i]['totaldescuento'];
    $TotalImporte+=$reg[$i]['totalpago'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]),utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]["formapago"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
        }
   
    $this->Cell(185,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR PACIENTE ##############################

################################### REPORTES DE VENTAS ##################################































################################### REPORTES DE CREDITOS ##################################

########################## FUNCION TICKET VENTA ##############################
function TicketCredito()
    {  
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->CreditosPorId();
    $simbolo = $reg[0]['simbolo']." ";
  
     $this->SetXY(2,4);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(70,4,utf8_decode($reg[0]['nomsucursal']), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"TLF Nº: ".utf8_decode($reg[0]['tlfsucursal']), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "Nº ".$reg[0]['documento'].": ".utf8_decode($reg[0]['cuitsucursal']),0,1,'C');

    if($reg[0]['provincia']!=''){

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])),0,1,'C');

    }

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,utf8_decode($reg[0]['direcsucursal']),0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"TICKET Nº: ".utf8_decode($reg[0]['codfactura']),0,1,'C');

    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"OBLIGADO A LLEVAR CONTABILIDAD: ".utf8_decode($reg[0]['llevacontabilidad']),0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"AMBIENTE: PRODUCCIÓN",0,1,'C');
    
    $this->SetX(2);
    $this->SetFont('Courier','',9);
    $this->CellFitSpace(70,3,"EMISIÓN: NORMAL",0,1,'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,$documento = ($reg[0]['documpaciente'] == '0' ? "Nº DOC:" : "Nº ".$reg[0]['documento3'].": "),0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['cedpaciente']),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"SEÑOR(A):",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['nompaciente']." ".$reg[0]['apepaciente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"Nº TLF:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,utf8_decode($reg[0]['tlfpaciente'] == '' ? "0" : $reg[0]['tlfpaciente']),0,1,'L');

    $this->SetFont('Courier','B',10);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es BLANCO 255 GRIS 255)
    $this->Cell(10, 5,"Nº", 0, 0, 'L', True);
    $this->Cell(24, 5,"MÉTODO", 0, 0, 'L', True);
    $this->Cell(19, 5,"MONTO", 0, 0, 'L', True);
    $this->Cell(18, 5,"FECHA", 0, 1, 'L', True);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $tra = new Login();
    $detalle = $tra->VerDetallesAbonos();
    if($detalle==""){

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'NO SE ENCONTRARON ABONOS',0,0,'C');
    $this->Ln(3);

    } else {
    $cantidad=0;

    $this->SetWidths(array(10,24,19,18));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){
    
    $this->SetX(2);
    $this->SetFont('Courier','',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array(
        utf8_decode($a++),
        utf8_decode($detalle[$i]['medioabono']),
        utf8_decode($simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ',')),
        utf8_decode(date("d-m-Y H:i:s",strtotime($detalle[$i]['fechaabono']))))); 
       }
    }

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"IMPORTE TOTAL:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(38,3,utf8_decode($simbolo.number_format($reg[0]["totalpago"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"TOTAL ABONADO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(38,3,utf8_decode($simbolo.number_format($reg[0]["creditopagado"], 2, '.', ',')),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"TOTAL DEBE:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(38,3,utf8_decode($simbolo.number_format($reg[0]["totalpago"]-$reg[0]["creditopagado"], 2, '.', ',')),0,1,'R');

    $this->SetFont('Courier','B',10);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"STATUS PAGO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(38,3,utf8_decode($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[0]["statusventa"]),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"VENCE CRÉDITO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(38,3,utf8_decode(date("d-m-Y",strtotime($reg[0]["fechavencecredito"]))),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(32,3,"DIAS VENCIDOS:",0,0,'L');
    $this->SetFont('Courier','',8);

    if($reg[0]['fechavencecredito']== '0000-00-00') { 
        $this->CellFitSpace(38,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
        $this->CellFitSpace(38,3,utf8_decode("0"),0,1,'R');
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
        $this->CellFitSpace(38,3,utf8_decode(Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito'])),0,1,'R');
    }

    $this->SetFont('Courier','B',10);
    $this->SetX(2);
    $this->Cell(70,3,'--------------------------------',0,0,'C');
    $this->Ln(3); 
}
########################## FUNCION TICKET CREDITO VENTA ##############################

########################## FUNCION LISTAR CREDITOS ##############################
function TablaListarCreditos()
   {
    
    $tra = new Login();
    $reg = $tra->ListarCreditos();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE CRÉDITOS',0,0,'C');

   if($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente"){

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'SUCURSAL',1,0,'C', True);
    $this->Cell(30,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(50,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(25,8,'STATUS',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,30,50,50,25,30,35,35,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 

    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago'] - $reg[$i]['creditopagado'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,portales(utf8_decode($reg[$i]["nomsucursal"])),utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(230,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();

      }

    } else {

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(50,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(35,8,'STATUS',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,50,35,30,35,35,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 

    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago'] - $reg[$i]['creditopagado'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(230,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS ##############################

########################## FUNCION LISTAR CREDITOS POR FECHAS ##############################
function TablaListarCreditosxFechas()
   {

    $tra = new Login();
    $reg = $tra->BuscarCreditosxFechas();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE CRÉDITOS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE PACIENTE',1,0,'C', True);
    $this->Cell(50,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(35,8,'STATUS',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,50,35,30,35,35,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 

    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago'] - $reg[$i]['creditopagado'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]["nompaciente"]." ".$reg[$i]["apepaciente"])),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(230,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR FECHAS ##############################

########################## FUNCION LISTAR CREDITOS POR PACIENTE ##############################
function TablaListarCreditosxPaciente()
   {

    $tra = new Login();
    $reg = $tra->BuscarCreditosxPacientes();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE CRÉDITOS POR PACIENTE',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PACIENTE: ".utf8_decode($reg[0]["cedpaciente"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PACIENTE: ".portales(utf8_decode($reg[0]['nompaciente']." ".$reg[0]['apepaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"GRUPO SANG: ".portales(utf8_decode($reg[0]['gruposapaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"Nº DE TELÉFONO: ".portales(utf8_decode($reg[0]['tlfpaciente'] == '' ? "********" : $reg[0]['tlfpaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"FECHA NACIMIENTO: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : date("d-m-Y",strtotime($reg[0]['fnacpaciente'])))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"EDAD: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : edad($reg[0]['fnacpaciente']))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESTADO CIVIL: ".portales(utf8_decode($reg[0]['estadopaciente'] == '' ? "********" : $reg[0]['estadopaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"OCUPACIÓN: ".portales(utf8_decode($reg[0]['ocupacionpaciente'] == '' ? "********" : $reg[0]['ocupacionpaciente'])),0,0,'L');
 
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(30,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(45,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(30,8,'STATUS',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,60,45,30,35,40,40,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 

    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago'] - $reg[$i]['creditopagado'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")")),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR PACIENTE ##############################

########################## FUNCION LISTAR DETALLES CREDITOS POR PACIENTE ##############################
function TablaListarDetallesCreditosxPaciente()
   {

    $tra = new Login();
    $reg = $tra->BuscarCreditosxDetalles();

    ################################# MEMBRETE LEGAL #################################
    if($_SESSION['acceso'] == "administradorG"){

    $logo = ( file_exists("./fotos/logo_principal.png") == "" ? "./assets/images/null.png" : "./fotos/logo_principal.png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");
    
    $con = new Login();
    $con = $con->ConfiguracionPorId(); 

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'])." ".utf8_decode($con[0]['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    

    if($con[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($con[0]['id_departamento'] == '0' ? "" : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? "" : $con[0]['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($con[0]['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($con[0]['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($con[0]['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   } else { 

    $logo = ( file_exists("./fotos/sucursales/".$_SESSION['cuitsucursal'].".png") == "" ? "./assets/images/null.png" : "./fotos/sucursales/".$_SESSION['cuitsucursal'].".png");
    $logo2 = ( file_exists("./fotos/logo_pdf.png") == "" ? "./assets/images/null.png" : "./fotos/logo_pdf.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(90,5,$this->Image($logo, $this->GetX()+10, $this->GetY()+6, $GLOBALS['logo1_horizontal']),0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['nomsucursal'])),0,0,'C');
    $this->Cell(90,5,$this->Image($logo2, $this->GetX()+5, $this->GetY()+6, $GLOBALS['logo2_horizontal']),0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['documsucursal'] == '0' ? "" : $_SESSION['documento'])." ".utf8_decode($_SESSION['cuitsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    if($_SESSION['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($departamento = ($_SESSION['id_departamento'] == '0' ? "" : $_SESSION['departamento'])." ".$provincia = ($_SESSION['id_provincia'] == '0' ? "" : $_SESSION['provincia']))),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,portales(utf8_decode($_SESSION['direcsucursal'])),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,"Nº TLF: ".utf8_decode($_SESSION['tlfsucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(90,5,"",0,0,'C');
    $this->Cell(150,5,utf8_decode($_SESSION['correosucursal']),0,0,'C');
    $this->Cell(90,5,"",0,0,'C');
    $this->Ln(5);

   }
   ################################# MEMBRETE LEGAL #################################
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DETALLES DE CRÉDITOS POR PACIENTE',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($reg[0]['documento'])." SUCURSAL: ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(335,6,"Nº ".utf8_decode($documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PACIENTE: ".utf8_decode($reg[0]["cedpaciente"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PACIENTE: ".portales(utf8_decode($reg[0]['nompaciente']." ".$reg[0]['apepaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"GRUPO SANG: ".portales(utf8_decode($reg[0]['gruposapaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"Nº DE TELÉFONO: ".portales(utf8_decode($reg[0]['tlfpaciente'] == '' ? "********" : $reg[0]['tlfpaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"FECHA NACIMIENTO: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : date("d-m-Y",strtotime($reg[0]['fnacpaciente'])))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"EDAD: ".portales(utf8_decode($reg[0]['fnacpaciente'] == '0000-00-00' ? "********" : edad($reg[0]['fnacpaciente']))),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"ESTADO CIVIL: ".portales(utf8_decode($reg[0]['estadopaciente'] == '' ? "********" : $reg[0]['estadopaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"OCUPACIÓN: ".portales(utf8_decode($reg[0]['ocupacionpaciente'] == '' ? "********" : $reg[0]['ocupacionpaciente'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d-m-Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d-m-Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(44, 171, 227); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'Nº',1,0,'C', True);
    $this->Cell(25,8,'Nº FACTURA',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE ESPECIALISTA',1,0,'C', True);
    $this->Cell(40,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(55,8,'DETALLES DE FACTURA',1,0,'C', True);
    $this->Cell(25,8,'STATUS',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISIÓN',1,0,'C', True);
    $this->Cell(35,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL ABONO',1,0,'C', True);
    $this->Cell(30,8,'TOTAL DEBE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,25,50,40,55,25,30,35,35,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 

    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago'] - $reg[$i]['creditopagado'];
    $simbolo = $reg[$i]['simbolo']." ";
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")")),portales(utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones'])),portales(utf8_decode(str_replace("<br>","\n", $reg[$i]['detalles']))),utf8_decode($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]),utf8_decode(date("d-m-Y",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(240,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES CREDITOS POR PACIENTE ##############################

################################### REPORTES DE CREDITOS ##################################



























############################## REPORTES DE CREDITOS ##################################

############################### REPORTES DE CREDITOS ###############################















































###################### AQUI COMIENZA CODIGO PARA AJUSTAR TEXTO #########################

########### FUNCION PARA TRAZO DE LINEAS SEPARADAS ############
function DashedRect($x1, $y1, $x2, $y2, $width=1, $nb=15)
    {
        $this->SetLineWidth($width);
        $longueur=abs($x1-$x2);
        $hauteur=abs($y1-$y2);
        if($longueur>$hauteur) {
            $Pointilles=($longueur/$nb)/2; // length of dashes
        }
        else {
            $Pointilles=($hauteur/$nb)/2;
        }
        for($i=$x1;$i<=$x2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($x2-1)) {
                    $this->Line($j,$y1,$j+1,$y1); // upper dashes
                    $this->Line($j,$y2,$j+1,$y2); // lower dashes
                }
            }
        }
        for($i=$y1;$i<=$y2;$i+=$Pointilles+$Pointilles) {
            for($j=$i;$j<=($i+$Pointilles);$j++) {
                if($j<=($y2-1)) {
                    $this->Line($x1,$j,$x1,$j+1); // left dashes
                    $this->Line($x2,$j,$x2,$j+1); // right dashes
                }
            }
        }
    }
########### FUNCION PARA TRAZO DE LINEAS SEPARADAS ############

########### FUNCION PARA CODIGO DE BARRA CON CODE39 ############
function Code39($x, $y, $code, $ext = true, $cks = false, $w = 0.4, $h = 20, $wide = true) {

    //Display code
    $this->SetFont('Arial', '', 10);
    $this->Text($x, $y+$h+4, $code);

    if($ext) {
        //Extended encoding
        $code = $this->encode_code39_ext($code);
    }
    else {
        //Convert to upper case
        $code = strtoupper($code);
        //Check validity
        if(!preg_match('|^[0-9A-Z. $/+%-]*$|', $code))
            $this->Error('Invalid barcode value: '.$code);
    }

    //Compute checksum
    if ($cks)
        $code .= $this->checksum_code39($code);

    //Add start and stop characters
    $code = '*'.$code.'*';

    //Conversion tables
    $narrow_encoding = array (
        '0' => '101001101101', '1' => '110100101011', '2' => '101100101011', 
        '3' => '110110010101', '4' => '101001101011', '5' => '110100110101', 
        '6' => '101100110101', '7' => '101001011011', '8' => '110100101101', 
        '9' => '101100101101', 'A' => '110101001011', 'B' => '101101001011', 
        'C' => '110110100101', 'D' => '101011001011', 'E' => '110101100101', 
        'F' => '101101100101', 'G' => '101010011011', 'H' => '110101001101', 
        'I' => '101101001101', 'J' => '101011001101', 'K' => '110101010011', 
        'L' => '101101010011', 'M' => '110110101001', 'N' => '101011010011', 
        'O' => '110101101001', 'P' => '101101101001', 'Q' => '101010110011', 
        'R' => '110101011001', 'S' => '101101011001', 'T' => '101011011001', 
        'U' => '110010101011', 'V' => '100110101011', 'W' => '110011010101', 
        'X' => '100101101011', 'Y' => '110010110101', 'Z' => '100110110101', 
        '-' => '100101011011', '.' => '110010101101', ' ' => '100110101101', 
        '*' => '100101101101', '$' => '100100100101', '/' => '100100101001', 
        '+' => '100101001001', '%' => '101001001001' );

    $wide_encoding = array (
        '0' => '101000111011101', '1' => '111010001010111', '2' => '101110001010111', 
        '3' => '111011100010101', '4' => '101000111010111', '5' => '111010001110101', 
        '6' => '101110001110101', '7' => '101000101110111', '8' => '111010001011101', 
        '9' => '101110001011101', 'A' => '111010100010111', 'B' => '101110100010111', 
        'C' => '111011101000101', 'D' => '101011100010111', 'E' => '111010111000101', 
        'F' => '101110111000101', 'G' => '101010001110111', 'H' => '111010100011101', 
        'I' => '101110100011101', 'J' => '101011100011101', 'K' => '111010101000111', 
        'L' => '101110101000111', 'M' => '111011101010001', 'N' => '101011101000111', 
        'O' => '111010111010001', 'P' => '101110111010001', 'Q' => '101010111000111', 
        'R' => '111010101110001', 'S' => '101110101110001', 'T' => '101011101110001', 
        'U' => '111000101010111', 'V' => '100011101010111', 'W' => '111000111010101', 
        'X' => '100010111010111', 'Y' => '111000101110101', 'Z' => '100011101110101', 
        '-' => '100010101110111', '.' => '111000101011101', ' ' => '100011101011101', 
        '*' => '100010111011101', '$' => '100010001000101', '/' => '100010001010001', 
        '+' => '100010100010001', '%' => '101000100010001');

    $encoding = $wide ? $wide_encoding : $narrow_encoding;

    //Inter-character spacing
    $gap = ($w > 0.29) ? '00' : '0';

    //Convert to bars
    $encode = '';
    for ($i = 0; $i< strlen($code); $i++)
        $encode .= $encoding[$code[$i]].$gap;

    //Draw bars
    $this->draw_code39($encode, $x, $y, $w, $h);
}

function checksum_code39($code) {

    //Compute the modulo 43 checksum

    $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
                            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 
                            'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 
                            'W', 'X', 'Y', 'Z', '-', '.', ' ', '$', '/', '+', '%');
    $sum = 0;
    for ($i=0 ; $i<strlen($code); $i++) {
        $a = array_keys($chars, $code[$i]);
        $sum += $a[0];
    }
    $r = $sum % 43;
    return $chars[$r];
}

function encode_code39_ext($code) {

    //Encode characters in extended mode

    $encode = array(
        chr(0) => '%U', chr(1) => '$A', chr(2) => '$B', chr(3) => '$C', 
        chr(4) => '$D', chr(5) => '$E', chr(6) => '$F', chr(7) => '$G', 
        chr(8) => '$H', chr(9) => '$I', chr(10) => '$J', chr(11) => '£K', 
        chr(12) => '$L', chr(13) => '$M', chr(14) => '$N', chr(15) => '$O', 
        chr(16) => '$P', chr(17) => '$Q', chr(18) => '$R', chr(19) => '$S', 
        chr(20) => '$T', chr(21) => '$U', chr(22) => '$V', chr(23) => '$W', 
        chr(24) => '$X', chr(25) => '$Y', chr(26) => '$Z', chr(27) => '%A', 
        chr(28) => '%B', chr(29) => '%C', chr(30) => '%D', chr(31) => '%E', 
        chr(32) => ' ', chr(33) => '/A', chr(34) => '/B', chr(35) => '/C', 
        chr(36) => '/D', chr(37) => '/E', chr(38) => '/F', chr(39) => '/G', 
        chr(40) => '/H', chr(41) => '/I', chr(42) => '/J', chr(43) => '/K', 
        chr(44) => '/L', chr(45) => '-', chr(46) => '.', chr(47) => '/O', 
        chr(48) => '0', chr(49) => '1', chr(50) => '2', chr(51) => '3', 
        chr(52) => '4', chr(53) => '5', chr(54) => '6', chr(55) => '7', 
        chr(56) => '8', chr(57) => '9', chr(58) => '/Z', chr(59) => '%F', 
        chr(60) => '%G', chr(61) => '%H', chr(62) => '%I', chr(63) => '%J', 
        chr(64) => '%V', chr(65) => 'A', chr(66) => 'B', chr(67) => 'C', 
        chr(68) => 'D', chr(69) => 'E', chr(70) => 'F', chr(71) => 'G', 
        chr(72) => 'H', chr(73) => 'I', chr(74) => 'J', chr(75) => 'K', 
        chr(76) => 'L', chr(77) => 'M', chr(78) => 'N', chr(79) => 'O', 
        chr(80) => 'P', chr(81) => 'Q', chr(82) => 'R', chr(83) => 'S', 
        chr(84) => 'T', chr(85) => 'U', chr(86) => 'V', chr(87) => 'W', 
        chr(88) => 'X', chr(89) => 'Y', chr(90) => 'Z', chr(91) => '%K', 
        chr(92) => '%L', chr(93) => '%M', chr(94) => '%N', chr(95) => '%O', 
        chr(96) => '%W', chr(97) => '+A', chr(98) => '+B', chr(99) => '+C', 
        chr(100) => '+D', chr(101) => '+E', chr(102) => '+F', chr(103) => '+G', 
        chr(104) => '+H', chr(105) => '+I', chr(106) => '+J', chr(107) => '+K', 
        chr(108) => '+L', chr(109) => '+M', chr(110) => '+N', chr(111) => '+O', 
        chr(112) => '+P', chr(113) => '+Q', chr(114) => '+R', chr(115) => '+S', 
        chr(116) => '+T', chr(117) => '+U', chr(118) => '+V', chr(119) => '+W', 
        chr(120) => '+X', chr(121) => '+Y', chr(122) => '+Z', chr(123) => '%P', 
        chr(124) => '%Q', chr(125) => '%R', chr(126) => '%S', chr(127) => '%T');

    $code_ext = '';
    for ($i = 0 ; $i<strlen($code); $i++) {
        if (ord($code[$i]) > 127)
            $this->Error('Invalid character: '.$code[$i]);
        $code_ext .= $encode[$code[$i]];
    }
    return $code_ext;
}

function draw_code39($code, $x, $y, $w, $h) {

    //Draw bars

    for($i=0; $i<strlen($code); $i++) {
        if($code[$i] == '1')
            $this->Rect($x+$i*$w, $y, $w, $h, 'F');
    }
}


########### FUNCION PARA CODIGO DE BARRA CON EAN13 ############
function EAN13($x, $y, $barcode, $h=16, $w=.35)
{
 $this->Barcode($x,$y,$barcode,$h,$w,13);
}
function UPC_A($x, $y, $barcode, $h=16, $w=.35)
{
 $this->Barcode($x,$y,$barcode,$h,$w,12);
}
function GetCheckDigit($barcode)
{
 //Compute the check digit
 $sum=0;
 for($i=1;$i<=11;$i+=2)
 $sum+=3*$barcode[$i];
 for($i=0;$i<=10;$i+=2)
 $sum+=$barcode[$i];
 $r=$sum%10;
 if($r>0)
 $r=10-$r;
 return $r;
}
function TestCheckDigit($barcode)
{
 //Test validity of check digit
 $sum=0;
 for($i=1;$i<=11;$i+=2)
 $sum+=3*$barcode[$i];
 for($i=0;$i<=10;$i+=2)
 $sum+=$barcode[$i];
 return ($sum+$barcode[12])%10==0;
}
function Barcode($x, $y, $barcode, $h, $w, $len)
{
 //Padding
 $barcode=str_pad($barcode,$len-1,'0',STR_PAD_LEFT);
 if($len==12)
 $barcode='0'.$barcode;
 //Add or control the check digit
 if(strlen($barcode)==12)
 $barcode.=$this->GetCheckDigit($barcode);
 elseif(!$this->TestCheckDigit($barcode))
 $this->Error('Incorrect check digit');
 //Convert digits to bars
 $codes=array(
 'A'=>array(
 '0'=>'0001101','1'=>'0011001','2'=>'0010011','3'=>'0111101','4'=>'0100011',
 '5'=>'0110001','6'=>'0101111','7'=>'0111011','8'=>'0110111','9'=>'0001011'),
 'B'=>array(
 '0'=>'0100111','1'=>'0110011','2'=>'0011011','3'=>'0100001','4'=>'0011101',
 '5'=>'0111001','6'=>'0000101','7'=>'0010001','8'=>'0001001','9'=>'0010111'),
 'C'=>array(
 '0'=>'1110010','1'=>'1100110','2'=>'1101100','3'=>'1000010','4'=>'1011100',
 '5'=>'1001110','6'=>'1010000','7'=>'1000100','8'=>'1001000','9'=>'1110100')
 );
 $parities=array(
 '0'=>array('A','A','A','A','A','A'),
 '1'=>array('A','A','B','A','B','B'),
 '2'=>array('A','A','B','B','A','B'),
 '3'=>array('A','A','B','B','B','A'),
 '4'=>array('A','B','A','A','B','B'),
 '5'=>array('A','B','B','A','A','B'),
 '6'=>array('A','B','B','B','A','A'),
 '7'=>array('A','B','A','B','A','B'),
 '8'=>array('A','B','A','B','B','A'),
 '9'=>array('A','B','B','A','B','A')
 );
 $code='101';
 $p=$parities[$barcode[0]];
 for($i=1;$i<=6;$i++)
 $code.=$codes[$p[$i-1]][$barcode[$i]];
 $code.='01010';
 for($i=7;$i<=12;$i++)
 $code.=$codes['C'][$barcode[$i]];
 $code.='101';
 //Draw bars
 for($i=0;$i<strlen($code);$i++)
 {
 if($code[$i]=='1')
 $this->Rect($x+$i*$w,$y,$w,$h,'F');
 }
 //Print text uder barcode
 $this->SetFont('Arial','',12);
 $this->Text($x,$y+$h+11/$this->k,substr($barcode,-$len));
}



########### FUNCION PARA CREAR MULTICELL SIN SALTO DE LINEA ############
function SetWidths($w)
{
//Set the array of column widths
$this->widths=$w;
}

function SetAligns($a)
{
//Set the array of column alignments
$this->aligns=$a;
}

function Row($data)
{
//Calculate the height of the row
$nb=0;
for($i=0;$i<count($data);$i++)
$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
$h=5*$nb;
//Issue a page break first if needed
$this->CheckPageBreak($h);
//Draw the cells of the row
for($i=0;$i<count($data);$i++)
{
$w=$this->widths[$i];
$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
//Save the current position
$x=$this->GetX();
$y=$this->GetY();
//Draw the border
$this->Rect($x,$y,$w,$h);
//Print the text
$this->MultiCell($w,5,$data[$i],0,$a);
//Put the position to the right of the cell
$this->SetXY($x+$w,$y);
}
//Go to the next line
$this->Ln($h);
}

function RowFacture($data)
{
//Calculate the height of the row
$nb=0;
for($i=0;$i<count($data);$i++)
$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
$h=3.5*$nb;
//Issue a page break first if needed
$this->CheckPageBreak($h);
//Draw the cells of the row
for($i=0;$i<count($data);$i++)
{
$w=$this->widths[$i];
$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
//Save the current position
$x=$this->GetX();
$y=$this->GetY();
//Draw the border
$this->Rect($x,$y,$w,$h,0,true);
//Print the text
$this->MultiCell($w,3.5,$data[$i],0,$a);
//Put the position to the right of the cell
$this->SetXY($x+$w,$y);
}
//Go to the next line
$this->Ln($h);
}

function RowFacture2($data)
{
//Calculate the height of the row
$nb=0;
for($i=0;$i<count($data);$i++)
$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
$h=3*$nb;
//Issue a page break first if needed
$this->CheckPageBreak($h);
//Draw the cells of the row
for($i=0;$i<count($data);$i++)
{
$w=$this->widths[$i];
$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
//Save the current position
$x=$this->GetX();
$y=$this->GetY();
//Draw the border
$this->Rect($x,$y,$w,$h);
//Print the text
$this->MultiCell($w,3,$data[$i],0,$a);
//Put the position to the right of the cell
$this->SetXY($x+$w,$y);
}
//Go to the next line
$this->Ln($h);
}

function CheckPageBreak($h)
{
//If the height h would cause an overflow, add a new page immediately
if($this->GetY()+$h>$this->PageBreakTrigger)
$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
//Computes the number of lines a MultiCell of width w will take
$cw=&$this->CurrentFont['cw'];
if($w==0)
$w=$this->w-$this->rMargin-$this->x;
$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
$s=str_replace("\r",'',$txt);
$nb=strlen($s);
if($nb>0 and $s[$nb-1]=="\n")
$nb--;
$sep=-1;
$i=0;
$j=0;
$l=0;
$nl=1;
while($i<$nb)
{
$c=$s[$i];
if($c=="\n")
{
$i++;
$sep=-1;
$j=$i;
$l=0;
$nl++;
continue;
}
if($c==' ')
$sep=$i;
$l+=$cw[$c];
if($l>$wmax)
{
if($sep==-1)
{
if($i==$j)
$i++;
}
else
$i=$sep+1;
$sep=-1;
$j=$i;
$l=0;
$nl++;
}
else
$i++;
}
return $nl;
}
########### FUNCION PARA CREAR MULTICELL SIN SALTO DE LINEA ############

function GetMultiCellHeight($w, $h, $txt, $border=null, $align='J') {
	// Calculate MultiCell with automatic or explicit line breaks height
	// $border is un-used, but I kept it in the parameters to keep the call
	//   to this function consistent with MultiCell()
	$cw = &$this->CurrentFont['cw'];
	if($w==0)
		$w = $this->w-$this->rMargin-$this->x;
	$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
	$s = str_replace("\r",'',$txt);
	$nb = strlen($s);
	if($nb>0 && $s[$nb-1]=="\n")
		$nb--;
	$sep = -1;
	$i = 0;
	$j = 0;
	$l = 0;
	$ns = 0;
	$height = 0;
	while($i<$nb)
	{
		// Get next character
		$c = $s[$i];
		if($c=="\n")
		{
			// Explicit line break
			if($this->ws>0)
			{
				$this->ws = 0;
				$this->_out('0 Tw');
			}
			//Increase Height
			$height += $h;
			$i++;
			$sep = -1;
			$j = $i;
			$l = 0;
			$ns = 0;
			continue;
		}
		if($c==' ')
		{
			$sep = $i;
			$ls = $l;
			$ns++;
		}
		$l += $cw[$c];
		if($l>$wmax)
		{
			// Automatic line break
			if($sep==-1)
			{
				if($i==$j)
					$i++;
				if($this->ws>0)
				{
					$this->ws = 0;
					$this->_out('0 Tw');
				}
				//Increase Height
				$height += $h;
			}
			else
			{
				if($align=='J')
				{
					$this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
					$this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
				}
				//Increase Height
				$height += $h;
				$i = $sep+1;
			}
			$sep = -1;
			$j = $i;
			$l = 0;
			$ns = 0;
		}
		else
			$i++;
	}
	// Last chunk
	if($this->ws>0)
	{
		$this->ws = 0;
		$this->_out('0 Tw');
	}
	//Increase Height
	$height += $h;

	return $height;
}

function MultiAlignCell($w,$h,$text,$border=0,$ln=0,$align='L',$fill=false)
{
    // Store reset values for (x,y) positions
    $x = $this->GetX() + $w;
    $y = $this->GetY();

    // Make a call to FPDF's MultiCell
    $this->MultiCell($w,$h,$text,$border,$align,$fill);

    // Reset the line position to the right, like in Cell
    if( $ln==0 )
    {
        $this->SetXY($x,$y);
    }
}


function MultiCellText($w, $h, $txt, $border=0, $ln=0, $align='J', $fill=false)
{
    // Custom Tomaz Ahlin
    if($ln == 0) {
        $current_y = $this->GetY();
        $current_x = $this->GetX();
    }

    // Output text with automatic or explicit line breaks
    $cw = &$this->CurrentFont['cw'];
    if($w==0)
        $w = $this->w-$this->rMargin-$this->x;
    $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
    $s = str_replace("\r",'',$txt);
    $nb = strlen($s);
    if($nb>0 && $s[$nb-1]=="\n")
        $nb--;
    $b = 0;
    if($border)
    {
        if($border==1)
        {
            $border = 'LTRB';
            $b = 'LRT';
            $b2 = 'LR';
        }
        else
        {
            $b2 = '';
            if(strpos($border,'L')!==false)
                $b2 .= 'L';
            if(strpos($border,'R')!==false)
                $b2 .= 'R';
            $b = (strpos($border,'T')!==false) ? $b2.'T' : $b2;
        }
    }
    $sep = -1;
    $i = 0;
    $j = 0;
    $l = 0;
    $ns = 0;
    $nl = 1;
    while($i<$nb)
    {
        // Get next character
        $c = $s[$i];
        if($c=="\n")
        {
            // Explicit line break
            if($this->ws>0)
            {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
            $i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            $ns = 0;
            $nl++;
            if($border && $nl==2)
                $b = $b2;
            continue;
        }
        if($c==' ')
        {
            $sep = $i;
            $ls = $l;
            $ns++;
        }
        $l += $cw[$c];
        if($l>$wmax)
        {
            // Automatic line break
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
                if($this->ws>0)
                {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
            }
            else
            {
                if($align=='J')
                {
                    $this->ws = ($ns>1) ?     ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                    $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                }
                $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                $i = $sep+1;
            }
            $sep = -1;
            $j = $i;
            $l = 0;
            $ns = 0;
            $nl++;
            if($border && $nl==2)
                $b = $b2;
        }
        else
            $i++;
    }
    // Last chunk
    if($this->ws>0)
    {
        $this->ws = 0;
        $this->_out('0 Tw');
    }
    if($border && strpos($border,'B')!==false)
        $b .= 'B';
    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
    $this->x = $this->lMargin;

    // Custom Tomaz Ahlin
    if($ln == 0) {
        $this->SetXY($current_x + $w, $current_y);
    }
}


function RoundedRect($x, $y, $w, $h, $r, $style = '')
	{
		$k = $this->k;
		$hp = $this->h;
		if($style=='F')
			$op='f';
		elseif($style=='FD' || $style=='DF')
			$op='B';
		else
			$op='S';
		$MyArc = 4/3 * (sqrt(2) - 1);
		$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
		$xc = $x+$w-$r ;
		$yc = $y+$r;
		$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

		$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
		$xc = $x+$w-$r ;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
		$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
		$xc = $x+$r ;
		$yc = $y+$h-$r;
		$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
		$this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
		$xc = $x+$r ;
		$yc = $y+$r;
		$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
		$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
		$this->_out($op);
	}

	function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
	{
		$h = $this->h;
		$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
			$x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
	}


    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)

    {

        //Get string width

        $str_width=$this->GetStringWidth($txt);


        //Calculate ratio to fit cell

        if($w==0)

            $w = $this->w-$this->rMargin-$this->x;

        $ratio = ($w-$this->cMargin*2)/$str_width;


        $fit = ($ratio < 1 || ($ratio > 1 && $force));

        if ($fit)

        {

            if ($scale)

            {

                //Calculate horizontal scaling

                $horiz_scale=$ratio*100.0;

                //Set horizontal scaling

                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));

            }

            else

            {

                //Calculate character spacing in points

                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;

                //Set character spacing

                $this->_out(sprintf('BT %.2F Tc ET',$char_space));

            }

            //Override user alignment (since text will fill up cell)

            $align='';

        }


        //Pass on to Cell method

        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);


        //Reset character spacing/horizontal scaling

        if ($fit)

            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');

    }


    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')

    {

        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);

    }


    //Patch to also work with CJK double-byte text

    function MBGetStringLength($s)

    {

        if($this->CurrentFont['type']=='Type0')

        {

            $len = 0;

            $nbbytes = strlen($s);

            for ($i = 0; $i < $nbbytes; $i++)

            {

                if (ord($s[$i])<128)

                    $len++;

                else

                {

                    $len++;

                    $i++;

                }

            }

            return $len;

        }

        else

            return strlen($s);

    }

##################### FIN DEL CODIGO PARA AJUSTAR TEXTO EN CELDAS #####################

function saveFont()
	{

		$saved = array();

		$saved[ 'family' ] = $this->FontFamily;
		$saved[ 'style' ] = $this->FontStyle;
		$saved[ 'sizePt' ] = $this->FontSizePt;
		$saved[ 'size' ] = $this->FontSize;
		$saved[ 'curr' ] =& $this->CurrentFont;

		return $saved;

	}

	function restoreFont( $saved )
	{

		$this->FontFamily = $saved[ 'family' ];
		$this->FontStyle = $saved[ 'style' ];
		$this->FontSizePt = $saved[ 'sizePt' ];
		$this->FontSize = $saved[ 'size' ];
		$this->CurrentFont =& $saved[ 'curr' ];

		if( $this->page > 0)
			$this->_out( sprintf( 'BT /F%d %.2F Tf ET', $this->CurrentFont[ 'i' ], $this->FontSizePt ) );

	}

	function newFlowingBlock( $w, $h, $b = 0, $a = 'J', $f = 0 )
	{

		// cell width in points
		$this->flowingBlockAttr[ 'width' ] = $w * $this->k;

		// line height in user units
		$this->flowingBlockAttr[ 'height' ] = $h;

		$this->flowingBlockAttr[ 'lineCount' ] = 0;

		$this->flowingBlockAttr[ 'border' ] = $b;
		$this->flowingBlockAttr[ 'align' ] = $a;
		$this->flowingBlockAttr[ 'fill' ] = $f;

		$this->flowingBlockAttr[ 'font' ] = array();
		$this->flowingBlockAttr[ 'content' ] = array();
		$this->flowingBlockAttr[ 'contentWidth' ] = 0;

	}

	function finishFlowingBlock()
	{

		$maxWidth =& $this->flowingBlockAttr[ 'width' ];

		$lineHeight =& $this->flowingBlockAttr[ 'height' ];

		$border =& $this->flowingBlockAttr[ 'border' ];
		$align =& $this->flowingBlockAttr[ 'align' ];
		$fill =& $this->flowingBlockAttr[ 'fill' ];

		$content =& $this->flowingBlockAttr[ 'content' ];
		$font =& $this->flowingBlockAttr[ 'font' ];

		// set normal spacing
		$this->_out( sprintf( '%.3F Tw', 0 ) );

		// print out each chunk

		// the amount of space taken up so far in user units
		$usedWidth = 0;

		foreach ( $content as $k => $chunk )
		{

			$b = '';

			if ( is_int( strpos( $border, 'B' ) ) )
				$b .= 'B';

			if ( $k == 0 && is_int( strpos( $border, 'L' ) ) )
				$b .= 'L';

			if ( $k == count( $content ) - 1 && is_int( strpos( $border, 'R' ) ) )
				$b .= 'R';

			$this->restoreFont( $font[ $k ] );

			// if it's the last chunk of this line, move to the next line after
			if ( $k == count( $content ) - 1 )
				$this->Cell( ( $maxWidth / $this->k ) - $usedWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 1, $align, $fill );
			else
				$this->Cell( $this->GetStringWidth( $chunk ), $lineHeight, $chunk, $b, 0, $align, $fill );

			$usedWidth += $this->GetStringWidth( $chunk );

		}

	}

	function WriteFlowingBlock( $s )
	{

		// width of all the content so far in points
		$contentWidth =& $this->flowingBlockAttr[ 'contentWidth' ];

		// cell width in points
		$maxWidth =& $this->flowingBlockAttr[ 'width' ];

		$lineCount =& $this->flowingBlockAttr[ 'lineCount' ];

		// line height in user units
		$lineHeight =& $this->flowingBlockAttr[ 'height' ];

		$border =& $this->flowingBlockAttr[ 'border' ];
		$align =& $this->flowingBlockAttr[ 'align' ];
		$fill =& $this->flowingBlockAttr[ 'fill' ];

		$content =& $this->flowingBlockAttr[ 'content' ];
		$font =& $this->flowingBlockAttr[ 'font' ];

		$font[] = $this->saveFont();
		$content[] = '';

		$currContent =& $content[ count( $content ) - 1 ];

		// where the line should be cutoff if it is to be justified
		$cutoffWidth = $contentWidth;

		// for every character in the string
		for ( $i = 0; $i < strlen( $s ); $i++ )
		{

			// extract the current character
			$c = $s[ $i ];

			// get the width of the character in points
			$cw = $this->CurrentFont[ 'cw' ][ $c ] * ( $this->FontSizePt / 1000 );

			if ( $c == ' ' )
			{

				$currContent .= ' ';
				$cutoffWidth = $contentWidth;

				$contentWidth += $cw;

				continue;

			}

			// try adding another char
			if ( $contentWidth + $cw > $maxWidth )
			{

				// won't fit, output what we have
				$lineCount++;

				// contains any content that didn't make it into this print
				$savedContent = '';
				$savedFont = array();

				// first, cut off and save any partial words at the end of the string
				$words = explode( ' ', $currContent );

				// if it looks like we didn't finish any words for this chunk
				if ( count( $words ) == 1 )
				{

					// save and crop off the content currently on the stack
					$savedContent = array_pop( $content );
					$savedFont = array_pop( $font );

					// trim any trailing spaces off the last bit of content
					$currContent =& $content[ count( $content ) - 1 ];

					$currContent = rtrim( $currContent );

				}

				// otherwise, we need to find which bit to cut off
				else
				{

					$lastContent = '';

					for ( $w = 0; $w < count( $words ) - 1; $w++)
						$lastContent .= "{$words[ $w ]} ";

					$savedContent = $words[ count( $words ) - 1 ];
					$savedFont = $this->saveFont();

					// replace the current content with the cropped version
					$currContent = rtrim( $lastContent );

				}

				// update $contentWidth and $cutoffWidth since they changed with cropping
				$contentWidth = 0;

				foreach ( $content as $k => $chunk )
				{

					$this->restoreFont( $font[ $k ] );

					$contentWidth += $this->GetStringWidth( $chunk ) * $this->k;

				}

				$cutoffWidth = $contentWidth;

				// if it's justified, we need to find the char spacing
				if( $align == 'J' )
				{

					// count how many spaces there are in the entire content string
					$numSpaces = 0;

					foreach ( $content as $chunk )
						$numSpaces += substr_count( $chunk, ' ' );

					// if there's more than one space, find word spacing in points
					if ( $numSpaces > 0 )
						$this->ws = ( $maxWidth - $cutoffWidth ) / $numSpaces;
					else
						$this->ws = 0;

					$this->_out( sprintf( '%.3F Tw', $this->ws ) );

				}

				// otherwise, we want normal spacing
				else
					$this->_out( sprintf( '%.3F Tw', 0 ) );

				// print out each chunk
				$usedWidth = 0;

				foreach ( $content as $k => $chunk )
				{

					$this->restoreFont( $font[ $k ] );

					$stringWidth = $this->GetStringWidth( $chunk ) + ( $this->ws * substr_count( $chunk, ' ' ) / $this->k );

					// determine which borders should be used
					$b = '';

					if ( $lineCount == 1 && is_int( strpos( $border, 'T' ) ) )
						$b .= 'T';

					if ( $k == 0 && is_int( strpos( $border, 'L' ) ) )
						$b .= 'L';

					if ( $k == count( $content ) - 1 && is_int( strpos( $border, 'R' ) ) )
						$b .= 'R';

					// if it's the last chunk of this line, move to the next line after
					if ( $k == count( $content ) - 1 )
						$this->Cell( ( $maxWidth / $this->k ) - $usedWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 1, $align, $fill );
					else
					{

						$this->Cell( $stringWidth + 2 * $this->cMargin, $lineHeight, $chunk, $b, 0, $align, $fill );
						$this->x -= 2 * $this->cMargin;

					}

					$usedWidth += $stringWidth;

				}

				// move on to the next line, reset variables, tack on saved content and current char
				$this->restoreFont( $savedFont );

				$font = array( $savedFont );
				$content = array( $savedContent . $s[ $i ] );

				$currContent =& $content[ 0 ];

				$contentWidth = $this->GetStringWidth( $currContent ) * $this->k;
				$cutoffWidth = $contentWidth;

			}

			// another character will fit, so add it on
			else
			{

				$contentWidth += $cw;
				$currContent .= $s[ $i ];

			}

		}

	}
	
	########### FUNCION PARA CODIGO DE BARRA CON CODABAR ############
	function Codabar($xpos, $ypos, $code, $start='A', $end='A', $basewidth=0.12, $height=10) {
	$barChar = array (
		'0' => array (6.5, 4.4, 6.5, 3.4, 6.5, 7.3, 2.9),
		'1' => array (6.5, 4.4, 6.5, 8.4, 4.9, 4.3, 6.5),
		'2' => array (6.5, 4.0, 6.5, 9.4, 6.5, 3.0, 8.6),
		'3' => array (17.9, 24.3, 6.5, 6.4, 6.5, 3.4, 6.5),
		'4' => array (6.5, 2.4, 8.9, 6.4, 6.5, 4.3, 6.5),
		'5' => array (5.9,	2.4, 6.5, 6.4, 6.5, 4.3, 6.5),
		'6' => array (6.5, 8.3, 6.5, 6.4, 6.5, 6.4, 7.9),
		'7' => array (6.5, 8.3, 6.5, 2.4, 7.9, 6.4, 6.5),
		'8' => array (6.5, 8.3, 5.9, 10.4, 6.5, 6.4, 6.5),
		'9' => array (7.6, 5.0, 6.5, 8.4, 6.5, 3.0, 6.5),
		'$' => array (6.5, 5.0, 18.6, 24.4, 6.5, 10.0, 6.5),
		'-' => array (6.5, 5.0, 6.5, 4.4, 8.6, 10.0, 6.5),
		':' => array (16.7, 9.3, 6.5, 9.3, 16.7, 9.3, 14.7),
		'/' => array (14.7, 9.3, 16.7, 9.3, 6.5, 9.3, 16.7),
		'.' => array (13.6, 10.1, 14.9, 10.1, 17.2, 10.1, 6.5),
		'+' => array (6.5, 10.1, 17.2, 10.1, 14.9, 10.1, 13.6),
		'A' => array (6.5, 8.0, 19.6, 19.4, 6.5, 16.1, 6.5),
		'T' => array (6.5, 8.0, 19.6, 19.4, 6.5, 16.1, 6.5),
		'B' => array (6.5, 16.1, 6.5, 19.4, 6.5, 8.0, 19.6),
		'N' => array (6.5, 16.1, 6.5, 19.4, 6.5, 8.0, 19.6),
		'C' => array (6.5, 8.0, 6.5, 19.4, 6.5, 16.1, 19.6),
		'*' => array (6.5, 8.0, 6.5, 19.4, 6.5, 16.1, 19.6),
		'D' => array (6.5, 8.0, 6.5, 19.4, 19.6, 16.1, 6.5),
		'E' => array (6.5, 8.0, 6.5, 19.4, 19.6, 16.1, 6.5),
	);
	$this->SetFont('Arial','',8.5);
	$this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco 259)
	$this->Text($xpos, $ypos + $height + 2, $code);
	$this->SetFillColor(0);
	$code = strtoupper($start.$code.$end);
	for($i=0; $i<strlen($code); $i++){
		$char = $code[$i];
		if(!isset($barChar[$char])){
			$this->Error('Invalid character in barcode: '.$char);
		}
		$seq = $barChar[$char];
		for($bar=0; $bar<7; $bar++){
			$lineWidth = $basewidth*$seq[$bar]/4;
			if($bar % 2 == 0){
				$this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
			}
			$xpos += $lineWidth;
		}
		$xpos += $basewidth*10.4/6.5;
	}
}

   function TextWithDirection($x, $y, $txt, $direction='R')
{
    if ($direction=='R')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    elseif ($direction=='L')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    elseif ($direction=='U')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    elseif ($direction=='D')
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    else
        $s=sprintf('BT %.2F %.2F Td (%s) Tj ET', $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    if ($this->ColorFlag)
        $s='q '.$this->TextColor.' '.$s.' Q';
    $this->_out($s);
}

function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0)
{
    $font_angle+=90+$txt_angle;
    $txt_angle*=M_PI/180;
    $font_angle*=M_PI/180;

    $txt_dx=cos($txt_angle);
    $txt_dy=sin($txt_angle);
    $font_dx=cos($font_angle);
    $font_dy=sin($font_angle);

    $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', $txt_dx, $txt_dy, $font_dx, $font_dy, $x*$this->k, ($this->h-$y)*$this->k, $this->_escape($txt));
    if ($this->ColorFlag)
        $s='q '.$this->TextColor.' '.$s.' Q';
    $this->_out($s);
}
 // FIN Class PDF
}
?>