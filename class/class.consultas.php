<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
require_once("classconexion.php");

class conectorDB extends Db
{
	public function __construct()
    {
        parent::__construct();
    } 	
	
	public function EjecutarSentencia($consulta, $valores = array()){  //funcion principal, ejecuta todas las consultas
		$resultado = false;
		
		if($statement = $this->dbh->prepare($consulta)){  //prepara la consulta
			if(preg_match_all("/(:\w+)/", $consulta, $campo, PREG_PATTERN_ORDER)){ //tomo los nombres de los campos iniciados con :xxxxx
				$campo = array_pop($campo); //inserto en un arreglo
				foreach($campo as $parametro){
					$statement->bindValue($parametro, $valores[substr($parametro,1)]);
				}
			}
			try {
				if (!$statement->execute()) { //si no se ejecuta la consulta...
					print_r($statement->errorInfo()); //imprimir errores
					return false;
				}
				$resultado = $statement->fetchAll(PDO::FETCH_ASSOC); //si es una consulta que devuelve valores los guarda en un arreglo.
				$statement->closeCursor();
			}
			catch(PDOException $e){
				echo "Error de ejecución: \n";
				print_r($e->getMessage());
			}	
		}
		return $resultado;
		$this->dbh = null; //cerramos la conexión
	} /// Termina funcion consultarBD
}/// Termina clase conectorDB

class Json
{
	private $json;
	
	################################ BUSQUEDA DE MEDIDAS ################################
	public function BuscaMedida($filtro){
    $consulta = "SELECT CONCAT(nommedida) as label, codmedida FROM medidas 
    WHERE CONCAT(nommedida) LIKE '%".$filtro."%' ORDER BY codmedida ASC LIMIT 0,20";
			$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE MEDIDAS ################################

    ################################ BUSQUEDA DE PRODUCTOS PARA COMPRAS ################################
	public function BuscaProductoC($filtro){

       if ($_SESSION["acceso"]=="administradorG") {

    $consulta = "SELECT 
    CONCAT(productos.codproducto, ' | ',productos.producto, ' : ',if(productos.codpresentacion='0','***',presentaciones.nompresentacion), ' | MARCA(',marcas.nommarca, ') | MEDIDA(',if(productos.codmedida='0','***',medidas.nommedida), ')') as label, productos.codproducto, productos.producto, productos.codmarca, productos.codpresentacion, productos.codmedida, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioventa, 2) precioventa, productos.existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, productos.fechaelaboracion, productos.fechaexpiracion, marcas.nommarca, presentaciones.nompresentacion, medidas.nommedida FROM productos INNER JOIN marcas ON productos.codmarca = marcas.codmarca LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida WHERE CONCAT(codproducto, '',producto, '',if(productos.codmarca='0','****',marcas.nommarca)) LIKE '%".$filtro."%' GROUP BY codproducto ASC LIMIT 0,15";
    $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

	   } else {

    $consulta = "SELECT 
    CONCAT(productos.codproducto, ' | ',productos.producto, ' : ',if(productos.codpresentacion='0','***',presentaciones.nompresentacion), ' | MARCA(',marcas.nommarca, ') | MEDIDA(',if(productos.codmedida='0','***',medidas.nommedida), ')') as label, productos.codproducto, productos.producto, productos.codmarca, productos.codpresentacion, productos.codmedida, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioventa, 2) precioventa, productos.existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, productos.fechaelaboracion, productos.fechaexpiracion, marcas.nommarca, presentaciones.nompresentacion, medidas.nommedida FROM productos INNER JOIN marcas ON productos.codmarca = marcas.codmarca LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida WHERE CONCAT(codproducto, '',producto, '',if(productos.codmarca='0','****',marcas.nommarca)) LIKE '%".$filtro."%' AND productos.codsucursal= '".strip_tags($_SESSION["codsucursal"])."' GROUP BY codproducto, codsucursal ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

	    }
	}
	################################ BUSQUEDA DE PRODUCTOS PARA COMPRAS ################################


	################################ BUSQUEDA DE PRODUCTOS PARA VENTAS ################################
	public function BuscaProductoV($filtro){

       if ($_SESSION["acceso"]=="administradorG") {

    $consulta = "SELECT 
    CONCAT(productos.codproducto, ' | ',productos.producto, ' : ',if(productos.codpresentacion='0','***',presentaciones.nompresentacion), ' | MARCA(',marcas.nommarca, ') | MEDIDA(',if(productos.codmedida='0','***',medidas.nommedida), ')') as label, productos.idproducto, productos.codproducto, productos.producto, productos.codmarca, productos.codpresentacion, productos.codmedida, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioventa, 2) precioventa, productos.existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, productos.fechaelaboracion, productos.fechaexpiracion, marcas.nommarca, presentaciones.nompresentacion, medidas.nommedida FROM productos INNER JOIN marcas ON productos.codmarca = marcas.codmarca LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida WHERE CONCAT(codproducto, '',producto, '',if(productos.codmarca='0','****',marcas.nommarca)) LIKE '%".$filtro."%' GROUP BY codproducto ASC LIMIT 0,15";
    $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

	   } else {

    $consulta = "SELECT 
    CONCAT(productos.codproducto, ' | ',productos.producto, ' : ',if(productos.codpresentacion='0','***',presentaciones.nompresentacion), ' | MARCA(',marcas.nommarca, ') | MEDIDA(',if(productos.codmedida='0','***',medidas.nommedida), ')') as label, productos.idproducto, productos.codproducto, productos.producto, productos.codmarca, productos.codpresentacion, productos.codmedida, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioventa, 2) precioventa, productos.existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, productos.fechaelaboracion, productos.fechaexpiracion, marcas.nommarca, presentaciones.nompresentacion, medidas.nommedida FROM productos INNER JOIN marcas ON productos.codmarca = marcas.codmarca LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion LEFT JOIN medidas ON productos.codmedida = medidas.codmedida WHERE CONCAT(codproducto, '',producto, '',if(productos.codmarca='0','****',marcas.nommarca)) LIKE '%".$filtro."%' AND productos.codsucursal= '".strip_tags($_SESSION["codsucursal"])."' GROUP BY codproducto, codsucursal ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

	    }
	}
	################################ BUSQUEDA DE PRODUCTOS PARA VENTAS ################################

	################################ BUSQUEDA DE SERVICIOS PARA VENTAS ################################
	public function BuscaServicio($filtro){

    if ($_SESSION["acceso"]=="administradorG") {

    $consulta = "SELECT 
    CONCAT(servicios.codservicio, ' | ',servicios.servicio) as label, servicios.idservicio, servicios.codservicio, servicios.servicio, ROUND(servicios.preciocompra, 2) preciocompra, ROUND(servicios.precioventa, 2) precioventa, servicios.ivaservicio, ROUND(servicios.descservicio, 2) descproducto FROM servicios WHERE CONCAT(codservicio, '',servicio) LIKE '%".$filtro."%' GROUP BY codservicio ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

	} else {

    $consulta = "SELECT 
    CONCAT(servicios.codservicio, ' | ',servicios.servicio) as label, servicios.idservicio, servicios.codservicio, servicios.servicio, ROUND(servicios.preciocompra, 2) preciocompra, ROUND(servicios.precioventa, 2) precioventa, servicios.ivaservicio, ROUND(servicios.descservicio, 2) descproducto FROM servicios WHERE CONCAT(codservicio, '',servicio) LIKE '%".$filtro."%' AND servicios.codsucursal= '".strip_tags($_SESSION["codsucursal"])."' GROUP BY codservicio, codsucursal ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

	    }
	}
	################################ BUSQUEDA DE SERVICIOS PARA VENTAS ################################

	################################ BUSQUEDA DE CIE10 ################################
	public function BuscaCie10($filtro){
		$consulta = "SELECT CONCAT(codcie, ': ', nombrecie) AS label, idcie, codcie, nombrecie FROM cie10 WHERE codcie LIKE '%".$filtro."%' or nombrecie LIKE '%".$filtro."%' ORDER BY codcie ASC LIMIT 0,10";
		$conexion = new conectorDB();
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE CIE10 ################################

	################################ BUSQUEDA DE PACIENTES ################################
	public function BuscaPacientes($filtro){
		$consulta = "SELECT CONCAT(if(pacientes.documpaciente='0','DOCUMENTO',documentos.documento), ' ',cedpaciente, ' : ',pnompaciente, ' ',if(snompaciente='','',snompaciente), ' ',papepaciente, ' ',if(sapepaciente='','',sapepaciente)) as label, codpaciente FROM pacientes LEFT JOIN documentos ON pacientes.documpaciente = documentos.coddocumento WHERE CONCAT(pacientes.cedpaciente, ' ',pacientes.pnompaciente, ' ',if(pacientes.snompaciente='','',pacientes.snompaciente), ' ',pacientes.papepaciente, ' ',if(pacientes.sapepaciente='','',pacientes.sapepaciente)) LIKE '%".$filtro."%' LIMIT 0,10";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE PACIENTES ################################

	################################ BUSQUEDA DE ESPECIALISTAS ################################
	public function BuscaEspecialistas($filtro){

    if ($_SESSION["acceso"]=="administradorG") {

    $consulta = "SELECT CONCAT(especialistas.cedespecialista, ' : ',especialistas.nomespecialista) as label, especialistas.codespecialista FROM especialistas INNER JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario WHERE CONCAT(especialistas.cedespecialista, ' ',especialistas.nomespecialista) LIKE '%".$filtro."%'  LIMIT 0,10";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;

	} else {

		$consulta = "SELECT CONCAT(especialistas.cedespecialista, ' : ',especialistas.nomespecialista) as label, especialistas.codespecialista FROM especialistas INNER JOIN accesosxsucursales ON especialistas.codespecialista = accesosxsucursales.codusuario WHERE CONCAT(especialistas.cedespecialista, ' ',especialistas.nomespecialista) LIKE '%".$filtro."%' AND accesosxsucursales.codsucursal= '".strip_tags($_SESSION["codsucursal"])."' LIMIT 0,10";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	    }
	}
	################################ BUSQUEDA DE ESPECIALISTAS ################################


}/// TERMINA CLASE  ///
?>