<?
include("BD/basedatos.php"); 
conectar_bd();
$sql="select * from documento";
$res=mysql_query($sql,$enlace)or die("error en el SQyreyL");

?>

  <br><br>
<form action="index.php?vista=7" method="post">
<div align="left">
        <font size="3">ID DEL DOCUMENTO:</font>
       
        <input name="borrardoc" type="text">
        <input name="ELIMINAR" type="submit" value="ELIMINAR">
        <div align="right">
        <a href="index.php?vista=3">&nbsp; Regresar</a>
        </div>
</div>
<br>
</form>
  <div align="left">
    <table width="0%">
      <tr>
	    <td width="15%">ID Doc.</td>
            <td width="39%">Título</td>
            <td width="46%">Ubicación</td>
    </tr>
    <? while($reg=mysql_fetch_array($res)){?>
    <tr> 
      <td width="15%"><? echo $reg['idDocumento']."<br>";?></td>
      <td width="39%"><? echo $reg['titulo']."<br>";?> </td>
      <td width="46%"><? echo $reg['ubicacion']."<br>";?></td>
	  
      <? 
}?>
    </tr>
  </table>
</div>
 <? /*}
 else{
echo "NO EXISTE UNA CESION ABIERTA"; }*/ ?>

