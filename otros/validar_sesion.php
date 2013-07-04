<?

session_start();

$log = $_POST['usuario'];
$pass = $_POST['contrasena'];
var_dump($log);
$enlace = mysql_connect("localhost", "root", "asdf") or die("ERROR: al conectarse al Servidor de Bases de Datos");
mysql_select_db("buscador", $enlace) or die("ERROR: al seleccionar la Base de Datos");
mysql_query("SET NAMES 'utf8'");

$consulta = "select login, password from administrador where login = '" . $log . "' AND password = '" . $pass . "'";


$resultado = mysql_query($consulta, $enlace) or die("ERROR: al realizar la consulta al servidor");

$numero = mysql_num_rows($resultado);

if ($numero == 1) {
    $_SESSION['usuario'] = $log;
    header("Location: ../index.php");
} else {
    header("Location: ../index.php?vista=3");
}
?>
