<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>vectorial</title>
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
	<body >
<div align="center" class="Estilo7"><br>B&Uacute;SQUEDA VECTORIAL</div>
<form action="vectorial.php" method="post" name="aprox">
  <div align="center"> 
	        <input name="texto" type="text" value="" size="40">
	        <input type="submit" name="Submit" value="Buscar">
  </div>
	
</form>
<p align="center" class="Estilo3">:</p>
<p>

<table width="700" border="5" cellspacing="0" cellpadding="0">
  <tr>
    <td height="300" align="left" valign="top">
	<?php
		include_once('../motor/busqueda.php');
		$link=new Busqueda();
		if(isset($_POST['texto']))
		{
			$link->busquedavectorial($_POST['texto']);
		}
		else{
			echo("Escriba una palabra para buscarla. <br>");
		}
	?>
	
	</td>
    <td height="300" align="left" valign="top">
	<?php 

	    include('../motor/busqueda2.php');
		$b=new Busqueda2();
		
		if(isset($_POST['texto'])){
			$b->busquedavectorial($_POST['texto']);
		}
		else{
			echo("Escriba una palabra para buscarla. <br>");
		}
		
	?>
	</td>
  </tr>
</table>
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="">
  <tr>
    
		<td height="5" ><div align="right"><a href="../index.html" class="Estilo6">*Salir </a>&nbsp;</div></td>
	</td>
  </tr>
	</td>
  </tr>
</table>
</body>
</html>
