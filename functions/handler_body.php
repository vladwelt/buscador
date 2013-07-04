<?php
    if (isset($_GET['vista'])) {
        $vista = $_GET['vista'];
    } else {
        $vista = 1;
    }

    if($vista == 1)
    {
       include_once ('views/home.php');
    }
    else if ($vista == 2){
        include_once ('models/model_selector.html');
    }
    else if ($vista == 3){
        include_once ('administrador.php');
    }
    else if ($vista == 4){
        include_once ('archiver/subir.php');
    }
    else if ($vista == 5){
        include_once ('archiver/borrar.php');
    }
    else if ($vista == 6){
        include_once ('views/home.php');
    }
    else if ($vista == 7){
        include_once ('archiver/exitoborrar.php');
    }
    else if ($vista == 8){
        include_once ('archiver/indexador.php');
    }
    else if ($vista == 9){
        include_once ('models/model_selector_1.html');
    }
    else if ($vista == 10){
        include_once ('models/booleano1palabra.php');
    }
    else if ($vista == 11){
        include_once ('models/booleano2palabras.php');
    }
    else if ($vista == 12){
        include_once ('models/vectorial.php');
    }
    else if ($vista == 13){
        include_once ('models/proximidad.php');
    }
?>