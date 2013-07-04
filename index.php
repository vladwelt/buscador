<!DOCTYPE html>
<? session_start(); ?>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>retrieval</title>
    <link href="css/configuracion.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/common.css" />
    <link rel="stylesheet" type="text/css" href="css/style3_1.css" />
</head>
<body>
    <header>
        <center>SISTEMA BUSCADOR DE INFORMACIÓN</center> 
    </header>
    <nav>
        <ul>
            <li><a href="index.php?vista=1">Inicio</a></li>
            <li><a href="index.php?vista=2">Modelos</a></li>
            <li><a href="index.php?vista=3">Administrar</a></li>
            <?php if($_SESSION['usuario'] === 'admin'){?>
            <li><a href="index.php?vista=4">Subir</a></li>
            <li><a href="index.php?vista=5">Borrar</a></li>
            <?php }?>
            <li><a href="otros/cerrar_session.php">Salir</a></li>
        </ul>
    </nav>
    <section class="main" >
        <?php include('functions/handler_body.php'); ?>
    </section>
    <footer>
        <a href="#"> Copyright &copy; 2013</a>
    </footer>
</body>
</html>
