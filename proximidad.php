<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
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

<body>
<div align="center" class="Estilo7">BUSQUEDA POR PROXIMIDAD</div>
<form action="proximidad.php" method="post" name="aprox">
	<tr>
	
		
    <table width="341" border="0" align="center">
      <tr> 
        <td><div align="center"> 
            <input name="texto" type="text" value="" size="40">
            <input type="submit" name="Submit" value="Buscar">
          </div>
    </table>  
  </tr>
	<p>
  <label>
	  <div align="center">
	  <span class="Estilo6">SELECCIONE ESPACIO ENTRE PALABRAS</span>
	    <select name="validaciones">
	      <option value="0" selected>Ninguna palabra</option>
	      <option value="1">1 Palabra</option>
	      <option value="2">2 Palabras</option>
        </select>
  </label>
  <tr>
	  <p align="center">		  <span class="Estilo6">
	    
	    <label></label>
	    </span></p>  
	    </td>
  </tr>
	<tr>  </tr>
</form>
<table width="700" border="5" cellspacing="0" cellpadding="0">
  <tr>
    <td height="300" align="left" valign="top">
<?php 

	include('busqueda.php');
	$link=new Busqueda();
	if(!isset($_POST['texto']))
	{
		echo("Escriba una palabra para buscarla. <br>");
	}
	else{
	$link->busquedaProximidad($_POST['texto'], $_POST['validaciones']);
	}
?> 
	
	</td>
    <td height="300" align="left" valign="top">
<?php 

	include('busqueda2.php');
	$b=new Busqueda2();
	if(!isset($_POST['texto']))
	{
		echo("Escriba una palabra para buscarla. <br>");
	}
	else{
	$b->busquedaProximidad($_POST['texto'], $_POST['validaciones']);
		}
?> 
	</td>
  </tr>
</table>

<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="">
  <tr>
    
		<td height="5" ><div align="right"><a href="index.html" class="Estilo6">*Salir </a>&nbsp;</div></td>
	</td>
  </tr>
	</td>
  </tr>
</table>
</body>
</html>
