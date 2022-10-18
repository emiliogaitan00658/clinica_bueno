<?php
session_start();
require_once("classconexion.php");
include_once("assets/captcha/securimage.php");
include_once('funciones_basicas.php');
include "class.phpmailer.php";
include "class.smtp.php";


// Motrar todos los errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//evita el error Fatal error: Allowed memory size of X bytes exhausted (tried to allocate Y bytes)...
ini_set('memory_limit', '-1'); 
// es lo mismo que set_time_limit(300) ;
ini_set('max_execution_time', 3800); 

################################## CLASE LOGIN ###################################
class Login extends Db
{
	public function __construct()
	{
		parent::__construct();
	} 	

###################### FUNCION PARA EXPIRAR SESSION POR INACTIVIDAD ####################
public function ExpiraSession(){

	if(!isset($_SESSION['usuario'])){// Esta logeado?.
		header("Location: logout.php"); 
	}

	if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista") {

	//Verifico el tiempo si esta seteado, caso contrario lo seteo.
	$tiempo = limpiar($_SESSION['hora_hasta']);
	$actual =  strtotime(date("H:i:s"));

	if($_SESSION['nivel'] != "ADMINISTRADOR(A) GENERAL" && $actual > $tiempo){
	?>					
		<script type='text/javascript' language='javascript'>
			alert('SU TIEMPO ESTABLECIDO POR EL ADMINISTRADOR A EXPIRADO \nDEBERA DE INGRESAR EN EL HORARIO ESTABLECIDO') 
			document.location.href='logout'	 
		</script> 
	<?php
	    } 
    }
}
###################### FUNCION PARA EXPIRAR SESSION POR INACTIVIDAD ####################

########################### CLASE LOGUEO ###############################

#################### FUNCION PARA ACCEDER AL SISTEMA ####################
public function Logueo()
{
	self::SetNames();
	if(empty($_POST["usuario"]) or empty($_POST["password"]) or empty($_POST["tipo"]))
	{
		echo "1";
		exit;
	}

	$date = new DateTime();
    $timestamp = $date->getTimestamp();// Devuelve el timestamp, por ejemplo: 1446811771

	if (decrypt($_POST['tipo']) == 1) {// SI TIPO INGRESO ES ADMINISTRADORES, SECRETARIAS, CAJEROS

	$sql = "SELECT
	usuarios.idusuario,
	usuarios.codigo, 
	usuarios.dni,
	usuarios.nombres,
	usuarios.sexo,
	usuarios.direccion,
	usuarios.telefono,
	usuarios.email,
	usuarios.usuario,
	usuarios.password,
	usuarios.nivel,
	usuarios.status,
	horarios.hora_desde,
	horarios.hora_hasta,
	sucursales.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_departamento,
	sucursales.id_provincia,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.nroactividadsucursal,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.descsucursal,
	documentos.documento,
	documentos2.documento AS documento2,
	departamentos.departamento,
	provincias.provincia
	FROM usuarios LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario
	LEFT JOIN horarios ON usuarios.codigo = horarios.codigo
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	WHERE usuarios.usuario = ?
	AND accesosxsucursales.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST["usuario"]),limpiar(decrypt($_POST["codsucursal"]))));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		echo "2";
		exit;

	} else {
			
	    if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[]=$row;
		}

		if (limpiar($row['status'])==0)
		{  
			echo "3";
			exit;
		} 
		elseif (limpiar($row['nivel']) != "ADMINISTRADOR(A) GENERAL" && strtotime($row['hora_desde']) == "")
		{  
			echo "4";
			exit;
		} 

		elseif (limpiar($row['nivel']) != "ADMINISTRADOR(A) GENERAL" && !($timestamp >= strtotime($row['hora_desde']) && $timestamp <= strtotime($row['hora_hasta'])))
		{  
			echo "5";
			exit;
		} 
		elseif (password_verify($_POST["password"], $row['password'])) {				
				
		################## DATOS DE USUARIO ##################
		$_SESSION["codigo"] = $p[0]["codigo"];
		$_SESSION["dni"] = $p[0]["dni"];
		$_SESSION["nombres"] = $p[0]["nombres"];
		$_SESSION["sexo"] = $p[0]["sexo"];
		$_SESSION["direccion"] = $p[0]["direccion"];
		$_SESSION["telefono"] = $p[0]["telefono"];
		$_SESSION["email"] = $p[0]["email"];
		$_SESSION["usuario"] = $p[0]["usuario"];
		$_SESSION["password"] = $p[0]["password"];
		$_SESSION["nivel"] = $p[0]["nivel"];
		$_SESSION["status"] = $p[0]["status"];
		$_SESSION["hora_desde"] = strtotime($p[0]["hora_desde"]);
		$_SESSION["hora_hasta"] = strtotime($p[0]["hora_hasta"]);
		$_SESSION["tipo"] = $_POST['tipo'];
		$_SESSION["ingreso"] = limpiar(date("Y-m-d H:i:s"));

        ################## DATOS DE LA SUCURSAL ##################
		$_SESSION["codsucursal"] = $p[0]["codsucursal"];
		$_SESSION["documsucursal"] = $p[0]["documsucursal"];
		$_SESSION["cuitsucursal"] = $p[0]["cuitsucursal"];
		$_SESSION["nomsucursal"] = $p[0]["nomsucursal"];
		$_SESSION["tlfsucursal"] = $p[0]["tlfsucursal"];
		$_SESSION["id_departamento"] = $p[0]["id_departamento"];
		$_SESSION["departamento"] = $p[0]["departamento"];
		$_SESSION["id_provincia"] = $p[0]["id_provincia"];
		$_SESSION["provincia"] = $p[0]["provincia"];
		$_SESSION["direcsucursal"] = $p[0]["direcsucursal"];
		$_SESSION["correosucursal"] = $p[0]["correosucursal"];
		$_SESSION["nomencargado"] = $p[0]["nomencargado"];
		$_SESSION["descsucursal"] = $p[0]["descsucursal"];
		$_SESSION["documento"] = $p[0]["documento"];
		$_SESSION["documento2"] = $p[0]["documento2"];

		$query = "INSERT INTO log VALUES (null, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1,$a);
		$stmt->bindParam(2,$b);
		$stmt->bindParam(3,$c);
		$stmt->bindParam(4,$d);
		$stmt->bindParam(5,$e);

		$a = limpiar($_SERVER['REMOTE_ADDR']);
		$b = limpiar(date("Y-m-d H:i:s"));
		$c = limpiar($_SERVER['HTTP_USER_AGENT']);
		$d = limpiar($_SERVER['PHP_SELF']);
		$e = limpiar($_POST["usuario"]);
		$stmt->execute();

		switch($_SESSION["nivel"])
		{
			case 'ADMINISTRADOR(A) GENERAL':
			$_SESSION["acceso"]="administradorG";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'ADMINISTRADOR(A) SUCURSAL':
			$_SESSION["acceso"]="administradorS";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'ASISTENTE':
			$_SESSION["acceso"]="secretaria";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'CAJERO(A)':
			$_SESSION["acceso"]="cajero";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>
			
			<?php
			break;
		}//end switch	

	} else {

  	echo "6";
  	exit;
  
	  }
   } //USUARIO   

    } elseif (decrypt($_POST['tipo']) == 2) {// SI TIPO INGRESO ES ESPECIALISTAS

    $sql = "SELECT
	especialistas.idespecialista,
	especialistas.codespecialista,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.sexoespecialista,
	especialistas.id_departamento,
	especialistas.id_provincia,
	especialistas.direcespecialista,
	especialistas.correoespecialista,
	especialistas.especialidad,
	especialistas.fnacespecialista,
	especialistas.claveespecialista,
    horarios.hora_desde,
    horarios.hora_hasta,
	sucursales.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_departamento,
	sucursales.id_provincia,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.nroactividadsucursal,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.descsucursal,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	departamentos.departamento,
	provincias.provincia,
	departamentos2.departamento AS departamento2,
	provincias2.provincia AS provincia2
	FROM especialistas LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario
    LEFT JOIN horarios ON especialistas.codespecialista = horarios.codigo
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN departamentos AS departamentos2 ON especialistas.id_departamento = departamentos2.id_departamento
	LEFT JOIN provincias AS provincias2 ON especialistas.id_provincia = provincias2.id_provincia
	WHERE especialistas.cedespecialista = ?
	AND accesosxsucursales.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST["usuario"]),limpiar(decrypt($_POST["codsucursal"]))));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		echo "2";
		exit;

	} else {
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[]=$row;
		}
        
        if (strtotime($row['hora_desde']) == "")
        {  
            echo "4";
            exit;
        } 

        elseif (!($timestamp >= strtotime($row['hora_desde']) && $timestamp <= strtotime($row['hora_hasta'])))
        {  
            echo "5";
            exit;
        } 

		if (password_verify($_POST["password"], $row['claveespecialista'])) {	
			
			################## DATOS DE ACCESO ##################
			$_SESSION["codigo"] = $p[0]["codespecialista"];
			$_SESSION["dni"] = $p[0]["cedespecialista"];
			$_SESSION["nombres"] = $p[0]["nomespecialista"];
			$_SESSION["telefono"] = $p[0]["tlfespecialista"];
			$_SESSION["email"] = $p[0]["correoespecialista"];
			$_SESSION["usuario"] = $p[0]["cedespecialista"];
			$_SESSION["password"] = $p[0]["claveespecialista"];
            $_SESSION["hora_desde"] = strtotime($p[0]["hora_desde"]);
            $_SESSION["hora_hasta"] = strtotime($p[0]["hora_hasta"]);
			$_SESSION["tipo"] = $_POST['tipo'];
			$_SESSION["nivel"] = "ESPECIALISTA";
			$_SESSION["ingreso"] = limpiar(date("Y-m-d H:i:s"));

			################## DATOS DE ESPECIALISTA ##################
			$_SESSION["idespecialista"] = $p[0]["idespecialista"];
			$_SESSION["codespecialista"] = $p[0]["codespecialista"];
			$_SESSION["tpespecialista"] = $p[0]["tpespecialista"];
			$_SESSION["documespecialista"] = $p[0]["documespecialista"];
			$_SESSION["documento3"] = $p[0]["documento3"];
			$_SESSION["cedespecialista"] = $p[0]["cedespecialista"];
			$_SESSION["nomespecialista"] = $p[0]["nomespecialista"];
			$_SESSION["tlfespecialista"] = $p[0]["tlfespecialista"];
			$_SESSION["sexoespecialista"] = $p[0]["sexoespecialista"];
			$_SESSION["id_departamento"] = $p[0]["id_departamento"];
			$_SESSION["departamento2"] = $p[0]["departamento2"];
			$_SESSION["id_provincia"] = $p[0]["id_provincia"];
			$_SESSION["provincia2"] = $p[0]["provincia2"];
			$_SESSION["direcespecialista"] = $p[0]["direcespecialista"];
			$_SESSION["correoespecialista"] = $p[0]["correoespecialista"];
			$_SESSION["especialidad"] = $p[0]["especialidad"];
			$_SESSION["fnacespecialista"] = $p[0]["fnacespecialista"];
			$_SESSION["claveespecialista"] = $p[0]["claveespecialista"];

			################## DATOS DE LA SUCURSAL ##################
			$_SESSION["codsucursal"] = $p[0]["codsucursal"];
			$_SESSION["documsucursal"] = $p[0]["documsucursal"];
			$_SESSION["cuitsucursal"] = $p[0]["cuitsucursal"];
			$_SESSION["nomsucursal"] = $p[0]["nomsucursal"];
			$_SESSION["tlfsucursal"] = $p[0]["tlfsucursal"];
			$_SESSION["id_departamento"] = $p[0]["id_departamento"];
			$_SESSION["departamento"] = $p[0]["departamento"];
			$_SESSION["id_provincia"] = $p[0]["id_provincia"];
			$_SESSION["provincia"] = $p[0]["provincia"];
			$_SESSION["direcsucursal"] = $p[0]["direcsucursal"];
			$_SESSION["correosucursal"] = $p[0]["correosucursal"];
			$_SESSION["nomencargado"] = $p[0]["nomencargado"];
			$_SESSION["descsucursal"] = $p[0]["descsucursal"];
			$_SESSION["documento"] = $p[0]["documento"];
			$_SESSION["documento2"] = $p[0]["documento2"];

			$query = "INSERT INTO log VALUES (null, ?, ?, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1,$a);
			$stmt->bindParam(2,$b);
			$stmt->bindParam(3,$c);
			$stmt->bindParam(4,$d);
			$stmt->bindParam(5,$e);

			$a = limpiar($_SERVER['REMOTE_ADDR']);
			$b = limpiar(date("Y-m-d H:i:s"));
			$c = limpiar($_SERVER['HTTP_USER_AGENT']);
			$d = limpiar($_SERVER['PHP_SELF']);
			$e = limpiar($_POST["usuario"]);
			$stmt->execute();
				
			switch($_SESSION["nivel"])
			{
				case 'ESPECIALISTA':
				$_SESSION["acceso"]="especialista";
				?>

				<script type="text/javascript">
				window.location="panel";
			    </script>

				<?php
				break;
		    }//end switch

	    } else {

  	    echo "6";
  	    exit;

	   }

   } //CERRAR ESPECIALISTA 

   } elseif (decrypt($_POST['tipo']) == 3) {// SI TIPO INGRESO ES PACIENTE

    $sql = "SELECT
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	pacientes.pnompaciente,
	pacientes.snompaciente,
	pacientes.papepaciente,
	pacientes.sapepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.emailpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	pacientes.id_departamento,
	pacientes.id_provincia,
	pacientes.direcpaciente,
	pacientes.clavepaciente,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia
	FROM pacientes LEFT JOIN documentos ON pacientes.documpaciente = documentos.coddocumento
	LEFT JOIN departamentos ON pacientes.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON pacientes.id_provincia = provincias.id_provincia
	WHERE pacientes.cedpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST["usuario"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		echo "2";
		exit;

	} else {
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[]=$row;
		}

		if (password_verify($_POST["password"], $row['clavepaciente'])) {	
			
			################## DATOS DE ACCESO ##################
			$_SESSION["codigo"] = $p[0]["codpaciente"];
			$_SESSION["dni"] = $p[0]["cedpaciente"];
			$_SESSION["nombres"] = $p[0]["pnompaciente"]." ".$p[0]["snompaciente"]." ".$p[0]["papepaciente"]." ".$p[0]["sapepaciente"];
			$_SESSION["telefono"] = $p[0]["tlfpaciente"];
			$_SESSION["email"] = $p[0]["emailpaciente"];
			$_SESSION["usuario"] = $p[0]["cedpaciente"];
			$_SESSION["password"] = $p[0]["clavepaciente"];
			$_SESSION["tipo"] = $_POST['tipo'];
			$_SESSION["nivel"] = "PACIENTE";
			$_SESSION["ingreso"] = limpiar(date("Y-m-d H:i:s"));

			################## DATOS DE PACIENTE ##################
			$_SESSION["idpaciente"] = $p[0]["idpaciente"];
			$_SESSION["codpaciente"] = $p[0]["codpaciente"];
			$_SESSION["documpaciente"] = $p[0]["documpaciente"];
			$_SESSION["documento"] = $p[0]["documento"];
			$_SESSION["cedpaciente"] = $p[0]["cedpaciente"];
			$_SESSION["pnompaciente"] = $p[0]["pnompaciente"];
			$_SESSION["snompaciente"] = $p[0]["snompaciente"];
			$_SESSION["papepaciente"] = $p[0]["papepaciente"];
			$_SESSION["sapepaciente"] = $p[0]["sapepaciente"];
			$_SESSION["fnacpaciente"] = $p[0]["fnacpaciente"];
			$_SESSION["tlfpaciente"] = $p[0]["tlfpaciente"];
			$_SESSION["emailpaciente"] = $p[0]["emailpaciente"];
			$_SESSION["gruposapaciente"] = $p[0]["gruposapaciente"];
			$_SESSION["estadopaciente"] = $p[0]["estadopaciente"];
			$_SESSION["ocupacionpaciente"] = $p[0]["ocupacionpaciente"];
			$_SESSION["sexopaciente"] = $p[0]["sexopaciente"];
			$_SESSION["enfoquepaciente"] = $p[0]["enfoquepaciente"];
			$_SESSION["id_departamento"] = $p[0]["id_departamento"];
			$_SESSION["departamento2"] = $p[0]["departamento"];
			$_SESSION["id_provincia"] = $p[0]["id_provincia"];
			$_SESSION["provincia"] = $p[0]["provincia"];
			$_SESSION["direcpaciente"] = $p[0]["direcpaciente"];
			$_SESSION["clavepaciente"] = $p[0]["clavepaciente"];

			$query = "INSERT INTO log VALUES (null, ?, ?, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1,$a);
			$stmt->bindParam(2,$b);
			$stmt->bindParam(3,$c);
			$stmt->bindParam(4,$d);
			$stmt->bindParam(5,$e);

			$a = limpiar($_SERVER['REMOTE_ADDR']);
			$b = limpiar(date("Y-m-d H:i:s"));
			$c = limpiar($_SERVER['HTTP_USER_AGENT']);
			$d = limpiar($_SERVER['PHP_SELF']);
			$e = limpiar($_POST["usuario"]);
			$stmt->execute();
				
			switch($_SESSION["nivel"])
			{
				case 'PACIENTE':
				$_SESSION["acceso"]="paciente";
				?>

				<script type="text/javascript">
				window.location="panel";
			    </script>

				<?php
				break;
		    }//end switch

	    } else {

  	    echo "6";
  	    exit;

	   }

   } //CERRAR PACIENTE

    } else {

    	echo "7";
    	exit;

    }
}
#################### FUNCION PARA ACCEDER AL SISTEMA ####################

########################### FIN DE CLASE LOGUEO ###############################

















######################## FUNCION RECUPERAR Y ACTUALIZAR PASSWORD #######################

########################### FUNCION PARA RECUPERAR CLAVE #############################
public function RecuperarPassword()
{
	self::SetNames();
	if(empty($_POST["email"]) or empty($_POST["tipo"]))
	{
		echo "1";
		exit;
	}

	################## DATOS DE CONFIGURACION #####################
	$sql = "SELECT * FROM configuracion";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
    $rucemisor = $row['cuitsucursal'];
    $nomsucursal = $row['nomsucursal'];
    $correo = $row['correosucursal'];
    ################## DATOS DE CONFIGURACION #####################

	if (decrypt($_POST['tipo']) == 4) {
	
	$sql = "SELECT * FROM usuarios WHERE email = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST["email"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "2";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$pa[] = $row;
		}
		################# OBTENGO DATOS DEL USUARIO #################
		$id = $pa[0]["codigo"];
		$nombres = $pa[0]["nombres"];
		$email = $pa[0]["email"];
		$pass = strtoupper(generar_clave(10));
		################# OBTENGO DATOS DEL USUARIO #################

		#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################
		$smtp=new PHPMailer();
		$smtp->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		# Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

	    # Definimos el formato del correo con UTF-8
		$smtp->CharSet="UTF-8";

	    # autenticación contra nuestro servidor smtp
		$smtp->Port = 465;
		$smtp->IsSMTP(); // use SMTP
		$smtp->SMTPAuth   = true;
		$smtp->SMTPSecure = 'ssl';						// enable SMTP authentication
		$smtp->Host       = "smtp.gmail.com";			// sets MAIL as the SMTP server
		$smtp->Username   = $correo;	// MAIL username
		$smtp->Password   = "**********";			// MAIL password

		# datos de quien realiza el envio
		$smtp->From       = $correo; // from mail
		$smtp->FromName   = portales(utf8_decode($nomsucursal)); // from mail name

		# Indicamos las direcciones donde enviar el mensaje con el formato
		#   "correo"=>"nombre usuario"
		# Se pueden poner tantos correos como se deseen

		# establecemos un limite de caracteres de anchura
		$smtp->WordWrap   = 50; // set word wrap

		# NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		# cualquier programa de correo pueda leerlo.

		# Definimos el contenido HTML del correo
		$contenidoHTML="<head>";
		$contenidoHTML.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML.="</head><body>";
		$contenidoHTML.="<b>Recuperación de Contraseña</b>";
		$contenidoHTML.="<p>Nueva Contraseña de Acceso: $pass</p>";
		$contenidoHTML.="</body>\n";

		# Definimos el contenido en formato Texto del correo
		$contenidoTexto= " Recuperación de Contraseña";
		$contenidoTexto.="\n\n";

		# Definimos el subject
		$smtp->Subject= " Recuperación de Contraseña";

		# Adjuntamos el archivo al correo.
	    $smtp->AddAttachment("fotos/logo_principal.png", "logo.png");
		//$smtp->AddAttachment("");

		# Indicamos el contenido
		$smtp->AltBody=$contenidoTexto; //Text Body
		$smtp->MsgHTML($contenidoHTML); //Text body HTML

		$smtp->ClearAllRecipients();
		$smtp->AddAddress($email,$nombres);

		//$smtp->Send();
		//Enviamos email
		if(!$smtp->Send()) {

		    //Mensaje no pudo ser enviado
		    echo "3";
			exit;

		} else {

		$sql = " UPDATE usuarios set "
		." password = ? "
		." where "
		." codigo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $password);
		$stmt->bindParam(2, $codigo);

		$codigo = $id;
		$password = password_hash($pass, PASSWORD_DEFAULT);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> SU NUEVA CLAVE DE ACCESO LE FUE ENVIADA A SU CORREO ELECTRONICO EXITOSAMENTE";
		exit;
    }
	#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################
	
	}


	} elseif (decrypt($_POST['tipo']) == 5) {

	$sql = "SELECT * FROM especialistas WHERE correoespecialista = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST["email"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "2";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$pa[] = $row;
		}
		################# OBTENGO DATOS DEL ESPECIALISTA #################
		$id = $pa[0]["codespecialista"];
		$nombres = $pa[0]["nomespecialista"];
		$email = $pa[0]["correoespecialista"];
		$pass = generar_clave(10);
		################# OBTENGO DATOS DEL ESPECIALISTA #################

		#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################
		$smtp=new PHPMailer();
		$smtp->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		# Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

	    # Definimos el formato del correo con UTF-8
		$smtp->CharSet="UTF-8";

	    # autenticación contra nuestro servidor smtp
		$smtp->Port = 465;
		$smtp->IsSMTP(); // use SMTP
		$smtp->SMTPAuth   = true;
		$smtp->SMTPSecure = 'ssl';						// enable SMTP authentication
		$smtp->Host       = "smtp.gmail.com";			// sets MAIL as the SMTP server
		$smtp->Username   = $correo;	// MAIL username
		$smtp->Password   = "**********";			// MAIL password

		# datos de quien realiza el envio
		$smtp->From       = $correo; // from mail
		$smtp->FromName   = portales(utf8_decode($nomsucursal)); // from mail name

		# Indicamos las direcciones donde enviar el mensaje con el formato
		#   "correo"=>"nombre usuario"
		# Se pueden poner tantos correos como se deseen

		# establecemos un limite de caracteres de anchura
		$smtp->WordWrap   = 50; // set word wrap

		# NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		# cualquier programa de correo pueda leerlo.

		# Definimos el contenido HTML del correo
		$contenidoHTML="<head>";
		$contenidoHTML.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML.="</head><body>";
		$contenidoHTML.="<b>Recuperación de Contraseña</b>";
		$contenidoHTML.="<p>Nueva Contraseña de Acceso: $pass</p>";
		$contenidoHTML.="</body>\n";

		# Definimos el contenido en formato Texto del correo
		$contenidoTexto= " Recuperación de Contraseña";
		$contenidoTexto.="\n\n";

		# Definimos el subject
		$smtp->Subject= " Recuperación de Contraseña";

		# Adjuntamos el archivo al correo.
	    $smtp->AddAttachment("fotos/logo_principal.png", "logo.png");
		//$smtp->AddAttachment("");

		# Indicamos el contenido
		$smtp->AltBody=$contenidoTexto; //Text Body
		$smtp->MsgHTML($contenidoHTML); //Text body HTML

		$smtp->ClearAllRecipients();
		$smtp->AddAddress($email,$nombres);

		//$smtp->Send();
		//Enviamos email
		if(!$smtp->Send()) {

		    //Mensaje no pudo ser enviado
		    echo "3";
			exit;

		} else {

		$sql = " UPDATE especialistas set "
		." claveespecialista = ? "
		." where "
		." codespecialista = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $password);
		$stmt->bindParam(2, $codigo);

		$codigo = $id;
		$password = password_hash($pass, PASSWORD_DEFAULT);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> SU NUEVA CLAVE DE ACCESO LE FUE ENVIADA A SU CORREO ELECTRONICO EXITOSAMENTE";
		exit;
    }
	#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################
	
	}	

	} elseif (decrypt($_POST['tipo']) == 6) {

	$sql = "SELECT * FROM pacientes WHERE emailpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST["email"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "2";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$pa[] = $row;
		}
		################# OBTENGO DATOS DEL ESPECIALISTA #################
		$id = $pa[0]["codpaciente"];
		$nombres = $pa[0]["pnompaciente"]." ".$pa[0]["snompaciente"]." ".$pa[0]["papepaciente"]." ".$pa[0]["sapepaciente"];
		$email = $pa[0]["emailpaciente"];
		$pass = generar_clave(10);
		################# OBTENGO DATOS DEL ESPECIALISTA #################

		#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################
		$smtp=new PHPMailer();
		$smtp->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		# Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

	    # Definimos el formato del correo con UTF-8
		$smtp->CharSet="UTF-8";

	    # autenticación contra nuestro servidor smtp
		$smtp->Port = 465;
		$smtp->IsSMTP(); // use SMTP
		$smtp->SMTPAuth   = true;
		$smtp->SMTPSecure = 'ssl';						// enable SMTP authentication
		$smtp->Host       = "smtp.gmail.com";			// sets MAIL as the SMTP server
		$smtp->Username   = $correo;	// MAIL username
		$smtp->Password   = "**********";			// MAIL password

		# datos de quien realiza el envio
		$smtp->From       = $correo; // from mail
		$smtp->FromName   = portales(utf8_decode($nomsucursal)); // from mail name

		# Indicamos las direcciones donde enviar el mensaje con el formato
		#   "correo"=>"nombre usuario"
		# Se pueden poner tantos correos como se deseen

		# establecemos un limite de caracteres de anchura
		$smtp->WordWrap   = 50; // set word wrap

		# NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		# cualquier programa de correo pueda leerlo.

		# Definimos el contenido HTML del correo
		$contenidoHTML="<head>";
		$contenidoHTML.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		$contenidoHTML.="</head><body>";
		$contenidoHTML.="<b>Recuperación de Contraseña</b>";
		$contenidoHTML.="<p>Nueva Contraseña de Acceso: $pass</p>";
		$contenidoHTML.="</body>\n";

		# Definimos el contenido en formato Texto del correo
		$contenidoTexto= " Recuperación de Contraseña";
		$contenidoTexto.="\n\n";

		# Definimos el subject
		$smtp->Subject= " Recuperación de Contraseña";

		# Adjuntamos el archivo al correo.
	    $smtp->AddAttachment("fotos/logo_principal.png", "logo.png");
		//$smtp->AddAttachment("");

		# Indicamos el contenido
		$smtp->AltBody=$contenidoTexto; //Text Body
		$smtp->MsgHTML($contenidoHTML); //Text body HTML

		$smtp->ClearAllRecipients();
		$smtp->AddAddress($email,$nombres);

		//$smtp->Send();
		//Enviamos email
		if(!$smtp->Send()) {

		    //Mensaje no pudo ser enviado
		    echo "3";
			exit;

		} else {

		$sql = " UPDATE pacientes set "
		." clavepaciente = ? "
		." where "
		." codpaciente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $password);
		$stmt->bindParam(2, $codigo);

		$codigo = $id;
		$password = password_hash($pass, PASSWORD_DEFAULT);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> SU NUEVA CLAVE DE ACCESO LE FUE ENVIADA A SU CORREO ELECTRONICO EXITOSAMENTE";
		exit;
    }
	#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################

	    }
	} 
}	
############################# FUNCION PARA RECUPERAR CLAVE ############################

########################## FUNCION PARA ACTUALIZAR PASSWORD ############################
public function ActualizarPassword()
{
	self::SetNames();
	if(empty($_POST["codigo"]) or empty($_POST["password"]) or empty($_POST["clave"]))
	{
		echo "1";
		exit;
	}

	if(password_hash($_POST["password"], PASSWORD_DEFAULT) == limpiar($_POST["clave"])){
		echo "2";
		exit;

	} else if($_SESSION["acceso"] == "especialista") {

		$sql = " UPDATE especialistas set "
		." claveespecialista = ? "
		." where "
		." codespecialista = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $password);
		$stmt->bindParam(2, $codigo);	

		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$codigo = limpiar($_POST["codigo"]);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> SU CLAVE DE ACCESO FUE ACTUALIZADA EXITOSAMENTE, SER&Aacute; EXPULSADO DE SU SESI&Oacute;N Y DEBER&Aacute; DE ACCEDER NUEVAMENTE CON SU NUEVA CLAVE";
		?>
		<script>
			function redireccionar(){location.href="logout";}
			setTimeout ("redireccionar()", 3000);
		</script>
		<?php
		exit;

	} else if($_SESSION["acceso"] == "paciente") {

		$sql = " UPDATE pacientes set "
		." clavepaciente = ? "
		." where "
		." codpaciente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $password);
		$stmt->bindParam(2, $codigo);	

		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$codigo = limpiar($_POST["codigo"]);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> SU CLAVE DE ACCESO FUE ACTUALIZADA EXITOSAMENTE, SER&Aacute; EXPULSADO DE SU SESI&Oacute;N Y DEBER&Aacute; DE ACCEDER NUEVAMENTE CON SU NUEVA CLAVE";
		?>
		<script>
			function redireccionar(){location.href="logout";}
			setTimeout ("redireccionar()", 3000);
		</script>
		<?php
		exit;

	} else {

		$sql = " UPDATE usuarios set "
		." usuario = ?, "
		." password = ? "
		." where "
		." codigo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $usuario);
		$stmt->bindParam(2, $password);
		$stmt->bindParam(3, $codigo);	

		$usuario = limpiar($_POST["usuario"]);
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$codigo = limpiar($_POST["codigo"]);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> SU CLAVE DE ACCESO FUE ACTUALIZADA EXITOSAMENTE, SER&Aacute; EXPULSADO DE SU SESI&Oacute;N Y DEBER&Aacute; DE ACCEDER NUEVAMENTE CON SU NUEVA CLAVE";
		?>
		<script>
			function redireccionar(){location.href="logout";}
			setTimeout ("redireccionar()", 3000);
		</script>
		<?php
		exit;
	}		
}
########################## FUNCION PARA ACTUALIZAR PASSWORD  ############################

####################### FUNCION RECUPERAR Y ACTUALIZAR PASSWORD ########################


























###################### FUNCION CONFIGURACION GENERAL DEL SISTEMA #######################

######################## FUNCION ID CONFIGURACION DEL SISTEMA #########################
public function ConfiguracionPorId()
{
	self::SetNames();
	$sql = " SELECT 
	configuracion.id,
	configuracion.documsucursal,
	configuracion.cuitsucursal,
	configuracion.nomsucursal,
	configuracion.tlfsucursal,
	configuracion.correosucursal,
	configuracion.id_departamento,
	configuracion.id_provincia,
	configuracion.direcsucursal,
	configuracion.documencargado,
	configuracion.dniencargado,
	configuracion.nomencargado,
	configuracion.tlfencargado,
	configuracion.pagina_web,
	documentos.documento,
	documentos2.documento AS documento2,
	departamentos.departamento,
	provincias.provincia
	FROM configuracion 
	LEFT JOIN documentos ON configuracion.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON configuracion.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON configuracion.id_departamento = departamentos.id_departamento 
	LEFT JOIN provincias ON configuracion.id_provincia = provincias.id_provincia WHERE configuracion.id = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array('1'));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION ID CONFIGURACION DEL SISTEMA #########################

######################## FUNCION  ACTUALIZAR CONFIGURACION ##########################
public function ActualizarConfiguracion()
{

	self::SetNames();
	if(empty($_POST["documsucursal"]) or empty($_POST["cuitsucursal"]) or empty($_POST["nomsucursal"]) or empty($_POST["tlfsucursal"]) or empty($_POST["correosucursal"]) or empty($_POST["id_departamento"]) or empty($_POST["id_provincia"]) or empty($_POST["direcsucursal"]) or empty($_POST["documencargado"]) or empty($_POST["dniencargado"]) or empty($_POST["nomencargado"]) or empty($_POST["tlfencargado"]) or empty($_POST["pagina_web"]))
	{
		echo "1";
		exit;
	}
	$sql = " UPDATE configuracion set "
	." documsucursal = ?, "
	." cuitsucursal = ?, "
	." nomsucursal = ?, "
	." tlfsucursal = ?, "
	." correosucursal = ?, "
	." id_departamento = ?, "
	." id_provincia = ?, "
	." direcsucursal = ?, "
	." documencargado = ?, "
	." dniencargado = ?, "
	." nomencargado = ?, "
	." tlfencargado = ?, "
	." pagina_web = ? "
	." where "
	." id = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $documsucursal);
	$stmt->bindParam(2, $cuitsucursal);
	$stmt->bindParam(3, $nomsucursal);
	$stmt->bindParam(4, $tlfsucursal);
	$stmt->bindParam(5, $correosucursal);
	$stmt->bindParam(6, $id_departamento);
	$stmt->bindParam(7, $id_provincia);
	$stmt->bindParam(8, $direcsucursal);
	$stmt->bindParam(9, $documencargado);
	$stmt->bindParam(10, $dniencargado);
	$stmt->bindParam(11, $nomencargado);
	$stmt->bindParam(12, $tlfencargado);
	$stmt->bindParam(13, $pagina_web);
	$stmt->bindParam(14, $id);

	$documsucursal = limpiar($_POST['documsucursal']);
	$cuitsucursal = limpiar($_POST["cuitsucursal"]);
	$nomsucursal = limpiar($_POST["nomsucursal"]);
	$tlfsucursal = limpiar($_POST["tlfsucursal"]);
	$correosucursal = limpiar($_POST["correosucursal"]);
	$id_departamento = limpiar($_POST['id_departamento']);
	$id_provincia = limpiar($_POST['id_provincia']);
	$direcsucursal = limpiar($_POST["direcsucursal"]);
	$documencargado = limpiar($_POST['documencargado']);
	$dniencargado = limpiar($_POST["dniencargado"]);
	$nomencargado = limpiar($_POST["nomencargado"]);
	$tlfencargado = limpiar($_POST["tlfencargado"]);
	$pagina_web = limpiar($_POST["pagina_web"]);
	$id = limpiar($_POST["id"]);
	$stmt->execute();

	################## SUBIR LOGO PRINCIPAL ######################################
         //datos del arhivo  
if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
         //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<300000) {  
			if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/logo_principal.png"))
			
					{ 
		 ## se puede dar un aviso
					} 
		 ## se puede dar otro aviso 
				}
	################## FINALIZA SUBIR LOGO PRINCIPAL ##################

	echo "<span class='fa fa-check-square-o'></span> LOS DATOS DE CONFIGURACI&Oacute;N FUERON ACTUALIZADOS EXITOSAMENTE";
	exit;
}
######################## FUNCION  ACTUALIZAR CONFIGURACION #######################

############################## FUNCION ENVIAR MENSAJE EN CONTACTO ##############################
public function EnviarMensaje()
{
	self::SetNames();
	if(empty($_POST["name"]) or empty($_POST["email"]) or empty($_POST["subject"]) or empty($_POST["message"]))
	{
		echo "1";
		exit;
	}

	################## DATOS DE CONFIGURACION #####################
	$sql = "SELECT * FROM configuracion";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
    $rucemisor = $row['cuitsucursal'];
    $nomsucursal = $row['nomsucursal'];
    $correo = $row['correosucursal'];
    ################## DATOS DE CONFIGURACION #####################

	#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################
	$smtp=new PHPMailer();
	$smtp->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);

	# Indicamos que vamos a utilizar un servidor SMTP
	$smtp->IsSMTP();

    # Definimos el formato del correo con UTF-8
	$smtp->CharSet="UTF-8";

    # autenticación contra nuestro servidor smtp
	$smtp->Port = 465;
	$smtp->IsSMTP(); // use SMTP
	$smtp->SMTPAuth   = true;
	$smtp->SMTPSecure = 'ssl';						// enable SMTP authentication
	$smtp->Host       = "smtp.gmail.com";			// sets MAIL as the SMTP server
	$smtp->Username   = $correo;	// MAIL username
	$smtp->Password   = "**********";			// MAIL password

	# datos de quien realiza el envio
	$smtp->From       = $correo; // from mail
	$smtp->FromName   = portales(utf8_decode($_POST['name'])); // from mail name

	# Indicamos las direcciones donde enviar el mensaje con el formato
	#   "correo"=>"nombre usuario"
	# Se pueden poner tantos correos como se deseen

	# establecemos un limite de caracteres de anchura
	$smtp->WordWrap   = 50; // set word wrap

	# NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
	# cualquier programa de correo pueda leerlo.

	# Definimos el contenido HTML del correo
	$contenidoHTML="<head>";
	$contenidoHTML.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
	$contenidoHTML.="</head><body>";
	$contenidoHTML.="<b>".$_POST['subject']."</b>";
	$contenidoHTML.="<p>SR(A) ".$_POST['name']."</p>";
	$contenidoHTML.="<p>".$_POST['email']."</p>";
	$contenidoHTML.="<p>".$_POST['message']."</p>";
	$contenidoHTML.="</body>\n";

	# Definimos el contenido en formato Texto del correo
	$contenidoTexto="".$_POST['subject']."";
	$contenidoTexto.="\n\n";

	# Definimos el subject
	$smtp->Subject="".$_POST['subject']."";

	# Adjuntamos el archivo al correo.
    $smtp->AddAttachment("fotos/logo_principal.png", "logo.png");
	//$smtp->AddAttachment("");

	# Indicamos el contenido
	$smtp->AltBody=$contenidoTexto; //Text Body
	$smtp->MsgHTML($contenidoHTML); //Text body HTML

	$smtp->ClearAllRecipients();
	$smtp->AddAddress($correo,portales(utf8_decode($nomsucursal)));

	//$smtp->Send();
	//Enviamos email
	//if(!$smtp->Send()) {

		$query = "INSERT INTO mensajes values (null, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $name);
		$stmt->bindParam(2, $phone);
		$stmt->bindParam(3, $email);
		$stmt->bindParam(4, $subject);
		$stmt->bindParam(5, $message);
		$stmt->bindParam(6, $fecha);

		$name = limpiar($_POST["name"]);
		$phone = limpiar($_POST["phone"]);
		$email = limpiar($_POST["email"]);
		$subject = limpiar($_POST["subject"]);
		$message = limpiar($_POST["message"]);
		$fecha = limpiar(date("Y-m-d H:i:s"));
		$stmt->execute();

	    echo "<span class='fa fa-check-square-o'></span> EL MENSAJE HA SIDO ENVIADO EXITOSAMENTE, PRONTO LE RESPONDEREMOS, GRACIAS POR PREFERIRNOS";
	    exit;
}
############################# FUNCION ENVIAR MENSAJE EN CONTACTO ###############################

######################## FUNCION LISTAR MENSAJES DE CONTACTO ###############################
public function ListarMensajes()
{
	self::SetNames();
	$sql = "SELECT * FROM mensajes ORDER BY fecha DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR MENSAJES DE CONTACTO ##########################

############################ FUNCION ID MENSAJES DE CONTACTO #################################
public function MensajesPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM mensajes WHERE codmensaje = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmensaje"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}		
############################ FUNCION ID MENSAJES DE CONTACTO #################################

########################## FUNCION ELIMINAR MENSAJES DE CONTACTO ########################
public function EliminarMensajes()
{
	self::SetNames();
    if($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "DELETE FROM mensajes WHERE codmensaje = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codmensaje);
		$codmensaje = decrypt($_GET["codmensaje"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 	
}
############################ FUNCION ELIMINAR MENSAJES DE CONTACTO #######################

#################### FIN DE FUNCION CONFIGURACION GENERAL DEL SISTEMA ##################























################################## CLASE USUARIOS #####################################

############################## FUNCION REGISTRAR USUARIOS ##############################
public function RegistrarUsuarios()
{
	self::SetNames();
	if(empty($_POST["nombres"]) or empty($_POST["usuario"]) or empty($_POST["password"]))
	{
		echo "1";
		exit;
	}
	elseif($_SESSION['acceso'] == "administradorG" && $_POST["nivel"] != "ADMINISTRADOR(A) GENERAL")
	{
		if (empty($_POST['codsucursal'])) 
		{
        echo "2";
        exit;
        }
	}

	$sql = "SELECT dni FROM usuarios WHERE dni = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["dni"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		
		echo "3";
		exit;
	}
	else
	{
	$sql = "SELECT email FROM usuarios WHERE email = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["email"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{

		echo "4";
		exit;
	}
	else
	{
	$sql = "SELECT usuario FROM usuarios WHERE usuario = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["usuario"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		
	    ######################### CODIGO DE ESPECIALISTA #########################
		$sql = "SELECT codigo FROM usuarios ORDER BY idusuario DESC LIMIT 1";
		foreach ($this->dbh->query($sql) as $row){

			$id=$row["codigo"];

		}
		if(empty($id))
		{
			$codigo = "U1";

		} else {

			$resto = substr($id, 0, 1);
			$coun = strlen($resto);
			$num     = substr($id, $coun);
			$var     = $num + 1;
			$codigo = "U".$var;
		}
	    ######################### CODIGO DE ESPECIALISTA #########################

	    $query = "INSERT INTO usuarios values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codigo);
		$stmt->bindParam(2, $dni);
		$stmt->bindParam(3, $nombres);
		$stmt->bindParam(4, $sexo);
		$stmt->bindParam(5, $direccion);
		$stmt->bindParam(6, $telefono);
		$stmt->bindParam(7, $email);
		$stmt->bindParam(8, $usuario);
		$stmt->bindParam(9, $password);
		$stmt->bindParam(10, $nivel);
		$stmt->bindParam(11, $status);

		$dni = limpiar($_POST["dni"]);
		$nombres = limpiar($_POST["nombres"]);
		$sexo = limpiar($_POST["sexo"]);
		$direccion = limpiar($_POST["direccion"]);
		$telefono = limpiar($_POST["telefono"]);
		$email = limpiar($_POST["email"]);
		$usuario = limpiar($_POST["usuario"]);
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$nivel = limpiar($_POST["nivel"]);
		$status = limpiar($_POST["status"]);
		$stmt->execute();

		if($_SESSION['acceso'] == "administradorG" && isset($_POST["codsucursal"])){

			###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
			for($i=0;$i<count($_POST['codsucursal']);$i++){  //recorro el array
	            if (!empty($_POST['codsucursal'][$i])) {

	            $query = "INSERT INTO accesosxsucursales values (null, ?, ?); ";
			    $stmt = $this->dbh->prepare($query);
			    $stmt->bindParam(1, $codigo);
			    $stmt->bindParam(2, $codsucursal);
				
			    $codsucursal = limpiar($_POST["codsucursal"][$i]);
			    $stmt->execute();
			
			    } 
		    }
		    ###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################

		} elseif($_SESSION['acceso'] == "administradorG" && $_POST["nivel"] == "ADMINISTRADOR(A) GENERAL"){

			###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
	        $query = "INSERT INTO accesosxsucursales values (null, ?, ?); ";
		    $stmt = $this->dbh->prepare($query);
		    $stmt->bindParam(1, $codigo);
		    $stmt->bindParam(2, $codsucursal);
			
		    $codsucursal = limpiar("0");
		    $stmt->execute();
		    ###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################

		} elseif($_SESSION['acceso'] == "administradorS") {

			###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
	        $query = "INSERT INTO accesosxsucursales values (null, ?, ?); ";
		    $stmt = $this->dbh->prepare($query);
		    $stmt->bindParam(1, $codigo);
		    $stmt->bindParam(2, $codsucursal);
			
		    $codsucursal = limpiar($_SESSION["codsucursal"]);
		    $stmt->execute();
		    ###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
		}

		################## SUBIR FOTO DE USUARIOS ######################################
         //datos del arhivo  
				if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
				if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
				if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
         //compruebo si las características del archivo son las que deseo  
				if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) 
				{  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["dni"].".jpg"))
					{ 
		 ## se puede dar un aviso
					} 
		 ## se puede dar otro aviso 
				}
		################## FINALIZA SUBIR FOTO DE USUARIOS ##################

				echo "<span class='fa fa-check-square-o'></span> EL USUARIO HA SIDO REGISTRADO EXITOSAMENTE";
				exit;
			}
			else
			{
				echo "5";
				exit;
			}
		}
	}
}
############################# FUNCION REGISTRAR USUARIOS ###############################

############################# FUNCION LISTAR USUARIOS ################################
public function ListarUsuarios()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	usuarios.idusuario,
	usuarios.codigo, 
	usuarios.dni,
	usuarios.nombres,
	usuarios.sexo,
	usuarios.direccion,
	usuarios.telefono,
	usuarios.email,
	usuarios.usuario,
	usuarios.password,
	usuarios.nivel,
	usuarios.status,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM usuarios LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	GROUP BY usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    } elseif ($_SESSION['acceso'] == "cajero" || $_SESSION['acceso'] == "secretaria") {

	$sql = "SELECT 
	usuarios.idusuario,
	usuarios.codigo, 
	usuarios.dni,
	usuarios.nombres,
	usuarios.sexo,
	usuarios.direccion,
	usuarios.telefono,
	usuarios.email,
	usuarios.usuario,
	usuarios.password,
	usuarios.nivel,
	usuarios.status,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM usuarios LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	WHERE usuarios.codigo = '".limpiar($_SESSION["codigo"])."'
	AND accesosxsucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    } else {

   $sql = "SELECT 
	usuarios.idusuario,
	usuarios.codigo, 
	usuarios.dni,
	usuarios.nombres,
	usuarios.sexo,
	usuarios.direccion,
	usuarios.telefono,
	usuarios.email,
	usuarios.usuario,
	usuarios.password,
	usuarios.nivel,
	usuarios.status,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM usuarios LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal 
	WHERE accesosxsucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     }
}
############################## FUNCION LISTAR USUARIOS ################################

############################# FUNCION LISTAR TIPOS USUARIOS ################################
public function ListarTiposUsuarios()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	usuarios.idusuario,
	usuarios.codigo, 
	usuarios.dni,
	usuarios.nombres,
	usuarios.sexo,
	usuarios.direccion,
	usuarios.telefono,
	usuarios.email,
	usuarios.usuario,
	usuarios.password,
	usuarios.nivel,
	usuarios.status,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM usuarios LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	WHERE usuarios.nivel != 'ADMINISTRADOR(A) GENERAL'
	GROUP BY usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    } else {

   $sql = "SELECT 
	usuarios.idusuario,
	usuarios.codigo, 
	usuarios.dni,
	usuarios.nombres,
	usuarios.sexo,
	usuarios.direccion,
	usuarios.telefono,
	usuarios.email,
	usuarios.usuario,
	usuarios.password,
	usuarios.nivel,
	usuarios.status,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM usuarios LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal 
	WHERE accesosxsucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     }
}
############################## FUNCION LISTAR TIPOS USUARIOS ################################

########################## FUNCION BUSQUEDA DE LOGS DE USUARIOS ###############################
public function BusquedaLogs()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    $sql = "SELECT * FROM log WHERE CONCAT(ip, ' ',tiempo, ' ',detalles, ' ',usuario) LIKE '%".$buscar."%' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE LOGS DE USUARIOS ###############################

########################### FUNCION LISTAR LOGS DE USUARIOS ###########################
public function ListarLogs()
{
	self::SetNames();
	$sql = "SELECT * FROM log";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

   }
########################### FUNCION LISTAR LOGS DE USUARIOS ###########################

############################ FUNCION ID USUARIOS #################################
public function UsuariosPorId()
{
	self::SetNames();
	$sql = "SELECT 
	usuarios.idusuario,
	usuarios.codigo, 
	usuarios.dni,
	usuarios.nombres,
	usuarios.sexo,
	usuarios.direccion,
	usuarios.telefono,
	usuarios.email,
	usuarios.usuario,
	usuarios.password,
	usuarios.nivel,
	usuarios.status,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM usuarios LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	WHERE usuarios.codigo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codigo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID USUARIOS #################################

############################ FUNCION ACTUALIZAR USUARIOS ############################
public function ActualizarUsuarios()
{

	self::SetNames();
	if(empty($_POST["dni"]) or empty($_POST["nombres"]) or empty($_POST["usuario"]) or empty($_POST["password"]))
	{
		echo "1";
		exit;
	}
	elseif($_SESSION['acceso'] == "administradorG" && $_POST["nivel"] != "ADMINISTRADOR(A) GENERAL")
	{
		if (empty($_POST['codsucursal'])) 
		{
        echo "2";
        exit;
        }
	}

	$sql = "SELECT * FROM usuarios WHERE codigo != ? AND dni = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codigo"],$_POST["dni"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		echo "3";
		exit;
	}
	else
	{
	$sql = "SELECT email FROM usuarios WHERE codigo != ? AND email = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codigo"],$_POST["email"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		echo "4";
		exit;
	}
	else
	{
	$sql = "SELECT usuario FROM usuarios WHERE codigo != ? AND usuario = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codigo"],$_POST["usuario"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " UPDATE usuarios set "
		." dni = ?, "
		." nombres = ?, "
		." sexo = ?, "
		." direccion = ?, "
		." telefono = ?, "
		." email = ?, "
		." usuario = ?, "
		." password = ?, "
		." nivel = ?, "
		." status = ? "
		." where "
		." codigo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $dni);
		$stmt->bindParam(2, $nombres);
		$stmt->bindParam(3, $sexo);
		$stmt->bindParam(4, $direccion);
		$stmt->bindParam(5, $telefono);
		$stmt->bindParam(6, $email);
		$stmt->bindParam(7, $usuario);
		$stmt->bindParam(8, $password);
		$stmt->bindParam(9, $nivel);
		$stmt->bindParam(10, $status);
		$stmt->bindParam(11, $codigo);

		$dni = limpiar($_POST["dni"]);
		$nombres = limpiar($_POST["nombres"]);
		$sexo = limpiar($_POST["sexo"]);
		$direccion = limpiar($_POST["direccion"]);
		$telefono = limpiar($_POST["telefono"]);
		$email = limpiar($_POST["email"]);
		$usuario = limpiar($_POST["usuario"]);
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$nivel = limpiar($_POST["nivel"]);
		$status = limpiar($_POST["status"]);
		$codigo = limpiar($_POST["codigo"]);
		$stmt->execute();

		if($_SESSION['acceso'] == "administradorG" && isset($_POST["codsucursal"])){

			###################### ELIMINO LAS SUCURSALES ASIGNADAS ######################
			$sql = "DELETE FROM accesosxsucursales WHERE codusuario = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codigo);
			$codigo = limpiar($_POST["codigo"]);
			$stmt->execute();
			###################### ELIMINO LAS SUCURSALES ASIGNADAS ######################

			###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
			for($i=0;$i<count($_POST['codsucursal']);$i++){  //recorro el array
	            if (!empty($_POST['codsucursal'][$i])) {

	            $query = "INSERT INTO accesosxsucursales values (null, ?, ?); ";
			    $stmt = $this->dbh->prepare($query);
			    $stmt->bindParam(1, $codigo);
			    $stmt->bindParam(2, $codsucursal);
				
			    $codigo = limpiar($_POST["codigo"]);
			    $codsucursal = limpiar($_POST["codsucursal"][$i]);
			    $stmt->execute();
			
			    } 
		    }
		    ###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################

		} elseif($_SESSION['acceso'] == "administradorG" && $_POST["nivel"] == "ADMINISTRADOR(A) GENERAL"){

			###################### ELIMINO LAS SUCURSALES ASIGNADAS ######################
			$sql = "DELETE FROM accesosxsucursales WHERE codusuario = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codigo);
			$codigo = limpiar($_POST["codigo"]);
			$stmt->execute();
			###################### ELIMINO LAS SUCURSALES ASIGNADAS ######################

			###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
	        $query = "INSERT INTO accesosxsucursales values (null, ?, ?); ";
		    $stmt = $this->dbh->prepare($query);
		    $stmt->bindParam(1, $codigo);
		    $stmt->bindParam(2, $codsucursal);
			
		    $codigo = limpiar($_POST["codigo"]);
		    $codsucursal = limpiar("0");
		    $stmt->execute();
		    ###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
		}

		################## SUBIR FOTO DE USUARIOS ######################################
         //datos del arhivo  
				if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
				if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
				if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
         //compruebo si las características del archivo son las que deseo  
				if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) 
				{  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["dni"].".jpg"))
					{ 
		 ## se puede dar un aviso
					} 
		 ## se puede dar otro aviso 
				}
		################## FINALIZA SUBIR FOTO DE USUARIOS ######################################

				echo "<span class='fa fa-check-square-o'></span> EL USUARIO HA SIDO ACTUALIZADO EXITOSAMENTE";
				exit;

			}
			else
			{
				echo "5";
				exit;
			}
		}
	}
}
############################ FUNCION ACTUALIZAR USUARIOS ############################

############################# FUNCION ELIMINAR USUARIOS ################################
public function EliminarUsuarios()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codigo FROM citas WHERE codigo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codigo"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM usuarios WHERE codigo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codigo);
		$codigo = decrypt($_GET["codigo"]);
		$stmt->execute();

		$sql = "DELETE FROM accesosxsucursales WHERE codusuario = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codigo);
		$codigo = decrypt($_GET["codigo"]);
		$stmt->execute();

		$dni = decrypt($_GET["dni"]);
		if (file_exists("fotos/".$dni.".jpg")){
	    //funcion para eliminar una carpeta con contenido
		$archivos = "fotos/".$dni.".jpg";		
		unlink($archivos);
		}

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
############################## FUNCION ELIMINAR USUARIOS ##############################

######################## FUNCION BUSCAR USUARIOS POR SUCURSAL ##########################
public function BuscarUsuariosxSucursal() 
	{
	self::SetNames();
	$sql = "SELECT * FROM usuarios 
	LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	WHERE accesosxsucursales.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<option value=''> -- SIN RESULTADOS -- </option>";
		exit;
	}
	else
	{
	while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION BUSCAR USUARIOS POR SUCURSAL ##########################

################### FUNCION SELECCIONA USUARIO POR CODIGO Y SUCURSAL ###################
public function BuscarUsuariosxCodigo() 
	       {
		self::SetNames();
	$sql = " SELECT * FROM usuarios WHERE codigo = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_GET["codigo"],decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();
		    if($num==0)
		{
			echo "<option value=''> -- SIN RESULTADOS -- </option>";
			exit;
		       }
		else
		{
		while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################### FUNCION SELECCIONA USUARIO POR CODIGO Y SUCURSAL ##################

############################ FIN DE CLASE USUARIOS ################################





















################################## CLASE HORARIO DE USUARIOS ######################################

############################ FUNCION REGISTRAR HORARIO DE USUARIOS ###############################
public function RegistrarHorariosUsuarios()
{
	self::SetNames();
	if(empty($_POST["codigo"]) or empty($_POST["hora_desde"]) or empty($_POST["hora_hasta"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT * FROM horarios WHERE codigo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codigo"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " INSERT INTO horarios values (null, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codigo);
		$stmt->bindParam(2, $hora_desde);
		$stmt->bindParam(3, $hora_hasta);
		$stmt->bindParam(4, $busqueda);

		$codigo = limpiar(decrypt($_POST["codigo"]));
		$hora_desde = limpiar($_POST["hora_desde"]);
		$hora_hasta = limpiar($_POST["hora_hasta"]);
		$busqueda = limpiar("1");
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL HORARIO DE ACCESO HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
############################ FUNCION REGISTRAR HORARIO DE USUARIOS ###############################

############################## FUNCION LISTAR HORARIO DE USUARIOS ################################
public function ListarHorariosUsuarios()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	usuarios.idusuario,
	usuarios.codigo, 
	usuarios.dni,
	usuarios.nombres,
	usuarios.sexo,
	usuarios.telefono,
	usuarios.nivel,
	horarios.codhorario,
	horarios.codigo,
	horarios.hora_desde,
	horarios.hora_hasta,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM horarios INNER JOIN usuarios ON horarios.codigo = usuarios.codigo 
	LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal 
	GROUP BY usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    } else {

   $sql = "SELECT 
	usuarios.idusuario,
	usuarios.codigo, 
	usuarios.dni,
	usuarios.nombres,
	usuarios.sexo,
	usuarios.telefono,
	usuarios.nivel,
	horarios.codhorario,
	horarios.codigo,
	horarios.hora_desde,
	horarios.hora_hasta,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM horarios INNER JOIN usuarios ON horarios.codigo = usuarios.codigo 
	LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal 
	WHERE accesosxsucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     }
}
################################## FUNCION LISTAR HORARIO DE USUARIOS ################################

############################ FUNCION ID HORARIO DE USUARIOS #################################
public function HorariosUsuariosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM horarios 
	INNER JOIN usuarios ON horarios.codigo = usuarios.codigo 
	WHERE horarios.codhorario = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codhorario"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID HORARIO DE USUARIOS #################################

############################ FUNCION ACTUALIZAR HORARIO DE USUARIOS ############################
public function ActualizarHorariosUsuarios()
{

	self::SetNames();
	if(empty($_POST["codhorario"]) or empty($_POST["codigo"]) or empty($_POST["hora_desde"]) or empty($_POST["hora_hasta"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT * FROM horarios WHERE codhorario != ? AND codigo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codhorario"],decrypt($_POST["codigo"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " UPDATE horarios set "
		." codigo = ?, "
		." hora_desde = ?, "
		." hora_hasta = ? "
		." where "
		." codhorario = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codigo);
		$stmt->bindParam(2, $hora_desde);
		$stmt->bindParam(3, $hora_hasta);
		$stmt->bindParam(4, $codhorario);

		$codigo = limpiar(decrypt($_POST["codigo"]));
		$hora_desde = limpiar($_POST["hora_desde"]);
		$hora_hasta = limpiar($_POST["hora_hasta"]);
		$codhorario = limpiar($_POST["codhorario"]);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL HORARIO DE ACCESO HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR HORARIO DE USUARIOS ############################

########################### FUNCION ELIMINAR HORARIO DE USUARIOS #################################
public function EliminarHorariosUsuarios()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "DELETE FROM horarios WHERE codhorario = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codhorario);
	$codhorario = decrypt($_GET["codhorario"]);
	$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
}
########################### FUNCION ELIMINAR HORARIO DE USUARIOS #################################

############################## FIN DE CLASE HORARIO DE USUARIOS ###################################

























################################## CLASE HORARIO DE ESPECIALISTAS ######################################

############################ FUNCION REGISTRAR HORARIO DE ESPECIALISTAS ###############################
public function RegistrarHorariosEspecialistas()
{
	self::SetNames();
	if(empty($_POST["codespecialista"]) or empty($_POST["hora_desde"]) or empty($_POST["hora_hasta"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT * FROM horarios WHERE codigo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codespecialista"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " INSERT INTO horarios values (null, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codespecialista);
		$stmt->bindParam(2, $hora_desde);
		$stmt->bindParam(3, $hora_hasta);
		$stmt->bindParam(4, $busqueda);

		$codespecialista = limpiar(decrypt($_POST["codespecialista"]));
		$hora_desde = limpiar($_POST["hora_desde"]);
		$hora_hasta = limpiar($_POST["hora_hasta"]);
		$busqueda = limpiar("1");
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL HORARIO DE ACCESO HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
############################ FUNCION REGISTRAR HORARIO DE ESPECIALISTAS ###############################

############################## FUNCION LISTAR HORARIO DE ESPECIALISTAS ################################
public function ListarHorariosEspecialistas()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	especialistas.codespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.sexoespecialista,
	especialistas.especialidad,
	horarios.codhorario,
	horarios.codigo,
	horarios.hora_desde,
	horarios.hora_hasta,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM horarios INNER JOIN especialistas ON horarios.codigo = especialistas.codespecialista 
	LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal 
	GROUP BY especialistas.codespecialista";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    } else {

   $sql = "SELECT 
	especialistas.codespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.sexoespecialista,
	especialistas.especialidad,
	horarios.codhorario,
	horarios.codigo,
	horarios.hora_desde,
	horarios.hora_hasta,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM horarios INNER JOIN especialistas ON horarios.codigo = especialistas.codespecialista 
	LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	WHERE accesosxsucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY especialistas.codespecialista";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     }
}
################################## FUNCION LISTAR HORARIO DE ESPECIALISTAS ################################

############################ FUNCION ID HORARIO DE ESPECIALISTAS #################################
public function HorariosEspecialistasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM horarios 
	INNER JOIN especialistas ON horarios.codigo = especialistas.codespecialista 
	WHERE horarios.codhorario = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codhorario"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID HORARIO DE ESPECIALISTAS #################################

############################ FUNCION ACTUALIZAR HORARIO DE ESPECIALISTAS ############################
public function ActualizarHorariosEspecialistas()
{

	self::SetNames();
	if(empty($_POST["codhorario"]) or empty($_POST["codespecialista"]) or empty($_POST["hora_desde"]) or empty($_POST["hora_hasta"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT * FROM horarios WHERE codhorario != ? AND codigo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codhorario"],decrypt($_POST["codespecialista"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " UPDATE horarios set "
		." codigo = ?, "
		." hora_desde = ?, "
		." hora_hasta = ? "
		." where "
		." codhorario = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codespecialista);
		$stmt->bindParam(2, $hora_desde);
		$stmt->bindParam(3, $hora_hasta);
		$stmt->bindParam(4, $codhorario);

		$codespecialista = limpiar(decrypt($_POST["codespecialista"]));
		$hora_desde = limpiar($_POST["hora_desde"]);
		$hora_hasta = limpiar($_POST["hora_hasta"]);
		$codhorario = limpiar($_POST["codhorario"]);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL HORARIO DE ACCESO HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR HORARIO DE ESPECIALISTAS ############################

########################### FUNCION ELIMINAR HORARIO DE ESPECIALISTAS #################################
public function EliminarHorariosEspecialistas()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "DELETE FROM horarios WHERE codhorario = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codhorario);
	$codhorario = decrypt($_GET["codhorario"]);
	$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
}
########################### FUNCION ELIMINAR HORARIO DE ESPECIALISTAS #################################

############################## FIN DE CLASE HORARIO DE ESPECIALISTAS ###################################

























############################### CLASE DEPARTAMENTOS ################################

############################# FUNCION REGISTRAR DEPARTAMENTOS ###########################
public function RegistrarDepartamentos()
{
	self::SetNames();
	if(empty($_POST["departamento"]))
	{
		echo "1";
		exit;
	}

		$sql = " SELECT departamento FROM departamentos WHERE departamento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["departamento"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " INSERT INTO departamentos values (null, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $departamento);

			$departamento = limpiar($_POST["departamento"]);
			$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> EL DEPARTAMENTO HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
########################### FUNCION REGISTRAR DEPARTAMENTOS ########################

########################## FUNCION PARA LISTAR DEPARTAMENTOS ##########################
public function ListarDepartamentos()
{
	self::SetNames();
	$sql = "SELECT * FROM departamentos";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
######################### FUNCION PARA LISTAR DEPARTAMENTOS ##########################

############################ FUNCION ID DEPARTAMENTOS #################################
public function DepartamentosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM departamentos WHERE id_departamento = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["id_departamento"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID DEPARTAMENTOS #################################

######################## FUNCION ACTUALIZAR DEPARTAMENTOS ############################
public function ActualizarDepartamentos()
{
	self::SetNames();
	if(empty($_POST["id_departamento"]) or empty($_POST["departamento"]))
	{
		echo "1";
		exit;
	}

		$sql = "SELECT departamento FROM departamentos WHERE id_departamento != ? AND departamento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["id_departamento"],$_POST["departamento"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = " UPDATE departamentos set "
			." departamento = ? "
			." where "
			." id_departamento = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $departamento);
			$stmt->bindParam(2, $id_departamento);

			$departamento = limpiar($_POST["departamento"]);
			$id_departamento = limpiar($_POST['id_departamento']);
			$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> EL DEPARTAMENTO HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR DEPARTAMENTOS #######################

############################ FUNCION ELIMINAR DEPARTAMENTOS ###########################
public function EliminarDepartamentos()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT id_departamento FROM provincias WHERE id_departamento = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["id_departamento"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM provincias WHERE id_departamento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$id_departamento);
		$id_departamento = decrypt($_GET["id_departamento"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
	   
		echo "2";
		exit;
	} 
		
	} else {
	
	    echo "3";
	    exit;
    }	
}
########################### FUNCION ELIMINAR DEPARTAMENTOS ############################

############################## FIN DE CLASE DEPARTAMENTOS ##############################

























############################### CLASE PROVINCIAS ################################

############################# FUNCION REGISTRAR PROVINCIAS ###########################
public function RegistrarProvincias()
{
	self::SetNames();
	if(empty($_POST["provincia"]) or empty($_POST["id_departamento"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT provincia FROM provincias WHERE provincia = ? AND id_departamento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["provincia"],$_POST["id_departamento"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO provincias values (null, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $provincia);
				$stmt->bindParam(2, $id_departamento);

				$provincia = limpiar($_POST["provincia"]);
				$id_departamento = limpiar($_POST['id_departamento']);
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> LA PROVINCIA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
########################### FUNCION REGISTRAR PROVINCIAS ########################

########################## FUNCION PARA LISTAR PROVINCIAS ##########################
	public function ListarProvincias()
	{
		self::SetNames();
		$sql = "SELECT * FROM provincias LEFT JOIN departamentos ON provincias.id_departamento = departamentos.id_departamento";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
######################### FUNCION PARA LISTAR PROVINCIAS ##########################

############################ FUNCION ID PROVINCIAS #################################
public function ProvinciasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM provincias LEFT JOIN departamentos ON provincias.id_departamento = departamentos.id_departamento WHERE provincias.id_provincia = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["id_provincia"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PROVINCIAS #################################

######################## FUNCION ACTUALIZAR PROVINCIAS ############################
public function ActualizarProvincias()
{
	self::SetNames();
	if(empty($_POST["id_provincia"]) or empty($_POST["provincia"]) or empty($_POST["id_departamento"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT provincia FROM provincias WHERE id_provincia != ? AND provincia = ? AND id_departamento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["id_provincia"],$_POST["provincia"],$_POST["id_departamento"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE provincias set "
				." provincia = ?, "
				." id_departamento = ? "
				." where "
				." id_provincia = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $provincia);
				$stmt->bindParam(2, $id_departamento);
				$stmt->bindParam(3, $codprovincia);

				$provincia = limpiar($_POST["provincia"]);
				$id_departamento = limpiar($_POST['id_departamento']);
				$id_provincia = limpiar($_POST['id_provincia']);
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> LA PROVINCIA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR PROVINCIAS #######################

############################ FUNCION ELIMINAR PROVINCIAS ###########################
public function EliminarProvincias()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT id_provincia FROM sucursales WHERE id_provincia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["id_provincia"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM provincias WHERE id_provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$id_provincia);
			$id_provincia = decrypt($_GET["id_provincia"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR PROVINCIAS ############################

###################### FUNCION LISTAR DEPARTAMENTOS POR PROVINCIAS #####################
	public function ListarProvinciasXDepartamento() 
	       {
		self::SetNames();
		$sql = "SELECT * FROM provincias WHERE id_departamento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_GET["id_departamento"]));
		$num = $stmt->rowCount();
		    if($num==0)
		{
			echo "<option value=''> -- SIN RESULTADOS -- </option>";
			exit;
		}
		else
		{
		while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
##################### FUNCION LISTAR DEPARTAMENTOS POR PROVINCIAS ######################

################# FUNCION PARA SELECCIONAR PROVINCIAS POR DEPARTAMENTOS #################
	public function SeleccionaProvincia()
	{
		self::SetNames();
		$sql = "SELECT * FROM provincias WHERE id_departamento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_GET["id_departamento"]));
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "<option value=''> -- SIN RESULTADOS -- </option>";
			exit;
		}
		else
		{
			while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################# FUNCION PARA SELECCIONAR PROVINCIAS POR DEPARTAMENTOS ################

############################## FIN DE CLASE PROVINCIAS ##############################



























################################ CLASE TIPOS DE DOCUMENTOS ##############################

########################### FUNCION REGISTRAR TIPO DE DOCUMENTOS ########################
public function RegistrarDocumentos()
{
	self::SetNames();
	if(empty($_POST["documento"]) or empty($_POST["descripcion"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT * FROM documentos WHERE documento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["documento"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = "INSERT INTO documentos values (null, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $documento);
				$stmt->bindParam(2, $descripcion);

				$documento = limpiar($_POST["documento"]);
				$descripcion = limpiar($_POST["descripcion"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE DOCUMENTO HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
############################ FUNCION REGISTRAR TIPO DE MONEDA ########################

########################## FUNCION LISTAR TIPO DE MONEDA ################################
public function ListarDocumentos()
{
	self::SetNames();
	$sql = "SELECT * FROM documentos ORDER BY documento ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
######################### FUNCION LISTAR TIPO DE DOCUMENTOS ##########################

######################### FUNCION ID TIPO DE DOCUMENTOS ###############################
public function DocumentosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM documentos WHERE coddocumento = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["coddocumento"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION ID TIPO DE DOCUMENTOS #########################

######################### FUNCION ACTUALIZAR TIPO DE DOCUMENTOS ########################
public function ActualizarDocumentos()
{

	self::SetNames();
	if(empty($_POST["coddocumento"]) or empty($_POST["documento"]) or empty($_POST["descripcion"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT documento FROM documentos WHERE coddocumento != ? AND documento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["coddocumento"],$_POST["documento"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE documentos set "
				." documento = ?, "
				." descripcion = ? "
				." where "
				." coddocumento = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $documento);
				$stmt->bindParam(2, $descripcion);
				$stmt->bindParam(3, $coddocumento);

				$documento = limpiar($_POST["documento"]);
				$descripcion = limpiar($_POST["descripcion"]);
				$coddocumento = limpiar($_POST["coddocumento"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE DOCUMENTO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
####################### FUNCION ACTUALIZAR TIPO DE DOCUMENTOS #######################

######################### FUNCION ELIMINAR TIPO DE DOCUMENTOS #########################
public function EliminarDocumentos()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT documsucursal FROM configuracion WHERE documsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddocumento"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM documentos WHERE coddocumento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$coddocumento);
			$coddocumento = decrypt($_GET["coddocumento"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
######################## FUNCION ELIMINAR TIPOS DE DOCUMENTOS ###########################

########################### FIN DE CLASE TIPOS DE DOCUMENTOS ###########################



























############################### CLASE TIPOS DE MONEDAS ##############################

############################ FUNCION REGISTRAR TIPO DE MONEDA ##########################
public function RegistrarTipoMoneda()
{
	self::SetNames();
	if(empty($_POST["moneda"]) or empty($_POST["moneda"]) or empty($_POST["simbolo"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT * FROM tiposmoneda WHERE moneda = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["moneda"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO tiposmoneda values (null, ?, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $moneda);
				$stmt->bindParam(2, $siglas);
				$stmt->bindParam(3, $simbolo);

				$moneda = limpiar($_POST["moneda"]);
				$siglas = limpiar($_POST["siglas"]);
				$simbolo = limpiar($_POST["simbolo"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE MONEDA HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
######################### FUNCION REGISTRAR TIPO DE MONEDA #######################

########################## FUNCION LISTAR TIPO DE MONEDA ################################
public function ListarTipoMoneda()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposmoneda";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR TIPO DE MONEDA #########################

############################ FUNCION ID TIPO DE MONEDA #################################
public function TipoMonedaPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposmoneda WHERE codmoneda = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmoneda"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID TIPO DE MONEDA #################################

####################### FUNCION ACTUALIZAR TIPO DE MONEDA ###########################
public function ActualizarTipoMoneda()
{

	self::SetNames();
	if(empty($_POST["codmoneda"]) or empty($_POST["moneda"]) or empty($_POST["siglas"]) or empty($_POST["simbolo"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT moneda FROM tiposmoneda WHERE codmoneda != ? AND moneda = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codmoneda"],$_POST["moneda"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE tiposmoneda set "
				." moneda = ?, "
				." siglas = ?, "
				." simbolo = ? "
				." where "
				." codmoneda = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $moneda);
				$stmt->bindParam(2, $siglas);
				$stmt->bindParam(3, $simbolo);
				$stmt->bindParam(4, $codmoneda);

				$moneda = limpiar($_POST["moneda"]);
				$siglas = limpiar($_POST["siglas"]);
				$simbolo = limpiar($_POST["simbolo"]);
				$codmoneda = limpiar($_POST["codmoneda"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE MONEDA HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
######################## FUNCION ACTUALIZAR TIPO DE MONEDA ############################

######################### FUNCION ELIMINAR TIPO DE MONEDA ###########################
public function EliminarTipoMoneda()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codmoneda FROM tiposcambio WHERE codmoneda = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codmoneda"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM tiposmoneda WHERE codmoneda = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codmoneda);
			$codmoneda = decrypt($_GET["codmoneda"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR TIPOS DE MONEDAS ########################

##################### FUNCION BUSCAR TIPOS DE CAMBIOS POR MONEDA #######################
public function BuscarTiposCambios()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposmoneda INNER JOIN tiposcambio ON tiposmoneda.codmoneda = tiposcambio.codmoneda WHERE tiposcambio.codmoneda = ? ORDER BY tiposcambio.codcambio DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmoneda"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE CAMBIO PARA LA MONEDA SELECCIONADA</div></center>";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
##################### FUNCION BUSCAR TIPOS DE CAMBIOS POR MONEDA #####################

############################# FIN DE CLASE TIPOS DE MONEDAS #############################
























############################## CLASE TIPOS DE CAMBIOS ################################

########################## FUNCION REGISTRAR TIPO DE CAMBIO #########################
public function RegistrarTipoCambio()
{
	self::SetNames();
	if(empty($_POST["descripcioncambio"]) or empty($_POST["montocambio"]) or empty($_POST["codmoneda"]) or empty($_POST["fechacambio"]))
	{
		echo "1";
		exit;
	}
			
		$sql = "SELECT codmoneda, fechacambio FROM tiposcambio WHERE codmoneda = ? AND fechacambio = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codmoneda"],date("Y-m-d",strtotime($_POST['fechacambio']))));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO tiposcambio values (null, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $descripcioncambio);
			$stmt->bindParam(2, $montocambio);
			$stmt->bindParam(3, $codmoneda);
			$stmt->bindParam(4, $fechacambio);

			$descripcioncambio = limpiar($_POST["descripcioncambio"]);
			$montocambio = number_format($_POST["montocambio"], 3, '.', '');
			$codmoneda = limpiar($_POST["codmoneda"]);
			$fechacambio = limpiar(date("Y-m-d",strtotime($_POST['fechacambio'])));
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE CAMBIO HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
######################### FUNCION REGISTRAR TIPO DE CAMBIO ########################

########################### FUNCION LISTAR TIPO DE CAMBIO ########################
public function ListarTipoCambio()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposcambio INNER JOIN tiposmoneda ON tiposcambio.codmoneda = tiposmoneda.codmoneda";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
######################### FUNCION LISTAR TIPO DE CAMBIO ################################

######################## FUNCION ID TIPO DE CAMBIO #################################
public function TipoCambioPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposcambio INNER JOIN tiposmoneda ON tiposcambio.codmoneda = tiposmoneda.codmoneda WHERE tiposcambio.codcambio = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcambio"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID TIPO DE CAMBIO #################################

####################### FUNCION ACTUALIZAR TIPO DE CAMBIO ############################
public function ActualizarTipoCambio()
{
	self::SetNames();
	if(empty($_POST["codcambio"])or empty($_POST["descripcioncambio"]) or empty($_POST["montocambio"]) or empty($_POST["codmoneda"]) or empty($_POST["fechacambio"]))
	{
		echo "1";
		exit;
	}
			
		$sql = "SELECT codmoneda, fechacambio FROM tiposcambio WHERE codcambio != ? AND codmoneda = ? AND fechacambio = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcambio"],$_POST["codmoneda"],date("Y-m-d",strtotime($_POST['fechacambio']))));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = "UPDATE tiposcambio set "
			." descripcioncambio = ?, "
			." montocambio = ?, "
			." codmoneda = ?, "
			." fechacambio = ? "
			." where "
			." codcambio = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $descripcioncambio);
			$stmt->bindParam(2, $montocambio);
			$stmt->bindParam(3, $codmoneda);
			$stmt->bindParam(4, $fechacambio);
			$stmt->bindParam(5, $codcambio);

			$descripcioncambio = limpiar($_POST["descripcioncambio"]);
			$montocambio = number_format($_POST["montocambio"], 3, '.', '');
			$codmoneda = limpiar($_POST["codmoneda"]);
			$fechacambio = limpiar(date("Y-m-d",strtotime($_POST['fechacambio'])));
			$codcambio = limpiar($_POST["codcambio"]);
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE CAMBIO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
###################### FUNCION ACTUALIZAR TIPO DE CAMBIO ############################

########################## FUNCION ELIMINAR TIPO DE CAMBIO ###########################
public function EliminarTipoCambio()
{
	self::SetNames();
		if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		    $sql = "DELETE FROM tiposcambio WHERE codcambio = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codcambio);
			$codcambio = decrypt($_GET["codcambio"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		} 
}
########################### FUNCION ELIMINAR TIPO DE CAMBIO ###########################

######################## FUNCION BUSCAR PRODUCTOS POR MONEDA ###########################
public function MonedaProductoId()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT sucursales.codmoneda, tiposmoneda.moneda, tiposmoneda.siglas, tiposmoneda.simbolo, tiposcambio.montocambio 
	FROM tiposmoneda 
	INNER JOIN sucursales ON tiposmoneda.codmoneda = sucursales.codmoneda
	INNER JOIN tiposcambio ON tiposmoneda.codmoneda = tiposcambio.codmoneda 
	WHERE sucursales.codsucursal = ? ORDER BY tiposcambio.codcambio DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	   }

	} else {

	$sql = "SELECT sucursales.codmoneda, tiposmoneda.moneda, tiposmoneda.siglas, tiposmoneda.simbolo, tiposcambio.montocambio 
	FROM sucursales 
	INNER JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	INNER JOIN tiposcambio ON tiposmoneda.codmoneda = tiposcambio.codmoneda 
	WHERE sucursales.codsucursal = ? ORDER BY tiposcambio.codcambio DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codsucursal"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	   }
	}
}
###################### FUNCION BUSCAR PRODUCTOS POR MONEDA ##########################

############################ FIN DE CLASE TIPOS DE CAMBIOS #############################


























################################# CLASE MEDIOS DE PAGOS ################################

########################### FUNCION REGISTRAR MEDIOS DE PAGOS ###########################
public function RegistrarMediosPagos()
{
	self::SetNames();
	if(empty($_POST["mediopago"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT mediopago FROM mediospagos WHERE mediopago = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["mediopago"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO mediospagos values (null, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $mediopago);

				$mediopago = limpiar($_POST["mediopago"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL MEDIO DE PAGO HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
############################ FUNCION REGISTRAR MEDIOS DE PAGOS ##########################

########################## FUNCION LISTAR MEDIOS DE PAGOS ##########################
public function ListarMediosPagos()
{
	self::SetNames();
	$sql = "SELECT * FROM mediospagos";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR MEDIOS DE PAGOS ##########################

############################ FUNCION ID MEDIOS DE PAGOS #################################
public function MediosPagosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM mediospagos WHERE codmediopago = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmediopago"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID MEDIOS DE PAGOS #################################

##################### FUNCION ACTUALIZAR MEDIOS DE PAGOS ############################
public function ActualizarMediosPagos()
{
	self::SetNames();
	if(empty($_POST["codmediopago"]) or empty($_POST["mediopago"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT mediopago FROM mediospagos WHERE codmediopago != ? AND mediopago = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codmediopago"],$_POST["mediopago"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE mediospagos set "
				." mediopago = ? "
				." where "
				." codmediopago = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $mediopago);
				$stmt->bindParam(2, $codmediopago);

				$mediopago = limpiar($_POST["mediopago"]);
				$codmediopago = limpiar($_POST["codmediopago"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL MEDIO DE PAGO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
##################### FUNCION ACTUALIZAR MEDIOS DE PAGOS ############################

########################## FUNCION ELIMINAR MEDIOS DE PAGOS #########################
public function EliminarMediosPagos()
{
	self::SetNames();
		if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT formapago FROM ventas WHERE formapago = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codmediopago"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM mediospagos WHERE codmediopago = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codmediopago);
			$codmediopago = decrypt($_GET["codmediopago"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################## FUNCION ELIMINAR MEDIOS DE PAGOS ###########################

############################ FIN DE CLASE MEDIOS DE PAGOS ##############################

























############################### CLASE IMPUESTOS ####################################

############################ FUNCION REGISTRAR IMPUESTOS ###############################
public function RegistrarImpuestos()
{
	self::SetNames();
	if(empty($_POST["nomimpuesto"]) or empty($_POST["valorimpuesto"]) or empty($_POST["statusimpuesto"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT statusimpuesto FROM impuestos WHERE nomimpuesto != ? AND statusimpuesto = ? AND statusimpuesto = 'ACTIVO'";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nomimpuesto"],$_POST["statusimpuesto"]));
			$num = $stmt->rowCount();
			if($num>0)
			{
				echo "2";
				exit;
			}
			else
			{

			$sql = " SELECT nomimpuesto FROM impuestos WHERE nomimpuesto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nomimpuesto"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO impuestos values (null, ?, ?, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nomimpuesto);
				$stmt->bindParam(2, $valorimpuesto);
				$stmt->bindParam(3, $statusimpuesto);
				$stmt->bindParam(4, $fechaimpuesto);

				$nomimpuesto = limpiar($_POST["nomimpuesto"]);
				$valorimpuesto = limpiar($_POST["valorimpuesto"]);
				$statusimpuesto = limpiar($_POST["statusimpuesto"]);
				$fechaimpuesto = limpiar(date("Y-m-d",strtotime($_POST['fechaimpuesto'])));
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL IMPUESTO HA SIDO REGISTRADO  EXITOSAMENTE";
			exit;

			} else {

			echo "3";
			exit;
	    }
	}
}
############################ FUNCION REGISTRAR IMPUESTOS ###############################

############################# FUNCION LISTAR IMPUESTOS ################################
public function ListarImpuestos()
{
	self::SetNames();
	$sql = "SELECT * FROM impuestos";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
############################# FUNCION LISTAR IMPUESTOS ################################

############################ FUNCION ID IMPUESTOS #################################
public function ImpuestosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM impuestos WHERE statusimpuesto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array("ACTIVO"));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
}
############################ FUNCION ID IMPUESTOS #################################

############################ FUNCION ACTUALIZAR IMPUESTOS ############################
public function ActualizarImpuestos()
{

	self::SetNames();
	if(empty($_POST["codimpuesto"]) or empty($_POST["nomimpuesto"]) or empty($_POST["valorimpuesto"]) or empty($_POST["statusimpuesto"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT statusimpuesto FROM impuestos WHERE codimpuesto != ? AND statusimpuesto = ? AND statusimpuesto = 'ACTIVO'";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codimpuesto"],$_POST["statusimpuesto"]));
			$num = $stmt->rowCount();
			if($num>0)
			{
				echo "2";
				exit;
			}
			else
			{

			$sql = "SELECT nomimpuesto FROM impuestos WHERE codimpuesto != ? AND nomimpuesto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codimpuesto"],$_POST["nomimpuesto"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE impuestos set "
				." nomimpuesto = ?, "
				." valorimpuesto = ?, "
				." statusimpuesto = ? "
				." where "
				." codimpuesto = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nomimpuesto);
				$stmt->bindParam(2, $valorimpuesto);
				$stmt->bindParam(3, $statusimpuesto);
				$stmt->bindParam(4, $codimpuesto);

				$nomimpuesto = limpiar($_POST["nomimpuesto"]);
				$valorimpuesto = limpiar($_POST["valorimpuesto"]);
				$statusimpuesto = limpiar($_POST["statusimpuesto"]);
				$codimpuesto = limpiar($_POST["codimpuesto"]);
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL IMPUESTO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "3";
			exit;
		}
	}
}
############################ FUNCION ACTUALIZAR IMPUESTOS ############################

######################### FUNCION ELIMINAR IMPUESTOS #########################
public function EliminarImpuestos()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT * FROM impuestos WHERE codimpuesto = ? AND statusimpuesto = 'ACTIVO'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codimpuesto"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM impuestos WHERE codimpuesto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codimpuesto);
			$codimpuesto = decrypt($_GET["codimpuesto"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
######################## FUNCION ELIMINAR IMPUESTOS ###########################

############################ FIN DE CLASE IMPUESTOS ################################






















############################# CLASE SUCURSALES ##################################

############################ FUNCION REGISTRAR SUCURSALES ##########################
public function RegistrarSucursales()
{
	self::SetNames();
	if(empty($_POST["nrosucursal"]) or empty($_POST["cuitsucursal"]) or empty($_POST["nomsucursal"]) or empty($_POST["direcsucursal"]) or empty($_POST["correosucursal"]) or empty($_POST["nroactividadsucursal"]) or empty($_POST["inicioticket"]) or empty($_POST["inicionotaventa"]) or empty($_POST["iniciofactura"]) or empty($_POST["dniencargado"]) or empty($_POST["nomencargado"]) or empty($_POST["descsucursal"]) or empty($_POST["codmoneda"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT correosucursal FROM sucursales WHERE correosucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["correosucursal"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{

		echo "2";
		exit;
	}
	else
	{
	$sql = " SELECT cuitsucursal FROM sucursales WHERE cuitsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["cuitsucursal"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " INSERT INTO sucursales values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $nrosucursal);
		$stmt->bindParam(2, $documsucursal);
		$stmt->bindParam(3, $cuitsucursal);
		$stmt->bindParam(4, $nomsucursal);
		$stmt->bindParam(5, $id_departamento);
		$stmt->bindParam(6, $id_provincia);
		$stmt->bindParam(7, $direcsucursal);
		$stmt->bindParam(8, $correosucursal);
		$stmt->bindParam(9, $tlfsucursal);
		$stmt->bindParam(10, $nroactividadsucursal);
		$stmt->bindParam(11, $inicioticket);
		$stmt->bindParam(12, $inicionotaventa);
		$stmt->bindParam(13, $iniciofactura);
		$stmt->bindParam(14, $fechaautorsucursal);
		$stmt->bindParam(15, $llevacontabilidad);
		$stmt->bindParam(16, $documencargado);
		$stmt->bindParam(17, $dniencargado);
		$stmt->bindParam(18, $nomencargado);
		$stmt->bindParam(19, $tlfencargado);
		$stmt->bindParam(20, $descsucursal);
		$stmt->bindParam(21, $codmoneda);
		$stmt->bindParam(22, $codmoneda2);

		$nrosucursal = limpiar($_POST["nrosucursal"]);
		$documsucursal = limpiar($_POST['documsucursal'] == '' ? "0" : $_POST['documsucursal']);
		$cuitsucursal = limpiar($_POST["cuitsucursal"]);
		$nomsucursal = limpiar($_POST["nomsucursal"]);
		$id_departamento = limpiar($_POST['id_departamento']);
		$id_provincia = limpiar($_POST['id_provincia']);
		$direcsucursal = limpiar($_POST["direcsucursal"]);
		$correosucursal = limpiar($_POST["correosucursal"]);
		$tlfsucursal = limpiar($_POST["tlfsucursal"]);
		$nroactividadsucursal = limpiar($_POST["nroactividadsucursal"]);
		$inicioticket = limpiar($_POST["inicioticket"]);
		$inicionotaventa = limpiar($_POST["inicionotaventa"]);
		$iniciofactura = limpiar($_POST["iniciofactura"]);
		$fechaautorsucursal = limpiar($_POST['fechaautorsucursal'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaautorsucursal'])));
		$llevacontabilidad = limpiar($_POST["llevacontabilidad"]);
		$documencargado = limpiar($_POST["documencargado"]);
		$dniencargado = limpiar($_POST["dniencargado"]);
		$nomencargado = limpiar($_POST["nomencargado"]);
		$tlfencargado = limpiar($_POST["tlfencargado"]);
		$descsucursal = limpiar($_POST["descsucursal"]);
		$codmoneda = limpiar($_POST["codmoneda"]);
		$codmoneda2 = limpiar($_POST["codmoneda2"]);
		$stmt->execute();

##################  SUBIR LOGO DE SUCURSAL ######################################
//datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
//compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/sucursales/".$nombre_archivo) && rename("fotos/sucursales/".$nombre_archivo,"fotos/sucursales/".$_POST["cuitsucursal"].".png"))
					{ 
## se puede dar un aviso
					} 
## se puede dar otro aviso 
				}
##################  FINALIZA SUBIR LOGO DE SUCURSAL ##################


			echo "<span class='fa fa-check-square-o'></span> LA SUCURSAL HA SIDO REGISTRADA EXITOSAMENTE";
			exit;
		}
		else
		{
			echo "3";
			exit;
	    }
	}
}
######################### FUNCION REGISTRAR SUCURSALES ###############################

######################## FUNCION LISTAR SUCURSALES ###############################
public function ListarSucursales()
{
	self::SetNames();
	$sql = "SELECT 
	sucursales.codsucursal,
	sucursales.nrosucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_departamento,
	sucursales.id_provincia,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.nroactividadsucursal,
	sucursales.inicioticket,
	sucursales.inicionotaventa,
	sucursales.iniciofactura,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.descsucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda2.moneda AS moneda2,
	departamentos.departamento,
	provincias.provincia 
	FROM sucursales 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;	
 }
########################## FUNCION LISTAR SUCURSALES ##########################

######################## FUNCION LISTAR SUCURSALES DIFERENTES A SESSION ###############################
public function ListarSucursalesDiferentes()
{
	self::SetNames();
	$sql = "SELECT 
	sucursales.codsucursal,
	sucursales.nrosucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_departamento,
	sucursales.id_provincia,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.nroactividadsucursal,
	sucursales.inicioticket,
	sucursales.inicionotaventa,
	sucursales.iniciofactura,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.descsucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda2.moneda AS moneda2,
	departamentos.departamento,
	provincias.provincia 
	FROM sucursales 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	WHERE sucursales.codsucursal != '".limpiar($_SESSION["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################## FUNCION LISTAR SUCURSALES DIFERENTES A SESSION ########################## 

############################ FUNCION ID SUCURSALES #################################
public function SucursalesPorId()
{
	self::SetNames();
	$sql = "SELECT 
	sucursales.codsucursal,
	sucursales.nrosucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_departamento,
	sucursales.id_provincia,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.nroactividadsucursal,
	sucursales.inicioticket,
	sucursales.inicionotaventa,
	sucursales.iniciofactura,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.descsucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda2.moneda AS moneda2,
	departamentos.departamento,
	provincias.provincia 
	FROM sucursales 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia WHERE sucursales.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID SUCURSALES #################################

############################ FUNCION ACTUALIZAR SUCURSALES ############################
public function ActualizarSucursales()
{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["nrosucursal"]) or empty($_POST["cuitsucursal"]) or empty($_POST["nomsucursal"]) or empty($_POST["direcsucursal"]) or empty($_POST["correosucursal"]) or empty($_POST["nroactividadsucursal"]) or empty($_POST["inicioticket"]) or empty($_POST["inicionotaventa"]) or empty($_POST["iniciofactura"]) or empty($_POST["dniencargado"]) or empty($_POST["nomencargado"]) or empty($_POST["descsucursal"]) or empty($_POST["codmoneda"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT correosucursal FROM sucursales WHERE codsucursal != ? AND correosucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codsucursal"],$_POST["correosucursal"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		echo "2";
		exit;
	}
	else
	{
	$sql = " SELECT cuitsucursal FROM sucursales WHERE codsucursal != ? AND cuitsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codsucursal"],$_POST["cuitsucursal"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " UPDATE sucursales set "
		." nrosucursal = ?, "
		." documsucursal = ?, "
		." cuitsucursal = ?, "
		." nomsucursal = ?, "
		." id_departamento = ?, "
		." id_provincia = ?, "
		." direcsucursal = ?, "
		." correosucursal = ?, "
		." tlfsucursal = ?, "
		." nroactividadsucursal = ?, "
		." inicioticket = ?, "
		." inicionotaventa = ?, "
		." iniciofactura = ?, "
		." fechaautorsucursal = ?, "
		." llevacontabilidad = ?, "
		." documencargado = ?, "
		." dniencargado = ?, "
		." nomencargado = ?, "
		." tlfencargado = ?, "
		." descsucursal = ?, "
		." codmoneda = ?, "
		." codmoneda2 = ? "
		." where "
		." codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $nrosucursal);
		$stmt->bindParam(2, $documsucursal);
		$stmt->bindParam(3, $cuitsucursal);
		$stmt->bindParam(4, $nomsucursal);
		$stmt->bindParam(5, $id_departamento);
		$stmt->bindParam(6, $id_provincia);
		$stmt->bindParam(7, $direcsucursal);
		$stmt->bindParam(8, $correosucursal);
		$stmt->bindParam(9, $tlfsucursal);
		$stmt->bindParam(10, $nroactividadsucursal);
		$stmt->bindParam(11, $inicioticket);
		$stmt->bindParam(12, $inicionotaventa);
		$stmt->bindParam(13, $iniciofactura);
		$stmt->bindParam(14, $fechaautorsucursal);
		$stmt->bindParam(15, $llevacontabilidad);
		$stmt->bindParam(16, $documencargado);
		$stmt->bindParam(17, $dniencargado);
		$stmt->bindParam(18, $nomencargado);
		$stmt->bindParam(19, $tlfencargado);
		$stmt->bindParam(20, $descsucursal);
		$stmt->bindParam(21, $codmoneda);
		$stmt->bindParam(22, $codmoneda2);
		$stmt->bindParam(23, $codsucursal);

		$nrosucursal = limpiar($_POST["nrosucursal"]);
		$documsucursal = limpiar($_POST['documsucursal'] == '' ? "0" : $_POST['documsucursal']);
		$cuitsucursal = limpiar($_POST["cuitsucursal"]);
		$nomsucursal = limpiar($_POST["nomsucursal"]);
		$id_departamento = limpiar($_POST['id_departamento']);
		$id_provincia = limpiar($_POST['id_provincia']);
		$direcsucursal = limpiar($_POST["direcsucursal"]);
		$correosucursal = limpiar($_POST["correosucursal"]);
		$tlfsucursal = limpiar($_POST["tlfsucursal"]);
		$nroactividadsucursal = limpiar($_POST["nroactividadsucursal"]);
	    $inicioticket = limpiar($_POST["inicioticket"]);
		$inicionotaventa = limpiar($_POST["inicionotaventa"]);
		$iniciofactura = limpiar($_POST["iniciofactura"]);
		$fechaautorsucursal = limpiar($_POST['fechaautorsucursal'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaautorsucursal'])));
		$llevacontabilidad = limpiar($_POST["llevacontabilidad"]);
		$documencargado = limpiar($_POST["documencargado"]);
		$dniencargado = limpiar($_POST["dniencargado"]);
		$nomencargado = limpiar($_POST["nomencargado"]);
		$tlfencargado = limpiar($_POST["tlfencargado"]);
		$descsucursal = limpiar($_POST["descsucursal"]);
		$codmoneda = limpiar($_POST["codmoneda"]);
		$codmoneda2 = limpiar($_POST["codmoneda2"]);
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

##################  SUBIR LOGO DE SUCURSAL ######################################
//datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
//compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/sucursales/".$nombre_archivo) && rename("fotos/sucursales/".$nombre_archivo,"fotos/sucursales/".$_POST["cuitsucursal"].".png"))
					{ 
## se puede dar un aviso
					} 
## se puede dar otro aviso 
				}
##################  FINALIZA SUBIR LOGO DE SUCURSAL ##################

			echo "<span class='fa fa-check-square-o'></span> LA SUCURSAL HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

		}
		else
		{
			echo "3";
			exit;
		}
	}
}
############################ FUNCION ACTUALIZAR SUCURSALES ############################

########################## FUNCION ELIMINAR SUCURSALES ########################
public function EliminarSucursales()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT codsucursal FROM productos WHERE codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "DELETE FROM sucursales WHERE codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codsucursal);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
############################ FUNCION ELIMINAR SUCURSALES #######################

############################# FIN DE CLASE SUCURSALES ################################


























################################# CLASE TRATAMIENTOS ################################

########################### FUNCION REGISTRAR TRATAMIENTOS ##########################
public function RegistrarTratamientos()
{
	self::SetNames();
	if(empty($_POST["nomtratamiento"]))
	{
		echo "1";
		exit;
	}

		$sql = " SELECT nomtratamiento FROM tratamientos WHERE nomtratamiento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nomtratamiento"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = " INSERT INTO tratamientos values (null, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nomtratamiento);

			$nomtratamiento = limpiar(Eliminar_Acentos($_POST["nomtratamiento"]));
			$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> LA TRATAMIENTO HA SIDO REGISTRADA EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
########################### FUNCION REGISTRAR TRATAMIENTOS #########################

########################### FUNCION LISTAR TRATAMIENTOS ############################
public function ListarTratamientos()
{
	self::SetNames();
	$sql = "SELECT * FROM tratamientos";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR TRATAMIENTOS #########################

############################ FUNCION ID TRATAMIENTOS #################################
public function TratamientosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM tratamientos WHERE codtratamiento = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codtratamiento"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID TRATAMIENTOS #################################

######################### FUNCION ACTUALIZAR TRATAMIENTOS #######################
public function ActualizarTratamientos()
{
	self::SetNames();
	if(empty($_POST["codtratamiento"]) or empty($_POST["nomtratamiento"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT nomtratamiento FROM tratamientos WHERE codtratamiento != ? AND nomtratamiento = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codtratamiento"],$_POST["nomtratamiento"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " UPDATE tratamientos set "
		." nomtratamiento = ? "
		." where "
		." codtratamiento = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $nomtratamiento);
		$stmt->bindParam(2, $codtratamiento);

		$nomtratamiento = limpiar(Eliminar_Acentos($_POST["nomtratamiento"]));
		$codtratamiento = limpiar($_POST["codtratamiento"]);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> LA TRATAMIENTO HA SIDO ACTUALIZADA EXITOSAMENTE";
		exit;

	} else {

		echo "2";
		exit;
	}
}
######################## FUNCION ACTUALIZAR TRATAMIENTOS #######################

########################### FUNCION ELIMINAR TRATAMIENTOS ############################
public function EliminarTratamientos()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT plantratamiento FROM odontologia WHERE codtratamiento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codtratamiento"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM tratamientos WHERE codtratamiento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codtratamiento);
			$codtratamiento = decrypt($_GET["codtratamiento"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR TRATAMIENTOS ###########################

########################### FIN DE CLASE TRATAMIENTOS ###############################























################################## CLASE MARCAS ######################################

############################ FUNCION REGISTRAR MARCAS ###############################
public function RegistrarMarcas()
{
	self::SetNames();
	if(empty($_POST["nommarca"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nommarca FROM marcas WHERE nommarca = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nommarca"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO marcas values (null, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nommarca);

				$nommarca = limpiar($_POST["nommarca"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA MARCA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
############################ FUNCION REGISTRAR MARCAS ###############################

############################## FUNCION LISTAR MARCAS ################################
public function ListarMarcas()
{
	self::SetNames();
	$sql = "SELECT * FROM marcas";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
################################## FUNCION LISTAR MARCAS ################################

############################ FUNCION ID MARCAS #################################
public function MarcasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM marcas WHERE codmarca = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmarca"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID MARCAS #################################

############################ FUNCION ACTUALIZAR MARCAS ############################
public function ActualizarMarcas()
{

	self::SetNames();
	if(empty($_POST["codmarca"]) or empty($_POST["nommarca"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nommarca FROM marcas WHERE codmarca != ? AND nommarca = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codmarca"],$_POST["nommarca"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE marcas set "
				." nommarca = ? "
				." where "
				." codmarca = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nommarca);
				$stmt->bindParam(2, $codmarca);

				$nommarca = limpiar($_POST["nommarca"]);
				$codmarca = limpiar($_POST["codmarca"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA MARCA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR MARCAS ############################

########################### FUNCION ELIMINAR MARCAS #################################
public function EliminarMarcas()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codmarca FROM productos WHERE codmarca = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codmarca"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM marcas WHERE codmarca = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codmarca);
			$codmarca = decrypt($_GET["codmarca"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR MARCAS #################################

############################## FIN DE CLASE MARCAS ###################################

























################################# CLASE PRESENTACIONES ################################

########################### FUNCION REGISTRAR PRESENTACIONES ##########################
public function RegistrarPresentaciones()
{
	self::SetNames();
	if(empty($_POST["nompresentacion"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nompresentacion FROM presentaciones WHERE nompresentacion = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nompresentacion"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = " INSERT INTO presentaciones values (null, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nompresentacion);

				$nompresentacion = limpiar($_POST["nompresentacion"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA PRESENTACI&Oacute;N HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
########################### FUNCION REGISTRAR PRESENTACIONES #########################

########################### FUNCION LISTAR PRESENTACIONES ############################
public function ListarPresentaciones()
{
	self::SetNames();
	$sql = "SELECT * FROM presentaciones";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR PRESENTACIONES #########################

############################ FUNCION ID PRESENTACIONES #################################
public function PresentacionesPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM presentaciones WHERE codpresentacion = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpresentacion"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PRESENTACIONES #################################

######################### FUNCION ACTUALIZAR PRESENTACIONES #######################
public function ActualizarPresentaciones()
{
	self::SetNames();
	if(empty($_POST["codpresentacion"]) or empty($_POST["nompresentacion"]))
	{
		echo "1";
		exit;
	}

			$sql = " SELECT nompresentacion FROM presentaciones WHERE codpresentacion != ? AND nompresentacion = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codpresentacion"],$_POST["nompresentacion"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE presentaciones set "
				." nompresentacion = ? "
				." where "
				." codpresentacion = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nompresentacion);
				$stmt->bindParam(2, $codpresentacion);

				$nompresentacion = limpiar($_POST["nompresentacion"]);
				$codpresentacion = limpiar($_POST["codpresentacion"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA PRESENTACI&Oacute;N HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
######################## FUNCION ACTUALIZAR PRESENTACIONES #######################

########################### FUNCION ELIMINAR PRESENTACIONES ############################
public function EliminarPresentaciones()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codpresentacion FROM productos WHERE codpresentacion = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codpresentacion"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM presentaciones WHERE codpresentacion = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codpresentacion);
			$codpresentacion = decrypt($_GET["codpresentacion"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR PRESENTACIONES ###########################

########################### FIN DE CLASE PRESENTACIONES ###############################























################################################ CLASE UNIDADES DE MEDIDAS ##########################################

##################################### FUNCION REGISTRAR UNIDAD DE MEDIDA ####################################
public function RegistrarMedidas()
{
	self::SetNames();
	if(empty($_POST["nommedida"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT nommedida FROM medidas WHERE nommedida = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nommedida"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = "INSERT INTO medidas values (null, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nommedida);

				$nommedida = limpiar($_POST["nommedida"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA UNIDAD DE MEDIDA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
##################################### FUNCION REGISTRAR UNIDAD DE MEDIDA ######################################

##################################### FUNCION LISTAR UNIDAD DE MEDIDA #####################################
public function ListarMedidas()
{
	self::SetNames();
	$sql = "SELECT * FROM medidas";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
###################################### FUNCION LISTAR UNIDAD DE MEDIDA #####################################

#################################### FUNCION ID UNIDAD DE MEDIDA #########################################
public function MedidasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM medidas WHERE codmedida = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmedida"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
#################################### FUNCION ID UNIDAD DE MEDIDA #########################################

#################################### FUNCION ACTUALIZAR UNIDAD DE MEDIDA ####################################
public function ActualizarMedidas()
{

	self::SetNames();
	if(empty($_POST["codmedida"]) or empty($_POST["nommedida"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT nommedida FROM medidas WHERE codmedida != ? AND nommedida = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codmedida"],$_POST["nommedida"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE medidas set "
				." nommedida = ? "
				." where "
				." codmedida = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nommedida);
				$stmt->bindParam(2, $codmedida);

				$nommedida = limpiar($_POST["nommedida"]);
				$codmedida = limpiar($_POST["codmedida"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA UNIDAD DE MEDIDA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
#################################### FUNCION ACTUALIZAR UNIDAD DE MEDIDA ####################################

#################################### FUNCION ELIMINAR UNIDAD DE MEDIDA ####################################
public function EliminarMedidas()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

		$sql = "SELECT codmedida FROM productos WHERE codmedida = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codmedida"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM medidas WHERE codmedida = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codmedida);
			$codmedida = decrypt($_GET["codmedida"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
##################################### FUNCION ELIMINAR UNIDAD DE MEDIDA #####################################

######################################## FIN DE CLASE UNIDADES DE MEDIDAS #######################################























############################# CLASE ESPECIALISTAS ##################################

############################### FUNCION CARGAR ESPECIALISTAS ##############################
	public function CargaEspecialistas()
	{
		self::SetNames();
		if(empty($_FILES["sel_file"]))
		{
			echo "1";
			exit;
		}

  //$porcentaje=($_SESSION['acceso']=="administradorG" ? "0.00" : $_SESSION['porcentaje']);

        //Aquí es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         //echo 'Cargando nombre del archivo: '.$fname.' ';
         $chk_ext = explode(".",$fname);
         
        if(strtolower(end($chk_ext)) == "csv")
        {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        $this->dbh->beginTransaction();
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

        //Insertamos los datos con los valores...
        $query = " INSERT INTO especialistas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codespecialista);
		$stmt->bindParam(2, $tpespecialista);
		$stmt->bindParam(3, $documespecialista);
		$stmt->bindParam(4, $cedespecialista);
		$stmt->bindParam(5, $nomespecialista);
		$stmt->bindParam(6, $tlfespecialista);
		$stmt->bindParam(7, $sexoespecialista);
		$stmt->bindParam(8, $id_departamento);
		$stmt->bindParam(9, $id_provincia);
		$stmt->bindParam(10, $direcespecialista);
		$stmt->bindParam(11, $correoespecialista);
		$stmt->bindParam(12, $especialidad);
		$stmt->bindParam(13, $fnacespecialista);
		$stmt->bindParam(14, $twitter);
		$stmt->bindParam(15, $facebook);
		$stmt->bindParam(16, $instagram);
		$stmt->bindParam(17, $google);
		$stmt->bindParam(18, $claveespecialista);

    	$codespecialista = limpiar($data[0]);
    	$tpespecialista = limpiar($data[1]);
    	$documespecialista = limpiar($data[2]);
    	$cedespecialista = limpiar($data[3]);
    	$nomespecialista = limpiar($data[4]);
    	$tlfespecialista = limpiar($data[5]);
    	$sexoespecialista = limpiar($data[6]);
    	$id_departamento = limpiar($data[7]);
    	$id_provincia = limpiar($data[8]);
    	$direcespecialista = limpiar($data[9]);
    	$correoespecialista = limpiar($data[10]);
    	$especialidad = limpiar($data[11]);
    	$fnacespecialista = limpiar($data[12]);
    	$twitter = limpiar($data[13]);
    	$facebook = limpiar($data[14]);
    	$instagram = limpiar($data[15]);
    	$google = limpiar($data[16]);
    	$claveespecialista = password_hash($data[3], PASSWORD_DEFAULT);
    	$stmt->execute();
	
        }
           
        $this->dbh->commit();
        //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
        fclose($handle);

	    echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE ESPECIALISTAS FUE REALIZADA EXITOSAMENTE";
	    exit;    
    }
    else
    {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
        echo "2";
		exit;
    }  
}
############################## FUNCION CARGAR ESPECIALISTAS ##############################

############################ FUNCION REGISTRAR ESPECIALISTAS ##########################
public function RegistrarEspecialistas()
{
	self::SetNames();
	if(empty($_POST["tpespecialista"]) or empty($_POST["documespecialista"]) or empty($_POST["cedespecialista"]) or empty($_POST["nomespecialista"]) or empty($_POST["tlfespecialista"]) or empty($_POST["sexoespecialista"]) or empty($_POST["direcespecialista"]) or empty($_POST["correoespecialista"]) or empty($_POST["especialidad"]))
	{
		echo "1";
		exit;
	}
	elseif($_SESSION['acceso'] == "administradorG")
	{
		if (empty($_POST['codsucursal'])) 
		{
        echo "2";
        exit;
        }
	}

	######################### CODIGO DE ESPECIALISTA #########################
    $sql = "SELECT codespecialista FROM especialistas ORDER BY idespecialista DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$id=$row["codespecialista"];

	}
	if(empty($id))
	{
		$codespecialista = "E1";

	} else {

		$resto = substr($id, 0, 1);
		$coun = strlen($resto);
		$num     = substr($id, $coun);
		$codigo     = $num + 1;
		$codespecialista = "E".$codigo;
	}
	######################### CODIGO DE ESPECIALISTA #########################

	$sql = " SELECT correoespecialista FROM especialistas WHERE correoespecialista = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["correoespecialista"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{

		echo "3";
		exit;
	}
	else
	{
	$sql = " SELECT cedespecialista FROM especialistas WHERE cedespecialista = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["cedespecialista"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
	    $query = " INSERT INTO especialistas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codespecialista);
		$stmt->bindParam(2, $tpespecialista);
		$stmt->bindParam(3, $documespecialista);
		$stmt->bindParam(4, $cedespecialista);
		$stmt->bindParam(5, $nomespecialista);
		$stmt->bindParam(6, $tlfespecialista);
		$stmt->bindParam(7, $sexoespecialista);
		$stmt->bindParam(8, $id_departamento);
		$stmt->bindParam(9, $id_provincia);
		$stmt->bindParam(10, $direcespecialista);
		$stmt->bindParam(11, $correoespecialista);
		$stmt->bindParam(12, $especialidad);
		$stmt->bindParam(13, $fnacespecialista);
		$stmt->bindParam(14, $twitter);
		$stmt->bindParam(15, $facebook);
		$stmt->bindParam(16, $instagram);
		$stmt->bindParam(17, $google);
		$stmt->bindParam(18, $claveespecialista);

		$tpespecialista = limpiar($_POST["tpespecialista"]);
		$documespecialista = limpiar($_POST["documespecialista"] == '' ? "0" : $_POST['documespecialista']);
		$cedespecialista = limpiar($_POST['cedespecialista']);
		$nomespecialista = limpiar($_POST["nomespecialista"]);
		$tlfespecialista = limpiar($_POST["tlfespecialista"]);
		$sexoespecialista = limpiar($_POST["sexoespecialista"]);
		$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
		$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
		$direcespecialista = limpiar($_POST["direcespecialista"]);
		$correoespecialista = limpiar($_POST["correoespecialista"]);
		$especialidad = limpiar($_POST["especialidad"]);
		$fnacespecialista = limpiar($_POST['fnacespecialista'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fnacespecialista'])));
		$twitter = limpiar($_POST["twitter"]);
		$facebook = limpiar($_POST["facebook"]);
		$instagram = limpiar($_POST["instagram"]);
		$google = limpiar($_POST["google"]);
		$claveespecialista = password_hash($_POST["cedespecialista"], PASSWORD_DEFAULT);
		$stmt->execute();

		if($_SESSION['acceso'] == "administradorG"){

		###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
		for($i=0;$i<count($_POST['codsucursal']);$i++){  //recorro el array
            if (!empty($_POST['codsucursal'][$i])) {

            $query = "INSERT INTO accesosxsucursales values (null, ?, ?); ";
		    $stmt = $this->dbh->prepare($query);
		    $stmt->bindParam(1, $codespecialista);
		    $stmt->bindParam(2, $codsucursal);
			
		    $codsucursal = limpiar($_POST["codsucursal"][$i]);
		    $stmt->execute();
		
		    } 
	    }
	    ###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################

	    } elseif($_SESSION['acceso'] == "administradorS") {

			###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
	        $query = "INSERT INTO accesosxsucursales values (null, ?, ?); ";
		    $stmt = $this->dbh->prepare($query);
		    $stmt->bindParam(1, $codespecialista);
		    $stmt->bindParam(2, $codsucursal);
			
		    $codsucursal = limpiar($_SESSION["codsucursal"]);
		    $stmt->execute();
		    ###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
		}

    ######################################  SUBIR FOTO DE ESPECIALISTA ######################################
    //datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
    //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) {
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["codespecialista"].".png"))
					{ 
    ## se puede dar un aviso
					} 
    ## se puede dar otro aviso 
				}
    ######################################  FINALIZA SUBIR FOTO DE ESPECIALISTA ######################################

			echo "<span class='fa fa-check-square-o'></span> EL ESPECIALISTA HA SIDO REGISTRADO EXITOSAMENTE";
			exit;
		}
		else
		{
			echo "4";
			exit;
	    }
	}
}
######################### FUNCION REGISTRAR ESPECIALISTAS ###############################

######################## FUNCION LISTAR ESPECIALISTAS EN WEB ###############################
public function ListarEspecialistasWeb()
{
	self::SetNames();
	$sql = "SELECT
	especialistas.idespecialista,
	especialistas.codespecialista,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.sexoespecialista,
	especialistas.id_departamento,
	especialistas.id_provincia,
	especialistas.direcespecialista,
	especialistas.correoespecialista,
	especialistas.especialidad,
	especialistas.fnacespecialista,
	especialistas.twitter,
	especialistas.facebook,
	especialistas.instagram,
	especialistas.google,
	especialistas.claveespecialista,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM especialistas 
	LEFT JOIN documentos ON especialistas.documespecialista = documentos.coddocumento
	LEFT JOIN departamentos ON especialistas.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON especialistas.id_provincia = provincias.id_provincia
	LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	GROUP BY especialistas.codespecialista";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR ESPECIALISTAS EN WEB ##########################

######################## FUNCION LISTAR ESPECIALISTAS ###############################
public function ListarEspecialistas()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
	especialistas.idespecialista,
	especialistas.codespecialista,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.sexoespecialista,
	especialistas.id_departamento,
	especialistas.id_provincia,
	especialistas.direcespecialista,
	especialistas.correoespecialista,
	especialistas.especialidad,
	especialistas.fnacespecialista,
	especialistas.twitter,
	especialistas.facebook,
	especialistas.instagram,
	especialistas.google,
	especialistas.claveespecialista,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM especialistas 
	LEFT JOIN documentos ON especialistas.documespecialista = documentos.coddocumento
	LEFT JOIN departamentos ON especialistas.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON especialistas.id_provincia = provincias.id_provincia
	LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	GROUP BY especialistas.codespecialista";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

    $sql = "SELECT
	especialistas.idespecialista,
	especialistas.codespecialista,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.sexoespecialista,
	especialistas.id_departamento,
	especialistas.id_provincia,
	especialistas.direcespecialista,
	especialistas.correoespecialista,
	especialistas.especialidad,
	especialistas.fnacespecialista,
	especialistas.twitter,
	especialistas.facebook,
	especialistas.instagram,
	especialistas.google,
	especialistas.claveespecialista,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM especialistas 
	LEFT JOIN documentos ON especialistas.documespecialista = documentos.coddocumento
	LEFT JOIN departamentos ON especialistas.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON especialistas.id_provincia = provincias.id_provincia
	LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	WHERE accesosxsucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY especialistas.codespecialista";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
    }
 }
########################## FUNCION LISTAR ESPECIALISTAS ##########################

############################# FUNCION LISTAR TIPOS ESPECIALISTAS ################################
public function ListarTiposEspecialistas()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
	especialistas.idespecialista,
	especialistas.codespecialista,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.sexoespecialista,
	especialistas.id_departamento,
	especialistas.id_provincia,
	especialistas.direcespecialista,
	especialistas.correoespecialista,
	especialistas.especialidad,
	especialistas.fnacespecialista,
	especialistas.twitter,
	especialistas.facebook,
	especialistas.instagram,
	especialistas.google,
	especialistas.claveespecialista,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM especialistas 
	LEFT JOIN documentos ON especialistas.documespecialista = documentos.coddocumento
	LEFT JOIN departamentos ON especialistas.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON especialistas.id_provincia = provincias.id_provincia
	LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	GROUP BY especialistas.codespecialista";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

    $sql = "SELECT
	especialistas.idespecialista,
	especialistas.codespecialista,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.sexoespecialista,
	especialistas.id_departamento,
	especialistas.id_provincia,
	especialistas.direcespecialista,
	especialistas.correoespecialista,
	especialistas.especialidad,
	especialistas.fnacespecialista,
	especialistas.twitter,
	especialistas.facebook,
	especialistas.instagram,
	especialistas.google,
	especialistas.claveespecialista,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM especialistas 
	LEFT JOIN documentos ON especialistas.documespecialista = documentos.coddocumento
	LEFT JOIN departamentos ON especialistas.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON especialistas.id_provincia = provincias.id_provincia
	LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	WHERE accesosxsucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY especialistas.codespecialista";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
    }
 }
############################## FUNCION LISTAR TIPOS ESPECIALISTAS ################################ 

############################ FUNCION ID ESPECIALISTAS #################################
public function EspecialistasPorId()
{
	self::SetNames();
	
	if ($_SESSION['acceso'] == "especialista") {

	$sql = "SELECT
	especialistas.idespecialista,
	especialistas.codespecialista,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.sexoespecialista,
	especialistas.id_departamento,
	especialistas.id_provincia,
	especialistas.direcespecialista,
	especialistas.correoespecialista,
	especialistas.especialidad,
	especialistas.fnacespecialista,
	especialistas.twitter,
	especialistas.facebook,
	especialistas.instagram,
	especialistas.google,
	especialistas.claveespecialista,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM especialistas 
	LEFT JOIN documentos ON especialistas.documespecialista = documentos.coddocumento
	LEFT JOIN departamentos ON especialistas.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON especialistas.id_provincia = provincias.id_provincia 
	LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	WHERE especialistas.codespecialista = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_SESSION["codespecialista"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}

	} else {

	$sql = "SELECT
	especialistas.idespecialista,
	especialistas.codespecialista,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.sexoespecialista,
	especialistas.id_departamento,
	especialistas.id_provincia,
	especialistas.direcespecialista,
	especialistas.correoespecialista,
	especialistas.especialidad,
	especialistas.fnacespecialista,
	especialistas.twitter,
	especialistas.facebook,
	especialistas.instagram,
	especialistas.google,
	especialistas.claveespecialista,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia,
	GROUP_CONCAT(DISTINCT sucursales.codsucursal SEPARATOR ', ') AS gruposid,
	GROUP_CONCAT(DISTINCT sucursales.nomsucursal SEPARATOR ', ') AS gruposnombres
	FROM especialistas 
	LEFT JOIN documentos ON especialistas.documespecialista = documentos.coddocumento
	LEFT JOIN departamentos ON especialistas.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON especialistas.id_provincia = provincias.id_provincia 
	LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
	LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	WHERE especialistas.codespecialista = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codespecialista"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	    }
	}
}		
############################ FUNCION ID ESPECIALISTAS #################################

############################ FUNCION ACTUALIZAR ESPECIALISTAS ############################
public function ActualizarEspecialistas()
{
	self::SetNames();
	if(empty($_POST["codespecialista"]) or empty($_POST["tpespecialista"]) or empty($_POST["documespecialista"]) or empty($_POST["cedespecialista"]) or empty($_POST["nomespecialista"]) or empty($_POST["tlfespecialista"]) or empty($_POST["sexoespecialista"]) or empty($_POST["direcespecialista"]) or empty($_POST["correoespecialista"]) or empty($_POST["especialidad"]))
	{
		echo "1";
		exit;
	}
	elseif($_SESSION['acceso'] == "administradorG")
	{
		if (empty($_POST['codsucursal'])) 
		{
        echo "2";
        exit;
        }
	}

	$sql = " SELECT correoespecialista FROM especialistas WHERE codespecialista != ? AND correoespecialista = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codespecialista"],$_POST["correoespecialista"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		echo "3";
		exit;
	}
	else
	{
	$sql = " SELECT cedespecialista FROM especialistas WHERE codespecialista != ? AND cedespecialista = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codespecialista"],$_POST["cedespecialista"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{

	$sql = " UPDATE especialistas set "
		." tpespecialista = ?, "
		." documespecialista = ?, "
		." cedespecialista = ?, "
		." nomespecialista = ?, "
		." tlfespecialista = ?, "
		." sexoespecialista = ?, "
		." id_departamento = ?, "
		." id_provincia = ?, "
		." direcespecialista = ?, "
		." correoespecialista = ?, "
		." especialidad = ?, "
		." fnacespecialista = ?, "
		." twitter = ?, "
		." facebook = ?, "
		." instagram = ?, "
		." google = ? "
		." where "
		." codespecialista = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $tpespecialista);
		$stmt->bindParam(2, $documespecialista);
		$stmt->bindParam(3, $cedespecialista);
		$stmt->bindParam(4, $nomespecialista);
		$stmt->bindParam(5, $tlfespecialista);
		$stmt->bindParam(6, $sexoespecialista);
		$stmt->bindParam(7, $id_departamento);
		$stmt->bindParam(8, $id_provincia);
		$stmt->bindParam(9, $direcespecialista);
		$stmt->bindParam(10, $correoespecialista);
		$stmt->bindParam(11, $especialidad);
		$stmt->bindParam(12, $fnacespecialista);
		$stmt->bindParam(13, $twitter);
		$stmt->bindParam(14, $facebook);
		$stmt->bindParam(15, $instagram);
		$stmt->bindParam(16, $google);
		$stmt->bindParam(17, $codespecialista);

		$tpespecialista = limpiar($_POST["tpespecialista"]);
		$documespecialista = limpiar($_POST["documespecialista"] == '' ? "0" : $_POST['documespecialista']);
		$cedespecialista = limpiar($_POST['cedespecialista']);
		$nomespecialista = limpiar($_POST["nomespecialista"]);
		$tlfespecialista = limpiar($_POST["tlfespecialista"]);
		$sexoespecialista = limpiar($_POST["sexoespecialista"]);
		$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
		$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
		$direcespecialista = limpiar($_POST["direcespecialista"]);
		$correoespecialista = limpiar($_POST["correoespecialista"]);
		$especialidad = limpiar($_POST["especialidad"]);
	$fnacespecialista = limpiar($_POST['fnacespecialista'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fnacespecialista'])));
		$twitter = limpiar($_POST["twitter"]);
		$facebook = limpiar($_POST["facebook"]);
		$instagram = limpiar($_POST["instagram"]);
		$google = limpiar($_POST["google"]);
		$codespecialista = limpiar($_POST["codespecialista"]);
		$stmt->execute();

		if($_SESSION['acceso'] == "administradorG"){

			###################### ELIMINO LAS SUCURSALES ASIGNADAS ######################
			$sql = "DELETE FROM accesosxsucursales WHERE codusuario = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codespecialista);
			$codespecialista = limpiar($_POST["codespecialista"]);
			$stmt->execute();
			###################### ELIMINO LAS SUCURSALES ASIGNADAS ######################

			###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
			for($i=0;$i<count($_POST['codsucursal']);$i++){  //recorro el array
	            if (!empty($_POST['codsucursal'][$i])) {

	            $query = "INSERT INTO accesosxsucursales values (null, ?, ?); ";
			    $stmt = $this->dbh->prepare($query);
			    $stmt->bindParam(1, $codespecialista);
			    $stmt->bindParam(2, $codsucursal);
				
			    $codespecialista = limpiar($_POST["codespecialista"]);
			    $codsucursal = limpiar($_POST["codsucursal"][$i]);
			    $stmt->execute();
			
			    } 
		    }
		    ###################### REGISTRO LAS SUCURSALES ASIGNADAS ######################
		}

    ######################################  SUBIR FOTO DE ESPECIALISTA ######################################
    //datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
    //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) {  
		if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["codespecialista"].".jpg"))
		{ 
    ## se puede dar un aviso
		} 
    ## se puede dar otro aviso 
		}
    ######################################  FINALIZA SUBIR FOTO DE ESPECIALISTA ######################################

			echo "<span class='fa fa-check-square-o'></span> EL ESPECIALISTA HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

		}
		else
		{
			echo "4";
			exit;
		}
	 }
}
############################ FUNCION ACTUALIZAR ESPECIALISTAS ############################

############################ FUNCION ACTUALIZAR MIS DATOS ############################
public function ActualizarMisDatos()
{
	self::SetNames();
	if(empty($_POST["codespecialista"]) or empty($_POST["tpespecialista"]) or empty($_POST["documespecialista"]) or empty($_POST["cedespecialista"]) or empty($_POST["nomespecialista"]) or empty($_POST["tlfespecialista"]) or empty($_POST["sexoespecialista"]) or empty($_POST["direcespecialista"]) or empty($_POST["correoespecialista"]) or empty($_POST["especialidad"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT correoespecialista FROM especialistas WHERE codespecialista != ? AND correoespecialista = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codespecialista"]),$_POST["correoespecialista"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		echo "2";
		exit;
	}
	else
	{
	$sql = " SELECT cedespecialista FROM especialistas WHERE codespecialista != ? AND cedespecialista = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codespecialista"]),$_POST["cedespecialista"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{

	$sql = " UPDATE especialistas set "
		." tpespecialista = ?, "
		." documespecialista = ?, "
		." cedespecialista = ?, "
		." nomespecialista = ?, "
		." tlfespecialista = ?, "
		." sexoespecialista = ?, "
		." id_departamento = ?, "
		." id_provincia = ?, "
		." direcespecialista = ?, "
		." correoespecialista = ?, "
		." especialidad = ?, "
		." fnacespecialista = ?, "
		." twitter = ?, "
		." facebook = ?, "
		." instagram = ?, "
		." google = ? "
		." where "
		." codespecialista = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $tpespecialista);
		$stmt->bindParam(2, $documespecialista);
		$stmt->bindParam(3, $cedespecialista);
		$stmt->bindParam(4, $nomespecialista);
		$stmt->bindParam(5, $tlfespecialista);
		$stmt->bindParam(6, $sexoespecialista);
		$stmt->bindParam(7, $id_departamento);
		$stmt->bindParam(8, $id_provincia);
		$stmt->bindParam(9, $direcespecialista);
		$stmt->bindParam(10, $correoespecialista);
		$stmt->bindParam(11, $especialidad);
		$stmt->bindParam(12, $fnacespecialista);
		$stmt->bindParam(13, $twitter);
		$stmt->bindParam(14, $facebook);
		$stmt->bindParam(15, $instagram);
		$stmt->bindParam(16, $google);
		$stmt->bindParam(17, $codespecialista);

		$tpespecialista = limpiar($_POST["tpespecialista"]);
		$documespecialista = limpiar($_POST["documespecialista"] == '' ? "0" : $_POST['documespecialista']);
		$cedespecialista = limpiar($_POST['cedespecialista']);
		$nomespecialista = limpiar($_POST["nomespecialista"]);
		$tlfespecialista = limpiar($_POST["tlfespecialista"]);
		$sexoespecialista = limpiar($_POST["sexoespecialista"]);
		$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
		$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
		$direcespecialista = limpiar($_POST["direcespecialista"]);
		$correoespecialista = limpiar($_POST["correoespecialista"]);
		$especialidad = limpiar($_POST["especialidad"]);
	$fnacespecialista = limpiar($_POST['fnacespecialista'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fnacespecialista'])));
		$twitter = limpiar($_POST["twitter"]);
		$facebook = limpiar($_POST["facebook"]);
		$instagram = limpiar($_POST["instagram"]);
		$google = limpiar($_POST["google"]);
		$codespecialista = limpiar(decrypt($_POST["codespecialista"]));
		$stmt->execute();

    ######################################  SUBIR FOTO DE ESPECIALISTA ######################################
    //datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
    //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) {  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["codespecialista"].".jpg"))
					{ 
    ## se puede dar un aviso
					} 
    ## se puede dar otro aviso 
				}
    ######################################  FINALIZA SUBIR FOTO DE ESPECIALISTA ######################################

			echo "<span class='fa fa-check-square-o'></span> SUS DATOS HAN SIDO ACTUALIZADOS EXITOSAMENTE";
			exit;

		}
		else
		{
			echo "3";
			exit;
		}
	}
}
############################ FUNCION ACTUALIZAR MIS DATOS ############################

################################## FUNCION REINICIAR CLAVE ESPECIALISTAS ###################################
public function ReiniciarClaveEspecialistas()
{
	self::SetNames();
	$sql = "UPDATE especialistas set "
	." claveespecialista = ? "
	." where "
	." codespecialista = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $claveespecialista);
	$stmt->bindParam(2,$codespecialista);
	
	$claveespecialista = password_hash(decrypt($_GET["cedespecialista"]), PASSWORD_DEFAULT);
	$codespecialista= limpiar(decrypt($_GET['codespecialista']));
	$stmt->execute();

	echo "1";
	exit;
}
################################## FUNCION REINICIAR CLAVE DOCENTES ###################################

########################## FUNCION ELIMINAR ESPECIALISTAS ########################
public function EliminarEspecialistas()
{
	self::SetNames();
    if($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codespecialista FROM citas WHERE codespecialista = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codespecialista"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "DELETE FROM especialistas WHERE codespecialista = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codespecialista);
		$codespecialista = decrypt($_GET["codespecialista"]);
		$stmt->execute();

		$sql = "DELETE FROM accesosxsucursales WHERE codusuario = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codespecialista);
		$codespecialista = decrypt($_GET["codespecialista"]);
		$stmt->execute();

		$cedespecialista = decrypt($_GET["cedespecialista"]);
		if (file_exists("fotos/".$cedespecialista.".jpg")){
	    //funcion para eliminar una carpeta con contenido
		$archivos = "fotos/".$cedespecialista.".jpg";		
		unlink($archivos);
		}

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
############################ FUNCION ELIMINAR ESPECIALISTAS #######################

######################## FUNCION BUSCAR ESPECIALISTAS POR SUCURSAL ##########################
public function BuscarEspecialistasxSucursal() 
	{
	self::SetNames();
	$sql = "SELECT * FROM especialistas 
    LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
    LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal 
	WHERE accesosxsucursales.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	    if($num==0)
	{
		echo "<option value=''> -- SIN RESULTADOS -- </option>";
		exit;
	}
	else
	{
	while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION BUSCAR ESPECIALISTAS POR SUCURSAL ##########################

############################# FIN DE CLASE ESPECIALISTAS ################################
























############################# CLASE PACIENTES ##################################

############################### FUNCION CARGAR PACIENTES ##############################
public function CargaPacientes()
	{
	self::SetNames();
	if(empty($_FILES["sel_file"]))
	{
		echo "1";
		exit;
	}

    //Aquí es donde seleccionamos nuestro csv
     $fname = $_FILES['sel_file']['name'];
     //echo 'Cargando nombre del archivo: '.$fname.' ';
     $chk_ext = explode(".",$fname);
     
    if(strtolower(end($chk_ext)) == "csv")
    {
    //si es correcto, entonces damos permisos de lectura para subir
    $filename = $_FILES['sel_file']['tmp_name'];
    $handle = fopen($filename, "r");
    $this->dbh->beginTransaction();
    
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

        //Insertamos los datos con los valores...
        $query = " INSERT INTO pacientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpaciente);
		$stmt->bindParam(2, $documpaciente);
		$stmt->bindParam(3, $cedpaciente);
		$stmt->bindParam(4, $pnompaciente);
		$stmt->bindParam(5, $snompaciente);
		$stmt->bindParam(6, $papepaciente);
		$stmt->bindParam(7, $sapepaciente);
		$stmt->bindParam(8, $fnacpaciente);
		$stmt->bindParam(9, $tlfpaciente);
		$stmt->bindParam(10, $emailpaciente);
		$stmt->bindParam(11, $gruposapaciente);
		$stmt->bindParam(12, $estadopaciente);
		$stmt->bindParam(13, $ocupacionpaciente);
		$stmt->bindParam(14, $sexopaciente);
		$stmt->bindParam(15, $enfoquepaciente);
		$stmt->bindParam(16, $id_departamento);
		$stmt->bindParam(17, $id_provincia);
		$stmt->bindParam(18, $direcpaciente);
		$stmt->bindParam(19, $nomacompana);
		$stmt->bindParam(20, $direcacompana);
		$stmt->bindParam(21, $tlfacompana);
		$stmt->bindParam(22, $parentescoacompana);
		$stmt->bindParam(23, $nomresponsable);
		$stmt->bindParam(24, $direcresponsable);
		$stmt->bindParam(25, $tlfresponsable);
		$stmt->bindParam(26, $parentescoresponsable);
		$stmt->bindParam(27, $clavepaciente);

    	$codpaciente = limpiar($data[0]);
    	$documpaciente = limpiar($data[1]);
    	$cedpaciente = limpiar($data[2]);
    	$pnompaciente = limpiar($data[3]);
    	$snompaciente = limpiar($data[4]);
    	$papepaciente = limpiar($data[5]);
    	$sapepaciente = limpiar($data[6]);
    	$fnacpaciente = limpiar($data[7]);
    	$tlfpaciente = limpiar($data[8]);
    	$emailpaciente = limpiar($data[9]);
    	$gruposapaciente = limpiar($data[10]);
    	$estadopaciente = limpiar($data[11]);
    	$ocupacionpaciente = limpiar($data[12]);
    	$sexopaciente = limpiar($data[13]);
    	$enfoquepaciente = limpiar($data[14]);
    	$id_departamento = limpiar($data[15]);
    	$id_provincia = limpiar($data[16]);
    	$direcpaciente = limpiar($data[17]);
    	$nomacompana = limpiar($data[18]);
    	$direcacompana = limpiar($data[19]);
    	$tlfacompana = limpiar($data[20]);
    	$parentescoacompana = limpiar($data[21]);
    	$nomresponsable = limpiar($data[22]);
    	$direcresponsable = limpiar($data[23]);
    	$tlfresponsable = limpiar($data[24]);
    	$parentescoresponsable = limpiar($data[25]);
    	$clavepaciente = password_hash($data[2], PASSWORD_DEFAULT);
    	$stmt->execute();
	
    }
           
        $this->dbh->commit();
        //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
        fclose($handle);
	    
	    echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE PACIENTES FUE REALIZADA EXITOSAMENTE";
	    exit;    
    }
    else
    {
        //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
        echo "2";
		exit;
    }  
}
############################## FUNCION CARGAR PACIENTES ##############################

############################ FUNCION REGISTRAR PACIENTES ##########################
public function RegistrarPacientes()
{
	self::SetNames();
	if(empty($_POST["cedpaciente"]) or empty($_POST["pnompaciente"]) or empty($_POST["papepaciente"]) or empty($_POST["gruposapaciente"]) or empty($_POST["estadopaciente"]) or empty($_POST["ocupacionpaciente"]) or empty($_POST["sexopaciente"]) or empty($_POST["enfoquepaciente"]))
	{
		echo "1";
		exit;
	}

	######################### CODIGO DE PACIENTE #########################
    $sql = "SELECT codpaciente FROM pacientes ORDER BY idpaciente DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$id=$row["codpaciente"];

	}
	if(empty($id))
	{
		$codpaciente = "P1";

	} else {

		$resto = substr($id, 0, 1);
		$coun = strlen($resto);
		$num     = substr($id, $coun);
		$codigo     = $num + 1;
		$codpaciente = "P".$codigo;
	}
	######################### CODIGO DE PACIENTE #########################

	$sql = " SELECT cedpaciente FROM pacientes WHERE cedpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["cedpaciente"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " INSERT INTO pacientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpaciente);
		$stmt->bindParam(2, $documpaciente);
		$stmt->bindParam(3, $cedpaciente);
		$stmt->bindParam(4, $pnompaciente);
		$stmt->bindParam(5, $snompaciente);
		$stmt->bindParam(6, $papepaciente);
		$stmt->bindParam(7, $sapepaciente);
		$stmt->bindParam(8, $fnacpaciente);
		$stmt->bindParam(9, $tlfpaciente);
		$stmt->bindParam(10, $emailpaciente);
		$stmt->bindParam(11, $gruposapaciente);
		$stmt->bindParam(12, $estadopaciente);
		$stmt->bindParam(13, $ocupacionpaciente);
		$stmt->bindParam(14, $sexopaciente);
		$stmt->bindParam(15, $enfoquepaciente);
		$stmt->bindParam(16, $id_departamento);
		$stmt->bindParam(17, $id_provincia);
		$stmt->bindParam(18, $direcpaciente);
		$stmt->bindParam(19, $nomacompana);
		$stmt->bindParam(20, $direcacompana);
		$stmt->bindParam(21, $tlfacompana);
		$stmt->bindParam(22, $parentescoacompana);
		$stmt->bindParam(23, $nomresponsable);
		$stmt->bindParam(24, $direcresponsable);
		$stmt->bindParam(25, $tlfresponsable);
		$stmt->bindParam(26, $parentescoresponsable);
		$stmt->bindParam(27, $clavepaciente);

		$documpaciente = limpiar($_POST["documpaciente"] == '' ? "0" : $_POST['documpaciente']);
		$cedpaciente = limpiar($_POST["cedpaciente"]);
		$pnompaciente = limpiar($_POST["pnompaciente"]);
		$snompaciente = limpiar($_POST["snompaciente"]);
		$papepaciente = limpiar($_POST["papepaciente"]);
		$sapepaciente = limpiar($_POST["sapepaciente"]);
		$fnacpaciente = limpiar($_POST['fnacpaciente'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fnacpaciente'])));
		$tlfpaciente = limpiar($_POST["tlfpaciente"]);
		$emailpaciente = limpiar($_POST["emailpaciente"]);
		$gruposapaciente = limpiar($_POST["gruposapaciente"]);
		$estadopaciente = limpiar($_POST["estadopaciente"]);
		$ocupacionpaciente = limpiar($_POST["ocupacionpaciente"]);
		$sexopaciente = limpiar($_POST["sexopaciente"]);
		$enfoquepaciente = limpiar($_POST["enfoquepaciente"]);
		$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
		$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
		$direcpaciente = limpiar($_POST["direcpaciente"]);
		$nomacompana = limpiar($_POST["nomacompana"]);
		$direcacompana = limpiar($_POST["direcacompana"]);
		$tlfacompana = limpiar($_POST["tlfacompana"]);
		$parentescoacompana = limpiar($_POST["parentescoacompana"]);
		$nomresponsable = limpiar($_POST["nomresponsable"]);
		$direcresponsable = limpiar($_POST["direcresponsable"]);
		$tlfresponsable = limpiar($_POST["tlfresponsable"]);
		$parentescoresponsable = limpiar($_POST["parentescoresponsable"]);
		$clavepaciente = password_hash($_POST["cedpaciente"], PASSWORD_DEFAULT);
		$stmt->execute();

    ######################################  SUBIR FOTO DE PACIENTE ######################################
    //datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
    //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["codpaciente"].".png"))
					{ 
    ## se puede dar un aviso
					} 
    ## se puede dar otro aviso 
				}
    ######################################  FINALIZA SUBIR FOTO DE PACIENTE ######################################


		echo "<span class='fa fa-check-square-o'></span> EL PACIENTE HA SIDO REGISTRADO EXITOSAMENTE";
		exit;
	}
	else
	{
		echo "2";
		exit;
	}
}
######################### FUNCION REGISTRAR PACIENTES ###############################

########################## FUNCION BUSQUEDA DE PACIENTES ###############################
public function BusquedaPacientes()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    $sql = "SELECT
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.emailpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	pacientes.id_departamento,
	pacientes.id_provincia,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	pacientes.parentescoacompana,
	pacientes.nomresponsable,
	pacientes.direcresponsable,
	pacientes.tlfresponsable,
	pacientes.parentescoresponsable,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia
	FROM pacientes 
	LEFT JOIN documentos ON pacientes.documpaciente = documentos.coddocumento
	LEFT JOIN departamentos ON pacientes.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON pacientes.id_provincia = provincias.id_provincia WHERE
    (pacientes.codpaciente = '".$buscar."')
    OR 
    (pacientes.cedpaciente = '".$buscar."')
    OR 
    (pacientes.pnompaciente = '".$buscar."')
    OR
    (pacientes.snompaciente = '".$buscar."')
    OR 
    (pacientes.papepaciente = '".$buscar."') 
    OR 
    (pacientes.sapepaciente = '".$buscar."')
    OR
    (pacientes.gruposapaciente = '".$buscar."') LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE PACIENTES ###############################

######################## FUNCION LISTAR PACIENTES ###############################
public function ListarPacientes()
{
	self::SetNames();
	$sql = "SELECT
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	pacientes.pnompaciente,
	pacientes.snompaciente,
	pacientes.papepaciente,
	pacientes.sapepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.emailpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	pacientes.id_departamento,
	pacientes.id_provincia,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	pacientes.parentescoacompana,
	pacientes.nomresponsable,
	pacientes.direcresponsable,
	pacientes.tlfresponsable,
	pacientes.parentescoresponsable,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia
	FROM pacientes 
	LEFT JOIN documentos ON pacientes.documpaciente = documentos.coddocumento
	LEFT JOIN departamentos ON pacientes.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON pacientes.id_provincia = provincias.id_provincia";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################## FUNCION LISTAR PACIENTES ##########################

############################ FUNCION ID PACIENTES #################################
public function PacientesPorId()
{
	self::SetNames();
	
	if ($_SESSION['acceso'] == "paciente") {

	$sql = "SELECT
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	pacientes.pnompaciente,
	pacientes.snompaciente,
	pacientes.papepaciente,
	pacientes.sapepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.emailpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	pacientes.id_departamento,
	pacientes.id_provincia,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	pacientes.parentescoacompana,
	pacientes.nomresponsable,
	pacientes.direcresponsable,
	pacientes.tlfresponsable,
	pacientes.parentescoresponsable,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia
	FROM pacientes 
	LEFT JOIN documentos ON pacientes.documpaciente = documentos.coddocumento
	LEFT JOIN departamentos ON pacientes.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON pacientes.id_provincia = provincias.id_provincia 
	WHERE pacientes.codpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_SESSION["codpaciente"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}

	} else {

	$sql = "SELECT
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	pacientes.pnompaciente,
	pacientes.snompaciente,
	pacientes.papepaciente,
	pacientes.sapepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.emailpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	pacientes.id_departamento,
	pacientes.id_provincia,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	pacientes.parentescoacompana,
	pacientes.nomresponsable,
	pacientes.direcresponsable,
	pacientes.tlfresponsable,
	pacientes.parentescoresponsable,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia
	FROM pacientes 
	LEFT JOIN documentos ON pacientes.documpaciente = documentos.coddocumento
	LEFT JOIN departamentos ON pacientes.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON pacientes.id_provincia = provincias.id_provincia 
	WHERE pacientes.codpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpaciente"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	    }
    }
}
############################ FUNCION ID PACIENTES #################################

############################ FUNCION ACTUALIZAR PACIENTES ############################
public function ActualizarPacientes()
{
	self::SetNames();
	if(empty($_POST["codpaciente"]) or empty($_POST["cedpaciente"]) or empty($_POST["pnompaciente"]) or empty($_POST["papepaciente"]) or empty($_POST["gruposapaciente"]) or empty($_POST["estadopaciente"]) or empty($_POST["ocupacionpaciente"]) or empty($_POST["sexopaciente"]) or empty($_POST["enfoquepaciente"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT cedpaciente FROM pacientes WHERE codpaciente != ? AND cedpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codpaciente"],$_POST["cedpaciente"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " UPDATE pacientes set "
		." documpaciente = ?, "
		." cedpaciente = ?, "
		." pnompaciente = ?, "
		." snompaciente = ?, "
		." papepaciente = ?, "
		." sapepaciente = ?, "
		." fnacpaciente = ?, "
		." tlfpaciente = ?, "
		." emailpaciente = ?, "
		." gruposapaciente = ?, "
		." estadopaciente = ?, "
		." ocupacionpaciente = ?, "
		." sexopaciente = ?, "
		." enfoquepaciente = ?, "
		." id_departamento = ?, "
		." id_provincia = ?, "
		." direcpaciente = ?, "
		." nomacompana = ?, "
		." direcacompana = ?, "
		." tlfacompana = ?, "
		." parentescoacompana = ?, "
		." nomresponsable = ?, "
		." direcresponsable = ?, "
		." tlfresponsable = ?, "
		." parentescoresponsable = ? "
		." where "
		." codpaciente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $documpaciente);
		$stmt->bindParam(2, $cedpaciente);
		$stmt->bindParam(3, $pnompaciente);
		$stmt->bindParam(4, $snompaciente);
		$stmt->bindParam(5, $papepaciente);
		$stmt->bindParam(6, $sapepaciente);
		$stmt->bindParam(7, $fnacpaciente);
		$stmt->bindParam(8, $tlfpaciente);
		$stmt->bindParam(9, $emailpaciente);
		$stmt->bindParam(10, $gruposapaciente);
		$stmt->bindParam(11, $estadopaciente);
		$stmt->bindParam(12, $ocupacionpaciente);
		$stmt->bindParam(13, $sexopaciente);
		$stmt->bindParam(14, $enfoquepaciente);
		$stmt->bindParam(15, $id_departamento);
		$stmt->bindParam(16, $id_provincia);
		$stmt->bindParam(17, $direcpaciente);
		$stmt->bindParam(18, $nomacompana);
		$stmt->bindParam(19, $direcacompana);
		$stmt->bindParam(20, $tlfacompana);
		$stmt->bindParam(21, $parentescoacompana);
		$stmt->bindParam(22, $nomresponsable);
		$stmt->bindParam(23, $direcresponsable);
		$stmt->bindParam(24, $tlfresponsable);
		$stmt->bindParam(25, $parentescoresponsable);
		$stmt->bindParam(26, $codpaciente);

		$documpaciente = limpiar($_POST["documpaciente"] == '' ? "0" : $_POST['documpaciente']);
		$cedpaciente = limpiar($_POST["cedpaciente"]);
		$pnompaciente = limpiar($_POST["pnompaciente"]);
		$snompaciente = limpiar($_POST["snompaciente"]);
		$papepaciente = limpiar($_POST["papepaciente"]);
		$sapepaciente = limpiar($_POST["sapepaciente"]);
		$fnacpaciente = limpiar($_POST['fnacpaciente'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fnacpaciente'])));
		$tlfpaciente = limpiar($_POST["tlfpaciente"]);
		$emailpaciente = limpiar($_POST["emailpaciente"]);
		$gruposapaciente = limpiar($_POST["gruposapaciente"]);
		$estadopaciente = limpiar($_POST["estadopaciente"]);
		$ocupacionpaciente = limpiar($_POST["ocupacionpaciente"]);
		$sexopaciente = limpiar($_POST["sexopaciente"]);
		$enfoquepaciente = limpiar($_POST["enfoquepaciente"]);
		$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
		$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
		$direcpaciente = limpiar($_POST["direcpaciente"]);
		$nomacompana = limpiar($_POST["nomacompana"]);
		$direcacompana = limpiar($_POST["direcacompana"]);
		$tlfacompana = limpiar($_POST["tlfacompana"]);
		$parentescoacompana = limpiar($_POST["parentescoacompana"]);
		$nomresponsable = limpiar($_POST["nomresponsable"]);
		$direcresponsable = limpiar($_POST["direcresponsable"]);
		$tlfresponsable = limpiar($_POST["tlfresponsable"]);
		$parentescoresponsable = limpiar($_POST["parentescoresponsable"]);
		$codpaciente = limpiar($_POST["codpaciente"]);
		$stmt->execute();

    ######################################  SUBIR FOTO DE PACIENTE ######################################
    //datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
    //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["codpaciente"].".png"))
					{ 
    ## se puede dar un aviso
					} 
    ## se puede dar otro aviso 
				}
    ######################################  FINALIZA SUBIR FOTO DE PACIENTE ######################################

		if ($_SESSION['acceso'] == "paciente") {

		echo "<span class='fa fa-check-square-o'></span> SUS DATOS HAN SIDO ACTUALIZADOS EXITOSAMENTE";
		exit;

		} else {

		echo "<span class='fa fa-check-square-o'></span> EL PACIENTE HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

		}

	}
	else
	{
		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR PACIENTES ############################

########################## FUNCION ELIMINAR PACIENTES ########################
public function EliminarPacientes()
{
	self::SetNames();
    if($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codpaciente FROM citas WHERE codpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpaciente"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "DELETE FROM pacientes WHERE codpaciente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpaciente);
		$codpaciente = decrypt($_GET["codpaciente"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
############################ FUNCION ELIMINAR PACIENTES #######################

############################# FIN DE CLASE PACIENTES ################################
























################################## CLASE PROVEEDORES ###################################

########################## FUNCION CARGAR PROVEEDORES ###############################
	public function CargarProveedores()
	{
		self::SetNames();
		if(empty($_FILES["sel_file"]))
		{
			echo "1";
			exit;
		}
        //Aquí es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         //echo 'Cargando nombre del archivo: '.$fname.' ';
         $chk_ext = explode(".",$fname);
         
        if(strtolower(end($chk_ext)) == "csv")
        {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        $this->dbh->beginTransaction();
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

               //Insertamos los datos con los valores...
			   
		$query = "INSERT INTO proveedores values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproveedor);
		$stmt->bindParam(2, $documproveedor);
		$stmt->bindParam(3, $dniproveedor);
		$stmt->bindParam(4, $nomproveedor);
		$stmt->bindParam(5, $tlfproveedor);
		$stmt->bindParam(6, $id_departamento);
		$stmt->bindParam(7, $id_provincia);
		$stmt->bindParam(8, $direcproveedor);
		$stmt->bindParam(9, $emailproveedor);
		$stmt->bindParam(10, $vendedor);
		$stmt->bindParam(11, $fechaingreso);

		$codproveedor = limpiar($data[0]);
		$documproveedor = limpiar($data[1]);
		$dniproveedor = limpiar($data[2]);
		$nomproveedor = limpiar($data[3]);
		$tlfproveedor = limpiar($data[4]);
		$id_departamento = limpiar($data[5]);
		$id_provincia = limpiar($data[6]);
		$direcproveedor = limpiar($data[7]);
		$emailproveedor = limpiar($data[8]);
		$vendedor = limpiar($data[9]);
		$fechaingreso = limpiar(date("Y-m-d"));
		$stmt->execute();
				
        }
           $this->dbh->commit();
           //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
           fclose($handle);
	        
	echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE PROVEEDORES FUE REALIZADA EXITOSAMENTE";
	exit;
             
         }
         else
         {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
         echo "2";
		 exit;
      }  
}
############################# FUNCION CARGAR PROVEEDORES ##############################

############################ FUNCION REGISTRAR PROVEEDORES ##########################
public function RegistrarProveedores()
{
	self::SetNames();
	if(empty($_POST["cuitproveedor"]) or empty($_POST["nomproveedor"]) or empty($_POST["direcproveedor"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT codproveedor FROM proveedores ORDER BY idproveedor DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$id=$row["codproveedor"];

	}
	if(empty($id))
	{
		$codproveedor = "P1";

	} else {

		$resto = substr($id, 0, 1);
		$coun = strlen($resto);
		$num     = substr($id, $coun);
		$codigo     = $num + 1;
		$codproveedor = "P".$codigo;
	}

	$sql = " SELECT cuitproveedor FROM proveedores WHERE cuitproveedor = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["cuitproveedor"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = " INSERT INTO proveedores values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproveedor);
	    $stmt->bindParam(2, $documproveedor);
		$stmt->bindParam(3, $cuitproveedor);
		$stmt->bindParam(4, $nomproveedor);
		$stmt->bindParam(5, $tlfproveedor);
		$stmt->bindParam(7, $id_departamento);
		$stmt->bindParam(6, $id_provincia);
		$stmt->bindParam(8, $direcproveedor);
		$stmt->bindParam(9, $emailproveedor);
		$stmt->bindParam(10, $vendedor);
		$stmt->bindParam(11, $fechaingreso);
		
		$documproveedor = limpiar($_POST['documproveedor'] == '' ? "0" : $_POST['documproveedor']);
		$cuitproveedor = limpiar($_POST["cuitproveedor"]);
		$nomproveedor = limpiar($_POST["nomproveedor"]);
		$tlfproveedor = limpiar($_POST["tlfproveedor"]);
		$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
		$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
		$direcproveedor = limpiar($_POST["direcproveedor"]);
		$emailproveedor = limpiar($_POST["emailproveedor"]);
		$vendedor = limpiar($_POST["vendedor"]);
	    $fechaingreso = limpiar(date("Y-m-d"));
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL PROVEEDOR HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

	} else {

		echo "2";
		exit;
	}
}
########################### FUNCION REGISTRAR PROVEEDORES ########################

########################### FUNCION LISTAR PROVEEDORES ################################
public function ListarProveedores()
	{
	self::SetNames();
    $sql = "SELECT
	proveedores.codproveedor,
	proveedores.documproveedor,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	proveedores.tlfproveedor,
	proveedores.id_departamento,
	proveedores.id_provincia,
	proveedores.direcproveedor,
	proveedores.emailproveedor,
	proveedores.vendedor,
	proveedores.fechaingreso,
    documentos.documento,
	departamentos.departamento,
	provincias.provincia
	FROM proveedores 
	LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
	LEFT JOIN departamentos ON proveedores.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON proveedores.id_provincia = provincias.id_provincia";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################### FUNCION LISTAR PROVEEDORES ################################

########################### FUNCION ID PROVEEDORES #################################
public function ProveedoresPorId()
{
	self::SetNames();
	$sql = "SELECT
	proveedores.codproveedor,
	proveedores.documproveedor,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	proveedores.tlfproveedor,
	proveedores.id_departamento,
	proveedores.id_provincia,
	proveedores.direcproveedor,
	proveedores.emailproveedor,
	proveedores.vendedor,
	proveedores.fechaingreso,
    documentos.documento,
	departamentos.departamento,
	provincias.provincia
	FROM proveedores 
	LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
	LEFT JOIN departamentos ON proveedores.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON proveedores.id_provincia = provincias.id_provincia WHERE proveedores.codproveedor = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codproveedor"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PROVEEDORES #################################
	
############################ FUNCION ACTUALIZAR PROVEEDORES ############################
public function ActualizarProveedores()
{
self::SetNames();
	if(empty($_POST["codproveedor"]) or empty($_POST["cuitproveedor"]) or empty($_POST["nomproveedor"]) or empty($_POST["direcproveedor"]))
	{
		echo "1";
		exit;
	}
	$sql = " SELECT cuitproveedor FROM proveedores WHERE codproveedor != ? AND cuitproveedor = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codproveedor"],$_POST["cuitproveedor"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "UPDATE proveedores set "
		." documproveedor = ?, "
		." cuitproveedor = ?, "
		." nomproveedor = ?, "
		." tlfproveedor = ?, "
		." id_provincia = ?, "
		." id_departamento = ?, "
		." direcproveedor = ?, "
		." emailproveedor = ?, "
		." vendedor = ? "
		." where "
		." codproveedor = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $documproveedor);
		$stmt->bindParam(2, $cuitproveedor);
		$stmt->bindParam(3, $nomproveedor);
		$stmt->bindParam(4, $tlfproveedor);
		$stmt->bindParam(5, $id_provincia);
		$stmt->bindParam(6, $id_departamento);
		$stmt->bindParam(7, $direcproveedor);
		$stmt->bindParam(8, $emailproveedor);
		$stmt->bindParam(9, $vendedor);
		$stmt->bindParam(10, $codproveedor);
		
		$documproveedor = limpiar($_POST['documproveedor'] == '' ? "0" : $_POST['documproveedor']);
		$cuitproveedor = limpiar($_POST["cuitproveedor"]);
		$nomproveedor = limpiar($_POST["nomproveedor"]);
		$tlfproveedor = limpiar($_POST["tlfproveedor"]);
		$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
		$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
		$direcproveedor = limpiar($_POST["direcproveedor"]);
		$emailproveedor = limpiar($_POST["emailproveedor"]);
		$vendedor = limpiar($_POST["vendedor"]);
		$codproveedor = limpiar($_POST["codproveedor"]);
		$stmt->execute();
    
	echo "<span class='fa fa-check-square-o'></span> EL PROVEEDOR HA SIDO ACTUALIZADO EXITOSAMENTE";
	exit;

	} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR PROVEEDORES ############################

########################## FUNCION ELIMINAR PROVEEDORES #################################
public function EliminarProveedores()
{
     self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codproveedor FROM productos WHERE codproveedor = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codproveedor"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM proveedores where codproveedor = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproveedor);
		$codproveedor = decrypt($_GET["codproveedor"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
	   
		echo "2";
		exit;
	  } 
		
	} else {
	
	echo "3";
	exit;
    }	
}
########################### FUNCION ELIMINAR PROVEEDORES #########################

############################## FIN DE CLASE PROVEEDORES #################################






























############################# CLASE SERVICIOS ##################################

############################### FUNCION CARGAR SERVICIOS ##############################
	public function CargaServicios()
	{
		self::SetNames();
		if(empty($_FILES["sel_file"]))
		{
			echo "1";
			exit;
		}

  //$porcentaje=($_SESSION['acceso']=="administradorG" ? "0.00" : $_SESSION['porcentaje']);

        //Aquí es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         //echo 'Cargando nombre del archivo: '.$fname.' ';
         $chk_ext = explode(".",$fname);
         
        if(strtolower(end($chk_ext)) == "csv")
        {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        $this->dbh->beginTransaction();
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

        //Insertamos los datos con los valores...
        $query = "INSERT INTO servicios values (null, ?, ?, ?, ?, ?, ?, ?, ?);";
    	$stmt = $this->dbh->prepare($query);
    	$stmt->bindParam(1, $codservicio);
    	$stmt->bindParam(2, $servicio);
    	$stmt->bindParam(3, $preciocompra);
    	$stmt->bindParam(4, $precioventa);
    	$stmt->bindParam(5, $ivaservicio);
    	$stmt->bindParam(6, $descservicio);
    	$stmt->bindParam(7, $status);
    	$stmt->bindParam(8, $codsucursal);

    	$codservicio = limpiar($data[0]);
    	$servicio = limpiar($data[1]);
    	$preciocompra = limpiar($data[2]);
    	$precioventa = limpiar($data[3]);
    	$ivaservicio = limpiar($data[4]);
    	$descservicio = limpiar($data[5]);
    	$status = limpiar($data[6]);
    	$codsucursal = limpiar($_SESSION["codsucursal"]);
    	$stmt->execute();
	
        }
           
           $this->dbh->commit();
           //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
           fclose($handle);
	        
	echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE SERVICIOS FUE REALIZADA EXITOSAMENTE";
	exit;
             
         }
         else
         {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
         echo "2";
		 exit;
      }  
}
############################## FUNCION CARGAR SERVICIOS ##############################

############################ FUNCION REGISTRAR SERVICIOS ##########################
public function RegistrarServicios()
{
	self::SetNames();
	if(empty($_POST["servicio"]) or empty($_POST["preciocompra"]) or empty($_POST["precioventa"]) or empty($_POST["ivaservicio"]) or empty($_POST["descservicio"]))
	{
		echo "1";
		exit;
	}

	######################### CODIGO DE SERVICIO #########################
    $sql = "SELECT codservicio FROM servicios ORDER BY idservicio DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$id=$row["codservicio"];

	}
	if(empty($id))
	{
		$codservicio = "S1";

	} else {

		$resto = substr($id, 0, 1);
		$coun = strlen($resto);
		$num     = substr($id, $coun);
		$codigo     = $num + 1;
		$codservicio = "S".$codigo;
	}
	######################### CODIGO DE SERVICIO #########################

	$sql = " SELECT servicio FROM servicios WHERE servicio = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["servicio"],decrypt($_POST["codsucursal"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO servicios values (null, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codservicio);
		$stmt->bindParam(2, $servicio);
		$stmt->bindParam(3, $preciocompra);
		$stmt->bindParam(4, $precioventa);
		$stmt->bindParam(5, $ivaservicio);
		$stmt->bindParam(6, $descservicio);
		$stmt->bindParam(7, $status);
		$stmt->bindParam(8, $codsucursal);

		$servicio = limpiar($_POST["servicio"]);
		$preciocompra = limpiar($_POST['preciocompra']);
		$precioventa = limpiar($_POST['precioventa']);
		$ivaservicio = limpiar($_POST["ivaservicio"]);
		$descservicio = limpiar($_POST["descservicio"]);
		$status = limpiar($_POST["status"]);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL SERVICIO HA SIDO REGISTRADO EXITOSAMENTE";
		exit;
	}
	else
	{
		echo "2";
		exit;
	}
}
######################### FUNCION REGISTRAR SERVICIOS ###############################

######################## FUNCION LISTAR SERVICIOS ###############################
public function ListarServicios()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
	servicios.idservicio,
	servicios.codservicio,
	servicios.servicio,
	servicios.preciocompra,
	servicios.precioventa,
	servicios.ivaservicio,
	servicios.descservicio,
	servicios.status,
	servicios.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	departamentos.departamento,
	provincias.provincia 
	FROM servicios 
	INNER JOIN sucursales ON servicios.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia WHERE servicios.codsucursal = ?";
     $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA</center>";
		echo "</div>";		
	   exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
				$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}	

	} else {

	$sql = "SELECT
	servicios.idservicio,
	servicios.codservicio,
	servicios.servicio,
	servicios.preciocompra,
	servicios.precioventa,
	servicios.ivaservicio,
	servicios.descservicio,
	servicios.status,
	servicios.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	departamentos.departamento,
	provincias.provincia 
	FROM servicios 
	INNER JOIN sucursales ON servicios.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	WHERE servicios.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
	}
 }
########################## FUNCION LISTAR SERVICIOS ##########################

############################ FUNCION ID SERVICIOS #################################
public function ServiciosPorId()
{
	self::SetNames();
	$sql = "SELECT
	servicios.idservicio,
	servicios.codservicio,
	servicios.servicio,
	servicios.preciocompra,
	servicios.precioventa,
	servicios.ivaservicio,
	servicios.descservicio,
	servicios.status,
	servicios.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	departamentos.departamento,
	provincias.provincia 
	FROM servicios 
	INNER JOIN sucursales ON servicios.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia WHERE servicios.codservicio = ? AND servicios.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codservicio"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID SERVICIOS #################################

############################ FUNCION ACTUALIZAR SERVICIOS ############################
public function ActualizarServicios()
{

	self::SetNames();
	if(empty($_POST["codservicio"]) or empty($_POST["servicio"]) or empty($_POST["preciocompra"]) or empty($_POST["precioventa"]) or empty($_POST["ivaservicio"]) or empty($_POST["descservicio"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT servicio FROM servicios WHERE codservicio != ? AND servicio = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codservicio"],$_POST["servicio"],decrypt($_POST["codsucursal"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " UPDATE servicios set "
		." servicio = ?, "
		." preciocompra = ?, "
		." precioventa = ?, "
		." ivaservicio = ?, "
		." descservicio = ?, "
		." status = ?, "
		." codsucursal = ? "
		." where "
		." codservicio = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $servicio);
		$stmt->bindParam(2, $preciocompra);
		$stmt->bindParam(3, $precioventa);
		$stmt->bindParam(4, $ivaservicio);
		$stmt->bindParam(5, $descservicio);
		$stmt->bindParam(6, $status);
		$stmt->bindParam(7, $codsucursal);
		$stmt->bindParam(8, $codservicio);

		$servicio = limpiar($_POST["servicio"]);
		$preciocompra = limpiar($_POST['preciocompra']);
	    $precioventa = limpiar($_POST['precioventa']);
		$ivaservicio = limpiar($_POST["ivaservicio"]);
		$descservicio = limpiar($_POST["descservicio"]);
		$status = limpiar($_POST["status"]);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$codservicio = limpiar($_POST["codservicio"]);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL SERVICIO HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

	}
	else
	{
		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR SERVICIOS ############################

########################## FUNCION ELIMINAR SERVICIOS ########################
public function EliminarServicios()
{
	self::SetNames();
    if($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codproducto FROM detalle_ventas WHERE codproducto = ? AND tipodetalle = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codservicio"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "DELETE FROM servicios WHERE codservicio = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codservicio);
		$codservicio = decrypt($_GET["codservicio"]);
		$stmt->execute();

		$sql = "DELETE FROM kardex WHERE codproducto = ? AND codsucursal = ? AND tipokardex = 1";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codservicio);
		$stmt->bindParam(2,$codsucursal);
		$codservicio = decrypt($_GET["codservicio"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
############################ FUNCION ELIMINAR SERVICIOS #######################

###################### FUNCION BUSCAR SERVICIOS VENDIDOS #########################
public function BuscarServiciosVendidos() 
{
	self::SetNames();
	$sql ="SELECT
	detalle_ventas.idproducto,
	detalle_ventas.codproducto,
	detalle_ventas.producto,
	detalle_ventas.codmarca,
	detalle_ventas.codpresentacion, 
	detalle_ventas.codmedida, 
	detalle_ventas.ivaproducto,
	detalle_ventas.descproducto, 
	detalle_ventas.precioventa,
	servicios.codservicio, 
	ventas.iva, 
	ventas.fechaventa, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio, 
	SUM(detalle_ventas.cantventa) as cantidad 
	FROM (ventas INNER JOIN detalle_ventas ON ventas.codventa = detalle_ventas.codventa) 
	INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN servicios ON detalle_ventas.idproducto = servicios.idservicio  
	WHERE ventas.codsucursal = '".decrypt($_GET['codsucursal'])."' 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND detalle_ventas.tipodetalle = 1
	GROUP BY detalle_ventas.codproducto, detalle_ventas.precioventa, detalle_ventas.descproducto 
	ORDER BY detalle_ventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION SERVICIOS VENDIDOS ###############################

###################### FUNCION BUSCAR SERVICIOS VENDIDOS POR VENDEDOR #########################
public function BuscarServiciosxVendedor() 
{
	self::SetNames();
	$sql ="SELECT
	detalle_ventas.idproducto,
	detalle_ventas.codproducto,
	detalle_ventas.producto,
	detalle_ventas.codmarca,
	detalle_ventas.codpresentacion, 
	detalle_ventas.codmedida, 
	detalle_ventas.ivaproducto,
	detalle_ventas.descproducto, 
	detalle_ventas.precioventa,
	servicios.codservicio, 
	ventas.iva, 
	ventas.fechaventa, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	usuarios.dni,
	usuarios.nombres,  
	SUM(detalle_ventas.cantventa) as cantidad 
	FROM (ventas INNER JOIN detalle_ventas ON ventas.codventa = detalle_ventas.codventa) 
	INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN servicios ON detalle_ventas.idproducto = servicios.idservicio   
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
	WHERE ventas.codsucursal = '".decrypt($_GET['codsucursal'])."'
	AND ventas.codigo = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND detalle_ventas.tipodetalle = 1
	GROUP BY detalle_ventas.codproducto, detalle_ventas.precioventa, detalle_ventas.descproducto 
	ORDER BY detalle_ventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION PRODUCTOS SERVICIOS VENDIDOS POR VENDEDOR ###############################

######################## FUNCION DETALLE KARDEX SERVICIO #########################
public function DetalleKardexServicio()
{
	self::SetNames();
	$sql = "SELECT
	servicios.idservicio,
	servicios.codservicio,
	servicios.servicio,
	servicios.preciocompra,
	servicios.precioventa,
	servicios.ivaservicio,
	servicios.descservicio,
	servicios.status,
	servicios.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	departamentos.departamento,
	provincias.provincia 
	FROM servicios 
	INNER JOIN sucursales ON servicios.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	WHERE servicios.codservicio = ? AND servicios.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codservicio"],decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION DETALLE KARDEX SERVICIO #########################

######################## FUNCION BUSCA KARDEX SERVICIOS ##########################
public function BuscarKardexServicio() 
{
	self::SetNames();
	$sql ="SELECT * FROM kardex WHERE codproducto = ? AND codsucursal = ? AND tipokardex = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codservicio"], decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION BUSCA KARDEX SERVICIOS #########################

###################### FUNCION SERVICIOS POR FECHAS Y VENDEDOR #########################
public function BuscarKardexServiciosValorizadoxFechas() 
{
	self::SetNames();
	$sql ="SELECT
	detalle_ventas.idproducto,
	detalle_ventas.codproducto,
	detalle_ventas.producto,
	detalle_ventas.ivaproducto, 
	detalle_ventas.descproducto, 
	detalle_ventas.preciocompra,
	detalle_ventas.precioventa, 
	servicios.codservicio, 
	ventas.iva,
	ventas.fechaventa, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	usuarios.dni,
	usuarios.nombres, 
	SUM(detalle_ventas.cantventa) as cantidad 
	FROM (ventas INNER JOIN detalle_ventas ON ventas.codventa = detalle_ventas.codventa) 
	INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	INNER JOIN usuarios ON ventas.codigo = usuarios.codigo 
	INNER JOIN servicios ON detalle_ventas.idproducto = servicios.idservicio 
	WHERE ventas.codsucursal = '".decrypt($_GET['codsucursal'])."' 
	AND ventas.codigo = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND detalle_ventas.tipodetalle = 1  
	GROUP BY detalle_ventas.codproducto, detalle_ventas.precioventa, detalle_ventas.descproducto 
	ORDER BY detalle_ventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION KARDEX SERVICIOS POR FECHAS Y VENDEDOR ###############################

############################# FIN DE CLASE SERVICIOS ################################

































################################# CLASE PRODUCTOS ######################################

############################### FUNCION CARGAR PRODUCTOS ##############################
	public function CargarProductos()
	{
		self::SetNames();
		if(empty($_FILES["sel_file"]))
		{
			echo "1";
			exit;
		}

  //$porcentaje=($_SESSION['acceso']=="administradorG" ? "0.00" : $_SESSION['porcentaje']);

        //Aquí es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         //echo 'Cargando nombre del archivo: '.$fname.' ';
         $chk_ext = explode(".",$fname);
         
        if(strtolower(end($chk_ext)) == "csv")
        {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        $this->dbh->beginTransaction();
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

        //Insertamos los datos con los valores...
        $query = "INSERT INTO productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    	$stmt = $this->dbh->prepare($query);
    	$stmt->bindParam(1, $codproducto);
    	$stmt->bindParam(2, $producto);
    	$stmt->bindParam(3, $codmarca);
    	$stmt->bindParam(4, $codpresentacion);
    	$stmt->bindParam(5, $codmedida);
    	$stmt->bindParam(6, $lote);
    	$stmt->bindParam(7, $preciocompra);
    	$stmt->bindParam(8, $precioventa);
    	$stmt->bindParam(9, $existencia);
    	$stmt->bindParam(10, $stockminimo);
    	$stmt->bindParam(11, $stockmaximo);
    	$stmt->bindParam(12, $ivaproducto);
    	$stmt->bindParam(13, $descproducto);
    	$stmt->bindParam(14, $fechaelaboracion);
    	$stmt->bindParam(15, $fechaexpiracion);
    	$stmt->bindParam(16, $codproveedor);
    	$stmt->bindParam(17, $stockteorico);
    	$stmt->bindParam(18, $motivoajuste);
    	$stmt->bindParam(19, $codsucursal);

    	$codproducto = limpiar($data[0]);
    	$producto = limpiar($data[1]);
    	$codmarca = limpiar($data[2]);
    	$codpresentacion = limpiar($data[3]);
    	$codmedida = limpiar($data[4]);
    	$lote = limpiar($data[5]);
    	$preciocompra = limpiar($data[6]);
    	$precioventa = limpiar($data[7]);
    	$existencia = limpiar($data[8]);
    	$stockminimo = limpiar($data[9]);
    	$stockmaximo = limpiar($data[10]);
    	$ivaproducto = limpiar($data[11]);
    	$descproducto = limpiar($data[12]);
    	$fechaelaboracion = limpiar($data[13]);
    	$fechaexpiracion = limpiar($data[14]);
    	$codproveedor = limpiar($data[15]);
    	$stockteorico = limpiar("0");
    	$motivoajuste = limpiar("NINGUNO");
    	$codsucursal = limpiar($_SESSION["codsucursal"]);
    	$stmt->execute();

        #################### REGISTRAMOS PRODUCTOS EN KARDEX #####################
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproceso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);
		$stmt->bindParam(15, $codsucursal);
		
		$codproceso = limpiar($data[0]);
		$codresponsable = limpiar("0");
		$codproducto = limpiar($data[0]);
		$movimiento = limpiar("ENTRADAS");
		$entradas = limpiar($data[8]);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($data[8]);
		$ivaproducto = limpiar($data[11]);
		$descproducto = limpiar($data[12]);
		$precio = limpiar($data[6]);
		$documento = limpiar("INVENTARIO INICIAL");
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("2");
    	$codsucursal = limpiar($_SESSION["codsucursal"]);
		$stmt->execute();
		#################### REGISTRAMOS PRODUCTOS EN KARDEX #####################
	
        }
           
           $this->dbh->commit();
           //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
           fclose($handle);
	    echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE PRODUCTOS FUE REALIZADA EXITOSAMENTE";
	    exit;
             
    }
    else
    {
        //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
        echo "2";
		exit;
    }  
}
############################## FUNCION CARGAR PRODUCTOS ##############################

########################### FUNCION REGISTRAR PRODUCTOS ###############################
public function RegistrarProductos()
	{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codmarca"]) or empty($_POST["codpresentacion"]) or empty($_POST["preciocompra"]) or empty($_POST["precioventa"]))
	{
		echo "1";
		exit;
	}

	$sql = " SELECT codproducto FROM productos WHERE codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codproducto"],$_POST["codsucursal"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $producto);
		$stmt->bindParam(3, $codmarca);
		$stmt->bindParam(4, $codpresentacion);
		$stmt->bindParam(5, $codmedida);
		$stmt->bindParam(6, $lote);
		$stmt->bindParam(7, $preciocompra);
		$stmt->bindParam(8, $precioventa);
		$stmt->bindParam(9, $existencia);
		$stmt->bindParam(10, $stockminimo);
		$stmt->bindParam(11, $stockmaximo);
		$stmt->bindParam(12, $ivaproducto);
		$stmt->bindParam(13, $descproducto);
		$stmt->bindParam(14, $fechaelaboracion);
		$stmt->bindParam(15, $fechaexpiracion);
		$stmt->bindParam(16, $codproveedor);
		$stmt->bindParam(17, $stockteorico);
		$stmt->bindParam(18, $motivoajuste);
		$stmt->bindParam(19, $codsucursal);

		$codproducto = limpiar($_POST["codproducto"]);
		$producto = limpiar($_POST["producto"]);
		$codmarca = limpiar($_POST['codmarca'] == '' ? "0" : $_POST['codmarca']);
		$codpresentacion = limpiar($_POST['codpresentacion'] == '' ? "0" : $_POST['codpresentacion']);
		$codmedida = limpiar($_POST['codmedida'] == '' ? "0" : $_POST['codmedida']);
		$lote = limpiar($_POST['lote'] == '' ? "0" : $_POST['lote']);
		$preciocompra = limpiar($_POST["preciocompra"]);
		$precioventa = limpiar($_POST["precioventa"]);
		$existencia = limpiar($_POST["existencia"]);
		$stockminimo = limpiar($_POST['stockminimo'] == '' ? "0" : $_POST['stockminimo']);
		$stockmaximo = limpiar($_POST['stockmaximo'] == '' ? "0" : $_POST['stockmaximo']);
		$ivaproducto = limpiar($_POST["ivaproducto"]);
		$descproducto = limpiar($_POST["descproducto"]);
		$fechaelaboracion = limpiar($_POST['fechaelaboracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaelaboracion'])));
		$fechaexpiracion = limpiar($_POST['fechaexpiracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaexpiracion'])));
		$codproveedor = limpiar($_POST["codproveedor"]);
		$stockteorico = limpiar("0");
		$motivoajuste = limpiar("NINGUNO");
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();

        #################### REGISTRAMOS PRODUCTOS EN KARDEX #####################
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproceso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);
		$stmt->bindParam(15, $codsucursal);

		$codproceso = limpiar($_POST['codproducto']);
		$codresponsable = limpiar("0");
		$codproducto = limpiar($_POST['codproducto']);
		$movimiento = limpiar("ENTRADAS");
		$entradas = limpiar($_POST['existencia']);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($_POST['existencia']);
		$ivaproducto = limpiar($_POST["ivaproducto"]);
		$descproducto = limpiar($_POST["descproducto"]);
		$precio = limpiar($_POST['precioventa']);
		$documento = limpiar("INVENTARIO INICIAL");
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("2");
		$codsucursal = limpiar($_POST["codsucursal"]);
		$stmt->execute();
        #################### REGISTRAMOS PRODUCTOS EN KARDEX #####################


	##################  SUBIR FOTO DE PRODUCTO ######################################
         //datos del arhivo  
if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; } 
         //compruebo si las características del archivo son las que deseo  
if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
		 {  
if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/productos/".$nombre_archivo) && rename("fotos/productos/".$nombre_archivo,"fotos/productos/".$codproducto.".jpg"))
		 { 
		 ## se puede dar un aviso
		 } 
		 ## se puede dar otro aviso 
		 }
	##################  FINALIZA SUBIR FOTO DE PRODUCTO ######################################

		echo "<span class='fa fa-check-square-o'></span> EL PRODUCTO HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

	} else {

		echo "2";
		exit;
	}
}
########################## FUNCION REGISTRAR PRODUCTOS ###############################

########################## FUNCION BUSQUEDA DE PRODUCTOS ###############################
public function BusquedaProductos()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	WHERE
    (productos.codproducto = '".$buscar."')
    OR 
    (productos.producto = '".$buscar."') 
    OR 
    (marcas.nommarca = '".$buscar."') 
    OR 
    (presentaciones.nompresentacion = '".$buscar."')
    OR 
    (medidas.nommedida = '".$buscar."')
    AND 
    productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."'LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE PRODUCTOS ###############################

########################### FUNCION LISTAR PRODUCTOS ################################
public function ListarProductos()
	{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	departamentos.departamento,
	provincias.provincia 
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	WHERE productos.codsucursal = ? ORDER BY productos.producto ASC";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
	    exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

	} else { 

    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."' ORDER BY productos.producto ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
	}
}
########################## FUNCION LISTAR PRODUCTOS ################################

########################### FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ################################
public function ListarProductosMinimo()
	{
	self::SetNames();
	
    if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	departamentos.departamento,
	provincias.provincia 
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	WHERE productos.codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND productos.existencia <= productos.stockminimo ORDER BY productos.producto ASC";
    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else { 

    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND productos.existencia <= productos.stockminimo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
  }
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ################################

########################### FUNCION LISTAR PRODUCTOS EN STOCK MAXIMO ################################
public function ListarProductosMaximo()
	{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	departamentos.departamento,
	provincias.provincia 
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	WHERE productos.codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND productos.existencia >= productos.stockmaximo ORDER BY productos.producto ASC";
    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else { 

    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND productos.existencia >= productos.stockmaximo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
  }
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MAXIMO ################################

############################# FUNCION LISTAR PRODUCTOS EN VENTANA MODAL ################################
public function ListarProductosModal()
	{
	self::SetNames();
	$sql = "SELECT * FROM productos 
    LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
    WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR PRODUCTOS EN VENTANA MODAL ################################

############################ FUNCION ID PRODUCTOS #################################
public function ProductosPorId()
{
	self::SetNames();
	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	WHERE productos.codproducto = ? AND productos.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codproducto"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PRODUCTOS #################################

############################ FUNCION ACTUALIZAR PRODUCTOS ############################
public function ActualizarProductos()
	{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codmarca"]) or empty($_POST["codpresentacion"]) or empty($_POST["preciocompra"]) or empty($_POST["precioventa"]))
	{
		echo "1";
		exit;
	}
	$sql = "SELECT codproducto FROM productos WHERE idproducto != ? AND codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["idproducto"],$_POST["codproducto"],$_POST["codsucursal"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "UPDATE productos set"
		." producto = ?, "
		." codmarca = ?, "
		." codpresentacion = ?, "
		." codmedida = ?, "
		." lote = ?, "
		." preciocompra = ?, "
		." precioventa = ?, "
		." existencia = ?, "
		." stockminimo = ?, "
		." stockmaximo = ?, "
		." ivaproducto = ?, "
		." descproducto = ?, "
		." fechaelaboracion = ?, "
		." fechaexpiracion = ?, "
		." codproveedor = ? "
		." where "
		." idproducto = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $producto);
		$stmt->bindParam(2, $codmarca);
		$stmt->bindParam(3, $codpresentacion);
		$stmt->bindParam(4, $codmedida);
		$stmt->bindParam(5, $lote);
		$stmt->bindParam(6, $preciocompra);
		$stmt->bindParam(7, $precioventa);
		$stmt->bindParam(8, $existencia);
		$stmt->bindParam(9, $stockminimo);
		$stmt->bindParam(10, $stockmaximo);
		$stmt->bindParam(11, $ivaproducto);
		$stmt->bindParam(12, $descproducto);
		$stmt->bindParam(13, $fechaelaboracion);
		$stmt->bindParam(14, $fechaexpiracion);
		$stmt->bindParam(15, $codproveedor);
		$stmt->bindParam(16, $idproducto);

		$codproducto = limpiar($_POST["codproducto"]);
		$producto = limpiar($_POST["producto"]);
		$codmarca = limpiar($_POST['codmarca'] == '' ? "0" : $_POST['codmarca']);
		$codpresentacion = limpiar($_POST['codpresentacion'] == '' ? "0" : $_POST['codpresentacion']);
		$codmedida = limpiar($_POST['codmedida'] == '' ? "0" : $_POST['codmedida']);
		$lote = limpiar($_POST['lote'] == '' ? "0" : $_POST['lote']);
		$preciocompra = limpiar($_POST["preciocompra"]);
		$precioventa = limpiar($_POST["precioventa"]);
		$existencia = limpiar($_POST["existencia"]);
		$stockminimo = limpiar($_POST['stockminimo'] == '' ? "0" : $_POST['stockminimo']);
		$stockmaximo = limpiar($_POST['stockmaximo'] == '' ? "0" : $_POST['stockmaximo']);
		$ivaproducto = limpiar($_POST["ivaproducto"]);
		$descproducto = limpiar($_POST["descproducto"]);
		$fechaelaboracion = limpiar($_POST['fechaelaboracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaelaboracion'])));
		$fechaexpiracion = limpiar($_POST['fechaexpiracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaexpiracion'])));
		$codproveedor = limpiar($_POST["codproveedor"]);
		$idproducto = limpiar($_POST["idproducto"]);
		$stmt->execute();


	################## SUBIR FOTO DE PRODUCTO ######################################
         //datos del arhivo  
if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; } 
         //compruebo si las características del archivo son las que deseo  
if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
		 {  
if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/productos/".$nombre_archivo) && rename("fotos/productos/".$nombre_archivo,"fotos/productos/".$codproducto.".jpg"))
		 { 
		 ## se puede dar un aviso
		 } 
		 ## se puede dar otro aviso 
		 }
	################## FINALIZA SUBIR FOTO DE PRODUCTO ##########################
        
		echo "<span class='fa fa-check-square-o'></span> EL PRODUCTO HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

	} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR PRODUCTOS ############################

########################## FUNCION ELIMINAR PRODUCTOS ###########################
public function EliminarProductos()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codproducto FROM detalle_ventas WHERE codproducto = ? AND codsucursal = ? AND tipodetalle = 2";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codproducto"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproducto);
		$stmt->bindParam(2,$codsucursal);
		$codproducto = decrypt($_GET["codproducto"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		$sql = "DELETE FROM kardex where codproducto = ? AND codsucursal = ? AND tipokardex = 2";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproducto);
		$stmt->bindParam(2,$codsucursal);
		$codproducto = decrypt($_GET["codproducto"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();

		$codproducto = decrypt($_GET["codproducto"]);
		if (file_exists("fotos/productos/".$codproducto.".jpg")){
	    //funcion para eliminar una carpeta con contenido
		$archivos = "fotos/productos/".$codproducto.".jpg";		
		unlink($archivos);
		}

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
########################## FUNCION ELIMINAR PRODUCTOS #################################

###################### FUNCION BUSCAR PRODUCTOS VENDIDOS #########################
public function BuscarProductosVendidos() 
{
	self::SetNames();
	$sql ="SELECT
	detalle_ventas.idproducto,
	detalle_ventas.codproducto,
	detalle_ventas.producto,
	detalle_ventas.codmarca,
	detalle_ventas.codpresentacion, 
	detalle_ventas.codmedida, 
	detalle_ventas.ivaproducto,
	detalle_ventas.descproducto, 
	detalle_ventas.precioventa, 
	productos.existencia,
	marcas.nommarca, 
	presentaciones.nompresentacion,
	medidas.nommedida,
	ventas.iva, 
	ventas.fechaventa, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio, 
	SUM(detalle_ventas.cantventa) as cantidad 
	FROM (ventas INNER JOIN detalle_ventas ON ventas.codventa = detalle_ventas.codventa) 
	INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN productos ON detalle_ventas.idproducto = productos.idproducto
	LEFT JOIN marcas ON detalle_ventas.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON detalle_ventas.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON detalle_ventas.codmedida = medidas.codmedida
	WHERE ventas.codsucursal = '".decrypt($_GET['codsucursal'])."' 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND detalle_ventas.tipodetalle = 2 
	GROUP BY detalle_ventas.codproducto, detalle_ventas.precioventa, detalle_ventas.descproducto 
	ORDER BY detalle_ventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION PRODUCTOS VENDIDOS ###############################

###################### FUNCION BUSCAR PRODUCTOS VENDIDOS POR VENDEDOR #########################
public function BuscarProductosxVendedor() 
{
	self::SetNames();
	$sql ="SELECT
	detalle_ventas.idproducto,
	detalle_ventas.codproducto,
	detalle_ventas.producto,
	detalle_ventas.codmarca,
	detalle_ventas.codpresentacion, 
	detalle_ventas.codmedida, 
	detalle_ventas.ivaproducto,
	detalle_ventas.descproducto, 
	detalle_ventas.precioventa, 
	productos.existencia,
	marcas.nommarca, 
	presentaciones.nompresentacion,
	medidas.nommedida,
	ventas.iva, 
	ventas.fechaventa, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	usuarios.dni,
	usuarios.nombres, 
	SUM(detalle_ventas.cantventa) as cantidad 
	FROM (ventas INNER JOIN detalle_ventas ON ventas.codventa = detalle_ventas.codventa) 
	INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda   
	INNER JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN productos ON detalle_ventas.idproducto = productos.idproducto
	LEFT JOIN marcas ON detalle_ventas.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON detalle_ventas.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON detalle_ventas.codmedida = medidas.codmedida
	WHERE ventas.codsucursal = '".decrypt($_GET['codsucursal'])."'
	AND ventas.codigo = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND detalle_ventas.tipodetalle = 2 
	GROUP BY detalle_ventas.codproducto, detalle_ventas.precioventa, detalle_ventas.descproducto 
	ORDER BY detalle_ventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION PRODUCTOS VENDIDOS POR VENDEDOR ###############################

######################## FUNCION DETALLE PRODUCTO KARDEX #########################
public function DetalleKardexProducto()
{
	self::SetNames();
	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	departamentos.departamento,
	provincias.provincia 
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	WHERE productos.codproducto = ? AND productos.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codproducto"],decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION DETALLE PRODUCTO KARDEX #########################

######################## FUNCION BUSCA KARDEX PRODUCTOS ##########################
public function BuscarKardexProducto() 
{
	self::SetNames();
	$sql ="SELECT * FROM kardex WHERE codproducto = ? AND codsucursal = ? AND tipokardex = 2";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codproducto"], decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION BUSCA KARDEX PRODUCTOS #########################

########################### FUNCION LISTAR KARDEX PRODUCTOS VALORIZADO ################################
public function ListarKardexProductosValorizado()
	{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	departamentos.departamento,
	provincias.provincia 
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	WHERE productos.codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

 	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	productos.lote,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio
	FROM (productos INNER JOIN sucursales ON productos.codsucursal = sucursales.codsucursal)
	LEFT JOIN marcas ON productos.codmarca = marcas.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida  
	LEFT JOIN proveedores ON productos.codproveedor = proveedores.codproveedor
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	WHERE productos.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
########################## FUNCION LISTAR KARDEX PRODUCTOS VALORIZADO ################################

###################### FUNCION KARDEX PRODUCTOS POR FECHAS Y VENDEDOR #########################
public function BuscarKardexProductosValorizadoxFechas() 
{
	self::SetNames();
	$sql ="SELECT
	detalle_ventas.idproducto,
	detalle_ventas.codproducto,
	detalle_ventas.producto,
	detalle_ventas.codmarca,
	detalle_ventas.codpresentacion, 
	detalle_ventas.codmedida, 
	detalle_ventas.ivaproducto,
	detalle_ventas.descproducto, 
	detalle_ventas.preciocompra, 
	detalle_ventas.precioventa,
	productos.existencia,
	marcas.nommarca, 
	presentaciones.nompresentacion, 
	medidas.nommedida,
	ventas.iva,
	ventas.fechaventa, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	departamentos.departamento,
	provincias.provincia, 
	usuarios.dni,
	usuarios.nombres, 
	SUM(detalle_ventas.cantventa) as cantidad 
	FROM (ventas INNER JOIN detalle_ventas ON ventas.codventa = detalle_ventas.codventa) 
	INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN productos ON detalle_ventas.idproducto = productos.idproducto 
	LEFT JOIN marcas ON marcas.codmarca = productos.codmarca 
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida 
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codsucursal = '".decrypt($_GET['codsucursal'])."' 
	AND ventas.codigo = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND detalle_ventas.tipodetalle = 2  
	GROUP BY detalle_ventas.codproducto, detalle_ventas.precioventa, detalle_ventas.descproducto 
	ORDER BY detalle_ventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION KARDEX PRODUCTOS POR FECHAS Y VENDEDOR ###############################

############################### FIN DE CLASE PRODUCTOS ###############################






























###################################### CLASE TRASPASOS ##################################

######################### FUNCION REGISTRAR TRASPASOS #######################
public function RegistrarTraspasos()
{
	self::SetNames();
	if(empty($_POST["recibe"]) or empty($_POST["codsucursal"]) or empty($_POST["fechatraspaso"]))
	{
		echo "1";
		exit;
	}
	elseif(empty($_SESSION["CarritoTraspaso"]) || $_POST["txtTotal"]=="0.00")
	{
		echo "2";
		exit;
		
	}


    ############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$v = $_SESSION["CarritoTraspaso"];
	for($i=0;$i<count($v);$i++){

		$sql = "SELECT existencia
		FROM productos 
		WHERE codproducto = '".$v[$i]['txtCodigo']."'
		AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		
		$existenciadb = $row['existencia'];
		$cantidad = $v[$i]['cantidad'];

        if ($cantidad > $existenciadb) 
        { 
		    echo "3";
		    exit;
	    }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

	$fecha = date("Y-m-d H:i:s");

	####################################################################################
	#                                                                                  #
	#                               CREO CODIGO DE TRASPASO                            #
	#                                                                                  #
	####################################################################################
	
	####################### OBTENGO DATOS DE TRASPASO #######################
	$sql = "SELECT
	codtraspaso 
	FROM traspasos 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'  
	ORDER BY idtraspaso DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$traspaso=$row["codtraspaso"];
	}
	####################### OBTENGO DATOS DE TRASPASO #######################
	
	####################### CREO CODIGO DE TRASPASO #######################
	if(empty($traspaso))
	{
		$codtraspaso = "1";

	} else {

		$codtraspaso = $traspaso + 1;
	}
	####################### CREO CODIGO DE TRASPASO #######################

    ####################################################################################
	#                                                                                  #
	#                               CREO CODIGO DE TRASPASO                            #
	#                                                                                  #
	####################################################################################

    ################################### REGISTRO LA COTIZACION ###################################
    $query = "INSERT INTO traspasos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $recibe);
	$stmt->bindParam(3, $subtotalivasi);
	$stmt->bindParam(4, $subtotalivano);
	$stmt->bindParam(5, $iva);
	$stmt->bindParam(6, $totaliva);
	$stmt->bindParam(7, $descontado);
	$stmt->bindParam(8, $descuento);
	$stmt->bindParam(9, $totaldescuento);
	$stmt->bindParam(10, $totalpago);
	$stmt->bindParam(11, $totalpago2);
	$stmt->bindParam(12, $fechatraspaso);
	$stmt->bindParam(13, $observaciones);
	$stmt->bindParam(14, $codigo);
	$stmt->bindParam(15, $codsucursal);
   
	$recibe = limpiar(decrypt($_POST["recibe"]));
	$subtotalivasi = limpiar($_POST["txtgravado"]);
	$subtotalivano = limpiar($_POST["txtexento"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
    $fechatraspaso = limpiar($fecha);
    $observaciones = limpiar(isset($_POST['observaciones']) ? $_POST['observaciones'] : "");
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################################### REGISTRO LA COTIZACION ###################################

    $this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoTraspaso"];
	for($i=0;$i<count($detalle);$i++){

	############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################
	$sql = "SELECT * FROM 
	productos 
	WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciabd = $row['existencia'];
	############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################

	################################### REGISTRO DETALLES DE TRASPASO ###################################
	$query = "INSERT INTO detalle_traspasos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codmarca);
    $stmt->bindParam(6, $codpresentacion);
    $stmt->bindParam(7, $codmedida);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $preciocompra);
	$stmt->bindParam(10, $precioventa);
	$stmt->bindParam(11, $ivaproducto);
	$stmt->bindParam(12, $descproducto);
	$stmt->bindParam(13, $valortotal);
	$stmt->bindParam(14, $totaldescuentov);
	$stmt->bindParam(15, $valorneto);
	$stmt->bindParam(16, $valorneto2);
	$stmt->bindParam(17, $fechaexpiracion);
	$stmt->bindParam(18, $codsucursal);
		
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codmarca = limpiar($detalle[$i]['codmarca']);
	$codpresentacion = limpiar($detalle[$i]['codpresentacion']);
	$codmedida = limpiar($detalle[$i]['codmedida']);
	$cantidad = limpiar($detalle[$i]['cantidad']);
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
	$fechaexpiracion = limpiar($detalle[$i]['fechaexpiracion']);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################################### REGISTRO DETALLES DE TRASPASO ###################################

    ##########################################################################################################
	#                                                                                                        #
	#                                   PROCESO DE PRODUCTOS SALIENTES                                       #
	#                                                                                                        #
	##########################################################################################################

	##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
	$sql = " UPDATE productos set "
		  ." existencia = ? "
		  ." where "
		  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$canttraspaso = limpiar($detalle[$i]['cantidad']);
	$existencia = $existenciabd-$canttraspaso;
	$stmt->execute();
	##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

	############### REGISTRAMOS LOS PRODUCTOS SALIENTES EN KARDEX ###############
    $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $recibe);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);
	$stmt->bindParam(14, $tipokardex);		
	$stmt->bindParam(15, $codsucursal);

	$codresponsable = limpiar(decrypt($_POST["recibe"]));
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$movimiento = limpiar("SALIDAS");
	$entradas = limpiar("0");
	$salidas= limpiar($detalle[$i]['cantidad']);
	$devolucion = limpiar("0");
	$stockactual = limpiar($existenciabd-$detalle[$i]['cantidad']);
	$precio = limpiar($detalle[$i]["precio2"]);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$documento = limpiar("TRASPASO: ".$codtraspaso);
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar("2");
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	############### REGISTRAMOS LOS PRODUCTOS SALIENTES EN KARDEX ###############

	##########################################################################################################
	#                                                                                                        #
	#                                   PROCESO DE PRODUCTOS SALIENTES                                       #
	#                                                                                                        #
	##########################################################################################################


	##########################################################################################################
	#                                                                                                        #
	#                                   PROCESO DE PRODUCTOS ENTRANTES                                       #
	#                                                                                                        #
	##########################################################################################################

	############ VERIFICO SI EL PRODUCTO YA EXISTE EN LA SUCURSAL QUE RECIBE ###########
	$sql = "SELECT 
	codproducto 
	FROM productos 
	WHERE codproducto = ?
	AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($detalle[$i]['txtCodigo']),limpiar(decrypt($_POST['recibe']))));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		############################## REGISTRO DATOS DE PRODUCTOS ##############################
		$query = "INSERT INTO productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $producto);
		$stmt->bindParam(3, $codmarca);
		$stmt->bindParam(4, $codpresentacion);
		$stmt->bindParam(5, $codmedida);
		$stmt->bindParam(6, $lote);
		$stmt->bindParam(7, $preciocompra);
		$stmt->bindParam(8, $precioventa);
		$stmt->bindParam(9, $existencia);
		$stmt->bindParam(10, $stockminimo);
		$stmt->bindParam(11, $stockmaximo);
		$stmt->bindParam(12, $ivaproducto);
		$stmt->bindParam(13, $descproducto);
		$stmt->bindParam(14, $fechaelaboracion);
		$stmt->bindParam(15, $fechaexpiracion);
		$stmt->bindParam(16, $codproveedor);
		$stmt->bindParam(17, $stockteorico);
		$stmt->bindParam(18, $motivoajuste);
		$stmt->bindParam(19, $recibe);

		$codproducto = limpiar($detalle[$i]["txtCodigo"]);
		$producto = limpiar($detalle[$i]["producto"]);
		$codmarca = limpiar($detalle[$i]["codmarca"]);
		$codpresentacion = limpiar($detalle[$i]["codpresentacion"]);
		$codmedida = limpiar($detalle[$i]["codmedida"]);
		$lote = limpiar($row["lote"]);
		$preciocompra = limpiar($detalle[$i]["precio"]);
		$precioventa = limpiar($detalle[$i]["precio2"]);
		$existencia = limpiar($detalle[$i]["cantidad"]);
		$stockminimo = limpiar($row["stockminimo"]);
		$stockmaximo = limpiar($row["stockmaximo"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$fechaelaboracion = limpiar($row['fechaelaboracion']);
		$fechaexpiracion = limpiar($detalle[$i]['fechaexpiracion']);
		$codproveedor = limpiar($row["codproveedor"]);
		$stockteorico = limpiar("0");
		$motivoajuste = limpiar("NINGUNO");
		$recibe = limpiar(decrypt($_POST['recibe']));
		$stmt->execute();
		############################## REGISTRO DATOS DE PRODUCTOS ##############################

		############### REGISTRAMOS LOS PRODUCTOS ENTRANTES EN KARDEX ###############
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codtraspaso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $recibe);

		$codresponsable = limpiar(decrypt($_POST["codsucursal"]));
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("ENTRADAS");
		$entradas = limpiar($detalle[$i]['cantidad']);
		$salidas= limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($detalle[$i]['cantidad']);
		$precio = limpiar($detalle[$i]["precio2"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("TRASPASO: ".$codtraspaso);
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("2");
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();
	    ############## REGISTRAMOS LOS PRODUCTOS ENTRANTES EN KARDEX ###############

	} else {

		############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################
		$sql = "SELECT 
		existencia 
		FROM 
		productos 
		WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
		AND codsucursal = '".limpiar(decrypt($_POST["recibe"]))."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciarecibebd = $row['existencia'];
	    ############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################

	    ############################## ACTUALIZAMOS DATOS DE PRODUCTOS ##############################
		$sql = "UPDATE productos set "
		      ." preciocompra = ?, "
			  ." precioventa = ?, "
			  ." existencia = ?, "
			  ." ivaproducto = ?, "
			  ." descproducto = ?, "
			  ." fechaexpiracion = ? "
			  ." WHERE "
			  ." codproducto = ? AND codsucursal = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $preciocompra);
		$stmt->bindParam(2, $precioventa);
		$stmt->bindParam(3, $existencia);
		$stmt->bindParam(4, $ivaproducto);
		$stmt->bindParam(5, $descproducto);
		$stmt->bindParam(6, $fechaexpiracion);
		$stmt->bindParam(7, $codproducto);
		$stmt->bindParam(8, $recibe);
		
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioventa = limpiar($detalle[$i]['precio2']);
		$existencia = limpiar($existenciarecibebd+$detalle[$i]['cantidad']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$fechaexpiracion = limpiar($detalle[$i]['fechaexpiracion']);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();
		############################## ACTUALIZAMOS DATOS DE PRODUCTOS ##############################

		############### REGISTRAMOS LOS PRODUCTOS ENTRANTES EN KARDEX ###############
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codtraspaso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $recibe);

		$codresponsable = limpiar(decrypt($_POST["codsucursal"]));
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("ENTRADAS");
		$entradas = limpiar($detalle[$i]['cantidad']);
		$salidas= limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($existenciarecibebd+$detalle[$i]['cantidad']);
		$precio = limpiar($detalle[$i]["precio2"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("TRASPASO: ".$codtraspaso);
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("2");
		$recibe = limpiar(decrypt($_POST["recibe"]));
		$stmt->execute();
	    ############## REGISTRAMOS LOS PRODUCTOS ENTRANTES EN KARDEX ###############

	}//FIN DE REGISTRO DE PRODUCTOS

	##########################################################################################################
	#                                                                                                        #
	#                                   PROCESO DE PRODUCTOS ENTRANTES                                       #
	#                                                                                                        #
	##########################################################################################################

    }

	####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoTraspaso"]);
    $this->dbh->commit();
    ################################### REGISTRO DETALLES DE FACTURA ###################################

	echo "<span class='fa fa-check-square-o'></span> EL TRASPASO DE PRODUCTOS HA SIDO REGISTRADO EXITOSAMENTE <a href='reportepdf?codtraspaso=".encrypt($codtraspaso)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURATRASPASO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR DOCUMENTO</strong></font color></a>";

	echo "<script>window.open('reportepdf?codtraspaso=".encrypt($codtraspaso)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURATRASPASO")."', '_blank');</script>";
	exit;
}
######################### FUNCION REGISTRAR TRASPASOS #########################

############################## FUNCION LISTAR TRASPASOS ################################
public function ListarTraspasos()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	traspasos.idtraspaso, 
	traspasos.codtraspaso, 
	traspasos.recibe, 
	traspasos.subtotalivasi, 
	traspasos.subtotalivano, 
	traspasos.iva, 
	traspasos.totaliva,
	traspasos.descontado, 
	traspasos.descuento, 
	traspasos.totaldescuento,
	traspasos.totalpago, 
	traspasos.totalpago2, 
	traspasos.fechatraspaso, 
	traspasos.observaciones, 
	traspasos.codigo,
	traspasos.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	documentos.documento,
	documentos2.documento AS documento2,
	sucursales2.documsucursal AS documsucursal2,
	sucursales2.cuitsucursal AS cuitsucursal2,
	sucursales2.nomsucursal AS nomsucursal2,
	sucursales2.documencargado AS documencargado2,
	sucursales2.dniencargado AS dniencargado2,
	sucursales2.nomencargado AS nomencargado2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	SUM(detalle_traspasos.cantidad) AS sumarticulos 
	FROM (traspasos LEFT JOIN detalle_traspasos ON detalle_traspasos.codtraspaso = traspasos.codtraspaso)
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN sucursales AS sucursales2 ON traspasos.recibe = sucursales2.codsucursal
	LEFT JOIN documentos AS documentos3 ON sucursales.documsucursal = documentos3.coddocumento
	LEFT JOIN documentos AS documentos4 ON sucursales.documencargado = documentos4.coddocumento
	GROUP BY traspasos.codtraspaso, traspasos.codsucursal 
	ORDER BY traspasos.idtraspaso ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else {

   $sql = "SELECT 
	traspasos.idtraspaso, 
	traspasos.codtraspaso, 
	traspasos.recibe, 
	traspasos.subtotalivasi, 
	traspasos.subtotalivano, 
	traspasos.iva, 
	traspasos.totaliva,
	traspasos.descontado, 
	traspasos.descuento, 
	traspasos.totaldescuento,
	traspasos.totalpago, 
	traspasos.totalpago2, 
	traspasos.fechatraspaso, 
	traspasos.observaciones, 
	traspasos.codigo,
	traspasos.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	documentos.documento,
	documentos2.documento AS documento2,
	sucursales2.documsucursal AS documsucursal2,
	sucursales2.cuitsucursal AS cuitsucursal2,
	sucursales2.nomsucursal AS nomsucursal2,
	sucursales2.documencargado AS documencargado2,
	sucursales2.dniencargado AS dniencargado2,
	sucursales2.nomencargado AS nomencargado2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	SUM(detalle_traspasos.cantidad) AS sumarticulos 
	FROM (traspasos LEFT JOIN detalle_traspasos ON detalle_traspasos.codtraspaso = traspasos.codtraspaso)
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN sucursales AS sucursales2 ON traspasos.recibe = sucursales2.codsucursal
	LEFT JOIN documentos AS documentos3 ON sucursales.documsucursal = documentos3.coddocumento
	LEFT JOIN documentos AS documentos4 ON sucursales.documencargado = documentos4.coddocumento
	WHERE traspasos.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	OR traspasos.recibe = '".limpiar($_SESSION["codsucursal"])."' 
	GROUP BY traspasos.codtraspaso, traspasos.codsucursal 
	ORDER BY traspasos.idtraspaso ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     }
}
############################ FUNCION LISTAR TRASPASOS ############################

############################ FUNCION ID TRASPASOS #################################
public function TraspasosPorId()
	{
	self::SetNames();
	$sql = "SELECT 
	traspasos.idtraspaso, 
	traspasos.codtraspaso, 
	traspasos.recibe, 
	traspasos.subtotalivasi, 
	traspasos.subtotalivano, 
	traspasos.iva, 
	traspasos.totaliva,
	traspasos.descontado, 
	traspasos.descuento, 
	traspasos.totaldescuento,
	traspasos.totalpago, 
	traspasos.totalpago2, 
	traspasos.fechatraspaso, 
	traspasos.observaciones, 
	traspasos.codigo,
	traspasos.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	provincias.provincia,
	departamentos.departamento,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	documentos.documento,
	documentos2.documento AS documento2,
	sucursales2.documsucursal AS documsucursal2,
	sucursales2.cuitsucursal AS cuitsucursal2,
	sucursales2.nomsucursal AS nomsucursal2,
	sucursales2.id_provincia AS id_provincia2,
	sucursales2.id_departamento AS id_departamento2,
	sucursales2.direcsucursal AS direcsucursal2,
	sucursales2.correosucursal AS correosucursal2,
	sucursales2.tlfsucursal AS tlfsucursal2,
	sucursales2.documencargado AS documencargado2,
	sucursales2.dniencargado AS dniencargado2,
	sucursales2.nomencargado AS nomencargado2,
	sucursales2.tlfencargado AS tlfencargado2,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	SUM(detalle_traspasos.cantidad) AS sumarticulos 
	FROM (traspasos LEFT JOIN detalle_traspasos ON detalle_traspasos.codtraspaso = traspasos.codtraspaso)
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN sucursales AS sucursales2 ON traspasos.recibe = sucursales2.codsucursal
	LEFT JOIN documentos AS documentos3 ON sucursales.documsucursal = documentos3.coddocumento
	LEFT JOIN documentos AS documentos4 ON sucursales.documencargado = documentos4.coddocumento
	LEFT JOIN provincias AS provincias2 ON sucursales.id_provincia = provincias2.id_provincia
	LEFT JOIN departamentos AS departamentos2 ON sucursales.id_departamento = departamentos2.id_departamento 
	WHERE traspasos.codtraspaso = ? AND traspasos.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codtraspaso"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID TRASPASOS #################################

########################### FUNCION VER DETALLES TRASPASOS ##########################
public function VerDetallesTraspasos()
	{
	self::SetNames();
	$sql = "SELECT
	detalle_traspasos.coddetalletraspaso,
	detalle_traspasos.codtraspaso,
	detalle_traspasos.idproducto,
	detalle_traspasos.codproducto,
	detalle_traspasos.producto,
	detalle_traspasos.cantidad,
	detalle_traspasos.preciocompra,
	detalle_traspasos.precioventa,
	detalle_traspasos.ivaproducto,
	detalle_traspasos.descproducto,
	detalle_traspasos.valortotal, 
	detalle_traspasos.totaldescuentov,
	detalle_traspasos.valorneto,
	detalle_traspasos.valorneto2,
	detalle_traspasos.fechaexpiracion,
	detalle_traspasos.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida
	FROM detalle_traspasos LEFT JOIN marcas ON detalle_traspasos.codmarca = marcas.codmarca
	LEFT JOIN presentaciones ON detalle_traspasos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON detalle_traspasos.codmedida = medidas.codmedida
	WHERE detalle_traspasos.codtraspaso = ? AND detalle_traspasos.codsucursal = ? ORDER BY detalle_traspasos.coddetalletraspaso ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codtraspaso"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
		return $this->p;
		$this->dbh=null;
}
############################ FUNCION VER DETALLES TRASPASOS #######################

############################ FUNCION ACTUALIZAR TRASPASOS ##########################
public function ActualizarTraspasos()
	{
	self::SetNames();
	if(empty($_POST["codtraspaso"]) or empty($_POST["recibe"]) or empty($_POST["codsucursal"]) or empty($_POST["fechatraspaso"]))
	{
		echo "1";
		exit;
	}

	############ VERIFICO QUE CANTIDAD NO SEA IGUAL A CERO #############
	for($i=0;$i<count($_POST['coddetalletraspaso']);$i++){  //recorro el array
        if (!empty($_POST['coddetalletraspaso'][$i])) {

	       if($_POST['cantidad'][$i]==0){

		      echo "2";
		      exit();
	       }
        }
    }
    ############ VERIFICO QUE CANTIDAD NO SEA IGUAL A CERO #############

	$this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['coddetalletraspaso']);$i++){  //recorro el array
	if (!empty($_POST['coddetalletraspaso'][$i])) {

	############### OBTENGO DETALLES DE TRASPASOS ##################
	$sql = "SELECT 
	cantidad 
	FROM detalle_traspasos 
	WHERE coddetalletraspaso = '".limpiar(decrypt($_POST['coddetalletraspaso'][$i]))."' 
	AND codtraspaso = '".limpiar(decrypt($_POST["codtraspaso"]))."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
	$cantidadbd = $row['cantidad'];
	############### OBTENGO DETALLES DE TRASPASOS ##################

	if($cantidadbd != $_POST['cantidad'][$i]){

	############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################
    $sql = "SELECT 
    existencia 
    FROM productos 
    WHERE codproducto = '".limpiar(decrypt($_POST['codproducto'][$i]))."' 
    AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	    {
		    $this->p[] = $row;
	    }
	$existenciabd = $row['existencia'];
	$cantidad = $_POST["cantidad"][$i];
	$cantidadbd = $_POST["cantidadbd"][$i];
	$totaltraspaso = $cantidad-$cantidadbd;
	############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################

    if ($totaltraspaso > $existenciabd) 
    { 
	    echo "3";
	    exit;
    }

	##################### ACTUALIZO DETALLES DE TRASPASOS ####################
	$query = "UPDATE detalle_traspasos set"
	." cantidad = ?, "
	." valortotal = ?, "
	." totaldescuentov = ?, "
	." valorneto = ?, "
	." valorneto2 = ? "
	." WHERE "
	." coddetalletraspaso = ? AND codtraspaso = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $cantidad);
	$stmt->bindParam(2, $valortotal);
	$stmt->bindParam(3, $totaldescuentov);
	$stmt->bindParam(4, $valorneto);
	$stmt->bindParam(5, $valorneto2);
	$stmt->bindParam(6, $coddetalletraspaso);
	$stmt->bindParam(7, $codtraspaso);
	$stmt->bindParam(8, $codsucursal);

	$cantidad = limpiar($_POST['cantidad'][$i]);
	$preciocompra = limpiar($_POST['preciocompra'][$i]);
	$precioventa = limpiar($_POST['precioventa'][$i]);
	$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
	$descuento = $_POST['descproducto'][$i]/100;
	$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
	$totaldescuento = number_format($_POST['totaldescuentov'][$i], 2, '.', '');
	$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
	$valorneto2 = number_format($_POST['valorneto2'][$i], 2, '.', '');
	$coddetalletraspaso = limpiar(decrypt($_POST['coddetalletraspaso'][$i]));
	$codtraspaso = limpiar(decrypt($_POST["codtraspaso"]));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	##################### ACTUALIZO DETALLES DE TRASPASOS ####################

	############## ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN #1 ##############
	$sql2 = " UPDATE productos set "
	." existencia = ? "
	." WHERE "
	." codproducto = '".limpiar(decrypt($_POST["codproducto"][$i]))."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
	";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->bindParam(1, $existencia);
	$existencia = $existenciabd-$totaltraspaso;
	$stmt->execute();
	############## ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN #1 ##############

	############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #1 ###############
	$sql3 = " UPDATE kardex set "
    ." salidas = ?, "
    ." stockactual = ? "
    ." WHERE "
    ." codproceso = '".limpiar(decrypt($_POST["codtraspaso"]))."' and codproducto = '".limpiar(decrypt($_POST["codproducto"][$i]))."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
    ";
	$stmt = $this->dbh->prepare($sql3);
	$stmt->bindParam(1, $salidas);
	$stmt->bindParam(2, $existencia);
	
	$salidas = limpiar($_POST["cantidad"][$i]);
	$stmt->execute();
	############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #1 ###############

	############ CONSULTO LA EXISTENCIA DE PRODUCTO EN ALMACEN ENTRANDO ############
	$sql = "SELECT 
	existencia 
	FROM productos 
	WHERE codproducto = '".limpiar(decrypt($_POST['codproducto'][$i]))."' 
	AND codsucursal = '".limpiar(decrypt($_POST["recibe"]))."'";
	    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciarecibebd = $row['existencia'];
	############ CONSULTO LA EXISTENCIA DE PRODUCTO EN ALMACEN ENTRANDO ############

	############## ACTUALIZAMOS EXISTENCIA DE PRODUCTO EN ALMACEN #2 ##############
	$sql2 = " UPDATE productos set "
	." existencia = ? "
	." WHERE "
	." codproducto = '".limpiar(decrypt($_POST["codproducto"][$i]))."' AND codsucursal = '".limpiar(decrypt($_POST["recibe"]))."';
	";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->bindParam(1, $existenciarecibe);
	$existenciarecibe = $existenciarecibebd+$totaltraspaso;
	$stmt->execute();
	############## ACTUALIZAMOS EXISTENCIA DE PRODUCTO EN ALMACEN #2 ##############

    ############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #2 ###############
	$sql3 = " UPDATE kardex set "
	." entradas = ?, "
	." stockactual = ? "
	." WHERE "
	." codproceso = '".limpiar(decrypt($_POST["codtraspaso"]))."' AND codproducto = '".limpiar(decrypt($_POST["codproducto"][$i]))."' AND codsucursal = '".limpiar(decrypt($_POST["recibe"]))."';
		   ";
	$stmt = $this->dbh->prepare($sql3);
	$stmt->bindParam(1, $entradas);
	$stmt->bindParam(2, $existenciarecibe);
	
    $existenciarecibe = $existenciarecibebd+$totaltraspaso;
	$entradas = limpiar($_POST["cantidad"][$i]);
	$stmt->execute();
	############### ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX #2 ###############

		} else {

           echo "";

	       }
        }
    }
    $this->dbh->commit();

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
	$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalle_traspasos WHERE codtraspaso = '".limpiar(decrypt($_POST["codtraspaso"]))."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' AND ivaproducto = 'SI'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
		$this->p[] = $row3;
	}
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
	$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
	$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
	$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalle_traspasos WHERE codtraspaso = '".limpiar(decrypt($_POST["codtraspaso"]))."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' AND ivaproducto = 'NO'";
	foreach ($this->dbh->query($sql4) as $row4)
	{
		$this->p[] = $row4;
	}
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
	$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
	$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

    ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
	$sql = " UPDATE traspasos SET "
	." subtotalivasi = ?, "
	." subtotalivano = ?, "
	." totaliva = ?, "
	." descontado = ?, "
	." descuento = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." totalpago2= ? "
	." WHERE "
	." codtraspaso = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $subtotalivasi);
	$stmt->bindParam(2, $subtotalivano);
	$stmt->bindParam(3, $totaliva);
	$stmt->bindParam(4, $descontado);
	$stmt->bindParam(5, $descuento);
	$stmt->bindParam(6, $totaldescuento);
	$stmt->bindParam(7, $totalpago);
	$stmt->bindParam(8, $totalpago2);
	$stmt->bindParam(9, $codtraspaso);
	$stmt->bindParam(10, $codsucursal);

	$iva = $_POST["iva"]/100;
	$totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	$descuento = limpiar($_POST["descuento"]);
    $txtDescuento = $_POST["descuento"]/100;
    $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
    $totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
    $totalpago = number_format($total-$totaldescuento, 2, '.', '');
	$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
	$codtraspaso = limpiar(decrypt($_POST["codtraspaso"]));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> EL TRASPASO DE PRODUCTOS HA SIDO ACTUALIZADO EXITOSAMENTE <a href='reportepdf?codtraspaso=".encrypt($codtraspaso)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURATRASPASO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR DOCUMENTO</strong></font color></a></div>";

	echo "<script>window.open('reportepdf?codtraspaso=".encrypt($codtraspaso)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURATRASPASO")."', '_blank');</script>";
	exit;
}
######################### FUNCION ACTUALIZAR TRASPASOS ############################

########################## FUNCION ELIMINAR DETALLES TRASPASOS ##########################
public function EliminarDetallesTraspasos()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

    ############ CONSULTO DATOS DE TRASPASO ##############
	$sql = "SELECT * FROM traspasos 
	WHERE codtraspaso = '".limpiar(decrypt($_GET["codtraspaso"]))."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$recibebd = $row['recibe'];
	$totalpagobd = $row['totalpago'];
	############ CONSULTO DATOS DE TRASPASO ##############

	$sql = "SELECT * FROM detalle_traspasos WHERE codtraspaso = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codtraspaso"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

	############ OBTENGO DETALLES DE TRASPASO ##############
	$sql = "SELECT 
	codproducto, 
	cantidad, 
	precioventa, 
	ivaproducto, 
	descproducto 
	FROM detalle_traspasos 
	WHERE coddetalletraspaso = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["coddetalletraspaso"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
	$codproducto = $row['codproducto'];
	$cantidadbd = $row['cantidad'];
	$precioventabd = $row['precioventa'];
	$ivaproductobd = $row['ivaproducto'];
	$descproductobd = $row['descproducto'];
	############ OBTENGO DETALLES DE TRASPASO ##############

    ######################### DATOS DE SUCURSAL QUE ENVIA TRASPASO #######################			
	
	############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
	$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->execute(array($codproducto,decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
	$existenciabd = $row['existencia'];
	############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

	############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
	$sql = "UPDATE productos SET "
	." existencia = ? "
	." WHERE "
	." codproducto = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$stmt->bindParam(2, $codproducto);
	$stmt->bindParam(3, $codsucursal);

	$existencia = limpiar($existenciabd+$cantidadbd);
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$stmt->execute();
	############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
	$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $recibe);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);	
	$stmt->bindParam(14, $tipodetalle);		
	$stmt->bindParam(15, $codsucursal);

	$codtraspaso = limpiar(decrypt($_GET["codtraspaso"]));
	$recibe = limpiar(decrypt($_GET["recibe"]));
	$movimiento = limpiar("DEVOLUCION");
	$entradas= limpiar("0");
	$salidas = limpiar("0");
	$devolucion = limpiar($cantidadbd);
	$stockactual = limpiar($existenciabd+$cantidadbd);
	$precio = limpiar($precioventabd);
	$ivaproducto = limpiar($ivaproductobd);
	$descproducto = limpiar($descproductobd);
	$documento = limpiar("DEVOLUCION TRASPASO: ".decrypt($_GET["codtraspaso"]));
	$fechakardex = limpiar(date("Y-m-d"));
	$tipodetalle = limpiar("2");
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$stmt->execute();

	######################### DATOS DE SUCURSAL QUE ENVIA TRASPASO #######################			


    ######################### DATOS DE SUCURSAL QUE RECIBE TRASPASO #######################	

	############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
	$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->execute(array($codproducto,$recibebd));
	$num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
	$existenciarecibebd = $row['existencia'];
	############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

	############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
	$sql = "UPDATE productos SET "
	." existencia = ? "
	." WHERE "
	." codproducto = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$stmt->bindParam(2, $codproducto);
	$stmt->bindParam(3, $recibebd);

	$existencia = limpiar($existenciarecibebd-$cantidadbd);
	$stmt->execute();
	############ ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
	$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codtraspaso);
	$stmt->bindParam(2, $codsucursal);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);
	$stmt->bindParam(14, $tipodetalle);			
	$stmt->bindParam(15, $recibe);

	$codtraspaso = limpiar(decrypt($_GET["codtraspaso"]));			
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$movimiento = limpiar("DEVOLUCION");
	$entradas= limpiar("0");
	$salidas = limpiar("0");
	$devolucion = limpiar($cantidadbd);
	$stockactual = limpiar($existenciarecibebd-$cantidadbd);
	$precio = limpiar($precioventabd);
	$ivaproducto = limpiar($ivaproductobd);
	$descproducto = limpiar($descproductobd);
	$documento = limpiar("DEVOLUCION TRASPASO: ".decrypt($_GET["codtraspaso"]));
	$fechakardex = limpiar(date("Y-m-d"));
	$tipodetalle = limpiar("2");
	$recibe = limpiar($recibebd);
	$stmt->execute();
	########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########

	######################### DATOS DE SUCURSAL QUE RECIBE TRASPASO #######################			

	########## ELIMINO DETALLES DE TRASPASOS ##########
	$sql = "DELETE FROM detalle_traspasos WHERE coddetalletraspaso = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$coddetalletraspaso);
	$stmt->bindParam(2,$codsucursal);
	$coddetalletraspaso = decrypt($_GET["coddetalletraspaso"]);
	$codsucursal = decrypt($_GET["codsucursal"]);
	$stmt->execute();
	########## ELIMINO DETALLES DE TRASPASOS ##########

    ############ CONSULTO LOS TOTALES DE TRASPASO ##############
    $sql2 = "SELECT iva, descuento FROM traspasos WHERE codtraspaso = ? AND codsucursal = ?";
    $stmt = $this->dbh->prepare($sql2);
    $stmt->execute(array(decrypt($_GET["codtraspaso"]),decrypt($_GET["codsucursal"])));
    $num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$paea[] = $row;
	}
	$iva = $paea[0]["iva"]/100;
    $descuento = $paea[0]["descuento"]/100;
    ############ CONSULTO LOS TOTALES DE TRASPASO ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
	$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalle_traspasos WHERE codtraspaso = '".limpiar(decrypt($_GET["codtraspaso"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'SI'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
		$this->p[] = $row3;
	}
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
	$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
	$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
	$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalle_traspasos WHERE codtraspaso = '".limpiar(decrypt($_GET["codtraspaso"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'NO'";
	foreach ($this->dbh->query($sql4) as $row4)
	{
		$this->p[] = $row4;
	}
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
	$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
	$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

    ############ ACTUALIZO LOS TOTALES EN EL TRASPASO ##############
	$sql = " UPDATE traspasos SET "
	." subtotalivasi = ?, "
	." subtotalivano = ?, "
	." totaliva = ?, "
	." descontado = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." totalpago2= ? "
	." WHERE "
	." codtraspaso = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $subtotalivasi);
	$stmt->bindParam(2, $subtotalivano);
	$stmt->bindParam(3, $totaliva);
	$stmt->bindParam(4, $descontado);
	$stmt->bindParam(5, $totaldescuento);
	$stmt->bindParam(6, $totalpago);
	$stmt->bindParam(7, $totalpago2);
	$stmt->bindParam(8, $codtraspaso);
	$stmt->bindParam(9, $codsucursal);

	$totaliva= number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
    $total= number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
    $totaldescuento= number_format($total*$descuento, 2, '.', '');
    $totalpago= number_format($total-$totaldescuento, 2, '.', '');
	$totalpago2 = number_format($subtotalivasi+$subtotalivano, 2, '.', '');
	$codtraspaso = limpiar(decrypt($_GET["codtraspaso"]));
	$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
	$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
######################### FUNCION ELIMINAR DETALLES TRASPASOS #########################

########################## FUNCION ELIMINAR TRASPASOS #############################
public function EliminarTraspasos()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

    ########################## CONSULTO DATOS DE TRASPASO ##########################
	$sql = "SELECT * FROM traspasos 
	WHERE codtraspaso = '".limpiar(decrypt($_GET["codtraspaso"]))."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$recibebd = $row['recibe'];
	$totalpagobd = $row['totalpago'];
	########################## CONSULTO DATOS DE TRASPASO ##########################

    $sql = "SELECT * FROM detalle_traspasos 
    WHERE codtraspaso = '".limpiar(decrypt($_GET["codtraspaso"]))."' 
    AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;

		$codproducto = $row['codproducto'];
		$cantidadbd = $row['cantidad'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];

        ######################### DATOS DE SUCURSAL QUE ENVIA TRASPASO #######################

        ############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($codproducto,decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciabd = $row['existencia'];
		############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codsucursal);

		$existencia = limpiar($existenciabd+$cantidadbd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############

	    ########### REGISTRAMOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ############
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codtraspaso);
		$stmt->bindParam(2, $recibe);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
		$stmt->bindParam(14, $tipodetalle);	
		$stmt->bindParam(15, $codsucursal);

		$codtraspaso = limpiar(decrypt($_GET["codtraspaso"]));
	    $recibe = limpiar($recibebd);
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($existenciabd+$cantidadbd);
		$precio = limpiar($precioventabd);
		$ivaproducto = limpiar($ivaproductobd);
		$descproducto = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION TRASPASO: ".decrypt($_GET["codtraspaso"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipodetalle = limpiar("2");
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########### REGISTRAMOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ############

		######################### DATOS DE SUCURSAL QUE ENVIA TRASPASO #######################			

		
		######################### DATOS DE SUCURSAL QUE RECIBE TRASPASO #######################			
        
        ############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($codproducto,$recibebd));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciarecibebd = $row['existencia'];
		############ OBTENGO LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $recibebd);

		$existencia = limpiar($existenciarecibebd-$cantidadbd);
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ############

	    ########### REGISTRAMOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ############
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codtraspaso);
		$stmt->bindParam(2, $codsucursal);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		
		$stmt->bindParam(14, $tipodetalle);	
		$stmt->bindParam(15, $recibe);

		$codtraspaso = limpiar(decrypt($_GET["codtraspaso"]));		
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($existenciarecibebd-$cantidadbd);
		$precio = limpiar($precioventabd);
		$ivaproducto = limpiar($ivaproductobd);
		$descproducto = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION TRASPASO: ".decrypt($_GET["codtraspaso"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipodetalle = limpiar("2");
	    $recibe = limpiar($recibebd);
		$stmt->execute();
		########### REGISTRAMOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ############

		######################## DATOS DE SUCURSAL QUE RECIBE TRASPASO #######################			
	}

	########################## ELIMINO TRASPASOS ##########################
	$sql = "DELETE FROM traspasos WHERE codtraspaso = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codtraspaso);
	$stmt->bindParam(2,$codsucursal);
	$codtraspaso = decrypt($_GET["codtraspaso"]);
	$codsucursal = decrypt($_GET["codsucursal"]);
	$stmt->execute();
	########################## ELIMINO TRASPASOS ##########################

	########################## ELIMINO DETALLES TRASPASOS ##########################
	$sql = "DELETE FROM detalle_traspasos WHERE codtraspaso = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codtraspaso);
	$stmt->bindParam(2,$codsucursal);
	$codtraspaso = decrypt($_GET["codtraspaso"]);
	$codsucursal = decrypt($_GET["codsucursal"]);
	$stmt->execute();
	########################## ELIMINO DETALLES TRASPASOS ##########################

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
########################## FUNCION ELIMINAR TRASPASOS ###########################

####################### FUNCION BUSQUEDA TRASPASOS POR SUCURSAL ######################
public function BuscarTraspasosxSucursal() 
	{
	self::SetNames();
	$sql ="SELECT 
	traspasos.idtraspaso, 
	traspasos.codtraspaso, 
	traspasos.recibe, 
	traspasos.subtotalivasi, 
	traspasos.subtotalivano, 
	traspasos.iva, 
	traspasos.totaliva,
	traspasos.descontado, 
	traspasos.descuento, 
	traspasos.totaldescuento,
	traspasos.totalpago, 
	traspasos.totalpago2, 
	traspasos.fechatraspaso, 
	traspasos.observaciones, 
	traspasos.codigo,
	traspasos.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	provincias.provincia,
	departamentos.departamento,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	documentos.documento,
	documentos2.documento AS documento2,
	sucursales2.documsucursal AS documsucursal2,
	sucursales2.cuitsucursal AS cuitsucursal2,
	sucursales2.nomsucursal AS nomsucursal2,
	sucursales2.id_provincia AS id_provincia2,
	sucursales2.id_departamento AS id_departamento2,
	sucursales2.direcsucursal AS direcsucursal2,
	sucursales2.correosucursal AS correosucursal2,
	sucursales2.tlfsucursal AS tlfsucursal2,
	sucursales2.documencargado AS documencargado2,
	sucursales2.dniencargado AS dniencargado2,
	sucursales2.nomencargado AS nomencargado2,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	SUM(detalle_traspasos.cantidad) AS sumarticulos 
	FROM (traspasos LEFT JOIN detalle_traspasos ON detalle_traspasos.codtraspaso = traspasos.codtraspaso)
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN sucursales AS sucursales2 ON traspasos.recibe = sucursales2.codsucursal
	LEFT JOIN documentos AS documentos3 ON sucursales.documsucursal = documentos3.coddocumento
	LEFT JOIN documentos AS documentos4 ON sucursales.documencargado = documentos4.coddocumento
	LEFT JOIN provincias AS provincias2 ON sucursales.id_provincia = provincias2.id_provincia
	LEFT JOIN departamentos AS departamentos2 ON sucursales.id_departamento = departamentos2.id_departamento
	WHERE traspasos.codsucursal = ?
	GROUP BY detalle_traspasos.codtraspaso";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA TRASPASOS POR SUCURSAL ########################

####################### FUNCION BUSQUEDA TRASPASOS POR FECHAS #######################
public function BuscarTraspasosxFechas() 
	{
	self::SetNames();
	$sql ="SELECT 
	traspasos.idtraspaso, 
	traspasos.codtraspaso, 
	traspasos.recibe, 
	traspasos.subtotalivasi, 
	traspasos.subtotalivano, 
	traspasos.iva, 
	traspasos.totaliva,
	traspasos.descontado, 
	traspasos.descuento, 
	traspasos.totaldescuento,
	traspasos.totalpago, 
	traspasos.totalpago2, 
	traspasos.fechatraspaso, 
	traspasos.observaciones, 
	traspasos.codigo,
	traspasos.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	provincias.provincia,
	departamentos.departamento,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	documentos.documento,
	documentos2.documento AS documento2,
	sucursales2.documsucursal AS documsucursal2,
	sucursales2.cuitsucursal AS cuitsucursal2,
	sucursales2.nomsucursal AS nomsucursal2,
	sucursales2.id_provincia AS id_provincia2,
	sucursales2.id_departamento AS id_departamento2,
	sucursales2.direcsucursal AS direcsucursal2,
	sucursales2.correosucursal AS correosucursal2,
	sucursales2.tlfsucursal AS tlfsucursal2,
	sucursales2.documencargado AS documencargado2,
	sucursales2.dniencargado AS dniencargado2,
	sucursales2.nomencargado AS nomencargado2,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	SUM(detalle_traspasos.cantidad) AS sumarticulos 
	FROM (traspasos LEFT JOIN detalle_traspasos ON detalle_traspasos.codtraspaso = traspasos.codtraspaso)
	LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda
	LEFT JOIN sucursales AS sucursales2 ON traspasos.recibe = sucursales2.codsucursal
	LEFT JOIN documentos AS documentos3 ON sucursales.documsucursal = documentos3.coddocumento
	LEFT JOIN documentos AS documentos4 ON sucursales.documencargado = documentos4.coddocumento
	LEFT JOIN provincias AS provincias2 ON sucursales.id_provincia = provincias2.id_provincia
	LEFT JOIN departamentos AS departamentos2 ON sucursales.id_departamento = departamentos2.id_departamento
	WHERE traspasos.codsucursal = ? 
	AND DATE_FORMAT(traspasos.fechatraspaso,'%Y-%m-%d') BETWEEN ? AND ? 
	GROUP BY detalle_traspasos.codtraspaso";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA TRASPASOS POR FECHAS ###########################

####################### FUNCION BUSQUEDA PRODUCTOS TRASPASOS POR FECHAS #######################
public function BuscarProductosTraspasos() 
	{
	self::SetNames();
   $sql ="SELECT 
   detalle_traspasos.idproducto,
   detalle_traspasos.codproducto,
   detalle_traspasos.producto,
   detalle_traspasos.codmarca,
   detalle_traspasos.codpresentacion,
   detalle_traspasos.codmedida,
   detalle_traspasos.preciocompra,
   detalle_traspasos.precioventa,  
   detalle_traspasos.ivaproducto,
   detalle_traspasos.descproducto,
   productos.existencia,
   marcas.nommarca,
   presentaciones.nompresentacion,
   medidas.nommedida, 
   traspasos.fechatraspaso,
   sucursales.documsucursal, 
   sucursales.cuitsucursal, 
   sucursales.nomsucursal,
   sucursales.documencargado,
   sucursales.dniencargado,
   sucursales.nomencargado,
   sucursales.tlfsucursal,
   sucursales.direcsucursal,
   sucursales.correosucursal,
   sucursales.llevacontabilidad,
   sucursales.codmoneda,
   sucursales.codmoneda2,
   tiposmoneda.moneda,
   tiposmoneda.siglas,
   tiposmoneda.simbolo,
   tiposmoneda2.moneda AS moneda2,
   tiposmoneda2.siglas AS siglas2,
   tiposmoneda2.simbolo AS simbolo2,
   tiposcambio.codcambio,
   tiposcambio.montocambio,
   documentos.documento,
   documentos2.documento AS documento2,
   usuarios.dni,
   usuarios.nombres, 
   SUM(detalle_traspasos.cantidad) as cantidad 
   FROM (traspasos INNER JOIN detalle_traspasos ON traspasos.codtraspaso = detalle_traspasos.codtraspaso)
   LEFT JOIN productos ON detalle_traspasos.idproducto = productos.idproducto 
   LEFT JOIN marcas ON detalle_traspasos.codmarca = marcas.codmarca
   LEFT JOIN presentaciones ON detalle_traspasos.codpresentacion = presentaciones.codpresentacion 
   LEFT JOIN medidas ON detalle_traspasos.codmedida = medidas.codmedida
   LEFT JOIN sucursales ON traspasos.codsucursal = sucursales.codsucursal
   LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
   LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
   LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
   LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
   LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
   LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
   LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
   LEFT JOIN usuarios ON traspasos.codigo = usuarios.codigo 
   WHERE traspasos.codsucursal = '".decrypt($_GET['codsucursal'])."' 
   AND DATE_FORMAT(traspasos.fechatraspaso,'%Y-%m-%d') BETWEEN ? AND ? 
   GROUP BY detalle_traspasos.codproducto, detalle_traspasos.precioventa, detalle_traspasos.descproducto 
   ORDER BY detalle_traspasos.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	    echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA PRODUCTOS TRASPASOS POR FECHAS ###########################

################################## CLASE TRASPASOS ###################################


















###################################### CLASE COMPRAS ###################################

############################# FUNCION REGISTRAR COMPRAS #############################
public function RegistrarCompras()
	{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["codcompra"]) or empty($_POST["fechaemision"]) or empty($_POST["fecharecepcion"]) or empty($_POST["codproveedor"]))
	{
			echo "1";
			exit;
	}
	elseif(empty($_SESSION["CarritoCompra"]))
	{
		echo "2";
		exit;
		
	}

	####################### SI LA COMPRA ES A CREDITO #######################
	if($_POST["tipocompra"]=="CREDITO"){ 

	    $fechaactual = date("Y-m-d");
	    $fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));
	
        if (strtotime($fechavence) < strtotime($fechaactual)) {
  
            echo "3";
	        exit;
  
        } else if($_POST["montoabono"] >= $_POST["txtTotal"]){

		    echo "4";
		    exit;
	   } 
    }
    ####################### SI LA COMPRA ES A CREDITO #######################

    $sql = "SELECT codcompra FROM compras WHERE codcompra = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST['codcompra']));
	$num = $stmt->rowCount();
	if($num == 0)
	{

        ################################### REGISTRO LA FACTURA ###################################
        $query = "INSERT INTO compras values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $subtotalivasic);
		$stmt->bindParam(4, $subtotalivanoc);
		$stmt->bindParam(5, $ivac);
		$stmt->bindParam(6, $totalivac);
		$stmt->bindParam(7, $descontadoc);
		$stmt->bindParam(8, $descuentoc);
		$stmt->bindParam(9, $totaldescuentoc);
		$stmt->bindParam(10, $totalpagoc);
		$stmt->bindParam(11, $tipocompra);
		$stmt->bindParam(12, $formacompra);
		$stmt->bindParam(13, $creditopagado);
		$stmt->bindParam(14, $fechavencecredito);
		$stmt->bindParam(15, $fechapagado);
		$stmt->bindParam(16, $statuscompra);
		$stmt->bindParam(17, $fechaemision);
		$stmt->bindParam(18, $fecharecepcion);
		$stmt->bindParam(19, $observaciones);
		$stmt->bindParam(20, $codigo);
		$stmt->bindParam(21, $codsucursal);
	    
		$codcompra = limpiar($_POST["codcompra"]);
		$codproveedor = limpiar($_POST["codproveedor"]);
		$subtotalivasic = limpiar($_POST["txtgravado"]);
		$subtotalivanoc = limpiar($_POST["txtexento"]);
		$ivac = limpiar($_POST["iva"]);
		$totalivac = limpiar($_POST["txtIva"]);
		$descontadoc = limpiar($_POST["txtdescontado"]);
		$descuentoc = limpiar($_POST["descuento"]);
		$totaldescuentoc = limpiar($_POST["txtDescuento"]);
		$totalpagoc = limpiar($_POST["txtTotal"]);
		$tipocompra = limpiar($_POST["tipocompra"]);
		$formacompra = limpiar($_POST["tipocompra"]=="CONTADO" ? $_POST["formacompra"] : "CREDITO");
		$fechavencecredito = limpiar($_POST["tipocompra"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
		$creditopagado = limpiar(isset($_POST['montoabono']) ? $_POST['montoabono'] : "0.00");
        $fechapagado = limpiar("0000-00-00");
		$statuscompra = limpiar($_POST["tipocompra"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
        $fechaemision = limpiar(date("Y-m-d",strtotime($_POST['fechaemision'])));
        $fecharecepcion = limpiar(date("Y-m-d",strtotime($_POST['fecharecepcion'])));
        $observaciones = limpiar($_POST['observaciones']);
		$codigo = limpiar($_SESSION["codigo"]);
		$codsucursal = limpiar(decrypt($_POST['codsucursal']));
		$stmt->execute();
		################################### REGISTRO LA FACTURA ###################################
		
		$this->dbh->beginTransaction();

		$detalle = $_SESSION["CarritoCompra"];
		for($i=0;$i<count($detalle);$i++){

        ############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################
		$sql = "SELECT existencia FROM productos 
		WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
		AND codsucursal = '".limpiar(decrypt($_POST['codsucursal']))."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciabd = $row['existencia'];
		############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################

		############# REGISTRAMOS DETALLES DE COMPRAS ###############
		$query = "INSERT INTO detalle_compras values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
	    $stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $preciocomprac);
		$stmt->bindParam(4, $precioventac);
		$stmt->bindParam(5, $cantcompra);
		$stmt->bindParam(6, $ivaproductoc);
		$stmt->bindParam(7, $descproductoc);
		$stmt->bindParam(8, $descfactura);
		$stmt->bindParam(9, $valortotal);
		$stmt->bindParam(10, $totaldescuentoc);
		$stmt->bindParam(11, $valorneto);
		$stmt->bindParam(12, $lotec);
		$stmt->bindParam(13, $fechaelaboracionc);
		$stmt->bindParam(14, $fechaexpiracionc);
		$stmt->bindParam(15, $codsucursal);
			
		$codcompra = limpiar($_POST['codcompra']);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$preciocomprac = limpiar($detalle[$i]['precio']);
		$precioventac = limpiar($detalle[$i]['precio2']);
		$cantcompra = limpiar($detalle[$i]['cantidad']);
		$ivaproductoc = limpiar($detalle[$i]['ivaproducto']);
		$descproductoc = limpiar($detalle[$i]['descproducto']);
		$descfactura = limpiar($detalle[$i]['descproductofact']);
		$descuento = $detalle[$i]["descproductofact"]/100;
		$valortotal = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
		$totaldescuentoc = number_format($valortotal*$descuento, 2, '.', '');
	    $valorneto = number_format($valortotal-$totaldescuentoc, 2, '.', '');
		$lotec = limpiar($detalle[$i]['lote']);
		$fechaelaboracionc = limpiar($detalle[$i]['fechaelaboracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaelaboracion'])));
		$fechaexpiracionc = limpiar($detalle[$i]['fechaexpiracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion'])));
		$codsucursal = limpiar(decrypt($_POST['codsucursal']));
		$stmt->execute();
		############# REGISTRAMOS DETALLES DE COMPRAS ###############

		############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS ###############
		$sql = "UPDATE productos set "
		      ." preciocompra = ?, "
			  ." precioventa = ?, "
			  ." existencia = ?, "
			  ." ivaproducto = ?, "
			  ." descproducto = ?, "
			  ." fechaelaboracion = ?, "
			  ." fechaexpiracion = ?, "
			  ." codproveedor = ?, "
			  ." lote = ? "
			  ." WHERE "
			  ." codproducto = ? AND codsucursal = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $preciocompra);
		$stmt->bindParam(2, $precioventa);
		$stmt->bindParam(3, $existencia);
		$stmt->bindParam(4, $ivaproducto);
		$stmt->bindParam(5, $descproducto);
		$stmt->bindParam(6, $fechaelaboracion);
		$stmt->bindParam(7, $fechaexpiracion);
		$stmt->bindParam(8, $codproveedor);
		$stmt->bindParam(9, $lote);
		$stmt->bindParam(10, $codproducto);
		$stmt->bindParam(11, $codsucursal);
		
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioventa = limpiar($detalle[$i]['precio2']);
		$existencia = limpiar($detalle[$i]['cantidad']+$existenciabd);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$fechaelaboracion = limpiar($detalle[$i]['fechaelaboracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaelaboracion'])));
		$fechaexpiracion = limpiar($detalle[$i]['fechaexpiracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion'])));
		$codproveedor = limpiar($_POST['codproveedor']);
		$lote = limpiar($detalle[$i]['lote']);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$codsucursal = limpiar(decrypt($_POST['codsucursal']));
		$stmt->execute();
		############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS ###############

		############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
        $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);	
		$stmt->bindParam(14, $tipokardex);	
		$stmt->bindParam(15, $codsucursal);

		$codcompra = limpiar($_POST['codcompra']);
		$codproveedor = limpiar($_POST["codproveedor"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("ENTRADAS");
		$entradas= limpiar($detalle[$i]['cantidad']);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($detalle[$i]['cantidad']+$existenciabd);
		$precio = limpiar($detalle[$i]["precio"]);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("COMPRA: ".$_POST['codcompra']);
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("2");
		$codsucursal = limpiar(decrypt($_POST['codsucursal']));
		$stmt->execute();
		############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
      }
		####################### DESTRUYO LA VARIABLE DE SESSION #####################
	    unset($_SESSION["CarritoCompra"]);
        $this->dbh->commit();

        ########################## EN CASO DE ABONO DE CREDITO #################################
	    if (limpiar(isset($_POST['montoabono'])) && limpiar($_POST["montoabono"]!="0.00" && $_POST["montoabono"]!="0" && $_POST["montoabono"]!="")) {

		$query = "INSERT INTO abonoscreditoscompras values (null, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $medioabono);
		$stmt->bindParam(4, $montoabono);
		$stmt->bindParam(5, $fechaabono);
		$stmt->bindParam(6, $codsucursal);

		$codproveedor = limpiar($_POST["codproveedor"]);
		$medioabono = limpiar($_POST["medioabono"]);
		$montoabono = limpiar($_POST["montoabono"]);
		$fechaabono = limpiar(date("Y-m-d H:i:s"));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

	    }
	    ########################## EN CASO DE ABONO DE CREDITO #################################

		
        echo "<span class='fa fa-check-square-o'></span> LA COMPRA DE PRODUCTOS HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codcompra=".encrypt($codcompra)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOMPRA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

        echo "<script>window.open('reportepdf?codcompra=".encrypt($codcompra)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOMPRA")."', '_blank');</script>";
	    exit;
	}
	else
	{
		echo "5";
		exit;
	}
}
############################ FUNCION REGISTRAR COMPRAS ##########################

########################## FUNCION BUSQUEDA DE COMPRAS ###############################
public function BusquedaCompras()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    if ($_SESSION['acceso'] == "administradorG") {

    $sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	SUM(detalle_compras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detalle_compras ON detalle_compras.codcompra = compras.codcompra) 
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	WHERE
    (compras.codcompra = '".$buscar."')
    OR 
    (compras.formacompra = '".$buscar."') 
    OR 
    (compras.fechaemision = '".$buscar."')
    OR 
    (proveedores.cuitproveedor = '".$buscar."') 
    OR 
    (proveedores.nomproveedor = '".$buscar."')
    AND 
    compras.statuscompra = 'PAGADA' GROUP BY detalle_compras.codcompra ORDER BY compras.idcompra DESC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
} else {

$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	SUM(detalle_compras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detalle_compras ON detalle_compras.codcompra = compras.codcompra) 
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	WHERE
    (compras.codcompra = '".$buscar."')
    OR 
    (compras.formacompra = '".$buscar."') 
    OR 
    (compras.fechaemision = '".$buscar."')
    OR 
    (proveedores.cuitproveedor = '".$buscar."') 
    OR 
    (proveedores.nomproveedor = '".$buscar."')
    AND 
    compras.codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND compras.statuscompra = 'PAGADA' GROUP BY detalle_compras.codcompra ORDER BY compras.idcompra DESC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	   }
	}
}
########################## FUNCION BUSQUEDA DE COMPRAS ###############################

######################### FUNCION LISTAR COMPRAS ################################
public function ListarCompras()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	SUM(detalle_compras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detalle_compras ON detalle_compras.codcompra = compras.codcompra) 
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo WHERE compras.statuscompra = 'PAGADA' GROUP BY detalle_compras.codcompra ORDER BY compras.idcompra DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

   $sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	SUM(detalle_compras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detalle_compras ON detalle_compras.codcompra = compras.codcompra) 
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo WHERE compras.codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND compras.statuscompra = 'PAGADA' GROUP BY detalle_compras.codcompra ORDER BY compras.idcompra DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     }
}
################################## FUNCION LISTAR COMPRAS ############################

########################## FUNCION BUSQUEDA DE CUENTAS POR PAGAR ###############################
public function BusquedaCuentasxPagar()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    if ($_SESSION['acceso'] == "administradorG") {

    $sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	SUM(detalle_compras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detalle_compras ON detalle_compras.codcompra = compras.codcompra) 
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	WHERE
    (compras.codcompra = '".$buscar."')
    OR 
    (compras.formacompra = '".$buscar."') 
    OR 
    (compras.fechaemision = '".$buscar."')
    OR 
    (proveedores.cuitproveedor = '".$buscar."') 
    OR 
    (proveedores.nomproveedor = '".$buscar."')
    AND 
    compras.statuscompra = 'PENDIENTE' GROUP BY detalle_compras.codcompra ORDER BY compras.idcompra DESC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
} else {

    $sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	SUM(detalle_compras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detalle_compras ON detalle_compras.codcompra = compras.codcompra) 
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	WHERE
    (compras.codcompra = '".$buscar."')
    OR 
    (compras.formacompra = '".$buscar."') 
    OR 
    (compras.fechaemision = '".$buscar."')
    OR 
    (proveedores.cuitproveedor = '".$buscar."') 
    OR 
    (proveedores.nomproveedor = '".$buscar."') 
    AND 
    compras.codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND compras.statuscompra = 'PENDIENTE' GROUP BY detalle_compras.codcompra ORDER BY compras.idcompra DESC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	   }
	}
}
########################## FUNCION BUSQUEDA DE CUENTAS POR PAGAR ###############################

########################### FUNCION LISTAR CUENTAS POR PAGAR #######################
public function ListarCuentasxPagar()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	SUM(detalle_compras.cantcompra) AS articulos  
	FROM (compras LEFT JOIN detalle_compras ON detalle_compras.codcompra = compras.codcompra)
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	WHERE compras.statuscompra = 'PENDIENTE' 
	GROUP BY detalle_compras.codcompra 
	ORDER BY compras.idcompra DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

   $sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	SUM(detalle_compras.cantcompra) AS articulos  
	FROM (compras LEFT JOIN detalle_compras ON detalle_compras.codcompra = compras.codcompra)
	LEFT JOIN sucursales ON compras.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	WHERE compras.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	AND compras.statuscompra = 'PENDIENTE' 
	GROUP BY detalle_compras.codcompra 
	ORDER BY compras.idcompra DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    }
}
######################### FUNCION LISTAR CUENTAS POR PAGAR ############################

############################ FUNCION PARA PAGAR COMPRAS ############################
public function RegistrarPagoCompra()
	{
	self::SetNames();

	if(empty($_POST["codproveedor"]) or empty($_POST["codcompra"]) or empty($_POST["medioabono"]) or empty($_POST["montoabono"]))
	{
		echo "1";
		exit;
	} 
	else if($_POST["montoabono"] > $_POST["totaldebe"])
	{
		echo "2";
		exit;

	}

	############## REGISTRAMOS EL ABONO EN COMPRA ##################
	$query = "INSERT INTO abonoscreditoscompras values (null, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcompra);
	$stmt->bindParam(2, $codproveedor);
	$stmt->bindParam(3, $medioabono);
	$stmt->bindParam(4, $montoabono);
	$stmt->bindParam(5, $fechaabono);
	$stmt->bindParam(6, $codsucursal);

	$codcompra = limpiar($_POST["codcompra"]);
	$codproveedor = limpiar(decrypt($_POST["codproveedor"]));
	$medioabono = limpiar($_POST["medioabono"]);
	$montoabono = limpiar($_POST["montoabono"]);
	$fechaabono = limpiar(date("Y-m-d h:i:s"));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	############## REGISTRAMOS EL ABONO EN COMPRA ##################

    ############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
	if($_POST["montoabono"] == $_POST["totaldebe"]) {

		$sql = "UPDATE compras set "
		." creditopagado = ?, "
		." fechapagado = ?, "
		." statuscompra = ? "
		." WHERE "
		." codcompra = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $creditopagado);
		$stmt->bindParam(2, $fechapagado);
		$stmt->bindParam(3, $statuscompra);
		$stmt->bindParam(4, $codcompra);
		$stmt->bindParam(5, $codsucursal);

		$creditopagado = number_format($_POST["totalabono"] + $_POST["montoabono"], 2, '.', '');
		$fechapagado = limpiar(date("Y-m-d"));
		$statuscompra = limpiar("PAGADA");
		$codcompra = limpiar($_POST["codcompra"]);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

	} else {

		$sql = "UPDATE compras set "
		." creditopagado = ? "
		." WHERE "
		." codcompra = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $creditopagado);
		$stmt->bindParam(2, $codcompra);
		$stmt->bindParam(3, $codsucursal);

		$creditopagado = number_format($_POST["totalabono"] + $_POST["montoabono"], 2, '.', '');
		$codcompra = limpiar($_POST["codcompra"]);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
	}
    ############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
	
    echo "<span class='fa fa-check-square-o'></span> EL ABONO AL CR&Eacute;DITO DE COMPRA HA SIDO REGISTRADO EXITOSAMENTE</div>";
	exit;
}
########################## FUNCION PARA PAGAR COMPRAS ###############################

########################### FUNCION VER DETALLES ABONOS COMPRAS #######################
public function VerDetallesAbonosCompras()
{
	self::SetNames();
	$sql = "SELECT * FROM abonoscreditoscompras 
	INNER JOIN compras ON abonoscreditoscompras.codcompra = compras.codcompra 
	WHERE abonoscreditoscompras.codcompra = ? 
	AND abonoscreditoscompras.codsucursal = ?";	
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET["codcompra"])));
	$stmt->bindValue(2, trim(decrypt($_GET["codsucursal"])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION VER DETALLES ABONOS COMPRAS ###########################

############################ FUNCION ID COMPRAS #################################
public function ComprasPorId()
	{
	self::SetNames();
	$sql = "SELECT 
	compras.idcompra,
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia, 
	proveedores.id_departamento, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2
	FROM (compras INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal) 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON proveedores.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON proveedores.id_departamento = departamentos2.id_departamento 
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	WHERE compras.codcompra = ? AND compras.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcompra"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID COMPRAS #################################
	
############################ FUNCION VER DETALLES COMPRAS ############################
public function VerDetallesCompras()
	{
	self::SetNames();
	$sql = "SELECT
	detalle_compras.coddetallecompra,
	detalle_compras.codcompra,
	detalle_compras.codproducto,
	detalle_compras.preciocomprac,
	detalle_compras.precioventac,
	detalle_compras.cantcompra,
	detalle_compras.ivaproductoc,
	detalle_compras.descproductoc,
	detalle_compras.descfactura,
	detalle_compras.valortotal, 
	detalle_compras.totaldescuentoc,
	detalle_compras.valorneto,
	detalle_compras.lotec,
	detalle_compras.fechaelaboracionc,
	detalle_compras.fechaexpiracionc,
	detalle_compras.codsucursal,
	productos.codproducto,
	productos.producto,
	productos.codmarca,
	productos.codpresentacion,
	productos.codmedida,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida
	FROM detalle_compras INNER JOIN productos ON detalle_compras.codproducto = productos.codproducto 
	INNER JOIN marcas ON productos.codmarca = marcas.codmarca
	LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON productos.codmedida = medidas.codmedida
	WHERE detalle_compras.codcompra = ? 
	AND detalle_compras.codsucursal = ? 
	GROUP BY productos.codproducto";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcompra"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION VER DETALLES COMPRAS ##############################

############################## FUNCION ACTUALIZAR COMPRAS #############################
public function ActualizarCompras()
	{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["codcompra"]) or empty($_POST["fechaemision"]) or empty($_POST["fecharecepcion"]) or empty($_POST["codproveedor"]))
	{
		echo "1";
		exit;
	}

	####################### SI LA COMPRA ES A CREDITO #######################
	if (limpiar(isset($_POST['fechavencecredito']))) {

	    $fechaactual = date("Y-m-d");
	    $fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));
	
        if (strtotime($fechavence) < strtotime($fechaactual)) {
  
            echo "3";
	        exit;
  
        } 
    }
    ####################### SI LA COMPRA ES A CREDITO #######################


	####################### VERIFICO QUE NO EXISTAN CANTIDAD IGUAL A CERO #######################
	for($i=0;$i<count($_POST['coddetallecompra']);$i++){  //recorro el array
        if (!empty($_POST['coddetallecompra'][$i])) {

	       if($_POST['cantcompra'][$i]==0){

		      echo "3";
		      exit();

	        }
        }
    }
    ####################### VERIFICO QUE NO EXISTAN CANTIDAD IGUAL A CERO #######################

    ############ OBTENGO DETALLE DE COMPRA ##############
	$sql = "SELECT
	tipocompra,
	formacompra,
	creditopagado
	FROM compras 
	WHERE codcompra = '".limpiar(decrypt($_POST["compra"]))."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$tipocomprabd = $row['tipocompra'];
	$formacomprabd = $row['formacompra'];
	$creditopagadobd = $row['creditopagado'];
	############ OBTENGO DETALLE DE COMPRA ##############

    $this->dbh->beginTransaction();

    for($i=0;$i<count($_POST['coddetallecompra']);$i++){  //recorro el array
	    if (!empty($_POST['coddetallecompra'][$i])) {

	############ OBTENGO CANTIDAD EN DETALLES ##############
	$sql = "SELECT cantcompra FROM detalle_compras 
	WHERE coddetallecompra = '".limpiar(decrypt($_POST['coddetallecompra'][$i]))."' 
	AND codcompra = '".limpiar($_POST["codcompra"])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
		
	$cantidadcomprado = $row['cantcompra'];
	############ OBTENGO CANTIDAD EN DETALLES ##############

	if($cantidadcomprado != $_POST['cantcompra'][$i]){

		##################### OBTENGO EXISTENCIA POR CODIGO ####################
		$sql = "SELECT existencia 
		FROM productos 
		WHERE codproducto = '".limpiar(decrypt($_POST['codproducto'][$i]))."' 
		AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	    foreach ($this->dbh->query($sql) as $row)
	    {
		$this->p[] = $row;
	    }
	    $existenciabd = $row['existencia'];
	    $cantcompra = $_POST["cantcompra"][$i];
	    $cantidadcomprabd = $_POST["cantidadcomprabd"][$i];
	    $totalcompra = $cantcompra - $cantidadcomprabd;
	    ##################### OBTENGO EXISTENCIA POR CODIGO ####################

		##################### ACTUALIZAMOS DETALLES DE COMPRAS ####################
		$query = "UPDATE detalle_compras set"
		." cantcompra = ?, "
		." valortotal = ?, "
		." totaldescuentoc = ?, "
		." valorneto = ? "
		." WHERE "
		." coddetallecompra = ? AND codcompra = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantcompra);
		$stmt->bindParam(2, $valortotal);
		$stmt->bindParam(3, $totaldescuento);
		$stmt->bindParam(4, $valorneto);
		$stmt->bindParam(5, $coddetallecompra);
		$stmt->bindParam(6, $codcompra);
		$stmt->bindParam(7, $codsucursal);

		$cantcompra = limpiar($_POST['cantcompra'][$i]);
		$preciocompra = limpiar($_POST['preciocompra'][$i]);
		$precioventa = limpiar($_POST['precioventa'][$i]);
		$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
		$descuento = limpiar($_POST['descfactura'][$i]/100);
		$valortotal = number_format($_POST['preciocompra'][$i] * $_POST['cantcompra'][$i], 2, '.', '');
		$totaldescuento = number_format($valortotal * $descuento, 2, '.', '');
		$valorneto = number_format($valortotal - $totaldescuento, 2, '.', '');
		$coddetallecompra = limpiar(decrypt($_POST['coddetallecompra'][$i]));
		$codcompra = limpiar($_POST["codcompra"]);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
		##################### ACTUALIZAMOS DETALLES DE COMPRAS ####################

		############ ACTUALIZAMOS EXISTENCIA EN ALMACEN ################
		$sql2 = " UPDATE productos set "
			  ." existencia = ? "
			  ." WHERE "
			  ." codproducto = '".limpiar(decrypt($_POST["codproducto"][$i]))."' 
			  AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
			  ";
	    $stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $existencia);
		$existencia = $existenciabd + $totalcompra;
		$stmt->execute();
	    ############ ACTUALIZAMOS EXISTENCIA EN ALMACEN ################

		############## ACTUALIZAMOS LOS DATOS EN KARDEX ################
		$sql3 = " UPDATE kardex set "
		      ." entradas = ?, "
		      ." stockactual = ? "
			  ." WHERE "
			  ." codproceso = '".limpiar($_POST["codcompra"])."' 
			  AND codproducto = '".limpiar(decrypt($_POST["codproducto"][$i]))."'
			  AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
			   ";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->bindParam(1, $entradas);
		$stmt->bindParam(2, $existencia);

		$entradas = limpiar($_POST["cantcompra"][$i]);
		$stmt->execute();
		############## ACTUALIZAMOS LOS DATOS EN KARDEX ################
		
			} else {

               echo "";

		       }
	        }
        }

        $this->dbh->commit();

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentoc) AS totaldescuentosi, SUM(valorneto) AS valorneto FROM detalle_compras WHERE codcompra = '".limpiar($_POST["codcompra"])."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' AND ivaproductoc = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasic = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentoc) AS totaldescuentono, SUM(valorneto) AS valorneto FROM detalle_compras WHERE codcompra = '".limpiar($_POST["codcompra"])."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' AND ivaproductoc = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivanoc = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
		$sql = " UPDATE compras SET "
		." codproveedor = ?, "
		." subtotalivasic = ?, "
		." subtotalivanoc = ?, "
		." totalivac = ?, "
		." descontadoc = ?, "
		." descuentoc = ?, "
		." totaldescuentoc = ?, "
		." totalpagoc = ?, "
		." tipocompra = ?, "
		." formacompra = ?, "
		." creditopagado = ?, "
		." fechavencecredito = ?, "
		." statuscompra = ?, "
		." fechaemision = ?, "
		." fecharecepcion = ?, "
		." observaciones = ? "
		." WHERE "
		." codcompra = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codproveedor);
		$stmt->bindParam(2, $subtotalivasic);
		$stmt->bindParam(3, $subtotalivanoc);
		$stmt->bindParam(4, $totalivac);
		$stmt->bindParam(5, $descontadoc);
		$stmt->bindParam(6, $descuentoc);
		$stmt->bindParam(7, $totaldescuentoc);
		$stmt->bindParam(8, $totalpagoc);
		$stmt->bindParam(9, $tipocompra);
		$stmt->bindParam(10, $formacompra);
		$stmt->bindParam(11, $creditopagado);
		$stmt->bindParam(12, $fechavencecredito);
		$stmt->bindParam(13, $statuscompra);
		$stmt->bindParam(14, $fechaemision);
		$stmt->bindParam(15, $fecharecepcion);
		$stmt->bindParam(16, $observaciones);
		$stmt->bindParam(17, $codcompra);
		$stmt->bindParam(18, $codsucursal);

		$codproveedor = limpiar($_POST["codproveedor"]);
		$ivac = $_POST["iva"]/100;
		$totalivac = number_format($subtotalivasic*$ivac, 2, '.', '');
		$descontadoc = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
		$descuentoc = limpiar($_POST["descuento"]);
	    $txtDescuento = $_POST["descuento"]/100;
	    $total = number_format($subtotalivasic+$subtotalivanoc+$totalivac, 2, '.', '');
	    $totaldescuentoc = number_format($total*$txtDescuento, 2, '.', '');
	    $totalpagoc = number_format($total-$totaldescuentoc, 2, '.', '');
		//$tipocompra = limpiar($_POST["tipocompra"]);
		//$formacompra = limpiar($_POST["tipocompra"]=="CONTADO" ? $_POST["formacompra"] : "CREDITO");
		$tipocompra = limpiar(isset($_POST["tipocompra"]) ? $_POST["tipocompra"] : "CREDITO");
		$formacompra = limpiar(isset($_POST["formacompra"]) ? $_POST["formacompra"] : "CREDITO");
		$creditopagado = limpiar(isset($_POST['montoabono']) ? $_POST['montoabono'] : "0.00");
		$fechavencecredito = limpiar(isset($_POST["fechavencecredito"]) ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
		$statuscompra = limpiar(isset($_POST["tipocompra"]) ? "PAGADA" : "PENDIENTE");
		//$statuscompra = limpiar($_POST["tipocompra"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
		$fechaemision = limpiar(date("Y-m-d",strtotime($_POST['fechaemision'])));
		$fecharecepcion = limpiar(date("Y-m-d",strtotime($_POST['fecharecepcion'])));
        $observaciones = limpiar($_POST['observaciones']);
		$codcompra = limpiar($_POST["codcompra"]);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

echo "<span class='fa fa-check-square-o'></span> LA COMPRA DE PRODUCTOS HA SIDO ACTUALIZADA EXITOSAMENTE <a href='reportepdf?codcompra=".encrypt($codcompra)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOMPRA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codcompra=".encrypt($codcompra)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOMPRA")."', '_blank');</script>";
	exit;
}
############################# FUNCION ACTUALIZAR COMPRAS #########################

########################## FUNCION ELIMINAR DETALLES COMPRAS ########################
public function EliminarDetalleCompras()
    {
    self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT * FROM detalle_compras WHERE codcompra = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcompra"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		#################### SELECCIONO DATOS DE COMPRA ####################
		$sql = "SELECT 
		codproducto, 
		cantcompra, 
		preciocomprac, 
		ivaproductoc, 
		descproductoc 
		FROM detalle_compras 
		WHERE coddetallecompra = ? 
		AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddetallecompra"]),decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$codproducto = $row['codproducto'];
		$cantidaddb = $row['cantcompra'];
		$preciocompradb = $row['preciocomprac'];
		$ivaproductodb = $row['ivaproductoc'];
		$descproductodb = $row['descproductoc'];
		#################### SELECCIONO DATOS DE COMPRA ####################

		########### SELECCIONO EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproducto,decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciabd = $row['existencia'];
		########### SELECCIONO EXISTENCIA DE PRODUCTO EN ALMACEN #############

		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codsucursal);

		$existencia = limpiar($existenciabd-$cantidaddb);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############


	    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $codsucursal);

		$codcompra = limpiar(decrypt($_GET["codcompra"]));
	    $codproveedor = limpiar(decrypt($_GET["codproveedor"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidaddb);
		$stockactual = limpiar($existenciabd-$cantidaddb);
		$precio = limpiar($preciocompradb);
		$ivaproducto = limpiar($ivaproductodb);
		$descproducto = limpiar($descproductodb);
		$documento = limpiar("DEVOLUCION COMPRA: ".decrypt($_GET["codcompra"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("2");
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########

		########## ELIMINAMOS EL PRODUCTO EN DETALLES DE COMPRAS ###########
		$sql = "DELETE FROM detalle_compras WHERE coddetallecompra = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetallecompra);
		$stmt->bindParam(2,$codsucursal);
		$coddetallecompra = decrypt($_GET["coddetallecompra"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		########## ELIMINAMOS EL PRODUCTO EN DETALLES DE COMPRAS ###########

	    ############ CONSULTO LOS TOTALES DE COMPRAS ##############
	    $sql2 = "SELECT ivac, descuentoc FROM compras WHERE codcompra = ? AND codsucursal = ?";
	    $stmt = $this->dbh->prepare($sql2);
	    $stmt->execute(array(decrypt($_GET["codcompra"]),decrypt($_GET["codsucursal"])));
	    $num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$iva = $paea[0]["ivac"]/100;
	    $descuento = $paea[0]["descuentoc"]/100;
	    ############ CONSULTO LOS TOTALES DE COMPRAS ##############

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentoc) AS totaldescuentosi, SUM(valorneto) AS valorneto FROM detalle_compras WHERE codcompra = '".limpiar(decrypt($_GET["codcompra"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproductoc = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasic = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentoc) AS totaldescuentono, SUM(valorneto) AS valorneto FROM detalle_compras WHERE codcompra = '".limpiar(decrypt($_GET["codcompra"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproductoc = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivanoc = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN COMPRA ##############
		$sql = " UPDATE compras SET "
		." subtotalivasic = ?, "
		." subtotalivanoc = ?, "
		." totalivac = ?, "
		." descontadoc = ?, "
		." totaldescuentoc = ?, "
		." totalpagoc = ? "
		." WHERE "
		." codcompra = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasic);
		$stmt->bindParam(2, $subtotalivanoc);
		$stmt->bindParam(3, $totalivac);
		$stmt->bindParam(4, $descontadoc);
		$stmt->bindParam(5, $totaldescuentoc);
		$stmt->bindParam(6, $totalpagoc);
		$stmt->bindParam(7, $codcompra);
		$stmt->bindParam(8, $codsucursal);

		$totalivac= number_format($subtotalivasic*$iva, 2, '.', '');
		$descontadoc = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	    $total= number_format($subtotalivasic+$subtotalivanoc+$totalivac, 2, '.', '');
	    $totaldescuentoc = number_format($total*$descuento, 2, '.', '');
	    $totalpagoc = number_format($total-$totaldescuentoc, 2, '.', '');
		$codcompra = limpiar(decrypt($_GET["codcompra"]));
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN COMPRA ##############

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
###################### FUNCION ELIMINAR DETALLES COMPRAS #######################

####################### FUNCION ELIMINAR COMPRAS #################################
public function EliminarCompras()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT * FROM detalle_compras 
	WHERE codcompra = '".limpiar(decrypt($_GET["codcompra"]))."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";

	$array=array();

	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;

		$codproducto = $row['codproducto'];
		$cantidaddb = $row['cantcompra'];
		$preciocompradb = $row['preciocomprac'];
		$ivaproductodb = $row['ivaproductoc'];
		$descproductodb = $row['descproductoc'];

		########### SELECCIONO EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($codproducto,decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciabd = $row['existencia'];
		########### SELECCIONO EXISTENCIA DE PRODUCTO EN ALMACEN #############

		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codsucursal);

		$existencia = limpiar($existenciabd-$cantidaddb);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

	    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $codsucursal);

		$codcompra = limpiar(decrypt($_GET["codcompra"]));
	    $codproveedor = limpiar(decrypt($_GET["codproveedor"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidaddb);
		$stockactual = limpiar($existenciabd-$cantidaddb);
		$precio = limpiar($preciocompradb);
		$ivaproducto = limpiar($ivaproductodb);
		$descproducto = limpiar($descproductodb);
		$documento = limpiar("DEVOLUCION COMPRA: ".decrypt($_GET["codcompra"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar("2");
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
		}


		######################### ELIMINO COMPRA #########################
		$sql = "DELETE FROM compras WHERE codcompra = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$stmt->bindParam(2,$codsucursal);
		$codcompra = decrypt($_GET["codcompra"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		######################### ELIMINO COMPRA #########################

		######################### ELIMINO DETALLE COMPRA #########################
		$sql = "DELETE FROM detalle_compras WHERE codcompra = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$stmt->bindParam(2,$codsucursal);
		$codcompra = decrypt($_GET["codcompra"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		######################### ELIMINO DETALLE COMPRA #########################

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
######################### FUNCION ELIMINAR COMPRAS #################################

##################### FUNCION BUSQUEDA COMPRAS POR PROVEEDORES ###################
public function BuscarComprasxProveedor() 
	{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia, 
	proveedores.id_departamento, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2, 
	SUM(detalle_compras.cantcompra) as articulos 
	FROM (compras LEFT JOIN detalle_compras ON compras.codcompra=detalle_compras.codcompra) 
	INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON proveedores.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON proveedores.id_departamento = departamentos2.id_departamento 
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	WHERE compras.codsucursal = ? 
	AND compras.codproveedor = ? 
	AND compras.tipocompra = 'CONTADO'
	GROUP BY detalle_compras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"]),decrypt($_GET["codproveedor"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
echo "<div class='alert alert-danger'>";
echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
echo "</div>";		
exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
################### FUNCION BUSQUEDA COMPRAS POR PROVEEDORES ###################

###################### FUNCION BUSQUEDA COMPRAS POR FECHAS ###########################
public function BuscarComprasxFechas() 
{
	self::SetNames();
	$sql ="SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia, 
	proveedores.id_departamento, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2, 
	SUM(detalle_compras.cantcompra) as articulos 
	FROM (compras LEFT JOIN detalle_compras ON compras.codcompra=detalle_compras.codcompra) 
	INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON proveedores.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON proveedores.id_departamento = departamentos2.id_departamento 
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	WHERE compras.codsucursal = ? 
	AND DATE_FORMAT(compras.fecharecepcion,'%Y-%m-%d') BETWEEN ? AND ?
	AND compras.tipocompra = 'CONTADO' 
	GROUP BY detalle_compras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA COMPRAS POR FECHAS ###########################

###################### FUNCION BUSQUEDA CREDITOS POR PROVEEDOR ###########################
public function BuscarCreditosxProveedor() 
	{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia, 
	proveedores.id_departamento, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2, 
	SUM(detalle_compras.cantcompra) as articulos 
	FROM (compras LEFT JOIN detalle_compras ON compras.codcompra=detalle_compras.codcompra) 
	INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON proveedores.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON proveedores.id_departamento = departamentos2.id_departamento 
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	WHERE compras.codsucursal = ? 
	AND compras.codproveedor = ? 
	AND compras.tipocompra ='CREDITO' 
	GROUP BY compras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codproveedor'])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BUSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA CREDITOS POR PROVEEDOR ###########################

###################### FUNCION BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ###########################
public function BuscarCreditosComprasxFechas() 
	{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac, 
	compras.descontadoc,
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc,
	compras.tipocompra,
	compras.formacompra,
	compras.creditopagado, 
	compras.fechavencecredito, 
	compras.fechapagado, 
	compras.observaciones,
	compras.statuscompra, 
	compras.fechaemision,
	compras.fecharecepcion, 
	compras.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia, 
	proveedores.id_departamento, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2, 
	SUM(detalle_compras.cantcompra) as articulos 
	FROM (compras LEFT JOIN detalle_compras ON compras.codcompra=detalle_compras.codcompra) 
	INNER JOIN sucursales ON compras.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos AS documentos3 ON proveedores.documproveedor = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON proveedores.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON proveedores.id_departamento = departamentos2.id_departamento 
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	WHERE compras.codsucursal = ? 
	AND DATE_FORMAT(compras.fechaemision,'%Y-%m-%d') BETWEEN ? AND ?
	AND compras.tipocompra ='CREDITO' GROUP BY compras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ###########################

############################# FIN DE CLASE COMPRAS ###################################






























###################################### CLASE COTIZACIONES ##################################

######################### FUNCION REGISTRAR COTIZACIONES #######################
public function RegistrarCotizaciones()
{
	self::SetNames();
	if(empty($_POST["codespecialista"]) or empty($_POST["codpaciente"]) or empty($_POST["txtTotal"]))
	{
		echo "1";
		exit;
	}
	elseif(empty($_SESSION["CarritoCotizacion"]) || $_POST["txtTotal"]=="0.00")
	{
		echo "2";
		exit;
		
	}

	$fecha = date("Y-m-d H:i:s");

	####################################################################################
	#                                                                                  #
	#                               CREO CODIGO DE COTIZACION                          #
	#                                                                                  #
	####################################################################################
	
	####################### OBTENGO DATOS DE COTIZACION #######################
	$sql = "SELECT
	codcotizacion 
	FROM cotizaciones 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'  
	ORDER BY idcotizacion DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$cotizacion=$row["codcotizacion"];
	}
	####################### OBTENGO DATOS DE COTIZACION #######################
	
	####################### CREO CODIGO DE COTIZACION #######################
	if(empty($cotizacion))
	{
		$codcotizacion = "1";

	} else {

		$codcotizacion = $cotizacion + 1;
	}
	####################### CREO CODIGO DE COTIZACION #######################

    ####################################################################################
	#                                                                                  #
	#                               CREO CODIGO DE COTIZACION                          #
	#                                                                                  #
	####################################################################################

    ################################### REGISTRO LA COTIZACION ###################################
    $query = "INSERT INTO cotizaciones values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcotizacion);
	$stmt->bindParam(2, $codpaciente);
	$stmt->bindParam(3, $codespecialista);
	$stmt->bindParam(4, $subtotalivasi);
	$stmt->bindParam(5, $subtotalivano);
	$stmt->bindParam(6, $iva);
	$stmt->bindParam(7, $totaliva);
	$stmt->bindParam(8, $descontado);
	$stmt->bindParam(9, $descuento);
	$stmt->bindParam(10, $totaldescuento);
	$stmt->bindParam(11, $totalpago);
	$stmt->bindParam(12, $totalpago2);
	$stmt->bindParam(13, $fechacotizacion);
	$stmt->bindParam(14, $observaciones);
	$stmt->bindParam(15, $codigo);
	$stmt->bindParam(16, $codsucursal);
   
	$codpaciente = limpiar($_POST["codpaciente"]);
	$codespecialista = limpiar($_POST["codespecialista"]);
	$subtotalivasi = limpiar($_POST["txtgravado"]);
	$subtotalivano = limpiar($_POST["txtexento"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
    $fechacotizacion = limpiar($fecha);
    $observaciones = limpiar(isset($_POST['observaciones']) ? $_POST['observaciones'] : "");
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################################### REGISTRO LA COTIZACION ###################################

    $this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoCotizacion"];
	for($i=0;$i<count($detalle);$i++){

	################################### REGISTRO DETALLES DE COTIZACION ###################################
	$query = "INSERT INTO detalle_cotizaciones values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcotizacion);
	$stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codmarca);
    $stmt->bindParam(6, $codpresentacion);
    $stmt->bindParam(7, $codmedida);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $preciocompra);
	$stmt->bindParam(10, $precioventa);
	$stmt->bindParam(11, $ivaproducto);
	$stmt->bindParam(12, $descproducto);
	$stmt->bindParam(13, $valortotal);
	$stmt->bindParam(14, $totaldescuentov);
	$stmt->bindParam(15, $valorneto);
	$stmt->bindParam(16, $valorneto2);
	$stmt->bindParam(17, $tipodetalle);
	$stmt->bindParam(18, $codsucursal);
		
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codmarca = limpiar($detalle[$i]['codmarca']);
	$codpresentacion = limpiar($detalle[$i]['codpresentacion']);
	$codmedida = limpiar($detalle[$i]['codmedida']);
	$cantidad = limpiar($detalle[$i]['cantidad']);
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
	$tipodetalle = limpiar($detalle[$i]['busqueda']);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################################### REGISTRO DETALLES DE COTIZACION ###################################

    }

	####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoCotizacion"]);
    $this->dbh->commit();
    ################################### REGISTRO DETALLES DE FACTURA ###################################

	echo "<span class='fa fa-check-square-o'></span> LA COTIZACIÓN HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codcotizacion=".encrypt($codcotizacion)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOTIZACION")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR DOCUMENTO</strong></font color></a>";

	echo "<script>window.open('reportepdf?codcotizacion=".encrypt($codcotizacion)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOTIZACION")."', '_blank');</script>";
	exit;
}
######################### FUNCION REGISTRAR COTIZACIONES #########################

########################## FUNCION LISTAR COTIZACIONES ################################
public function ListarCotizaciones()
{
	self::SetNames();

if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalle_cotizaciones.cantventa) AS articulos 
	FROM (cotizaciones LEFT JOIN detalle_cotizaciones ON detalle_cotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	GROUP BY cotizaciones.idcotizacion ORDER BY cotizaciones.idcotizacion ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

 } else if($_SESSION["acceso"] == "cajero") {

	$sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva,
	cotizaciones.descontado, 
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalle_cotizaciones.cantventa) AS articulos 
	FROM (cotizaciones LEFT JOIN detalle_cotizaciones ON detalle_cotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE cotizaciones.codigo = '".limpiar($_SESSION["codigo"])."'
	AND cotizaciones.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY cotizaciones.idcotizacion ORDER BY cotizaciones.idcotizacion ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    } else if($_SESSION["acceso"] == "especialista") {

	$sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva,
	cotizaciones.descontado, 
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalle_cotizaciones.cantventa) AS articulos 
	FROM (cotizaciones LEFT JOIN detalle_cotizaciones ON detalle_cotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE cotizaciones.codespecialista = '".limpiar($_SESSION["codespecialista"])."'
	AND cotizaciones.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	GROUP BY cotizaciones.idcotizacion ORDER BY cotizaciones.idcotizacion ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

   } elseif ($_SESSION['acceso'] == "paciente") {

	$sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalle_cotizaciones.cantventa) AS articulos 
	FROM (cotizaciones LEFT JOIN detalle_cotizaciones ON detalle_cotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE cotizaciones.codpaciente = '".limpiar($_SESSION["codpaciente"])."' 
	GROUP BY cotizaciones.idcotizacion ORDER BY cotizaciones.idcotizacion ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

   } else {

   $sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal, 
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalle_cotizaciones.cantventa) AS articulos 
	FROM (cotizaciones LEFT JOIN detalle_cotizaciones ON detalle_cotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo 
	WHERE cotizaciones.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	GROUP BY cotizaciones.idcotizacion ORDER BY cotizaciones.idcotizacion ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
############################ FUNCION LISTAR COTIZACIONES ############################

############################ FUNCION ID COTIZACIONES #################################
public function CotizacionesPorId()
	{
	self::SetNames();
	$sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva,
	cotizaciones.descontado, 
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.tlfpaciente,
	pacientes.direcacompana,
	pacientes.estadopaciente,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3   
	FROM (cotizaciones INNER JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento 
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE cotizaciones.codcotizacion = ? AND cotizaciones.codsucursal = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcotizacion"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID COTIZACIONES #################################

########################### FUNCION VER DETALLES COTIZACIONES ##########################
public function VerDetallesCotizaciones()
	{
	self::SetNames();
	$sql = "SELECT
	detalle_cotizaciones.coddetallecotizacion,
	detalle_cotizaciones.codcotizacion,
	detalle_cotizaciones.idproducto,
	detalle_cotizaciones.codproducto,
	detalle_cotizaciones.producto,
	detalle_cotizaciones.cantventa,
	detalle_cotizaciones.preciocompra,
	detalle_cotizaciones.precioventa,
	detalle_cotizaciones.ivaproducto,
	detalle_cotizaciones.descproducto,
	detalle_cotizaciones.valortotal, 
	detalle_cotizaciones.totaldescuentov,
	detalle_cotizaciones.valorneto,
	detalle_cotizaciones.valorneto2,
	detalle_cotizaciones.tipodetalle,
	detalle_cotizaciones.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida
	FROM detalle_cotizaciones LEFT JOIN marcas ON detalle_cotizaciones.codmarca = marcas.codmarca
	LEFT JOIN presentaciones ON detalle_cotizaciones.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON detalle_cotizaciones.codmedida = medidas.codmedida
	WHERE detalle_cotizaciones.codcotizacion = ? AND detalle_cotizaciones.codsucursal = ? ORDER BY detalle_cotizaciones.coddetallecotizacion ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcotizacion"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
		return $this->p;
		$this->dbh=null;
}
############################ FUNCION VER DETALLES COTIZACIONES #######################

############################## FUNCION ACTUALIZAR COTIZACIONES #############################
public function ActualizarCotizaciones()
	{
	self::SetNames();
	if(empty($_POST["codsucursal"]) or empty($_POST["codcotizacion"]) or empty($_POST["codespecialista"]) or empty($_POST["codpaciente"]))
	{
		echo "1";
		exit;
	}


	####################### VERIFICO QUE NO EXISTAN CANTIDAD IGUAL A CERO #######################
	for($i=0;$i<count($_POST['coddetallecotizacion']);$i++){  //recorro el array
        if (!empty($_POST['coddetallecotizacion'][$i])) {

	        if($_POST['cantventa'][$i]==0){

		      echo "2";
		      exit();

	        }
        }
    }
    ####################### VERIFICO QUE NO EXISTAN CANTIDAD IGUAL A CERO #######################

    ############ OBTENGO DETALLE DE COTIZACION ##############
	$sql = "SELECT 
	iva,
	descuento,
	totalpago
	FROM cotizaciones 
	WHERE codcotizacion = '".limpiar(decrypt($_POST["codcotizacion"]))."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$ivabd = $row['iva'];
	$descuentobd = $row['descuento'];
	$totalpagobd = $row['totalpago'];
	############ OBTENGO DETALLE DE COTIZACION ##############

    $this->dbh->beginTransaction();

    for($i=0;$i<count($_POST['coddetallecotizacion']);$i++){  //recorro el array
	    if (!empty($_POST['coddetallecotizacion'][$i])) {

	############ OBTENGO CANTIDAD EN DETALLES ##############
	$sql = "SELECT cantventa FROM detalle_cotizaciones 
	WHERE coddetallecotizacion = '".limpiar(decrypt($_POST['coddetallecotizacion'][$i]))."' 
	AND codcotizacion = '".limpiar(decrypt($_POST["codcotizacion"]))."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
		
	$cantidadvendido = $row['cantventa'];
	############ OBTENGO CANTIDAD EN DETALLES ##############

		##################### ACTUALIZAMOS DETALLES DE COTIZACION ####################
		$query = "UPDATE detalle_cotizaciones set"
		." cantventa = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." coddetallecotizacion = ? AND codcotizacion = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantventa);
		$stmt->bindParam(2, $valortotal);
		$stmt->bindParam(3, $totaldescuento);
		$stmt->bindParam(4, $valorneto);
		$stmt->bindParam(5, $valorneto2);
		$stmt->bindParam(6, $coddetallecotizacion);
		$stmt->bindParam(7, $codcotizacion);
		$stmt->bindParam(8, $codsucursal);

		$cantventa = limpiar($_POST['cantventa'][$i]);
		$preciocompra = limpiar($_POST['preciocompra'][$i]);
		$precioventa = limpiar($_POST['precioventa'][$i]);
		$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
		$descuento = $_POST['descproducto'][$i]/100;
		$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
		$totaldescuento = number_format($_POST['totaldescuentov'][$i], 2, '.', '');
		$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
		$valorneto2 = number_format($_POST['valorneto2'][$i], 2, '.', '');
		$coddetallecotizacion = limpiar(decrypt($_POST['coddetallecotizacion'][$i]));
		$codcotizacion = limpiar(decrypt($_POST["codcotizacion"]));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
		##################### ACTUALIZAMOS DETALLES DE COTIZACION ####################

		
	        }
        }

        $this->dbh->commit();

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto FROM detalle_cotizaciones WHERE codcotizacion = '".limpiar(decrypt($_POST["codcotizacion"]))."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' AND ivaproducto = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto FROM detalle_cotizaciones WHERE codcotizacion = '".limpiar(decrypt($_POST["codcotizacion"]))."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' AND ivaproducto = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN COTIZACION ##############
		$sql = " UPDATE cotizaciones SET "
		." codpaciente = ?, "
		." codespecialista = ?, "
		." subtotalivasi = ?, "
		." subtotalivano = ?, "
		." totaliva = ?, "
		." descontado = ?, "
		." descuento = ?, "
		." totaldescuento = ?, "
		." totalpago = ?, "
		." totalpago2 = ?, "
		." observaciones = ? "
		." WHERE "
		." codcotizacion = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codpaciente);
		$stmt->bindParam(2, $codespecialista);
		$stmt->bindParam(3, $subtotalivasi);
		$stmt->bindParam(4, $subtotalivano);
		$stmt->bindParam(5, $totaliva);
		$stmt->bindParam(6, $descontado);
		$stmt->bindParam(7, $descuento);
		$stmt->bindParam(8, $totaldescuento);
		$stmt->bindParam(9, $totalpago);
		$stmt->bindParam(10, $totalpago2);
		$stmt->bindParam(11, $observaciones);
		$stmt->bindParam(12, $codcotizacion);
		$stmt->bindParam(13, $codsucursal);

		$codpaciente = limpiar($_POST["codpaciente"]);
		$codespecialista = limpiar($_POST["codespecialista"]);
		$iva = $_POST["iva"]/100;
		$totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
		$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
		$descuento = limpiar($_POST["descuento"]);
	    $txtDescuento = $_POST["descuento"]/100;
	    $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
	    $totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
	    $totalpago = number_format($total-$totaldescuento, 2, '.', '');
	    $totalpago2 = number_format($subtotalivasi+$subtotalivano, 2, '.', '');
        $observaciones = limpiar($_POST['observaciones']);
		$codcotizacion = limpiar(decrypt($_POST["codcotizacion"]));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN COTIZACION ##############

echo "<span class='fa fa-check-square-o'></span> LA COTIZACIÓN HA SIDO ACTUALIZADA EXITOSAMENTE <a href='reportepdf?codcotizacion=".encrypt($codcotizacion)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOTIZACION")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codcotizacion=".encrypt($codcotizacion)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FACTURACOTIZACION")."', '_blank');</script>";
	exit;
}
############################# FUNCION ACTUALIZAR COTIZACIONES #########################

########################## FUNCION ELIMINAR DETALLES COTIZACIONES ########################
public function EliminarDetalleCotizaciones()
    {
    self::SetNames();
	if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista") {

	$sql = "SELECT * FROM detalle_cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcotizacion"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		########## ELIMINAMOS EL DETALLE EN COTIZACION ###########
		$sql = "DELETE FROM detalle_cotizaciones WHERE coddetallecotizacion = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetallecotizacion);
		$stmt->bindParam(2,$codsucursal);
		$coddetallecotizacion = decrypt($_GET["coddetallecotizacion"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		########## ELIMINAMOS EL DETALLE EN COTIZACION ###########

	    ############ CONSULTO LOS TOTALES DE COTIZACION ##############
	    $sql2 = "SELECT iva, descuento FROM cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
	    $stmt = $this->dbh->prepare($sql2);
	    $stmt->execute(array(decrypt($_GET["codcotizacion"]),decrypt($_GET["codsucursal"])));
	    $num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$iva = $paea[0]["iva"]/100;
	    $descuento = $paea[0]["descuento"]/100;
	    ############ CONSULTO LOS TOTALES DE COTIZACION ##############

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto FROM detalle_cotizaciones WHERE codcotizacion = '".limpiar(decrypt($_GET["codcotizacion"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto FROM detalle_cotizaciones WHERE codcotizacion = '".limpiar(decrypt($_GET["codcotizacion"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN COTIZACION ##############
		$sql = " UPDATE cotizaciones SET "
		." subtotalivasi = ?, "
		." subtotalivano = ?, "
		." totaliva = ?, "
		." descontado = ?, "
		." totaldescuento = ?, "
		." totalpago = ?, "
		." totalpago2= ? "
		." WHERE "
		." codcotizacion = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasi);
		$stmt->bindParam(2, $subtotalivano);
		$stmt->bindParam(3, $totaliva);
		$stmt->bindParam(4, $descontadoc);
		$stmt->bindParam(5, $totaldescuento);
		$stmt->bindParam(6, $totalpago);
		$stmt->bindParam(7, $totalpago2);
		$stmt->bindParam(8, $codcotizacion);
		$stmt->bindParam(9, $codsucursal);

		$totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
		$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	    $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
	    $totaldescuento = number_format($total*$descuento, 2, '.', '');
	    $totalpago = number_format($total-$totaldescuento, 2, '.', '');
	    $totalpago2 = number_format($subtotalivasi+$subtotalivano, 2, '.', '');
		$codcotizacion = limpiar(decrypt($_GET["codcotizacion"]));
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN COTIZACION ##############

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
###################### FUNCION ELIMINAR DETALLES COTIZACIONES #######################

####################### FUNCION ELIMINAR COTIZACIONES #################################
public function EliminarCotizaciones()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista") {

		######################### ELIMINO COTIZACION #########################
		$sql = "DELETE FROM cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcotizacion);
		$stmt->bindParam(2,$codsucursal);
		$codcotizacion = decrypt($_GET["codcotizacion"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		######################### ELIMINO COTIZACION #########################

		########## ELIMINAMOS EL DETALLE EN COTIZACION ###########
		$sql = "DELETE FROM detalle_cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcotizacion);
		$stmt->bindParam(2,$codsucursal);
		$codcotizacion = decrypt($_GET["codcotizacion"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		########## ELIMINAMOS EL DETALLE EN COTIZACION ###########

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
######################### FUNCION ELIMINAR COTIZACIONES #################################

####################### FUNCION PROCESAR COTIZACIONES A VENTA #################################
public function ProcesarCotizaciones()
	{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;
		
	} else {
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
        $codarqueo = $row['codarqueo'];
        $codcaja = $row['codcaja'];
	}
	####################### VERIFICO ARQUEO DE CAJA #######################

	if(empty($_POST["codsucursal"]) or empty($_POST["tipodocumento"]) or empty($_POST["tipopago"]))
	{
		echo "2";
		exit;
	}
	elseif(limpiar($_POST["txtTotal"]=="") && limpiar($_POST["txtTotal"]==0) && limpiar($_POST["txtTotal"]==0.00))
	{
		echo "3";
		exit;
		
	}

	####################### SI LA FACTURACION ES A CREDITO #######################
	if($_POST["tipopago"]=="CREDITO"){

		$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));

		if (strtotime($fechavence) < strtotime($fechaactual)) {

			echo "4";
			exit;

		} else if($_POST["montoabono"] >= $_POST["txtTotal"]){

			echo "5";
			exit;
		} 
	}
	####################### SI LA FACTURACION ES A CREDITO ####################### 

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$sql = "SELECT * FROM detalle_cotizaciones WHERE codcotizacion = '".decrypt($_POST['codcotizacion'])."' 
	AND codsucursal = '".decrypt($_POST['codsucursal'])."'";
    	foreach ($this->dbh->query($sql) as $row2) {

    	if ($row2['tipodetalle'] == 2) {

	    $sql = "SELECT existencia FROM productos 
	    WHERE codproducto = '".limpiar($row2['codproducto'])."' 
	    AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	    foreach ($this->dbh->query($sql) as $row)
	    {
		$this->p[] = $row;
	    }
	
	    $existenciadb = $row['existencia'];
	    $cantidad = $row2['cantventa'];

	        if ($cantidad > $existenciadb) 
	        { 
		       echo "6";
		       exit;
	        }
	    }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

	$fecha = date("Y-m-d H:i:s");

	####################################################################################
	#                                                                                  #
	#                     CREO CODIGO DE VENTAS, SERIE Y AUTORIZACION                  #
	#                                                                                  #
	####################################################################################
	
    ####################### OBTENGO DATOS DE SUCURSAL #######################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal,
	inicioticket,
	inicionotaventa, 
	iniciofactura 
	FROM sucursales 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];
	$inicioticket = $row['inicioticket'];
	$inicionotaventa = $row['inicionotaventa'];
	$iniciofactura = $row['iniciofactura'];
	$secuencia = "SI";
	####################### OBTENGO DATOS DE SUCURSAL #######################
	
	####################### OBTENGO DATOS DE VENTA #######################
	$sql = "SELECT
	codventa, 
	codfactura 
	FROM ventas 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'  
	ORDER BY idventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$venta=$row["codventa"];
		$factura=$row["codfactura"];

	}
	####################### OBTENGO DATOS DE VENTA #######################
	
	####################### CREO CODIGO DE VENTA #######################
	if(empty($venta))
	{
		$codventa = "1";
        $codfactura = $nroactividad.'-'.$inicioticket;
		$codserie = $nroactividad;
		$codautorizacion = limpiar(GenerateRandomStringg());

	} else {

		$var = strlen($nroactividad."-");
        $var1 = substr($factura , $var);
        $var2 = strlen($var1);
        $var3 = $var1 + 1;
        $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);

        $codventa = $venta + 1;
        $codfactura = $nroactividad.'-'.$var4;
		$codserie = $nroactividad;
		$codautorizacion = limpiar(GenerateRandomStringg());
	}
	####################### CREO CODIGO DE VENTA #######################

    ####################################################################################
	#                                                                                  #
	#                     CREO CODIGO DE VENTAS, SERIE Y AUTORIZACION                  #
	#                                                                                  #
	####################################################################################

	################### SELECCIONE LOS DATOS DE LA COTIZACION ######################
    $sql = "SELECT * FROM cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST['codcotizacion']),decrypt($_POST['codsucursal'])));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    ################### SELECCIONE LOS DATOS DE LA COTIZACION ######################

    ################################### REGISTRO LA FACTURA ###################################
    $query = "INSERT INTO ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $tipodocumento);
	$stmt->bindParam(2, $codcaja);
	$stmt->bindParam(3, $codventa);
	$stmt->bindParam(4, $codfactura);
	$stmt->bindParam(5, $codserie);
	$stmt->bindParam(6, $codautorizacion);
	$stmt->bindParam(7, $codpaciente);
	$stmt->bindParam(8, $codespecialista);
	$stmt->bindParam(9, $subtotalivasi);
	$stmt->bindParam(10, $subtotalivano);
	$stmt->bindParam(11, $iva);
	$stmt->bindParam(12, $totaliva);
	$stmt->bindParam(13, $descontado);
	$stmt->bindParam(14, $descuento);
	$stmt->bindParam(15, $totaldescuento);
	$stmt->bindParam(16, $totalpago);
	$stmt->bindParam(17, $totalpago2);
	$stmt->bindParam(18, $tipopago);
	$stmt->bindParam(19, $formapago);
	$stmt->bindParam(20, $montopagado);
	$stmt->bindParam(21, $montodevuelto);
	$stmt->bindParam(22, $creditopagado);
	$stmt->bindParam(23, $fechavencecredito);
	$stmt->bindParam(24, $fechapagado);
	$stmt->bindParam(25, $statusventa);
	$stmt->bindParam(26, $fechaventa);
	$stmt->bindParam(27, $observaciones);
	$stmt->bindParam(28, $codigo);
	$stmt->bindParam(29, $codsucursal);
	$stmt->bindParam(30, $bandera);
	$stmt->bindParam(31, $docelectronico);
    
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	//$codcaja = limpiar($_POST["codcaja"]);
	$codpaciente = limpiar($_POST["codpaciente"]);
	$codespecialista = limpiar($row["codespecialista"]);
	$subtotalivasi = limpiar($row["subtotalivasi"]);
	$subtotalivano = limpiar($row["subtotalivano"]);
	$iva = limpiar($row["iva"]);
	$totaliva = limpiar($row["totaliva"]);
	$descontado = limpiar($row["descontado"]);
	$descuento = limpiar($row["descuento"]);
	$totaldescuento = limpiar($row["totaldescuento"]);
	$totalpago = limpiar($row["totalpago"]);
	$totalpago2 = limpiar($row["totalpago2"]);
	$tipopago = limpiar($_POST["tipopago"]);
	$formapago = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["formapago"] : "CREDITO");
	$montopagado = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["montopagado"] : "0.00");
	$montodevuelto = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["montodevuelto"] : "0.00");
	$creditopagado = limpiar(isset($_POST['montoabono']) ? $_POST['montoabono'] : "0.00");
	$fechavencecredito = limpiar($_POST["tipopago"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
	$fechapagado = limpiar("0000-00-00");
	$statusventa = limpiar($_POST["tipopago"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
    $fechaventa = limpiar($fecha);
    $observaciones = limpiar($_POST['observaciones']);
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$bandera = limpiar("0");
	$docelectronico = limpiar("0");
	$stmt->execute();

	################### SELECCIONO DETALLES DE LA COTIZACION ######################
	$sql = "SELECT * FROM detalle_cotizaciones 
	WHERE codcotizacion = '".decrypt($_POST['codcotizacion'])."' 
	AND codsucursal = '".decrypt($_POST['codsucursal'])."'";
    foreach ($this->dbh->query($sql) as $row2)
	{

    ############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################
	if ($row2['tipodetalle'] == 2) {
	$sql = "SELECT existencia FROM productos 
	WHERE codproducto = '".limpiar($row2['codproducto'])."' 
	AND codsucursal = '".limpiar(decrypt($_POST['codsucursal']))."'";
	foreach ($this->dbh->query($sql) as $row3)
	{
	$this->p[] = $row3;
	}
	$existenciabd = $row3['existencia'];
    }
	############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################

    ################################### REGISTRO DETALLES DE VENTAS ###################################
    $query = "INSERT INTO detalle_ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
    $stmt = $this->dbh->prepare($query);
    $stmt->bindParam(1, $codventa);
    $stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codmarca);
    $stmt->bindParam(6, $codpresentacion);
    $stmt->bindParam(7, $codmedida);
    $stmt->bindParam(8, $cantidad);
    $stmt->bindParam(9, $preciocompra);
    $stmt->bindParam(10, $precioventa);
    $stmt->bindParam(11, $ivaproducto);
    $stmt->bindParam(12, $descproducto);
    $stmt->bindParam(13, $valortotal);
    $stmt->bindParam(14, $totaldescuentov);
    $stmt->bindParam(15, $valorneto);
    $stmt->bindParam(16, $valorneto2);
    $stmt->bindParam(17, $tipodetalle);
    $stmt->bindParam(18, $codsucursal);

    $idproducto = limpiar($row2['idproducto']);
	$codproducto = limpiar($row2['codproducto']);
	$producto = limpiar($row2['producto']);
	$codmarca = limpiar($row2['codmarca']);
	$codpresentacion = limpiar($row2['codpresentacion']);
	$codmedida = limpiar($row2['codmedida']);
	$cantidad = limpiar($row2['cantventa']);
	$preciocompra = limpiar($row2['preciocompra']);
	$precioventa = limpiar($row2['precioventa']);
	$ivaproducto = limpiar($row2['ivaproducto']);
	$descproducto = limpiar($row2['descproducto']);
	$descuento = $row2['descproducto']/100;
	$valortotal = number_format($row2['valortotal'], 2, '.', '');
	$totaldescuentov = number_format($row2['totaldescuentov'], 2, '.', '');
	$valorneto = number_format($row2['valorneto'], 2, '.', '');
	$valorneto2 = number_format($row2['valorneto2'], 2, '.', '');
	$tipodetalle = limpiar($row2['tipodetalle']);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################################### REGISTRO DETALLES DE VENTAS ###################################

    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
	$sql = " UPDATE productos set "
	." existencia = ? "
	." where "
	." codproducto = '".limpiar($row2['codproducto'])."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$cantventa = limpiar($row2['cantventa']);
	$existencia = isset($existenciabd) ? $existenciabd-$cantventa : "0";
	$stmt->execute();
	##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

    ############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###############
	$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codventa);
	$stmt->bindParam(2, $codpaciente);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);
	$stmt->bindParam(14, $tipokardex);		
	$stmt->bindParam(15, $codsucursal);

	$codpaciente = limpiar($_POST["codpaciente"]);
	$codproducto = limpiar($row2['codproducto']);
	$movimiento = limpiar("SALIDAS");
	$entradas = limpiar("0");
	$salidas= limpiar($row2['cantventa']);
	$devolucion = limpiar("0");
	$stockactual = limpiar(isset($existenciabd) ? $existenciabd-$row2['cantventa'] : "0");
	$precio = limpiar($row2["precioventa"]);
	$ivaproducto = limpiar($row2['ivaproducto']);
	$descproducto = limpiar($row2['descproducto']);
	$documento = limpiar("VENTA: ".$codventa);
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar($row2['tipodetalle']);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();

	}
	################### SELECCIONO DETALLES DE LA COTIZACION ######################

	###################### OBTENGO DATOS DE ARQUEO ######################
	$sql = "SELECT
	arqueocaja.codarqueo,
	arqueocaja.codcaja,
	arqueocaja.efectivo, 
	arqueocaja.cheque, 
	arqueocaja.tcredito, 
	arqueocaja.tdebito, 
	arqueocaja.tprepago, 
	arqueocaja.transferencia, 
	arqueocaja.electronico,
	arqueocaja.cupon, 
	arqueocaja.otros,
	arqueocaja.creditos,
	arqueocaja.nroticket,
	arqueocaja.nronotaventa,
	arqueocaja.nrofactura
	FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE arqueocaja.codarqueo = '".limpiar($codarqueo)."'
	AND arqueocaja.statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$codarqueo = $row['codarqueo'];
	$codcaja = $row['codcaja'];
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
	$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
	$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
	$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
	$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
	$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
	$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
	$otros = ($row['otros']== "" ? "0.00" : $row['otros']);
	$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
	$nroticket = $row['nroticket'];
	$nronotaventa = $row['nronotaventa'];
	$nrofactura = $row['nrofactura'];
	###################### OBTENGO DATOS DE ARQUEO ######################

	###################### TIPO DE PAGO CONTADO ######################
	if (limpiar($_POST["tipopago"]=="CONTADO")){

		########################## PROCESO LA FORMA DE PAGO #################################
		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ?, "
		." nroticket = ?, "
		." nronotaventa = ?, "
		." nrofactura = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $NumTicket);
		$stmt->bindParam(11, $NumNotaVenta);
		$stmt->bindParam(12, $NumFactura);
		$stmt->bindParam(13, $codarqueo);

	$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo+$_POST["txtTotal"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque+$_POST["txtTotal"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["txtTotal"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["txtTotal"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["txtTotal"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["txtTotal"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["txtTotal"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon+$_POST["txtTotal"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros+$_POST["txtTotal"], 2, '.', '') : $otros);
	
	    $NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	    $NumNotaVenta = limpiar($_POST["tipodocumento"] == "NOTAVENTA" ? $nronotaventa+1 : $nronotaventa);
	    $NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
		$stmt->execute();
	    ########################## PROCESO LA FORMA DE PAGO #################################
	}
	###################### TIPO DE PAGO CONTADO ######################


	###################### TIPO DE PAGO CREDITO ######################
	if (limpiar($_POST["tipopago"]=="CREDITO")){

		########################## PROCESO LA FORMA DE PAGO #################################
		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ?, "
		." creditos = ?, "
		." nroticket = ?, "
		." nronotaventa = ?, "
		." nrofactura = ? "
		." WHERE "
		." codarqueo = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $txtCredito);
		$stmt->bindParam(11, $NumTicket);
		$stmt->bindParam(12, $NumNotaVenta);
		$stmt->bindParam(13, $NumFactura);
		$stmt->bindParam(14, $codarqueo);

	$txtEfectivo = limpiar($_POST["medioabono"] == "EFECTIVO" ? number_format($efectivo+$_POST["montoabono"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["medioabono"] == "CHEQUE" ? number_format($cheque+$_POST["montoabono"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["medioabono"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montoabono"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["medioabono"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montoabono"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["medioabono"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montoabono"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["medioabono"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montoabono"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["medioabono"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montoabono"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["medioabono"] == "CUPON" ? number_format($cupon+$_POST["montoabono"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["medioabono"] == "OTROS" ? number_format($otros+$_POST["montoabono"], 2, '.', '') : $otros);
	$txtCredito = number_format($credito+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
	
	    $NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	    $NumNotaVenta = limpiar($_POST["tipodocumento"] == "NOTAVENTA" ? $nronotaventa+1 : $nronotaventa);
	    $NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
		$stmt->execute();
	    ########################## PROCESO LA FORMA DE PAGO #################################


	    ########################## SUMO TOTAL A PACIENTE EN CREDITO #################################
	    $sql = "SELECT codpaciente FROM creditosxpacientes WHERE codpaciente = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codpaciente"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO creditosxpacientes values (null, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codpaciente);
			$stmt->bindParam(2, $montocredito);
			$stmt->bindParam(3, $codsucursal);

			$codpaciente = limpiar($_POST["codpaciente"]);
			$montocredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();

		} else { 

			$sql = "UPDATE creditosxpacientes set"
			." montocredito = ? "
			." where "
			." codpaciente = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $montocredito);
			$stmt->bindParam(2, $codpaciente);
			$stmt->bindParam(3, $codsucursal);

			$montocredito = number_format($montoactual+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
			$codpaciente = limpiar($_POST["codpaciente"]);
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();
		}
		########################## SUMO TOTAL A PACIENTE EN CREDITO #################################

        ########################## EN CASO DE DAR ABONO DE CREDITO #################################
	    if (limpiar($_POST["montoabono"]!="0.00" && $_POST["montoabono"]!="0" && $_POST["montoabono"]!="")) {

		$query = "INSERT INTO abonoscreditosventas values (null, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $codventa);
		$stmt->bindParam(3, $codpaciente);
		$stmt->bindParam(4, $medioabono);
		$stmt->bindParam(5, $montoabono);
		$stmt->bindParam(6, $fechaabono);
		$stmt->bindParam(7, $codsucursal);

		$codpaciente = limpiar($_POST["codpaciente"]);
		$medioabono = limpiar($_POST["medioabono"]);
		$montoabono = limpiar($_POST["montoabono"]);
		$fechaabono = limpiar(date("Y-m-d H:i:s"));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

	    }
	    ########################## EN CASO DE DAR ABONO DE CREDITO #################################

	}
	###################### TIPO DE PAGO CREDITO ######################
	
	####################### ELIMINO LA COTIZACION #######################
	$sql = "DELETE FROM cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codcotizacion);
	$stmt->bindParam(2,$codsucursal);
	$codcotizacion = decrypt($_POST["codcotizacion"]);
	$codsucursal = decrypt($_POST["codsucursal"]);
	$stmt->execute();
	####################### ELIMINO LA COTIZACION #######################

	####################### ELIMINO DETALLES DE COTIZACION #######################
	$sql = "DELETE FROM detalle_cotizaciones WHERE codcotizacion = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(1,$codcotizacion);
	$stmt->bindParam(2,$codsucursal);
	$codcotizacion = decrypt($_POST["codcotizacion"]);
	$codsucursal = decrypt($_POST["codsucursal"]);
	$stmt->execute();
	####################### ELIMINO DETALLES DE COTIZACION #######################

	echo "<span class='fa fa-check-square-o'></span> LA COTIZACION HA SIDO PROCESADA COMO FACTURACION EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR DOCUMENTO</strong></font color></a>";

	echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
###################### FUNCION PROCESAR COTIZACIONES A VENTAS #################################

###################### FUNCION BUSQUEDA COTIZACIONES POR FECHAS ###########################
public function BuscarCotizacionesxFechas() 
{
	self::SetNames();

	if($_SESSION["acceso"] == "especialista") {

	$sql ="SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.tlfpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_cotizaciones.cantventa) as articulos
    FROM (cotizaciones LEFT JOIN detalle_cotizaciones ON detalle_cotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE cotizaciones.codespecialista = ?
	AND cotizaciones.codsucursal = ? 
	AND DATE_FORMAT(cotizaciones.fechacotizacion,'%Y-%m-%d') BETWEEN ? AND ?
	GROUP BY detalle_cotizaciones.codcotizacion";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

	} else {

	$sql ="SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.tlfpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_cotizaciones.cantventa) as articulos
    FROM (cotizaciones LEFT JOIN detalle_cotizaciones ON detalle_cotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE cotizaciones.codsucursal = ? 
	AND DATE_FORMAT(cotizaciones.fechacotizacion,'%Y-%m-%d') BETWEEN ? AND ?
	GROUP BY detalle_cotizaciones.codcotizacion";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

	}
}
###################### FUNCION BUSQUEDA COTIZACIONES POR FECHAS ###########################

###################### FUNCION BUSQUEDA COTIZACIONES POR ESPECIALISTA ###########################
public function BuscarCotizacionesxEspecialista() 
{
	self::SetNames();
	$sql ="SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva,
	cotizaciones.descontado, 
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.tlfpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_cotizaciones.cantventa) as articulos
    FROM (cotizaciones LEFT JOIN detalle_cotizaciones ON detalle_cotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE cotizaciones.codsucursal = ?
	AND cotizaciones.codespecialista = ? 
	GROUP BY detalle_cotizaciones.codcotizacion";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['codespecialista']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA COTIZACIONES POR ESPECIALISTA ###########################

###################### FUNCION BUSQUEDA COTIZACIONES POR PACIENTE ###########################
public function BuscarCotizacionesxPaciente() 
{
	self::SetNames();

	if($_SESSION["acceso"] == "especialista") {

	$sql ="SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva,
	cotizaciones.descontado, 
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_cotizaciones.cantventa) as articulos
    FROM (cotizaciones LEFT JOIN detalle_cotizaciones ON detalle_cotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE cotizaciones.codespecialista = ?
	AND cotizaciones.codsucursal = ?
	AND cotizaciones.codpaciente = ? 
	GROUP BY detalle_cotizaciones.codcotizacion";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim($_GET['codpaciente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
   
    } else {

   	$sql ="SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codpaciente, 
	cotizaciones.codespecialista,
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva,
	cotizaciones.descontado, 
	cotizaciones.descuento, 
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.fechacotizacion,
	cotizaciones.observaciones,
	cotizaciones.codigo,   
	cotizaciones.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_cotizaciones.cantventa) as articulos
    FROM (cotizaciones LEFT JOIN detalle_cotizaciones ON detalle_cotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON cotizaciones.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON cotizaciones.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE cotizaciones.codsucursal = ?
	AND cotizaciones.codpaciente = ? 
	GROUP BY detalle_cotizaciones.codcotizacion";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['codpaciente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
    }
}
###################### FUNCION BUSQUEDA COTIZACIONES POR PACIENTE ###########################

###################### FUNCION BUSCAR PRODUCTOS COTIZADOS #########################
public function BuscarProductosCotizados() 
	{
	self::SetNames();
   $sql ="SELECT 
   detalle_cotizaciones.idproducto,
   detalle_cotizaciones.codproducto,
   detalle_cotizaciones.producto,
   detalle_cotizaciones.codmarca,
   detalle_cotizaciones.codpresentacion,
   detalle_cotizaciones.codmedida,
   detalle_cotizaciones.preciocompra,
   detalle_cotizaciones.precioventa,  
   detalle_cotizaciones.ivaproducto,
   detalle_cotizaciones.descproducto,
   detalle_cotizaciones.tipodetalle,
   productos.existencia,
   servicios.codservicio,
   marcas.nommarca,
   presentaciones.nompresentacion,
   medidas.nommedida, 
   cotizaciones.fechacotizacion,
   sucursales.documsucursal, 
   sucursales.cuitsucursal, 
   sucursales.nomsucursal,
   sucursales.documencargado,
   sucursales.dniencargado,
   sucursales.nomencargado,
   sucursales.tlfsucursal,
   sucursales.direcsucursal,
   sucursales.correosucursal,
   sucursales.llevacontabilidad,
   sucursales.codmoneda,
   sucursales.codmoneda2,
   tiposmoneda.moneda,
   tiposmoneda.siglas,
   tiposmoneda.simbolo,
   tiposmoneda2.moneda AS moneda2,
   tiposmoneda2.siglas AS siglas2,
   tiposmoneda2.simbolo AS simbolo2,
   tiposcambio.codcambio,
   tiposcambio.montocambio,
   usuarios.dni,
   usuarios.nombres, 
   SUM(detalle_cotizaciones.cantventa) as cantidad 
   FROM (cotizaciones INNER JOIN detalle_cotizaciones ON cotizaciones.codcotizacion = detalle_cotizaciones.codcotizacion)
   LEFT JOIN productos ON detalle_cotizaciones.idproducto = productos.idproducto 
   LEFT JOIN servicios ON detalle_cotizaciones.idproducto = servicios.idservicio
   LEFT JOIN marcas ON detalle_cotizaciones.codmarca = marcas.codmarca
   LEFT JOIN presentaciones ON detalle_cotizaciones.codpresentacion = presentaciones.codpresentacion 
   LEFT JOIN medidas ON detalle_cotizaciones.codmedida = medidas.codmedida
   LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal
   LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
   LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
   LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
   LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
   LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
   LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
   LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
   LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo 
   WHERE cotizaciones.codsucursal = '".decrypt($_GET['codsucursal'])."' 
   AND DATE_FORMAT(cotizaciones.fechacotizacion,'%Y-%m-%d') BETWEEN ? AND ? 
   GROUP BY detalle_cotizaciones.codproducto, detalle_cotizaciones.precioventa, detalle_cotizaciones.descproducto 
   ORDER BY detalle_cotizaciones.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	    echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION PRODUCTOS COTIZADOS ###############################

###################### FUNCION BUSCAR PRODUCTOS COTIZADOS POR VENDEDOR #########################
public function BuscarCotizacionesxVendedor() 
	{
   self::SetNames();
   $sql ="SELECT 
   detalle_cotizaciones.idproducto,
   detalle_cotizaciones.codproducto,
   detalle_cotizaciones.producto,
   detalle_cotizaciones.codmarca,
   detalle_cotizaciones.codpresentacion,
   detalle_cotizaciones.codmedida,
   detalle_cotizaciones.preciocompra,
   detalle_cotizaciones.precioventa,  
   detalle_cotizaciones.ivaproducto,
   detalle_cotizaciones.descproducto,
   detalle_cotizaciones.tipodetalle,
   productos.existencia,
   servicios.codservicio,
   marcas.nommarca,
   presentaciones.nompresentacion,
   medidas.nommedida, 
   cotizaciones.fechacotizacion,
   sucursales.documsucursal, 
   sucursales.cuitsucursal, 
   sucursales.nomsucursal,
   sucursales.documencargado,
   sucursales.dniencargado,
   sucursales.nomencargado,
   sucursales.tlfsucursal,
   sucursales.direcsucursal,
   sucursales.correosucursal,
   sucursales.llevacontabilidad,
   sucursales.codmoneda,
   sucursales.codmoneda2,
   tiposmoneda.moneda,
   tiposmoneda.siglas,
   tiposmoneda.simbolo,
   tiposmoneda2.moneda AS moneda2,
   tiposmoneda2.siglas AS siglas2,
   tiposmoneda2.simbolo AS simbolo2,
   tiposcambio.codcambio,
   tiposcambio.montocambio,
   usuarios.dni,
   usuarios.nombres, 
   SUM(detalle_cotizaciones.cantventa) as cantidad 
   FROM (cotizaciones INNER JOIN detalle_cotizaciones ON cotizaciones.codcotizacion = detalle_cotizaciones.codcotizacion)
   LEFT JOIN productos ON detalle_cotizaciones.idproducto = productos.idproducto 
   LEFT JOIN servicios ON detalle_cotizaciones.idproducto = servicios.idservicio
   LEFT JOIN marcas ON detalle_cotizaciones.codmarca = marcas.codmarca
   LEFT JOIN presentaciones ON detalle_cotizaciones.codpresentacion = presentaciones.codpresentacion 
   LEFT JOIN medidas ON detalle_cotizaciones.codmedida = medidas.codmedida
   LEFT JOIN sucursales ON cotizaciones.codsucursal = sucursales.codsucursal
   LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
   LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
   LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
   LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
   LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
   LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
   LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
   LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo 
   WHERE cotizaciones.codsucursal = '".decrypt($_GET['codsucursal'])."'
   AND cotizaciones.codigo = ? 
   AND DATE_FORMAT(cotizaciones.fechacotizacion,'%Y-%m-%d') BETWEEN ? AND ? 
   GROUP BY detalle_cotizaciones.codproducto, detalle_cotizaciones.precioventa, detalle_cotizaciones.descproducto 
   ORDER BY detalle_cotizaciones.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	    echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION PRODUCTOS COTIZADOS POR VENDEDOR ###############################

###################################### CLASE COTIZACIONES ##################################

































###################################### CLASE CITAS #####################################

############################ FUNCION BUSCAR CITAS EN CALENDARIO ################################
public function BuscarCitas()
	{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente,
	citas.descripcion,
	citas.codsucursal, 
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color, 
	citas.statuscita,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	CONCAT(pacientes.pnompaciente, ' ',pacientes.papepaciente) as nompaciente,
	CONCAT(pacientes.cedpaciente, ': ',pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente), ' ',pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as pacientes,
	sucursales.cuitsucursal,
	sucursales.nomsucursal
	FROM citas 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal";

	} elseif ($_SESSION['acceso'] == "especialista") {

	$sql = "SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente,
	citas.descripcion,
	citas.codsucursal, 
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	CONCAT(pacientes.pnompaciente, ' ',pacientes.papepaciente) as nompaciente,
	CONCAT(pacientes.cedpaciente, ': ',pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente), ' ',pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as pacientes,
	sucursales.cuitsucursal,
	sucursales.nomsucursal
	FROM citas 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal
	WHERE citas.codespecialista = '".limpiar($_SESSION["codespecialista"])."'";

	} elseif ($_SESSION['acceso'] == "paciente") {

	$sql = "SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente,
	citas.descripcion,
	citas.codsucursal, 
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	CONCAT(pacientes.pnompaciente, ' ',pacientes.papepaciente) as nompaciente,
	CONCAT(pacientes.cedpaciente, ': ',pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente), ' ',pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as pacientes,
	sucursales.cuitsucursal,
	sucursales.nomsucursal
	FROM citas 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal
	WHERE citas.codpaciente = '".limpiar($_SESSION["codpaciente"])."'";

	} else {

	$sql = "SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente,
	citas.descripcion,
	citas.codsucursal, 
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	CONCAT(pacientes.pnompaciente, ' ',pacientes.papepaciente) as nompaciente,
	CONCAT(pacientes.cedpaciente, ': ',pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente), ' ',pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as pacientes,
	sucursales.cuitsucursal,
	sucursales.nomsucursal
	FROM citas 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal
	WHERE citas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";

    }

	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {
		
	      echo "";

	} else {

		while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION BUSCAR CITAS EN CALENDARIO #############################

####################### FUNCION REGISTRAR CITAS ################################
public function RegistrarCitas()
	{
		self::SetNames();
		if(empty($_POST["codpaciente"]) or empty($_POST["codespecialista"]) or empty($_POST["descripcion"]) or empty($_POST["color"]) or empty($_POST["fechacita"]) or empty($_POST["horacita"]))
		{
			echo "1";
			exit;
		}
		
		$hora_cita = strtotime($_POST['horacita']); //hora cita
		$hora_actual = strtotime(date("H:i")); //hora actual h:i:s
		$fecha_cita = date("Y-m-d",strtotime($_POST['fechacita'])); //fechacita
		$fecha_actual = date("Y-m-d"); //fechaactual

	    if (strtotime($fecha_cita) < strtotime($fecha_actual)) {
	  
	     echo "2";
		 exit;
	  
	    } else if ((strtotime($fecha_cita) == strtotime($fecha_actual)) && ($hora_cita < $hora_actual)){
	  
	     echo "3";
		 exit;
	  
	    } else {
		
		############################# CODIGO DE CITA #############################
	    $sql = "SELECT codcita FROM citas ORDER BY idcita DESC LIMIT 1";
		foreach ($this->dbh->query($sql) as $row){

			$id=$row["codcita"];

		}
		if(empty($id))
		{
			$codcita = '01';

		} else {

			$resto = substr($id, 0, 1);
			$coun = strlen($resto);
			$num     = substr($id, $coun);
			$codigo     = $num + 1;
			$codcita = "0".$codigo;
		}
		############################# CODIGO DE CITA #############################

		$especialista = ($_SESSION["acceso"] == "paciente" ? limpiar($_POST['codespecialista']) : limpiar(decrypt($_POST["codespecialista"])));
		$sucursal = ($_SESSION["acceso"] == "paciente" ? limpiar(decrypt($_POST['codsucursal'])) : limpiar($_SESSION['codsucursal']));

		$sql = "SELECT * FROM citas WHERE codespecialista = ? AND fechacita = ? AND horacita = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($especialista, date("Y-m-d",strtotime($_POST['fechacita'])), date("H:i",strtotime($_POST['horacita'])), $sucursal));
		$num = $stmt->rowCount();
		if($num == 0)
		{
		$query = "INSERT INTO citas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcita);
		$stmt->bindParam(2, $codespecialista);
		$stmt->bindParam(3, $codpaciente);
		$stmt->bindParam(4, $descripcion);
		$stmt->bindParam(5, $fechacita);
		$stmt->bindParam(6, $horacita);
		$stmt->bindParam(7, $color);
		$stmt->bindParam(8, $statuscita);
		$stmt->bindParam(9, $codigo);
		$stmt->bindParam(10, $codsucursal);
		$stmt->bindParam(11, $ingresocita);
		
		$codespecialista = ($_SESSION["acceso"] == "paciente" ? limpiar($_POST['codespecialista']) : limpiar(decrypt($_POST["codespecialista"])));
		$codpaciente = limpiar($_POST["codpaciente"]);
		$descripcion = limpiar($_POST["descripcion"]);
		$fechacita = limpiar(date("Y-m-d",strtotime($_POST['fechacita'])));
		$horacita = limpiar(date("H:i",strtotime($_POST['horacita'])));
		$color = limpiar($_POST["color"]);
		$statuscita = limpiar('EN PROCESO');
		$codigo = limpiar($_SESSION["codigo"]);
		$codsucursal = ($_SESSION["acceso"] == "paciente" ? decrypt($_POST['codsucursal']) : $_SESSION['codsucursal']);
		$ingresocita = limpiar(date('Y-m-d'));
		$stmt->execute();
		
			echo "<span class='fa fa-check-circle'></span> LA CITA PARA ODONTOLOGIA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;
		}
		else
		{
		  echo "4";
		  exit;
	    }
	}  
}
############################ FUNCION REGISTRAR CITAS ###########################

########################## FUNCION BUSQUEDA DE CITAS ###############################
public function BusquedaCitas()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    $sql = "SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente, 
	citas.descripcion,
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	citas.codsucursal,
	citas.ingresocita,
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente), ' ',pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as pacientes,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	usuarios.dni,
	usuarios.nombres
	FROM citas 
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN usuarios ON citas.codigo = usuarios.codigo
	WHERE
    (pacientes.codpaciente = '".$buscar."')
    OR 
    (pacientes.cedpaciente = '".$buscar."')
    OR 
    (pacientes.pnompaciente = '".$buscar."')
    OR
    (pacientes.snompaciente = '".$buscar."')
    OR 
    (pacientes.papepaciente = '".$buscar."') 
    OR 
    (pacientes.sapepaciente = '".$buscar."')
    OR 
    (citas.descripcion = '".$buscar."')
    OR 
    (citas.fechacita = '".$buscar."') 
    OR 
    (citas.horacita = '".$buscar."') 
    OR 
    (especialistas.cedespecialista = '".$buscar."') 
    OR 
    especialistas.nomespecialista = '".$buscar."') LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
   
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE CITAS ###############################

############################ FUNCION LISTAR CITAS ################################
public function ListarCitas()
	{
	self::SetNames();

	if($_SESSION["acceso"] == "especialista") {

	$sql = "SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente, 
	citas.descripcion,
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	citas.codsucursal,
	citas.ingresocita,
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.especialidad,
	especialistas2.cedespecialista AS cedespecialista2, 
	especialistas2.nomespecialista AS nomespecialista2,
	especialistas2.especialidad AS especialidad2,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente), ' ',pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as pacientes,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	usuarios.dni,
	usuarios.nombres
	FROM citas 
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN usuarios ON citas.codigo = usuarios.codigo
	LEFT JOIN especialistas AS especialistas2 ON citas.codigo = especialistas2.codespecialista
	WHERE citas.codespecialista = '".limpiar($_SESSION["codespecialista"])."' 
	AND citas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	ORDER BY citas.fechacita DESC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

		echo "";

	} else {

		while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
    } else {

	$sql = "SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente, 
	citas.descripcion,
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	citas.codsucursal,
	citas.ingresocita,
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.especialidad,
	especialistas2.cedespecialista AS cedespecialista2, 
	especialistas2.nomespecialista AS nomespecialista2,
	especialistas2.especialidad AS especialidad2,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente), ' ',pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as pacientes,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	usuarios.dni,
	usuarios.nombres
	FROM citas 
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN usuarios ON citas.codigo = usuarios.codigo
	LEFT JOIN especialistas AS especialistas2 ON citas.codigo = especialistas2.codespecialista
	ORDER BY citas.fechacita DESC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

		echo "";

	} else {

		while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
    }
}
######################### FUNCION LISTAR CITAS #############################

########################### FUNCION ID CITAS ################################
public function CitasPorId()
{
	self::SetNames();
	$sql ="SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente, 
	citas.descripcion,
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	citas.codsucursal,
	citas.ingresocita, 
	especialistas.tpespecialista, 
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.tlfespecialista, 
	especialistas.sexoespecialista, 
	especialistas.correoespecialista, 
	especialistas.especialidad,
	especialistas2.cedespecialista AS cedespecialista2, 
	especialistas2.nomespecialista AS nomespecialista2,
	especialistas2.especialidad AS especialidad2, 
	pacientes.documpaciente,
	pacientes.cedpaciente,
	pacientes.pnompaciente,
	pacientes.snompaciente,
	pacientes.papepaciente,
	pacientes.sapepaciente,
	pacientes.fnacpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	usuarios.dni,
	usuarios.nombres
	FROM citas 
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN usuarios ON citas.codigo = usuarios.codigo
	LEFT JOIN especialistas AS especialistas2 ON citas.codigo = especialistas2.codespecialista 
	WHERE citas.codcita = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcita"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
################################ FUNCION ID CITAS ################################

################################ FUNCION PARA ACTUALIZAR CITAS #################################
public function ActualizarCitas()
	{
	self::SetNames();
	if(empty($_POST["codcita"]) or empty($_POST["codpaciente"]) or empty($_POST["codespecialista"]) or empty($_POST["descripcion"]) or empty($_POST["color"]) or empty($_POST["fechacita"]) or empty($_POST["horacita"]))
	{
		echo "1";
		exit;
	}
		
	$hora_cita = strtotime($_POST['horacita']); //hora cita
	$hora_actual = strtotime(date("H:i")); //hora actual h:i:s
	$fecha_cita = date("Y-m-d",strtotime($_POST['fechacita'])); //fechacita
	$fecha_actual = date("Y-m-d"); //fechaactual

	if (strtotime($fecha_cita) < strtotime($fecha_actual)) {
	  
	    echo "2";
		exit;
	  
	} else if ((strtotime($fecha_cita) == strtotime($fecha_actual)) && ($hora_cita < $hora_actual)){
	  
	    echo "3";
		exit;
	  
	} else {

	    $sql = " SELECT statuscita FROM citas WHERE codcita = ? AND statuscita = 'VERIFICADA' ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_POST["codcita"])));
		$num = $stmt->rowCount();
		if($num > 0)
		{
		
		echo "5";
		exit;
		
		} else {

		$sql = "SELECT * FROM citas WHERE codcita != ? AND codespecialista = ? AND fechacita = ? AND horacita = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_POST["codcita"]), decrypt($_POST["codespecialista"]), date("Y-m-d",strtotime($_POST['fechacita'])), date("H:i",strtotime($_POST['horacita'])), decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
		$sql = " UPDATE citas set "
			  ." codespecialista = ?, "
			  ." codpaciente = ?, "
			  ." descripcion = ?, "
			  ." fechacita = ?, "
			  ." horacita = ?, "
			  ." color = ?, "
			  ." statuscita = ?, "
			  ." ingresocita = ? "
			  ." WHERE "
			  ." codcita = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codespecialista);
		$stmt->bindParam(2, $codpaciente);
		$stmt->bindParam(3, $descripcion);
		$stmt->bindParam(4, $fechacita);
		$stmt->bindParam(5, $horacita);
		$stmt->bindParam(6, $color);
		$stmt->bindParam(7, $statuscita);
		$stmt->bindParam(8, $ingresocita);
		$stmt->bindParam(9, $codcita);
			
		$codespecialista = limpiar(decrypt($_POST["codespecialista"]));
		$codpaciente = limpiar($_POST["codpaciente"]);
		$descripcion = limpiar($_POST["descripcion"]);
		$fechacita = limpiar(date("Y-m-d",strtotime($_POST['fechacita'])));
		$horacita = limpiar(date("H:i",strtotime($_POST['horacita'])));
		$color = limpiar($_POST["color"]);
		$statuscita = limpiar("EN PROCESO");
		$ingresocita = limpiar(date('Y-m-d'));
		$codcita = limpiar(decrypt($_POST["codcita"]));
		$stmt->execute();
		
		echo "<span class='fa fa-check-circle'></span> LA CITA PARA ODONTOLOGIA HA SIDO ACTUALIZADA EXITOSAMENTE";
		exit;

		} else {

		  echo "4";
		  exit;
	        }
	    }
	}
}
############################### FUNCION PARA ACTUALIZAR CITAS ##############################

################################## FUNCION ACTUALIZAR FECHA DE CITA #################################
public function ActualizarFechaCitas()
{
	self::SetNames();
	if(empty($_POST['Event'][0]) or empty($_POST['Event'][1]))
	{
		echo "2";
		exit;
	}

		$fecha = date("Y-m-d",strtotime($_POST['Event'][1])); //fechacita
		$fechaactual = date("Y-m-d"); //fechaactual

		if (strtotime($fecha) < strtotime($fechaactual)) {

			echo "3";
			exit;

		} else { 

			$sql = "UPDATE citas set "
			." fechacita = ? "
			." where "
			." codcita = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $fechacita);
			$stmt->bindParam(2, $codcita);
			
			$fechacita = limpiar($_POST['Event'][1]);
			$codcita = limpiar(decrypt($_POST['Event'][0]));
			$stmt->execute();

			echo "1";
			exit;  
		} 	
	} 
################################## FUNCION ACTUALIZAR FECHA DE CITA #################################

############################### FUNCION PARA CANCELAR CITA ##################################
public function CancelarCitas()
	{
		
		self::SetNames();
   
   if ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="especialista") {

		$sql = "SELECT statuscita FROM citas WHERE codcita = ? AND statuscita = 'VERIFICADA'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codcita"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

		$sql = " UPDATE citas set "
			  ." color = ?, "
			  ." statuscita = ? "
			  ." WHERE "
			  ." codcita = ?;
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $color);
		$stmt->bindParam(2, $statuscita);
		$stmt->bindParam(3, $codcita);
			
		$color = limpiar('#FF0000');
		$statuscita = limpiar('CANCELADA');
		$codcita = limpiar(decrypt($_GET["codcita"]));
		$stmt->execute();
		
	    echo "1";
		exit;
		   
	} else {
		   
		echo "2";
		exit;
	}
			
	} else {
		
		echo "3";
		exit;
	}	
} 
############################### FUNCION PARA CANCELAR CITA #################################

############################ FUNCION PARA ELIMINAR CITAS ################################
public function EliminarCitas()
{
	self::SetNames();
	
	if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista") {
		
	$sql = "SELECT statuscita FROM citas WHERE codcita = ? AND statuscita = 'VERIFICADA'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcita"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
	
	$sql = "DELETE FROM citas WHERE codcita = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codcita);
	$codcita = decrypt($_GET["codcita"]);
	$stmt->execute();
	
		echo "1";
		exit;
		   
	} else {
		   
		echo "2";
		exit;
	}
			
	} else {
		
		echo "3";
		exit;
	}	
} 
########################## FUNCION PARA ELIMINAR CITAS #################################

################################ FUNCION BUSQUEDA CITAS POR FECHAS ################################
public function BusquedaCitasxFechas()
{
	self::SetNames();

	if ($_SESSION["acceso"]=="especialista") {

	$sql ="SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente, 
	citas.descripcion,
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	citas.codsucursal,
	citas.ingresocita, 
	especialistas.tpespecialista, 
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.tlfespecialista, 
	especialistas.sexoespecialista, 
	especialistas.correoespecialista, 
	especialistas.especialidad,
	especialistas2.cedespecialista AS cedespecialista2, 
	especialistas2.nomespecialista AS nomespecialista2,
	especialistas2.especialidad AS especialidad2, 
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',pacientes.snompaciente, ' ',pacientes.papepaciente, ' ',pacientes.sapepaciente) as pacientes,
	pacientes.fnacpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	usuarios.dni,
	usuarios.nombres
	FROM citas 
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN usuarios ON citas.codigo = usuarios.codigo
	LEFT JOIN especialistas AS especialistas2 ON citas.codigo = especialistas2.codespecialista 
	WHERE citas.codespecialista = ?
	AND citas.codsucursal = ? 
	AND DATE_FORMAT(citas.fechacita,'%Y-%m-%d') BETWEEN ? AND ?
	ORDER BY citas.fechacita DESC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
	    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA REALIZADA</center>";
        echo "</div>";		
	    exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
    } else {
   
   $sql ="SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente, 
	citas.descripcion,
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	citas.codsucursal,
	citas.ingresocita, 
	especialistas.tpespecialista, 
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.tlfespecialista, 
	especialistas.sexoespecialista, 
	especialistas.correoespecialista, 
	especialistas.especialidad, 
	especialistas2.cedespecialista AS cedespecialista2, 
	especialistas2.nomespecialista AS nomespecialista2,
	especialistas2.especialidad AS especialidad2,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',pacientes.snompaciente, ' ',pacientes.papepaciente, ' ',pacientes.sapepaciente) as pacientes,
	pacientes.fnacpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	usuarios.dni,
	usuarios.nombres
	FROM citas 
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN usuarios ON citas.codigo = usuarios.codigo
	LEFT JOIN especialistas AS especialistas2 ON citas.codigo = especialistas2.codespecialista 
	WHERE citas.codsucursal = ? 
	AND DATE_FORMAT(citas.fechacita,'%Y-%m-%d') BETWEEN ? AND ?
	ORDER BY citas.fechacita DESC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
	    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA REALIZADA</center>";
        echo "</div>";		
	    exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	    }
    }
}
################################ FUNCION BUSQUEDA CITAS POR FECHAS ################################

################################ FUNCION BUSQUEDA CITAS POR ESPECIALISTAS ################################
public function BusquedaCitasxEspecialistas()
{
	self::SetNames();
	$sql ="SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente, 
	citas.descripcion,
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	citas.codsucursal,
	citas.ingresocita, 
	especialistas.tpespecialista, 
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.tlfespecialista, 
	especialistas.sexoespecialista, 
	especialistas.correoespecialista, 
	especialistas.especialidad,
	especialistas2.cedespecialista AS cedespecialista2, 
	especialistas2.nomespecialista AS nomespecialista2,
	especialistas2.especialidad AS especialidad2, 
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',pacientes.snompaciente, ' ',pacientes.papepaciente, ' ',pacientes.sapepaciente) as pacientes,
	pacientes.fnacpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	usuarios.dni,
	usuarios.nombres
	FROM citas 
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN usuarios ON citas.codigo = usuarios.codigo
	LEFT JOIN especialistas AS especialistas2 ON citas.codigo = especialistas2.codespecialista
	WHERE citas.codsucursal = ? 
	AND citas.codespecialista = ? 
	AND DATE_FORMAT(citas.fechacita,'%Y-%m-%d') BETWEEN ? AND ?
	ORDER BY citas.fechacita DESC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codespecialista'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
	    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA REALIZADA</center>";
        echo "</div>";		
	    exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
################################ FUNCION BUSQUEDA CITAS POR ESPECIALISTAS ################################

################################ FUNCION BUSQUEDA CITAS POR PACIENTE ################################
public function BuscarCitasxPaciente()
{
	self::SetNames();

	if ($_SESSION["acceso"]=="especialista") {

	$sql ="SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente, 
	citas.descripcion,
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	citas.codsucursal,
	citas.ingresocita, 
	especialistas.tpespecialista, 
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.tlfespecialista, 
	especialistas.sexoespecialista, 
	especialistas.correoespecialista, 
	especialistas.especialidad,
	especialistas2.cedespecialista AS cedespecialista2, 
	especialistas2.nomespecialista AS nomespecialista2,
	especialistas2.especialidad AS especialidad2, 
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',pacientes.snompaciente, ' ',pacientes.papepaciente, ' ',pacientes.sapepaciente) as pacientes,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	usuarios.dni,
	usuarios.nombres
	FROM citas 
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN usuarios ON citas.codigo = usuarios.codigo
	LEFT JOIN especialistas AS especialistas2 ON citas.codigo = especialistas2.codespecialista 
	WHERE citas.codespecialista = ?
	AND citas.codsucursal = ?
	AND citas.codpaciente = ? 
	ORDER BY citas.fechacita DESC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim($_GET['codpaciente']));
		$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
	    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA REALIZADA</center>";
        echo "</div>";		
	    exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
    } else {
   
   $sql ="SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente, 
	citas.descripcion,
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	citas.statuscita,
	citas.codsucursal,
	citas.ingresocita, 
	especialistas.tpespecialista, 
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.tlfespecialista, 
	especialistas.sexoespecialista, 
	especialistas.correoespecialista, 
	especialistas.especialidad, 
	especialistas2.cedespecialista AS cedespecialista2, 
	especialistas2.nomespecialista AS nomespecialista2,
	especialistas2.especialidad AS especialidad2,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',pacientes.snompaciente, ' ',pacientes.papepaciente, ' ',pacientes.sapepaciente) as pacientes,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	usuarios.dni,
	usuarios.nombres
	FROM citas 
	LEFT JOIN sucursales ON citas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN usuarios ON citas.codigo = usuarios.codigo
	LEFT JOIN especialistas AS especialistas2 ON citas.codigo = especialistas2.codespecialista 
	WHERE citas.codsucursal = ?
	AND citas.codpaciente = ? 
	ORDER BY citas.fechacita DESC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['codpaciente']));
		$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
	    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA REALIZADA</center>";
        echo "</div>";		
	    exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	    }
    }
}
################################ FUNCION BUSQUEDA CITAS POR PACIENTE ################################

################################ FUNCION LISTAR CITAS #######################################

































################################ CLASE CAJAS DE VENTAS ################################

######################### FUNCION REGISTRAR CAJAS DE VENTAS #######################
public function RegistrarCajas()
{
	self::SetNames();
	if(empty($_POST["nrocaja"]) or empty($_POST["nomcaja"]) or empty($_POST["codigo"]))
	{
		echo "1";
		exit;
	}
		
		$sql = "SELECT nrocaja FROM cajas WHERE nrocaja = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nrocaja"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num > 0)
		{
		    echo "2";
		    exit;

		} else {
			
		$sql = "SELECT nomcaja FROM cajas WHERE nomcaja = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nomcaja"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num > 0)
		{
			echo "3";
			exit;

		} else {
			
		$sql = "SELECT codigo FROM cajas WHERE codigo = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codigo"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO cajas values (null, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nrocaja);
			$stmt->bindParam(2, $nomcaja);
			$stmt->bindParam(3, $codigo);
			$stmt->bindParam(4, $codsucursal);

			$nrocaja = limpiar($_POST["nrocaja"]);
			$nomcaja = limpiar($_POST["nomcaja"]);
			$codigo = limpiar($_POST["codigo"]);
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA CAJA PARA VENTA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "4";
			exit;
		    }
		}
	}
}
######################### FUNCION REGISTRAR CAJAS DE VENTAS #########################

######################### FUNCION LISTAR CAJAS DE VENTAS ################################
public function ListarCajas()
{
	self::SetNames();
	
	if($_SESSION['acceso'] == "administradorS") {

    $sql = "SELECT * FROM cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
    WHERE cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else if($_SESSION["acceso"] == "cajero") {

    $sql = "SELECT * FROM cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
    WHERE cajas.codigo = '".limpiar($_SESSION["codigo"])."'
    AND cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else {

	$sql = "SELECT * FROM cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION LISTAR CAJAS DE VENTAS ##########################

######################### FUNCION LISTAR CAJAS ABIERTAS ##########################
public function ListarCajasAbiertas()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
    WHERE cajas.codsucursal = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	     if($num==0)
	{
		echo "<option value=''> -- SIN RESULTADOS -- </option>";
		exit;
	       }
	else
	{
	while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

	} else if($_SESSION["acceso"] == "cajero") {

    $sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
    WHERE cajas.codigo = '".limpiar($_SESSION["codigo"])."'
    AND cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
    AND arqueocaja.statusarqueo = 1
    GROUP BY arqueocaja.codarqueo";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else {

	$sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
    WHERE cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
    AND arqueocaja.statusarqueo = 1
    GROUP BY arqueocaja.codarqueo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
######################### FUNCION LISTAR CAJAS ABIERTAS ##########################

############################ FUNCION ID CAJAS DE VENTAS #################################
public function CajasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
    WHERE cajas.codcaja = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcaja"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID CAJAS DE VENTAS #################################

#################### FUNCION ACTUALIZAR CAJAS DE VENTAS ############################
public function ActualizarCajas()
{
	self::SetNames();
	if(empty($_POST["codcaja"]) or empty($_POST["nrocaja"]) or empty($_POST["nomcaja"]) or empty($_POST["codigo"]))
	{
		echo "1";
		exit;
	}
		$sql = "SELECT nrocaja FROM cajas WHERE codcaja != ? AND nrocaja = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcaja"],$_POST["nrocaja"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num > 0)
		{
		    echo "2";
		    exit;

		} else {
			
		$sql = "SELECT nomcaja FROM cajas WHERE codcaja != ? AND nomcaja = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcaja"],$_POST["nomcaja"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num > 0)
		{
			echo "3";
			exit;

		} else {
			
		$sql = "SELECT codigo FROM cajas WHERE codcaja != ? AND codigo = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcaja"],$_POST["codigo"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = "UPDATE cajas set "
			." nrocaja = ?, "
			." nomcaja = ?, "
			." codigo = ?, "
			." codsucursal = ? "
			." where "
			." codcaja = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $nrocaja);
			$stmt->bindParam(2, $nomcaja);
			$stmt->bindParam(3, $codigo);
			$stmt->bindParam(4, $codsucursal);
			$stmt->bindParam(5, $codcaja);

			$nrocaja = limpiar($_POST["nrocaja"]);
			$nomcaja = limpiar($_POST["nomcaja"]);
			$codigo = limpiar($_POST["codigo"]);
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$codcaja = limpiar($_POST["codcaja"]);
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA CAJA PARA VENTA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "4";
			exit;
		    }
		}
	}
}
#################### FUNCION ACTUALIZAR CAJAS DE VENTAS ###########################

####################### FUNCION ELIMINAR CAJAS DE VENTAS ########################
public function EliminarCajas()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT codcaja FROM arqueocaja WHERE codcaja = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcaja"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM cajas WHERE codcaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcaja);
		$codcaja = decrypt($_GET["codcaja"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
####################### FUNCION ELIMINAR CAJAS DE VENTAS #######################

####################### FUNCION BUSCAR CAJAS POR SUCURSAL ###############################
public function BuscarCajasxSucursal() 
	{
	self::SetNames();
	$sql = "SELECT * FROM cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
    WHERE cajas.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	     if($num==0)
	{
		echo "<option value=''> -- SIN RESULTADOS -- </option>";
		exit;
	       }
	else
	{
	while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION BUSCAR CAJAS POR SUCURSAL #######################

############################ FUNCION ID CAJAS POR USUARIO #################################
public function CajasUsuarioPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal 
	WHERE cajas.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_SESSION["codigo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID CAJAS POR USUARIO #################################

############################ FIN DE CLASE CAJAS DE VENTAS ##############################


























########################## CLASE ARQUEOS DE CAJA ###################################

########################## FUNCION PARA REGISTRAR ARQUEO DE CAJA ####################
public function RegistrarArqueos()
{
	self::SetNames();
	if(empty($_POST["codcaja"]) or empty($_POST["montoinicial"]) or empty($_POST["fecharegistro"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT codcaja FROM arqueocaja WHERE codcaja = ? AND statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codcaja"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO arqueocaja values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $montoinicial);
		$stmt->bindParam(3, $efectivo);
		$stmt->bindParam(4, $cheque);
		$stmt->bindParam(5, $tcredito);
		$stmt->bindParam(6, $tdebito);
		$stmt->bindParam(7, $tprepago);
		$stmt->bindParam(8, $transferencia);
		$stmt->bindParam(9, $electronico);
		$stmt->bindParam(10, $cupon);
		$stmt->bindParam(11, $otros);
		$stmt->bindParam(12, $creditos);
		$stmt->bindParam(13, $abonosefectivo);
		$stmt->bindParam(14, $abonosotros);
		$stmt->bindParam(15, $ingresosefectivo);
		$stmt->bindParam(16, $ingresosotros);
		$stmt->bindParam(17, $egresos);
		$stmt->bindParam(18, $nroticket);
		$stmt->bindParam(19, $nronotaventa);
		$stmt->bindParam(20, $nrofactura);
		$stmt->bindParam(21, $dineroefectivo);
		$stmt->bindParam(22, $diferencia);
		$stmt->bindParam(23, $comentarios);
		$stmt->bindParam(24, $fechaapertura);
		$stmt->bindParam(25, $fechacierre);
		$stmt->bindParam(26, $statusarqueo);

		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$montoinicial = limpiar($_POST["montoinicial"]);
		$efectivo = limpiar("0.00");
		$cheque = limpiar("0.00");
		$tcredito = limpiar("0.00");
		$tdebito = limpiar("0.00");
		$tprepago = limpiar("0.00");
		$transferencia = limpiar("0.00");
		$electronico = limpiar("0.00");
		$cupon = limpiar("0.00");
		$otros = limpiar("0.00");
		$creditos = limpiar("0.00");
		$abonosefectivo = limpiar("0.00");
		$abonosotros = limpiar("0.00");
		$ingresosefectivo = limpiar("0.00");
		$ingresosotros = limpiar("0.00");
		$egresos = limpiar("0.00");
		$nroticket = limpiar("0");
		$nronotaventa = limpiar("0");
		$nrofactura = limpiar("0");
		$dineroefectivo = limpiar("0.00");
		$diferencia = limpiar("0.00");
		$comentarios = limpiar('NINGUNO');
		$fechaapertura = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro'])));
		$fechacierre = limpiar(date("0000-00-00 00:00:00"));
		$statusarqueo = limpiar("1");
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL ARQUEO DE CAJA HA SIDO REALIZADO EXITOSAMENTE";
		exit;

	} else {

		echo "2";
		exit;
	}
}
######################## FUNCION PARA REGISTRAR ARQUEO DE CAJA #######################

######################## FUNCION PARA LISTAR ARQUEO DE CAJA ########################
public function ListarArqueos()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administradorS") {

    $sql = "SELECT * FROM arqueocaja 
    INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda 
    WHERE cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
    ORDER BY arqueocaja.codarqueo DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else if($_SESSION["acceso"] == "cajero") {

    $sql = "SELECT * FROM arqueocaja 
    INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda 
    WHERE cajas.codigo = '".limpiar($_SESSION["codigo"])."'
    AND cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
    ORDER BY arqueocaja.codarqueo DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    } else {

	$sql = "SELECT * FROM arqueocaja 
    INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda 
	ORDER BY arqueocaja.codarqueo DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	}
}
######################## FUNCION PARA LISTAR ARQUEO DE CAJA #########################

########################## FUNCION ID ARQUEO DE CAJA #############################
public function ArqueoCajaPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM arqueocaja 
    INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia    
	WHERE arqueocaja.codarqueo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codarqueo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION ID ARQUEO DE CAJA #############################

##################### FUNCION VERIFICA ARQUEO DE CAJA POR USUARIO #######################
public function ArqueoCajaPorUsuario()
{
	self::SetNames();
	$sql = "SELECT * FROM arqueocaja 
    INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION VERIFICA ARQUEO DE CAJA POR USUARIO ###################

######################### FUNCION PARA CERRAR ARQUEO DE CAJA #########################
public function CerrarArqueos()
{
	self::SetNames();
	if(empty($_POST["codarqueo"]) or empty($_POST["dineroefectivo"]))
	{
		echo "1";
		exit;
	}

	if($_POST["dineroefectivo"] != 0.00 || $_POST["dineroefectivo"] != 0){

		$sql = "UPDATE arqueocaja SET "
		." dineroefectivo = ?, "
		." diferencia = ?, "
		." comentarios = ?, "
		." fechacierre = ?, "
		." statusarqueo = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $dineroefectivo);
		$stmt->bindParam(2, $diferencia);
		$stmt->bindParam(3, $comentarios);
		$stmt->bindParam(4, $fechacierre);
		$stmt->bindParam(5, $statusarqueo);
		$stmt->bindParam(6, $codarqueo);

		$dineroefectivo = limpiar($_POST["dineroefectivo"]);
		$diferencia = limpiar($_POST["diferencia"]);
		$comentarios = limpiar($_POST['comentarios']);
		$fechacierre = limpiar(date("Y-m-d h:i:s",strtotime($_POST['fecharegistro2'])));
		$statusarqueo = limpiar("0");
		$codarqueo = limpiar(decrypt($_POST["codarqueo"]));
		$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> EL CIERRE DE CAJA FUE REALIZADO EXITOSAMENTE <a href='reportepdf?codarqueo=".encrypt($codarqueo)."&tipo=".encrypt("TICKETCIERRE")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR TICKET</strong></font color></a></div>";

	echo "<script>window.open('reportepdf?codarqueo=".encrypt($codarqueo)."&tipo=".encrypt("TICKETCIERRE")."', '_blank');</script>";
	exit;

	} else {

		echo "2";
		exit;
	}
}
######################### FUNCION PARA CERRAR ARQUEO DE CAJA ######################

###################### FUNCION BUSCAR ARQUEOS DE CAJA POR FECHAS ######################
public function BuscarArqueosxFechas() 
	{
	self::SetNames();		
	$sql = "SELECT * FROM arqueocaja 
    INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda 
	WHERE sucursales.codsucursal = ? 
	AND arqueocaja.codcaja = ? 
	AND DATE_FORMAT(arqueocaja.fechaapertura,'%Y-%m-%d') BETWEEN ? AND ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codcaja'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA REALIZADA</div></center>";
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}	
}
######################## FUNCION BUSCAR ARQUEOS DE CAJA POR FECHAS ####################

############################# FIN DE CLASE ARQUEOS DE CAJA ###########################


























############################ CLASE MOVIMIENTOS EN CAJAS ##############################

###################### FUNCION PARA REGISTRAR MOVIMIENTO EN CAJA #######################
public function RegistrarMovimientos()
{
	self::SetNames();
	if(empty($_POST["codcaja"]) or empty($_POST["tipomovimiento"]) or empty($_POST["montomovimiento"]) or empty($_POST["descripcionmovimiento"]) or empty($_POST["mediomovimiento"]))
	{
		echo "1";
		exit;
	}
	elseif($_POST["montomovimiento"] == "" || $_POST["montomovimiento"] == 0 || $_POST["montomovimiento"] == 0.00)
	{
		echo "2";
		exit;

	}

	$sql = "SELECT * FROM arqueocaja 
	WHERE codcaja = '".limpiar(decrypt($_POST["codcaja"]))."' 
	AND statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "4";
		exit;
	}  
	
	#################### SELECCIONAMOS LOS DATOS DE CAJA ####################
	$sql = "SELECT 
	codarqueo,
	montoinicial, 
	efectivo, 
	abonosefectivo,
	ingresosefectivo,
	ingresosotros, 
	egresos FROM arqueocaja WHERE codcaja = '".limpiar(decrypt($_POST["codcaja"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$arqueo = $row['codarqueo'];
	$inicial = $row['montoinicial'];
	$efectivo = $row['efectivo'];
	$abono = $row['abonosefectivo'];
	$ingreso = $row['ingresosefectivo'];
	$ingreso2 = $row['ingresosotros'];
	$egresos = $row['egresos'];
	$total = $inicial+$efectivo+$abono+$ingreso-$egresos;
	#################### SELECCIONAMOS LOS DATOS DE CAJA ####################

	//REALIZO LA CONDICION SI EL MOVIMIENTO ES UN INGRESO
	if($_POST["tipomovimiento"]=="INGRESO"){ 

		######################## ACTUALIZO DATOS EN ARQUEO ########################
		$sql = " UPDATE arqueocaja SET "
		." ingresosefectivo = ?, "
		." ingresosotros = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtOtros);
		$stmt->bindParam(3, $codcaja);

		$txtEfectivo = limpiar($_POST["mediomovimiento"] == "EFECTIVO" ? number_format($ingreso+$_POST["montomovimiento"], 2, '.', '') : $ingreso);
	    $txtOtros = limpiar($_POST["mediomovimiento"] != "EFECTIVO" ? number_format($ingreso2+$_POST["montomovimiento"], 2, '.', '') : $ingreso2);
		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################
		$query = "INSERT INTO movimientoscajas values (null, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $tipomovimiento);
		$stmt->bindParam(3, $descripcionmovimiento);
		$stmt->bindParam(4, $montomovimiento);
		$stmt->bindParam(5, $mediomovimiento);
		$stmt->bindParam(6, $fechamovimiento);
		$stmt->bindParam(7, $arqueo);

		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$mediomovimiento = limpiar($_POST["mediomovimiento"]);
		$fechamovimiento = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro'])));
		$stmt->execute();
		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################

	//REALIZO LA CONDICION SI EL MOVIMIENTO ES UN EGRESO
	} else { 

	    if($_POST["mediomovimiento"]!="EFECTIVO"){

			echo "5";
			exit;

        } else if($_POST["montomovimiento"]>$total){

			echo "6";
			exit;

        } else {

		######################## ACTUALIZO DATOS EN ARQUEO ########################
        $sql = "UPDATE arqueocaja SET "
		." egresos = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $egresos);
		$stmt->bindParam(2, $codcaja);

		$egresos = number_format($egresos+$_POST["montomovimiento"], 2, '.', '');
		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################
		$query = "INSERT INTO movimientoscajas values (null, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $tipomovimiento);
		$stmt->bindParam(3, $descripcionmovimiento);
		$stmt->bindParam(4, $montomovimiento);
		$stmt->bindParam(5, $mediomovimiento);
		$stmt->bindParam(6, $fechamovimiento);
		$stmt->bindParam(7, $arqueo);

		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$mediomovimiento = limpiar($_POST["mediomovimiento"]);
		$fechamovimiento = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro'])));
		$stmt->execute();
		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################

	     }
	}

	echo "<span class='fa fa-check-square-o'></span> EL MOVIMIENTO EN CAJA HA SIDO REGISTRADO EXITOSAMENTE";
	exit;	
}
##################### FUNCION PARA REGISTRAR MOVIMIENTO EN CAJA #######################

###################### FUNCION PARA LISTAR MOVIMIENTO EN CAJA #######################
public function ListarMovimientos()
{
	self::SetNames();
	
	if($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "secretaria") {

    $sql = "SELECT * FROM movimientoscajas 
    LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo
    LEFT JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
    WHERE cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else if($_SESSION["acceso"] == "cajero") {

    $sql = "SELECT * FROM movimientoscajas 
    INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
    LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo 
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo  
    LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
    LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	WHERE usuarios.codigo = '".limpiar($_SESSION["codigo"])."'
    AND cajas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else {

	$sql = "SELECT * FROM movimientoscajas 
    LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo
    LEFT JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION PARA LISTAR MOVIMIENTO EN CAJA ######################

########################## FUNCION ID MOVIMIENTO EN CAJA #############################
public function MovimientosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM movimientoscajas 
    LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo
    LEFT JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	WHERE movimientoscajas.codmovimiento = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmovimiento"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION ID MOVIMIENTO EN CAJA #############################

##################### FUNCION PARA ACTUALIZAR MOVIMIENTOS EN CAJA ##################
public function ActualizarMovimientos()
{
	self::SetNames();
if(empty($_POST["codmovimiento"]) or empty($_POST["tipomovimiento"]) or empty($_POST["montomovimiento"]) or empty($_POST["mediomovimiento"]) or empty($_POST["codcaja"]))
	{
		echo "1";
		exit;
	}
	elseif($_POST["montomovimiento"] == "" || $_POST["montomovimiento"] == 0 || $_POST["montomovimiento"] == 0.00)
	{
		echo "2";
		exit;

	}
	elseif($_POST["tipomovimiento"] != $_POST["tipomovimientobd"] || $_POST["mediomovimiento"] != $_POST["mediomovimientobd"])
	{
		echo "3";
		exit;

	}

	$sql = "SELECT * FROM arqueocaja 
	WHERE codcaja = '".limpiar(decrypt($_POST["codcaja"]))."' AND statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "4";
		exit;
	}  

	#################### SELECCIONAMOS LOS DATOS DE CAJA ####################
	$sql = "SELECT
	montoinicial, 
	efectivo, 
	abonosefectivo, 
	ingresosefectivo,
	ingresosotros,  
	egresos,
	statusarqueo  
	FROM arqueocaja 
	INNER JOIN movimientoscajas ON arqueocaja.codarqueo = movimientoscajas.codarqueo 
	WHERE arqueocaja.codarqueo = '".limpiar(decrypt($_POST["codarqueo"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$inicial = $row['montoinicial'];
	$efectivo = $row['efectivo'];
	$abono = $row['abonosefectivo'];
	$ingreso = $row['ingresosefectivo'];
	$ingreso2 = $row['ingresosotros'];
	$egreso = $row['egresos'];
	$status = $row['statusarqueo'];
	$total = $inicial+$efectivo+$abono+$ingreso-$egreso;
	#################### SELECCIONAMOS LOS DATOS DE CAJA ####################
	
	//REALIZAMOS CALCULO DE CAMPOS
	$montomovimiento = limpiar($_POST["montomovimiento"]);
	$montomovimientobd = limpiar($_POST["montomovimientobd"]);
	$ingresobd = number_format($ingreso-$montomovimientobd, 2, '.', '');
	$ingresobd2 = number_format($ingreso2-$montomovimientobd, 2, '.', '');
	$totalmovimiento = number_format($montomovimiento-$montomovimientobd, 2, '.', '');

	if($status == 1) {

	//REALIZO LA CONDICION SI EL MOVIMIENTO ES UN INGRESO
	if($_POST["tipomovimiento"]=="INGRESO"){ 

	    ######################## ACTUALIZO DATOS EN ARQUEO ########################
	    $sql = "UPDATE arqueocaja SET "
		." ingresosefectivo = ?, "
		." ingresosotros = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtOtros);
		$stmt->bindParam(3, $codarqueo);
		
	$txtEfectivo = limpiar($_POST["mediomovimiento"] == "EFECTIVO" ? number_format($ingresobd+$montomovimiento, 2, '.', '') : $ingreso);
	$txtOtros = limpiar($_POST["mediomovimiento"] != "EFECTIVO" ? number_format($ingresobd2+$montomovimiento, 2, '.', '') : $ingreso2);
		$codarqueo = limpiar(decrypt($_POST["codarqueo"]));
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

	    ######################## ACTUALIZO EL MOVIMIENTOS EN CAJA ########################
	    $sql = "UPDATE movimientoscajas SET"
		." codcaja = ?, "
		." tipomovimiento = ?, "
		." descripcionmovimiento = ?, "
		." montomovimiento = ?, "
		." mediomovimiento = ? "
		." WHERE "
		." codmovimiento = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $tipomovimiento);
		$stmt->bindParam(3, $descripcionmovimiento);
		$stmt->bindParam(4, $montomovimiento);
		$stmt->bindParam(5, $mediomovimiento);
		$stmt->bindParam(6, $codmovimiento);

		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$mediomovimiento = limpiar($_POST["mediomovimiento"]);
		$codmovimiento = limpiar(decrypt($_POST["codmovimiento"]));
		$stmt->execute();
		######################## ACTUALIZO EL MOVIMIENTOS EN CAJA ########################

	//REALIZO LA CONDICION SI EL MOVIMIENTO ES UN EGRESO
	} else { 

	    if($_POST["mediomovimiento"]!="EFECTIVO"){

			echo "5";
			exit;

        } else if($totalmovimiento>$total){

			echo "6";
			exit;

        } else {

		######################## ACTUALIZO DATOS EN ARQUEO ########################
        $sql = "UPDATE arqueocaja SET"
		." egresos = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $egresos);
		$stmt->bindParam(2, $codarqueo);

		$egresos = number_format($egreso+$totalmovimiento, 2, '.', '');
		$codarqueo = limpiar(decrypt($_POST["codarqueo"]));
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

	    ######################## ACTUALIZO EL MOVIMIENTOS EN CAJA ########################
		$sql = "UPDATE movimientoscajas SET"
		." codcaja = ?, "
		." tipomovimiento = ?, "
		." descripcionmovimiento = ?, "
		." montomovimiento = ?, "
		." mediomovimiento = ? "
		." WHERE "
		." codmovimiento = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $tipomovimiento);
		$stmt->bindParam(3, $descripcionmovimiento);
		$stmt->bindParam(4, $montomovimiento);
		$stmt->bindParam(5, $mediomovimiento);
		$stmt->bindParam(6, $codmovimiento);

		$codcaja = limpiar(decrypt($_POST["codcaja"]));
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$mediomovimiento = limpiar($_POST["mediomovimiento"]);
		$codmovimiento = limpiar(decrypt($_POST["codmovimiento"]));
		$stmt->execute();
		######################## ACTUALIZO EL MOVIMIENTOS EN CAJA ########################

	    }
	}	

	echo "<span class='fa fa-check-square-o'></span> EL MOVIMIENTO EN CAJA HA SIDO ACTUALIZADO EXITOSAMENTE";
    exit;

	} else {
		   
		echo "7";
		exit;
    }
} 
##################### FUNCION PARA ACTUALIZAR MOVIMIENTOS EN CAJA ####################	

###################### FUNCION PARA ELIMINAR MOVIMIENTOS EN CAJA ######################
public function EliminarMovimientos()
{
	if($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "cajero") {

    #################### AGREGAMOS EL INGRESO A ARQUEO EN CAJA ####################
	$sql = "SELECT * FROM movimientoscajas 
	INNER JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo 
	WHERE movimientoscajas.codmovimiento = '".limpiar(decrypt($_GET["codmovimiento"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	//OBTENEMOS CAMPOS DE MOVIMIENTOS
	$codcaja = $row['codcaja'];
	$codarqueo = $row['codarqueo'];
	$tipomovimiento = $row['tipomovimiento'];
	$descripcionmovimiento = $row['descripcionmovimiento'];
	$montomovimiento = $row['montomovimiento'];
	$mediomovimiento = $row['mediomovimiento'];
	$fechamovimiento = $row['fechamovimiento'];
	//OBTENEMOS CAMPOS DE MOVIMIENTOS

	//OBTENEMOS CAMPOS DE ARQUEO
	$inicial = $row['montoinicial'];
	$ingreso = $row['ingresosefectivo'];
	$ingreso2 = $row['ingresosotros'];
	$egreso = $row['egresos'];
	$status = $row['statusarqueo'];
	//OBTENEMOS CAMPOS DE ARQUEO

    if($status == 1) {

        //REALIZO LA CONDICION SI EL MOVIMIENTO ES UN INGRESO
        if($tipomovimiento=="INGRESO"){

		######################## ACTUALIZO DATOS EN ARQUEO ########################
        $sql = "UPDATE arqueocaja SET"
		." ingresosefectivo = ?, "
		." ingresosotros = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtOtros);
		$stmt->bindParam(3, $codcaja);

	    $txtEfectivo = limpiar($mediomovimiento == "EFECTIVO" ? number_format($ingreso-$montomovimiento, 2, '.', '') : $ingreso);
	    $txtOtros = limpiar($mediomovimiento != "EFECTIVO" ? number_format($ingreso2-$montomovimiento, 2, '.', '') : $ingreso2);
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

        //REALIZO LA CONDICION SI EL MOVIMIENTO ES UN EGRESO
	    } else {

		######################## ACTUALIZO DATOS EN ARQUEO ########################
		$sql = "UPDATE arqueocaja SET "
		." egresos = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $egresos);
		$stmt->bindParam(2, $codcaja);

		$egresos = number_format($egreso-$montomovimiento, 2, '.', '');
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

      }

		######################## ELIMINO EL MOVIMIENTO EN CAJA ########################
        $sql = "DELETE FROM movimientoscajas WHERE codmovimiento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codmovimiento);
		$codmovimiento = decrypt($_GET["codmovimiento"]);
		$stmt->execute();
		######################## ELIMINO EL MOVIMIENTO EN CAJA ########################

		echo "1";
		exit;
		   
	} else {
		   
		echo "2";
		exit;
	}
			
	} else {
		
		echo "3";
		exit;
	}	
}
###################### FUNCION PARA ELIMINAR MOVIMIENTOS EN CAJAS  ####################

################## FUNCION BUSCAR MOVIMIENTOS DE CAJA POR FECHAS #######################
public function BuscarMovimientosxFechas() 
	{
	self::SetNames();		
	$sql = "SELECT * FROM movimientoscajas 
    LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo
    LEFT JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
    LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo
    LEFT JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	WHERE cajas.codsucursal = ? 
	AND movimientoscajas.codcaja = ? 
	AND DATE_FORMAT(movimientoscajas.fechamovimiento,'%Y-%m-%d') BETWEEN ? AND ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codcaja'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA REALIZADA</div></center>";
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
    }
}
###################### FUNCION BUSCAR MOVIMIENTOS DE CAJA POR FECHAS ###################

######################### FIN DE CLASE MOVIMIENTOS EN CAJAS #############################















































##################################### CLASE ODONTOLOGIA ########################################

############################ FUNCION BUSCAR CITAS POR FECHA ################################
public function BuscarCitasxFecha()
	{
	self::SetNames();
	$sql = "SELECT 
	citas.codcita,
	citas.codespecialista, 
	citas.codpaciente,
	citas.descripcion,
	citas.codsucursal, 
	CONCAT(citas.fechacita, ' ',citas.horacita) as fechacita, 
	citas.color,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.sexopaciente,
	pacientes.gruposapaciente,
	pacientes.ocupacionpaciente,
	pacientes.estadopaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.parentescoacompana
	FROM citas 
	LEFT JOIN especialistas ON citas.codespecialista = especialistas.codespecialista 
	LEFT JOIN pacientes ON citas.codpaciente = pacientes.codpaciente
	WHERE citas.codespecialista = ? 
	AND DATE_FORMAT(citas.fechacita,'%Y-%m-%d') = ? 
	AND citas.codsucursal = ?
	AND statuscita != 'VERIFICADA'
	ORDER BY citas.idcita ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codespecialista'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['fecha']))));
	$stmt->bindValue(3, trim(decrypt($_GET['codsucursal'])));
		$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
	    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA REALIZADA</center>";
        echo "</div>";		
	    exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION BUSCAR CITAS POR FECHA #############################

######################### FUNCION LISTAR HISTORIAL DE PACIENTE ################################
public function BusquedaHistorialPacientes()
{
	self::SetNames();
    $sql = "SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.observacionestratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento 
	WHERE odontologia.codpaciente = ? 
	AND odontologia.codsucursal = ? 
	ORDER BY odontologia.fechaodontologia DESC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codpaciente'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
		$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";		
	    exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
################################## FUNCION LISTAR HISTORIAL DE PACIENTE ############################

##################### FUNCION PARA REGISTRAR REFERENCIAS TRATAMIENTO ########################
public function RegistrarOdontograma()
	{
	self::SetNames();
	if(empty($_POST["codcita"]) or empty($_POST["codpaciente"]) or empty($_POST["codsucursal"])) 
	{
	   echo "1";
	   exit;
	}

	$sql = "SELECT 
	estados 
	FROM referenciasodontograma 
	WHERE codcita = ? 
	AND codpaciente = ?
	AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codcita"]), decrypt($_POST['codpaciente']), decrypt($_POST['codsucursal'])));
	$num = $stmt->rowCount();
	if($num > 0)
	{

		#################### ACTUALIZO REFERENCIA DE ODONTOGRAMA ####################
		$sql = " UPDATE referenciasodontograma set "
		    ." estados = ? "
		    ." WHERE "
			." codcita = ? AND codpaciente = ? AND codsucursal = ?;
			";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $estados);
		$stmt->bindParam(2, $codcita);
		$stmt->bindParam(3, $codpaciente);
		$stmt->bindParam(4, $codsucursal);
				
		$referencias = array_values(array_unique($_POST["estados"]));
		$referenciasarray = str_replace("_ _", "__",$referencias);
		//$listaSimple = array_unique($referencias);
	    $listaSimple = array_values(array_unique($referenciasarray));

		$arrayBD[] = array_values(array_unique($listaSimple));
	    ######### INSERCION EN LA BD #########
	    $listaSimpleFinal = implode("__",$listaSimple);
		$estados = str_replace("_ _", "__",$listaSimpleFinal);
		$codcita = limpiar(decrypt($_POST["codcita"]));
		$codpaciente = limpiar(decrypt($_POST["codpaciente"]));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
		#################### ACTUALIZO REFERENCIA DE ODONTOGRAMA ####################

	} else { 

		#################### REGISTRO REFERENCIA DE ODONTOGRAMA ####################
		$query = "INSERT INTO referenciasodontograma values (null, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcita);
		$stmt->bindParam(2, $codpaciente);
		$stmt->bindParam(3, $codsucursal);
		$stmt->bindParam(4, $estados);
		$stmt->bindParam(5, $fecharegistro);
			
		$codcita = limpiar(decrypt($_POST['codcita']));
		$codpaciente = limpiar(decrypt($_POST['codpaciente']));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$referencias = array_values(array_unique($_POST["estados"]));
		$referenciasarray = str_replace("_ _", "__",$referencias);
		//$listaSimple = array_unique($referencias);
	    $listaSimple = array_values(array_unique($referenciasarray));
		
		$arrayBD[] = array_values(array_unique($listaSimple));
	    ######### INSERCION EN LA BD #########
	    $listaSimpleFinal = implode("__",$listaSimple);
		$estados = str_replace("_ _", "__",$listaSimpleFinal);
	    $fecharegistro = limpiar(date("Y-m-d h:i:s"));
		$stmt->execute();
		#################### REGISTRO REFERENCIA DE ODONTOGRAMA ####################
	}

	echo "<center><div class='alert alert-success'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<span class='fa fa-check-square-o'></span> LAS REFERENCIAS ODONTOLOGICAS FUERON REGISTRADAS EXITOSAMENTE</div></center>";
    exit;
}
##################### FUNCION PARA REGISTRAR REFERENCIAS TRATAMIENTO ########################

######################### FUNCION ID REFERENCIA TRATAMIENTO #############################
public function ReferenciaOdontogramaPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM referenciasodontograma 
	WHERE codcita = ? 
	AND codpaciente = ? 
	AND codsucursal = ?
	ORDER BY codreferencia 
	DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codcita"]),decrypt($_POST["codpaciente"]),decrypt($_POST["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch())
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION ID REFERENCIA TRATAMIENTO #############################

######################### FUNCION ID REFERENCIA #2 TRATAMIENTO #############################
public function TratamientosOdontograma()
{
	self::SetNames();
	$sql = "SELECT * FROM referenciasodontograma 
	WHERE codcita = ? 
	AND codpaciente = ? 
	AND codsucursal = ? 
	ORDER BY codreferencia 
	DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcita"]),decrypt($_GET["codpaciente"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch())
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION ID REFERENCIA #2 TRATAMIENTO #############################

############################ FUNCION ELIMINAR REFERENCIAS TRATAMIENTO ###########################
public function EliminarReferenciaTratamiento()
{
	self::SetNames();
    if($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "especialista") {
		
	$sql="SELECT * FROM referenciasodontograma
	WHERE codcita = ? 
	AND codpaciente= ? 
	AND codsucursal= ? 
	ORDER BY codreferencia 
	DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET['codcita']), decrypt($_GET['codpaciente']),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch())
	{
		$p[] = $row;
	}
	$anterior = $row['estados'];

	$valor= $_GET['codreferencia'];
	$recibo = explode("__",$anterior);
	$listaSimple = array_unique($recibo);
	$listaSimpleFinal = array_values($listaSimple);
	unset($listaSimpleFinal[$valor]);
	
	# Indicamos que elimine "melon" del array y que reindexe los valores
	deleteFromArray($listaSimpleFinal,$valor,false);
    # mostramos el array
    //print_r(array_values($listaSimpleFinal));

	$arrayBD[] = $listaSimpleFinal;
    ######### INSERCION EN LA BD #########
	$referencias = implode("__",$listaSimpleFinal);

	$sql = "UPDATE referenciasodontograma set "
	." estados = ? "
	." WHERE "
	." codcita = ? AND codpaciente = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $referencias);
	$stmt->bindParam(2, $cita);
	$stmt->bindParam(3, $paciente);
	$stmt->bindParam(3, $sucursal);

	$cita = limpiar(decrypt($_GET['codcita']));
	$paciente = limpiar(decrypt($_GET['codpaciente']));
	$sucursal = limpiar(decrypt($_GET['codsucursal']));
	$stmt->execute();

	echo "1";
	exit;

	} else {
		   
	echo "2";
	exit;

	} 		
}
############################ FUNCION ELIMINAR REFERENCIAS TRATAMIENTO ###########################

######################### FUNCION REGISTRAR ODONTOLOGIA #######################
public function RegistrarOdontologia()
{
	self::SetNames();
	if(empty($_POST["codcita"]) or empty($_POST["codespecialista"]) or empty($_POST["codpaciente"]) or empty($_POST["txtTotal"]))
	{
		echo "1";
		exit;
	}
	/*elseif(empty($_SESSION["CarritoDetalles"]) || $_POST["txtTotal"]=="0.00")
	{
		echo "2";
		exit;
		
	}
	elseif(empty($_POST["plantratamiento"]))
	{
		echo "3";
		exit;
	}*/
	elseif(empty($_POST["estados"]))
	{
		echo "4";
		exit;
	}


	####################### DX PRESUNTIVO #######################
	if (limpiar(isset($_POST['idciepresuntivo']))) {

		$presuntivo = $_POST['presuntivo'];
	    $repeated = array_filter(array_count_values($presuntivo), function($count) {
	        return $count > 1;
	    });

	    foreach ($repeated as $key => $value) {
	        echo "5";
			exit;
	    }
	}
	####################### DX PRESUNTIVO #######################

	####################### DX DEFINITIVO #######################
	if (limpiar(isset($_POST['idciepresuntivo']))) {
			
		$definitivo = $_POST['definitivo'];
	    $repeated = array_filter(array_count_values($definitivo), function($count) {
	        return $count > 1;
	    });

	    foreach ($repeated as $key => $value) {
	        echo "6";
			exit;
	    }
    }
    ####################### DX DEFINITIVO #######################

    ############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	if (limpiar(isset($_SESSION["CarritoDetalles"]))) {

		$v = $_SESSION["CarritoDetalles"];
		for($i=0;$i<count($v);$i++){

			if ($v[$i]['busqueda'] == 2) {

				$sql = "SELECT existencia
				FROM productos 
				WHERE codproducto = '".$v[$i]['txtCodigo']."'
				AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
				foreach ($this->dbh->query($sql) as $row)
				{
					$this->p[] = $row;
				}
				
				$existenciadb = $row['existencia'];
				$cantidad = $v[$i]['cantidad'];

		        if ($cantidad > $existenciadb) 
		        { 
				    echo "7";
				    exit;
			    }
		    }
		}
    }
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
			
	$sql = "SELECT 
	codespecialista, 
	codpaciente, 
	fechaodontologia, 
	codsucursal 
	FROM odontologia 
	WHERE codespecialista = ? 
	AND codpaciente = ? 
	AND codsucursal = ? 
	AND DATE_FORMAT(fechaodontologia,'%Y-%m-%d') = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codespecialista"]), decrypt($_POST["codpaciente"]), decrypt($_POST["codsucursal"]), date("Y-m-d")));
	$num = $stmt->rowCount();
	if($num == 0)
	{

	$fecha = date("Y-m-d H:i:s");

	
    if (limpiar(isset($_SESSION["CarritoDetalles"]))) {//EN CASO DE TENER DETALLES PARA VENTAS

	####################################################################################
	#                                                                                  #
	#                     CREO CODIGO DE VENTAS, SERIE Y AUTORIZACION                  #
	#                                                                                  #
	####################################################################################
	
    ####################### OBTENGO DATOS DE SUCURSAL #######################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal,
	inicioticket,
	inicionotaventa, 
	iniciofactura 
	FROM sucursales 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];
	$inicioticket = $row['inicioticket'];
	$inicionotaventa = $row['inicionotaventa'];
	$iniciofactura = $row['iniciofactura'];
	$secuencia = "SI";
	####################### OBTENGO DATOS DE SUCURSAL #######################
	
	####################### OBTENGO DATOS DE VENTAS #######################
	$sql = "SELECT
	codventa, 
	codfactura 
	FROM ventas 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'  
	ORDER BY idventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$venta=$row["codventa"];
		$factura=$row["codfactura"];

	}
	####################### OBTENGO DATOS DE VENTAS #######################
	
	####################### CREO CODIGO DE VENTA #######################
	if(empty($venta))
	{
		$codventa = "1";
        $codfactura = $nroactividad.'-'.$inicioticket;
		$codserie = $nroactividad;
		$codautorizacion = limpiar(GenerateRandomStringg());

	} else {

		$var = strlen($nroactividad."-");
        $var1 = substr($factura , $var);
        $var2 = strlen($var1);
        $var3 = $var1 + 1;
        $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);

        $codventa = $venta + 1;
        $codfactura = $nroactividad.'-'.$var4;
		$codserie = $nroactividad;
		$codautorizacion = limpiar(GenerateRandomStringg());
	}
	####################### CREO CODIGO DE VENTA #######################

    ####################################################################################
	#                                                                                  #
	#                     CREO CODIGO DE VENTAS, SERIE Y AUTORIZACION                  #
	#                                                                                  #
	####################################################################################

    ################################### REGISTRO LA FACTURA ###################################
    $query = "INSERT INTO ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $tipodocumento);
	$stmt->bindParam(2, $codcaja);
	$stmt->bindParam(3, $codventa);
	$stmt->bindParam(4, $codfactura);
	$stmt->bindParam(5, $codserie);
	$stmt->bindParam(6, $codautorizacion);
	$stmt->bindParam(7, $codpaciente);
	$stmt->bindParam(8, $codespecialista);
	$stmt->bindParam(9, $subtotalivasi);
	$stmt->bindParam(10, $subtotalivano);
	$stmt->bindParam(11, $iva);
	$stmt->bindParam(12, $totaliva);
	$stmt->bindParam(13, $descontado);
	$stmt->bindParam(14, $descuento);
	$stmt->bindParam(15, $totaldescuento);
	$stmt->bindParam(16, $totalpago);
	$stmt->bindParam(17, $totalpago2);
	$stmt->bindParam(18, $tipopago);
	$stmt->bindParam(19, $formapago);
	$stmt->bindParam(20, $montopagado);
	$stmt->bindParam(21, $montodevuelto);
	$stmt->bindParam(22, $creditopagado);
	$stmt->bindParam(23, $fechavencecredito);
	$stmt->bindParam(24, $fechapagado);
	$stmt->bindParam(25, $statusventa);
	$stmt->bindParam(26, $fechaventa);
	$stmt->bindParam(27, $observaciones);
	$stmt->bindParam(28, $codigo);
	$stmt->bindParam(29, $codsucursal);
	$stmt->bindParam(30, $bandera);
	$stmt->bindParam(31, $docelectronico);
   
	$tipodocumento = limpiar("0");
	$codcaja = limpiar("0");
	$codpaciente = limpiar(decrypt($_POST["codpaciente"]));
	$codespecialista = limpiar(decrypt($_POST["codespecialista"]));
	$subtotalivasi = limpiar($_POST["txtgravado"]);
	$subtotalivano = limpiar($_POST["txtexento"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
	$tipopago = limpiar("0");
	$formapago = limpiar("0");
	$montopagado = limpiar("0");
	$montodevuelto = limpiar("0");
	$creditopagado = limpiar("0");
	$fechavencecredito = limpiar("0");
	$fechapagado = limpiar("0000-00-00");
	$statusventa = limpiar("0");
    $fechaventa = limpiar($fecha);
    $observaciones = limpiar($_POST["observaciones"]);
	$codigo = limpiar("0");
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$bandera = limpiar("1");
	$docelectronico = limpiar("0");
	$stmt->execute();
	################################### REGISTRO LA FACTURA ###################################


	################################### REGISTRO DETTALES DE FACTURA ###################################
    $this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoDetalles"];
	for($i=0;$i<count($detalle);$i++){

	############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################
	if ($detalle[$i]['busqueda'] == 2) {
	$sql = "SELECT 
	existencia 
	FROM 
	productos 
	WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciabd = $row['existencia'];
    }
	############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################

	$query = "INSERT INTO detalle_ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codventa);
    $stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codmarca);
    $stmt->bindParam(6, $codpresentacion);
    $stmt->bindParam(7, $codmedida);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $preciocompra);
	$stmt->bindParam(10, $precioventa);
	$stmt->bindParam(11, $ivaproducto);
	$stmt->bindParam(12, $descproducto);
	$stmt->bindParam(13, $valortotal);
	$stmt->bindParam(14, $totaldescuentov);
	$stmt->bindParam(15, $valorneto);
	$stmt->bindParam(16, $valorneto2);
	$stmt->bindParam(17, $tipodetalle);
	$stmt->bindParam(18, $codsucursal);
		
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codmarca = limpiar($detalle[$i]['codmarca']);
	$codpresentacion = limpiar($detalle[$i]['codpresentacion']);
	$codmedida = limpiar($detalle[$i]['codmedida']);
	$cantidad = limpiar($detalle[$i]['cantidad']);
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
	$tipodetalle = limpiar($detalle[$i]['busqueda']);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();

    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
	$sql = " UPDATE productos set "
		  ." existencia = ? "
		  ." where "
		  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$cantventa = limpiar($detalle[$i]['cantidad']);
	$existencia = isset($existenciabd) ? $existenciabd-$cantventa : "0";
	$stmt->execute();
	##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

	############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###############
    $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codventa);
	$stmt->bindParam(2, $codpaciente);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);
	$stmt->bindParam(14, $tipokardex);		
	$stmt->bindParam(15, $codsucursal);

	$codpaciente = limpiar(decrypt($_POST["codpaciente"]));
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$movimiento = limpiar("SALIDAS");
	$entradas = limpiar("0");
	$salidas= limpiar($detalle[$i]['cantidad']);
	$devolucion = limpiar("0");
	$stockactual = limpiar(isset($existenciabd) ? $existenciabd-$detalle[$i]['cantidad'] : "0");
	$precio = limpiar($detalle[$i]["precio2"]);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$documento = limpiar("VENTA: ".$codventa);
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar($detalle[$i]['busqueda']);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
    }
		
	####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoDetalles"]);
    $this->dbh->commit();
    ################################### REGISTRO DETTALES DE FACTURA ###################################

    }//CIERRO LLAVE EN DETALLES AGREGADOS
		
	################ CREO CODIGO DE ODONTOLOGIA ####################
	$sql = "SELECT cododontologia FROM odontologia ORDER BY idodontologia DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$odontologia=$row["cododontologia"];

	}
	if(empty($odontologia))
	{
		$cododontologia = "01";

	} else {

		$num = substr($odontologia, 0);
        $dig = $num + 1;
        $codigo = str_pad($dig, 2, "0", STR_PAD_LEFT);
        $cododontologia = $codigo;
	}
    ################ CREO CODIGO DE ODONTOLOGIA ###############

    ################################### REGISTRO LA CONSULTA ODONTOLOGICA ###################################
    $query = "INSERT INTO odontologia values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcita);
	$stmt->bindParam(2, $cododontologia);
	$stmt->bindParam(3, $codespecialista);
	$stmt->bindParam(4, $codpaciente);
	$stmt->bindParam(5, $tratamientomedico);
	$stmt->bindParam(6, $cualestratamiento);
	$stmt->bindParam(7, $ingestamedicamentos);
	$stmt->bindParam(8, $cualesingesta);
	$stmt->bindParam(9, $alergias);
	$stmt->bindParam(10, $cualesalergias);
	$stmt->bindParam(11, $hemorragias);
	$stmt->bindParam(12, $cualeshemorragias);
	$stmt->bindParam(13, $sinositis);
	$stmt->bindParam(14, $enfermedadrespiratoria);
	$stmt->bindParam(15, $diabetes);
	$stmt->bindParam(16, $cardiopatia);
	$stmt->bindParam(17, $hepatitis);
	$stmt->bindParam(18, $hepertension);
	$stmt->bindParam(19, $asistenciaodontologica);
	$stmt->bindParam(20, $ultimavisitaodontologia);
	$stmt->bindParam(21, $cepillado);
	$stmt->bindParam(22, $cuantoscepillados);
	$stmt->bindParam(23, $sedadental);
	$stmt->bindParam(24, $cuantascedasdental);
	$stmt->bindParam(25, $cremadental);
	$stmt->bindParam(26, $enjuague);
	$stmt->bindParam(27, $sangranencias);
	$stmt->bindParam(28, $tomaaguallave);
	$stmt->bindParam(29, $elementosconfluor);
	$stmt->bindParam(30, $aparatosortodoncia);
	$stmt->bindParam(31, $protesis);
	$stmt->bindParam(32, $protesisfija);
	$stmt->bindParam(33, $protesisremovible);
	$stmt->bindParam(34, $labios);
	$stmt->bindParam(35, $lengua);
	$stmt->bindParam(36, $paladar);
	$stmt->bindParam(37, $pisoboca);
	$stmt->bindParam(38, $carrillos);
	$stmt->bindParam(39, $glandulasalivales);
	$stmt->bindParam(40, $maxilar);
	$stmt->bindParam(41, $senosmaxilares);
	$stmt->bindParam(42, $musculosmasticadores);
	$stmt->bindParam(43, $sistemanervioso);
	$stmt->bindParam(44, $sistemavascular);
	$stmt->bindParam(45, $sistemalinfatico);
	$stmt->bindParam(46, $funcionoclusal);
	$stmt->bindParam(47, $observacionperiodontal);
	$stmt->bindParam(48, $supernumerarios);
	$stmt->bindParam(49, $adracion);
	$stmt->bindParam(50, $manchas);
	$stmt->bindParam(51, $patologiapulpar);
	$stmt->bindParam(52, $placablanda);
	$stmt->bindParam(53, $placacalificada);
	$stmt->bindParam(54, $otrosdental);
	$stmt->bindParam(55, $observacionexamendental);
	$stmt->bindParam(56, $dxpres);
	$stmt->bindParam(57, $dxdef);
	$stmt->bindParam(58, $pronostico);
	$stmt->bindParam(59, $plantratamiento);
	$stmt->bindParam(60, $observacionestratamiento);
	$stmt->bindParam(61, $fechaodontologia);
	$stmt->bindParam(62, $codsucursal);
		
	$codcita = limpiar(decrypt($_POST["codcita"]));
	$codespecialista = limpiar(decrypt($_POST["codespecialista"]));
	$codpaciente = limpiar(decrypt($_POST["codpaciente"]));
	$tratamientomedico = limpiar(empty($_POST["tratamientomedico"]) ? "" : $_POST['tratamientomedico']);
	$cualestratamiento = limpiar(isset($_POST['cualestratamiento']) ? $_POST['cualestratamiento'] : "");
	$ingestamedicamentos = limpiar(empty($_POST["ingestamedicamentos"]) ? "" : $_POST['ingestamedicamentos']);
	$cualesingesta = limpiar(isset($_POST['cualesingesta']) ? $_POST['cualesingesta'] : "");
	$alergias = limpiar(empty($_POST["alergias"]) ? "" : $_POST['alergias']);
	$cualesalergias = limpiar(isset($_POST['cualesalergias']) ? $_POST['cualesalergias'] : "");
	$hemorragias = limpiar(empty($_POST["hemorragias"]) ? "" : $_POST['hemorragias']);
	$cualeshemorragias = limpiar(isset($_POST['cualeshemorragias']) ? $_POST['cualeshemorragias'] : "");
	$sinositis = limpiar(empty($_POST["sinositis"]) ? "" : $_POST['sinositis']);
	$enfermedadrespiratoria = limpiar(empty($_POST["enfermedadrespiratoria"]) ? "" : $_POST['enfermedadrespiratoria']);
	$diabetes = limpiar(empty($_POST["diabetes"]) ? "" : $_POST['diabetes']);
	$cardiopatia = limpiar(empty($_POST["cardiopatia"]) ? "" : $_POST['cardiopatia']);
	$hepatitis = limpiar(empty($_POST["hepatitis"]) ? "" : $_POST['hepatitis']);
	$hepertension = limpiar(empty($_POST["hepertension"]) ? "" : $_POST['hepertension']);
	$asistenciaodontologica = limpiar(empty($_POST["asistenciaodontologica"]) ? "" : $_POST['asistenciaodontologica']);
	$ultimavisitaodontologia = limpiar(isset($_POST['ultimavisitaodontologia']) ? date("Y-m-d", strtotime($_POST["ultimavisitaodontologia"])) : "0000-00-00");
	$cepillado = limpiar(empty($_POST["cepillado"]) ? "" : $_POST['cepillado']);
	$cuantoscepillados = limpiar(isset($_POST['cuantoscepillados']) ? $_POST['cuantoscepillados'] : "");
	$sedadental = limpiar(empty($_POST["sedadental"]) ? "" : $_POST['sedadental']);
	$cuantascedasdental = limpiar(isset($_POST['cuantascedasdental']) ? $_POST['cuantascedasdental'] : "");
	$cremadental = limpiar(empty($_POST["cremadental"]) ? "" : $_POST['cremadental']);		
	$enjuague = limpiar(empty($_POST["enjuague"]) ? "" : $_POST['enjuague']);		
	$sangranencias = limpiar(empty($_POST["sangranencias"]) ? "" : $_POST['sangranencias']);
	$tomaaguallave = limpiar(empty($_POST["tomaaguallave"]) ? "" : $_POST['tomaaguallave']);
	$elementosconfluor = limpiar(empty($_POST["elementosconfluor"]) ? "" : $_POST['elementosconfluor']);
	$aparatosortodoncia = limpiar(empty($_POST["aparatosortodoncia"]) ? "" : $_POST['aparatosortodoncia']);
	$protesis = limpiar(empty($_POST["protesis"]) ? "" : $_POST['protesis']);		
	$protesisfija = limpiar(empty($_POST["protesisfija"]) ? "" : $_POST['protesisfija']);
	$protesisremovible = limpiar(empty($_POST["protesisremovible"]) ? "" : $_POST['protesisremovible']);
	$labios = limpiar(empty($_POST["labios"]) ? "" : $_POST['labios']);
	$lengua = limpiar(empty($_POST["lengua"]) ? "" : $_POST['lengua']);
	$paladar = limpiar(empty($_POST["paladar"]) ? "" : $_POST['paladar']);
	$pisoboca = limpiar(empty($_POST["pisoboca"]) ? "" : $_POST['pisoboca']);
	$carrillos = limpiar(empty($_POST["carrillos"]) ? "" : $_POST['carrillos']);
	$glandulasalivales = limpiar(empty($_POST["glandulasalivales"]) ? "" : $_POST['glandulasalivales']);
	$maxilar = limpiar(empty($_POST["maxilar"]) ? "" : $_POST['maxilar']);
	$senosmaxilares = limpiar(empty($_POST["senosmaxilares"]) ? "" : $_POST['senosmaxilares']);
	$musculosmasticadores = limpiar(empty($_POST["musculosmasticadores"]) ? "" : $_POST['musculosmasticadores']);
	$sistemanervioso = limpiar(empty($_POST["sistemanervioso"]) ? "" : $_POST['sistemanervioso']);
	$sistemavascular = limpiar(empty($_POST["sistemavascular"]) ? "" : $_POST['sistemavascular']);
	$sistemalinfatico = limpiar(empty($_POST["sistemalinfatico"]) ? "" : $_POST['sistemalinfatico']);
	$funcionoclusal = limpiar(empty($_POST["funcionoclusal"]) ? "" : $_POST['funcionoclusal']);
	$observacionperiodontal = limpiar(empty($_POST["observacionperiodontal"]) ? "" : $_POST['observacionperiodontal']);
	$supernumerarios = limpiar(empty($_POST["supernumerarios"]) ? "" : $_POST['supernumerarios']);
	$adracion = limpiar(empty($_POST["adracion"]) ? "" : $_POST['adracion']);
	$manchas = limpiar(empty($_POST["manchas"]) ? "" : $_POST['manchas']);
	$patologiapulpar = limpiar(empty($_POST["patologiapulpar"]) ? "" : $_POST['patologiapulpar']);
	$placablanda = limpiar(empty($_POST["placablanda"]) ? "" : $_POST['placablanda']);
	$placacalificada = limpiar(empty($_POST["placacalificada"]) ? "" : $_POST['placacalificada']);
	$otrosdental = limpiar(empty($_POST["otrosdental"]) ? "" : $_POST['otrosdental']);
	$otrosdental = limpiar(empty($_POST["otrosdental"]) ? "" : $_POST['otrosdental']);
	$observacionexamendental = limpiar(empty($_POST["observacionexamendental"]) ? "" : $_POST['observacionexamendental']);

	################# DX PRESUNTIVO #################
	$cont = 0;
	$arrayBD = array();
	$idciepres = $_POST["idciepresuntivo"];
	$pres = $_POST["presuntivo"];
	for($cont; $cont<count($_POST["presuntivo"]); $cont++):
		$arrayBD[] = $idciepres[$cont]."/".$pres[$cont]."\n";
	endfor;
	$dxpres = implode(",,",$arrayBD);
    ################# DX PRESUNTIVO #################

    ################# DX DEFINITIVO #################
	$cont = 0;
	$arrayBD = array();
	$idciedef = $_POST["idciedefinitivo"];
	$def = $_POST["definitivo"];
	for($cont; $cont<count($_POST["definitivo"]); $cont++):
		$arrayBD[] = $idciedef[$cont]."/".$def[$cont]."\n";
	endfor;
	$dxdef = implode(",,",$arrayBD);
    ################# DX DEFINITIVO #################
	
	$pronostico = limpiar(empty($_POST["pronostico"]) ? "" : $_POST['pronostico']);
	$plantratamiento = empty($_POST["plantratamiento"]) ? "" : implode(',',$_POST['plantratamiento']);
	$observacionestratamiento = limpiar(empty($_POST["observacionestratamiento"]) ? "" : $_POST['observacionestratamiento']);
	$fechaodontologia = limpiar($fecha);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################################### REGISTRO LA CONSULTA ODONTOLOGICA ###################################

	################## SUBIR FOTO DE DIENTE ######################################
    //datos del arhivo  
	if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
	if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
    //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<5000000) 
		{  
	if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/odontograma/".$nombre_archivo) && rename("fotos/odontograma/".$nombre_archivo,"fotos/odontograma/"."F_".$codcita."_".$codpaciente."_".$codsucursal.".jpg"))
		{ 
		## se puede dar un aviso
		} 
		## se puede dar otro aviso 
	}
	################## FINALIZA SUBIR FOTO DE DIENTE ##################

	##################### ACTUALIZO EL STATUS DE CITA ####################
	$sql = " UPDATE citas set "
		  ." statuscita = ? "
		  ." WHERE "
		  ." codcita = '".limpiar(decrypt($_POST["codcita"]))."' 
		  AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $statuscita);
	$statuscita = limpiar("VERIFICADA");
	$stmt->execute();
	##################### ACTUALIZO EL STATUS DE CITA ####################

	echo "<span class='fa fa-check-square-o'></span> LA CONSULTA ODONTOLOGICA HA SIDO REGISTRADA EXITOSAMENTE";

	echo "<script>window.open('reportepdf?cododontologia=".encrypt($cododontologia)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FICHAODONTOLOGICA")."', '_blank');</script>";
	exit;

	} else {

		echo "8";
		exit;
	}
}
######################### FUNCION REGISTRAR ODONTOLOGIA #########################

########################## FUNCION BUSQUEDA DE ODONTOLOGIA ###############################
public function BusquedaOdontologia()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    if ($_SESSION['acceso'] == "administradorG") {

    $sql = "SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.observacionestratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	WHERE
    (odontologia.fechaodontologia = '".$buscar."')
    OR 
    (sucursales.cuitsucursal = '".$buscar."')
    OR 
    (sucursales.nomsucursal = '".$buscar."')
    OR 
    (especialistas.cedespecialista = '".$buscar."')
    OR 
    (especialistas.nomespecialista = '".$buscar."')
    OR 
    (pacientes.codpaciente = '".$buscar."')
    OR 
    (pacientes.cedpaciente = '".$buscar."')
    OR 
    (pacientes.pnompaciente = '".$buscar."')
    OR
    (pacientes.snompaciente = '".$buscar."')
    OR 
    (pacientes.papepaciente = '".$buscar."') 
    OR 
    (pacientes.sapepaciente = '".$buscar."')
    OR
    (pacientes.gruposapaciente = '".$buscar."') LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
  } else if ($_SESSION['acceso'] == "especialista") {

    $sql = "SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.observacionestratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento 
	WHERE
    (odontologia.fechaodontologia = '".$buscar."')
    OR 
    (sucursales.cuitsucursal = '".$buscar."')
    OR 
    (sucursales.nomsucursal = '".$buscar."')
    OR 
    (especialistas.cedespecialista = '".$buscar."')
    OR 
    (especialistas.nomespecialista = '".$buscar."')
    OR 
    (pacientes.codpaciente = '".$buscar."')
    OR 
    (pacientes.cedpaciente = '".$buscar."')
    OR 
    (pacientes.pnompaciente = '".$buscar."')
    OR
    (pacientes.snompaciente = '".$buscar."')
    OR 
    (pacientes.papepaciente = '".$buscar."') 
    OR 
    (pacientes.sapepaciente = '".$buscar."')
    OR
    (pacientes.gruposapaciente = '".$buscar."') 
    AND odontologia.codespecialista = '".limpiar($_SESSION["codespecialista"])."'
    AND odontologia.codsucursal = '".limpiar($_SESSION["codsucursal"])."' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

  } else {

    $sql = "SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.observacionestratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	WHERE
    (odontologia.fechaodontologia = '".$buscar."')
    OR 
    (sucursales.cuitsucursal = '".$buscar."')
    OR 
    (sucursales.nomsucursal = '".$buscar."')
    OR 
    (especialistas.cedespecialista = '".$buscar."')
    OR 
    (especialistas.nomespecialista = '".$buscar."')
    OR 
    (pacientes.codpaciente = '".$buscar."')
    OR 
    (pacientes.cedpaciente = '".$buscar."')
    OR 
    (pacientes.pnompaciente = '".$buscar."')
    OR
    (pacientes.snompaciente = '".$buscar."')
    OR 
    (pacientes.papepaciente = '".$buscar."') 
    OR 
    (pacientes.sapepaciente = '".$buscar."')
    OR
    (pacientes.gruposapaciente = '".$buscar."') 
    AND odontologia.codsucursal = '".limpiar($_SESSION["codsucursal"])."' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
  }
}
########################## FUNCION BUSQUEDA DE ODONTOLOGIA ###############################

######################### FUNCION LISTAR ODONTOLOGIA ################################
public function ListarOdontologia()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.observacionestratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento 
	ORDER BY odontologia.fechaodontologia ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else if ($_SESSION['acceso'] == "paciente") {

	$sql = "SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.observacionestratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	WHERE odontologia.codpaciente = '".limpiar($_SESSION["codpaciente"])."' 
	ORDER BY odontologia.fechaodontologia ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else if ($_SESSION['acceso'] == "especialista") {

	$sql = "SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.observacionestratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento 
	WHERE odontologia.codespecialista = '".limpiar($_SESSION["codespecialista"])."'
	AND odontologia.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	ORDER BY odontologia.fechaodontologia ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    } else {

    $sql = "SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.observacionestratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento 
	WHERE odontologia.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	ORDER BY odontologia.fechaodontologia ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    }
}
################################## FUNCION LISTAR ODONTOLOGIA ############################

########################### FUNCION ID ODONTOLOGIA ###############################
public function OdontologiaPorId()
	{
	self::SetNames();
	$sql = "SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.cualestratamiento,
	odontologia.ingestamedicamentos,
	odontologia.cualesingesta,
	odontologia.alergias,
	odontologia.cualesalergias, 
	odontologia.hemorragias, 
	odontologia.cualeshemorragias, 
	odontologia.sinositis, 
	odontologia.enfermedadrespiratoria, 
	odontologia.diabetes, 
	odontologia.cardiopatia, 
	odontologia.hepatitis, 
	odontologia.hepertension, 
	odontologia.asistenciaodontologica, 
	odontologia.ultimavisitaodontologia, 
	odontologia.cepillado, 
	odontologia.cuantoscepillados, 
	odontologia.sedadental, 
	odontologia.cuantascedasdental, 
	odontologia.cremadental, 
	odontologia.enjuague, 
	odontologia.sangranencias, 
	odontologia.tomaaguallave, 
	odontologia.elementosconfluor, 
	odontologia.aparatosortodoncia, 
	odontologia.protesis, 
	odontologia.protesisfija, 
	odontologia.protesisremovible, 
	odontologia.labios, 
	odontologia.lengua, 
	odontologia.paladar, 
	odontologia.pisoboca, 
	odontologia.carrillos, 
	odontologia.glandulasalivales, 
	odontologia.maxilar, 
	odontologia.senosmaxilares, 
	odontologia.musculosmasticadores, 
	odontologia.sistemanervioso, 
	odontologia.sistemavascular, 
	odontologia.sistemalinfatico, 
	odontologia.funcionoclusal, 
	odontologia.observacionperiodontal, 
	odontologia.supernumerarios, 
	odontologia.adracion, 
	odontologia.manchas, 
	odontologia.patologiapulpar, 
	odontologia.placablanda, 
	odontologia.placacalificada, 
	odontologia.otrosdental, 
	odontologia.observacionexamendental, 
	odontologia.presuntivo, 
	odontologia.definitivo, 
	odontologia.pronostico, 
	odontologia.plantratamiento,
	odontologia.observacionestratamiento, 
	odontologia.fechaodontologia, 
	odontologia.codsucursal,
	referenciasodontograma.codreferencia,
	referenciasodontograma.estados,
	referenciasodontograma.fecharegistro,  
	especialistas.tpespecialista, 
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.tlfespecialista, 
	especialistas.sexoespecialista, 
	especialistas.correoespecialista, 
	especialistas.especialidad, 
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.papepaciente,
	pacientes.sapepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.parentescoacompana,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	departamentos.departamento,
	departamentos2.departamento AS departamento2,
	departamentos2.departamento AS departamento3,
	provincias.provincia,
	provincias2.provincia AS provincia2,
	provincias3.provincia AS provincia3
	FROM odontologia
	LEFT JOIN referenciasodontograma ON odontologia.codpaciente = referenciasodontograma.codpaciente 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento
	LEFT JOIN departamentos AS departamentos2 ON especialistas.id_departamento = departamentos2.id_departamento
	LEFT JOIN provincias AS provincias2 ON especialistas.id_provincia = provincias2.id_provincia
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN departamentos AS departamentos3 ON pacientes.id_departamento = departamentos3.id_departamento
	LEFT JOIN provincias AS provincias3 ON pacientes.id_provincia = provincias3.id_provincia
	WHERE odontologia.cododontologia = ? AND odontologia.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["cododontologia"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION ID ODONTOLOGIA ###############################

########################## FUNCION ACTUALIZAR ODONTOLOGIA #######################
public function ActualizarOdontologia()
	{
	self::SetNames();
	if(empty($_POST["codcita"]) or empty($_POST["codespecialista"]) or empty($_POST["codpaciente"]))
	{
		echo "1";
		exit;
	}
	/*elseif(empty($_POST["plantratamiento"]))
	{
		echo "2";
		exit;
	}*/
	elseif(empty($_POST["estados"]))
	{
		echo "3";
		exit;
	}		

	####################### DX PRESUNTIVO #######################
	if (limpiar(isset($_POST['idciepresuntivo']))) {

		$presuntivo = $_POST['presuntivo'];
	    $repeated = array_filter(array_count_values($presuntivo), function($count) {
	        return $count > 1;
	    });

	    foreach ($repeated as $key => $value) {
	        echo "4";
			exit;
	    }
	}
	####################### DX PRESUNTIVO #######################

	####################### DX DEFINITIVO #######################
	if (limpiar(isset($_POST['idciepresuntivo']))) {
			
		$definitivo = $_POST['definitivo'];
	    $repeated = array_filter(array_count_values($definitivo), function($count) {
	        return $count > 1;
	    });

	    foreach ($repeated as $key => $value) {
	        echo "5";
			exit;
	    }
    }
    ####################### DX DEFINITIVO #######################

    ################# PROCESO PARA ACTUALIZAR ODONTOLOGIA ##############
    $sql = "UPDATE odontologia set "
    ." tratamientomedico = ?, "
    ." cualestratamiento = ?, "
    ." ingestamedicamentos = ?, "
    ." cualesingesta = ?, "
    ." alergias = ?, "
    ." cualesalergias = ?, "
    ." hemorragias = ?, "
    ." cualeshemorragias = ?, "
    ." sinositis = ?, "
    ." enfermedadrespiratoria = ?, "
    ." diabetes = ?, "
    ." cardiopatia = ?, "
    ." hepatitis = ?, "
    ." hepertension = ?, "
    ." asistenciaodontologica = ?, "
    ." ultimavisitaodontologia = ?, "
    ." cepillado = ?, "
    ." cuantoscepillados = ?, "
    ." sedadental = ?, "
    ." cuantascedasdental = ?, "
    ." cremadental = ?, "
    ." enjuague = ?, "
    ." sangranencias = ?, "
    ." tomaaguallave = ?, "
    ." elementosconfluor = ?, "
    ." aparatosortodoncia = ?, "
    ." protesis = ?, "
    ." protesisfija = ?, "
    ." protesisremovible = ?, "
    ." labios = ?, "
    ." lengua = ?, "
    ." paladar = ?, "
    ." pisoboca = ?, "
    ." carrillos = ?, "
    ." glandulasalivales = ?, "
    ." maxilar = ?, "
    ." senosmaxilares = ?, "
    ." musculosmasticadores = ?, "
    ." sistemanervioso = ?, "
    ." sistemavascular = ?, "
    ." sistemalinfatico = ?, "
    ." funcionoclusal = ?, "
    ." observacionperiodontal = ?, "
    ." supernumerarios = ?, "
    ." adracion = ?, "
    ." manchas = ?, "
    ." patologiapulpar = ?, "
    ." placablanda = ?, "
    ." placacalificada = ?, "
    ." otrosdental = ?, "
    ." observacionexamendental = ?, "
    ." presuntivo = ?, "
    ." definitivo = ?, "
    ." pronostico = ?, "
    ." plantratamiento = ?, "
    ." observacionestratamiento = ? "
    ." WHERE "
    ." idodontologia = ?;
    ";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(1, $tratamientomedico);
    $stmt->bindParam(2, $cualestratamiento);
    $stmt->bindParam(3, $ingestamedicamentos);
    $stmt->bindParam(4, $cualesingesta);
    $stmt->bindParam(5, $alergias);
    $stmt->bindParam(6, $cualesalergias);
    $stmt->bindParam(7, $hemorragias);
    $stmt->bindParam(8, $cualeshemorragias);
    $stmt->bindParam(9, $sinositis);
    $stmt->bindParam(10, $enfermedadrespiratoria);
    $stmt->bindParam(11, $diabetes);
    $stmt->bindParam(12, $cardiopatia);
    $stmt->bindParam(13, $hepatitis);
    $stmt->bindParam(14, $hepertension);
    $stmt->bindParam(15, $asistenciaodontologica);
    $stmt->bindParam(16, $ultimavisitaodontologia);
    $stmt->bindParam(17, $cepillado);
    $stmt->bindParam(18, $cuantoscepillados);
    $stmt->bindParam(19, $sedadental);
    $stmt->bindParam(20, $cuantascedasdental);
    $stmt->bindParam(21, $cremadental);
    $stmt->bindParam(22, $enjuague);
    $stmt->bindParam(23, $sangranencias);
    $stmt->bindParam(24, $tomaaguallave);
    $stmt->bindParam(25, $elementosconfluor);
    $stmt->bindParam(26, $aparatosortodoncia);
    $stmt->bindParam(27, $protesis);
    $stmt->bindParam(28, $protesisfija);
    $stmt->bindParam(29, $protesisremovible);
    $stmt->bindParam(30, $labios);
    $stmt->bindParam(31, $lengua);
    $stmt->bindParam(32, $paladar);
    $stmt->bindParam(33, $pisoboca);
    $stmt->bindParam(34, $carrillos);
    $stmt->bindParam(35, $glandulasalivales);
    $stmt->bindParam(36, $maxilar);
    $stmt->bindParam(37, $senosmaxilares);
    $stmt->bindParam(38, $musculosmasticadores);
    $stmt->bindParam(39, $sistemanervioso);
    $stmt->bindParam(40, $sistemavascular);
    $stmt->bindParam(41, $sistemalinfatico);
    $stmt->bindParam(42, $funcionoclusal);
    $stmt->bindParam(43, $observacionperiodontal);
    $stmt->bindParam(44, $supernumerarios);
    $stmt->bindParam(45, $adracion);
    $stmt->bindParam(46, $manchas);
    $stmt->bindParam(47, $patologiapulpar);
    $stmt->bindParam(48, $placablanda);
    $stmt->bindParam(49, $placacalificada);
    $stmt->bindParam(50, $otrosdental);
    $stmt->bindParam(51, $observacionexamendental);
    $stmt->bindParam(52, $dxpres);
    $stmt->bindParam(53, $dxdef);
    $stmt->bindParam(54, $pronostico);
    $stmt->bindParam(55, $plantratamiento);
    $stmt->bindParam(56, $observacionestratamiento);
    $stmt->bindParam(57, $idodontologia);

    $tratamientomedico = limpiar(empty($_POST["tratamientomedico"]) ? "" : $_POST['tratamientomedico']);
    $cualestratamiento = limpiar(isset($_POST['cualestratamiento']) ? $_POST['cualestratamiento'] : "");
    $ingestamedicamentos = limpiar(empty($_POST["ingestamedicamentos"]) ? "" : $_POST['ingestamedicamentos']);
    $cualesingesta = limpiar(isset($_POST['cualesingesta']) ? $_POST['cualesingesta'] : "");
    $alergias = limpiar(empty($_POST["alergias"]) ? "" : $_POST['alergias']);
    $cualesalergias = limpiar(isset($_POST['cualesalergias']) ? $_POST['cualesalergias'] : "");
    $hemorragias = limpiar(empty($_POST["hemorragias"]) ? "" : $_POST['hemorragias']);
    $cualeshemorragias = limpiar(isset($_POST['cualeshemorragias']) ? $_POST['cualeshemorragias'] : "");
    $sinositis = limpiar(empty($_POST["sinositis"]) ? "" : $_POST['sinositis']);
    $enfermedadrespiratoria = limpiar(empty($_POST["enfermedadrespiratoria"]) ? "" : $_POST['enfermedadrespiratoria']);
    $diabetes = limpiar(empty($_POST["diabetes"]) ? "" : $_POST['diabetes']);
    $cardiopatia = limpiar(empty($_POST["cardiopatia"]) ? "" : $_POST['cardiopatia']);
    $hepatitis = limpiar(empty($_POST["hepatitis"]) ? "" : $_POST['hepatitis']);
    $hepertension = limpiar(empty($_POST["hepertension"]) ? "" : $_POST['hepertension']);
    $asistenciaodontologica = limpiar(empty($_POST["asistenciaodontologica"]) ? "" : $_POST['asistenciaodontologica']);
    $ultimavisitaodontologia = limpiar(isset($_POST['ultimavisitaodontologia']) ? date("Y-m-d", strtotime($_POST["ultimavisitaodontologia"])) : "0000-00-00");
    $cepillado = limpiar(empty($_POST["cepillado"]) ? "" : $_POST['cepillado']);
    $cuantoscepillados = limpiar(isset($_POST['cuantoscepillados']) ? $_POST['cuantoscepillados'] : "");
    $sedadental = limpiar(empty($_POST["sedadental"]) ? "" : $_POST['sedadental']);
    $cuantascedasdental = limpiar(isset($_POST['cuantascedasdental']) ? $_POST['cuantascedasdental'] : "");
    $cremadental = limpiar(empty($_POST["cremadental"]) ? "" : $_POST['cremadental']);		
    $enjuague = limpiar(empty($_POST["enjuague"]) ? "" : $_POST['enjuague']);		
    $sangranencias = limpiar(empty($_POST["sangranencias"]) ? "" : $_POST['sangranencias']);
    $tomaaguallave = limpiar(empty($_POST["tomaaguallave"]) ? "" : $_POST['tomaaguallave']);
    $elementosconfluor = limpiar(empty($_POST["elementosconfluor"]) ? "" : $_POST['elementosconfluor']);
    $aparatosortodoncia = limpiar(empty($_POST["aparatosortodoncia"]) ? "" : $_POST['aparatosortodoncia']);
    $protesis = limpiar(empty($_POST["protesis"]) ? "" : $_POST['protesis']);		
    $protesisfija = limpiar(empty($_POST["protesisfija"]) ? "" : $_POST['protesisfija']);
    $protesisremovible = limpiar(empty($_POST["protesisremovible"]) ? "" : $_POST['protesisremovible']);
    $labios = limpiar(empty($_POST["labios"]) ? "" : $_POST['labios']);
    $lengua = limpiar(empty($_POST["lengua"]) ? "" : $_POST['lengua']);
    $paladar = limpiar(empty($_POST["paladar"]) ? "" : $_POST['paladar']);
    $pisoboca = limpiar(empty($_POST["pisoboca"]) ? "" : $_POST['pisoboca']);
    $carrillos = limpiar(empty($_POST["carrillos"]) ? "" : $_POST['carrillos']);
    $glandulasalivales = limpiar(empty($_POST["glandulasalivales"]) ? "" : $_POST['glandulasalivales']);
    $maxilar = limpiar(empty($_POST["maxilar"]) ? "" : $_POST['maxilar']);
    $senosmaxilares = limpiar(empty($_POST["senosmaxilares"]) ? "" : $_POST['senosmaxilares']);
    $musculosmasticadores = limpiar(empty($_POST["musculosmasticadores"]) ? "" : $_POST['musculosmasticadores']);
    $sistemanervioso = limpiar(empty($_POST["sistemanervioso"]) ? "" : $_POST['sistemanervioso']);
    $sistemavascular = limpiar(empty($_POST["sistemavascular"]) ? "" : $_POST['sistemavascular']);
    $sistemalinfatico = limpiar(empty($_POST["sistemalinfatico"]) ? "" : $_POST['sistemalinfatico']);
    $funcionoclusal = limpiar(empty($_POST["funcionoclusal"]) ? "" : $_POST['funcionoclusal']);
    $observacionperiodontal = limpiar(empty($_POST["observacionperiodontal"]) ? "" : $_POST['observacionperiodontal']);
    $supernumerarios = limpiar(empty($_POST["supernumerarios"]) ? "" : $_POST['supernumerarios']);
    $adracion = limpiar(empty($_POST["adracion"]) ? "" : $_POST['adracion']);
    $manchas = limpiar(empty($_POST["manchas"]) ? "" : $_POST['manchas']);
    $patologiapulpar = limpiar(empty($_POST["patologiapulpar"]) ? "" : $_POST['patologiapulpar']);
    $placablanda = limpiar(empty($_POST["placablanda"]) ? "" : $_POST['placablanda']);
    $placacalificada = limpiar(empty($_POST["placacalificada"]) ? "" : $_POST['placacalificada']);
    $otrosdental = limpiar(empty($_POST["otrosdental"]) ? "" : $_POST['otrosdental']);
    $otrosdental = limpiar(empty($_POST["otrosdental"]) ? "" : $_POST['otrosdental']);
    $observacionexamendental = limpiar(empty($_POST["observacionexamendental"]) ? "" : $_POST['observacionexamendental']);

    ################# DX PRESUNTIVO #################
	$cont = 0;
	$arrayBD = array();
	$idciepres = $_POST["idciepresuntivo"];
	$pres = $_POST["presuntivo"];
	for($cont; $cont<count($_POST["presuntivo"]); $cont++):
		$arrayBD[] = $idciepres[$cont]."/".$pres[$cont]."\n";
	endfor;
	$dxpres = implode(",,",$arrayBD);
    ################# DX PRESUNTIVO #################

    ################# DX DEFINITIVO #################
	$cont = 0;
	$arrayBD = array();
	$idciedef = $_POST["idciedefinitivo"];
	$def = $_POST["definitivo"];
	for($cont; $cont<count($_POST["definitivo"]); $cont++):
		$arrayBD[] = $idciedef[$cont]."/".$def[$cont]."\n";
	endfor;
	$dxdef = implode(",,",$arrayBD);
    ################# DX DEFINITIVO #################

    $pronostico = limpiar(empty($_POST["pronostico"]) ? "" : $_POST['pronostico']);
	$plantratamiento = empty($_POST["plantratamiento"]) ? "" : implode(',',$_POST['plantratamiento']);
    $observacionestratamiento = limpiar(empty($_POST["observacionestratamiento"]) ? "" : $_POST['observacionestratamiento']);
    $idodontologia = limpiar(decrypt($_POST["idodontologia"]));
    $codcita = limpiar(decrypt($_POST["codcita"]));
    $cododontologia = limpiar(decrypt($_POST["cododontologia"]));
    $codpaciente = limpiar(decrypt($_POST["codpaciente"]));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
    $stmt->execute();

    ################## SUBIR FOTO DE DIENTE ######################################
    //datos del arhivo  
	if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo = ''; }
	if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo = ''; }
	if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo = ''; }  
    //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<5000000) 
		{  
	if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/odontograma/".$nombre_archivo) && rename("fotos/odontograma/".$nombre_archivo,"fotos/odontograma/"."F_".$codcita."_".$codpaciente."_".$codsucursal.".jpg"))
		{ 
		## se puede dar un aviso
		} 
		## se puede dar otro aviso 
	}
	################## FINALIZA SUBIR FOTO DE DIENTE ##################

	echo "<span class='fa fa-check-square-o'></span> LA CONSULTA ODONTOLOGICA HA SIDO ACTUALIZADA EXITOSAMENTE";

	echo "<script>window.open('reportepdf?cododontologia=".encrypt($cododontologia)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FICHAODONTOLOGICA")."', '_blank');</script>";
	exit;	
}
########################## FUNCION ACTUALIZAR ODONTOLOGIA #######################

############################ FUNCION ELIMINAR ODONTOLOGIA ###########################
public function EliminarOdontologia()
	{
	self::SetNames();
	
	if($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "especialista") {
		
	$sql = "DELETE FROM odontologia WHERE cododontologia = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$cododontologia);
	$stmt->bindParam(2,$codsucursal);
	$cododontologia = decrypt($_GET["cododontologia"]);
	$codsucursal = decrypt($_GET["codsucursal"]);
	$stmt->execute();
		
	$sql = "DELETE FROM referenciasodontograma WHERE codcita = ? AND codpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codcita);
	$stmt->bindParam(2,$codpaciente);
	$codcita = decrypt($_GET["codcita"]);
	$codpaciente = decrypt($_GET["codpaciente"]);
	$stmt->execute();

	//funcion para eliminar una carpeta con contenido
    $codpaciente = decrypt($_GET["codpaciente"]);
    $archivos = "fotos/odontograma/".$codcita."_".$codpaciente.".png";		
    unlink($archivos);
		
		echo "1";
		exit;
		   
	} else {
		   
		echo "2";
		exit;
    }	
}  
############################ FUNCION ELIMINAR ODONTOLOGIA ###########################

###################### FUNCION BUSQUEDA ODONTOLOGIA POR FECHAS ###########################
public function BuscarOdontologiaxFechas() 
{
	self::SetNames();

	if ($_SESSION["acceso"]=="especialista") {

	$sql ="SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.observacionestratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.especialidad,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	WHERE odontologia.codespecialista = ?
	AND odontologia.codsucursal = ? 
	AND DATE_FORMAT(odontologia.fechaodontologia,'%Y-%m-%d') BETWEEN ? AND ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
    } else { 

	$sql ="SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.observacionestratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.especialidad,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	WHERE odontologia.codsucursal = ? 
	AND DATE_FORMAT(odontologia.fechaodontologia,'%Y-%m-%d') BETWEEN ? AND ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
	}
}
###################### FUNCION BUSQUEDA ODONTOLOGIA POR FECHAS ###########################

###################### FUNCION BUSQUEDA ODONTOLOGIA POR ESPECIALISTA ###########################
public function BuscarOdontologiaxEspecialista() 
{
	self::SetNames();
	$sql ="SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionestratamiento,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.especialidad,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	WHERE odontologia.codsucursal = ?
	AND odontologia.codespecialista = ? 
	AND DATE_FORMAT(odontologia.fechaodontologia,'%Y-%m-%d') BETWEEN ? AND ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codespecialista'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA ODONTOLOGIA POR ESPECIALISTA ###########################

###################### FUNCION BUSQUEDA ODONTOLOGIA POR PACIENTE ###########################
public function BuscarOdontologiaxPaciente() 
{
	self::SetNames();

	if ($_SESSION["acceso"]=="especialista") {

	$sql ="SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionestratamiento,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.especialidad,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	WHERE odontologia.codespecialista = ?
	AND odontologia.codsucursal = ?
	AND odontologia.codpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim($_GET['codpaciente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

	} else {

	$sql ="SELECT
	odontologia.idodontologia,
	odontologia.codcita,
	odontologia.cododontologia,
	odontologia.codespecialista,
	odontologia.codpaciente,
	odontologia.tratamientomedico,
	odontologia.observacionestratamiento,
	odontologia.observacionexamendental,
	odontologia.presuntivo,
	odontologia.definitivo,
	odontologia.pronostico,
	odontologia.plantratamiento,
	odontologia.fechaodontologia,
	odontologia.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.especialidad,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM odontologia 
	LEFT JOIN sucursales ON odontologia.codsucursal = sucursales.codsucursal   
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON odontologia.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON odontologia.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	WHERE odontologia.codsucursal = ?
	AND odontologia.codpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['codpaciente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
		}
	}
}
###################### FUNCION BUSQUEDA ODONTOLOGIA POR PACIENTE ###########################

##################################### CLASE ODONTOLOGIA ########################################







































##################################### CLASE CONSENTIMIENTO INFORMADO ########################################

############################ FUNCION BUSCAR PACIENTE PARA CONSENTIMIENTO ################################
public function BuscarPacientes()
	{
	self::SetNames();
	$sql = "SELECT 
	pacientes.codpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.sexopaciente,
	pacientes.gruposapaciente,
	pacientes.ocupacionpaciente,
	pacientes.estadopaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.id_departamento,
	pacientes.id_provincia,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.parentescoacompana,
	documentos.documento,
	departamentos.departamento,
	provincias.provincia
	FROM pacientes 
	LEFT JOIN documentos ON pacientes.documpaciente = documentos.coddocumento
	LEFT JOIN departamentos ON pacientes.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON pacientes.id_provincia = provincias.id_provincia 
	WHERE pacientes.codpaciente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codpaciente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
	    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU B&Uacute;SQUEDA REALIZADA</center>";
        echo "</div>";		
	    exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION BUSCAR PACIENTE PARA CONSENTIMIENTO #############################

######################### FUNCION REGISTRAR CONSENTIMIENTO #######################
public function RegistrarConsentimiento()
{
	self::SetNames();
	if(empty($_POST["codespecialista"]) or empty($_POST["codpaciente"]) or empty($_POST["procedimiento"]) or empty($_POST["observaciones"]))
	{
		echo "1";
		exit;
	}
	

	############################ CODIGO DE CONSENTIMIENTO ############################
	$sql = "SELECT codconsentimiento FROM consentimientoinformado ORDER BY idconsentimiento DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$id=$row["codconsentimiento"];

	}
	if(empty($id))
	{
		$codconsentimiento = "C1";

	} else {

		$resto = substr($id, 0, 1);
		$coun = strlen($resto);
		$num     = substr($id, $coun);
		$codigo     = $num + 1;
		$codconsentimiento = "C".$codigo;
	}
	############################ CODIGO DE CONSENTIMIENTO ############################
			
	$sql = "SELECT codespecialista, codpaciente, codsucursal, fechaconsentimiento FROM consentimientoinformado WHERE codespecialista = ? AND codpaciente = ? AND codsucursal = ? AND DATE_FORMAT(fechaconsentimiento,'%Y-%m-%d') = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codespecialista"]), $_POST["codpaciente"], decrypt($_POST["codsucursal"]), date("Y-m-d")));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		
		$query = "INSERT INTO consentimientoinformado values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codconsentimiento);
		$stmt->bindParam(2, $codespecialista);
		$stmt->bindParam(3, $codpaciente);
		$stmt->bindParam(4, $procedimiento);
		$stmt->bindParam(5, $observaciones);
		$stmt->bindParam(6, $doctestigo);
		$stmt->bindParam(7, $nombretestigo);
		$stmt->bindParam(8, $nofirmapaciente);
		$stmt->bindParam(9, $fechaconsentimiento);
		$stmt->bindParam(10, $codsucursal);
			
		$codespecialista = limpiar(decrypt($_POST["codespecialista"]));
		$codpaciente = limpiar($_POST["codpaciente"]);
		$procedimiento = limpiar($_POST['procedimiento']);
		$observaciones = limpiar($_POST['observaciones']);
		$doctestigo = limpiar($_POST['doctestigo']);
		$nombretestigo = limpiar($_POST['nombretestigo']);
		$nofirmapaciente = limpiar($_POST['nofirmapaciente']);
		$fechaconsentimiento = limpiar(date("Y-m-d H:i:s"));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL CONSENTIMIENTO INFORMADO HA SIDO REGISTRADO EXITOSAMENTE <a href='reportepdf?codconsentimiento=".encrypt($codconsentimiento)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FICHACONSENTIMIENTO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR CONSENTIMIENTO</strong></font color></a>";
		exit;

	} else {

		echo "2";
		exit;
	}
}
######################### FUNCION REGISTRAR CONSENTIMIENTO #########################

########################## FUNCION BUSQUEDA DE CONSENTIMIENTO ###############################
public function BusquedaConsentimientos()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    if ($_SESSION['acceso'] == "administradorG") {

    $sql = "SELECT
	consentimientoinformado.idconsentimiento,
	consentimientoinformado.codconsentimiento,
	consentimientoinformado.codespecialista,
	consentimientoinformado.codpaciente,
	consentimientoinformado.procedimiento,
	consentimientoinformado.observaciones,
	consentimientoinformado.doctestigo,
	consentimientoinformado.nombretestigo,
	consentimientoinformado.nofirmapaciente,
	consentimientoinformado.fechaconsentimiento,
	consentimientoinformado.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM consentimientoinformado 
	LEFT JOIN sucursales ON consentimientoinformado.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON consentimientoinformado.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON consentimientoinformado.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento 
	WHERE
    (consentimientoinformado.procedimiento = '".$buscar."')
    OR 
    (consentimientoinformado.doctestigo = '".$buscar."')
    OR 
    (consentimientoinformado.nombretestigo = '".$buscar."')
    OR 
    (consentimientoinformado.fechaconsentimiento = '".$buscar."')
    OR 
    (sucursales.cuitsucursal = '".$buscar."')
    OR 
    (sucursales.nomsucursal = '".$buscar."')
    OR 
    (especialistas.cedespecialista = '".$buscar."')
    OR 
    (especialistas.nomespecialista = '".$buscar."')
    OR 
    (pacientes.codpaciente = '".$buscar."')
    OR 
    (pacientes.cedpaciente = '".$buscar."')
    OR 
    (pacientes.pnompaciente = '".$buscar."')
    OR
    (pacientes.snompaciente = '".$buscar."')
    OR 
    (pacientes.papepaciente = '".$buscar."') 
    OR 
    (pacientes.sapepaciente = '".$buscar."')
    OR
    (pacientes.gruposapaciente = '".$buscar."') LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
  } else if ($_SESSION['acceso'] == "especialista") {

    $sql = "SELECT
	consentimientoinformado.idconsentimiento,
	consentimientoinformado.codconsentimiento,
	consentimientoinformado.codespecialista,
	consentimientoinformado.codpaciente,
	consentimientoinformado.procedimiento,
	consentimientoinformado.observaciones,
	consentimientoinformado.doctestigo,
	consentimientoinformado.nombretestigo,
	consentimientoinformado.nofirmapaciente,
	consentimientoinformado.fechaconsentimiento,
	consentimientoinformado.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente
	FROM consentimientoinformado 
	LEFT JOIN sucursales ON consentimientoinformado.codsucursal = sucursales.codsucursal 
	LEFT JOIN especialistas ON consentimientoinformado.codespecialista = especialistas.codespecialista
	LEFT JOIN pacientes ON consentimientoinformado.codpaciente = pacientes.codpaciente WHERE
    (consentimientoinformado.procedimiento = '".$buscar."')
    OR 
    (consentimientoinformado.doctestigo = '".$buscar."')
    OR 
    (consentimientoinformado.nombretestigo = '".$buscar."')
    OR 
    (consentimientoinformado.fechaconsentimiento = '".$buscar."')
    OR 
    (sucursales.cuitsucursal = '".$buscar."')
    OR 
    (sucursales.nomsucursal = '".$buscar."')
    OR 
    (especialistas.cedespecialista = '".$buscar."')
    OR 
    (especialistas.nomespecialista = '".$buscar."')
    OR 
    (pacientes.codpaciente = '".$buscar."')
    OR 
    (pacientes.cedpaciente = '".$buscar."')
    OR 
    (pacientes.pnompaciente = '".$buscar."')
    OR
    (pacientes.snompaciente = '".$buscar."')
    OR 
    (pacientes.papepaciente = '".$buscar."') 
    OR 
    (pacientes.sapepaciente = '".$buscar."')
    OR
    (pacientes.gruposapaciente = '".$buscar."') 
    AND consentimientoinformado.codespecialista = '".limpiar($_SESSION["codespecialista"])."'
    AND consentimientoinformado.codsucursal = '".limpiar($_SESSION["codsucursal"])."' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

  } else {

   $sql = "SELECT
	consentimientoinformado.idconsentimiento,
	consentimientoinformado.codconsentimiento,
	consentimientoinformado.codespecialista,
	consentimientoinformado.codpaciente,
	consentimientoinformado.procedimiento,
	consentimientoinformado.observaciones,
	consentimientoinformado.doctestigo,
	consentimientoinformado.nombretestigo,
	consentimientoinformado.nofirmapaciente,
	consentimientoinformado.fechaconsentimiento,
	consentimientoinformado.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente
	FROM consentimientoinformado 
	LEFT JOIN sucursales ON consentimientoinformado.codsucursal = sucursales.codsucursal 
	LEFT JOIN especialistas ON consentimientoinformado.codespecialista = especialistas.codespecialista
	LEFT JOIN pacientes ON consentimientoinformado.codpaciente = pacientes.codpaciente WHERE
    (consentimientoinformado.procedimiento = '".$buscar."')
    OR 
    (consentimientoinformado.doctestigo = '".$buscar."')
    OR 
    (consentimientoinformado.nombretestigo = '".$buscar."')
    OR 
    (consentimientoinformado.fechaconsentimiento = '".$buscar."')
    OR 
    (sucursales.cuitsucursal = '".$buscar."')
    OR 
    (sucursales.nomsucursal = '".$buscar."')
    OR 
    (especialistas.cedespecialista = '".$buscar."')
    OR 
    (especialistas.nomespecialista = '".$buscar."')
    OR 
    (pacientes.codpaciente = '".$buscar."')
    OR 
    (pacientes.cedpaciente = '".$buscar."')
    OR 
    (pacientes.pnompaciente = '".$buscar."')
    OR
    (pacientes.snompaciente = '".$buscar."')
    OR 
    (pacientes.papepaciente = '".$buscar."') 
    OR 
    (pacientes.sapepaciente = '".$buscar."')
    OR
    (pacientes.gruposapaciente = '".$buscar."') 
    AND consentimientoinformado.codsucursal = '".limpiar($_SESSION["codsucursal"])."' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
  }
}
########################## FUNCION BUSQUEDA DE CONSENTIMIENTO ###############################

######################### FUNCION LISTAR CONSENTIMIENTO ################################
public function ListarConsentimientos()
{
	self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT
	consentimientoinformado.idconsentimiento,
	consentimientoinformado.codconsentimiento,
	consentimientoinformado.codespecialista,
	consentimientoinformado.codpaciente,
	consentimientoinformado.procedimiento,
	consentimientoinformado.observaciones,
	consentimientoinformado.doctestigo,
	consentimientoinformado.nombretestigo,
	consentimientoinformado.nofirmapaciente,
	consentimientoinformado.fechaconsentimiento,
	consentimientoinformado.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM consentimientoinformado 
	LEFT JOIN sucursales ON consentimientoinformado.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON consentimientoinformado.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON consentimientoinformado.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento 
	ORDER BY consentimientoinformado.fechaconsentimiento DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else if ($_SESSION['acceso'] == "paciente") {

	$sql = "SELECT
	consentimientoinformado.idconsentimiento,
	consentimientoinformado.codconsentimiento,
	consentimientoinformado.codespecialista,
	consentimientoinformado.codpaciente,
	consentimientoinformado.procedimiento,
	consentimientoinformado.observaciones,
	consentimientoinformado.doctestigo,
	consentimientoinformado.nombretestigo,
	consentimientoinformado.nofirmapaciente,
	consentimientoinformado.fechaconsentimiento,
	consentimientoinformado.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM consentimientoinformado 
	LEFT JOIN sucursales ON consentimientoinformado.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON consentimientoinformado.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON consentimientoinformado.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	WHERE consentimientoinformado.codpaciente = '".limpiar($_SESSION["codpaciente"])."' 
	ORDER BY consentimientoinformado.fechaconsentimiento DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else if ($_SESSION['acceso'] == "especialista") {

	$sql = "SELECT
	consentimientoinformado.idconsentimiento,
	consentimientoinformado.codconsentimiento,
	consentimientoinformado.codespecialista,
	consentimientoinformado.codpaciente,
	consentimientoinformado.procedimiento,
	consentimientoinformado.observaciones,
	consentimientoinformado.doctestigo,
	consentimientoinformado.nombretestigo,
	consentimientoinformado.nofirmapaciente,
	consentimientoinformado.fechaconsentimiento,
	consentimientoinformado.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM consentimientoinformado 
	LEFT JOIN sucursales ON consentimientoinformado.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON consentimientoinformado.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON consentimientoinformado.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	WHERE consentimientoinformado.codespecialista = '".limpiar($_SESSION["codespecialista"])."' 
	AND consentimientoinformado.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	ORDER BY consentimientoinformado.fechaconsentimiento DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    } else {

    $sql = "SELECT
	consentimientoinformado.idconsentimiento,
	consentimientoinformado.codconsentimiento,
	consentimientoinformado.codespecialista,
	consentimientoinformado.codpaciente,
	consentimientoinformado.procedimiento,
	consentimientoinformado.observaciones,
	consentimientoinformado.doctestigo,
	consentimientoinformado.nombretestigo,
	consentimientoinformado.nofirmapaciente,
	consentimientoinformado.fechaconsentimiento,
	consentimientoinformado.codsucursal,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	pacientes.idpaciente,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3, 
	documentos4.documento AS documento4
	FROM consentimientoinformado 
	LEFT JOIN sucursales ON consentimientoinformado.codsucursal = sucursales.codsucursal  
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN especialistas ON consentimientoinformado.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento 
	LEFT JOIN pacientes ON consentimientoinformado.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento 
	WHERE consentimientoinformado.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	ORDER BY consentimientoinformado.fechaconsentimiento DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    }
}
################################## FUNCION LISTAR CONSENTIMIENTO ############################

############################ FUNCION ID CONSENTIMIENTO #################################
public function ConsentimientosPorId()
	{
	self::SetNames();
	$sql = "SELECT
	consentimientoinformado.idconsentimiento,
	consentimientoinformado.codconsentimiento,
	consentimientoinformado.codespecialista,
	consentimientoinformado.codpaciente,
	consentimientoinformado.procedimiento,
	consentimientoinformado.observaciones,
	consentimientoinformado.doctestigo,
	consentimientoinformado.nombretestigo,
	consentimientoinformado.nofirmapaciente,
	consentimientoinformado.fechaconsentimiento,
	consentimientoinformado.codsucursal, 
	especialistas.tpespecialista, 
	especialistas.documespecialista,
	especialistas.cedespecialista, 
	especialistas.nomespecialista,
	especialistas.tlfespecialista, 
	especialistas.sexoespecialista, 
	especialistas.correoespecialista, 
	especialistas.especialidad, 
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.sexopaciente,
	pacientes.enfoquepaciente,
	pacientes.direcpaciente,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.id_provincia,
	sucursales.id_departamento,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	documentos.documento,
	documentos2.documento AS documento2,
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	departamentos.departamento,
	departamentos2.departamento AS departamento2,
	departamentos2.departamento AS departamento3,
	provincias.provincia,
	provincias2.provincia AS provincia2,
	provincias3.provincia AS provincia3
	FROM consentimientoinformado 
	LEFT JOIN sucursales ON consentimientoinformado.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN especialistas ON consentimientoinformado.codespecialista = especialistas.codespecialista 
	LEFT JOIN documentos AS documentos3 ON especialistas.documespecialista = documentos3.coddocumento
	LEFT JOIN departamentos AS departamentos2 ON especialistas.id_departamento = departamentos2.id_departamento
	LEFT JOIN provincias AS provincias2 ON especialistas.id_provincia = provincias2.id_provincia
	LEFT JOIN pacientes ON consentimientoinformado.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos4 ON pacientes.documpaciente = documentos4.coddocumento
	LEFT JOIN departamentos AS departamentos3 ON pacientes.id_departamento = departamentos3.id_departamento
	LEFT JOIN provincias AS provincias3 ON pacientes.id_provincia = provincias3.id_provincia
	WHERE consentimientoinformado.codconsentimiento = ? AND consentimientoinformado.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codconsentimiento"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID CONSENTIMIENTO #################################

################################ FUNCION PARA ACTUALIZAR CONSENTIMIENTO #################################
public function ActualizarConsentimiento()
	{
	self::SetNames();
	if(empty($_POST["codconsentimiento"]) or empty($_POST["codespecialista"]) or empty($_POST["codpaciente"]) or empty($_POST["procedimiento"]) or empty($_POST["observaciones"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT codespecialista, codpaciente, codsucursal, fechaconsentimiento FROM consentimientoinformado WHERE codconsentimiento != ? AND codespecialista = ? AND codpaciente = ? AND codsucursal = ? AND DATE_FORMAT(fechaconsentimiento,'%Y-%m-%d') = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codconsentimiento"], $_POST["codespecialista"], $_POST["codpaciente"], $_POST["codsucursal"], date("Y-m-d")));
	$num = $stmt->rowCount();
	if($num == 0)
	{

	$sql = " UPDATE consentimientoinformado set "
		  ." procedimiento = ?, "
		  ." observaciones = ?, "
		  ." doctestigo = ?, "
		  ." nombretestigo = ?, "
		  ." nofirmapaciente = ? "
		  ." WHERE "
		  ." codconsentimiento = ? AND codsucursal = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $procedimiento);
	$stmt->bindParam(2, $observaciones);
	$stmt->bindParam(3, $doctestigo);
	$stmt->bindParam(4, $nombretestigo);
	$stmt->bindParam(5, $nofirmapaciente);
	$stmt->bindParam(6, $codconsentimiento);
	$stmt->bindParam(7, $codsucursal);
		
	$procedimiento = limpiar($_POST['procedimiento']);
	$observaciones = limpiar($_POST['observaciones']);
	$doctestigo = limpiar($_POST['doctestigo']);
	$nombretestigo = limpiar($_POST['nombretestigo']);
	$nofirmapaciente = limpiar($_POST['nofirmapaciente']);
	$codconsentimiento = limpiar($_POST["codconsentimiento"]);
	$codsucursal = limpiar($_POST["codsucursal"]);
	$stmt->execute();
	
	echo "<span class='fa fa-check-square-o'></span> EL CONSENTIMIENTO INFORMADO HA SIDO ACTUALIZADO EXITOSAMENTE <a href='reportepdf?codconsentimiento=".encrypt($codconsentimiento)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("FICHACONSENTIMIENTO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR CONSENTIMIENTO</strong></font color></a>";
	exit;

	} else {

		echo "2";
		exit;
	}
}
############################### FUNCION PARA ACTUALIZAR CONSENTIMIENTO ##############################

########################### FUNCION ELIMINAR CONSENTIMIENTO ###########################
public function EliminarConsentimiento()
	{
	self::SetNames();

	if($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "especialista") {
		
	$sql = "DELETE FROM consentimientoinformado WHERE codconsentimiento = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codconsentimiento);
	$stmt->bindParam(2,$codsucursal);
	$codconsentimiento = decrypt($_GET["codconsentimiento"]);
	$codsucursal = decrypt($_GET["codsucursal"]);
	$stmt->execute();
		
		echo "1";
		exit;
		   
	} else {
		   
		echo "2";
		exit;
    }	
} 
########################### FUNCION ELIMINAR CONSENTIMIENTO ###########################

##################################### CLASE CONSENTIMIENTO INFORMADO ########################################































###################################### CLASE VENTAS ##################################

############################ FUNCION COBRAR VENTA ##############################
public function CobrarVenta()
	{
	self::SetNames();
	if(empty($_POST["idventa"]) or empty($_POST["codventa"]) or empty($_POST["txtTotal"]))
	{
		echo "1";
		exit;
	}

    ####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "2";
		exit;
		
	} else {
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
        $codarqueo = $row['codarqueo'];
        $codcaja = $row['codcaja'];
	}
	####################### VERIFICO ARQUEO DE CAJA #######################

	####################### SI LA FACTURACION ES A CREDITO #######################
	if($_POST["tipopago"]=="CREDITO"){

		$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));

		if (strtotime($fechavence) < strtotime($fechaactual)) {

			echo "3";
			exit;

		} else if($_POST["montoabono"] >= $_POST["txtTotal"]){

			echo "4";
			exit;
		} 
	}
	####################### SI LA FACTURACION ES A CREDITO #######################
	    
	###################### ACTUALIZO DATOS DE VENTA ######################
	$sql = "UPDATE ventas set "
	." tipodocumento = ?, "
	." codcaja = ?, "
	." tipopago = ?, "
	." formapago = ?, "
	." montopagado = ?, "
	." montodevuelto = ?, "
	." creditopagado = ?, "
	." fechavencecredito = ?, "
	." statusventa = ?, "
	." observaciones = ?, "
	." codigo = ?, "
	." bandera = ? "
	." WHERE "
	." idventa = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $tipodocumento);
	$stmt->bindParam(2, $codcaja);
	$stmt->bindParam(3, $tipopago);
	$stmt->bindParam(4, $formapago);
	$stmt->bindParam(5, $montopagado);
	$stmt->bindParam(6, $montodevuelto);
	$stmt->bindParam(7, $creditopagado);
	$stmt->bindParam(8, $fechavencecredito);
	$stmt->bindParam(9, $statusventa);
	$stmt->bindParam(10, $observaciones);
	$stmt->bindParam(11, $codigo);
	$stmt->bindParam(12, $bandera);
	$stmt->bindParam(13, $idventa);
    
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	$codcaja = limpiar(decrypt($_POST["codcaja"]));
	$tipopago = limpiar($_POST["tipopago"]);
	$formapago = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["formapago"] : "CREDITO");
	$montopagado = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["montopagado"] : "0.00");
	$montodevuelto = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["montodevuelto"] : "0.00");
	$creditopagado = limpiar(isset($_POST['montoabono']) ? $_POST['montoabono'] : "0.00");
	$fechavencecredito = limpiar($_POST["tipopago"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
	$statusventa = limpiar($_POST["tipopago"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
	$observaciones = limpiar($_POST['observaciones']);
	$codigo = limpiar($_SESSION['codigo']);
	$bandera = limpiar("0");
	$idventa = limpiar(decrypt($_POST["idventa"]));
	$codventa = limpiar(decrypt($_POST["codventa"]));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	###################### ACTUALIZO DATOS DE VENTA ######################

	###################### OBTENGO DATOS DE ARQUEO ######################
	$sql = "SELECT
	arqueocaja.codarqueo,
	arqueocaja.codcaja,
	arqueocaja.efectivo, 
	arqueocaja.cheque, 
	arqueocaja.tcredito, 
	arqueocaja.tdebito, 
	arqueocaja.tprepago, 
	arqueocaja.transferencia, 
	arqueocaja.electronico,
	arqueocaja.cupon, 
	arqueocaja.otros,
	arqueocaja.creditos,
	arqueocaja.nroticket,
	arqueocaja.nronotaventa,
	arqueocaja.nrofactura
	FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE arqueocaja.codarqueo = '".limpiar($codarqueo)."'
	AND arqueocaja.statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$codarqueo = $row['codarqueo'];
	$codcaja = $row['codcaja'];
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
	$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
	$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
	$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
	$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
	$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
	$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
	$otros = ($row['otros']== "" ? "0.00" : $row['otros']);
	$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
	$nroticket = $row['nroticket'];
	$nronotaventa = $row['nronotaventa'];
	$nrofactura = $row['nrofactura'];
	###################### OBTENGO DATOS DE ARQUEO ######################

	###################### TIPO DE PAGO CONTADO ######################
	if (limpiar($_POST["tipopago"]=="CONTADO")){

		########################## PROCESO LA FORMA DE PAGO #################################
		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ?, "
		." nroticket = ?, "
		." nronotaventa = ?, "
		." nrofactura = ? "
		." WHERE "
		." codarqueo = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $NumTicket);
		$stmt->bindParam(11, $NumNotaVenta);
		$stmt->bindParam(12, $NumFactura);
		$stmt->bindParam(13, $codarqueo);

	$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo+$_POST["txtTotal"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque+$_POST["txtTotal"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["txtTotal"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["txtTotal"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["txtTotal"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["txtTotal"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["txtTotal"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon+$_POST["txtTotal"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros+$_POST["txtTotal"], 2, '.', '') : $otros);
	
	    $NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	    $NumNotaVenta = limpiar($_POST["tipodocumento"] == "NOTAVENTA" ? $nronotaventa+1 : $nronotaventa);
	    $NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
		$stmt->execute();
	    ########################## PROCESO LA FORMA DE PAGO #################################
	}
	###################### TIPO DE PAGO CONTADO ######################


	###################### TIPO DE PAGO CREDITO ######################
	if (limpiar($_POST["tipopago"]=="CREDITO")){

		########################## PROCESO LA FORMA DE PAGO #################################
		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ?, "
		." creditos = ?, "
		." nroticket = ?, "
		." nronotaventa = ?, "
		." nrofactura = ? "
		." WHERE "
		." codarqueo = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $txtCredito);
		$stmt->bindParam(11, $NumTicket);
		$stmt->bindParam(12, $NumNotaVenta);
		$stmt->bindParam(13, $NumFactura);
		$stmt->bindParam(14, $codarqueo);

	$txtEfectivo = limpiar($_POST["medioabono"] == "EFECTIVO" ? number_format($efectivo+$_POST["montoabono"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["medioabono"] == "CHEQUE" ? number_format($cheque+$_POST["montoabono"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["medioabono"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montoabono"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["medioabono"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montoabono"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["medioabono"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montoabono"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["medioabono"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montoabono"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["medioabono"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montoabono"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["medioabono"] == "CUPON" ? number_format($cupon+$_POST["montoabono"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["medioabono"] == "OTROS" ? number_format($otros+$_POST["montoabono"], 2, '.', '') : $otros);
	$txtCredito = number_format($credito+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
	
	    $NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	    $NumNotaVenta = limpiar($_POST["tipodocumento"] == "NOTAVENTA" ? $nronotaventa+1 : $nronotaventa);
	    $NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
		$stmt->execute();
	    ########################## PROCESO LA FORMA DE PAGO #################################


	    ########################## SUMO TOTAL A PACIENTE EN CREDITO #################################
	    $sql = "SELECT codpaciente FROM creditosxpacientes WHERE codpaciente = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_POST["codpaciente"]),decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO creditosxpacientes values (null, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codpaciente);
			$stmt->bindParam(2, $montocredito);
			$stmt->bindParam(3, $codsucursal);

			$codpaciente = limpiar(decrypt($_POST["codpaciente"]));
			$montocredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();

		} else { 

			$sql = "UPDATE creditosxpacientes set"
			." montocredito = ? "
			." where "
			." codpaciente = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $montocredito);
			$stmt->bindParam(2, $codpaciente);
			$stmt->bindParam(3, $codsucursal);

			$montocredito = number_format($montoactual+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
			$codpaciente = limpiar(decrypt($_POST["codpaciente"]));
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();
		}
		########################## SUMO TOTAL A PACIENTE EN CREDITO #################################

        ########################## EN CASO DE DAR ABONO DE CREDITO #################################
	    if (limpiar($_POST["montoabono"]!="0.00" && $_POST["montoabono"]!="0" && $_POST["montoabono"]!="")) {

		$query = "INSERT INTO abonoscreditosventas values (null, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $codventa);
		$stmt->bindParam(3, $codpaciente);
		$stmt->bindParam(4, $medioabono);
		$stmt->bindParam(5, $montoabono);
		$stmt->bindParam(6, $fechaabono);
		$stmt->bindParam(7, $codsucursal);

		$codpaciente = limpiar(decrypt($_POST["codpaciente"]));
		$medioabono = limpiar($_POST["medioabono"]);
		$montoabono = limpiar($_POST["montoabono"]);
		$fechaabono = limpiar(date("Y-m-d H:i:s"));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

	    }
	    ########################## EN CASO DE DAR ABONO DE CREDITO #################################

	}
	###################### TIPO DE PAGO CREDITO ######################
	

    echo "<span class='fa fa-check-square-o'></span> LA VENTA HA SIDO COBRADA EN CAJA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a>";

    echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;

}
############################ FUNCION COBRAR VENTA ############################

######################### FUNCION REGISTRAR VENTAS #######################
public function RegistrarVentas()
{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;
		
	} else {
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
        $codarqueo = $row['codarqueo'];
        $codcaja = $row['codcaja'];
	}
	####################### VERIFICO ARQUEO DE CAJA #######################
	
	if(empty($_POST["codespecialista"]) or empty($_POST["codpaciente"]) or empty($_POST["txtTotal"]))
	{
		echo "2";
		exit;
	}
	elseif(empty($_SESSION["CarritoVenta"]) || $_POST["txtTotal"]=="0.00")
	{
		echo "3";
		exit;
		
	}

	####################### SI LA FACTURACION ES A CREDITO #######################
	if($_POST["tipopago"]=="CREDITO"){

		$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));

		if (strtotime($fechavence) < strtotime($fechaactual)) {

			echo "4";
			exit;

		} else if($_POST["montoabono"] >= $_POST["txtTotal"]){

			echo "5";
			exit;
		} 
	}
	####################### SI LA FACTURACION ES A CREDITO #######################

    ############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$v = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($v);$i++){

		if ($v[$i]['busqueda'] == 2) {

			$sql = "SELECT existencia
			FROM productos 
			WHERE codproducto = '".$v[$i]['txtCodigo']."'
			AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			
			$existenciadb = $row['existencia'];
			$cantidad = $v[$i]['cantidad'];

	        if ($cantidad > $existenciadb) 
	        { 
			    echo "6";
			    exit;
		    }
	    }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

	$fecha = date("Y-m-d H:i:s");

	####################################################################################
	#                                                                                  #
	#                     CREO CODIGO DE VENTAS, SERIE Y AUTORIZACION                  #
	#                                                                                  #
	####################################################################################
	
    ####################### OBTENGO DATOS DE SUCURSAL #######################
	$sql = " SELECT 
	codsucursal, 
	nroactividadsucursal,
	inicioticket,
	inicionotaventa, 
	iniciofactura 
	FROM sucursales 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$nroactividad = $row['nroactividadsucursal'];
	$inicioticket = $row['inicioticket'];
	$inicionotaventa = $row['inicionotaventa'];
	$iniciofactura = $row['iniciofactura'];
	$secuencia = "SI";
	####################### OBTENGO DATOS DE SUCURSAL #######################
	
	####################### OBTENGO DATOS DE VENTA #######################
	$sql = "SELECT
	codventa, 
	codfactura 
	FROM ventas 
	WHERE codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'  
	ORDER BY idventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$venta=$row["codventa"];
		$factura=$row["codfactura"];

	}
	####################### OBTENGO DATOS DE VENTA #######################
	
	####################### CREO CODIGO DE VENTA #######################
	if(empty($venta))
	{
		$codventa = "1";
        $codfactura = $nroactividad.'-'.$inicioticket;
		$codserie = $nroactividad;
		$codautorizacion = limpiar(GenerateRandomStringg());

	} else {

		$var = strlen($nroactividad."-");
        $var1 = substr($factura , $var);
        $var2 = strlen($var1);
        $var3 = $var1 + 1;
        $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);

        $codventa = $venta + 1;
        $codfactura = $nroactividad.'-'.$var4;
		$codserie = $nroactividad;
		$codautorizacion = limpiar(GenerateRandomStringg());
	}
	####################### CREO CODIGO DE VENTA #######################

    ####################################################################################
	#                                                                                  #
	#                     CREO CODIGO DE VENTAS, SERIE Y AUTORIZACION                  #
	#                                                                                  #
	####################################################################################

    ################################### REGISTRO LA FACTURA ###################################
    $query = "INSERT INTO ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $tipodocumento);
	$stmt->bindParam(2, $codcaja);
	$stmt->bindParam(3, $codventa);
	$stmt->bindParam(4, $codfactura);
	$stmt->bindParam(5, $codserie);
	$stmt->bindParam(6, $codautorizacion);
	$stmt->bindParam(7, $codpaciente);
	$stmt->bindParam(8, $codespecialista);
	$stmt->bindParam(9, $subtotalivasi);
	$stmt->bindParam(10, $subtotalivano);
	$stmt->bindParam(11, $iva);
	$stmt->bindParam(12, $totaliva);
	$stmt->bindParam(13, $descontado);
	$stmt->bindParam(14, $descuento);
	$stmt->bindParam(15, $totaldescuento);
	$stmt->bindParam(16, $totalpago);
	$stmt->bindParam(17, $totalpago2);
	$stmt->bindParam(18, $tipopago);
	$stmt->bindParam(19, $formapago);
	$stmt->bindParam(20, $montopagado);
	$stmt->bindParam(21, $montodevuelto);
	$stmt->bindParam(22, $creditopagado);
	$stmt->bindParam(23, $fechavencecredito);
	$stmt->bindParam(24, $fechapagado);
	$stmt->bindParam(25, $statusventa);
	$stmt->bindParam(26, $fechaventa);
	$stmt->bindParam(27, $observaciones);
	$stmt->bindParam(28, $codigo);
	$stmt->bindParam(29, $codsucursal);
	$stmt->bindParam(30, $bandera);
	$stmt->bindParam(31, $docelectronico);
   
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	$codpaciente = limpiar($_POST["codpaciente"]);
	$codespecialista = limpiar($_POST["codespecialista"]);
	$subtotalivasi = limpiar($_POST["txtgravado"]);
	$subtotalivano = limpiar($_POST["txtexento"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
	$tipopago = limpiar($_POST["tipopago"]);
	$formapago = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["formapago"] : "CREDITO");
	$montopagado = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["montopagado"] : "0.00");
	$montodevuelto = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["montodevuelto"] : "0.00");
	$creditopagado = limpiar(isset($_POST['montoabono']) ? $_POST['montoabono'] : "0.00");
	$fechavencecredito = limpiar($_POST["tipopago"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
	$fechapagado = limpiar("0000-00-00");
	$statusventa = limpiar($_POST["tipopago"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
    $fechaventa = limpiar($fecha);
    $observaciones = limpiar(isset($_POST['observaciones']) ? $_POST['observaciones'] : "");
	$codigo = limpiar($_SESSION["codigo"]);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$bandera = limpiar("0");
	$docelectronico = limpiar("0");
	$stmt->execute();
	################################### REGISTRO LA FACTURA ###################################

    $this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($detalle);$i++){

	############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################
	if ($detalle[$i]['busqueda'] == 2) {
	$sql = "SELECT 
	existencia 
	FROM 
	productos 
	WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciabd = $row['existencia'];
    }
	############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################

	################################### REGISTRO DETALLES DE VENTAS ###################################
	$query = "INSERT INTO detalle_ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codventa);
    $stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codmarca);
    $stmt->bindParam(6, $codpresentacion);
    $stmt->bindParam(7, $codmedida);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $preciocompra);
	$stmt->bindParam(10, $precioventa);
	$stmt->bindParam(11, $ivaproducto);
	$stmt->bindParam(12, $descproducto);
	$stmt->bindParam(13, $valortotal);
	$stmt->bindParam(14, $totaldescuentov);
	$stmt->bindParam(15, $valorneto);
	$stmt->bindParam(16, $valorneto2);
	$stmt->bindParam(17, $tipodetalle);
	$stmt->bindParam(18, $codsucursal);
		
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codmarca = limpiar($detalle[$i]['codmarca']);
	$codpresentacion = limpiar($detalle[$i]['codpresentacion']);
	$codmedida = limpiar($detalle[$i]['codmedida']);
	$cantidad = limpiar($detalle[$i]['cantidad']);
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
	$tipodetalle = limpiar($detalle[$i]['busqueda']);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################################### REGISTRO DETALLES DE VENTAS ###################################

    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
	$sql = " UPDATE productos set "
		  ." existencia = ? "
		  ." where "
		  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$cantventa = limpiar($detalle[$i]['cantidad']);
	$existencia = isset($existenciabd) ? $existenciabd-$cantventa : "0";
	$stmt->execute();
	##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

	############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###############
    $query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codventa);
	$stmt->bindParam(2, $codpaciente);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);
	$stmt->bindParam(14, $tipokardex);		
	$stmt->bindParam(15, $codsucursal);

	$codpaciente = limpiar($_POST["codpaciente"]);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$movimiento = limpiar("SALIDAS");
	$entradas = limpiar("0");
	$salidas= limpiar($detalle[$i]['cantidad']);
	$devolucion = limpiar("0");
	$stockactual = limpiar(isset($existenciabd) ? $existenciabd-$detalle[$i]['cantidad'] : "0");
	$precio = limpiar($detalle[$i]["precio2"]);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$documento = limpiar("VENTA: ".$codventa);
	$fechakardex = limpiar(date("Y-m-d"));
	$tipokardex = limpiar($detalle[$i]['busqueda']);
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
    }
		
	####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoVenta"]);
    $this->dbh->commit();
    ################################### REGISTRO DETALLES DE FACTURA ###################################

	###################### OBTENGO DATOS DE ARQUEO ######################
	$sql = "SELECT
	arqueocaja.codarqueo,
	arqueocaja.codcaja,
	arqueocaja.efectivo, 
	arqueocaja.cheque, 
	arqueocaja.tcredito, 
	arqueocaja.tdebito, 
	arqueocaja.tprepago, 
	arqueocaja.transferencia, 
	arqueocaja.electronico,
	arqueocaja.cupon, 
	arqueocaja.otros,
	arqueocaja.creditos,
	arqueocaja.nroticket,
	arqueocaja.nronotaventa,
	arqueocaja.nrofactura
	FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE arqueocaja.codarqueo = '".limpiar($codarqueo)."'
	AND arqueocaja.statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$codarqueo = $row['codarqueo'];
	$codcaja = $row['codcaja'];
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
	$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
	$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
	$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
	$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
	$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
	$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
	$otros = ($row['otros']== "" ? "0.00" : $row['otros']);
	$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
	$nroticket = $row['nroticket'];
	$nronotaventa = $row['nronotaventa'];
	$nrofactura = $row['nrofactura'];
	###################### OBTENGO DATOS DE ARQUEO ######################

	###################### TIPO DE PAGO CONTADO ######################
	if (limpiar($_POST["tipopago"]=="CONTADO")){

		########################## PROCESO LA FORMA DE PAGO #################################
		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ?, "
		." nroticket = ?, "
		." nronotaventa = ?, "
		." nrofactura = ? "
		." WHERE "
		." codarqueo = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $NumTicket);
		$stmt->bindParam(11, $NumNotaVenta);
		$stmt->bindParam(12, $NumFactura);
		$stmt->bindParam(13, $codarqueo);

	$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo+$_POST["txtTotal"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque+$_POST["txtTotal"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["txtTotal"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["txtTotal"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["txtTotal"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["txtTotal"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["txtTotal"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon+$_POST["txtTotal"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros+$_POST["txtTotal"], 2, '.', '') : $otros);
	
	    $NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	    $NumNotaVenta = limpiar($_POST["tipodocumento"] == "NOTAVENTA" ? $nronotaventa+1 : $nronotaventa);
	    $NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
		$stmt->execute();
	    ########################## PROCESO LA FORMA DE PAGO #################################
	}
	###################### TIPO DE PAGO CONTADO ######################


	###################### TIPO DE PAGO CREDITO ######################
	if (limpiar($_POST["tipopago"]=="CREDITO")){

		########################## PROCESO LA FORMA DE PAGO #################################
		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ?, "
		." creditos = ?, "
		." nroticket = ?, "
		." nronotaventa = ?, "
		." nrofactura = ? "
		." WHERE "
		." codarqueo = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $txtCredito);
		$stmt->bindParam(11, $NumTicket);
		$stmt->bindParam(12, $NumNotaVenta);
		$stmt->bindParam(13, $NumFactura);
		$stmt->bindParam(14, $codarqueo);

	$txtEfectivo = limpiar($_POST["medioabono"] == "EFECTIVO" ? number_format($efectivo+$_POST["montoabono"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["medioabono"] == "CHEQUE" ? number_format($cheque+$_POST["montoabono"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["medioabono"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montoabono"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["medioabono"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montoabono"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["medioabono"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montoabono"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["medioabono"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montoabono"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["medioabono"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montoabono"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["medioabono"] == "CUPON" ? number_format($cupon+$_POST["montoabono"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["medioabono"] == "OTROS" ? number_format($otros+$_POST["montoabono"], 2, '.', '') : $otros);
	$txtCredito = number_format($credito+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
	
	    $NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	    $NumNotaVenta = limpiar($_POST["tipodocumento"] == "NOTAVENTA" ? $nronotaventa+1 : $nronotaventa);
	    $NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
		$stmt->execute();
	    ########################## PROCESO LA FORMA DE PAGO #################################


	    ########################## SUMO TOTAL A PACIENTE EN CREDITO #################################
	    $sql = "SELECT codpaciente FROM creditosxpacientes WHERE codpaciente = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codpaciente"],decrypt($_POST["codsucursal"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO creditosxpacientes values (null, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codpaciente);
			$stmt->bindParam(2, $montocredito);
			$stmt->bindParam(3, $codsucursal);

			$codpaciente = limpiar($_POST["codpaciente"]);
			$montocredito = number_format($_POST["txtTotal"]-$_POST["montoabono"], 2, '.', '');
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();

		} else { 

			$sql = "UPDATE creditosxpacientes set"
			." montocredito = ? "
			." where "
			." codpaciente = ? AND codsucursal = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $montocredito);
			$stmt->bindParam(2, $codpaciente);
			$stmt->bindParam(3, $codsucursal);

			$montocredito = number_format($montoactual+($_POST["txtTotal"]-$_POST["montoabono"]), 2, '.', '');
			$codpaciente = limpiar($_POST["codpaciente"]);
			$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
			$stmt->execute();
		}
		########################## SUMO TOTAL A PACIENTE EN CREDITO #################################

        ########################## EN CASO DE DAR ABONO DE CREDITO #################################
	    if (limpiar($_POST["montoabono"]!="0.00" && $_POST["montoabono"]!="0" && $_POST["montoabono"]!="")) {

		$query = "INSERT INTO abonoscreditosventas values (null, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $codventa);
		$stmt->bindParam(3, $codpaciente);
		$stmt->bindParam(4, $medioabono);
		$stmt->bindParam(5, $montoabono);
		$stmt->bindParam(6, $fechaabono);
		$stmt->bindParam(7, $codsucursal);

		$codpaciente = limpiar($_POST["codpaciente"]);
		$medioabono = limpiar($_POST["medioabono"]);
		$montoabono = limpiar($_POST["montoabono"]);
		$fechaabono = limpiar(date("Y-m-d H:i:s"));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();

	    }
	    ########################## EN CASO DE DAR ABONO DE CREDITO #################################

	}
	###################### TIPO DE PAGO CREDITO ######################

	echo "<span class='fa fa-check-square-o'></span> LA FACTURACION HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR DOCUMENTO</strong></font color></a>";

	echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
######################### FUNCION REGISTRAR VENTAS #########################

########################## FUNCION LISTAR VENTAS PENDIENTES ################################
public function ListarVentasPendientes()
{
	self::SetNames();

	if($_SESSION["acceso"] == "especialista") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	SUM(detalle_ventas.cantventa) AS sumarticulos,
	GROUP_CONCAT(detalle_ventas.cantventa, ' | ', detalle_ventas.producto, ' | ', if(detalle_ventas.codmarca='','***',marcas.nommarca), ' | ', if(detalle_ventas.codmedida='','***',medidas.nommedida), ' | ', detalle_ventas.precioventa, ' | ', detalle_ventas.valortotal SEPARATOR '<br>') AS detalles  
	FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)

	LEFT JOIN marcas ON detalle_ventas.codmarca = marcas.codmarca
	LEFT JOIN presentaciones ON detalle_ventas.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON detalle_ventas.codmedida = medidas.codmedida

	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	WHERE ventas.codespecialista = '".limpiar($_SESSION["codespecialista"])."'
	AND ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	AND ventas.bandera = 1 
	GROUP BY ventas.codventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;	

	} else {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida,
	SUM(detalle_ventas.cantventa) AS sumarticulos,
	GROUP_CONCAT(detalle_ventas.cantventa, ' | ', detalle_ventas.producto, ' | ', if(detalle_ventas.codmarca='','***',marcas.nommarca), ' | ', if(detalle_ventas.codmedida='','***',medidas.nommedida), ' | ', detalle_ventas.precioventa, ' | ', detalle_ventas.valortotal SEPARATOR '<br>') AS detalles  
	FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)

	LEFT JOIN marcas ON detalle_ventas.codmarca = marcas.codmarca
	LEFT JOIN presentaciones ON detalle_ventas.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON detalle_ventas.codmedida = medidas.codmedida

	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	WHERE ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	AND ventas.bandera = 1 
	GROUP BY ventas.codventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
    }
 } 
############################ FUNCION LISTAR VENTAS PENDIENTES ############################

########################## FUNCION LISTAR VENTAS ################################
public function ListarVentas()
{
	self::SetNames();

if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalle_ventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	INNER JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.bandera = 0  
	GROUP BY ventas.idventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

 } else if ($_SESSION['acceso'] == "paciente") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalle_ventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	INNER JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codpaciente = '".limpiar($_SESSION["codpaciente"])."'
	AND ventas.bandera = 0  
	GROUP BY ventas.idventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

 } else if($_SESSION["acceso"] == "cajero") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalle_ventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	INNER JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codigo = '".limpiar($_SESSION["codigo"])."'
	AND ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	AND ventas.bandera = 0 
	GROUP BY ventas.idventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

  } else if($_SESSION["acceso"] == "especialista") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalle_ventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	INNER JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codespecialista = '".limpiar($_SESSION["codespecialista"])."'
	AND ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	AND ventas.bandera = 0 
	GROUP BY ventas.idventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

  } else {

   $sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	SUM(detalle_ventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	INNER JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda 
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
	WHERE ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	AND ventas.bandera = 0 
	GROUP BY ventas.idventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
############################ FUNCION LISTAR VENTAS ############################

############################ FUNCION ID VENTAS #################################
public function VentasPorId()
	{
	self::SetNames();
	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.nroactividadsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.tlfpaciente,
	pacientes.emailpaciente,
	pacientes.direcacompana,
	pacientes.estadopaciente,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual   
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento 
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
    
    LEFT JOIN
        (SELECT
        codpaciente, montocredito       
        FROM creditosxpacientes 
        WHERE codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."') pag ON pag.codpaciente = pacientes.codpaciente
    
    LEFT JOIN
        (SELECT
        codventa, codpaciente
        FROM abonoscreditosventas 
        WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."') pag2 ON pag2.codpaciente = pacientes.codpaciente

        WHERE ventas.codventa = ? AND ventas.codsucursal = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID VENTAS #################################

########################### FUNCION VER DETALLES VENTAS ##########################
public function VerDetallesVentas()
	{
	self::SetNames();
	$sql = "SELECT
	detalle_ventas.coddetalleventa,
	detalle_ventas.codventa,
	detalle_ventas.idproducto,
	detalle_ventas.codproducto,
	detalle_ventas.producto,
	detalle_ventas.cantventa,
	detalle_ventas.preciocompra,
	detalle_ventas.precioventa,
	detalle_ventas.ivaproducto,
	detalle_ventas.descproducto,
	detalle_ventas.valortotal, 
	detalle_ventas.totaldescuentov,
	detalle_ventas.valorneto,
	detalle_ventas.valorneto2,
	detalle_ventas.tipodetalle,
	detalle_ventas.codsucursal,
	marcas.nommarca,
	presentaciones.nompresentacion,
	medidas.nommedida
	FROM detalle_ventas LEFT JOIN marcas ON detalle_ventas.codmarca = marcas.codmarca
	LEFT JOIN presentaciones ON detalle_ventas.codpresentacion = presentaciones.codpresentacion 
	LEFT JOIN medidas ON detalle_ventas.codmedida = medidas.codmedida
	WHERE detalle_ventas.codventa = ? AND detalle_ventas.codsucursal = ? ORDER BY detalle_ventas.coddetalleventa ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
		return $this->p;
		$this->dbh=null;
}
############################ FUNCION VER DETALLES VENTAS #######################

############################## FUNCION ACTUALIZAR VENTAS #############################
public function ActualizarVentas()
	{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;
		
	} else {
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
        $codarqueo = $row['codarqueo'];
        $codcaja = $row['codcaja'];
	}
	####################### VERIFICO ARQUEO DE CAJA #######################

	if(empty($_POST["codsucursal"]) or empty($_POST["codventa"]) or empty($_POST["tipodocumento"]) or empty($_POST["codespecialista"]) or empty($_POST["codpaciente"]))
	{
		echo "2";
		exit;
	}

	####################### SI LA FACTURACION ES A CREDITO #######################
	if (limpiar(isset($_POST['fechavencecredito']))) {

		$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));

		if (strtotime($fechavence) < strtotime($fechaactual)) {

			echo "3";
			exit;

		} 
	}
	####################### SI LA FACTURACION ES A CREDITO #######################

	####################### VERIFICO QUE NO EXISTAN CANTIDAD IGUAL A CERO #######################
	for($i=0;$i<count($_POST['coddetalleventa']);$i++){  //recorro el array
        if (!empty($_POST['coddetalleventa'][$i])) {

	       if($_POST['cantventa'][$i]==0){

		      echo "4";
		      exit();

	        }
        }
    }
    ####################### VERIFICO QUE NO EXISTAN CANTIDAD IGUAL A CERO #######################

    ############ OBTENGO DETALLE DE VENTA ##############
	$sql = "SELECT
	tipodocumento, 
	iva,
	descuento,
	totalpago,
	tipopago,
	formapago,
	creditopagado
	FROM ventas 
	WHERE codventa = '".limpiar(decrypt($_POST["codventa"]))."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$tipodocumentobd = $row['tipodocumento'];
	$ivabd = $row['iva'];
	$descuentobd = $row['descuento'];
	$totalpagobd = $row['totalpago'];
	$tipopagobd = $row['tipopago'];
	$formapagobd = $row['formapago'];
	$creditopagadobd = $row['creditopagado'];
	############ OBTENGO DETALLE DE VENTA ##############

    $this->dbh->beginTransaction();

    for($i=0;$i<count($_POST['coddetalleventa']);$i++){  //recorro el array
	    if (!empty($_POST['coddetalleventa'][$i])) {

	############ OBTENGO CANTIDAD EN DETALLES ##############
	$sql = "SELECT cantventa FROM detalle_ventas 
	WHERE coddetalleventa = '".limpiar(decrypt($_POST['coddetalleventa'][$i]))."' 
	AND codventa = '".limpiar(decrypt($_POST["codventa"]))."' 
	AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
		
	$cantidadvendido = $row['cantventa'];
	############ OBTENGO CANTIDAD EN DETALLES ##############

		if (decrypt($_POST['tipodetalle'][$i]) == 2) {

		##################### OBTENGO EXISTENCIA POR CODIGO ####################
		$sql = "SELECT existencia 
		FROM productos 
		WHERE codproducto = '".limpiar(decrypt($_POST['codproducto'][$i]))."' 
		AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."'";
	    foreach ($this->dbh->query($sql) as $row)
	    {
		$this->p[] = $row;
	    }
	    $existenciabd = $row['existencia'];
	    $cantventa = $_POST["cantventa"][$i];
	    $cantidadventabd = $_POST["cantidadventabd"][$i];
	    $totalventa = $cantventa - $cantidadventabd;
	    ##################### OBTENGO EXISTENCIA POR CODIGO ####################

	    ##################### EN CASO QUE CANTIDAD VENTA ES MAYOR QUE EXISTENCIA ####################
	    if ($totalventa > $existenciabd) 
        { 
		    echo "5";
		    exit;
	    }
	    ##################### EN CASO QUE CANTIDAD VENTA ES MAYOR QUE EXISTENCIA ####################

	    }

		##################### ACTUALIZAMOS DETALLES DE VENTAS ####################
		$query = "UPDATE detalle_ventas set"
		." cantventa = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." coddetalleventa = ? AND codventa = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantventa);
		$stmt->bindParam(2, $valortotal);
		$stmt->bindParam(3, $totaldescuento);
		$stmt->bindParam(4, $valorneto);
		$stmt->bindParam(5, $valorneto2);
		$stmt->bindParam(6, $coddetalleventa);
		$stmt->bindParam(7, $codventa);
		$stmt->bindParam(8, $codsucursal);

		$cantventa = limpiar($_POST['cantventa'][$i]);
		$preciocompra = limpiar($_POST['preciocompra'][$i]);
		$precioventa = limpiar($_POST['precioventa'][$i]);
		$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
		$descuento = limpiar($_POST['descproducto'][$i]/100);
		$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
		$totaldescuento = number_format($_POST['totaldescuentov'][$i], 2, '.', '');
		$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
		$valorneto2 = number_format($_POST['valorneto2'][$i], 2, '.', '');
		$coddetalleventa = limpiar(decrypt($_POST['coddetalleventa'][$i]));
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
		##################### ACTUALIZAMOS DETALLES DE VENTAS ####################

		if (decrypt($_POST['tipodetalle'][$i]) == 2) {

		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql2 = " UPDATE productos set "
			  ." existencia = ? "
			  ." WHERE "
			  ." codproducto = '".limpiar(decrypt($_POST['codproducto'][$i]))."' 
			  AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
			  ";
	    $stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $existencia);
		$existencia = $existenciabd - $totalventa;
		$stmt->execute();
	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

	    }

		############## ACTUALIZAMOS LOS DATOS EN KARDEX ################
		$sql3 = " UPDATE kardex set "
		      ." salidas = ?, "
		      ." stockactual = ? "
			  ." WHERE "
			  ." codproceso = '".limpiar(decrypt($_POST["codventa"]))."' 
			  AND codproducto = '".limpiar(decrypt($_POST['codproducto'][$i]))."'
			  AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."';
			   ";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->bindParam(1, $salidas);
		$stmt->bindParam(2, $stockactual);

		$stockactual = limpiar(isset($existenciabd) ? $existenciabd - $totalventa : "0");
		$salidas = limpiar($_POST["cantventa"][$i]);
		$stmt->execute();
		############## ACTUALIZAMOS LOS DATOS EN KARDEX ################
		
			
	    }
    }

    $this->dbh->commit();

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
	$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto FROM detalle_ventas WHERE codventa = '".limpiar(decrypt($_POST["codventa"]))."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' AND ivaproducto = 'SI'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
		$this->p[] = $row3;
	}
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
	$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
	############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
	$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto FROM detalle_ventas WHERE codventa = '".limpiar(decrypt($_POST["codventa"]))."' AND codsucursal = '".limpiar(decrypt($_POST["codsucursal"]))."' AND ivaproducto = 'NO'";
	foreach ($this->dbh->query($sql4) as $row4)
	{
		$this->p[] = $row4;
	}
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
	$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

    ############ ACTUALIZO LOS TOTALES EN VENTA ##############
	$sql = " UPDATE ventas SET "
	." tipodocumento = ?, "
	." codpaciente = ?, "
	." codespecialista = ?, "
	." subtotalivasi = ?, "
	." subtotalivano = ?, "
	." totaliva = ?, "
	." descontado = ?, "
	." descuento = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." totalpago2 = ?, "
	." montopagado = ?, "
	." montodevuelto = ?, "
	." fechavencecredito = ?, "
	." statusventa = ?, "
	." observaciones = ? "
	." WHERE "
	." codventa = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $tipodocumento);
	$stmt->bindParam(2, $codpaciente);
	$stmt->bindParam(3, $codespecialista);
	$stmt->bindParam(4, $subtotalivasi);
	$stmt->bindParam(5, $subtotalivano);
	$stmt->bindParam(6, $totaliva);
	$stmt->bindParam(7, $descontado);
	$stmt->bindParam(8, $descuento);
	$stmt->bindParam(9, $totaldescuento);
	$stmt->bindParam(10, $totalpago);
	$stmt->bindParam(11, $totalpago2);
	$stmt->bindParam(12, $montopagado);
	$stmt->bindParam(13, $montodevuelto);
	$stmt->bindParam(14, $fechavencecredito);
	$stmt->bindParam(15, $statusventa);
	$stmt->bindParam(16, $observaciones);
	$stmt->bindParam(17, $codventa);
	$stmt->bindParam(18, $codsucursal);

	$tipodocumento = limpiar($_POST["tipodocumento"]);
	$codpaciente = limpiar($_POST["codpaciente"]);
	$codespecialista = limpiar($_POST["codespecialista"]);
	$iva = $_POST["iva"]/100;
	$totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	$descuento = limpiar($_POST["descuento"]);
    $txtDescuento = $_POST["descuento"]/100;
    $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
    $totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
    $totalpago = number_format($total-$totaldescuento, 2, '.', '');
    $totalpago2 = number_format($subtotalivasi+$subtotalivano, 2, '.', '');
	
	$montopagado = limpiar($tipopagobd=="CONTADO" ? $_POST["montopagado"] : "0.00");
	$montodevuelto = limpiar($tipopagobd=="CONTADO" ? $_POST["montodevuelto"] : "0.00");
	$fechavencecredito = limpiar($tipopagobd=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
	
	$statusventa = limpiar($tipopagobd=="CONTADO" ? "PAGADA" : "PENDIENTE");
	$observaciones = limpiar($_POST["observaciones"]);
	$codventa = limpiar(decrypt($_POST["codventa"]));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
    $tipodocumento = limpiar($_POST["tipodocumento"]);
	$stmt->execute();
	############ ACTUALIZO LOS TOTALES EN VENTA ##############

	###################### OBTENGO DATOS DE ARQUEO ######################
	$sql = "SELECT
	arqueocaja.codarqueo,
	arqueocaja.codcaja,
	arqueocaja.efectivo, 
	arqueocaja.cheque, 
	arqueocaja.tcredito, 
	arqueocaja.tdebito, 
	arqueocaja.tprepago, 
	arqueocaja.transferencia, 
	arqueocaja.electronico,
	arqueocaja.cupon, 
	arqueocaja.otros,
	arqueocaja.creditos,
	arqueocaja.nroticket,
	arqueocaja.nronotaventa,
	arqueocaja.nrofactura
	FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE arqueocaja.codarqueo = '".limpiar($codarqueo)."'
	AND arqueocaja.statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$codarqueo = $row['codarqueo'];
	$codcaja = $row['codcaja'];
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
	$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
	$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
	$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
	$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
	$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
	$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
	$otros = ($row['otros']== "" ? "0.00" : $row['otros']);
	$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
	$nroticket = $row['nroticket'];
	$nronotaventa = $row['nronotaventa'];
	$nrofactura = $row['nrofactura'];
	###################### OBTENGO DATOS DE ARQUEO ######################

	###################### TIPO DE PAGO CONTADO ######################
	if (limpiar($tipopagobd=="CONTADO") && $totalpagobd != $totalpago || $tipodocumentobd != $tipodocumento){

		########################## PROCESO LA FORMA DE PAGO #################################
		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ?, "
		." nroticket = ?, "
		." nronotaventa = ?, "
		." nrofactura = ? "
		." WHERE "
		." codarqueo = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $NumTicket);
		$stmt->bindParam(11, $NumNotaVenta);
		$stmt->bindParam(12, $NumFactura);
		$stmt->bindParam(13, $codarqueo);

	if($formapagobd == "EFECTIVO" && $totalpagobd > $totalpago){
	$txtEfectivo = number_format($efectivo - ($totalpagobd - $totalpago), 2, '.', '');
	} else if($formapagobd == "EFECTIVO" && $totalpagobd < $totalpago){
	$txtEfectivo = number_format($efectivo + ($totalpago - $totalpagobd), 2, '.', '');
	} else {
	$txtEfectivo = number_format($efectivo, 2, '.', '');	
	}

	if($formapagobd == "CHEQUE" && $totalpagobd > $totalpago){
	$txtCheque = number_format($cheque - ($totalpagobd - $totalpago), 2, '.', '');
	} else if($formapagobd == "CHEQUE" && $totalpagobd < $totalpago){
	$txtCheque = number_format($cheque + ($totalpago - $totalpagobd), 2, '.', '');
	} else {
	$txtCheque = number_format($cheque, 2, '.', '');	
	}

	if($formapagobd == "TARJETA DE CREDITO" && $totalpagobd > $totalpago){
	$txtTcredito = number_format($tcredito - ($totalpagobd - $totalpago), 2, '.', '');
	} else if($formapagobd == "TARJETA DE CREDITO" && $totalpagobd < $totalpago){
	$txtTcredito = number_format($tcredito + ($totalpago - $totalpagobd), 2, '.', '');
	} else {
	$txtTcredito = number_format($tcredito, 2, '.', '');	
	}

	if($formapagobd == "TARJETA DE DEBITO" && $totalpagobd > $totalpago){
	$txtTdebito = number_format($tdebito - ($totalpagobd - $totalpago), 2, '.', '');
	} else if($formapagobd == "TARJETA DE DEBITO" && $totalpagobd < $totalpago){
	$txtTdebito = number_format($tdebito + ($totalpago - $totalpagobd), 2, '.', '');
	} else {
	$txtTdebito = number_format($tdebito, 2, '.', '');	
	}

	if($formapagobd == "TARJETA PREPAGO" && $totalpagobd > $totalpago){
	$txtTprepago = number_format($tprepago - ($totalpagobd - $totalpago), 2, '.', '');
	} else if($formapagobd == "TARJETA PREPAGO" && $totalpagobd < $totalpago){
	$txtTprepago = number_format($tprepago + ($totalpago - $totalpagobd), 2, '.', '');
	} else {
	$txtTprepago = number_format($tprepago, 2, '.', '');	
	}

	if($formapagobd == "TRANSFERENCIA" && $totalpagobd > $totalpago){
	$txtTransferencia = number_format($transferencia - ($totalpagobd - $totalpago), 2, '.', '');
	} else if($formapagobd == "TRANSFERENCIA" && $totalpagobd < $totalpago){
	$txtTransferencia = number_format($transferencia + ($totalpago - $totalpagobd), 2, '.', '');
	} else {
	$txtTransferencia = number_format($transferencia, 2, '.', '');	
	}

	if($formapagobd == "DINERO ELECTRONICO" && $totalpagobd > $totalpago){
	$txtElectronico = number_format($electronico - ($totalpagobd - $totalpago), 2, '.', '');
	} else if($formapagobd == "DINERO ELECTRONICO" && $totalpagobd < $totalpago){
	$txtElectronico = number_format($electronico + ($totalpago - $totalpagobd), 2, '.', '');
	} else {
	$txtElectronico = number_format($electronico, 2, '.', '');	
	}

	if($formapagobd == "CUPON" && $totalpagobd > $totalpago){
	$txtCupon = number_format($cupon - ($totalpagobd - $totalpago), 2, '.', '');
	} else if($formapagobd == "CUPON" && $totalpagobd < $totalpago){
	$txtCupon = number_format($cupon + ($totalpago - $totalpagobd), 2, '.', '');
	} else {
	$txtCupon = number_format($cupon, 2, '.', '');	
	}

	if($formapagobd == "OTROS" && $totalpagobd > $totalpago){
	$txtOtros = number_format($otros - ($totalpagobd - $totalpago), 2, '.', '');
	} else if($formapagobd == "OTROS" && $totalpagobd < $totalpago){
	$txtOtros = number_format($otros + ($totalpago - $totalpagobd), 2, '.', '');
	} else {
	$txtOtros = number_format($otros, 2, '.', '');	
	}
	
	    $NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	    $NumNotaVenta = limpiar($_POST["tipodocumento"] == "NOTAVENTA" ? $nronotaventa+1 : $nronotaventa);
	    $NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
		$stmt->execute();
	    ########################## PROCESO LA FORMA DE PAGO #################################
	}
	###################### TIPO DE PAGO CONTADO ######################

	###################### TIPO DE PAGO CREDITO ######################
	if (limpiar($tipopagobd=="CREDITO") && $totalpagobd != $totalpago || $tipodocumentobd != $tipodocumento){

		########################## PROCESO LA FORMA DE PAGO #################################
		$sql = "UPDATE arqueocaja set "
		." creditos = ?, "
		." nroticket = ?, "
		." nronotaventa = ?, "
		." nrofactura = ? "
		." WHERE "
		." codarqueo = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtCredito);
		$stmt->bindParam(2, $NumTicket);
		$stmt->bindParam(3, $NumNotaVenta);
		$stmt->bindParam(4, $NumFactura);
		$stmt->bindParam(5, $codarqueo);

		if($totalpagobd > $totalpago){
			$txtCredito = number_format($credito - ($totalpagobd - $totalpago), 2, '.', '');
		} else if($totalpagobd < $totalpago){
			$txtCredito = number_format($credito + ($totalpago - $totalpagobd), 2, '.', '');
		}
	
	    $NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	    $NumNotaVenta = limpiar($_POST["tipodocumento"] == "NOTAVENTA" ? $nronotaventa+1 : $nronotaventa);
	    $NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
		$stmt->execute();
	    ########################## PROCESO LA FORMA DE PAGO #################################

	    ########################## SUMO TOTAL A PACIENTE EN CREDITO #################################
		$sql = "UPDATE creditosxpacientes set"
		." montocredito = ? "
		." where "
		." codpaciente = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $montocredito);
		$stmt->bindParam(2, $codpaciente);
		$stmt->bindParam(3, $codsucursal);

		$montocredito = number_format($totalpago - $creditopagadobd, 2, '.', '');
		$codpaciente = limpiar($_POST["codpaciente"]);
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
		########################## SUMO TOTAL A PACIENTE EN CREDITO #################################
	}
	###################### TIPO DE PAGO CREDITO ######################

echo "<span class='fa fa-check-square-o'></span> LA FACTURA HA SIDO ACTUALIZADA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
############################# FUNCION ACTUALIZAR VENTAS #########################

########################## FUNCION ELIMINAR DETALLES VENTAS ########################
public function EliminarDetalleVentas()
    {
    self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT * FROM detalle_ventas WHERE codventa = ? AND codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		#################### SELECCIONO DATOS DE VENTA ####################
		$sql = "SELECT 
		codproducto, 
		cantventa, 
		precioventa, 
		ivaproducto, 
		descproducto, 
		tipodetalle 
		FROM detalle_ventas 
		WHERE coddetalleventa = ? 
		AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddetalleventa"]),decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$codproducto = $row['codproducto'];
		$cantidadbd = $row['cantventa'];
		$preciocomprabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		$tipodetallebd = $row['tipodetalle'];
		#################### SELECCIONO DATOS DE VENTA ####################

		########### SELECCIONO EXISTENCIA DE PRODUCTO #############
		if($tipodetallebd == 2){

		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproducto,decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciabd = $row['existencia'];
		########### SELECCIONO EXISTENCIA DE PRODUCTO #############

		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codsucursal);

		$existencia = limpiar($existenciabd + $cantidadbd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
	    }
		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############


	    ########## REGISTRAMOS LOS DATOS ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codpaciente);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $codsucursal);

		$codventa = limpiar(decrypt($_GET["codventa"]));
	    $codpaciente = limpiar(decrypt($_GET["codpaciente"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar(isset($existenciabd) ? $existenciabd - $cantidadbd : "0");
		$precio = limpiar($preciocomprabd);
		$ivaproducto = limpiar($ivaproductobd);
		$descproducto = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION VENTA: ".decrypt($_GET["codventa"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar($tipodetallebd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########## REGISTRAMOS LOS DATOS ELIMINADO EN KARDEX ##########


		########## ELIMINAMOS EL DETALLE EN VENTA ###########
		$sql = "DELETE FROM detalle_ventas WHERE coddetalleventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetalleventa);
		$stmt->bindParam(2,$codsucursal);
		$coddetalleventa = decrypt($_GET["coddetalleventa"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		########## ELIMINAMOS EL DETALLE EN VENTA ###########


	    ############ CONSULTO LOS TOTALES DE VENTA ##############
	    $sql2 = "SELECT iva, descuento FROM ventas WHERE codventa = ? AND codsucursal = ?";
	    $stmt = $this->dbh->prepare($sql2);
	    $stmt->execute(array(decrypt($_GET["codventa"]),decrypt($_GET["codsucursal"])));
	    $num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$iva = $paea[0]["iva"]/100;
	    $descuento = $paea[0]["descuento"]/100;
	    ############ CONSULTO LOS TOTALES DE VENTA ##############

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto FROM detalle_ventas WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto FROM detalle_ventas WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."' AND ivaproducto = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN VENTA ##############
		$sql = " UPDATE ventas SET "
		." subtotalivasi = ?, "
		." subtotalivano = ?, "
		." totaliva = ?, "
		." descontado = ?, "
		." totaldescuento = ?, "
		." totalpago = ?, "
		." totalpago2= ? "
		." WHERE "
		." codventa = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasi);
		$stmt->bindParam(2, $subtotalivano);
		$stmt->bindParam(3, $totaliva);
		$stmt->bindParam(4, $descontado);
		$stmt->bindParam(5, $totaldescuento);
		$stmt->bindParam(6, $totalpago);
		$stmt->bindParam(7, $totalpago2);
		$stmt->bindParam(8, $codventa);
		$stmt->bindParam(9, $codsucursal);

		$totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
		$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	    $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
	    $totaldescuento = number_format($total*$descuento, 2, '.', '');
	    $totalpago = number_format($total-$totaldescuento, 2, '.', '');
	    $totalpago2 = number_format($subtotalivasi+$subtotalivano, 2, '.', '');
		$codventa = limpiar(decrypt($_GET["codventa"]));
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN VENTA ##############

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
###################### FUNCION ELIMINAR DETALLES VENTAS #######################

####################### FUNCION ELIMINAR VENTAS #################################
public function EliminarVentas()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administradorS") {

	$sql = "SELECT  
	codproducto, 
	cantventa, 
	precioventa, 
	ivaproducto, 
	descproducto, 
	tipodetalle FROM detalle_ventas 
	WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' 
	AND codsucursal = '".limpiar(decrypt($_GET["codsucursal"]))."'";

	$array=array();

	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;

		#################### SELECCIONO DATOS DE VENTA ####################
		$codproducto = $row['codproducto'];
		$cantidadbd = $row['cantventa'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		$tipodetallebd = $row['tipodetalle'];
		#################### SELECCIONO DATOS DE VENTA ####################

		if($tipodetallebd == 2){

		########### SELECCIONO EXISTENCIA DE PRODUCTO #############
		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($codproducto,decrypt($_GET["codsucursal"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciabd = $row['existencia'];
		########### SELECCIONO EXISTENCIA DE PRODUCTO #############

		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codsucursal);

		$existencia = limpiar($existenciabd + $cantidadbd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

	    }

	    ########## REGISTRAMOS LOS DATOS ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codpaciente);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		$stmt->bindParam(14, $tipokardex);		
		$stmt->bindParam(15, $codsucursal);

		$codventa = limpiar(decrypt($_GET["codventa"]));
	    $codpaciente = limpiar(decrypt($_GET["codpaciente"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar(isset($existenciabd) ? $existenciabd + $cantidadbd : "0");
		$precio = limpiar($precioventabd);
		$ivaproducto = limpiar($ivaproductobd);
		$descproducto = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION VENTA: ".decrypt($_GET["codventa"]));
		$fechakardex = limpiar(date("Y-m-d"));
		$tipokardex = limpiar($tipodetallebd);
		$codsucursal = limpiar(decrypt($_GET["codsucursal"]));
		$stmt->execute();
		########## REGISTRAMOS LOS DATOS ELIMINADO EN KARDEX ##########

		}

		######################### ELIMINO VENTA #########################
		$sql = "DELETE FROM ventas WHERE codventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$stmt->bindParam(2,$codsucursal);
		$codventa = decrypt($_GET["codventa"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		######################### ELIMINO VENTA #########################

		########## ELIMINAMOS EL DETALLE EN VENTA ###########
		$sql = "DELETE FROM detalle_ventas WHERE codventa = ? AND codsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$stmt->bindParam(2,$codsucursal);
		$codventa = decrypt($_GET["codventa"]);
		$codsucursal = decrypt($_GET["codsucursal"]);
		$stmt->execute();
		########## ELIMINAMOS EL DETALLE EN VENTA ###########

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
######################### FUNCION ELIMINAR VENTAS #################################

###################### FUNCION BUSQUEDA VENTAS POR CAJAS ###########################
public function BuscarVentasxCajas() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.tlfpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista,
	especialistas.especialidad,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_ventas.cantventa) as articulos
    FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codsucursal = ? 
	AND ventas.codcaja = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND ventas.bandera = 0  
	GROUP BY detalle_ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(decrypt($_GET['codcaja'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA VENTAS POR CAJAS ###########################

###################### FUNCION BUSQUEDA VENTAS POR FECHAS ###########################
public function BuscarVentasxFechas() 
{
	self::SetNames();

	if ($_SESSION["acceso"]=="especialista") {

	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.tlfpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_ventas.cantventa) as articulos
    FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codespecialista = ?
	AND ventas.codsucursal = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND ventas.bandera = 0  
	GROUP BY detalle_ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

	} else {

	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.tlfpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_ventas.cantventa) as articulos
    FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codsucursal = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND ventas.bandera = 0  
	GROUP BY detalle_ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
	}
}
###################### FUNCION BUSQUEDA VENTAS POR FECHAS ###########################

###################### FUNCION BUSQUEDA VENTAS POR ESPECIALISTA ###########################
public function BuscarVentasxEspecialista() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.tlfpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_ventas.cantventa) as articulos
    FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codsucursal = ?
	AND ventas.codespecialista = ? 
	AND ventas.bandera = 0 
	GROUP BY detalle_ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['codespecialista']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA VENTAS POR ESPECIALISTA ###########################

###################### FUNCION BUSQUEDA VENTAS POR PACIENTE ###########################
public function BuscarVentasxPaciente() 
{
	self::SetNames();

	if ($_SESSION["acceso"]=="especialista") { 

	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_ventas.cantventa) as articulos
    FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codespecialista = ?
	AND ventas.codsucursal = ?
	AND ventas.codpaciente = ?
	AND ventas.bandera = 0 
	GROUP BY detalle_ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim($_GET['codpaciente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}

	} else { 

	$sql ="SELECT 
	ventas.idventa, 
	ventas.tipodocumento, 
	ventas.codventa, 
	ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.codespecialista,
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.creditopagado,
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,
	ventas.codigo,   
	ventas.codsucursal, 
	ventas.docelectronico,
	sucursales.documsucursal, 
	sucursales.cuitsucursal, 
	sucursales.nomsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	SUM(detalle_ventas.cantventa) as articulos
    FROM (ventas LEFT JOIN detalle_ventas ON detalle_ventas.codventa = ventas.codventa)
	LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda    
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento  
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codsucursal = ?
	AND ventas.codpaciente = ?
	AND ventas.bandera = 0 
	GROUP BY detalle_ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['codpaciente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
	}
}
###################### FUNCION BUSQUEDA VENTAS POR PACIENTE ###########################

###################################### CLASE VENTAS ##################################


































###################################### CLASE CREDITOS ###################################

####################### FUNCION REGISTRAR PAGOS A CREDITOS ##########################
public function RegistrarPago()
	{
	self::SetNames();
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;
		
	} else {
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
        $codarqueo = $row['codarqueo'];
        $codcaja = $row['codcaja'];
	}

    if(empty($_POST["codpaciente"]) or empty($_POST["codventa"]) or empty($_POST["montoabono"]))
	{
		echo "2";
		exit;
	} 
	else if($_POST["montoabono"] > $_POST["totaldebe"])
	{
		echo "3";
		exit;

	} else {

	################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################
	$sql = "SELECT montocredito FROM creditosxpacientes 
	WHERE codpaciente = '".limpiar(decrypt($_POST['codpaciente']))."' 
	AND codsucursal = '".limpiar(decrypt($_POST['codsucursal']))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
    $monto = (empty($row['montocredito']) ? "0.00" : $row['montocredito']);
    ################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################

	################### INGRESOS EL ABONO DEL CREDITO ######################
	$query = "INSERT INTO abonoscreditosventas values (null, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcaja);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $codpaciente);
	$stmt->bindParam(4, $formaabono);
	$stmt->bindParam(5, $montoabono);
	$stmt->bindParam(6, $fechaabono);
	$stmt->bindParam(7, $codsucursal);

	$codventa = limpiar(decrypt($_POST["codventa"]));
	$codpaciente = limpiar(decrypt($_POST["codpaciente"]));
	$formaabono = limpiar($_POST["formaabono"]);
	$montoabono = limpiar($_POST["montoabono"]);
	$fechaabono = limpiar(date("Y-m-d H:i:s"));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute();
	################### INGRESOS EL ABONO DEL CREDITO ######################

    ############# SELECCIONAMOS DATOS DE CAJA ##############
	$sql = "SELECT 
	abonosefectivo,
	abonosotros
	FROM arqueocaja 
	WHERE codcaja = '".limpiar($codcaja)."' 
	AND statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$abonosefectivo = ($row['abonosefectivo']== "" ? "0.00" : $row['abonosefectivo']);
	$abonosotros = ($row['abonosotros']== "" ? "0.00" : $row['abonosotros']);
	############# SELECCIONAMOS DATOS DE CAJA ##############

	############# ACTUALIZAMNOS DATOS DE CAJA ##############
	$sql = "UPDATE arqueocaja set "
	." abonosefectivo = ?, "
	." abonosotros = ? "
	." WHERE "
	." codarqueo = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtOtros);
	$stmt->bindParam(3, $codarqueo);

    $txtEfectivo = limpiar($_POST["formaabono"] == "EFECTIVO" ? number_format($abonosefectivo + $_POST["montoabono"], 2, '.', '') : $abonosefectivo);
    $txtOtros = limpiar($_POST["formaabono"] != "EFECTIVO" ? number_format($abonosotros + $_POST["montoabono"], 2, '.', '') : $abonosotros);
	$stmt->execute();
	############# ACTUALIZAMNOS DATOS DE CAJA ##############

	############## ACTUALIZAMOS EL MONTO DE CREDITO ##################
	$sql = "UPDATE creditosxpacientes set"
	." montocredito = ? "
	." where "
	." codpaciente = ? AND codsucursal = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $montocredito);
	$stmt->bindParam(2, $codpaciente);
	$stmt->bindParam(3, $codsucursal);

    $montocredito = number_format($monto - $_POST["montoabono"], 2, '.', '');
	$codpaciente = limpiar(decrypt($_POST["codpaciente"]));
	$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
	$stmt->execute(); 
    ############## ACTUALIZAMOS EL MONTO DE CREDITO ##################

    ############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
	if($_POST["montoabono"] == $_POST["totaldebe"]) {

		$sql = "UPDATE ventas set "
		." creditopagado = ?, "
		." statusventa = ?, "
		." fechapagado = ? "
		." WHERE "
		." codventa = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $creditopagado);
		$stmt->bindParam(2, $statusventa);
		$stmt->bindParam(3, $fechapagado);
		$stmt->bindParam(4, $codventa);
		$stmt->bindParam(5, $codsucursal);

		$creditopagado = number_format($_POST["totalabono"] + $_POST["montoabono"], 2, '.', '');
		$statusventa = limpiar("PAGADA");
		$fechapagado = limpiar(date("Y-m-d"));
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
	
	} else {

		$sql = "UPDATE ventas set "
		." creditopagado = ? "
		." WHERE "
		." codventa = ? AND codsucursal = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $creditopagado);
		$stmt->bindParam(2, $codventa);
		$stmt->bindParam(3, $codsucursal);

		$creditopagado = number_format($_POST["totalabono"] + $_POST["montoabono"], 2, '.', '');
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$codsucursal = limpiar(decrypt($_POST["codsucursal"]));
		$stmt->execute();
	}
    ############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
		
echo "<span class='fa fa-check-square-o'></span> EL ABONO A LA FACTURA HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETCREDITO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR TICKET</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&codsucursal=".encrypt($codsucursal)."&tipo=".encrypt("TICKETCREDITO")."', '_blank');</script>";
	exit;
   }
}
########################## FUNCION REGISTRAR PAGOS A CREDITOS ####################

###################### FUNCION LISTAR CREDITOS ####################### 
public function ListarCreditos()
{
	self::SetNames();

if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.tipopago ='CREDITO'
	AND ventas.bandera = 0 
	GROUP BY ventas.idventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

 } else if ($_SESSION['acceso'] == "paciente") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codpaciente = '".limpiar($_SESSION["codpaciente"])."'
	AND ventas.tipopago ='CREDITO'
	AND ventas.bandera = 0 
	GROUP BY ventas.idventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

 } else if($_SESSION["acceso"] == "cajero") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
	WHERE ventas.tipopago ='CREDITO'
	AND ventas.codigo = '".limpiar($_SESSION["codigo"])."'
	AND ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	AND ventas.bandera = 0 
	GROUP BY ventas.idventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

  } else if($_SESSION["acceso"] == "especialista") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
	WHERE ventas.tipopago ='CREDITO'
	AND ventas.codespecialista = '".limpiar($_SESSION["codespecialista"])."'
	AND ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	AND ventas.bandera = 0 
	GROUP BY ventas.idventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

  } else {

   $sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
	WHERE ventas.tipopago ='CREDITO' 
	AND ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."'
	AND ventas.bandera = 0  
	GROUP BY ventas.idventa ORDER BY ventas.idventa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
###################### FUNCION LISTAR CREDITOS ####################### 

############################ FUNCION ID CREDITOS #################################
public function CreditosPorId()
{
	self::SetNames();
	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.codpaciente,
	pacientes.documpaciente,
	pacientes.cedpaciente,
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.tlfpaciente,
	pacientes.direcacompana,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento
	WHERE ventas.codventa = ? AND ventas.codsucursal = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"]),decrypt($_GET["codsucursal"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID CREDITOS #################################
	
########################### FUNCION VER DETALLES VENTAS #######################
public function VerDetallesAbonos()
{
	self::SetNames();
	$sql = "SELECT * FROM abonoscreditosventas 
	INNER JOIN ventas ON abonoscreditosventas.codventa = ventas.codventa 
	LEFT JOIN cajas ON abonoscreditosventas.codcaja = cajas.codcaja 
	WHERE abonoscreditosventas.codventa = ? 
	AND abonoscreditosventas.codsucursal = ?";	
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET["codventa"])));
	$stmt->bindValue(2, trim(decrypt($_GET["codsucursal"])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION VER DETALLES VENTAS ###########################

###################### FUNCION BUSQUEDA CREDITOS POR FECHAS ###########################
public function BuscarCreditosxFechas() 
{
	self::SetNames();

	if($_SESSION["acceso"] == "especialista") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codespecialista = ?
	AND ventas.codsucursal = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND ventas.tipopago ='CREDITO'
	AND ventas.bandera = 0
	GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
	} else {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codsucursal = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND ventas.tipopago ='CREDITO'
	AND ventas.bandera = 0
	GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
	}
}
###################### FUNCION BUSQUEDA CREDITOS POR FECHAS ###########################

###################### FUNCION BUSQUEDA CREDITOS POR PACIENTES ###########################
public function BuscarCreditosxPacientes() 
{
	self::SetNames();

	if($_SESSION["acceso"] == "especialista") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codespecialista = ?
	AND ventas.codsucursal = ? 
	AND ventas.codpaciente = ? 
	AND ventas.tipopago ='CREDITO'
	AND ventas.bandera = 0  
	GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim($_GET['codpaciente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
	} else {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad,  
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni,
	usuarios.nombres
	FROM (ventas INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal)
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento 
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo  
	WHERE ventas.codsucursal = ? 
	AND ventas.codpaciente = ? 
	AND ventas.tipopago ='CREDITO'
	AND ventas.bandera = 0  
	GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['codpaciente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
	}
}
###################### FUNCION BUSQUEDA CREDITOS POR PACIENTES ###########################

###################### FUNCION BUSQUEDA CREDITOS POR DETALLES ###########################
public function BuscarCreditosxDetalles() 
{
	self::SetNames();

	if($_SESSION["acceso"] == "especialista") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	especialistas.tpespecialista,
	especialistas.documespecialista,
	especialistas.cedespecialista,
	especialistas.nomespecialista,
	especialistas.tlfespecialista,
	especialistas.direcespecialista, 
	especialistas.especialidad, 
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	documentos4.documento AS documento4,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	provincias3.provincia AS provincia3,
	departamentos3.departamento AS departamento3,
	GROUP_CONCAT(detalle_ventas.cantventa, ' | ', detalle_ventas.producto SEPARATOR '<br>') AS detalles
	FROM (ventas INNER JOIN detalle_ventas ON ventas.codventa = detalle_ventas.codventa) 
	INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento
	LEFT JOIN especialistas ON ventas.codespecialista = especialistas.codespecialista
	LEFT JOIN documentos AS documentos4 ON especialistas.documespecialista = documentos4.coddocumento
	LEFT JOIN provincias AS provincias3 ON especialistas.id_provincia = provincias3.id_provincia 
	LEFT JOIN departamentos AS departamentos3 ON especialistas.id_departamento = departamentos3.id_departamento
	WHERE ventas.codespecialista = ?
	AND ventas.codsucursal = ? 
	AND ventas.codpaciente = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND ventas.tipopago ='CREDITO'
	AND ventas.bandera = 0 
	GROUP BY detalle_ventas.codventa
	ORDER BY ventas.fechaventa DESC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_SESSION['codespecialista']));
	$stmt->bindValue(2, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(3, trim($_GET['codpaciente']));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(5, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
	} else {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.tipodocumento,
	ventas.codventa,
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codpaciente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.observaciones,  
	ventas.codsucursal,
	sucursales.documsucursal,
	sucursales.cuitsucursal,
	sucursales.nomsucursal,
	sucursales.direcsucursal,
	sucursales.correosucursal,
	sucursales.tlfsucursal,
	sucursales.documencargado,
	sucursales.dniencargado,
	sucursales.nomencargado,
	sucursales.tlfencargado,
	sucursales.fechaautorsucursal,
	sucursales.llevacontabilidad,
	sucursales.codmoneda,
	sucursales.codmoneda2,
	tiposmoneda.moneda,
	tiposmoneda.siglas,
	tiposmoneda.simbolo,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda2.siglas AS siglas2,
	tiposmoneda2.simbolo AS simbolo2,
	tiposcambio.codcambio,
	tiposcambio.montocambio,
	pacientes.idpaciente,
	pacientes.documpaciente, 
	pacientes.cedpaciente, 
	CONCAT(pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente)) as nompaciente,
	CONCAT(pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) as apepaciente,
	pacientes.fnacpaciente,
	pacientes.tlfpaciente,
	pacientes.gruposapaciente,
	pacientes.estadopaciente,
	pacientes.ocupacionpaciente,
	pacientes.direcpaciente,
	pacientes.nomacompana,
	pacientes.direcacompana,
	pacientes.tlfacompana,
	documentos.documento,
	documentos2.documento AS documento2, 
	documentos3.documento AS documento3,
	provincias.provincia,
	departamentos.departamento,
	provincias2.provincia AS provincia2,
	departamentos2.departamento AS departamento2,
	GROUP_CONCAT(detalle_ventas.cantventa, ' | ', detalle_ventas.producto SEPARATOR '<br>') AS detalles
	FROM (ventas INNER JOIN detalle_ventas ON ventas.codventa = detalle_ventas.codventa) 
	INNER JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal
	LEFT JOIN documentos ON sucursales.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON sucursales.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON sucursales.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON sucursales.id_departamento = departamentos.id_departamento
	LEFT JOIN tiposmoneda ON sucursales.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON sucursales.codmoneda2 = tiposmoneda2.codmoneda
	LEFT JOIN tiposcambio ON tiposmoneda2.codmoneda = tiposcambio.codmoneda  
	LEFT JOIN pacientes ON ventas.codpaciente = pacientes.codpaciente 
	LEFT JOIN documentos AS documentos3 ON pacientes.documpaciente = documentos3.coddocumento
	LEFT JOIN provincias AS provincias2 ON pacientes.id_provincia = provincias2.id_provincia 
	LEFT JOIN departamentos AS departamentos2 ON pacientes.id_departamento = departamentos2.id_departamento
	WHERE ventas.codsucursal = ? 
	AND ventas.codpaciente = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND ventas.tipopago ='CREDITO'
	AND ventas.bandera = 0 
	GROUP BY detalle_ventas.codventa
	ORDER BY ventas.fechaventa DESC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codsucursal'])));
	$stmt->bindValue(2, trim($_GET['codpaciente']));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(4, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	    }
	}
}
###################### FUNCION BUSQUEDA CREDITOS POR DETALLES ###########################

###################################### CLASE CREDITOS ###################################






























####################################### FUNCION PARA GRAFICOS #######################################

########################## FUNCION GRAFICO POR SUCURSALES ##########################
public function GraficoxSucursal()
{
	self::SetNames();
    $sql = "SELECT 
    sucursales.codsucursal id,
	sucursales.nomsucursal,
    com.sumcompras,
    cot.sumcotizacion,
    ven.sumventas
     FROM
       sucursales
     LEFT JOIN
       ( SELECT
           codsucursal, SUM(totalpagoc) AS sumcompras         
           FROM compras WHERE DATE_FORMAT(fechaemision,'%Y') = '".date("Y")."' GROUP BY codsucursal) com ON com.codsucursal = sucursales.codsucursal  
     LEFT JOIN
       ( SELECT
           codsucursal, SUM(totalpago) AS sumcotizacion
         FROM cotizaciones WHERE DATE_FORMAT(fechacotizacion,'%Y') = '".date("Y")."' GROUP BY codsucursal) cot ON cot.codsucursal = sucursales.codsucursal   
     LEFT JOIN
       ( SELECT
           codsucursal, SUM(totalpago) AS sumventas
         FROM ventas WHERE DATE_FORMAT(fechaventa,'%Y') = '".date("Y")."' GROUP BY codsucursal) ven ON ven.codsucursal = sucursales.codsucursal GROUP BY id";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION GRAFICO POR SUCURSALES ###########################

########################### FUNCION SUMA DE COMPRAS #################################
 public function SumaCompras()
{
	self::SetNames();

	$sql ="SELECT  
	MONTH(fecharecepcion) mes, 
	SUM(totalpagoc) totalmes
	FROM compras 
	WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND YEAR(fecharecepcion) = '".date('Y')."' AND MONTH(fecharecepcion) GROUP BY MONTH(fecharecepcion) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 
 } 
########################### FUNCION SUMA DE COMPRAS #################################

########################### FUNCION SUMA DE COTIZACIONES ############################
public function SumaCotizaciones()
{
	self::SetNames();
	$sql ="SELECT  
	MONTH(fechacotizacion) mes, 
	SUM(totalpago) totalmes
	FROM cotizaciones 
	WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND YEAR(fechacotizacion) = '".date('Y')."' AND MONTH(fechacotizacion) GROUP BY MONTH(fechacotizacion) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
} 
########################### FUNCION SUMA DE COTIZACIONES #############################

########################### FUNCION SUMA DE VENTAS #################################
 public function SumaVentas()
{
	self::SetNames();

	$sql ="SELECT  
	MONTH(fechaventa) mes, 
	SUM(totalpago) totalmes
	FROM ventas 
	WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND YEAR(fechaventa) = '".date('Y')."' AND MONTH(fechaventa) GROUP BY MONTH(fechaventa) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 
 }
########################### FUNCION SUMA DE VENTAS #################################

########################### FUNCION SUMA DE INGRESOS #################################
 public function SumaIngresos()
{
	self::SetNames();
	$sql ="SELECT  
	MONTH(fechaapertura) mesingreso, 
	SUM(dineroefectivo) totalingresos
	FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo
	INNER JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal 
	WHERE sucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	AND YEAR(arqueocaja.fechaapertura) = '".date('Y')."' 
	AND MONTH(arqueocaja.fechaapertura) 
	GROUP BY MONTH(arqueocaja.fechaapertura) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################### FUNCION SUMA DE INGRESOS #################################

########################### FUNCION SUMA DE EGRESOS #################################
 public function SumaEgresos()
{
	self::SetNames();
	$sql ="SELECT  
	MONTH(fechaapertura) mesegreso, 
	SUM(egresos) totalegresos
	FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo
	INNER JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal 
	WHERE sucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
	AND YEAR(arqueocaja.fechaapertura) = '".date('Y')."' 
	AND MONTH(arqueocaja.fechaapertura) 
	GROUP BY MONTH(arqueocaja.fechaapertura) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################### FUNCION SUMA DE EGRESOS #################################

########################### FUNCION PRODUCTOS 5 MAS VENDIDOS ############################
	public function ProductosMasVendidos()
	{
		self::SetNames();

	if ($_SESSION['acceso'] == "administradorG") {

	$sql = "SELECT productos.codproducto, productos.producto, productos.codmarca, detalle_ventas.descproducto, detalle_ventas.precioventa, productos.existencia, marcas.nommarca, ventas.fechaventa, sucursales.cuitsucursal, sucursales.nomsucursal, SUM(detalle_ventas.cantventa) as cantidad FROM (ventas LEFT JOIN detalle_ventas ON ventas.codventa=detalle_ventas.codventa) LEFT JOIN sucursales ON ventas.codsucursal=sucursales.codsucursal LEFT JOIN productos ON detalle_ventas.codproducto=productos.codproducto LEFT JOIN marcas ON marcas.codmarca=productos.codmarca WHERE detalle_ventas.tipodetalle = 2 GROUP BY detalle_ventas.codproducto, detalle_ventas.precioventa, detalle_ventas.descproducto ORDER BY productos.codproducto ASC LIMIT 5";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

     } else {

       $sql = "SELECT 
       productos.codproducto, 
       productos.producto,
       SUM(detalle_ventas.cantventa) as cantidad 
       FROM (ventas LEFT JOIN detalle_ventas ON ventas.codventa = detalle_ventas.codventa) 
       LEFT JOIN sucursales ON ventas.codsucursal = sucursales.codsucursal 
       LEFT JOIN productos ON detalle_ventas.codproducto = productos.codproducto 
       WHERE ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' 
       AND detalle_ventas.tipodetalle = 2 
       AND YEAR(ventas.fechaventa) = '".date('Y')."' 
       GROUP BY productos.codproducto, productos.producto 
       ORDER BY productos.codproducto ASC LIMIT 5";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
   }
}
########################## FUNCION 5 PRODUCTOS MAS VENDIDOS ###########################

########################## FUNCION SUMAR VENTAS POR USUARIOS ##########################
	public function VentasxUsuarios()
	{
		self::SetNames();
     $sql = "SELECT usuarios.codigo, usuarios.nombres, SUM(ventas.totalpago) as total FROM (usuarios INNER JOIN ventas ON usuarios.codigo=ventas.codigo) WHERE ventas.codsucursal = '".limpiar($_SESSION["codsucursal"])."' AND YEAR(ventas.fechaventa) = '".date('Y')."' GROUP BY usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION SUMAR VENTAS POR USUARIOS #########################

#################### FUNCION PARA CONTAR REGISTROS ###################################
public function ContarRegistros()
	{
    self::SetNames();
if($_SESSION['acceso'] == "administradorG") {

$sql = "SELECT
(SELECT COUNT(codsucursal) FROM sucursales) AS sucursales,
(SELECT COUNT(codigo) FROM usuarios) AS usuarios,
(SELECT COUNT(codproducto) FROM productos) AS productos,
(SELECT COUNT(codpaciente) FROM pacientes) AS pacientes,
(SELECT COUNT(codproveedor) FROM proveedores) AS proveedores,
(SELECT COUNT(codproducto) FROM productos WHERE existencia <= stockminimo) AS minimo,
(SELECT COUNT(codproducto) FROM productos WHERE fechaexpiracion != '0000-00-00' AND fechaexpiracion <= '".date("Y-m-d")."') AS vencidos,
(SELECT COUNT(idcompra) FROM compras WHERE tipocompra = 'CREDITO' AND statuscompra = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."') AS creditoscomprasvencidos,
(SELECT COUNT(idventa) FROM ventas WHERE tipopago = 'CREDITO' AND statusventa = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."') AS creditosventasvencidos";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else if($_SESSION['acceso'] == "paciente") {

$sql = "SELECT
(SELECT COUNT(idcita) FROM citas WHERE codpaciente = '".limpiar($_SESSION["codpaciente"])."') AS citas,
(SELECT COUNT(idodontologia) FROM odontologia WHERE codpaciente = '".limpiar($_SESSION["codpaciente"])."') AS odontologia,
(SELECT COUNT(idcotizacion) FROM cotizaciones WHERE codpaciente = '".limpiar($_SESSION["codpaciente"])."') AS cotizaciones,
(SELECT COUNT(idventa) FROM ventas WHERE codpaciente = '".limpiar($_SESSION["codpaciente"])."') AS ventas";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else if($_SESSION['acceso'] == "especialista") {

	$sql = "SELECT
(SELECT COUNT(codpaciente) FROM pacientes) AS pacientes,
(SELECT COUNT(codproducto) FROM productos WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS productos,
(SELECT COUNT(codservicio) FROM servicios WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS servicios,
(SELECT COUNT(idcita) FROM citas WHERE codsucursal = '".limpiar($_SESSION["codespecialista"])."') AS citas,
(SELECT COUNT(idodontologia) FROM odontologia WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS odontologia,
(SELECT COUNT(idcompra) FROM compras WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS compras,
(SELECT COUNT(idcotizacion) FROM cotizaciones WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS cotizaciones,
(SELECT COUNT(idtraspaso) FROM traspasos WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS traspasos,
(SELECT COUNT(idventa) FROM ventas WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS ventas,
(SELECT COUNT(codproducto) FROM productos WHERE existencia <= stockminimo AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS minimo,
(SELECT COUNT(codproducto) FROM productos WHERE fechaexpiracion != '0000-00-00' AND fechaexpiracion <= '".date("Y-m-d")."' AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS vencidos,
(SELECT COUNT(idcompra) FROM compras WHERE tipocompra = 'CREDITO' AND statuscompra = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."' AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS creditoscomprasvencidos,
(SELECT COUNT(idventa) FROM ventas WHERE tipopago = 'CREDITO' AND statusventa = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."' AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS creditosventasvencidos";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

    } else {

$sql = "SELECT
(SELECT COUNT(codigo) FROM usuarios 
LEFT JOIN accesosxsucursales ON usuarios.codigo = accesosxsucursales.codusuario 
LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal 
WHERE accesosxsucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS usuarios,
(SELECT COUNT(codespecialista) FROM especialistas 
LEFT JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario 
LEFT JOIN sucursales ON accesosxsucursales.codsucursal = sucursales.codsucursal 
WHERE accesosxsucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS especialistas,

(SELECT SUM(dineroefectivo) FROM arqueocaja 
INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
INNER JOIN usuarios ON cajas.codigo = usuarios.codigo
INNER JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
WHERE sucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS ingresos,

(SELECT SUM(egresos) FROM arqueocaja 
INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
INNER JOIN usuarios ON cajas.codigo = usuarios.codigo
INNER JOIN sucursales ON cajas.codsucursal = sucursales.codsucursal
WHERE sucursales.codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS egresos,

(SELECT COUNT(codpaciente) FROM pacientes) AS pacientes,
(SELECT COUNT(codproveedor) FROM proveedores) AS proveedores,
(SELECT COUNT(codproducto) FROM productos WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS productos,
(SELECT COUNT(codservicio) FROM servicios WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS servicios,

(SELECT COUNT(idcita) FROM citas WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS citas,
(SELECT COUNT(idcompra) FROM compras WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS compras,
(SELECT COUNT(idcotizacion) FROM cotizaciones WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS cotizaciones,
(SELECT COUNT(idtraspaso) FROM traspasos WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS traspasos,
(SELECT COUNT(idventa) FROM ventas WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS ventas,
(SELECT COUNT(idodontologia) FROM odontologia WHERE codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS odontologia,

(SELECT COUNT(codproducto) FROM productos WHERE existencia <= stockminimo AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS minimo,
(SELECT COUNT(codproducto) FROM productos WHERE fechaexpiracion != '0000-00-00' AND fechaexpiracion <= '".date("Y-m-d")."' AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS vencidos,
(SELECT COUNT(idcompra) FROM compras WHERE tipocompra = 'CREDITO' AND statuscompra = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."' AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS creditoscomprasvencidos,
(SELECT COUNT(idventa) FROM ventas WHERE tipopago = 'CREDITO' AND statusventa = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."' AND codsucursal = '".limpiar($_SESSION["codsucursal"])."') AS creditosventasvencidos";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
##################### FUNCION PARA CONTAR REGISTROS ##################

####################################### FUNCION PARA GRAFICOS #######################################


}
############## TERMINA LA CLASE LOGIN ######################
?>