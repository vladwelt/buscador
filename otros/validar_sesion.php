<?
	$log = $_POST['usuario'];
	$pass = $_POST['contrasena'];

	$enlace = mysql_connect("localhost","root",".ronald") or die("ERROR: al conectarse al Servidor de Bases de Datos"); 
	mysql_select_db("buscador", $enlace) or die("ERROR: al seleccionar la Base de Datos");
  mysql_query("SET NAMES 'utf8'");

	$consulta = "select login, password from administrador where login = '".$log."' AND password = '".$pass."'";
	

	$resultado = mysql_query($consulta,$enlace) or  die("ERROR: al realizar la consulta al servidor");

	$numero = mysql_num_rows($resultado);
	

	if ( $numero == 1)
	{
		header("Location: administrador.php"); 
	}
	else
	{
		header("Location: index.php"); 
	}
?>

