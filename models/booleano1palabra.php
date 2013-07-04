
<div align="center">BUSQUEDA BOOLEANA</div>
<form action="index.php?vista=10" method="post" name="aprox">
    <div align="center">

        <input name="texto1" id="texto1" type="text" value="" size="25">
        <input type="submit" name="Submit" value="Buscar">
    </div>
</form>
<br>
<table width="700" border="5" cellspacing="0" cellpadding="0">
    <tr>
        <td height="300" align="left" valign="top">
            <?php
            include('motor/busqueda.php');
            $link = new Busqueda();
            //if(strcmp($texto1,"")==0){
            if (!isset($_POST['texto1'])) {
                echo("El campo donde debe introducir la palabra, no puede ser vacío. <br>");
            } else {
                //$link->busquedaBooleano1palabra($_POST['texto1'],$_POST['texto2'],$_POST['and_or']);
                $link->busquedaBooleano1palabra($_POST['texto1']);
            }
            ?>

        </td>
        <td height="300" align="left" valign="top">
            <?php
            include('motor/busqueda2.php');
            $b = new Busqueda2();
            //if(strcmp($texto1,"")==0){
            if (!isset($_POST['texto1'])) {
                
            } else {
                //$b->busquedaBooleano1palabra($_POST['texto1'],$_POST['texto2'],$_POST['and_or']);
                $b->busquedaBooleano1palabra($_POST['texto1']);
            }
            ?>
        </td>
    </tr>
</table>