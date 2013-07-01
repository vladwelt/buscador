<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>exitoborrar</title>
<style type="text/css">
<!--
.Estilo10 {color: #CCFF00; }
.Estilo11 {color: #000066; }
.Estilo7 {color: #FFFFFF; font-weight: bold; font-size: 24px; }
.Estilo12 {font-size: 18px}
.Estilo13 {color: #FFFFFF; font-weight: bold; font-size: 16px; }
body {
	background-color: #4F96CA;
}
.Estilo14 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
}
.Estilo15 {color: #FFFFFF}
.Estilo6 {color: #000000; font-size: 18px;}
-->
</style>
</head>

<body bgcolor="#CCCCCC">
<?
/*session_name("admin");
session_start();
if(isset($_SESSION['nombre'])){*/
include("basedatos.php"); 
conectar_bd();
$borrardoc=$_POST['borrardoc'];
if(isset($_POST['ELIMINAR']))
{
$sql="DELETE FROM documento WHERE iddocumento='".$borrardoc."'";
$sql1="DELETE FROM documento_has_posteo WHERE iddocumento='".$borrardoc."'";
#$res=mysql_affected_rows(mysql_query($sql,$enlace));
mysql_query($sql,$enlace);

$res=mysql_affected_rows();
if($res==1){
mysql_query($sql1,$enlace);
echo "DOCUMENTO ELIMINADO CON EXITO "; ?>
<font color="#00FFEF"><a href="borrar.php"><font size="7"><strong><font size="4">ATRAS</font></strong></font></a> 

<? }
else{
echo "NO EXISTE ESE DOCUMENTO "; ?>
<a href="borrar.php"><font size="4"><strong>ATRAS</strong></font></a></font> 
<?
}
}

?>
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="300" valign="bottom">
		<tr>
    
		<td height="5" ><div align="right"><a href="administrador.php" class="Estilo6">*Salir </a>&nbsp;</div></td>
	</td>
  </tr>
	</td>
  </tr>
</table>
</body>
</html>
