<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>borrar</title>
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
include("basedatos.php"); 
conectar_bd();
$sql="select * from documento";
$res=mysql_query($sql,$enlace)or die("error en el SQyreyL");

?>

  <br><br>
<form action="exitoborrar.php" method="post">
<div align="center">
    <table width="50%" border="5" cellpadding="0" cellspacing="0" bordercolor="#006699">
      <tr>
        <td width="48%" height="51"><div align="center"><span class="Estilo6"><font size="3">ID DEL DOCUMENTO:</font></span></div></td>
        <td width="52%"><div align="center"><span class="Estilo1"><font face="Arial, Helvetica, sans-serif">
          <font face="Arial, Helvetica, sans-serif">
            <input name="borrardoc" type="text">
            </font>
          <input name="ELIMINAR" type="submit" value="ELIMINAR">
        </font></span></div></td>
</tr>
</table>
<br>
</div>
</form>
  <p>&nbsp;</p>
  <div align="center">
    <table width="50%" border="1" cellpadding="0" cellspacing="0" bordercolor="#006699" >
      <tr>
	    <td width="15%"><span class="Estilo6">ID Doc. </span></td>
      <td width="39%"><span class="Estilo6">T&iacute;tulo</span></td>
      <td width="46%"><span class="Estilo6">Ubicaci&oacute;n</span></td>
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

<br>
<table width="100%" border="0">
  <tr>
    
		<td height="5" ><div align="right"><a href="administrador.php" class="Estilo6">*Salir </a>&nbsp;</div></td>
	</td>
  </tr>

</table>
 <? /*}
 else{
echo "NO EXISTE UNA CESION ABIERTA"; }*/ ?>

</body>
</html>
