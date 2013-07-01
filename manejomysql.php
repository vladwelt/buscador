<?php
	$servidorBD = "localhost";
	$usuario = "root";
	$clave = ".ronald";
	$BD = "buscador";
    $enlace = 0;
    $res = 0;	
	
function conectar_bd()
 {
   global $enlace;
   global $servidorBD;
   global $usuario;
   global $clave;
   global $BD;
   $enlace = mysql_connect($servidorBD,$usuario,$clave)
        or die("EXISTIO UN ERROR AL INTENTAR CONECTARSE AL SERVIDOR DE BASE DE DATOS");
   mysql_select_db($BD, $enlace)
        or die("NO SE PUDO SELECCIONAR LA BASE DE DATOS");
   mysql_query("SET NAMES 'utf8'");
 }

function consulta_bd( $sql )
 {
   global $enlace;
   global $res;
   $res = mysql_query( $sql, $enlace )
   		or die( "No se pudo realizar la consulta: ".$sql );
   return $res;
 }

function cuantos_registros_bd( $res )
 {
   $cuantos = mysql_num_rows($res);
   return $cuantos;
 }
function sacar_registro_bd( $res )
 {
   $registro = mysql_fetch_Array($res);
   return $registro;
 }
function desconectar_bd()
 {
   global $enlace;
   mysql_close($enlace); 
 }
 
function verConsulta($sql)
 {
 	global $enlace;
	if ($sql == "") {
		$this->Error = "La consulta SQL no ha sido especificada";
		return 0;
	}
	$resultado = mysql_query($sql,$enlace)
	    or  die("No se pudo realizar la consulta");

	echo ("<table border=1>\n");

	for ($i = 0; $i < mysql_num_fields($resultado); $i++){
		echo "<td><b>".mysql_field_name($resultado, $i)."</b></td>\n";
	 }
	echo "</tr>\n";
	while ($row = mysql_fetch_row($resultado)) {
			echo "<tr> \n";
			for ($i = 0; $i < mysql_num_fields($resultado); $i++){
				echo "<td>".$row[$i]."</td>\n";
			}
			echo "</tr>\n";
	}
}

function ver()
 {
 	global $enlace;
	global $res;
	if ($res == "") {
		$this->Error = "La consulta SQL no ha sido especificada ";
		return 0;
	}

	echo ("<table border=1>\n");
	for ($i = 0; $i < mysql_num_fields($res); $i++){
		echo "<td><b>".mysql_field_name($res, $i)."</b></td>\n";
	 }
	echo "</tr>\n";
	while ($row = mysql_fetch_row($res)) {
			echo "<tr> \n";
			for ($i = 0; $i < mysql_num_fields($res); $i++){
				echo "<td>".$row[$i]."</td>\n";
			}
			echo "</tr>\n";
	}
} 
?>
