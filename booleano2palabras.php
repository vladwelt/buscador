<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>booleano2palabras</title>
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
<form action="booleano2palabras.php" method="post" name="aprox">
	<tr>
	
		
    <table width="300" border="0" align="center">
      <tr> 
        <td width="294" height="12"><div align="center" > 
            <span class="Estilo6">Palabra 1:</span>
            <input name="texto1" type="text" value="" size="25">
        </div>
          <span class="Estilo6"><label></label>
          </span>
<tr>
        <td height="10"><div align="center"><span class="Estilo6">Palabra 2:
          <input name="texto2" type="text" value="" size="25">
          </span>
        </div>
          <span class="Estilo6">
          <label></label>      
          </span>
      <tr>
        <td height="29"><div align="right"><span class="Estilo6">Ambas palabras (AND):
          <input name="and_or" type="radio" value="1">
        </span></div>
      <tr>
        <td height="30"><div align="right"><span class="Estilo6">Al menos una palabra (OR):
          <input name="and_or" type="radio" value="2">
        </span></div>      
      <tr>
        <td height="4"><div align="center"><span class="Estilo6">
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
	echo("El campo donde debe introcucir la primera palabra, no puede ser vacío. <br>");
}else{
  $texto1 = $_POST['texto1'];
  $texto2 = $_POST['texto2'];
  $and_or = $_POST['and_or'];

	if(strcmp($texto2,"")==0){
		echo("El campo donde debe introcucir la segunda palabra, no puede ser vacío. <br>");
	}else{
		if($_POST['and_or']==1 || $_POST['and_or']==2){
			//echo "todo marcha bien<br>";
			$link->busquedaBooleano($_POST['texto1'],$_POST['texto2'],$_POST['and_or']);
		}else{
			echo "Debe seleccionar un tipo de búsqueda (AND-OR).";
		}
	}
}
	?>
	
	</td>
    <td height="300" align="left" valign="top">
	<?php 

	    include('busqueda2.php');
		$b=new Busqueda2();
		if(strcmp($_POST['texto1'],"")==0){
	
}else{
	if(strcmp($texto2,"")==0){
		
	}else{
		if($and_or==1 || $and_or==2){
			$b->busquedaBooleano($_POST['texto1'],$_POST['texto2'],$_POST['and_or']);
		}else{
			echo "Debe seleccionar un tipo de búsqueda (AND-OR).";
		}
	}
}
		
	?>
	</td>
  </tr>
</table>




<table width="100%" border="0">
  <tr>
    <tr>
    
		<td height="5" ><div align="right"><a href="index.html" class="Estilo6">*Salir </a>&nbsp;</div></td>
	</td>
  </tr>

</table>
<p align="center">&nbsp;</p>
</body>
</html>
