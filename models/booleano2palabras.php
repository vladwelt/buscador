<div align="center" class="Estilo7">BUSQUEDA BOOLEANA </div>
<form action="index.php?vista=11" method="post" name="aprox">
    <div align="center">Palabra 1:
        <input name="texto1" type="text" value="" size="25">
    </div>
    <div align="center">Palabra 2:
        <input name="texto2" type="text" value="" size="25">
    </div>
    <div align="center">
        Ambas palabras (AND):<input name="and_or" type="radio" value="1">
        Al menos una palabra (OR):<input name="and_or" type="radio" value="2">
    </div>
    <div align="center">
        <input type="submit" name="Submit" value="Buscar">
    </div>
</form>
<br>
<table width="700" border="5" cellspacing="0" cellpadding="0">
  <tr>
    <td height="300" align="left" valign="top">
	<?php
		include('motor/busqueda.php');
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

	    include('motor/busqueda2.php');
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
