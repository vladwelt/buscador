<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>booleano1palabra</title>
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
<DIV>
<br>
<div align="center" class="Estilo7">BUSQUEDA BOOLEANA </div>
<form action="booleano1palabra.php" method="post" name="aprox">
	<tr>
	
		
    <table width="300" border="0" align="center">
      <tr> 
        <td width="294" height="12"><div align="center" > 
            <span class="Estilo6">Palabra 1:</span>
            <input name="texto1" id="texto1" type="text" value="" size="25">
        </div>
<tr>
        <td height="4"><div align="center"><span class="Estilo4">
          <input type="submit" name="Submit" value="Buscar">
        </span> </div>
      </table>  
  </tr>
	<p>
  <label>
	  <div align="center">
  </label>
  <tr>
	    </td>
  </tr>
	<tr>  </tr>
</form>
<p align="left">
  
<table width="700" border="5" cellspacing="0" cellpadding="0">
  <tr>
    <td height="300" align="left" valign="top">
	<?php
		include('busqueda.php');
		$link=new Busqueda();
		//if(strcmp($texto1,"")==0){
                if(!isset($_POST['texto1'])){  
	echo("El campo donde debe introducir la palabra, no puede ser vacío. <br>");
}else{
	//$link->busquedaBooleano1palabra($_POST['texto1'],$_POST['texto2'],$_POST['and_or']);
	$link->busquedaBooleano1palabra($_POST['texto1']);
}
	?>
	
	</td>
    <td height="300" align="left" valign="top">
	<?php 

	    include('busqueda2.php');
		$b=new Busqueda2();
		//if(strcmp($texto1,"")==0){
                if(!isset($_POST['texto1'])){  
	
}else{
	//$b->busquedaBooleano1palabra($_POST['texto1'],$_POST['texto2'],$_POST['and_or']);
	$b->busquedaBooleano1palabra($_POST['texto1']);
}
		
	?>
	</td>
  </tr>
</table>
<table width="100%" border="0">
   <tr>
    
		<td height="5" ><div align="right"><a href="index.html" class="Estilo6">*Salir </a>&nbsp;</div></td>
	</td>
  </tr>
</table>
<p align="center">&nbsp;</p>
</body>
</html>
