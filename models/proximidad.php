<div align="center" class="Estilo7">BUSQUEDA POR PROXIMIDAD</div>
<form action="index.php?vista=13" method="post" name="aprox">
    <div align="center"> 
        <input name="texto" type="text" value="" size="40">
        <input type="submit" name="Submit" value="Buscar">
    </div>
    <div align="center">
        <label>

            <span class="Estilo6">SELECCIONE ESPACIO ENTRE PALABRAS</span>
            <select name="validaciones">
                <option value="0" selected>Ninguna palabra</option>
                <option value="1">1 Palabra</option>
                <option value="2">2 Palabras</option>
            </select>
        </label>
    </div>
    <p align="center">		  <span class="Estilo6">
        </span></p>  
</form>
<br>
<table width="700" border="5" cellspacing="0" cellpadding="0">
    <tr>
        <td height="300" align="left" valign="top">
            <?php
            include('motor/busqueda.php');
            $link = new Busqueda();
            if (!isset($_POST['texto'])) {
                echo("Escriba una palabra para buscarla. <br>");
            } else {
                $link->busquedaProximidad($_POST['texto'], $_POST['validaciones']);
            }
            ?> 

        </td>
        <td height="300" align="left" valign="top">
<?php
include('motor/busqueda2.php');
$b = new Busqueda2();
if (!isset($_POST['texto'])) {
    echo("Escriba una palabra para buscarla. <br>");
} else {
    $b->busquedaProximidad($_POST['texto'], $_POST['validaciones']);
}
?> 
        </td>
    </tr>
</table>
