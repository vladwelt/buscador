<?

session_start();
session_unset();
session_destroy();
if(!isset($_SESSION['usuario']))
{
    header("Location: ../index.php?vista=1");
}
?>
