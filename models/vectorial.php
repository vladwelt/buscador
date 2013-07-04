
<div align="center" class="Estilo7"><br>B&Uacute;SQUEDA VECTORIAL</div>
<form action="index.php?vista=12" method="post" name="aprox">
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
		include_once('motor/busqueda.php');
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

	    include('motor/busqueda2.php');
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