
<?
/*session_name("admin");
session_start();
if(isset($_SESSION['nombre'])){*/
include("BD/basedatos.php"); 
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
<font color="#00FFEF"><a href="index.php?vista=5"><font size="7"><strong><font size="4">ATRAS</font></strong></font></a> 

<? }
else{
echo "NO EXISTE ESE DOCUMENTO "; ?>
<a href="index.php?vista=5"><font size="4"><strong>ATRAS</strong></font></a></font> 
<?
}
}

?>